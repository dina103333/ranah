<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\OrderProductResource;
use App\Http\Resources\Api\OrderResource;
use App\Models\Admin;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Discount;
use App\Models\DiscountProduct;
use App\Models\Order;
use App\Models\OrderDiscount;
use App\Models\OrderProduct;
use App\Models\Point;
use App\Models\Product;
use App\Models\PromoCode;
use App\Models\Setting;
use App\Models\Shop;
use App\Models\Store;
use App\Models\StoreProduct;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletValue;
use App\Notifications\OrderNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;


class OrderController extends Controller
{
    use ApiResponse;

    public function createOrder(Request $request){

        $cart = Cart::with('products')->where('shop_id',$request->user()->shop_id)->first();
        if(!$cart)
            return $this->error('لا يمكنك انشاء طلب والسله فاضيه يا بيه',422);
        $shop = Shop::where('id',$request->user()->shop_id)->select('store_id','longitude','latitude')->first();
        $store = Store::where('id',$shop->store_id)->select('id','longitude','latitude')->first();
        $distance = $this->getDistanceBetweenPointsNew($shop->latitude,$shop->longitude,$store->latitude, $store->longitude);
        $discount = Discount::where('status','تفعيل')->where('from','<=',Carbon::now()->format('Y-m-d'))->where('to','>=',Carbon::now()->format('Y-m-d'))->first();
        $wallet = Wallet::where('user_id',$request->user()->id)->first();
        $promo_code = PromoCode::where('status','تفعيل')->where('name',$request->promo_code)->first();
        $order = Order::create([
            'shop_id'       => $cart->shop_id,
            'store_id'      => $cart->store_id,
            'sub_total'     => $cart->sub_total,
            'total'         => 0,
            'total_cost'    => 0,
            'distance'      => (Double) number_format($distance),
            'fee'           => Setting::where('key','سعر الشحن للكيلو الواحد')->first()->value,
            'status'        => 'معلق',
            'user_id'       => $request->user()->id,
            'promo_code_id' => $promo_code ? $promo_code->id : null,
            'discount_id'   => $discount ? $discount->id : null,
            'discount_price'   => $discount ? ($discount->type == 'فورى' ? ($discount->value == null ? ($cart->sub_total * ($discount->ratio/100))  : $discount->value)  :  null) : null,
        ]);
        if($discount && $discount->type == 'مؤجل'){
            $this->addWalletValue($discount,$cart,$wallet);
        }
        $this->addPoints($cart,$request);
        // $this->sendNotification($order,$request);
        return $this->addOrderProducts($order,$cart,$store,$wallet,$request);
    }

    function sendNotification($order,$request){
        updateFirebaseNotification('+', '1');
        $message = 'باضافه طلب جديد'.' '.$request->user()->name.' لقد قام ';
        addFirebaseNotification($order->id,$message);
    }

    function addWalletValue($discount,$cart,$wallet){
        $total_discount = $discount->value == null ? ($cart->sub_total * ($discount->ratio/100))  : $discount->value;
        $wallet->update([
            'hold_value' => $wallet->hold_value + $total_discount
        ]);
        WalletValue::create([
            'wallet_id' => $wallet->id,
            'value' =>  $total_discount,
            'type' => 'خصم',
            'active' => false,
        ]);
    }

    function addPoints($cart,$request){
        $points = Point::where('status','تفعيل')->get();
        if($points){
            $user_points = [];
            foreach ($points as $point) {
                if($point->from <= $cart->sub_total && $point->to >= $cart->sub_total){
                    $user_points[] = $point->point ;
                }
            }
            $request->user()->update(['points'=>array_sum($user_points)]);
        }
    }

