@csrf
<div class="modal-body py-10 px-lg-17" >
    <div id="kt_modal_add_customer_billing_info" class="collapse show">
        <div class="d-flex flex-column mb-7 fv-row">
            <label class="fs-6 fw-bold mb-2">
                <span class="required">المنتجات</span>
            </label>
            <select name="products[]" multiple aria-label="Select a Country" data-placeholder="اختر المنتجات" data-control="select2"  class="form-select form-select-solid fw-bolder">
                <option value="">اختر المنتجات </option>
                @foreach ($products as $product)
                    <option value="{{$product->id}}" {{isset($slider) ?(in_array($product->id,$slider_products) ?'selected' : '') : ''}}>{{$product->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    @if ($errors->has('products'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('products') }}</span>
    @endif


    <div id="kt_modal_add_customer_billing_info" class="collapse show">
        <div class="d-flex flex-column mb-7 fv-row">
            <label class="fs-6 fw-bold mb-2">
                <span class="required">النوع</span>
            </label>
            <select name="type"  aria-label="Select a Country" data-placeholder="اختر النوع" data-control="select2"  class="form-select form-select-solid fw-bolder">
                <option value="">اختر النوع </option>
                @foreach ($types as $type)
                    <option value="{{$type}}" {{isset($slider) ?( $type == $slider->type ?'selected' : '') : ''}}>{{$type}}</option>
                @endforeach
            </select>
        </div>
    </div>
    @if ($errors->has('type'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('type') }}</span>
    @endif


    <div class="fv-row mb-7">
        <label class="required fs-6 fw-bold mb-2"> الصوره</label>
        <input type="file" class="form-control form-control-solid" placeholder="" name="image" value="{{isset($supplier) ?$supplier->name :old('name')}}" />
    </div>
    @if ($errors->has('image'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('image') }}</span>
    @endif
</div>
<div class="modal-footer flex-center">
    <button type="submit"  class="btn btn-primary">
        <span class="indicator-label">{{isset($slider) ? 'تعديل  ' : 'حفظ'}}</span>
    </button>
</div>

