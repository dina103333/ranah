@csrf
<div class="modal-body py-10 px-lg-17" >
    <div class="fv-row mb-7">
        <label class="required fs-6 fw-bold mb-2">اسم المستخدم</label>
        <input type="text" class="form-control form-control-solid" placeholder="" name="name" value="{{isset($admin) ?$admin->name :old('name')}}" />
    </div>
    @if ($errors->has('name'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('name') }}</span>
    @endif

    <div class="fv-row mb-7">
        <label class="fs-6 fw-bold mb-2">
            <span class="required">البريد الالكترونى</span>
            <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Email address must be active"></i>
        </label>
        <input type="email" class="form-control form-control-solid" placeholder="" name="email" value="{{isset($admin) ?$admin->email :old('email')}}" />
    </div>
    @if ($errors->has('email'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('email') }}</span>
    @endif

    <div class="fv-row mb-7">
        <label class="fs-6 fw-bold mb-2">
            <span class="required">رقم الهاتف</span>
        </label>
        <input type="number" class="form-control form-control-solid" placeholder="" name="mobile" value="{{isset($admin) ?$admin->mobile_number :old('mobile')}}" />
    </div>
    @if ($errors->has('mobile'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('mobile') }}</span>
    @endif

    <div class="fv-row mb-7">
        <label class="fs-6 fw-bold mb-2">
            <span class="required">كلمه المرور</span>
            <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="password is required"></i>
        </label>
        <input type="password" class="form-control form-control-solid" placeholder="" name="password" value="{{old('password')}}" />
    </div>
    @if ($errors->has('password'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('password') }}</span>
    @endif

    <div id="kt_modal_add_customer_billing_info" class="collapse show">
        <div class="d-flex flex-column mb-7 fv-row">
            <label class="fs-6 fw-bold mb-2">
                <span class="required">الدور</span>
            </label>
            <select name="role" aria-label="Select a Country" data-placeholder="اختر الدور" data-control="select2"  class="form-select form-select-solid fw-bolder">
                <option value="">اختر الدور </option>
                @foreach ($roles as $role)
                    <option value="{{$role->id}}" {{isset($admin) ?( $role->id == $admin->role_id ?'selected' : '') : ''}}>{{$role->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    @if ($errors->has('role'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('role') }}</span>
    @endif

    <div id="kt_modal_add_customer_billing_info" class="collapse show">
        <div class="d-flex flex-column mb-7 fv-row">
            <label class="fs-6 fw-bold mb-2">
                <span class="required">الحاله</span>
            </label>
            <select name="status" aria-label="Select a Country" data-placeholder="اختر الحاله" data-control="select2"  class="form-select form-select-solid fw-bolder">
                <option value="">اختر الحاله </option>
                @foreach ($status as $status)
                    <option value="{{$status}}" {{isset($admin) ?( $status == $admin->status ?'selected' : '') : ''}}>{{$status}}</option>
                @endforeach
            </select>
        </div>
    </div>
    @if ($errors->has('status'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('status') }}</span>
    @endif
</div>
<div class="modal-footer flex-center">
    <button type="submit"  class="btn btn-primary">
        <span class="indicator-label">{{isset($admin) ? 'تعديل  ' : 'حفظ'}}</span>
    </button>
</div>

