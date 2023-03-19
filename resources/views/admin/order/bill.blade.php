<!DOCTYPE html>
<html direction="rtl" dir="rtl" style="direction: rtl" >
	<head><base href="">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>رنه</title>
        @include('admin.layouts.css')
        <style>
            .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
                border: 3px solid #333 !important;
            }
            .large-font {
                    font-size: 20px;
                    font-weight: bolder;
            }
            @media print {
                .noPrint{
                display:none;
                }
                .tazlel-in-print{
                    background-color: lightsteelblue !important;
                }
                .large-font{
                    font-size: 20px !important;
                    font-weight: bolder;
                }
            }
        </style>
	</head>
	<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed toolbar-tablet-and-mobile-fixed aside-enabled aside-fixed" style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">

		<div class="d-flex flex-column flex-root">
			<div class="page d-flex flex-row flex-column-fluid">
				<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                        <div class="header-info"style="direction: rtl;margin-right: 25px;">
                            إذن صرف
                            <span>#{{$order->id}}</span>
                            <div style="display: inline;margin-right: 35%;font-size: larger;font-weight: bold;">
                                <span style="font-size: x-large;">
                                    فاتورة {{$order->type}}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-12 x_content ">
                            <table  class="table table-condensed table-bordered table-striped" style="border-bottom: 3px solid #333 !important;direction: ltr;">
                                <thead class="thead-light">
                                    <tr>
                                        <th colspan="6"   style="text-align: center"> <img style="width: 75px;height: 40px;" src="/storage/files/logo.png" alt=""> </th>
                                        <th colspan="6" style="text-align: center">شركة رنه
                                        </th>
                                    </tr>

                                </thead>
                                <tbody>
                                    <tr >
                                        <td colspan="3" style="text-align: center" >01223526165</td>
                                        <td colspan="3" style="text-align: center" ></td>
                                        <td colspan="3" style="text-align: center" ></td>
                                        <td colspan="3" style="text-align: center" ></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: end;" colspan="4">{{$order->store->name}}</td>
                                        <td style="text-align: end;">المخزن</td>
                                        <td style="text-align: end;" colspan="4">{{$order->user->name}}</td>
                                        <td style="text-align: end;">اسم العميل</td>
                                    </tr>

                                    <tr>
                                        <td style="text-align: end;" colspan="4">{{date('d/m/Y', strtotime($order->created_at))}}</td>
                                        <td style="text-align: end;"> التاريخ </td>
                                        <td style="text-align: end;" colspan="4">
                                            <span>{{$order->user->mobile_number}}</span>
                                        </td>
                                        <td style="text-align: end;" > رقم العميل  </td>
                                    </tr>
                                    <tr>
                                        <td  style="text-align: end;">{{$order->shop->area->name}}</td>
                                        <!--<td style="text-align: end;" > منطقة العميل</td>-->

                                        <td colspan="8" style="text-align: end;">{{$order->shop->address}}</td>
                                        <td style="text-align: end;" >عنوان العميل</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="x_content" style="direction: rtl;" >
                            <table class="table table-condensed table-bordered table-striped" >
                                <thead class="thead-light">
                                    <tr>
                                        <tr>
                                            <th colspan="8" style="text-align: center;border:none !important;">
                                                <div class="specific"style="direction: rtl;margin-right: 25px;">
                                                    إذن صرف
                                                    <span>#{{$order->id}}</span>
                                                    <div style="display: inline;margin-right: 35%;font-size: larger;font-weight: bold;">
                                                        <span style="font-size: x-large;">
                                                            فاتورة {{$order->type}}
                                                        </span>
                                                    </div>
                                                    <div style="direction: rtl;margin-right: 25px;">
                                                        عدد المنتجات
                                                        <span>
                                                            {{$order->products->count()}}
                                                        </span>
                                                        <div style="display: inline;margin-right: 35%;font-size: larger;font-weight: bold;">
                                                            الاجمالى
                                                            <span style="font-size: x-large;">
                                                                {{$order->total}}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </th>
                                        </tr>
                                        <th style="text-align: center" >اسم المنتج</th>
                                        <th style="text-align: center" > كميه جمله </th>
                                        <th style="text-align: center"> الوحده </th>
                                        <th class="tazlel-in-print" style="text-align: center;background-color: lightsteelblue;"> كميه قطاعى </th>
                                        <th class="tazlel-in-print" style="text-align: center;background-color: lightsteelblue;"> الوحده </th>
                                        <th style="text-align: center"> السعر جمله  </th>
                                        <th style="text-align: center"> السعر قطاعى  </th>
                                        <th style="text-align: center"> الاجمالى </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->products as $key=>$product)
                                        <tr>
                                            <td>{{ $product->name }}</td>
                                            <td>
                                                <span>
                                                    <!--++-->
                                                </span>
                                                    {{$product->pivot->current_wholesale_quantity}}
                                                <span>
                                                    <!--++-->
                                                </span>
                                            </td>
                                            <td>
                                                {{$product->wholesale_type}}
                                            </td>

                                            <td class="tazlel-in-print" style="background-color: lightsteelblue;">
                                                <span>
                                                    <!--++-->
                                                </span>
                                                    {{$product->pivot->current_unit_quantity}}
                                                <span>
                                                    <!--++-->
                                                </span>
                                            </td>
                                            <td class="tazlel-in-print" style="background-color: lightsteelblue;">
                                                {{$product->item_type}}
                                            </td>
                                            <td>{{$product->pivot->wholesale_price}}</td>
                                            <td>{{$product->pivot->unit_price}}</td>
                                            <td>
                                                {{$product->pivot->total}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr colspan="12">
                                        <td colspan="12">
                                            <br>
                                        </td>
                                    </tr>
                                    <tr >
                                        <td colspan="2" >مصاريف التوصيل</td>
                                        <td >{{$order->fee}}</td>
                                    </tr>
                                    <tr >
                                        <td colspan="2" >المسافه بالكيلو</td>
                                        <td >{{$order->distance}}</td>
                                    </tr>
                                    <tr >
                                        <td colspan="2"> المكافأه الفورى </td>
                                        <td >{{$order->discounts_sum_valu == null ? 0 : $order->discounts_sum_valu == null}} جنيه</td>
                                    </tr>
                                    <tr >
                                        <td colspan="2"> اجمالى الخصم على المنتجات </td>
                                        <td >{{$order->discount_price == null ? 0 : $order->discount_price}} جنيه</td>
                                    </tr>
                                    <tr >
                                        <td colspan="2"> كوبون الخصم </td>
                                        <td >{{$order->promo ? $order->promo->value : 0}} جنيه</td>
                                    </tr>
                                    <tr >
                                        <td colspan="2"> كاش باك </td>
                                        <td >{{$wallet->value}}</td>
                                    </tr>
                                    <tr  >
                                        <td style="border-bottom: 3px solid #333 !important;" colspan="2" class="large-font" > الاجمالى </td>
                                        <td  style="border-bottom: 3px solid #333 !important;" class="large-font" > {{$order->total - $order->discount_price  - ($order->promo ? $order->promo->value : 0)}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</body>
</html>