    public function addOrderProducts($order,$cart,$store,$wallet,$request){
        $total = [];
        $cost_total = [];
        foreach($cart->products as $product){
            $store_product = StoreProduct::where('product_id',$product->id)->where('store_id',$store->id)->first();
            if($store_product->max_limit !=0 ){
                if($store_product->lower_limit > $product->pivot->wholesale_quantity || $store_product->max_limit < $product->pivot->wholesale_quantity ){
                    OrderProduct::where('order_id',$order->id)->delete();
                    $order->delete();
                    return $this->error('لا يمكن الطلب بهذه الكميه علما بأن اقصى كميه متاحه واقل كميه من ال'.$product->name . 'هى '.$store_product->lower_limit .'و'.$store_product->max_limit );
                }
            }
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
                'total'                          => $product->pivot->unit_total + $product->pivot->wholesale_total  ,
                'unit_buy_price'                 => $store_product->buy_price / $product->wholesale_quantity_units ,
                'wholesale_buy_price'            => $store_product->buy_price ,
                'total_cost'                     => ($store_product->buy_price * $product->pivot->wholesale_quantity) + (($store_product->buy_price / $product->wholesale_quantity_units) * $product->pivot->unit_quantity),
            ]);
            $this->addDiscountProduct($product , $order, $request,$wallet,$products);
            $total[] = $products->total - ($products->item_discount + $products->wholesale_discount);
            $cost_total[] = $products->total_cost;
            $this->updateStoreQuantity($product , $store_product);
        }
        $this->updateOrderTotal($total,$wallet,$order,$cost_total);
        $this->removeCart($cart);
        return $this->successSingle('تم انشاء الطلب بنجاح',[],200);
    }

    function updateStoreQuantity($product , $store_product){
        if($product->pivot->wholesale_quantity != 0 ){
            $store_product->update([
                'wholesale_quantity' => $store_product->wholesale_quantity - $product->pivot->wholesale_quantity,
                'unit_quantity' =>  $store_product->unit_quantity - (($product->pivot->wholesale_quantity * $product->wholesale_quantity_units)+ $product->pivot->unit_quantity),
            ]);
        }else{
            $store_product->update([
                'wholesale_quantity' => $store_product->wholesale_quantity - intval(($product->pivot->unit_quantity/$product->wholesale_quantity_units)),
                'unit_quantity' => $store_product->unit_quantity - $product->pivot->unit_quantity,
            ]);
        }
    }

    function addDiscountProduct($product , $order, $request,$wallet,$products){
        $product_discount = DiscountProduct::where('product_id',$product->id)->where('store_id',$order->store_id)
                            ->where('status','تفعيل')->get();
        if($product_discount){
            foreach($product_discount as $discount){
                if($discount->from_item_total <= $product->pivot->unit_total || $discount->from_wholesale_total <= $product->pivot->wholesale_total ){
                    $wholesale_total_discount = $discount->wholesale_value == null ? ($product->pivot->wholesale_total * ($discount->wholesale_ratio/100))  : $discount->wholesale_value;
                    $item_total_discount = $discount->item_value == null ? ($product->pivot->unit_total * ($discount->item_ratio/100))  : $discount->item_value;
                    OrderDiscount::create([
                        'product_id' => $product->id,
                        'order_id' => $order->id,
                        'user_id' => $request->user()->id,
                        'discount_id' => $discount->id,
                        'active' => $discount->type == 'فورى' ? true : false,
                        'value' => $wholesale_total_discount + $item_total_discount,
                    ]);
                    if($discount->type == 'مؤجل' ){
                        $wallet->update([
                            'hold_product_value' => $wallet->hold_value + ($wholesale_total_discount + $item_total_discount)
                        ]);
                        WalletValue::create([
                            'wallet_id' => $wallet->id,
                            'value' =>  $wholesale_total_discount + $item_total_discount,
                            'type' => 'خصم',
                            'active' => false,
                        ]);
                    }else{
                        $products->update([
                            'item_discount' => $item_total_discount,
                            'wholesale_discount' => $wholesale_total_discount,
                        ]);
                    }
                }
            }
        }

    }

    function updateOrderTotal($total,$wallet,$order,$cost_total){
        $order_total = (array_sum($total) + ($order->fee * $order->distance)) > $wallet->value ?  (array_sum($total) + ($order->fee * $order->distance)) - $wallet->value : 0;
        $order->update(['total' => $order_total ,'total_cost'=>array_sum($cost_total)]);

        if((array_sum($total) + ($order->fee * $order->distance)) > $wallet->value ){
            $wallet->update(['value' => 0]);
            WalletValue::create([
                'wallet_id' => $wallet->id,
                'value' => $wallet->value,
                'type' => 'دفع فاتوره',
                'active' => false,
            ]);
        }else{
            $wallet->update(['value' => $wallet->value - (array_sum($total) + ($order->fee * $order->distance))]);
            WalletValue::create([
                'wallet_id' => $wallet->id,
                'value' => (array_sum($total) + ($order->fee * $order->distance)),
                'type' => 'دفع فاتوره',
                'active' => false,
            ]);
        }
    }

    function removeCart($cart){
        CartProduct::where('cart_id', $cart->id)->delete();
        $cart->delete();
    }

    public function cancelOrder(Request $request){
        $order = Order::where('id',$request->order_id)->first();
        if($order->status == 'جاري المعالجه' || $order->status == 'معلق'){
            $order_products =OrderProduct::where('order_id',$request->order_id)->get();
            foreach($order_products as $product){
                $store_product = StoreProduct::where('product_id',$product->product_id)->where('store_id',$order->store_id)->first();
                $product_data = Product::where('id',$product->product_id)->first();
                $store_product->update([
                    'wholesale_quantity' => ($store_product->wholesale_quantity + $product->current_wholesale_quantity) +
                    intval(($store_product->wholesale_quantity + ($product->current_unit_quantity / $product_data->wholesale_quantity_units))),
                    'unit_quantity' => ($store_product->unit_quantity + ($product->current_wholesale_quantity * $product_data->wholesale_quantity_units)) +
                    ($store_product->unit_quantity + $product->current_unit_quantity)
                    ,
                ]);
            }
            $order->update(['status'=>'تم الالغاء']);
            return $this->successSingle('تم الغاء الطلب بنجاح',[],200);
        }else{
            return $this->error('هذا الطلب لا يمكن الغاءه',422);
        }
    }

    public function getOrders(Request $request){
        $orders = Order::withSum('discounts','value')->with(['promo'=>function($q){
            $q->withTrashed()->select('id','value');
        }])->where('shop_id',$request->user()->shop_id)
        ->orderBy('id','desc')->paginate(6);
        $orders = OrderResource::collection($orders)->response()->getData(true);
        return $this->success('تم بنجاح',$orders,200);
    }

    public function getOrderProducts(Request $request){
        $order_details = Order::where('id',$request->order_id)
        ->withSum('discounts','value')
        ->with(['products.discounts'=>function($q) use ($request){
            $q->join('discount_products',function($join){
                $join->on('discount_products.id','order_discounts.discount_id');
                $join->on('discount_products.product_id','order_discounts.product_id');
            })->where('order_discounts.order_id',$request->order_id);
        },'promo'=>function($q){
            $q->withTrashed()->select('id','value');
        }])->first();
        $products = OrderProductResource::make($order_details);
        return $this->successSingle('تم بنجاح',$products,200);
    }

    function getDistanceBetweenPointsNew($lat1, $lon1, $lat2, $lon2) {
        $R = 6371;
        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);

        $dLat = $lat2 - $lat1;
        $dLon = $lon2 - $lon1;

        $a = sin($dLat / 2) * sin($dLat / 2) + cos($lat1) * cos($lat2) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = $R * $c;
        return $distance;
    }

}
