@csrf
<div class="modal-body py-10 px-lg-17" >
    <div id="kt_modal_add_customer_billing_info" class="collapse show">
        <div class="d-flex flex-column mb-7 fv-row">
            <label class="fs-6 fw-bold mb-2">
                <span class="required">المخزن</span>
            </label>
            <select name="store_id" aria-label="Select a Country" data-placeholder="اختر المخزن" data-control="select2"  class="form-select form-select-solid fw-bolder companies">
                <option value="">اختر المخزن </option>
                @foreach ($stores as $store)
                    <option value="{{$store->id}}" {{isset($discount) ?( $discount->store_id == $store->id ?'selected' : '') : ''}}>{{$store->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    @if ($errors->has('company_id'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('company_id') }}</span>
    @endif
    <div class="fv-row mb-7">
        <label class="fs-6 fw-bold mb-2">
            <span class="required">نوع الخصم</span>
        </label>

        <select name="type" aria-label="Select a Country" data-placeholder="اختر نوع الخصم" data-control="select2"  class="form-select form-select-solid fw-bolder companies">
            <option value="">اختر نوع الخصم </option>
            @foreach ($types as $type)
                <option value="{{$type}}" {{isset($discount) ?( $type == $discount->type ?'selected' : '') : ''}}>{{$type}}</option>
            @endforeach
        </select>
    </div>
    @if ($errors->has('type'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('type') }}</span>
    @endif
    <div class="fv-row mb-7">
        <label class="fs-6 fw-bold mb-2">
            <span class="">قيمه الخصم</span>
        </label>
        <input class="form-control form-control-solid" type="text" name="discount_value" value="{{isset($discount) ? $discount->value :'' }}" />
    </div>
    <div class="fv-row mb-7">
        <label class="fs-6 fw-bold mb-2">
            <span class="">نسبه الخصم</span>
        </label>
        <input class="form-control form-control-solid" type="text" name="discount_ratio" value="{{isset($discount) ? $discount->ratio :'' }}" />
    </div>
    <div class="fv-row mb-7">
        <label class="fs-6 fw-bold mb-2">
            <span class="required">تاريخ بدايه الخصم</span>
        </label>
        <input class="form-control form-control-solid" type="date" name="start_date" value="{{isset($discount) ? $discount->from :'' }}" />
    </div>
    @if ($errors->has('start_date'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('start_date') }}</span>
    @endif
    <div class="fv-row mb-7">
        <label class="fs-6 fw-bold mb-2">
            <span class="required">تاريخ نهايه الخصم</span>
        </label>
        <input class="form-control form-control-solid" type="date" name="end_date" value="{{isset($discount) ? $discount->to :'' }}" />
    </div>
    @if ($errors->has('end_date'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('end_date') }}</span>
    @endif
    <div class="fv-row mb-7">
        <label class="fs-6 fw-bold mb-2">
            <span class="required">الحاله</span>
        </label>
        <select name="status" aria-label="Select a Country" data-placeholder="اختر الحاله" data-control="select2"  class="form-select form-select-solid fw-bolder companies">
            <option value="">اختر الحاله </option>
            @foreach ($status as $status)
                <option value="{{$status}}" {{isset($discount) ?( $status == $discount->status ?'selected' : '') : ''}}>{{$status}}</option>
            @endforeach
        </select>
    </div>
    @if ($errors->has('status'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('status') }}</span>
    @endif
</div>

<div class="modal-footer flex-center">
    <button type="submit" id="kt_modal_add_customer_submit" class="btn btn-primary">
        <span class="indicator-label">{{isset($discount) ? 'تعديل' : 'حفظ'}}</span>
    </button>
</div>
