@extends('admin.layouts.app')
@section('title') الاعدادات @endsection
@section('list')
    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
        <li class="breadcrumb-item text-muted">
            <a href="{{route('admin.dashboard')}}" class="text-muted text-hover-primary">لوحه التجكم</a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-200 w-5px h-2px"></span>
        </li>
        <li class="breadcrumb-item text-muted">الاعدادات</li>
    </ul>
@endsection
@section('content')
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-xxl">
        <div class="card mb-5 mb-xl-10">
            <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
                <div class="card-title m-0">
                    <h3 class="fw-bolder m-0">الاعدادات</h3>
                </div>
            </div>
            <div id="kt_account_profile_details" class="collapse show">
                <form method="POST" action="{{route('admin.update-setting')}}" class="form">
                    @include('admin.setting.form')
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
