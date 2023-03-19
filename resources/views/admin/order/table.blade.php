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
        <td class="pt-6">{{$product->pivot->wholesale_returned_quantity}}</td>
        <td class="pt-6">{{$product->pivot->unit_returned_quantity}}</td>
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
    {{-- <td class="text-center w-80px"></td> --}}
</tr>
<tr>
    <td class="text-center w-10px pe-2"></td>
    <td class="text-center w-80px">الحاله</td>
    <td class="text-center w-80px">
        <select name="status" class="form-select form-select-lg mb-3 status">
            @foreach ($status as $state)
                <option value="{{$state}}" {{$order->status == $state ? 'selected' : ''}}>{{$state}}</option>
            @endforeach
        </select>
    </td>
    <td class="text-center w-80px">
        <button onclick="saveChanges({{$order->id}})" class="btn btn-success">حفظ التغييرات</button>
    </td>
    <td class="text-center w-80px"></td>
    <td class="text-center w-80px"></td>
    <td class="text-center w-80px"></td>
    <td class="text-center w-80px"></td>
    <td class="text-center w-80px"></td>
    <td class="text-center w-80px">الاجمالى </td>
    <td class="text-center w-80px">{{$order->total - $order->discount_price  - ($order->promo ? $order->promo->value : 0)}} جنيه جنيه</td>
    {{-- <td class="text-center w-80px"></td> --}}
</tr>
