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
    <div class="form-check m-4">
        <input class="form-check-input companies" type="radio" name="option" value="online" id="gridRadios4">
        <label class="form-check-label" for="gridRadios4">
          العملاء الاونلاين
        </label>
    </div>
    <div class="form-check m-4">
        <input class="form-check-input companies" type="radio" name="option" value="direct" id="gridRadios4">
        <label class="form-check-label" for="gridRadios4">
          العملاء المباشر
        </label>
    </div>
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

