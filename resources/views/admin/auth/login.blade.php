@extends('admin.auth.app')
@section('content')
@include('flash-message')
    <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" method="post" action="{{route('admin.login-form')}}">
        @csrf
        <div class="text-center mb-10">
            <h1 class="text-dark mb-3">تسجيل الدخول</h1>
        </div>
        <div class="fv-row ">
            <label class="form-label fs-6 fw-bolder text-dark">البريد الالكترونى</label>
            <input class="form-control form-control-lg form-control-solid mb-5" type="text" name="email" autocomplete="off" />
        </div>
        @if ($errors->has('email'))
            <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('email') }}</span>
        @endif
        <div class="fv-row ">
            <div class="d-flex flex-stack ">
                <label class="form-label fw-bolder text-dark fs-6 mb-0">كلمه المرور</label>
                <a href="{{route('admin.forget-password')}}" class="link-primary fs-6 fw-bolder">نسيت كلمه المرور ؟</a>
            </div>
            <input class="form-control form-control-lg form-control-solid mb-5" type="password" name="password" autocomplete="off" />
        </div>
        @if ($errors->has('password'))
            <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('password') }}</span>
        @endif
        <div class="text-center">
            <button type="submit"  class="btn btn-lg btn-primary w-100 mb-5">
                <span class="indicator-label">دخول</span>
                <span class="indicator-progress">Please wait...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
        </div>
    </form>
@endsection
