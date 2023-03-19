@extends('admin.layouts.app')
@section('title') الطلبات المباشره @endsection
@section('list')
    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
        <li class="breadcrumb-item text-muted">
            <a href="{{route('admin.dashboard')}}" class="text-muted text-hover-primary">لوحه التجكم</a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-200 w-5px h-2px"></span>
        </li>
        <li class="breadcrumb-item text-muted">اضافه طلب مباشر</li>
    </ul>
@endsection
@section('content')
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            <div class="card">
                <div class="card-body pt-0" style="direction: rtl">
                    <form class="form" method="post" action="{{route('admin.orders.store')}}" id="kt_invoice_form" enctype="multipart/form-data">
                        @include('flash-message')
                        <div class="modal-header" id="kt_modal_add_role_header">
                            <h2 class="fw-bolder">اضافه طلب مباشر</h2>
                        </div>
                        @include('admin.direct_order.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
<script>
    $(document).ready(function() {
        $('.store').change(function(event){
            event.preventDefault();
            let store_id = $( this ).val();
            $.ajax({
                url: '/admin/store-users/'+store_id,
                type: 'get',
                data: {
                    _method : 'get',
                    _token : $('meta[name="csrf-token"]').attr('content')
                },
                success: function (res) {
                    // console.log(res)
                    $('.direct-order').removeAttr("disabled")
                    $('.products').removeAttr("disabled")
                    let content
                    $.each( res.users, function( key, value ) {
                        content = `<option value="${value.id}" style="display:none">${value.name}</option>`
                        $('.direct-order').append(content)
                    })
                    let product_content
                    $.each( res.products, function( key, value ) {
                        product_content = `<option value="${value.id}" style="display:none">${value.name} ${value.stores[0].pivot.sell_wholesale_price} جنيه</option>`
                        $('.products').append(product_content)
                    })
                }
            });
        })
        $('.products').change(function(event){
            event.preventDefault();
            let product_id = $( this ).val();
            let store_id = $('.store option:selected').val();
            $.ajax({
                url: '/admin/product-details/'+product_id,
                type: 'get',
                data: {
                    _method : 'get',
                    _token : $('meta[name="csrf-token"]').attr('content'),
                    store_id: store_id,
                },
                success: function (res) {
                    const trElement = event.target.parentNode.parentNode;

                    const max_wholesale_quantity = trElement.querySelector('td:nth-child(2)');
                    const store_wholesale_quantity = trElement.querySelector('td:nth-child(3)');

                    const max_unit_quantity = trElement.querySelector('td:nth-child(4)');
                    const store_unit_quantity = trElement.querySelector('td:nth-child(5)');

                    const wholesale_price = trElement.querySelector('td:nth-child(6)');
                    const unit_price = trElement.querySelector('td:nth-child(7)');

                    var unit_value = res.selling_type != 'جمله وقطاعى' ? 0 : (res.lower_limit * res.wholesale_quantity_units)
                    max_wholesale_quantity.innerHTML = `<label class="fs-6 fw-bold"> بحد ادنى <span class="text-danger">(${res.lower_limit})</span> </label>
                                    <input class="form-control form-control-solid" type="number" min="${res.lower_limit}"
                                    name="wholesale_quantity[]" value="${res.lower_limit}" data-kt-element="quantity" />`;

                    store_wholesale_quantity.innerHTML = `<label class="fs-6 fw-bold"><span></span></label>
                        <input disabled class="form-control form-control-solid" type="text"
                        value="${res.wholesale_quantity} (${res.wholesale_type})" />`;

                    max_unit_quantity.innerHTML = `<label class="fs-6 fw-bold"> بحد ادنى <span class="text-danger">(${res.lower_limit * res.wholesale_quantity_units})</span> </label>
                                    <input ${res.selling_type != 'جمله وقطاعى' ? 'readonly': ''} class="form-control form-control-solid" type="number" min="${res.lower_limit * res.wholesale_quantity_units}"
                                    name="unit_quantity[]" value="${unit_value.toString().trim()}" data-kt-element="unit_quantity" />`;

                    store_unit_quantity.innerHTML = `<label class="fs-6 fw-bold"><span></span></label>
                        <input disabled class="form-control form-control-solid" type="text"
                        value="${res.unit_quantity} (${res.item_type})"  />`;

                    wholesale_price.innerHTML = `<label class="fs-6 fw-bold"></label>
                                    <input class="form-control form-control-solid" type="text"
                                        value="${res.sell_wholesale_price}" data-kt-element="price" />`;

                    unit_price.innerHTML = `<label class="fs-6 fw-bold"><span></span></label>
                        <input disabled class="form-control form-control-solid" type="text"
                        value="${res.sell_item_price}" data-kt-element="unit_price" />`;
                }
            });
        })
    });


</script>
@endsection


