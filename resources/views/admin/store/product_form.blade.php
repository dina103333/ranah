<div class="tab-pane fade" id="kt_customer_view_overview_events_and_logs_tab" role="tabpanel" style="overflow: auto;max-height: 500px;">

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

</div>
