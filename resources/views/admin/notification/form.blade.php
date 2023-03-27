@csrf
<div class="data-content d-flex">
    <div class="form-check m-4">
        <input class="form-check-input all" type="radio" name="option" value="all" id="gridRadios5">
        <label class="form-check-label" for="gridRadios5">
          الجميع
        </label>
    </div>
    <div class="form-check m-4">
        <input class="form-check-input users" type="radio" name="option" value="users" id="gridRadios4">
        <label class="form-check-label" for="gridRadios4">
          العملاء
        </label>
    </div>
    {{-- <div class="form-check m-4">
        <input class="form-check-input companies" type="radio" name="option" value="companies" id="gridRadios4">
        <label class="form-check-label" for="gridRadios4">
          الشركات
        </label>
    </div> --}}
    <div class="form-check m-4">
        <input class="form-check-input areas" type="radio" name="option" value="area" id="gridRadios3">
        <label class="form-check-label" for="gridRadios3">
          المنطقه
        </label>
    </div>
    <div class="form-check m-4">
        <input class="form-check-input active_users" type="radio" name="option" id="gridRadios2" value="active_users">
        <label class="form-check-label" for="gridRadios2">
          العملاء المتفاعلين
        </label>
    </div>
    <div class="form-check m-4">
        <input class="form-check-input unactive_users" type="radio" name="option" id="gridRadios1" value="unactive_users">
        <label class="form-check-label" for="gridRadios1">
          العملاء الغير متفاعلين
        </label>
    </div>
</div>

<div class="selected_users">
    <div class="d-flex flex-column mb-7 fv-row">
        <label class="fs-6 fw-bold mb-2">
            <span class="required">العملاء</span>
        </label>
        <select name="user_id[]" multiple aria-label="Select a Country" data-placeholder="اختر العملاء" data-control="select2"  class="form-select  form-select-solid fw-bolder">
            <option value="">اختر العملاء </option>
                @foreach ($users as $user)
                    <option value="{{$user->id}}">{{$user->name}}</option>
                @endforeach
        </select>
    </div>
</div>

<div class="selected_areas">
    <div class="d-flex flex-column mb-7 fv-row">
        <label class="fs-6 fw-bold mb-2">
            <span class="required">المناطق</span>
        </label>
        <select name="area_id" aria-label="Select a Country" data-placeholder="اختر المنطقه" data-control="select2"  class="form-select  form-select-solid fw-bolder">
            <option value="">اختر المنطقه </option>
                @foreach ($areas as $area)
                    <option value="{{$area->id}}">{{$area->name}}</option>
                @endforeach
        </select>
    </div>
</div>
<div class="selected_companies">
    <div class="d-flex flex-column mb-7 fv-row">
        <label class="fs-6 fw-bold mb-2">
            <span class="">الشركات</span>
        </label>
        <select name="company_id" aria-label="Select a Country" data-placeholder="اختر الشركه" data-control="select2"  class="form-select  form-select-solid fw-bolder">
            <option value="">اختر الشركه </option>
                @foreach ($companies as $company)
                    <option value="{{$company->id}}">{{$company->name}}</option>
                @endforeach
        </select>
    </div>
</div>


<div id="kt_modal_add_customer_billing_info" class="collapse show products">
    <div class="d-flex flex-column mb-7 fv-row">
        <label class="fs-6 fw-bold mb-2">
            <span class="">المنتج</span>
        </label>
        <select name="product_id" aria-label="Select a Country" data-placeholder="اختر المنتج" data-control="select2"  class="form-select form-select-solid fw-bolder">
            <option value="">اختر المنتج </option>
            @foreach ($products as $product)
                <option value="{{$product->id}}">{{$product->name}}</option>
            @endforeach
        </select>
    </div>
</div>


<div>
    <label class="fs-6 fw-bold mb-2">
        <span class="required">عنوان الاشعار</span>
    </label>
    <input class="form-control" type="text" name="title" value="" />
</div>

<div>
    <label class="fs-6 fw-bold mb-2">
        <span class="required">الرساله</span>
    </label>
    <input class="form-control" type="text" name="message" value="" />
</div>


<div class="modal-footer flex-center">
    <button type="submit"  class="btn btn-primary">
        <span class="indicator-label">حفظ</span>
    </button>
</div>

