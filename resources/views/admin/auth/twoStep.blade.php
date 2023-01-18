@extends('admin.auth.app')
@section('content')
    <form class="form w-100 mb-10" novalidate="novalidate" id="kt_sing_in_two_steps_form">
        <div class="alert alert-danger error" style="display: none">

            رمز التحقق الذى ادخلته غير صحيح .
         </div>
        <div class="text-center mb-10">
            <img alt="Logo" class="mh-125px" src="assets/media/svg/misc/smartphone.svg" />
        </div>
        <div class="text-center mb-10">
            <h1 class="text-dark mb-3">التحقق بخطوتين</h1>
            <div class="text-muted fw-bold fs-5 mb-5">أدخل رمز التحقق الذي تم ارساله إلى</div>
            <div class="fw-bolder text-dark fs-3">{{substr($mobile,-4)}}*******</div>
        </div>
        <div class="mb-10 px-md-10">
            <div class="fw-bolder text-start text-dark fs-6 mb-1 ms-1">اكتب رمز الحماية المكون من 6 أرقام</div>
            <div class="d-flex flex-wrap flex-stack">
                <input type="text" name="code[]" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="data form-control form-control-solid h-60px w-60px fs-2qx text-center border-primary border-hover mx-1 my-2" value="" />
                <input type="text" name="code[]" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="data form-control form-control-solid h-60px w-60px fs-2qx text-center border-primary border-hover mx-1 my-2" value="" />
                <input type="text" name="code[]" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="data form-control form-control-solid h-60px w-60px fs-2qx text-center border-primary border-hover mx-1 my-2" value="" />
                <input type="text" name="code[]" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="data form-control form-control-solid h-60px w-60px fs-2qx text-center border-primary border-hover mx-1 my-2" value="" />
                <input type="text" name="code[]" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="data form-control form-control-solid h-60px w-60px fs-2qx text-center border-primary border-hover mx-1 my-2" value="" />
                <input type="text" name="code[]" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="data form-control form-control-solid h-60px w-60px fs-2qx text-center border-primary border-hover mx-1 my-2" value="" />
            </div>
        </div>
        <div class="d-flex flex-center">
            <button type="button" onclick="verify()" id="kt_sing_in_two_steps_submit" class="btn btn-lg btn-primary fw-bolder">
                <span class="indicator-label">ادخال</span>
                <span class="indicator-progress">Please wait...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
        </div>
    </form>
@endsection
@section('js')
    <script>
        function verify(){
            let mobile = {{$mobile}};
            let codes = []
             $('input[name^=code]').each(function() {
                    codes.push($(this).val());
            });
            if(codes[0] == ''){
                alert('قم بادخال رمز التحقق');
            }else{
                $.ajax({
                    url: "{{url('admin/verify-otp')}}",
                    type: 'Post',
                    data: {
                        _method : 'Post',
                        _token : '{{ csrf_token() }}',
                        mobile_number:mobile,
                        codes:codes,
                    },
                    success: function (res) {
                        console .log(res)
                        var obj =  $.parseJSON(res);
                        if(obj.type =='success'){
                            var form = $('<form action="' + '/admin/reset-password' + '" method="post">' +
                            `@csrf <input type="hidden" name="mobile" value="${mobile}" />` +
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
