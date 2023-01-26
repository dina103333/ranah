@csrf
<div class="modal-body py-10 px-lg-17" >
    <div class="fv-row mb-7">
        <label class="required fs-6 fw-bold mb-2">اسم المنطقه</label>
        <input type="text" class="form-control form-control-solid" placeholder="" name="name" value="{{isset($area) ?$area->name :old('name')}}" />
    </div>
    @if ($errors->has('name'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('name') }}</span>
    @endif

    <div id="kt_modal_add_customer_billing_info" class="collapse show">
        <div class="d-flex flex-column mb-7 fv-row">
            <label class="fs-6 fw-bold mb-2">
                <span class="required">الحاله</span>
            </label>
            <select name="status" aria-label="Select a Country" data-placeholder="اختر الحاله" data-control="select2"  class="form-select form-select-solid fw-bolder">
                <option value="">اختر الحاله </option>
                @foreach ($status as $s)
                    <option value="{{$s}}" {{isset($area) ?( $s == $area->status ?'selected' : '') : ''}}>{{$s}}</option>
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
        <span class="indicator-label">{{isset($area) ? 'تعديل  ' : 'حفظ'}}</span>
    </button>
</div>

