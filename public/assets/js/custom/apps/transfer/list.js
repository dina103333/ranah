var datatable;
let store_id = $('.store').val();
function change_status(transfer_id){
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
                url: '/admin/change-transfers',
                type: 'POST',
                data: {
                    _method : 'POST',
                    _token : $('meta[name="csrf-token"]').attr('content'),
                    transfer_id : transfer_id,
                    store_id    : store_id,
                },
                success: function (res) {
                    if (result.value) {
                        Swal.fire({
                            icon: 'success',
                            title: 'تم التأكيد',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                    datatable.ajax.reload();
                }
            });
        }
    })
};

function show_modal(transfer_id){
    $.ajax({
        url: '/admin/transfer-products',
        type: 'GET',
        data: {
            _method : 'GET',
            _token : $('meta[name="csrf-token"]').attr('content'),
            transfer_id : transfer_id,
        },
        success: function (res) {
            let content = ``;
            $.each(res, function (key, val) {
                content+= `
                    <tr>
                        <th class="text-center">${val.id}</th>
                        <th class="text-center">${val.name} </th>
                        <th class="text-center"> ${val.transfers[0].pivot.wholesale_quantity} ${val.wholesale_type}</th>
                    </tr
                `
            });
            $('#mytable').html(' ').append(content);
            $('#myModal').modal('show');
        }
    });
}


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
                url: '/admin/get-transfers/'+store_id,
                dataType: 'json',
            },
            columns: [
                { data: 'id',className: 'text-center'},
                { data: 'id' },
                { data: 'id' },
                { data: 'id' },
            ],
            columnDefs: [
                {
                    targets: 1,
                    orderable: false,
                    searchable: false,
                    render: function (data,row,full) {
                        return `
                            <div class=" align-items-center text-center">
                            <span>${full.stores[0].name}</span>
                            </div>
                        `;
                        }

                },
                {
                    targets: 2,
                    orderable: false,
                    searchable: false,
                    render: function (data,row,full) {
                        if(full.arrived_to_store == true){
                            return `
                            <div class=" align-items-center text-center">
                              تم الاستلام
                        </div>
                        `;
                        }else{
                            return `
                            <div class=" align-items-center text-center">
                                لم يتم الاستلام
                            </div>
                    `;
                        }

                    }
                },
                {
                    targets: -1,
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                    render: function (data,row,full) {

                        return `
                            <button class="btn" onClick="show_modal(${data})" class=" px-3"><i class="fas fa-eye"></i></button>
                            <button onClick="change_status(${data})"
                                class="btn btn-light"><i class="fa fa-check-circle" style="color:#33d933;"></i>
                            </button>
                        `;
                    },
                },
            ],
            // Add data-filter attribute
            createdRow: function (row, data, dataIndex) {
                $(row).find('td:eq(4)').attr('data-filter', data.CreditCardType);
            }
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
        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTRolesList.init();

});

