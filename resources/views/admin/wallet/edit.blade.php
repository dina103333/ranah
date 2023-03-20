@extends('admin.layouts.app')
@section('title') المحفظه @endsection
@section('list')
    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
        <li class="breadcrumb-item text-muted">
            <a href="{{route('admin.dashboard')}}" class="text-muted text-hover-primary">لوحه التجكم</a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-200 w-5px h-2px"></span>
        </li>
        <li class="breadcrumb-item text-muted">تعديل المحفظه</li>
    </ul>
@endsection
@section('content')

    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            <div class="card">
                <div class="card-body pt-0" style="direction: rtl">
                    <form class="form" method="post" action="{{route('admin.update-wallet-value',$wallet_id)}}" enctype="multipart/form-data">
                        @method('PUT')
                        @include('flash-message')
                        <div class="modal-header" id="kt_modal_add_role_header">
                            <h2 class="fw-bolder">تعديل المحفظه</h2>
                        </div>
                        @csrf
                        <div class="modal-body py-10 px-lg-17" >
                            <div class="fv-row mb-7">
                                <label class="required fs-6 fw-bold mb-2">القيمه</label>
                                <input type="text" class="form-control form-control-solid" name="value" value="" />
                            </div>
                            @if ($errors->has('value'))
                                <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('value') }}</span>
                            @endif
                        </div>
                        <div class="modal-footer flex-center">
                            <button type="submit"  class="btn btn-primary">
                                <span class="indicator-label">حفظ </span>
                            </button>
                        </div>

                    </form>
                </div>
            </div>


        </div>
    </div>
@endsection


