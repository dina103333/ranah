@extends('admin.layouts.app')
@section('title') الخصومات @endsection
@section('list')
    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
        <li class="breadcrumb-item text-muted">
            <a href="{{route('admin.dashboard')}}" class="text-muted text-hover-primary">لوحه التجكم</a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-200 w-5px h-2px"></span>
        </li>
        <li class="breadcrumb-item text-muted">اضافه خصم</li>
    </ul>
@endsection
@section('content')
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            <div class="card">
                <div class="card-body pt-0" style="direction: rtl">
                    <form class="form" method="post" action="{{route('admin.discountproducts.store')}}" enctype="multipart/form-data">
                        @include('flash-message')
                        <div class="modal-header" id="kt_modal_add_role_header">
                            <h2 class="fw-bolder">اضافه خصم</h2>
                        </div>
                        @include('admin.product_discounts.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <script>
        $('.stores').change(function(event){
            event.preventDefault();
            let store_id = $( this ).val();
            $.ajax({
                url: '/admin/get-discount-store-products/'+store_id,
                type: 'get',
                data: {
                    _method : 'get',
                    _token : $('meta[name="csrf-token"]').attr('content')
                },
                success: function (res) {
                    console .log(res)
                    $('.products').removeAttr("disabled")
                    let content=``
                    $.each( res, function( key, value ) {
                        content+= `<option value="${value.id}" style="display:none">${value.name}</option>`
                    })
                    $('.products').append(content)
                }
            });
        })
    </script>
@endsection


