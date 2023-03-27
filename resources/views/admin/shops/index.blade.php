@extends('admin.layouts.app')
@section('title') انواع المحلات @endsection
@section('list')
    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
        <li class="breadcrumb-item text-muted">
            <a href="{{route('admin.dashboard')}}" class="text-muted text-hover-primary">لوحه التجكم</a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-200 w-5px h-2px"></span>
        </li>
        <li class="breadcrumb-item text-muted">انواع المحلات</li>
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
                            <input type="text" data-kt-customer-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="بحث" />
                        </div>
                    </div>
                    <div class="card-toolbar">
                        <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                            @if(in_array(132,permissions()))
                                <a href="{{route('admin.shops.create')}}" type="button" class="btn btn-primary">اضافه نوع محل</a>
                            @endif
                        </div>
                        <div class="d-flex justify-content-end align-items-center d-none" data-kt-customer-table-toolbar="selected">
                            <div class="fw-bolder me-5">
                            <span class="me-2" data-kt-customer-table-select="selected_count"></span>قيد الاختيار</div>
                            <button type="button" {{in_array(134, permissions()) ?'' : 'disabled'}} class="btn btn-danger delete-all" data-kt-customer-table-select="delete_selected">حذف</button>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    @include('flash-message')
                    <div class="data-content">
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                            <thead>
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="w-10px pe-2">
                                        @if(in_array(134,permissions()))
                                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                            <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_customers_table .form-check-input" value="1" />
                                        </div>
                                        @endif
                                    </th>

                                    <th class="min-w-125px">اسم نوع المجل</th>
                                    <th class="min-w-125px">الحاله</th>
                                    <th class="text-end min-w-70px">الاجراءات</th>
                                </tr>
                            </thead>
                            <tbody class="fw-bold text-gray-600">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection


@section('js')
<script src="/assets/js/custom/apps/shop/list.js"></script>
    <script>
        setTimeout(function() {
            $('.flash').fadeOut('fast');
        }, 3000);
        $(document).ready(function(event) {
            $.ajax({
                type: 'get',
                url: '/admin/user-permission',
                success: function(response) {
                    if ($.inArray(133, response) !== -1) {
                        $('.edit').show();
                    } else {
                        $('.edit').hide();
                    }
                    if ($.inArray(134, response) !== -1) {
                        $('.delete').show();
                    } else {
                        $('.delete').hide();
                    }
                }
            });
        });
    </script>
@endsection

