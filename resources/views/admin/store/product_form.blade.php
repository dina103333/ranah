@extends('admin.layouts.app')
@section('title') المخازن @endsection
@section('list')
    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
        <li class="breadcrumb-item text-muted">
            <a href="{{route('admin.dashboard')}}" class="text-muted text-hover-primary">لوحه التجكم</a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-200 w-5px h-2px"></span>
        </li>
        <li class="breadcrumb-item text-muted">تعديل اسعار المخزن</li>
    </ul>
@endsection
@section('content')

    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            <div class="card">
                <div class="card-body pt-0" style="direction: rtl">
                    <form class="form" method="post" action="{{route('admin.update-store-product')}}" enctype="multipart/form-data">
                        @include('flash-message')
                        <div class="modal-header" id="kt_modal_add_role_header">
                            <h2 class="fw-bolder">تعديل اسعار المخزن</h2>
                        </div>
                        @csrf
                        <div class="modal-body py-10 px-lg-17" >
                            <div class="flex-lg-row-fluid">
                                <div class="col-12">
                                    <h5>{{$product->name}}</h5>
                                    <input type='hidden' name='store_id' value="{{$store_id}}"/>
                                    <input type='hidden' name='product_id' value="{{$product_id}}"/>
                                    <div class="row">
                                        <div class="col-md-2 col-sm-4 form-group m-3">
                                            <label class="fs-6 fw-bold mb-2 d-block">حد اعاده الطلب</label>
                                            <input type="number" min="0" class="form-control"  name="reorder_limit" value="{{$product->stores[0]->pivot->reorder_limit}}" style="direction: rtl;">
                                            @if ($errors->has('reorder_limit'))
                                                <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('reorder_limit') }}</span>
                                            @endif
                                        </div>

                                        <div class="col-md-2 col-sm-4 form-group m-3">
                                            <label class="fs-6 fw-bold mb-2 d-block">الحد الادنى</label>
                                            <input type="number" min="0" class="form-control"  name="lower_limit" value="{{$product->stores[0]->pivot->lower_limit}}" style="direction: rtl;">
                                            @if ($errors->has('lower_limit'))
                                                <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('lower_limit') }}</span>
                                            @endif
                                        </div>

                                        <div class="col-md-2 col-sm-4 form-group m-3">
                                            <label class="fs-6 fw-bold mb-2">الحد الاقصى</label>
                                            <input type="number" min="0" class="form-control" name="max_limit" value="{{$product->stores[0]->pivot->max_limit}}" style="direction: rtl;">
                                            @if ($errors->has('max_limit'))
                                                <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('max_limit') }}</span>
                                            @endif
                                        </div>

                                        <div class="col-md-2 col-sm-4 form-group m-3">
                                            <label class="fs-6 fw-bold mb-2">سعر البيع جمله</label>
                                            <input class="form-control sell_wholesale_price" name="sell_wholesale_price" value="{{$product->stores[0]->pivot->sell_wholesale_price}}">
                                            @if ($errors->has('sell_wholesale_price'))
                                                <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('sell_wholesale_price') }}</span>
                                            @endif
                                        </div>

                                        <div class="col-md-2 col-sm-4 form-group m-3">
                                            <label class="fs-6 fw-bold mb-2">سعر البيع قطاعى</label>
                                            <input class="form-control sell_item_price" name="sell_item_price" value="{{$product->stores[0]->pivot->sell_item_price}}">
                                            @if ($errors->has('sell_item_price'))
                                                <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('sell_item_price') }}</span>
                                            @endif
                                        </div>

                                        <div class="col-md-2 col-sm-4 form-group m-3">
                                            <label class="fs-6 fw-bold mb-2">سعر الشراء</label>
                                            <input readonly  class="form-control buy_price" name="buy_price" value="{{$product->stores[0]->pivot->buy_price}}">
                                        </div>
                                        <div class="col-md-2 col-sm-4 form-group m-3">
                                            <label class="fs-6 fw-bold mb-2" style="direction: ltr">% نسبة المكسب قطاعي</label>
                                            <input readonly  class="form-control unit_gain_ratio" name="unit_gain_ratio" value="{{$product->stores[0]->pivot->unit_gain_ratio}}" style="background: gold;">
                                        </div>
                                        <div class="col-md-2 col-sm-4 form-group m-3">
                                            <label class="fs-6 fw-bold mb-2" style="direction: ltr">% نسبة المكسب جملة</label>
                                            <input readonly  class="form-control wholesale_gain_ratio" name="wholesale_gain_ratio" value="{{$product->stores[0]->pivot->wholesale_gain_ratio}}" style="background: gold;">
                                        </div>
                                        <div class="col-md-2 col-sm-4 form-group m-3">
                                            <label class="fs-6 fw-bold mb-2"> قيمة المكسب جمله بالجنيه</label>
                                            <input readonly  class="form-control wholesale_gain_value" value="{{$product->stores[0]->pivot->wholesale_gain_value}}" name="wholesale_gain_value">
                                        </div>
                                        <div class="col-md-2 col-sm-4 form-group m-3">
                                            <label class="fs-6 fw-bold mb-2">قيمة المكسب قطاعى بالجنيه</label>
                                            <input readonly  class="form-control unit_gain_value" value="{{$product->stores[0]->pivot->unit_gain_value}}" name="unit_gain_value">
                                        </div>
                                        <div class="col-md-2 col-sm-4 form-group m-3">
                                            <label class="fs-6 fw-bold mb-2">الخساره جمله</label>
                                            <input readonly  class="form-control loss" value="0" name="loss" value="{{$product->stores[0]->pivot->loss}}" style="background: rgb(255 58 58);">
                                        </div>
                                        <div class="col-md-2 col-sm-4 form-group m-3">
                                            <label class="fs-6 fw-bold mb-2">الخساره قطاعى</label>
                                            <input readonly  class="form-control loss_unit" value="0" name="loss" style="background: rgb(255 58 58);">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer flex-center">
                            <button type="submit"  class="btn btn-primary">
                                <span class="indicator-label">تعديل </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </div>
