@extends('admin.layouts.app')
@section('title') العملاء @endsection
@section('list')
    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
        <li class="breadcrumb-item text-muted">
            <a href="{{route('admin.dashboard')}}" class="text-muted text-hover-primary">لوحه التجكم</a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-200 w-5px h-2px"></span>
        </li>
        <li class="breadcrumb-item text-muted">العملاء</li>
    </ul>
@endsection
@section('content')

    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            <div class="card">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <div class="d-flex align-items-center position-relative my-1">
                            <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
                                    <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black" />
                                </svg>
                            </span>
                            <input type="text" data-kt-role-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="بحث" />
                        </div>
                    </div>
                    <div class="card-toolbar">
                        <div class="d-flex justify-content-end" data-kt-role-table-toolbar="base">

                            {{-- <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal" data-bs-target="#kt_customers_export_modal">
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <rect opacity="0.3" x="12.75" y="4.25" width="12" height="2" rx="1" transform="rotate(90 12.75 4.25)" fill="black" />
                                        <path d="M12.0573 6.11875L13.5203 7.87435C13.9121 8.34457 14.6232 8.37683 15.056 7.94401C15.4457 7.5543 15.4641 6.92836 15.0979 6.51643L12.4974 3.59084C12.0996 3.14332 11.4004 3.14332 11.0026 3.59084L8.40206 6.51643C8.0359 6.92836 8.0543 7.5543 8.44401 7.94401C8.87683 8.37683 9.58785 8.34458 9.9797 7.87435L11.4427 6.11875C11.6026 5.92684 11.8974 5.92684 12.0573 6.11875Z" fill="black" />
                                        <path d="M18.75 8.25H17.75C17.1977 8.25 16.75 8.69772 16.75 9.25C16.75 9.80228 17.1977 10.25 17.75 10.25C18.3023 10.25 18.75 10.6977 18.75 11.25V18.25C18.75 18.8023 18.3023 19.25 17.75 19.25H5.75C5.19772 19.25 4.75 18.8023 4.75 18.25V11.25C4.75 10.6977 5.19771 10.25 5.75 10.25C6.30229 10.25 6.75 9.80228 6.75 9.25C6.75 8.69772 6.30229 8.25 5.75 8.25H4.75C3.64543 8.25 2.75 9.14543 2.75 10.25V19.25C2.75 20.3546 3.64543 21.25 4.75 21.25H18.75C19.8546 21.25 20.75 20.3546 20.75 19.25V10.25C20.75 9.14543 19.8546 8.25 18.75 8.25Z" fill="#C4C4C4" />
                                    </svg>
                                </span>
                                Export
                            </button> --}}
                            @if(in_array(98,permissions()))
                                <a href="{{route('admin.users.create')}}" type="button" class="btn btn-primary">اضافه مستخدم</a>
                            @endif
                        </div>
                        <div class="d-flex justify-content-end align-items-center d-none" data-kt-role-table-toolbar="selected">
                            <div class="fw-bolder me-5">
                            <span class="me-2" data-kt-role-table-select="selected_count"></span>قيد الاختيار</div>
                            <button type="button" {{in_array(101, permissions()) ?'' : 'disabled'}} class="btn btn-danger delete-all" data-kt-customer-table-select="delete_selected">حذف</button>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    @include('flash-message')
                    <div class="data-content">
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_role_table">
                            <thead>
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="w-10px pe-2">
                                        @if(in_array(101,permissions()))
                                            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                                <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_role_table .form-check-input" value="1" />
                                            </div>
                                        @endif
                                    </th>
                                    <th class="text-center w-90px">اسم العميل</th>
                                    <th class="text-center w-90px">رقم الهاتف</th>
                                    <th class="text-center w-90px">اسم المحل</th>
                                    <th class="text-center w-90px">المنطقه</th>
                                    <th class="text-center w-90px">نوع المستخدم</th>
                                    <th class="text-center w-90px">الحاله</th>
                                    <th class="text-center w-90px">تفعيل / حظر</th>
                                    <th class="text-center w-90px">الاجراءات</th>
                                </tr>
                            </thead>
                            <tbody class="fw-bold text-gray-600">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
                <!-- Modal -->
            <div class="modal fade points" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="">
                <div class="modal-dialog">
                    <div class="modal-content poits_content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">نقاط العميل</h5>
                            <button type="button" class="close" onclick="hideModele()" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body model-points">

                        </div>
                        <div class="modal-footer">
                            @if(in_array(212,permissions()))
                                <button type="button" class="btn btn-success" onclick="deletePoints()">تم تسليم الهديه</button>
                            @endif
                            <button type="button" class="btn btn-danger" onclick="hideModele()">اغلاق</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('js')
<script src="/assets/js/custom/apps/users/list/list.js"></script>
    <script>
        setTimeout(function() {
            $('.flash').fadeOut('fast');
        }, 3000);
        $(document).ready(function(event) {
            $.ajax({
                type: 'get',
                url: '/admin/user-permission',
                success: function(response) {
                    if ($.inArray(192, response) !== -1) {
                        $('.edit').show();
                    } else {
                        $('.edit').hide();
                    }
                    if ($.inArray(100, response) !== -1) {
                        $('.delete').show();
                    } else {
                        $('.delete').hide();
                    }
                    if ($.inArray(209, response) !== -1) {
                        $('.wallet').show();
                    } else {
                        $('.wallet').hide();
                    }
                    if ($.inArray(211, response) !== -1) {
                        $('.points').show();
                    } else {
                        $('.points').hide();
                    }
                }
            });
        });
        function hideModele(){
            $('.points').modal('hide');
        }

        function deletePoints(){
            let user_id = $('.user_id').val();
            $.ajax({
                url: '/admin/delete-points',
                type: 'POST',
                data: {
                    _method : 'POST',
                    _token  :  $('meta[name="csrf-token"]').attr('content'),
                    user_id:user_id
                },
                success: function (res) {
                    $('.points').modal('hide')
                    Swal.fire({
                        icon: 'success',
                        title: 'تم تسليم الهديه للعميل',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    datatable.ajax.reload();
                }
            });
        }
    </script>
@endsection

