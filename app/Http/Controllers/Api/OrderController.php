<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\OrderProductResource;
use App\Http\Resources\Api\OrderResource;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Shop;
use App\Models\Store;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\Double;

class OrderController extends Controller
{
    use ApiResponse;

    public function createOrder(Request $request){
        $cart = Cart::with('products')->where('shop_id',$request->user()->shop_id)->first();
        if(!$cart)
            return $this->error('لا يمكنك انشاء طلب والسله فاضيه يا بيه',422);
        $shop = Shop::where('id',$request->user()->shop_id)->select('longitude','latitude')->first();
        $store = Store::where('id',$request->user()->store_id)->select('longitude','latitude')->first();
        $distance =  $this->getDistanceBetweenPointsNew($shop->latitude,$shop->longitude ,$store->latitude , $store->longitude);

        $order = Order::create([
            'shop_id'       => $cart->shop_id,
            'store_id'      => $cart->store_id,
            'sub_total'     => $cart->sub_total,
            'total'         => 0,
            'distance'      => (Double) number_format($distance),
            'fee'           => 10,
            'status'        => 'معلق',
            'user_id'        => $request->auth()->user()->id,
        ]);
        $this->addOrderProducts($order,$cart);
        $this->removeCart($cart);
        return $this->successSingle('تم انشاء الطلب بنجاح',[],200);
    }

    public function addOrderProducts($order,$cart){
        $total = [];
        foreach($cart->products as $product){
            $products = OrderProduct::create([
                'order_id'                       => $order->id,
                'product_id'                     => $product->id,
                'shop_id'                        => $cart->shop_id,
                'current_unit_quantity'          => $product->pivot->unit_quantity,
                'current_wholesale_quantity'     => $product->pivot->wholesale_quantity,
                'past_unit_quantity'             => $product->pivot->unit_quantity,
                'past_wholesale_quantity'        => $product->pivot->wholesale_quantity,
                'unit_price'                     => $product->pivot->unit_price,
                'wholesale_price'                => $product->pivot->wholesale_price,
                'total'                          => $product->pivot->unit_total + $product->pivot->wholesale_total ,
            ]);
            $total[]= $products->total;
        }
        $order->update(['total' => array_sum($total) + ($order->fee * $order->distance)]);
    }

    function removeCart($cart){
        CartProduct::where('cart_id', $cart->id)->delete();
        $cart->delete();
    }

    public function cancelOrder(Request $request){
        $order = Order::where('id',$request->order_id)->first();
        if($order->status == 'جاري المعالجه' || $order->status == 'معلق'){
            $order->update(['status'=>'تم الالغاء']);
            return $this->successSingle('تم الغاء الطلب بنجاح',[],200);
        }else{
            return $this->error('هذا الطلب لا يمكن الغاءه',422);
        }
    }

    public function getOrders(Request $request){
        $orders = Order::where('shop_id',$request->user()->shop_id)->paginate(6);
        $orders = OrderResource::collection($orders)->response()->getData(true);
        return $this->success('تم بنجاح',$orders,200);
    }

    public function getOrderProducts(Request $request){
        $order = Order::where('id',$request->order_id)->first();
        $products = Product::whereHas('orders',function($q) use($request){
            $q->where('orders_products.order_id',$request->order_id);
        })->with(['orders'=>function($q) use($request){
            $q->where('order_id',$request->order_id);
        }])->paginate(6);
        $products = OrderProductResource::collection($products)->response()->getData(true);
        return $this->success('تم بنجاح',['order_total'=>$order->total,'products'=>$products],200);
    }

    function getDistanceBetweenPointsNew($latitude1, $longitude1, $latitude2, $longitude2) {
        $theta = $longitude1 - $longitude2;
        $miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $kilometers = $miles * 1.609344;
        return $kilometers;
    }
}