@endsection


@section('js')
    <script>
            $(document).on('keyup', '.sell_wholesale_price', function() {
                $sell_price = $(this).val();
                $buy_price = $('.buy_price').val();
                if(($sell_price - $buy_price) < 0){
                    $('.loss').val(($buy_price - $sell_price)+' جنيه' ) ;
                    $('.wholesale_gain_ratio').val(0);
                    $('.wholesale_gain_value').val(0);
                }else{
                    $percentage = ((($sell_price - $buy_price) / $buy_price) * 100)+ '%';
                    $('.wholesale_gain_ratio').val($percentage);

                    $profit = ($sell_price - $buy_price) +' جنيه';
                    $('.wholesale_gain_value').val($profit);
                    $('.loss').val(0)
                }
            });

            $(document).on('keyup', '.sell_item_price', function() {
                $sell_price = $(this).val();
                $buy_price = $('.buy_price').val();

                $quantity = '{{$product->wholesale_quantity_units}}';
                if($quantity!=null)
                {
                    $buy_price = $buy_price/$quantity;
                    console.log($buy_price)
                    if(($sell_price - $buy_price) < 0){
                        $('.loss_unit').val(($buy_price - $sell_price)+' جنيه' ) ;
                        $('.unit_gain_ratio').val(0);
                        $('.unit_gain_value').val(0);
                    }else{
                        $percentage = ((($sell_price - $buy_price) / $buy_price)* 100 )+ '%';
                        $('.unit_gain_ratio').val($percentage);

                        $profit = ($sell_price - ($buy_price))  ;
                        $('.unit_gain_value').val($profit);
                        $('.loss_unit').val(0)
                    }
                }
            });
</script>
@endsection


