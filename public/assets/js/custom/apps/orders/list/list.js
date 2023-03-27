var datatable;
$(document).on('click', '.delete', function (e){
    Swal.fire({
            title: 'هل انت متأكد؟',
            text: "لن تتمكن من التراجع عن هذا!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'نعم احذفها!',
            cancelButtonText: 'الغاء',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: $(this).data('url'),
                type: 'POST',
                data: {
                    _method : 'DELETE',
                    _token : $('meta[name="csrf-token"]').attr('content')
                },
                success: function (res) {
                    console.log(res)
                    if (result.value) {
                        Swal.fire({
                            icon: 'success',
                            title: 'تم الحذف',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        const parent = e.target.closest('tr');
                        datatable.row($(parent)).remove().draw();
                    }
                }
            });
        }
    })
});
function confirmOrder(id){
    Swal.fire({
            title: 'هل تريد تأكيد تسليم منتجات الطلب للمندوب ؟',
            text: "لن تتمكن من التراجع عن هذا!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'نعم !',
            cancelButtonText: 'الغاء',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/admin/deliver-order',
                type: 'POST',
                data: {
                    _method : 'POST',
                    _token : $('meta[name="csrf-token"]').attr('content'),
                    id:id
                },
                success: function (res) {
                    console.log(res)
                    if (result.value) {
                        Swal.fire({
                            icon: 'success',
                            title: 'تم تسليم الطلب للمندوب',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        datatable.ajax.reload();
                    }
                }
            });
        }
    })
};
$('.stores').change(function(){
    let store_id = $('.stores :selected').val();
    // $('.drivers').empty();
    $.ajax({
        url: '/admin/store-drivers',
        type: 'get',
        data: {
            _method : 'get',
            _token  :  $('meta[name="csrf-token"]').attr('content'),
            store_id:  store_id
        },
        success: function (res) {
            console.log(res)
            var content = `` ;
            $.each(res,function(key , value){
                content+=`<option value="${value.id}" style="display:none">${value.name}</option>`
            });
            console.log(content)
            $('.drivers').append(content)
        }
    });
});
"use strict";

