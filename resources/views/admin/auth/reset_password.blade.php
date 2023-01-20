@extends('admin.auth.app')
@section('content')
    <form class="form w-100" novalidate="novalidate" id="kt_password_reset_form">
        @csrf
        <div class="text-center mb-10">
            <div class="alert alert-danger error" style="display: none">

               . يرجى التحقق من الرقم الذى قمت بادخاله او يمكنك التواصل مع الاداره
            </div>
            <h1 class="text-dark mb-3">هل نسيت كلمه المرور ؟</h1>
            <div class="text-gray-400 fw-bold fs-4">قم بادخال رقم الهاتف المحمول لتغيير كلمه المرور .</div>
        </div>
        <div class="fv-row mb-10">
            <label class="form-label fw-bolder text-gray-900 fs-6">رقم الهاتف المحمول</label>
            <input class="form-control form-control-solid" type="tel" placeholder="123-45-678"
            pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" name="mobile" required autocomplete="off" />
        </div>
        <div class="d-flex flex-wrap justify-content-around pb-lg-0">
            <form method="post" action="{{route('admin.forget-password')}}">
                <button type="button" onclick="twoStep()" id="kt_password_reset_submit" class="btn btn-lg btn-primary fw-bolder me-4">
                    <span class="indicator-label">ارسال</span>
                    <span class="indicator-progress">برجاء الانتظار ...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </form>
            <a href="{{route('admin.login')}}" class="btn btn-lg btn-light-primary fw-bolder">الغاء</a>
        </div>
    </form>
@endsection
@section('js')
    <script>
        function twoStep(){
            let mobile_number = $("input[name = 'mobile']").val();
            if(mobile_number){
                $.ajax({
                    url: "{{url('admin/send-otp')}}",
                    type: 'Post',
                    data: {
                        _method : 'Post',
                        _token : '{{ csrf_token() }}',
                        mobile_number:mobile_number
                    },
                    success: function (res) {
                        if(res =='failed'){
                            $('.error').css('display','flex')
                        }else{
                            var obj =  $.parseJSON(res);
                            if(obj.type =='success'){
                                var form = $('<form action="' + '/admin/otp-page' + '" method="post">' +
                                `@csrf <input type="hidden" name="mobile" value="${mobile_number}" />` +
                                '</form>');
                                $('body').append(form);
                                $(form).submit();
                            }else{
                                $('.error').css('display','flex')
                            }
                        }


                    }
                });
            }else{
                alert('قم بأدخال رقم الهاتف المحمول')
            }

        }
    </script>
@endsection
