@csrf
<div class="modal-body py-10 px-lg-17" >
    <div class="fv-row mb-7">
        <label class="required fs-6 fw-bold mb-2">رقم الهاتف</label>
        <input type="text" class="form-control form-control-solid" placeholder="" name="mobile_number" value="{{isset($contact) ?$contact->mobile_number :old('mobile_number')}}" />
    </div>
    @if ($errors->has('name'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('name') }}</span>
    @endif
    <div id="kt_modal_add_customer_billing_info" class="collapse show">
        <div class="d-flex flex-column mb-7 fv-row">
            <label class="fs-6 fw-bold mb-2">
                <span class="required">النوع</span>
            </label>
            <select name="type" aria-label="Select a Country" data-placeholder="اختر النوع" data-control="select2"  class="form-select form-select-solid fw-bolder">
                <option value="">اختر النوع </option>
                @foreach ($types as $type)
                    <option value="{{$type}}" {{isset($contact) ?( $type == $contact->type ?'selected' : '') : ''}}>{{$type}}</option>
                @endforeach
            </select>
        </div>
    </div>
    @if ($errors->has('type'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('type') }}</span>
    @endif
</div>
<div class="modal-footer flex-center">
    <button type="submit"  class="btn btn-primary">
        <span class="indicator-label">{{isset($contact) ? 'تعديل  ' : 'حفظ'}}</span>
    </button>
</div>

