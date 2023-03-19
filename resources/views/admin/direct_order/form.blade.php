@csrf
<div class="card-body p-12">
        <div class="d-flex flex-column align-items-start flex-xxl-row">
            <div class="d-flex flex-center flex-equal fw-row text-nowrap order-1 order-xxl-2 me-4" data-bs-toggle="tooltip" data-bs-trigger="hover">
                <span class="fs-2x fw-bolder text-gray-800">طلب مباشر #</span>
            </div>
        </div>
        <div class="separator separator-dashed my-10"></div>
        <div id="kt_modal_add_customer_billing_info" class="collapse show">
            <div class="d-flex flex-column mb-7 fv-row">
                <label class="fs-6 fw-bold mb-2">
                    <span class="required">المخزن</span>
                </label>
                <select class="form-select form-select-solid fw-bolder store" aria-label="Select a Country" data-placeholder="اختر المخزن" data-control="select2"
                    name="store_id">
                    <option value="">اختر المخزن</option>
                    @foreach ($stores as $store)
                        <option value="{{ $store->id }}" {{isset($receipt) ? ($receipt->store_id == $store->id ? 'selected' : '' ):''}}>{{ $store->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @if ($errors->has('store_id'))
            <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('store_id') }}</span>
        @endif

        <div id="kt_modal_add_customer_billing_info" class="collapse show">
            <div class="d-flex flex-column mb-7 fv-row">
                <label class="fs-6 fw-bold mb-2">
                    <span class="required"> العميل </span>
                </label>
                <select disabled class="form-select form-select-solid fw-bolder direct-order" aria-label="Select a Country" data-placeholder="اختر العميل" data-control="select2"
                    name="user_id">
                    <option value="">اختر العميل</option>
                </select>
            </div>
        </div>
        @if ($errors->has('user_id'))
            <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('user_id') }}</span>
        @endif

        <div class="mb-0">
            <div class="table-responsive mb-10">
                <table class="table gs-0 mb-0 fw-bolder text-gray-700" data-kt-element="items">
                    <thead>

                        <tr class="border-bottom fs-7 fw-bolder text-gray-700 text-uppercase">
                            <th class=" w-250px">المنتج</th>
                            <th class=" w-150px">الكميه المطلوبه جمله</th>
                            <th class=" w-150px">الكميه الموجوده بالمخزن</th>
                            <th class=" w-150px">الكميه المطلوبه قطاعى</th>
                            <th class=" w-150px">الكميه الموجوده بالمخزن</th>
                            <th class=" w-90px">سعر الجمله</th>
                            <th class=" w-80px"> سعر القطاعى</th>
                            <th class="w-150px text-end">الاجمالى</th>
                            <th class="w-75px text-end">الاجراءات</th>
                        </tr>
                        <tr class="border-top border-top-dashed align-top fs-6 fw-bolder text-gray-700">
                            <th class="text-primary">
                                <a class="btn btn-link py-1" data-kt-element="add-item">اضافه منتج </a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>

                        @if(isset($receipt))
                            @foreach ($receipt->products as $receipt_product)
                                <tr class="border-bottom border-bottom-dashed" data-kt-element="item">
                                    <td class="pe-7">
                                        <select name="products[]" aria-label="Select a Country" data-placeholder=" اختر المنتج " data-control="select2"  class="form-select form-select-solid fw-bolder">
                                            <option value="">اختر المنتج </option>
                                            @foreach ($products as $product)
                                                <option value="{{$product->id}}" {{$receipt_product->id == $product->id ? 'selected' : ''}}>{{$product->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="ps-0">
                                        <input class="form-control form-control-solid" type="number" min="1" name="quantity[]" placeholder="1" value="{{$receipt_product->pivot->quantity}}" data-kt-element="quantity" />
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-solid text-end" name="price[]" placeholder="0.00" value="{{$receipt_product->pivot->buy_price}}" data-kt-element="price" />
                                    </td>
                                    <td>
                                        <input class="form-control form-control-solid kt_datepicker_1" placeholder="Pick a date" value="{{$receipt_product->pivot->production_date}}"  name="production_date[]"/>
                                    </td>
                                    <td>
                                        <input class="form-control form-control-solid kt_datepicker_1" placeholder="Pick a date" value="{{$receipt_product->pivot->expiry_date}}"  name="expiry_date[]"/>
                                    </td>
                                    <td class="pt-8 text-end text-nowrap">
                                        <span data-kt-element="total">0.00</span>
                                    </td>
                                    <td class="pt-5 text-end">
                                        <a class="btn btn-sm btn-icon btn-active-color-primary" data-kt-element="remove-item">
                                            <i class="fas fa-trash-alt" style="color:red"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach

                        @else
                            <tr class="border-bottom border-bottom-dashed" data-kt-element="item">
                                <td class="pe-5">
                                    <label class="fs-6 fw-bold"> <span>المنتج</span> </label>
                                    <select disabled name="products[]" aria-label="Select a Country" data-placeholder=" اختر المنتج " data-control="select2"  class="form-select form-select-solid fw-bolder products">
                                        <option value="" selected>اختر المنتج </option>
                                    </select>
                                </td>
                                <td class="ps-0">
                                    <label class="fs-6 fw-bold"> <span>بحد ادنى()</span> </label>
                                    <input class="form-control form-control-solid" type="number"  name="wholesale_quantity[]"  data-kt-element="quantity" />
                                </td>
                                <td class="ps-0">
                                    <label class="fs-6 fw-bold"><span></span></label>
                                    <input disabled class="form-control form-control-solid" type="number" />
                                </td>
                                <td>
                                    <label class="fs-6 fw-bold"> <span>بحد ادنى()</span></label>
                                    <input type="number" class="form-control form-control-solid " name="unit_quantity[]"  data-kt-element="unit_quantity" />
                                </td>
                                <td>
                                    <label class="fs-6 fw-bold"><span></span></label>
                                    <input disabled type="number" class="form-control form-control-solid "/>
                                </td>
                                <td>
                                    <label class="fs-6 fw-bold"><span></span></label>
                                    <input disabled type="text" class="form-control form-control-solid"  data-kt-element="price" />
                                </td>
                                <td>
                                    <label class="fs-6 fw-bold"><span></span></label>
                                    <input disabled type="text" class="form-control form-control-solid text-end" value="0" data-kt-element="unit_price" />
                                </td>
                                <td class="pt-8 text-end text-nowrap">
                                    <label class="fs-6 fw-bold"><span></span></label>
                                    <span data-kt-element="total">0.00</span>
                                </td>
                                <td class="pt-5 text-end">
                                    <label class="fs-6 fw-bold"><span></span></label>
                                    <a class="btn btn-sm btn-icon btn-active-color-primary" data-kt-element="remove-item">
                                        <i class="fas fa-trash-alt" style="color:red"></i>
                                    </a>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                    <tfoot>

                    </tfoot>
                </table>
            </div>
            <table class="table d-none" data-kt-element="item-template">
                <tr class="border-bottom border-bottom-dashed dod" data-kt-element="item">
                    <td class="pe-5">
                        <label class="fs-6 fw-bold"> <span>المنتج</span> </label>
                        <select name="products[]" aria-label="Select a Country" data-placeholder=" اختر المنتج"  data-value="new"  class="form-select form-select-solid fw-bolder products">
                            <option value="">اختر المنتج </option>
                        </select>
                    </td>
                    <td class="ps-0">
                        <label class="fs-6 fw-bold"> <span> بحد ادنى()</span> </label>
                        <input class="form-control form-control-solid" type="number" min="1" name="wholesale_quantity[]" placeholder="1" data-kt-element="quantity" />
                    </td>
                    <td class="ps-0">
                        <label class="fs-6 fw-bold"><span></span></label>
                        <input disabled class="form-control form-control-solid" type="number" />
                    </td>
                    <td>
                        <label class="fs-6 fw-bold"> <span> بحد ادنى()</span></label>
                        <input type="number" class="form-control form-control-solid" name="unit_quantity[]" data-kt-element="unit_quantity" />
                    </td>
                    <td>
                        <label class="fs-6 fw-bold"><span></span></label>
                        <input disabled type="number" class="form-control form-control-solid" />
                    </td>
                    <td>
                        <label class="fs-6 fw-bold"><span></span></label>
                        <input disabled type="text" class="form-control form-control-solid" data-kt-element="price" />
                    </td>
                    <td>
                        <label class="fs-6 fw-bold"><span></span></label>
                        <input disabled type="text" class="form-control form-control-solid" data-kt-element="unit_price" />
                    </td>
                    <td class="pt-8 text-end">
                        <label class="fs-6 fw-bold"><span></span></label>
                        <span data-kt-element="total">0.00</span>
                    </td>
                    <td class="pt-5 text-end">
                        <label class="fs-6 fw-bold"><span></span></label>
                        <a type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-kt-element="remove-item">
                            <i class="fas fa-trash-alt" style="color:red"></i>
                        </a>
                    </td>
                </tr>
            </table>
            <table class="table d-none" data-kt-element="empty-template">
                <tr data-kt-element="empty">
                    <th colspan="5" class="text-muted text-center py-10">لا يوجد منتجات</th>
                </tr>
            </table>
        </div>
</div>
<input type="hidden" name="total" value="{{isset($receipt) ? $receipt->total : ''}}" data-kt-element="grand-total">
<div class="modal-footer flex-center">
    <button type="submit"  class="btn btn-primary">
        <span class="indicator-label">{{isset($category) ? 'تعديل  ' : 'حفظ'}}</span>
    </button>
</div>
