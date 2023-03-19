@csrf
<div class="modal-body py-10 px-lg-17" >
    <div id="kt_modal_add_customer_billing_info" class="collapse show">
        <div class="d-flex flex-column mb-7 fv-row">
            <label class="fs-6 fw-bold mb-2">
                <span class="required">المخزن</span>
            </label>
            <select name="store_id" aria-label="Select a Country" data-placeholder="اختر المخزن" data-control="select2"  class="form-select form-select-solid fw-bolder stores">
                <option value="">اختر المخزن </option>
                @foreach ($stores as $store)
                    <option value="{{$store->id}}" {{isset($discount) ?( $discount->store_id == $store->id ?'selected' : '') : ''}}>{{$store->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    @if ($errors->has('store_id'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('store_id') }}</span>
    @endif
    <div class="fv-row mb-7">
        <label class="fs-6 fw-bold mb-2">
            <span class="required">المنتج</span>
        </label>
        @if(isset($discount))
            <select name="product_id" data-placeholder="اختر المنتج" data-control="select2"  class="form-select form-select-solid fw-bolder products">
                <option value="">اختر الصنف </option>
                @foreach ($products as $product)
                    <option value="{{$product->id}}" {{$product->id == $discount->product_id ?'selected' : ''}}>{{$product->name}}</option>
                @endforeach
            </select>
        @else
            <select name="product_id" disabled aria-label="Select a Country" data-placeholder="اختر المنتج" data-control="select2"  class="form-select form-select-solid fw-bolder products">
                <option value="">اختر المنتج  </option>
            </select>
        @endif
    </div>
    @if ($errors->has('product_id'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('product_id') }}</span>
    @endif
    <div class="fv-row mb-7">
        <label class="fs-6 fw-bold mb-2">
            <span class="required">نوع الخصم</span>
        </label>
        <select multiple name="type[]" aria-label="Select a Country" data-placeholder="اختر نوع الخصم" data-control="select2"  class="form-select form-select-solid fw-bolder companies">
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
            <span class="">قيمه الخصم على القطاعى</span>
        </label>
        <input class="form-control form-control-solid" type="text" name="item_value" value="{{isset($discount) ? $discount->item_value :'' }}" />
    </div>
    <div class="fv-row mb-7">
        <label class="fs-6 fw-bold mb-2">
            <span class="">نسبه الخصم على القطاعى</span>
        </label>
        <input class="form-control form-control-solid" type="text" name="item_ratio" value="{{isset($discount) ? $discount->item_ratio :'' }}" />
    </div>
    <div class="fv-row mb-7">
        <label class="fs-6 fw-bold mb-2">
            <span class="">قيمه الخصم على الجمله</span>
        </label>
        <input class="form-control form-control-solid" type="text" name="wholesale_value" value="{{isset($discount) ? $discount->wholesale_value :'' }}" />
    </div>
    <div class="fv-row mb-7">
        <label class="fs-6 fw-bold mb-2">
            <span class="">نسبه الخصم على الجمله</span>
        </label>
        <input class="form-control form-control-solid" type="text" name="wholesale_ratio" value="{{isset($discount) ? $discount->wholesale_ratio :'' }}" />
    </div>
    <div class="fv-row mb-7">
        <label class="fs-6 fw-bold mb-2">
            <span class="">من اجمالى سعر للوحده</span>
        </label>
        <input class="form-control form-control-solid" type="text" name="from_item_total" value="{{isset($discount) ? $discount->from_item_total :'' }}" />
    </div>
    <div class="fv-row mb-7">
        <label class="fs-6 fw-bold mb-2">
            <span class="">الى اجمالى سعر للوحده</span>
        </label>
        <input class="form-control form-control-solid" type="text" name="to_item_total" value="{{isset($discount) ? $discount->to_item_total :'' }}" />
    </div>
    <div class="fv-row mb-7">
        <label class="fs-6 fw-bold mb-2">
            <span class="">من اجمالى سعر للجمله</span>
        </label>
        <input class="form-control form-control-solid" type="text" name="from_wholesale_total" value="{{isset($discount) ? $discount->from_wholesale_total :'' }}" />
    </div>
    <div class="fv-row mb-7">
        <label class="fs-6 fw-bold mb-2">
            <span class="">الى اجمالى سعر للجمله</span>
        </label>
        <input class="form-control form-control-solid" type="text" name="to_wholesale_total" value="{{isset($discount) ? $discount->to_wholesale_total :'' }}" />
    </div>
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
