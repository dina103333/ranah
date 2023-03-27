@csrf
<div class="modal-body py-10 px-lg-17" >

    <div class="fv-row mb-7">
        <label class="required fs-6 fw-bold mb-2">اسم العميل</label>
        <input type="text" class="form-control form-control-solid" placeholder="" name="name" value="{{isset($user) ?$user->name :old('name')}}" />
    </div>
    @if ($errors->has('name'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('name') }}</span>
    @endif

    <div class="fv-row mb-7">
        <label class="required fs-6 fw-bold mb-2">رقم الهاتف</label>
        <input type="text" class="form-control form-control-solid" placeholder="" name="mobile_number" value="{{isset($user) ?$user->mobile_number :old('mobile_number')}}" />
    </div>
    @if ($errors->has('mobile_number'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('mobile_number') }}</span>
    @endif

    <div class="fv-row mb-7">
        <label class="required fs-6 fw-bold mb-2">كلمه المرور</label>
        <input type="password" class="form-control form-control-solid" placeholder="" name="password" value="{{old('password')}}" />
    </div>
    @if ($errors->has('password'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('password') }}</span>
    @endif

    <div class="fv-row mb-7">
        <label class="required fs-6 fw-bold mb-2">اسم المحل</label>
        <input type="text" class="form-control form-control-solid" placeholder="" name="shop_name" value="{{isset($user) ? $user->shop->name :old('shop_name')}}" />
    </div>
    @if ($errors->has('shop_name'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('shop_name') }}</span>
    @endif

    <div id="kt_modal_add_customer_billing_info" class="collapse show">
        <div class="d-flex flex-column mb-7 fv-row">
            <label class="fs-6 fw-bold mb-2">
                <span class="required">نوع المحل</span>
            </label>
            <select name="shop_type_id" aria-label="Select a Country" data-placeholder=" اختر نوع المحل" data-control="select2"  class="form-select form-select-solid fw-bolder">
                <option value="">اختر نوع المحل</option>
                @foreach ($shop_types as $type)
                    <option value="{{$type->id}}" {{isset($user) ?( $type->id == $user->shop->shop_types_id ?'selected' : '') : ''}}>{{$type->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    @if ($errors->has('shop_type_id'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('shop_type_id') }}</span>
    @endif

    <div class="fv-row mb-7">
        <label class="required fs-6 fw-bold mb-2">العنوان</label>
        <input type="text" class="form-control form-control-solid" placeholder="" name="address" value="{{isset($user) ? $user->shop->address :old('address')}}" />
    </div>
    @if ($errors->has('address'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('address') }}</span>
    @endif

    <div class="fv-row mb-7">
        <label class="required fs-6 fw-bold mb-2">خطوط الطول</label>
        <input type="text" class="form-control form-control-solid" placeholder="" name="longitude" value="{{isset($user) ? $user->shop->longitude :' '}}" />
    </div>
    @if ($errors->has('longitude'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('longitude') }}</span>
    @endif

    <div class="fv-row mb-7">
        <label class="required fs-6 fw-bold mb-2">دوائر العرض</label>
        <input type="text" class="form-control form-control-solid" placeholder="" name="latitude" value="{{isset($user) ?$user->shop->latitude :' '}}" />
    </div>
    @if ($errors->has('latitude'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('latitude') }}</span>
    @endif

    <div id="kt_modal_add_customer_billing_info" class="collapse show">
        <div class="d-flex flex-column mb-7 fv-row">
            <label class="fs-6 fw-bold mb-2">
                <span class="required">المنطقه</span>
            </label>
            <select name="area_id" aria-label="Select a Country" data-placeholder="اختر المنطقه" data-control="select2"  class="form-select form-select-solid fw-bolder">
                <option value="">اختر المنطقه</option>
                @foreach ($areas as $area)
                    <option value="{{$area->id}}" {{isset($user) ?( $area->id == $user->shop->area_id ?'selected' : '') : ''}}>{{$area->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    @if ($errors->has('area_id'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('area_id') }}</span>
    @endif

    <div id="kt_modal_add_customer_billing_info" class="collapse show">
        <div class="d-flex flex-column mb-7 fv-row">
            <label class="fs-6 fw-bold mb-2">
                <span class="required">الحاله</span>
            </label>
            <select name="status" aria-label="Select a Country" data-placeholder="اختر الحاله" data-control="select2"  class="form-select form-select-solid fw-bolder">
                <option value="">اختر الحاله </option>
                @foreach ($status as $status)
                    <option value="{{$status}}" {{isset($user) ?( $status == $user->status ?'selected' : '') : ''}}>{{$status}}</option>
                @endforeach
            </select>
        </div>
    </div>
    @if ($errors->has('status'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('status') }}</span>
    @endif

    <div id="kt_modal_add_customer_billing_info" class="collapse show">
        <div class="d-flex flex-column mb-7 fv-row">
            <label class="fs-6 fw-bold mb-2">
                <span class="required">تفعيل تغيير الموقع؟</span>
            </label>
            <div class="d-flex">
                <input type="radio" name="change_location" class="form-check-input" value="1" {{isset($user) ?( $user->change_location == true ?'checked' : '') : ''}}>
                <label class="form-check-label" style="margin-left: 23px;margin-right: 10px;">
                    <span>نعم</span>
                </label>

                <input type="radio" name="change_location" class="form-check-input" value="0" {{isset($user) ?( $user->change_location == false ?'checked' : '') : ''}}>
                <label class="form-check-label" style="margin-left: 23px;margin-right: 10px;">
                    <span>لا</span>
                </label>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer flex-center">
    <button type="submit"  class="btn btn-primary">
        <span class="indicator-label">{{isset($category) ? 'تعديل  ' : 'حفظ'}}</span>
    </button>
</div>

