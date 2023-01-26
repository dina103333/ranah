@extends('admin.layouts.app')
@section('title') البائعين @endsection
@section('list')
    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
        <li class="breadcrumb-item text-muted">
            <a href="{{route('admin.dashboard')}}" class="text-muted text-hover-primary">لوحه التجكم</a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-200 w-5px h-2px"></span>
        </li>
        <li class="breadcrumb-item text-muted">تعديل بائع</li>
    </ul>
@endsection
@section('content')

    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            <div class="card">
                <div class="card-body pt-0" style="direction: rtl">
                    <form class="form" method="post" action="{{route('admin.areas.update', $area)}}">
                        @method('PUT')
                        @include('flash-message')
                        <div class="modal-header" id="kt_modal_add_customer_header">
                            <h2 class="fw-bolder">تعديل بائع</h2>
                        </div>
                        @include('admin.area.form')
                    </form>
                </div>
            </div>


        </div>
    </div>
@endsection


@section('js')
<script src="/assets/js/custom/apps/sellers/list/list.js"></script>
@endsection


