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
$(document).on('click', '.approve', function (e){
    Swal.fire({
            title: 'هل انت متأكد؟',
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
                url: $(this).data('url'),
                type: 'GET',
                data: {
                    _method : 'GET',
                    _token : $('meta[name="csrf-token"]').attr('content')
                },
                success: function (res) {
                    if (result.value) {
                        Swal.fire({
                            icon: 'success',
                            title: 'تم التسليم',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        datatable.ajax.reload();
                    }
                }
            });
        }
    })
});
"use strict";

// Class definition
var KTRolesList = function () {
    // Define shared variables

    var filterMonth;
    var filterPayment;
    var table
    let content = ``;

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
            // responsive: true,
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
                url: '/admin/get-receipts',
            },
            columns: [
                { data: 'id' },
                { data: 'store.name' },
                { data: 'supplier.name' },
                { data: 'total' },
                { data: 'keeper.name' },
                { data: 'created_at' },
                { data: 'is_received' },
                { data: 'id' },
            ],
            columnDefs: [
                {
                    targets: 0,
                    orderable: false,
                    searchable: false,
                    render: function (data) {
                        return `
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="${data}" />
                            </div>`;
                    }
                },
                {
                    targets: 6,
                    orderable: false,
                    searchable: false,
                    render: function (data) {
                        let content
                        if(data == false){
                            content = ` <span>لم يتم الاستلام</span>`
                        }else{
                            content = ` <span>تم الاستلام من جهه امين المخزن</span>`
                        }
                        return content;
                    }
                },
                {
                    targets: -1,
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: 'text-end',
                    render: function (data, type, row) {
                        if(row.is_received == false){
                            content= `
                                <div class="d-flex">
                                    <a class="btn edit" href='/admin/receipts/${data}/edit' class=" px-3"><i class="fas fa-edit" style="color: #2cc3c0;"></i></a>
                                    <button  data-url='/admin/receipts/${data}'
                                        class="btn px-3 delete"><i class="fas fa-trash-alt" style="color:red"></i>
                                    </button>
                                </div>
                                <div class="d-flex">
                                    <a class="btn" href='/admin/receipts/${data}/edit' class=" px-3"><i class="fas fa-eye"></i></a>
                                    <button  data-url='/admin/receive-receipts/${data}'
                                        class="btn px-3 approve"><i class="fas fa-check" style="color:green"></i>
                                    </button>
                                </div>
                            `
                        }else{
                            content= `
                            <div class="d-flex">
                                <a class="btn" href='/admin/receipts/${data}' class=" px-3"><i class="fas fa-eye"></i></a>
                            </div>
                            `
                        }
                        return content
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
        console.log('sdffd');
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

                // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
                Swal.fire({
                    text: "Are you sure you want to delete " + customerName + "?",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "Yes, delete!",
                    cancelButtonText: "No, cancel",
                    customClass: {
                        confirmButton: "btn fw-bold btn-danger",
                        cancelButton: "btn fw-bold btn-active-light-primary"
                    }
                }).then(function (result) {
                    if (result.value) {
                        Swal.fire({
                            text: "You have deleted " + customerName + "!.",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary",
                            }
                        }).then(function () {
                            // Remove current row
                            datatable.row($(parent)).remove().draw();
                        });
                    } else if (result.dismiss === 'cancel') {
                        Swal.fire({
                            text: customerName + " was not deleted.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary",
                            }
                        });
                    }
                });
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
            // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
            Swal.fire({
                text: "Are you sure you want to delete selected customers?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, delete!",
                cancelButtonText: "No, cancel",
                customClass: {
                    confirmButton: "btn fw-bold btn-danger",
                    cancelButton: "btn fw-bold btn-active-light-primary"
                }
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        url: $(this).data('url'),
                        type: 'POST',
                        data: {
                            _method : 'DELETE',
                            _token : $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (res) {
                            Swal.fire({
                                text: "You have deleted all selected customers!.",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary",
                                }
                            }).then(function () {

                                // Remove all selected customers
                                checkboxes.forEach(c => {
                                    if (c.checked) {
                                        datatable.row($(c.closest('tbody tr'))).remove().draw();
                                    }
                                });

                                // Remove header checked box
                                const headerCheckbox = table.querySelectorAll('[type="checkbox"]')[0];
                                headerCheckbox.checked = false;


                            });
                        }})
                } else if (result.dismiss === 'cancel') {
                    Swal.fire({
                        text: "Selected customers was not deleted.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary",
                        }
                    });
                }
            });
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
            table = document.querySelector('#kt_roles_table');

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

