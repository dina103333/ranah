var datatable;
var store_id = $('.store_id').val();
console.log(store_id)
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
            responsive: true,
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
                url: '/admin/get-store-products-table/'+store_id,
            },
            columns: [
                { data: 'name' },
                { data: 'company.name' },
                { data: 'category.name' },
                { data: 'stores[0].pivot.wholesale_quantity' ,searchable: false ,orderable: false},
                { data: 'stores[0].pivot.unit_quantity',searchable: false ,orderable: false},
                { data: 'wholesale_type' },
                { data: 'item_type' },
                { data: 'stores[0].pivot.reorder_limit',searchable: false,orderable: false },
                { data: 'stores[0].pivot.buy_price' ,searchable: false,orderable: false},
                { data: 'stores[0].pivot.sell_item_price',searchable: false ,orderable: false},
                { data: 'stores[0].pivot.sell_wholesale_price',searchable: false,orderable: false },
                { data: 'stores[0].pivot.production_date',searchable: false ,orderable: false},
                { data: 'stores[0].pivot.expiry_date',searchable: false ,orderable: false},
                { data: 'id' },
            ],
            columnDefs: [
                {
                    targets: -1,
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: 'text-end',
                    render: function (data, type, row) {
                        return `
                            <a class="btn" href='/admin/edit-store-product/${data}/${store_id}' class=" px-3"><i class="fas fa-edit" style="color: #2cc3c0;"></i></a>
                        `;
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

    }


    // Public methods
    return {
        init: function () {
            table = document.querySelector('#kt_roles_table');

            if (!table) {
                return;
            }

            initCustomerList();
            handleSearchDatatable();
            handleFilterDatatable();
            handleResetForm();
        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTRolesList.init();

});

