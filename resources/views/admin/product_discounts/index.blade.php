@extends('admin.layouts.app')
@section('title') الخصومات @endsection
@section('list')
    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
        <li class="breadcrumb-item text-muted">
            <a href="{{route('admin.dashboard')}}" class="text-muted text-hover-primary">لوحه التجكم</a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-200 w-5px h-2px"></span>
        </li>
        <li class="breadcrumb-item text-muted">الخصومات</li>
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
                            <button data-url="{{route('admin.convert-discounts')}}" class="btn btn-light-primary me-3 discount_hold">تفعيل الخصومات المؤجله</button>
                            <a href="{{route('admin.discountproducts.create')}}" type="button" class="btn btn-primary">اضافه خصم</a>
                        </div>
                        <div class="d-flex justify-content-end align-items-center d-none" data-kt-role-table-toolbar="selected">
                            <div class="fw-bolder me-5">
                            <span class="me-2" data-kt-role-table-select="selected_count"></span>قيد الاختيار</div>
                            {{-- <button type="button" class="btn btn-danger" data-kt-role-table-select="delete_selected">حذف</button> --}}
                            <button type="button" class="btn btn-danger delete-all" data-kt-customer-table-select="delete_selected">حذف</button>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    @include('flash-message')
                    <div class="data-content">
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_roles_table">
                            <thead>
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="w-10px pe-2">
                                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                            <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_role_table .form-check-input" value="1" />
                                        </div>
                                    </th>
                                    <th class="min-w-125px">اسم المنتج</th>
                                    <th class="min-w-125px">المخزن</th>
                                    <th class="min-w-125px">نوع الخصم</th>
                                    <th class="min-w-125px"> الخصم جمله</th>
                                    <th class="min-w-125px"> الخصم قطاعى</th>
                                    <th class="min-w-125px">من اجمالى للجمله</th>
                                    <th class="min-w-125px">من اجمالى للقطاعى</th>
                                    <th class="min-w-125px">تاريخ الانشاء</th>
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
<script src="/assets/js/custom/apps/discountProducts/list/list.js"></script>
    <script>
        setTimeout(function() {
            $('.flash').fadeOut('fast');
        }, 3000);
    </script>
@endsection

