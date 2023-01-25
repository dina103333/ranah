@extends('admin.layouts.app')
@section('title') فواتير الشراء @endsection
@section('list')
    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
        <li class="breadcrumb-item text-muted">
            <a href="{{route('admin.dashboard')}}" class="text-muted text-hover-primary">لوحه التجكم</a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-200 w-5px h-2px"></span>
        </li>
        <li class="breadcrumb-item text-muted">فواتير الشراء</li>
    </ul>
@endsection
@section('content')
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-xxl">
        <div class="card card-flush pt-3 mb-5 mb-xl-10">
            <div class="card-header">
            <div class="card-title">
                <h2 class="title_invoice">فاتوره رقم # {{$receipt->id}}</h2>
            </div>
            <div class="card-toolbar">
                <button class="btn btn-success" onClick="print()">print</button>
            </div>
        </div>
        <div class="card-body pt-2 print">
            <div id="kt_referred_users_tab_content" class="tab-content">
                <div id="kt_customer_details_invoices_1" class="tab-pane fade show active" role="tabpanel">
                    <div class="table-responsive">
                        <table id="kt_customer_details_invoices_table_1" class="table align-middle table-row-dashed fs-6 fw-bolder gs-0 gy-4 p-0 m-0">
                            <thead class="border-bottom border-gray-200 fs-7 text-uppercase fw-bolder">
                                <tr class="text-start text-gray-400">
                                    <th class="min-w-100px">اسم المنتج</th>
                                    <th class="min-w-100px">الكميه</th>
                                    <th class="min-w-100px">السعر</th>
                                </tr>
                            </thead>
                            <tbody class="fs-6 fw-bold text-gray-600">
                                @foreach ($receipt->products as $product)
                                    <tr>
                                        <td>
                                            {{$product->name}}
                                        </td>
                                        <td class="text-success">{{$product->pivot->quantity}}</td>
                                        <td>
                                        <span class="badge badge-light-warning">{{$product->pivot->buy_price}}</span>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script>
        function print(){
        //    $.print(".print");
           $(".print").print({
            prepend  : ".title_invoice",


                // Custom document type

                doctype: '<!doctype html>'


           })

        }
    </script>
@endsection

