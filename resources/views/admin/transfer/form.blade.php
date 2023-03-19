@csrf
<div class="modal-body py-10 px-lg-17" >
    <div class="flex-lg-row-fluid ms-lg-15">
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="kt_customer_view_overview_tab" role="tabpanel">
                <div id="kt_modal_add_customer_billing_info" class="collapse show">
                    <div class="d-flex flex-column mb-7 fv-row">
                        <label class="fs-6 fw-bold mb-2">
                            <span class="required">المخزن المنقول اليه</span>
                        </label>
                        <input type="hidden" name="store_id" value="{{$store_id}}" >
                        <select name="to_store_id" aria-label="Select a Country" data-placeholder="اختر المخزن" data-control="select2"  class="form-select form-select-solid fw-bolder">
                            <option value="">اختر المخزن </option>
                            @foreach ($stores as $store)
                                <option value="{{$store->id}}" {{isset($store) ?( $store->id == $store->area_id ?'selected' : '') : ''}}>{{$store->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @if ($errors->has('to_store_id'))
                    <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('to_store_id') }}</span>
                @endif

                <div id="kt_modal_add_customer_billing_info" class="collapse show">
                    <div class="d-flex flex-column mb-7 fv-row">
                        <label class="fs-6 fw-bold mb-2">
                            <span class="required">المندوب المسؤل عن النقل </span>
                        </label>
                        <select class="form-select form-select-solid fw-bolder" aria-label="Select a Country" data-placeholder="اختر المندوب " data-control="select2"
                            name="driver_id">
                            <option value="">اختر المندوب </option>
                            @foreach ($drivers as $driver)
                                <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @if ($errors->has('driver_id'))
                    <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('driver_id') }}</span>
                @endif
            </div>
        </div>
    </div>

    <div class="mb-0">
        <div class="table-responsive mb-10">
            <table class="table g-5 gs-0 mb-0 fw-bolder text-gray-700" data-kt-element="items">
                <thead>
                    <tr class="border-bottom fs-7 fw-bolder text-gray-700 text-uppercase">
                        <th class="min-w-300px w-475px">المنتج</th>
                        <th class="min-w-100px w-100px">الكميه</th>
                        <th class="min-w-75px w-75px text-end">الاجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-bottom border-bottom-dashed" data-kt-element="item">
                        <td class="pe-7">
                            <select name="products[]" aria-label="Select a Country" data-placeholder=" اختر المنتج " data-control="select2"  class="form-select form-select-solid fw-bolder">
                                <option value="">اختر المنتج </option>
                                @foreach ($products as $product)
                                    <option value="{{$product->id}}">  {{$product->name}}  - {{$product->stores[0]->wholesale_quantity}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('products'))
                                <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('products') }}</span>
                            @endif
                        </td>
                        <td class="ps-0">
                            <input class="form-control form-control-solid" type="number" min="1" name="quantity[]" value="" data-kt-element="quantity" />
                        </td>
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
                            <option value="{{$product->id}}"> {{$product->name}}  - {{$product->stores[0]->wholesale_quantity}}</option>
                        @endforeach
                    </select>
                </td>
                <td class="ps-0">
                    <input class="form-control form-control-solid" type="number" min="1" name="quantity[]" data-kt-element="quantity" />
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
        <span class="indicator-label">نقل</span>
    </button>
</div>

