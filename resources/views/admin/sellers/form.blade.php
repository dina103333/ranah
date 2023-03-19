@csrf
<div class="modal-body py-10 px-lg-17" >
    <div class="fv-row mb-7">
        <label class="required fs-6 fw-bold mb-2">اسم البائع</label>
        <input type="text" class="form-control form-control-solid" placeholder="" name="name" value="{{isset($seller) ?$seller->name :old('name')}}" />
    </div>
    @if ($errors->has('name'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('name') }}</span>
    @endif

    <div class="fv-row mb-7">
        <label class="fs-6 fw-bold mb-2">
            <span class="required">رقم الهاتف</span>
        </label>
        <input type="number" class="form-control form-control-solid" placeholder="" name="mobile" value="{{isset($seller) ?$seller->mobile_number :old('mobile')}}" />
    </div>
    @if ($errors->has('mobile'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('mobile') }}</span>
    @endif
</div>
<div class="modal-footer flex-center">
    <button type="submit"  class="btn btn-primary">
        <span class="indicator-label">{{isset($seller) ? 'تعديل  ' : 'حفظ'}}</span>
    </button>
</div>

