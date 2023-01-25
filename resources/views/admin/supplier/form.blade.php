@csrf
<div class="modal-body py-10 px-lg-17" >
    <div class="fv-row mb-7">
        <label class="required fs-6 fw-bold mb-2">اسم المورد</label>
        <input type="text" class="form-control form-control-solid" placeholder="" name="name" value="{{isset($supplier) ?$supplier->name :old('name')}}" />
    </div>
    @if ($errors->has('name'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('name') }}</span>
    @endif
</div>
<div class="modal-footer flex-center">
    <button type="submit"  class="btn btn-primary">
        <span class="indicator-label">{{isset($supplier) ? 'تعديل  ' : 'حفظ'}}</span>
    </button>
</div>

