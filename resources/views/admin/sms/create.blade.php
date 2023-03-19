@extends('admin.layouts.app')
@section('title') الرسائل @endsection
@section('list')
    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
        <li class="breadcrumb-item text-muted">
            <a href="{{route('admin.dashboard')}}" class="text-muted text-hover-primary">لوحه التجكم</a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-200 w-5px h-2px"></span>
        </li>
        <li class="breadcrumb-item text-muted">اضافه sms</li>
    </ul>
@endsection
@section('content')
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            <div class="card">
                <div class="card-body pt-0" style="direction: rtl">
                    <form class="form" method="post" action="{{route('admin.sms.store')}}" enctype="multipart/form-data">
                        @include('flash-message')
                        <div class="modal-header" id="kt_modal_add_role_header">
                            <h2 class="fw-bolder">اضافه sms</h2>
                        </div>
                        @include('admin.sms.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
<script >
        $(".selected_users").hide();
        $(".selected_areas").hide();
        $(".users").click(function() {
            if($(".users").is(":checked")) {
                $(".selected_users").show(300);
                $(".selected_areas").hide(200);
            }
        });
        $(".all").click(function() {
            if($(".all").is(":checked")) {
                $(".selected_users").hide(200);
                $(".selected_areas").hide(200);
            }
        });
        $(".active_users").click(function() {
            if($(".active_users").is(":checked")) {
                $(".selected_users").hide(200);
                $(".selected_areas").hide(200);
            }
        });
        $(".unactive_users").click(function() {
            if($(".unactive_users").is(":checked")) {
                $(".selected_users").hide(200);
                $(".selected_areas").hide(200);
            }
        });
        $(".areas").click(function() {
            if($(".areas").is(":checked")) {
                $(".selected_areas").show(200);
                $(".selected_users").hide(200);
            }
        });
</script>
@endsection


