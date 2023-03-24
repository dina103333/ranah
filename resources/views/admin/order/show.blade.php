@extends('admin.layouts.app')
@section('title') تفاصيل الطلب @endsection
@section('list')
    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
        <li class="breadcrumb-item text-muted">
            <a href="{{route('admin.dashboard')}}" class="text-muted text-hover-primary">لوحه التجكم</a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-200 w-5px h-2px"></span>
        </li>
        <li class="breadcrumb-item text-muted">تفاصيل الطلب</li>
    </ul>
@endsection
@section('content')

    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            <div class="card">
                <div class="card-header border-0 pt-6">
                    <div class="card-title ">

                    </div>
                    <div class="card-toolbar">
                        <div class="d-flex justify-content-end" data-kt-role-table-toolbar="base">
                            <button onclick="show()" class="btn btn-light me-3 returns">
                                المرتجعات
                              </button>
                            @if(count($order->returns)>0)
                                <button onclick="dropCustodies({{$order->id}})" type="button" class="btn btn-light me-3">اسقاط عهده السائق</button>
                            @endif
                            <a href="{{route('admin.print-bill',$order->id)}}" class="btn btn-success btnprn">print</a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="m-0">
                        <div class="fw-bolder fs-3 text-gray-800 mb-8 text-center ">رقم الطلب :{{$order->id}}</div>
                        <div class="row g-5 mb-11 text-center">
                            <div class="col-sm-4">
                                <div class="fw-bolder fs-7 text-gray-800 mb-1">اسم المحل : {{$order->shop->name}}</div>
                            </div>
                            <div class="col-sm-4">
                                <div class="fw-bolder fs-7 text-gray-800 mb-1">اسم العميل : {{$order->user->name}}</div>
                            </div>
                            <div class="col-sm-4">
                                <div class="fw-bolder fs-7 text-gray-800 mb-1">رقم العميل : {{$order->user->mobile_number}}</div>
                            </div>
                        </div>
                        <div class="row g-5 mb-12 text-center">
                            <div class="col-sm-6">
                                <div class="fw-bolder fs-7 text-gray-800 mb-1">تاريخ الطلب : {{date('d/m/Y', strtotime($order->created_at))}}</div>
                            </div>
                            <div class="col-sm-6">
                                <div class="fw-bolder fs-6 text-gray-800 mb-1">تاريخ التسليم : {{$order->status == 'تم التسليم' ? date('d/m/Y', strtotime($order->updated_at)) : 'لم يتم التسليم بعد'}}</div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="table-responsive border-bottom mb-9">
                                <table class="table mb-3">
                                    <thead>
                                        <tr class="border-bottom fs-6 fw-bolder text-muted">
                                            <th class="text-center w-10px pe-2">#</th>
                                            <th class="text-center w-10px pe-2"> اسم المنتج </th>
                                            <th class="text-center w-80px">كميه الجملة المطلوبه</th>
                                            <th class="text-center w-80px">كميه القطاعي المطلوبه</th>
                                            <th class="text-center w-80px">المستلم من الجملة</th>
                                            <th class="text-center w-80px">المستلم من القطاعي</th>
                                            <th class="text-center w-80px">المرتجع من الجملة</th>
                                            <th class="text-center w-80px">المرتجع من القطاعي</th>
                                            <th class="text-center w-80px">سعر الوحده جمله</th>
                                            <th class="text-center w-80px">سعر الوحده قطاعى</th>
                                            <th class="text-center w-80px">السعر الكلى</th>
                                        </tr>
                                    </thead>
                                    <tbody class="order-table">
                                        <?php
                                            $total_item_discount = [];
                                            $total_wholesale_discount = [];
                                        ?>
                                        @foreach ($order->products as $key=>$product)
                                            <tr class="fw-bolder text-gray-700 fs-5 text-center">
                                                <td class="d-flex align-items-center pt-6">{{$product->id}}</td>
                                                <td class="pt-6">{{$product->name}}</td>
                                                <td class="pt-6"><input class="form-control current_wholesale_quantity" name="current_wholesale_quantity[]" id="{{$product->id}}" value="{{$product->pivot->current_wholesale_quantity}}"></td>
                                                <td class="pt-6"><input {{$product->selling_type == 'جمله فقط' ? 'disabled': ''}} class="form-control current_unit_quantity" id="{{$product->id}}" name="current_unit_quantity[]" value="{{$product->pivot->current_unit_quantity}}"></td>
                                                <td class="pt-6">{{$product->pivot->current_wholesale_quantity}}</td>
                                                <td class="pt-6">{{$product->pivot->current_unit_quantity}}</td>
                                                <td class="pt-6">{{$product->pivot->wholesale_returned_quantity == null ? 0 : $product->pivot->wholesale_returned_quantit}}</td>
                                                <td class="pt-6">{{$product->pivot->unit_returned_quantity == null ? 0 : $product->pivot->unit_returned_quantity}}</td>
                                                <td class="pt-6">{{$product->pivot->wholesale_price}}</td>
                                                <td class="pt-6">{{$product->pivot->unit_price}}</td>
                                                <td class="pt-6">{{$product->pivot->total}}</td>
                                                <?php
                                                    $total_item_discount[] = $product->pivot->item_discount;
                                                    $total_wholesale_discount[] = $product->pivot->wholesale_discount;
                                                ?>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td class="text-center w-10px pe-2"></td>
                                            <td class="text-center w-10px pe-2"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px">السعر قبل التوصيل</td>
                                            <td class="text-center w-80px">{{$order->sub_total}} جنيه</td>
                                            {{-- <td class="text-center w-80px"></td> --}}
                                        </tr>
                                        <tr>
                                            <td class="text-center w-10px pe-2"></td>
                                            <td class="text-center w-10px pe-2"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px">مصاريف التوصيل </td>
                                            <td class="text-center w-80px">{{$order->fee}} جنيه</td>
                                            {{-- <td class="text-center w-80px"></td> --}}
                                        </tr>
                                        <tr>
                                            <td class="text-center w-10px pe-2"></td>
                                            <td class="text-center w-10px pe-2"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px">المسافه بالكيلو </td>
                                            <td class="text-center w-80px">{{$order->distance}} كيلو</td>
                                            {{-- <td class="text-center w-80px"></td> --}}
                                        </tr>
                                        <tr>
                                            <td class="text-center w-10px pe-2"></td>
                                            <td class="text-center w-10px pe-2"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px">المكافأه الفورى</td>
                                            <td class="text-center w-80px"><input onclick="addDiscount({{$order->id}})" class="form-control discount" name="discount_price" value="{{$order->discount_price == null ? 0 : $order->discount_price }}"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center w-10px pe-2"></td>
                                            <td class="text-center w-10px pe-2"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px">اجمالى الخصم على المنتجات</td>
                                            <td class="text-center w-80px">{{array_sum($total_item_discount) + array_sum($total_wholesale_discount)}} جنيه</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center w-10px pe-2"></td>
                                            <td class="text-center w-10px pe-2"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px">كوبون الخصم</td>
                                            <td class="text-center w-80px">{{$order->promo ? $order->promo->value : 0}} جنيه</td>
                                            {{-- <td class="text-center w-80px"></td> --}}
                                        </tr>
                                        <tr>
                                            <td class="text-center w-10px pe-2"></td>
                                            <td class="text-center w-10px pe-2"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px">كاش باك</td>
                                            <td class="text-center w-80px">{{$wallet->value}}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center w-10px pe-2"></td>
                                            <td class="text-center w-80px">{{isset($status) ? 'الحاله': ''}}</td>
                                            <td class="text-center w-80px">
                                                @if(isset($status))
                                                    <select name="status" class="form-select form-select-lg mb-3 status">
                                                        @foreach ($status as $state)
                                                            <option value="{{$state}}" {{$order->status == $state ? 'selected' : ''}}>{{$state}}</option>
                                                        @endforeach
                                                    </select>
                                                @else
                                                    <button onclick="confirm({{$order->id}})" class="btn btn-success">تأكيد الطلب</button>
                                                @endif
                                            </td>
                                            <td class="text-center w-80px">
                                                @if(isset($status))
                                                    <button onclick="saveChanges({{$order->id}})" class="btn btn-success">حفظ التغييرات</button>
                                                @else
                                                    <button data-url='/admin/orders/{{$order->id}}' class="btn btn-danger cancel">الفاء الطلب</button>
                                                @endif
                                            </td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px"></td>
                                            <td class="text-center w-80px">الاجمالى </td>
                                            <td class="text-center w-80px">
                                                    {{$order->total - $order->discount_price  - ($order->promo ? $order->promo->value : 0)}} جنيه
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="returns-model" role="dialog">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">تفاصبل المرتجعات</h5>
                </div>
                <div class="modal-body">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_role_table">
                        <thead>
                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                <th class="text-center w-80px">المنتج</th>
                                <th class="text-center w-80px">الكميه المرتجعه جمله</th>
                                <th class="text-center w-80px">الكميه المرتجعه قطاعى</th>
                                <th class="text-center w-80px">باجمالى سعر</th>
                            </tr>
                        </thead>
                        <tbody class="fw-bold text-gray-600">
                            @foreach ($order->custodies  as $custody)
                                <tr>
                                    <td class="text-center">{{$custody->product->name}}</td>
                                    <td class="text-center">{{$custody->wholesale_quantity}} {{$custody->product->wholesale_type}}</td>
                                    <td class="text-center">{{$custody->unit_quantity}} {{$custody->product->item_type}}</td>
                                    <td class="text-center">{{$custody->total}} جنيه</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="hideModele()">اغلاق</button>
                </div>
            </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
