@extends('admin.layouts.app')
@section('title') البيانات الشخصيه @endsection
@section('list')
    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
        <li class="breadcrumb-item text-muted">
            <a href="{{route('admin.dashboard')}}" class="text-muted text-hover-primary">لوحه التجكم</a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-200 w-5px h-2px"></span>
        </li>
        <li class="breadcrumb-item text-muted">تعديل البايانات الشخصيه</li>
    </ul>
@endsection
@section('content')

    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            <div class="card">
                <div class="card-body pt-0" style="direction: rtl">
                    <form class="form" method="post" action="{{route('admin.update-admin')}}" enctype="multipart/form-data">
                        @include('flash-message')
                        <div class="modal-header" id="kt_modal_add_role_header">
                            <h2 class="fw-bolder">تعديل البيانات الشخصيه</h2>
                        </div>
                        @csrf
                        <div class="modal-body py-10 px-lg-17" >
                            <div class="fv-row mb-7">
                                <label class="required fs-6 fw-bold mb-2">الاسم</label>
                                <input type="text" class="form-control form-control-solid" placeholder="" name="name" value="{{auth()->user()->name}}" />
                            </div>
                            <div class="fv-row mb-7">
                                <label class="required fs-6 fw-bold mb-2">البريد الالكترونى</label>
                                <input type="email" class="form-control form-control-solid" placeholder="" name="email" value="{{auth()->user()->email}}" />
                            </div>
                            <div class="fv-row mb-7">
                                <label class="required fs-6 fw-bold mb-2">كلمه المرور</label>
                                <input type="passwoed" class="form-control form-control-solid" placeholder="" name="passwoed" value="{{auth()->user()->email}}" />
                            </div>
                        </div>
                        <div class="modal-footer flex-center">
                            <button type="submit"  class="btn btn-primary">
                                <span class="indicator-label">تعديل </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
@endsection




