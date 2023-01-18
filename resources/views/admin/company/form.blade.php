@csrf
<div class="modal-body py-10 px-lg-17" >
    <div id="kt_modal_add_customer_billing_info" class="collapse show">
        <div class="d-flex flex-column mb-7 fv-row">
            <label class="fs-6 fw-bold mb-2">
                <span class="required">الفئه</span>
            </label>
            <select name="categories[]" multiple aria-label="Select a Country" data-placeholder=" اختر الفئه " data-control="select2"  class="form-select form-select-solid fw-bolder">
                <option value="">اختر الفئه </option>
                @foreach ($categories as $category)
                    <option value="{{$category->id}}" {{isset($company)? (in_array($category->id,$company_categories) ? 'selected' : ''): ''}} >{{$category->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    @if ($errors->has('categories'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('categories') }}</span>
    @endif


    <div class="fv-row mb-7">
        <label class="required fs-6 fw-bold mb-2">اسم الشركه</label>
        <input type="text" class="form-control form-control-solid" placeholder="" name="name" value="{{isset($company) ?$company->name :old('name')}}" />
    </div>
    @if ($errors->has('name'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('name') }}</span>
    @endif

    <div class="fv-row mb-7">
        <label class="required fs-6 fw-bold mb-2">الصوره</label>
        <input type="file" class="form-control form-control-solid"
        name="image" value="{{isset($company) ?$company->image :old('image')}}" />
    </div>
    @if ($errors->has('image'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('image') }}</span>
    @endif
    <div id="kt_modal_add_customer_billing_info" class="collapse show">
        <div class="d-flex flex-column mb-7 fv-row">
            <label class="fs-6 fw-bold mb-2">
                <span class="required">الحاله</span>
            </label>
            <select name="status" aria-label="Select a Country" data-placeholder="اختر الحاله" data-control="select2"  class="form-select form-select-solid fw-bolder">
                <option value="">اختر الحاله </option>
                @foreach ($status as $status)
                    <option value="{{$status}}" {{isset($company) ?( $status == $company->status ?'selected' : '') : ''}}>{{$status}}</option>
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
        <span class="indicator-label">{{isset($company) ? 'تعديل  ' : 'حفظ'}}</span>
    </button>
</div>

