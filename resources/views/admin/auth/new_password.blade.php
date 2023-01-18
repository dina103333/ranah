@extends('admin.auth.app')
@section('content')
    <form class="form w-100" novalidate="novalidate" id="kt_new_password_form">
        @crf
        <div class="alert alert-danger error" style="display: none">
            لن نتمكن من تغيير كلمه المرور برجاء المحاوله فى وقت لاحق .
         </div>
        <div class="text-center mb-10">
            <h1 class="text-dark mb-3">قم بإعداد كلمة مرور جديدة</h1>
        </div>
        <div class="mb-10 fv-row" data-kt-password-meter="true">
            <div class="mb-1">
                <label class="form-label fw-bolder text-dark fs-6">كلمه المرور</label>
                <div class="position-relative mb-3">
                    <input class="form-control form-control-lg form-control-solid" type="password" placeholder="" name="password" autocomplete="off" />
                    <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                        <i class="bi bi-eye-slash fs-2"></i>
                        <i class="bi bi-eye fs-2 d-none"></i>
                    </span>
                </div>
                <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                </div>
            </div>
            <div class="text-muted">Use 8 or more characters with a mix of letters, numbers &amp; symbols.</div>
        </div>
        <div class="fv-row mb-10">
            <label class="form-label fw-bolder text-dark fs-6">تأكيد كلمه المرور</label>
            <input class="form-control form-control-lg form-control-solid" type="password" placeholder="" name="confirm-password" autocomplete="off" />
        </div>
        <div class="text-center">
            <button type="button" onclick="newPassword()" id="kt_new_password_submit" class="btn btn-lg btn-primary fw-bolder">
                <span class="indicator-label">حفظ</span>
                <span class="indicator-progress">برجاء الانتظار ...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
        </div>
    </form>
@endsection
@section('js')
    <script>
        function newPassword(){
            let password =  $("input[name = 'password']").val()
            let conf_password =  $("input[name = 'confirm-password']").val()
            if( password != conf_password){
                alert('كلمه المرور غير متطايقه .')
            }else{
                $.ajax({
                    url: "{{url('admin/new-password')}}",
                    type: 'Post',
                    data: {
                        _method : 'Post',
                        _token : '{{ csrf_token() }}',
                        mobile_number:{{$mobile}},
                        password:password,
                    },
                    success: function (res) {
                        console .log(res)
                        if(res =='ok'){
                            var form = $('<form action="' + '/admin/login' + '" method="get">' +
                            `@csrf` +
                            '</form>');
                            $('body').append(form);
                            $(form).submit();
                        }else{
                            $('.error').css('display','flex')
                        }

                    }
                });
            }
        }
    </script>
@endsection
