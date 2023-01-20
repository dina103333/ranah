@csrf
<div class="modal-body py-10 px-lg-17" >
    <div class="flex-lg-row-fluid ms-lg-15">
        <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
            <li class="nav-item">
                <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#kt_customer_view_overview_tab">البيانات الرئيسيه</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_customer_view_overview_events_and_logs_tab">المنتجات</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">

            <div class="tab-pane fade show active" id="kt_customer_view_overview_tab" role="tabpanel">
                <div class="fv-row mb-7">
                    <label class="required fs-6 fw-bold mb-2">اسم المخزن</label>
                    <input type="text" class="form-control form-control-solid" placeholder="" name="name" value="{{isset($store) ? $store->name :' '}}" />
                </div>
                @if ($errors->has('name'))
                    <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('name') }}</span>
                @endif

                <div id="kt_modal_add_customer_billing_info" class="collapse show">
                    <div class="d-flex flex-column mb-7 fv-row">
                        <label class="fs-6 fw-bold mb-2">
                            <span class="required">المنطقه</span>
                        </label>
                        <select name="area_id" aria-label="Select a Country" data-placeholder="اختر المنظقه" data-control="select2"  class="form-select form-select-solid fw-bolder">
                            <option value="">اختر المنطقه </option>
                            @foreach ($areas as $area)
                                <option value="{{$area->id}}" {{isset($store) ?( $area->id == $store->area_id ?'selected' : '') : ''}}>{{$area->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @if ($errors->has('area_id'))
                    <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('area_id') }}</span>
                @endif

                <div class="fv-row mb-7">
                    <label class="required fs-6 fw-bold mb-2">عنوان المخزن</label>
                    <input type="text" class="form-control form-control-solid" placeholder="" name="address" value="{{isset($store) ? $store->address :' '}}" />
                </div>
                @if ($errors->has('address'))
                    <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('address') }}</span>
                @endif

                <div class="fv-row mb-7">
                    <label class="required fs-6 fw-bold mb-2">خطوط الطول</label>
                    <input type="text" class="form-control form-control-solid" placeholder="" name="longitude" value="{{isset($store) ? $store->longitude :' '}}" />
                </div>
                @if ($errors->has('longitude'))
                    <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('longitude') }}</span>
                @endif

                <div class="fv-row mb-7">
                    <label class="required fs-6 fw-bold mb-2">دوائر العرض</label>
                    <input type="text" class="form-control form-control-solid" placeholder="" name="latitude" value="{{isset($store) ? $store->latitude :' '}}" />
                </div>
                @if ($errors->has('latitude'))
                    <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('latitude') }}</span>
                @endif

                <div id="kt_modal_add_customer_billing_info" class="collapse show">
                    <div class="d-flex flex-column mb-7 fv-row">
                        <label class="fs-6 fw-bold mb-2">
                            <span class="required"> امناء العهد </span>
                        </label>
                        <select class="form-select form-select-solid fw-bolder" multiple required aria-label="Select a Country" data-placeholder="اختر امناء العهد " data-control="select2"
                            name="storekeepers[]">
                            <option value="">اختر امناء العهد </option>
                            @foreach ($storekeepers as $store_keeper)
                                <option value="{{ $store_keeper->id }}">{{ $store_keeper->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div id="kt_modal_add_customer_billing_info" class="collapse show">
                    <div class="d-flex flex-column mb-7 fv-row">
                        <label class="fs-6 fw-bold mb-2">
                            <span class="required">  امين العهدة الحالي </span>
                        </label>
                        <select class="form-select form-select-solid fw-bolder" aria-label="Select a Country" data-placeholder="اختر امين العهدة الحالي " data-control="select2"
                            required name="storekeeper_id">
                            <option value="">اختر امين العهدة الحالي </option>
                            @foreach ($storekeepers as $store_keeper)
                                <option value="{{ $store_keeper->id }}">{{ $store_keeper->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <div id="kt_modal_add_customer_billing_info" class="collapse show">
                    <div class="d-flex flex-column mb-7 fv-row">
                        <label class="fs-6 fw-bold mb-2">
                            <span class="required"> مسئولين المالية </span>
                        </label>
                        <select class="form-select form-select-solid fw-bolder" multiple required aria-label="Select a Country" data-placeholder="اختر مسئولين المالية " data-control="select2"
                            name="finance_officers[]">
                            <option value="">اختر مسئولين المالية </option>
                            @foreach ($finance_officers as $finance_officer)
                                <option value="{{ $finance_officer->id }}">{{ $finance_officer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <div id="kt_modal_add_customer_billing_info" class="collapse show">
                    <div class="d-flex flex-column mb-7 fv-row">
                        <label class="fs-6 fw-bold mb-2">
                            <span class="required"> مسئول المالية الحالي</span>
                        </label>
                        <select class="form-select form-select-solid fw-bolder" required aria-label="Select a Country" data-placeholder="اختر مسئول المالية الحالي" data-control="select2"
                            name="finance_officer_id">
                            <option value="">اختر مسئول المالية الحالي</option>
                            @foreach ($finance_officers as $finance_officer)
                                <option value="{{ $finance_officer->id }}">{{ $finance_officer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <div id="kt_modal_add_customer_billing_info" class="collapse show">
                    <div class="d-flex flex-column mb-7 fv-row">
                        <label class="fs-6 fw-bold mb-2">
                            <span class="required"> البائعين </span>
                        </label>
                        <select class="form-select form-select-solid fw-bolder" multiple required aria-label="Select a Country" data-placeholder="اختر البائعين " data-control="select2"
                            name="finance_officers[]">
                            <option value="">اختر البائعين </option>
                            @foreach ($salesmen as $salesman)
                                <option value="{{ $salesman->id }}">{{ $salesman->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div id="kt_modal_add_customer_billing_info" class="collapse show">
                    <div class="d-flex flex-column mb-7 fv-row">
                        <label class="fs-6 fw-bold mb-2">
                            <span class="required">تفعيل المنتج ؟</span>
                        </label>
                        <div class="d-flex">
                            @foreach ($status as $status)
                            <input type="radio" name="status" class="form-check-input" value="{{$status}}" {{isset($store) ?( $status == $store->status ?'checked' : '') : ''}}>
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
            <div class="tab-pane fade" id="kt_customer_view_overview_events_and_logs_tab" role="tabpanel" style="overflow: auto;max-height: 500px;">
                    <input style="margin-right: 10px;" type="checkbox" onclick="CheckAll('check',this)" name="check" class="check_all">  اخيار الكل
                @foreach ($companies as $company)
                    <div class="card pt-4 mb-6 mb-xl-9">
                        <div class="card-header border-0">
                            <div class="card-title">
                                <h2>{{$company->name}}</h2>
                            </div>
                        </div>
                        <div class="card-body py-0 row">
                            @foreach ($company->products as $product )
                                <div class="col-12 d-flex mt-3">
                                    <input class="check" value="{{$product->id}}" type="checkbox" name="products[]" style="margin-left: 15px">
                                    <div class="col-12">
                                        <h5>{{$product->name}}</h5>
                                        <div class="row">
                                            <div class="col-2 form-group m-3">
                                                <label class="fs-6 fw-bold mb-2 d-block">حد اعاده الطلب</label>
                                                <input type="number" class="form-control"  name="reorder_limit[]" value="0">
                                            </div>
                                            <div class="col-2 form-group m-3">
                                                <label class="fs-6 fw-bold mb-2 d-block">الحد الادنى</label>
                                                <input type="number" class="form-control"  name="lower_limit[]" value="0">
                                            </div>
                                            <div class="col-2 form-group m-3">
                                                <label class="fs-6 fw-bold mb-2">الحد الاقصى</label>
                                                <input type="number" class="form-control" name="max_limit[]" value="0">
                                            </div>
                                            <div class="col-2 form-group m-3">
                                                <label class="fs-6 fw-bold mb-2">سعر البيع حمله</label>
                                                <input class="form-control" name="sell_wholesale_price[]" value="0">
                                            </div>
                                            <div class="col-2 form-group m-3">
                                                <label class="fs-6 fw-bold mb-2">سعر البيع قطاعى</label>
                                                <input class="form-control" name="sell_item_price[]" value="0">
                                            </div>
                                            <div class="col-2 form-group m-3">
                                                <label class="fs-6 fw-bold mb-2">سعر الشراء</label>
                                                <input disabled class="form-control" name="buy_price">
                                            </div>
                                            <div class="col-2 form-group m-3">
                                                <label class="fs-6 fw-bold mb-2">% نسبة المكسب قطاعي</label>
                                                <input disabled class="form-control" name="unit_gain_ratio">
                                            </div>
                                            <div class="col-2 form-group m-3">
                                                <label class="fs-6 fw-bold mb-2">% نسبة المكسب جملة</label>
                                                <input disabled class="form-control" name="wholesale_gain_ratio">
                                            </div>
                                            <div class="col-2 form-group m-3">
                                                <label class="fs-6 fw-bold mb-2"> قيمة المكسب جمله بالجنيه</label>
                                                <input disabled class="form-control" name="wholesale_gain_value">
                                            </div>
                                            <div class="col-2 form-group m-3">
                                                <label class="fs-6 fw-bold mb-2">قيمة المكسب قطاعى بالجنيه</label>
                                                <input disabled class="form-control" name="unit_gain_value">
                                            </div>
                                            <div class="col-2 form-group m-3">
                                                <label class="fs-6 fw-bold mb-2">خساره</label>
                                                <input disabled class="form-control" name="loss">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="mt-2">
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<div class="modal-footer flex-center">
    <button type="submit"  class="btn btn-primary">
        <span class="indicator-label">{{isset($store) ? 'تعديل  ' : 'حفظ'}}</span>
    </button>
</div>

