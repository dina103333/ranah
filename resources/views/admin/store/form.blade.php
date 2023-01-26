@csrf
<div class="modal-body py-10 px-lg-17" >
    <div class="flex-lg-row-fluid ms-lg-15">
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
                                <option value="{{ $store_keeper->id }}"
                                    {{isset($store) ?(in_array($store_keeper->id ,$keepers) ?'selected' : '') : ''}}>{{ $store_keeper->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @if ($errors->has('storekeepers'))
                    <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('storekeepers') }}</span>
                @endif

                <div id="kt_modal_add_customer_billing_info" class="collapse show">
                    <div class="d-flex flex-column mb-7 fv-row">
                        <label class="fs-6 fw-bold mb-2">
                            <span class="required">  امين العهدة الحالي </span>
                        </label>
                        <select class="form-select form-select-solid fw-bolder" aria-label="Select a Country" data-placeholder="اختر امين العهدة الحالي " data-control="select2"
                            required name="storekeeper_id">
                            <option value="">اختر امين العهدة الحالي </option>
                            @foreach ($storekeepers as $store_keeper)
                                <option value="{{ $store_keeper->id }}" {{isset($store) ?($store->store_keeper_id ==$store_keeper->id ?'selected' : '') : ''}}>{{ $store_keeper->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @if ($errors->has('storekeeper_id'))
                    <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('storekeeper_id') }}</span>
                @endif

                <div id="kt_modal_add_customer_billing_info" class="collapse show">
                    <div class="d-flex flex-column mb-7 fv-row">
                        <label class="fs-6 fw-bold mb-2">
                            <span class="required"> مسئولين المالية </span>
                        </label>
                        <select class="form-select form-select-solid fw-bolder" multiple required aria-label="Select a Country" data-placeholder="اختر مسئولين المالية " data-control="select2"
                            name="finance_officers[]">
                            <option value="">اختر مسئولين المالية </option>

                            @foreach ($finance_officers as $finance_officer)
                                <option value="{{ $finance_officer->id }}"
                                    {{isset($store) ?(in_array($finance_officer->id , $store_finance_officers) ?'selected' : '') : ''}}>{{ $finance_officer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @if ($errors->has('finance_officers'))
                    <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('finance_officers') }}</span>
                @endif

                <div id="kt_modal_add_customer_billing_info" class="collapse show">
                    <div class="d-flex flex-column mb-7 fv-row">
                        <label class="fs-6 fw-bold mb-2">
                            <span class="required"> مسئول المالية الحالي</span>
                        </label>
                        <select class="form-select form-select-solid fw-bolder" required aria-label="Select a Country" data-placeholder="اختر مسئول المالية الحالي" data-control="select2"
                            name="finance_officer_id">
                            <option value="">اختر مسئول المالية الحالي</option>
                            @foreach ($finance_officers as $finance_officer)
                                <option value="{{ $finance_officer->id }}" {{isset($store) ?( $finance_officer->id == $store->store_finance_manager_id ?'selected' : '') : ''}}>{{ $finance_officer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @if ($errors->has('finance_officer_id'))
                    <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('finance_officer_id') }}</span>
                @endif


                <div id="kt_modal_add_customer_billing_info" class="collapse show">
                    <div class="d-flex flex-column mb-7 fv-row">
                        <label class="fs-6 fw-bold mb-2">
                            <span class="required"> البائعين </span>
                        </label>
                        <select class="form-select form-select-solid fw-bolder" multiple required aria-label="Select a Country" data-placeholder="اختر البائعين " data-control="select2"
                            name="sales[]">
                            <option value="">اختر البائعين </option>
                            @foreach ($salesmen as $salesman)
                                <option value="{{ $salesman->id }}"
                                    {{isset($store) ?( in_array($salesman->id,$stor_salesmen) ?'selected' : '') : ''}} >{{ $salesman->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @if ($errors->has('sales'))
                    <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('sales') }}</span>
                @endif
                <div id="kt_modal_add_customer_billing_info" class="collapse show">
                    <div class="d-flex flex-column mb-7 fv-row">
                        <label class="fs-6 fw-bold mb-2">
                            <span class="required">تفعيل المخزن ؟</span>
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
        </div>
    </div>
</div>
<div class="modal-footer flex-center">
    <button type="submit"  class="btn btn-primary">
        <span class="indicator-label">{{isset($store) ? 'تعديل  ' : 'حفظ'}}</span>
    </button>
</div>

