@extends('admin.layouts.app')
@section('title') البضاعه المنقوله للمخزن @endsection
@section('list')
    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
        <li class="breadcrumb-item text-muted">
            <a href="{{route('admin.dashboard')}}" class="text-muted text-hover-primary">لوحه التجكم</a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-200 w-5px h-2px"></span>
        </li>
        <li class="breadcrumb-item text-muted">البضاعه المنقوله للمخزن</li>
    </ul>
@endsection
@section('content')
<input type="hidden" class="store" name="store_id" value="{{$store_id}}">
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            <div class="card">
                <div class="card-header border-0 pt-6">
                </div>
                <div class="card-body pt-0">
                    @include('flash-message')
                    <div class="data-content">
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_roles_table">
                            <thead>

                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="text-center" class="w-10px pe-2">
                                        #
                                    </th>
                                    <th class="text-center"> من مخزن</th>
                                    <th class="text-center">الحاله </th>
                                    <th class="text-center" >الاجراءات</th>
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
    <div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <table class="table align-middle table-row-dashed fs-6 gy-5" >
                    <thead>
                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                            <th class="text-center"> # </th>
                            <th class="text-center">الاسم</th>
                            <th class="text-center">الكميه </th>
                        </tr>
                    </thead>
                    <tbody class="fw-bold text-gray-600" id="mytable" >

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection


@section('js')
<script src="/assets/js/custom/apps/transfer/list.js"></script>
    <script>
        setTimeout(function() {
            $('.flash').fadeOut('fast');
        }, 3000);
    </script>
@endsection

