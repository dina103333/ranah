@csrf
<div class="modal-body py-10 px-lg-17" >
    <div id="kt_modal_add_customer_billing_info" class="collapse show">
        <div class="d-flex flex-column mb-7 fv-row">
            <label class="fs-6 fw-bold mb-2">
                <span class="required">الشركه</span>
            </label>
            <select name="company_id" aria-label="Select a Country" data-placeholder="اختر الشركه" data-control="select2"  class="form-select form-select-solid fw-bolder companies">
                <option value="">اختر الشركه </option>
                @foreach ($companies as $company)
                    <option value="{{$company->id}}" {{isset($product) ?( $company->id == $product->company_id ?'selected' : '') : ''}}>{{$company->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    @if ($errors->has('company_id'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('company_id') }}</span>
    @endif
    <div id="kt_modal_add_customer_billing_info" class="collapse show">
        <div class="d-flex flex-column mb-7 fv-row">
            <label class="fs-6 fw-bold mb-2">
                <span class="required">الاصناف</span>
            </label>
            @if(isset($product))
                <select name="category_id" data-placeholder="اختر الصنف" data-control="select2"  class="form-select form-select-solid fw-bolder categories">
                    <option value="">اختر الصنف </option>
                    @foreach ($company_categories as $category)
                        <option value="{{$category->id}}" {{$category->id == $product->category_id ?'selected' : ''}}>{{$category->name}}</option>
                    @endforeach
                </select>
            @else
                <select disabled name="category_id" data-placeholder="اختر الصنف" data-control="select2"  class="form-select form-select-solid fw-bolder categories">
                    <option value="">اختر الصنف </option>
                </select>
            @endif
        </div>
    </div>
    @if ($errors->has('category_id'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('category_id') }}</span>
    @endif

    <div class="fv-row mb-7">
        <label class="required fs-6 fw-bold mb-2">اسم المنتج</label>
        <input type="text" class="form-control form-control-solid" placeholder="" name="name" value="{{isset($product) ? $product->name :' '}}" />
    </div>
    @if ($errors->has('name'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('name') }}</span>
    @endif

    <div class="fv-row mb-7">
        <label class="required fs-6 fw-bold mb-2">نوع الوحدة</label>
        <input type="text" class="form-control form-control-solid" placeholder="" name="wholesale_type" value="{{isset($product) ? $product->wholesale_type :' '}}" />
    </div>
    @if ($errors->has('wholesale_type'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('wholesale_type') }}</span>
    @endif

    <div class="fv-row mb-7">
        <label class="required fs-6 fw-bold mb-2">كمية الوحده</label>
        <input type="number" class="form-control form-control-solid" style="direction: rtl" placeholder="" name="wholesale_quantity_units" value="{{isset($product) ? $product->wholesale_quantity_units :' '}}" />
    </div>
    @if ($errors->has('wholesale_quantity_units'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('wholesale_quantity_units') }}</span>
    @endif

    <div class="fv-row mb-7">
        <label class="required fs-6 fw-bold mb-2">نوع القطعه الواحده</label>
        <input type="text" class="form-control form-control-solid" placeholder="" name="item_type" value="{{isset($product) ? $product->item_type :' '}}" />
    </div>
    @if ($errors->has('item_type'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('item_type') }}</span>
    @endif

    <div class="fv-row mb-7">
        <label class="required fs-6 fw-bold mb-2">التفاصيل</label>
        <textarea type="description"
        rows="3" class="form-control form-control-solid" placeholder="" name="description" value="{{isset($product) ? $product->description :' '}}" >{{isset($product) ? $product->description :' '}}</textarea>
    </div>
    @if ($errors->has('description'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('description') }}</span>
    @endif


    <div class="fv-row mb-7">
        <label class="required fs-6 fw-bold mb-2">اقصي كميه متاحه</label>
        <input type="number" class="form-control form-control-solid" style="direction: rtl" placeholder="" name="wholesale_max_quantity" value="{{isset($product) ? $product->wholesale_max_quantity :' '}}" />
    </div>
    @if ($errors->has('wholesale_max_quantity'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('wholesale_max_quantity') }}</span>
    @endif

    <div class="fv-row mb-7">
        <label class="required fs-6 fw-bold mb-2">الصوره</label>
        <input type="file" class="form-control form-control-solid" name="image" value="{{isset($product) ?$product->image :old('image')}}" />
    </div>
    @if ($errors->has('image'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('image') }}</span>
    @endif

    <div id="kt_modal_add_customer_billing_info" class="collapse show">
        <div class="d-flex flex-column mb-7 fv-row">
            <label class="fs-6 fw-bold mb-2">
                <span class="required">طريقة البيع</span>
            </label>
            <div class="d-flex">
                @foreach ($selling_type as $sell)
                <input type="radio" name="sales" class="form-check-input" value="{{$sell}}" {{isset($product) ?( $sell == $product->selling_type ?'checked' : '') : ''}}>
                <label class="form-check-label" style="margin-left: 23px;margin-right: 10px;">
                    <span>{{$sell}}</span>
                </label>
                @endforeach
            </div>
        </div>
    </div>
    @if ($errors->has('sales'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('sales') }}</span>
    @endif

    <div id="kt_modal_add_customer_billing_info" class="collapse show">
        <div class="d-flex flex-column mb-7 fv-row">
            <label class="fs-6 fw-bold mb-2">
                <span class="required">وضع المنتج في قائمه الانتظار</span>
            </label>
            <div class="d-flex">
                @foreach ($wating as $waite)
                <input type="radio" name="wating" class="form-check-input" value="{{$waite}}" {{isset($product) ?( $waite == $product->wating ?'checked' : '') : ''}}>
                <label class="form-check-label" style="margin-left: 23px;margin-right: 10px;">
                    <span>{{$waite}}</span>
                </label>
                @endforeach
            </div>
        </div>
    </div>
    @if ($errors->has('wating'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('wating') }}</span>
    @endif

    <div id="kt_modal_add_customer_billing_info" class="collapse show">
        <div class="d-flex flex-column mb-7 fv-row">
            <label class="fs-6 fw-bold mb-2">
                <span class="required">تحديد كميه للمنتج ؟</span>
            </label>
            <div class="d-flex">
                @foreach ($product_quantity as $quantity)
                <input type="radio" name="product_quantity" class="form-check-input" value="{{$quantity}}" {{isset($product) ?( $quantity == $product->product_quantity ?'checked' : '') : ''}}>
                <label class="form-check-label" style="margin-left: 23px;margin-right: 10px;">
                    <span>{{$quantity}}</span>
                </label>
                @endforeach
            </div>
        </div>
    </div>
    @if ($errors->has('wating'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('wating') }}</span>
    @endif

    <div id="kt_modal_add_customer_billing_info" class="collapse show">
        <div class="d-flex flex-column mb-7 fv-row">
            <label class="fs-6 fw-bold mb-2">
                <span class="required">تفعيل المنتج ؟</span>
            </label>
            <div class="d-flex">
                @foreach ($status as $status)
                <input type="radio" name="status" class="form-check-input" value="{{$status}}" {{isset($product) ?( $status == $product->status ?'checked' : '') : ''}}>
                <label class="form-check-label" style="margin-left: 23px;margin-right: 10px;">
                    <span>{{$status}}</span>
                </label>
                @endforeach
            </div>
        </div>
    </div>
    @if ($errors->has('status'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('status') }}</span>
    @endif
</div>
<div class="modal-footer flex-center">
    <button type="submit" id="kt_modal_add_customer_submit" class="btn btn-primary">
        <span class="indicator-label">{{isset($product) ? 'تعديل' : 'حفظ'}}</span>
    </button>
</div>

