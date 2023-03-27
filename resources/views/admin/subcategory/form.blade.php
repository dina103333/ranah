@csrf
<div class="modal-body py-10 px-lg-17" >
    <div id="kt_modal_add_customer_billing_info" class="collapse show">
        <div class="d-flex flex-column mb-7 fv-row">
            <label class="fs-6 fw-bold mb-2">
                <span class="required">الفئه</span>
            </label>
            <select name="parent_id" aria-label="Select a Country" data-placeholder=" اختر الفئه الرئيسيه" data-control="select2"  class="form-select form-select-solid fw-bolder">
                <option value="">اختر الفئه الرئيسيه</option>
                <option value="0"> فئه رئيسيه</option>
                @foreach ($sub_categories as $sub_category)
                    <option value="{{$sub_category->id}}" {{isset($category) ?( $sub_category->id == $category->parent_id ?'selected' : '') : ''}}>{{$sub_category->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    @if ($errors->has('parent_id'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('parent_id') }}</span>
    @endif


    <div class="fv-row mb-7">
        <label class="required fs-6 fw-bold mb-2">اسم الفئه</label>
        <input type="text" class="form-control form-control-solid" placeholder="" name="name" value="{{isset($category) ?$category->name :old('name')}}" />
    </div>
    @if ($errors->has('name'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('name') }}</span>
    @endif

    <div class="fv-row mb-7">
        <label class="required fs-6 fw-bold mb-2">الصوره</label>
        <input type="file" class="form-control form-control-solid"
        name="image" value="{{isset($category) ?$category->image :old('image')}}" />
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
                    <option value="{{$status}}" {{isset($category) ?( $status == $category->status ?'selected' : '') : ''}}>{{$status}}</option>
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
        <span class="indicator-label">{{isset($category) ? 'تعديل  ' : 'حفظ'}}</span>
    </button>
</div>

