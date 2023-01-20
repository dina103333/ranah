@csrf
<div class="card-body p-12">
        <div class="d-flex flex-column align-items-start flex-xxl-row">
            <div class="d-flex flex-center flex-equal fw-row text-nowrap order-1 order-xxl-2 me-4" data-bs-toggle="tooltip" data-bs-trigger="hover" title="Enter invoice number">
                <span class="fs-2x fw-bolder text-gray-800">فاتوره #</span>
            </div>
        </div>
        <div class="separator separator-dashed my-10"></div>
        <div id="kt_modal_add_customer_billing_info" class="collapse show">
            <div class="d-flex flex-column mb-7 fv-row">
                <label class="fs-6 fw-bold mb-2">
                    <span class="required">المخزن</span>
                </label>
                <select class="form-select form-select-solid fw-bolder" required aria-label="Select a Country" data-placeholder="اختر المخزن" data-control="select2"
                    name="store_id">
                    <option value="">اختر المخزن</option>
                    @foreach ($stores as $store)
                        <option value="{{ $store->id }}">{{ $store->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @if ($errors->has('status'))
            <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('status') }}</span>
        @endif

        <div id="kt_modal_add_customer_billing_info" class="collapse show">
            <div class="d-flex flex-column mb-7 fv-row">
                <label class="fs-6 fw-bold mb-2">
                    <span class="required"> المورد </span>
                </label>
                <select class="form-select form-select-solid fw-bolder" required aria-label="Select a Country" data-placeholder="اختر المورد" data-control="select2"
                    name="supplier_id">
                    <option value="">اختر المورد</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @if ($errors->has('status'))
            <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('status') }}</span>
        @endif

        <div class="mb-0">
            <div class="table-responsive mb-10">
                <table class="table g-5 gs-0 mb-0 fw-bolder text-gray-700" data-kt-element="items">
                    <thead>
                        <tr class="border-bottom fs-7 fw-bolder text-gray-700 text-uppercase">
                            <th class="min-w-300px w-475px">المنتج</th>
                            <th class="min-w-100px w-100px">الكميه</th>
                            <th class="min-w-150px w-150px">السعر</th>
                            <th class="min-w-150px w-150px">تاريخ الانناج</th>
                            <th class="min-w-150px w-150px">تاريخ الانتهاء</th>
                            <th class="min-w-100px w-150px text-end">الاجمالى</th>
                            <th class="min-w-75px w-75px text-end">الاجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-bottom border-bottom-dashed" data-kt-element="item">
                            <td class="pe-7">
                                <select name="products[]" aria-label="Select a Country" data-placeholder=" اختر المنتج " data-control="select2"  class="form-select form-select-solid fw-bolder">
                                    <option value="">اختر المنتج </option>
                                    @foreach ($products as $product)
                                        <option value="{{$product->id}}">{{$product->name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="ps-0">
                                <input class="form-control form-control-solid" type="number" min="1" name="quantity[]" placeholder="1" value="1" data-kt-element="quantity" />
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-solid text-end" name="price[]" placeholder="0.00" value="0.00" data-kt-element="price" />
                            </td>
                            <td>
                                <input class="form-control form-control-solid" placeholder="Pick a date" id="kt_datepicker_1" name="production_date[]"/>
                            </td>
                            <td>
                                <input class="form-control form-control-solid" placeholder="Pick a date" id="kt_datepicker_2" name="expiry_date[]"/>
                            </td>
                            <td class="pt-8 text-end text-nowrap">
                                <span data-kt-element="total">0.00</span></td>
                                <input type="hidden" name="total" data-kt-element="grand-total">
                            <td class="pt-5 text-end">
                                <a class="btn btn-sm btn-icon btn-active-color-primary" data-kt-element="remove-item">
                                    <i class="fas fa-trash-alt" style="color:red"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="border-top border-top-dashed align-top fs-6 fw-bolder text-gray-700">
                            <th class="text-primary">
                                <a class="btn btn-link py-1" data-kt-element="add-item">اضافه منتج </a>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <table class="table d-none" data-kt-element="item-template">
                <tr class="border-bottom border-bottom-dashed dod" data-kt-element="item">
                    <td class="pe-7">
                        <select name="products[]" aria-label="Select a Country"  data-placeholder=" اختر المنتج"  data-value="new"  class="form-select form-select-solid fw-bolder">
                            <option value="">اختر المنتج </option>
                            @foreach ($products as $product)
                                <option value="{{$product->id}}">{{$product->name}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="ps-0">
                        <input class="form-control form-control-solid" type="number" min="1" name="quantity[]" placeholder="1" data-kt-element="quantity" />
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-solid text-end" name="price[]" placeholder="0.00" data-kt-element="price" />
                    </td>
                    <td>
                        <input class="form-control form-control-solid" placeholder="Pick a date" id="kt_datepicker_1" name="production_date[]"/>
                    </td>
                    <td>
                        <input class="form-control form-control-solid" placeholder="Pick a date" id="kt_datepicker_2" name="expiry_date[]"/>
                    </td>
                    <td class="pt-8 text-end">
                        <span data-kt-element="total">0.00</span>
                    </td>
                    <td class="pt-5 text-end">
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
<div class="modal-footer flex-center">
    <button type="submit"  class="btn btn-primary">
        <span class="indicator-label">{{isset($category) ? 'تعديل  ' : 'حفظ'}}</span>
    </button>
</div>