// Class definition
var KTRolesList = function () {
    // Define shared variables

    var filterMonth;
    var filterPayment;
    var table

    // Private functions
    var initCustomerList = function () {
        // Set date data order
        const tableRows = table.querySelectorAll('tbody tr');

        tableRows.forEach(row => {
            const dateRow = row.querySelectorAll('td');
            const realDate = moment(dateRow[5].innerHTML, "DD MMM YYYY, LT").format(); // select date from 5th column in table
            dateRow[5].setAttribute('data-order', realDate);
        });

        // Init datatable --- more info on datatables: https://datatables.net/manual/
        datatable = $(table).DataTable({
            responsive: false,
            searchDelay: 500,
            processing: true,
            serverSide: true,
            order: [[1, 'desc']],
            stateSave: true,
            select: {
                style: 'os',
                selector: 'td:first-child',
                className: 'row-selected'
            },
            ajax: {
                url: '/admin/get-orders',
            },
            columns: [
                { data: 'id',className: 'text-center',width:'80ox' },
                { data: 'id',className: 'text-center',width:'80ox' },
                { data: 'status',className: 'text-center',width:'80ox' },
                { data: 'type',className: 'text-center',width:'80ox' },
                { data: 'created_date',className: 'text-center',width:'80ox' },
                { data: 'delivered_date',className: 'text-center',width:'80ox' },
                { data: 'store.name' ,className: 'text-center',width:'80ox' },
                { data: 'user.name' ,className: 'text-center',width:'80ox' },
                { data: 'shop.area.name',className: 'text-center',width:'80ox'  },
                { data: 'total',className: 'text-center' ,width:'80ox' },
                { data: 'id' ,className: 'text-center',width:'80ox' },
                { data: 'id',className: 'text-center' ,width:'80ox' },
            ],
            columnDefs: [
                {
                    targets: 0,
                    orderable: false,
                    searchable: false,
                    render: function (data, type, full) {
                        if(full.status != 'في الطريق' && full.status != 'تم التسليم' && full.status != 'تم الالغاء'){
                            return `
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input name="order_id[]" class="form-check-input order" type="checkbox" value="${data}" />
                            </div>`;
                        }else{
                            return `
                            <div class="form-check form-check-sm form-check-custom form-check-solid">

                            </div>`;
                        }

                    }
                },
                {
                    targets: 2,
                    orderable: true,
                    searchable: true,
                    render: function (data) {
                        var color = data == 'معلق' ? 'badge-light-warning' :
                        (data == 'تم الالغاء' ? 'badge-light-danger' : (data == 'في الطريق' ? 'badge-light-info' :
                        (data == 'تم التسليم' ? 'badge-light-success' : 'badge-light-primary')));
                        return `
                            <div class="badge ${color} fw-bolder">
                                ${data}
                            </div>
                        `;
                    }
                },
                {
                    targets: 10,
                    orderable: true,
                    searchable: false,
                    render: function (data,row,full) {
                        if(full.driver != null){
                            return `
                                <span>
                                    ${full.driver.name}
                                </span>
                            `;
                        }else{
                            return ` -- `
                        }

                    }
                },
                {
                    targets: -1,
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: 'text-end',
                    render: function (data, type, row) {
                        var content = `<div class="d-flex">
                                        <a class="btn show" href='/admin/orders/${data}' class=" px-3"><i class="fas fa-eye" style="color: #2cc3c0;"></i></a>`
                        if(row.driver_id != null){
                            if(row.delivered_from_store == true)
                            {
                                content+= `
                                        <button disabled class="btn btn-light" title="تم تسليم منتجات الطلب للمندوب" style="width: 50px;"><i class="fa fa-check-circle" style="color:#33d933;"></i></button>
                                `;
                            }else{
                                content+= `
                                        <button onclick="confirmOrder(${data})" class="btn btn-light deliver" title=" تسليم منتجات الطلب للمندوب" style="width: 50px;"><i class="fa fa-check-circle" style="color:#f4ef10;"></i></button>
                                `;
                            }
                        }
                        content += `</div>`
                        return content;
                    },
                },
            ],
            // Add data-filter attribute
            createdRow: function (row, data, dataIndex) {
                $(row).find('td:eq(4)').attr('data-filter', data.CreditCardType);
            }

        });

        // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
        datatable.on('draw', function () {
            initToggleToolbar();
            handleDeleteRows();
            toggleToolbars();
        });
    }

    // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
    var handleSearchDatatable = () => {
        const filterSearch = document.querySelector('[data-kt-role-table-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            datatable.search(e.target.value).draw();
        });
    }

    // Filter Datatable
    var handleFilterDatatable = () => {
        // Select filter options
        filterMonth = $('[data-kt-role-table-filter="month"]');
        filterPayment = document.querySelectorAll('[data-kt-role-table-filter="payment_type"] [name="payment_type"]');
        const filterButton = document.querySelector('[data-kt-role-table-filter="filter"]');

        // Filter datatable on submit
        filterButton.addEventListener('click', function () {
            // Get filter values
            const monthValue = filterMonth.val();
            let paymentValue = '';

            // Get payment value
            filterPayment.forEach(r => {
                if (r.checked) {
                    paymentValue = r.value;
                }

                // Reset payment value if "All" is selected
                if (paymentValue === 'all') {
                    paymentValue = '';
                }
            });

            // Build filter string from filter options
            const filterString = monthValue + ' ' + paymentValue;

            // Filter datatable --- official docs reference: https://datatables.net/reference/api/search()
            datatable.search(filterString).draw();
        });
    }

    // Delete customer
    var handleDeleteRows = () => {
        // Select all delete buttons
        const deleteButtons = table.querySelectorAll('[data-kt-role-table-filter="delete_row"]');

        deleteButtons.forEach(d => {
            // Delete button on click
            d.addEventListener('click', function (e) {
                e.preventDefault();

                // Select parent row
                const parent = e.target.closest('tr');

                // Get customer name
                const customerName = parent.querySelectorAll('td')[1].innerText;
                $('#exampleModal').modal('show')

            })
        });
    }

    // Reset Filter
    var handleResetForm = () => {
        // Select reset button
        const resetButton = document.querySelector('[data-kt-role-table-filter="reset"]');

        // Reset datatable
        resetButton.addEventListener('click', function () {
            // Reset month
            filterMonth.val(null).trigger('change');

            // Reset payment type
            filterPayment[0].checked = true;

            // Reset datatable --- official docs reference: https://datatables.net/reference/api/search()
            datatable.search('').draw();
        });
    }

    // Init toggle toolbar
    var initToggleToolbar = () => {
        // Toggle selected action toolbar
        // Select all checkboxes
        const checkboxes = table.querySelectorAll('[type="checkbox"]');

        // Select elements
        const deleteSelected = document.querySelector('[data-kt-role-table-select="delete_selected"]');

        // Toggle delete selected toolbar
        checkboxes.forEach(c => {
            // Checkbox on click event
            c.addEventListener('click', function () {
                setTimeout(function () {
                    toggleToolbars();
                }, 50);
            });
        });

        // Deleted selected rows
        deleteSelected.addEventListener('click', function () {
            $('#exampleModal').modal('show')

        });
    }

    // Toggle toolbars
    const toggleToolbars = () => {
        // Define variables
        const toolbarBase = document.querySelector('[data-kt-role-table-toolbar="base"]');
        const toolbarSelected = document.querySelector('[data-kt-role-table-toolbar="selected"]');
        const selectedCount = document.querySelector('[data-kt-role-table-select="selected_count"]');

        // Select refreshed checkbox DOM elements
        const allCheckboxes = table.querySelectorAll('tbody [type="checkbox"]');

        // Detect checkboxes state & count
        let checkedState = false;
        let count = 0;

        // Count checked boxes
        allCheckboxes.forEach(c => {
            if (c.checked) {
                checkedState = true;
                count++;
            }
        });

        // Toggle toolbars
        if (checkedState) {
            selectedCount.innerHTML = count;
            toolbarBase.classList.add('d-none');
            toolbarSelected.classList.remove('d-none');
        } else {
            toolbarBase.classList.remove('d-none');
            toolbarSelected.classList.add('d-none');
        }
    }

    // Public methods
    return {
        init: function () {
            table = document.querySelector('#kt_role_table');

            if (!table) {
                return;
            }

            initCustomerList();
            initToggleToolbar();
            handleSearchDatatable();
            handleFilterDatatable();
            handleDeleteRows();
            handleResetForm();
        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTRolesList.init();

});

