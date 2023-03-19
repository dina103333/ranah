@csrf
<div class="modal-body py-10 px-lg-17" >
    <div class="fv-row mb-7">
        <label class="fs-6 fw-bold mb-2">
            <span class="required">اسم الكوبون</span>
        </label>
        <input class="form-control form-control-solid" type="text" name="name" value="{{isset($promo) ? $promo->name :'' }}" />
    </div>
    @if ($errors->has('name'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('name') }}</span>
    @endif
    <div class="fv-row mb-7">
        <label class="fs-6 fw-bold mb-2">
            <span class="required"> قيمه الكوبون</span>
        </label>
        <input class="form-control form-control-solid" type="text" name="value" value="{{isset($promo) ? $promo->value :'' }}" />
    </div>
    @if ($errors->has('value'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('value') }}</span>
    @endif

    <div class="fv-row mb-7">
        <label class="fs-6 fw-bold mb-2">
            <span class="required">الحاله</span>
        </label>
        <select name="status" aria-label="Select a Country" data-placeholder="اختر الحاله" data-control="select2"  class="form-select form-select-solid fw-bolder companies">
            <option value="">اختر الحاله </option>
            @foreach ($status as $status)
                <option value="{{$status}}" {{isset($promo) ?( $status == $promo->status ?'selected' : '') : ''}}>{{$status}}</option>
            @endforeach
        </select>
    </div>
    @if ($errors->has('status'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('status') }}</span>
    @endif
</div>

<div class="modal-footer flex-center">
    <button type="submit" id="kt_modal_add_customer_submit" class="btn btn-primary">
        <span class="indicator-label">{{isset($promo) ? 'تعديل' : 'حفظ'}}</span>
    </button>
</div>