<script type="text/javascript" src="/assets/js/jquery.printPage.js"></script>
    <script>
        setTimeout(function() {
            $('.flash').fadeOut('fast');
        }, 3000);

        function hideModele(){
            $('#returns-model').modal('hide')
        }
        function show() {
            console.log('ghfrtghtyh');
            $('#returns-model').modal('show')
        }

        function saveChanges(id){
            wholesale_quantity = [];
            $('.current_wholesale_quantity').each(function(index){
                var input = $(this);
                wholesale_quantity.push([input.attr('id'),input.val()]);
            });
            unit_quantity = [];
            $('.current_unit_quantity').each(function(index){
                var input = $(this);
                unit_quantity.push([input.attr('id'),input.val()]);
            });

            let messages = 'تم تغيير الحاله بنجاح';
            let order_id = id;
            let status   = $('.status :selected').val();
            $.ajax({
                url: "{{url('admin/change-status-order')}}",
                type: 'POST',
                data: {
                    _method : 'POST',
                    _token : '{{ csrf_token() }}',
                    status:status,
                    order_id:order_id,
                    wholesale_quantity:wholesale_quantity,
                    unit_quantity:unit_quantity,
                },
                success: function (res) {
                    if (res.status == false) {
                        alert(res.message)
                    }else{
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title:res.message ,
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                    getOrderDetails(order_id);
                }
            });
        }
        function confirm(id){
            wholesale_quantity = [];
            $('.current_wholesale_quantity').each(function(index){
                var input = $(this);
                wholesale_quantity.push([input.attr('id'),input.val()]);
            });
            unit_quantity = [];
            $('.current_unit_quantity').each(function(index){
                var input = $(this);
                unit_quantity.push([input.attr('id'),input.val()]);
            });
            let order_id = id;
            let total   = $('.total').val();
            $.ajax({
                url: "{{url('admin/confirm-order')}}",
                type: 'POST',
                data: {
                    _method : 'POST',
                    _token : '{{ csrf_token() }}',
                    total:total,
                    order_id:order_id,
                    wholesale_quantity:wholesale_quantity,
                    unit_quantity:unit_quantity,
                },
                success: function (res) {
                    if (res.status == false) {
                        alert(res.message)
                    }else{
                        Swal.fire({
                            icon: 'success',
                            title: 'تم تأكيد الطلب',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        var baseUrl = window.location.origin;
                        window.location.href =  baseUrl + '/admin/orders';
                    }
                }
            });
        }

        $('.cancel').click(function(event){
            Swal.fire({
                    title: 'هل انت متأكد؟',
                    text: "لن تتمكن من التراجع عن هذا!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'نعم !',
                    cancelButtonText: 'الغاء',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: $(this).data('url'),
                        type: 'POST',
                        data: {
                            _method : 'DELETE',
                            _token : $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (res) {
                            console.log(res)
                            if (result.value) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'تم الالغاء',
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                var baseUrl = window.location.origin;
                                window.location.href =  baseUrl + '/admin/orders';
                            }
                        }
                    });
                }
            })
        });

        function getOrderDetails(id){
            $.ajax({
                url: "/admin/orders/"+id,
                type: 'GET',
                data: {
                    _method : 'GET',
                    _token : '{{ csrf_token() }}',
                    id:id,
                },
                success: function (res) {
                    $('.order-table').html('').append(res);
                }
            });
        }
        $(document).ready(function(){
            $('.btnprn').printPage();
        });

        function addDiscount(order_id){
            $(document).keypress(function(e) {
                if(e.which == 13) {
                    let direct_discount = $('.discount').val();
                    Swal.fire({
                            title: 'هل انت متأكد؟',
                            text: "لن تتمكن من التراجع عن هذا!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'نعم !',
                            cancelButtonText: 'الغاء',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '/admin/direct-discount',
                                type: 'POST',
                                data: {
                                    _method : 'POST',
                                    _token : $('meta[name="csrf-token"]').attr('content'),
                                    order_id : order_id,
                                    direct_discount : direct_discount,
                                },
                                success: function (res) {
                                    console.log(res)
                                    if (result.value) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'تم اضافه خصم',
                                            showConfirmButton: false,
                                            timer: 1500
                                        })
                                        location.reload();
                                    }
                                }
                            });
                        }
                    })
                }
            });
        }

        function dropCustodies(order_id){
            Swal.fire({
                    title: 'هل تريج اسقاط العهده من السائق؟',
                    text: "لن تتمكن من التراجع عن هذا!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'نعم !',
                    cancelButtonText: 'الغاء',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/admin/drop-custodies",
                        type: 'Post',
                        data: {
                            _method : 'Post',
                            _token : '{{ csrf_token() }}',
                            order_id:order_id,
                        },
                        success: function (res) {
                            if (result.value) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'تم استلام العهده من السائق',
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                var baseUrl = window.location.origin;
                                window.location.href =  baseUrl + "/admin/orders/"+order_id;
                            }

                        }
                    });
                }
            })
        }

    </script>
@endsection

