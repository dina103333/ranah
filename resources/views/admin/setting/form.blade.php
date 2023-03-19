@csrf
<div class="card-body border-top p-9">

    <div class="row mb-6">
        <label class="col-lg-4 col-form-label fw-bold fs-6">sms username</label>
        <div class="col-lg-8">
            <input type="text" name="username" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"  value="{{base64_decode(substr($setting[0]->value,5,-5))}}" />
        </div>
    </div>
    <div class="row mb-6">
        <label class="col-lg-4 col-form-label fw-bold fs-6">sms password</label>
        <div class="col-lg-8 fv-row">
            <input type="password" name="password" class="form-control form-control-lg form-control-solid"  value="" />
        </div>
    </div>
    <div class="row mb-6">
        <label class="col-lg-4 col-form-label fw-bold fs-6">
            <span class="">sms sender</span>
        </label>
        <div class="col-lg-8 fv-row">
            <input type="text" name="sender" class="form-control form-control-lg form-control-solid"  value="{{base64_decode(substr($setting[2]->value,5,-5))}}" />
        </div>
    </div>
    <div class="row mb-6">
        <label class="col-lg-4 col-form-label fw-bold fs-6">
            <span class="">اقل سعر للطلب</span>
        </label>
        <div class="col-lg-8 fv-row">
            <input type="number" name="min_order" style="direction: rtl;" class="form-control form-control-lg form-control-solid" placeholder="Phone number" value="{{$setting[10]->value}}" />
        </div>
    </div>
    <div class="row mb-6">
        <label class="col-lg-4 col-form-label fw-bold fs-6">
            <span class="">الاصدار</span>
        </label>
        <div class="col-lg-8 fv-row">
            <input type="text" name="version" class="form-control form-control-lg form-control-solid" placeholder="Phone number" value="{{$setting[6]->value}}" />
        </div>
    </div>
    <div class="row mb-6">
        <label class="col-lg-4 col-form-label fw-bold fs-6">
            <span class="">سعر الشحن للكيلو الواحد</span>
        </label>
        <div class="col-lg-8 fv-row">
            <input type="number" name="price" style="direction: rtl;" class="form-control form-control-lg form-control-solid" placeholder="Phone number" value="{{$setting[11]->value}}" />
        </div>
    </div>
    <div class="row mb-6">
        <label class="col-lg-4 col-form-label fw-bold fs-6">
            <span class="">الغاء الشحن على اجمالى الطلبات الاقل من</span>
        </label>
        <div class="col-lg-8 fv-row">
            <input type="number" name="cancele-charge" style="direction: rtl;" class="form-control form-control-lg form-control-solid" placeholder="Phone number" value="{{$setting[13]->value}}" />
        </div>
    </div>
    <div class="row mb-6">
        <label class="col-lg-4 col-form-label fw-bold fs-6">
            <span class="">تطبيق مصاربف الشحن من اجمالى</span>
        </label>
        <div class="col-lg-8 fv-row">
            <input type="number" name="add-charge" style="direction: rtl;" class="form-control form-control-lg form-control-solid" placeholder="Phone number" value="{{$setting[12]->value}}" />
        </div>
    </div>
    <div class="row mb-6">
        <label class="col-lg-4 col-form-label fw-bold fs-6">freshchat_app_id</label>
        <div class="col-lg-8">
            <input type="text" name="freshchat_app_id" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" value="{{$setting[16]->value}}" />
        </div>
    </div>
    <div class="row mb-6">
        <label class="col-lg-4 col-form-label fw-bold fs-6">freshchat_appkey</label>
        <div class="col-lg-8">
            <input type="text" name="freshchat_appkey" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" value="{{$setting[17]->value}}" />
        </div>
    </div>
    <div class="row mb-6">
        <label class="col-lg-4 col-form-label fw-bold fs-6">freshchat_domain</label>
        <div class="col-lg-8">
            <input type="text" name="freshchat_domain" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" value="{{$setting[18]->value}}" />
        </div>
    </div>
    <div class="row mb-6">
        <label class="col-lg-4 col-form-label fw-bold fs-6">freshchat</label>
        <div class="col-lg-8 fv-row">
            <div class="d-flex align-items-center mt-3">
                <label class="form-check form-check-inline form-check-solid me-5">
                    <input class="form-check-input" name="freshchat" {{$setting[15]->value == 'enable' ? 'checked': ''}}  type="checkbox" value="enable" />
                    <span class="fw-bold ps-2 fs-6">enable</span>
                </label>
                <label class="form-check form-check-inline form-check-solid">
                    <input class="form-check-input" name="freshchat" {{$setting[15]->value == 'disable' ? 'checked': ''}}  type="checkbox" value="disable" />
                    <span class="fw-bold ps-2 fs-6">disable</span>
                </label>
            </div>
        </div>
    </div>
    <div class="row mb-6">
        <label class="col-lg-4 col-form-label fw-bold fs-6">غلق الابلكيشن ؟</label>
        <div class="col-lg-8 fv-row">
            <div class="d-flex align-items-center mt-3">
                <label class="form-check form-check-inline form-check-solid me-5">
                    <input class="form-check-input" name="close" {{$setting[3]->value == 'true' ? 'checked': ''}}  type="checkbox" value="true" />
                    <span class="fw-bold ps-2 fs-6">نعم</span>
                </label>
                <label class="form-check form-check-inline form-check-solid">
                    <input class="form-check-input" name="close" {{$setting[3]->value == 'false' ? 'checked': ''}}  type="checkbox" value="false" />
                    <span class="fw-bold ps-2 fs-6">لا</span>
                </label>
            </div>
        </div>
    </div>
    <div class="row mb-6">
        <label class="col-lg-4 col-form-label fw-bold fs-6">اخفاء الخصومات ؟</label>
        <div class="col-lg-8 fv-row">
            <div class="d-flex align-items-center mt-3">
                <label class="form-check form-check-inline form-check-solid me-5">
                    <input class="form-check-input" name="hide" {{$setting[4]->value == 'true' ? 'checked': ''}} type="checkbox" value="true" />
                    <span class="fw-bold ps-2 fs-6">نعم</span>
                </label>
                <label class="form-check form-check-inline form-check-solid">
                    <input class="form-check-input" name="hide" {{$setting[4]->value == 'false' ? 'checked': ''}} type="checkbox" value="false" />
                    <span class="fw-bold ps-2 fs-6">لا</span>
                </label>
            </div>
        </div>
    <div class="row mb-6">
        <label class="col-lg-4 col-form-label fw-bold fs-6">اظهار الشريط الاخضر الخاص بالخصم؟ </label>
        <div class="col-lg-8 fv-row">
            <div class="d-flex align-items-center mt-3">
                <label class="form-check form-check-inline form-check-solid me-5">
                    <input class="form-check-input" name="show" {{$setting[5]->value == 'true' ? 'checked': ''}} type="checkbox" value="true" />
                    <span class="fw-bold ps-2 fs-6">نعم</span>
                </label>
                <label class="form-check form-check-inline form-check-solid">
                    <input class="form-check-input" name="show" {{$setting[5]->value == 'false' ? 'checked': ''}} type="checkbox" value="false" />
                    <span class="fw-bold ps-2 fs-6">لا</span>
                </label>
            </div>
        </div>
    </div>
    <div class="row mb-6">
        <label class="col-lg-4 col-form-label fw-bold fs-6">تحويل الخصومات الاجله بنظام كاش باك يتم تحصيل العميل المبلغ اوتوماتيكيا عند الطلب مره اخرى</label>
        <div class="col-lg-8 fv-row">
            <div class="d-flex align-items-center mt-3">
                <label class="form-check form-check-inline form-check-solid me-5">
                    <input class="form-check-input" name="cahe_bakc" {{$setting[7]->value == 'true' ? 'checked': ''}}  type="checkbox" value="true"/>
                    <span class="fw-bold ps-2 fs-6">نعم</span>
                </label>
                <label class="form-check form-check-inline form-check-solid">
                    <input class="form-check-input" name="cahe_bakc" {{$setting[7]->value == 'false' ? 'checked': ''}}  type="checkbox" value="false"/>
                    <span class="fw-bold ps-2 fs-6">لا</span>
                </label>
            </div>
        </div>
    </div>
    <div class="row mb-6">
        <label class="col-lg-4 col-form-label fw-bold fs-6">دمج كميات المنتج في جميع المخازن اثناء شراء العميل</label>
        <div class="col-lg-8 fv-row">
            <div class="d-flex align-items-center mt-3">
                <label class="form-check form-check-inline form-check-solid me-5">
                    <input class="form-check-input" name="all_stores" {{$setting[8]->value == 'true' ? 'checked': ''}} type="checkbox"  value="true"/>
                    <span class="fw-bold ps-2 fs-6">نعم</span>
                </label>
                <label class="form-check form-check-inline form-check-solid">
                    <input class="form-check-input" name="all_stores" {{$setting[8]->value == 'false' ? 'checked': ''}} type="checkbox" value="false" />
                    <span class="fw-bold ps-2 fs-6">لا</span>
                </label>
            </div>
        </div>
    </div>
    <div class="row mb-6">
        <label class="col-lg-4 col-form-label fw-bold fs-6">تععين المخزن للطلبات القادمه يدويا</label>
        <div class="col-lg-8 fv-row">
            <div class="d-flex align-items-center mt-3">
                <label class="form-check form-check-inline form-check-solid me-5">
                    <input class="form-check-input" name="store_order" {{$setting[9]->value == 'true' ? 'checked': ''}} type="checkbox"  value="true" />
                    <span class="fw-bold ps-2 fs-6">نعم</span>
                </label>
                <label class="form-check form-check-inline form-check-solid">
                    <input class="form-check-input" name="store_order" {{$setting[9]->value == 'false' ? 'checked': ''}} type="checkbox"  value="false"/>
                    <span class="fw-bold ps-2 fs-6">لا</span>
                </label>
            </div>
        </div>
    </div>
    <div class="row mb-6">
        <label class="col-lg-4 col-form-label fw-bold fs-6">تفعيل الشحن؟</label>
        <div class="col-lg-8 fv-row">
            <div class="d-flex align-items-center mt-3">
                <label class="form-check form-check-inline form-check-solid me-5">
                    <input class="form-check-input" name="charge" {{$setting[14]->value == 'true' ? 'checked': ''}} type="checkbox" value="true" />
                    <span class="fw-bold ps-2 fs-6">نعم</span>
                </label>
                <label class="form-check form-check-inline form-check-solid">
                    <input class="form-check-input" name="charge" {{$setting[14]->value == 'false' ? 'checked': ''}} type="checkbox" value="false" />
                    <span class="fw-bold ps-2 fs-6">لا</span>
                </label>
            </div>
        </div>
    </div>

</div>
<div class="card-footer d-flex justify-content-center py-6 px-9">
    <button class="btn btn-primary">حفظ</button>
</div>
