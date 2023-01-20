@extends('admin.layouts.app')
@section('title') المخازن @endsection
@section('list')
    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
        <li class="breadcrumb-item text-muted">
            <a href="{{route('admin.dashboard')}}" class="text-muted text-hover-primary">لوحه التجكم</a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-200 w-5px h-2px"></span>
        </li>
        <li class="breadcrumb-item text-muted">اضافه مخزن</li>
    </ul>
@endsection
@section('content')
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            <div class="card">
                <div class="card-body pt-0" style="direction: rtl">
                    <form class="form" method="post" action="{{route('admin.stores.store')}}" enctype="multipart/form-data">
                        @include('flash-message')
                        <div class="modal-header" id="kt_modal_add_role_header">
                            <h2 class="fw-bolder">اضافه مخزن</h2>
                        </div>
                        @include('admin.store.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <script src="/assets/js/custom/apps/stories/list/list.js"></script>
    <script>
        function CheckAll(className,e) {
            var elements = document.getElementsByClassName(className)
            var l = elements.length

            if(e.checked){
                for (var i = 0; i < l; i++){
                    elements[i].checked = true;
                }
            }else{
                for (var i = 0; i < l; i++){
                    elements[i].checked = false;
                }
            }
        }
    </script>
@endsection


