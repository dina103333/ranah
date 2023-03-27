<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DriectOrderRequest;
use App\Jobs\SendFCMNotificationJob;
use App\Models\Contact;
use App\Models\Custody;
use App\Models\Discount;
use App\Models\DiscountProduct;
use App\Models\Driver;
use App\Models\Order;
use App\Models\OrderDiscount;
use App\Models\OrderProduct;
use App\Models\OrderReturn;
use App\Models\Point;
use App\Models\Product;
use App\Models\PromoCode;
use App\Models\Setting;
use App\Models\Shop;
use App\Models\Store;
use App\Models\StoreProduct;
use App\Models\Treasury;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletValue;
use Carbon\Carbon;
use Facade\FlareClient\View;
use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Report\Xml\Totals;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!in_array(62,permissions())){
            abort(403);
        }
        if(auth()->user()->type == 'المسؤول العام'){
            $orders = Order::select('*',\DB::raw("(DATE_FORMAT(created_at,'%Y-%m-%d')) as created_date")
            ,\DB::raw("(DATE_FORMAT(updated_at,'%Y-%m-%d')) as delivered_date"))
            ->with('user:id,name','driver:id,name','shop:id,area_id','shop.area:id,name','store:id,name')
            ->paginate(10);
            $stores = Store::where('status','تفعيل')->select('id','name')->get();
        }else{
            $orders = Order::where('store_id',auth()->user()->store_id)
            ->select('*',\DB::raw("(DATE_FORMAT(created_at,'%Y-%m-%d')) as created_date")
            ,\DB::raw("(DATE_FORMAT(updated_at,'%Y-%m-%d')) as delivered_date"))
            ->with('user:id,name','driver:id,name','shop:id,area_id','shop.area:id,name','store:id,name')
            ->paginate(10);
            $stores = Store::where('status','تفعيل')->where('id',auth()->user()->store_id)->select('id','name')->get();
        }
        updateFirebaseNotification('0', '0');
        return view('admin.order.index',compact('orders','stores'));
    }

    public function getOrders()
    {
        if(auth()->user()->type == 'المسؤول العام'){
            $orders = Order::select('*',\DB::raw("(DATE_FORMAT(created_at,'%Y-%m-%d')) as created_date")
            ,\DB::raw("(DATE_FORMAT(updated_at,'%Y-%m-%d')) as delivered_date"))
            ->with('user:id,name','driver:id,name','shop:id,area_id','shop.area:id,name','store:id,name')
            ->get();
        }else{
            $orders = Order::where('store_id',auth()->user()->store_id)
            ->select('*',\DB::raw("(DATE_FORMAT(created_at,'%Y-%m-%d')) as created_date")
            ,\DB::raw("(DATE_FORMAT(updated_at,'%Y-%m-%d')) as delivered_date"))
            ->with('user:id,name','driver:id,name','shop:id,area_id','shop.area:id,name','store:id,name')
            ->get();
        }
        return datatables($orders)->make(true);
    }

    public function storeDrivers(Request $request){
        $drivers = Driver::where('store_id',$request->store_id)->select('id','name','store_id')->get();
        return $drivers;
    }


    public function assignDriver(Request $request){
        Order::whereIn('id',$request->arr)->update([
            'driver_id' => $request->driver_id,
            'status' => 'في الطريق'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!in_array(107,permissions())){
            abort(403);
        }
        $stores = Store::where('status', 'تفعيل')->get();
        return view('admin.direct_order.create',compact('stores'));
    }

    public function getStorUsers($store_id){
        $users = User::where('store_id', $store_id)->select('id','name')->get();
        $products = Product::where('status','تفعيل')->whereHas('stores',function($q) use($store_id){
            $q->where('stores_products.store_id', $store_id)->where('stores_products.wholesale_quantity','!=',0)
            ->where('stores_products.sell_wholesale_price','!=',null)
            ->where('stores_products.wholesale_quantity','!=',null);
        })
        ->with('stores',function($q) use($store_id){
            $q->where('stores_products.store_id', $store_id)
            ->where('stores_products.wholesale_quantity','!=',0)
            ->where('stores_products.sell_wholesale_price','!=',null)
            ->where('stores_products.wholesale_quantity','!=',null)
            ->select('stores.id');
        })->select('id','name')->get();
        return response()->json(['users' => $users, 'products' => $products]);
    }

    public function getProductDetails(Request $request,$product_id){
        $product_details = StoreProduct::where('product_id', $product_id)
                                        ->where('store_id', $request->store_id)
                                        ->join('products','products.id','stores_products.product_id')
                                        ->where('stores_products.sell_wholesale_price','!=',null)
                                        ->where('products.status','تفعيل')
                                        ->where('products.is_available_for_order',true)
                                        ->first();
        return  response()->json($product_details);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DriectOrderRequest $request)
    {
        $products = array_filter($request->products);

        if(empty($products)  || (empty(array_filter($request->wholesale_quantity)) && empty(array_filter($request->unit_quantity))  )){
            return redirect()->back()->with('error','يجب اخنيار المنتجات مع تحديد كيمه لها');
        }
        $user = User::where('id',$request->user_id)->first();
        $shop = Shop::where('id',$user->shop_id)->select('store_id','longitude','latitude')->first();
        $store = Store::where('id',$request->store_id)->first();
        $distance = $this->getDistanceBetweenPointsNew($shop->latitude,$shop->longitude,$store->latitude, $store->longitude);
        $discount = Discount::where('status','تفعيل')->where('from','<=',Carbon::now()->format('Y-m-d'))->where('to','>=',Carbon::now()->format('Y-m-d'))->first();
        $wallet = Wallet::where('user_id',$request->user_id)->first();
        $promo_code = PromoCode::where('status','تفعيل')->where('name',$request->promo_code)->first();
        $order = Order::create([
            'shop_id'       => $user->shop_id,
            'store_id'      => $request->store_id,
            'sub_total'     => 0,
            'total'         => 0,
            'total_cost'    => 0,
            'distance'      => (Double) number_format($distance),
            'fee'           => Setting::where('key','سعر الشحن للكيلو الواحد')->first()->value,
            'status'        => 'معلق',
            'type'          => 'مباشر',
            'user_id'       => $request->user_id,
            'promo_code_id' => $promo_code ? $promo_code->id : null,
            'discount_id'   => $discount ? $discount->id : null,
        ]);
        if($discount && $discount->type == 'مؤجل'){
            $this->addWalletValue($discount,$order,$wallet);
        }
        $this->addOrderProducts($request,$order,$store,$products,$discount,$wallet,$user);
        $order = Order::withSum('discounts','value')->with(['promo'=>function($q){
            $q->withTrashed()->select('id','value');
        },'shop:id,name','user:id,name,mobile_number'
        ,'store:id,name','products'])->where('id',$order->id)->first();
        return View('admin.order.show',compact('order','wallet'));
    }

    function addWalletValue($discount,$order,$wallet){
        $total_discount = $discount->value == null ? ($order->sub_total * ($discount->ratio/100))  : $discount->value;
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
    function addPoints($order,$user){
        $points = Point::where('status','تفعيل')->get();
        if($points){
            $user_points = [];
            foreach ($points as $point) {
                if($point->from <= $order->sub_total && $point->to >= $order->sub_total){
                    $user_points[] = $point->point ;
                }
            }
            $user->update(['points'=>array_sum($user_points)]);
        }
    }

    public function addOrderProducts($request,$order,$store,$products,$discount,$wallet,$user){
        $wholesale_quantity = array_filter($request->wholesale_quantity, fn ($value) => !is_null($value));
        $unit_quantity = array_filter($request->unit_quantity, fn ($value) => !is_null($value));
        $total=[];
        $cost_total = [];
        foreach($products as $key=>$product){
            $store_product = StoreProduct::where('product_id',$product)->where('store_id',$store->id)->first();
            $product_data = Product::where('id',$product)->select('id','wholesale_quantity_units')->first();
            if($store_product->max_limit !=0 ){
                if($store_product->lower_limit > $wholesale_quantity[$key] || $store_product->max_limit < $wholesale_quantity[$key] ){
                    OrderProduct::where('order_id',$order->id)->delete();
                    $order->delete();
                    return response()->json(['status'=>false,'message'=>'لا يمكن الطلب بهذه الكميه علما بأن اقصى كميه متاحه واقل كميه من ال'.$product->name . 'هى '.$store_product->lower_limit .'و'.$store_product->max_limit]);
                }
            }
            $products = OrderProduct::create([
                'order_id'                       => $order->id,
                'product_id'                     => $product,
                'shop_id'                        => $order->shop_id,
                'current_unit_quantity'          => $unit_quantity[$key] ,
                'current_wholesale_quantity'     => $wholesale_quantity[$key] ,
                'past_unit_quantity'             => $unit_quantity[$key] ,
                'past_wholesale_quantity'        => $wholesale_quantity[$key] ,
                'unit_price'                     => $store_product->sell_item_price,
                'wholesale_price'                => $store_product->sell_wholesale_price,
                'total'                          => ($wholesale_quantity[$key]  * $store_product->sell_wholesale_price) + ($unit_quantity[$key] *$store_product->sell_item_price ),
                'unit_buy_price'                 => $store_product->buy_price / $product_data->wholesale_quantity_units ,
                'wholesale_buy_price'            => $store_product->buy_price ,
                'total_cost'                     => ($store_product->buy_price * $wholesale_quantity[$key]) + (($store_product->buy_price / $product_data->wholesale_quantity_units) * $unit_quantity[$key]),
            ]);
            $this->addDiscountProduct($product,$order,$wallet,$products);
            $total[] = $products->total - ( $products->item_discount  + $products->wholesale_discount );
            $cost_total[] = $products->total_cost;
            $this->updateStoreQuantity($wholesale_quantity ,$store_product,$key,$product_data,$unit_quantity);
        }
        $this->updateOrderTotal($total,$wallet,$order,$discount,$cost_total);
        $this->addPoints($order,$user);
    }

    function updateStoreQuantity($wholesale_quantity ,$store_product,$key,$product_data,$unit_quantity){
        if($wholesale_quantity != 0 ){
            $store_product->update([
                'wholesale_quantity' => $store_product->wholesale_quantity - $wholesale_quantity[$key] ,
                'unit_quantity' =>  $store_product->unit_quantity - (($wholesale_quantity[$key]  * $product_data->wholesale_quantity_units) + $unit_quantity[$key]),
            ]);
        }else{
            $store_product->update([
                'wholesale_quantity' => $store_product->wholesale_quantity - intval(($unit_quantity[$key] /$product_data->wholesale_quantity_units)),
                'unit_quantity' => $store_product->unit_quantity - $unit_quantity[$key] ,
            ]);
        }
    }
    function addDiscountProduct($product , $order,$wallet,$products){

        $product_discount = DiscountProduct::where('product_id',$product)->where('store_id',$order->store_id)
                            ->where('status','تفعيل')->get();
        if($product_discount){
            foreach($product_discount as $discount){
                $unit_total = $products->unit_price * $products->current_unit_quantity;
                $wholesale_total = $products->wholesale_price * $products->current_wholesale_quantity;
                if($discount->from_item_total <= $unit_total || $discount->from_wholesale_total <= $wholesale_total ){
                    $wholesale_total_discount = $discount->wholesale_value == null ? ($wholesale_total * ($discount->wholesale_ratio/100))  : $discount->wholesale_value;
                    $item_total_discount = $discount->item_value == null ? ($unit_total * ($discount->item_ratio/100))  : $discount->item_value;
                    OrderDiscount::create([
                        'product_id' => $product,
                        'order_id' => $order->id,
                        'user_id' => $order->user_id,
                        'discount_id' => $discount->id,
                        'active' => $discount->type == 'فورى' ? true : false,
                        'value' => $wholesale_total_discount + $item_total_discount,
                    ]);
                    if($discount->type == 'مؤجل' ){
                        return 'dfdsfsdfsdfdfsd';
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
                            'item_discount' => $products->current_unit_quantity != 0.0 ? $item_total_discount : 0 ,
                            'wholesale_discount' => $products->current_wholesale_quantity != 0 ? $wholesale_total_discount : 0 ,
                        ]);
                        return $products;
                    }
                }
            }
        }

    }

    function updateOrderTotal($total,$wallet,$order,$discount,$cost_total){
       return $order_total = (array_sum($total) + ($order->fee * $order->distance)) > $wallet->value ?  (array_sum($total) + ($order->fee * $order->distance)) - $wallet->value : 0;
        $order->update(['sub_total'=>array_sum($total) ,'total' => $order_total,'total_cost'=>$cost_total,
        'discount_price'   => $discount ? ($discount->type == 'فورى' ? ($discount->value == null ? (array_sum($total) * ($discount->ratio/100))  : $discount->value)  :  null) : null]);

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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,Order $order)
    {
        if(!in_array(208,permissions())){
            abort(403);
        }
        $order = Order::withSum('discounts','value')->with(['promo'=>function($q){
            $q->withTrashed()->select('id','value');
        },'shop:id,name','user:id,name,mobile_number'
        ,'store:id,name','custodies.product','returns'=>function($q){
            $q->where('status','قيد الانتظار');
        },'products'])->where(function($q) use($request,$order){
            if($request->id){
                $q->where('id',$request->id);
            }else{
                $q->where('id',$order->id);
            }
        })->first();
        $wallet = Wallet::where('user_id',$order->user_id)->first();
        $status = Order::getEnumValues('orders','status');
        if($request->ajax()){
            return View('admin.order.table',compact('order','status','wallet'));
        }
        return View('admin.order.show',compact('order','status','wallet'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */

    public function changeStatus(Request $request){
        $order= Order::where('id',$request->order_id)->first();
        $order->update([
            'status'=>$request->status
        ]);
        $wallet = Wallet::where('user_id',$order->user_id)->first();
        $user = User::where('id',$order->user_id)->first();
        $response =  $this->updateOrderProducts($request,$order,$wallet);
        if($response['status'] == true ){
            $total = $response['total'];
            $discount = Discount::where('status','تفعيل')->where('from','<=',Carbon::now()->format('Y-m-d'))->where('to','>=',Carbon::now()->format('Y-m-d'))->first();
            if($discount && $discount->type == 'مؤجل'){
                $this->addWalletValue($discount,$order,$wallet);
            }
            return $this->updateOrderTotal($total,$wallet,$order,$discount,$response['total_cost']);
            $this->addPoints($order,$user);
        }else{
            return response()->json(['status'=> false , 'message'=>$response['message']]);
        }
        $type = 'order_status';
        $title = 'اشعار بحاله الطلب';
        $body = 'تم تغيير حاله الطلب الى '.$order->status;
        $id = $order->id;
        $image = url('/storage/files/logo.png') ;
        $devices = User::where('id',$order->user_id)->where('type','اونلاين')->pluck('device_token')->toArray();
        if(count($devices) > 0)
            dispatch(new SendFCMNotificationJob($devices, $title, $body,$type,$id,null,$image));
        return response()->json(['status'=>true ,'message'=>'تم تعديل الطلب بنجاح']);
    }

    public function confirmOrder(Request $request){
        $order= Order::where('id',$request->order_id)->first();
        $wallet = Wallet::where('user_id',$order->user_id)->first();
        $user = User::where('id',$order->user_id)->first();
       $response =  $this->updateOrderProducts($request,$order,$wallet);
       if($response['status'] == true ){
            $total = $response['total'];
            $discount = Discount::where('status','تفعيل')->where('from','<=',Carbon::now()->format('Y-m-d'))->where('to','>=',Carbon::now()->format('Y-m-d'))->first();
            if($discount && $discount->type == 'مؤجل'){
                $this->addWalletValue($discount,$order,$wallet);
            }
            $this->updateOrderTotal($total,$wallet,$order,$discount,$response['total_cost']);

            $order->update(['status'=>'تم التسليم',]);
            $this->addPoints($order,$user);
        }else{
            return response()->json(['status'=> false , 'message'=>$response['message']]);
        }

        return response()->json(['status'=>true ,'message'=>'تم تعديل الطلب بنجاح']);
    }

    public function updateOrderProducts($request,$order,$wallet){
        $total=[];
        $total_cost=[];

        foreach($request->wholesale_quantity as $key=>$quantity){
            $order_product = OrderProduct::where('order_id',$request->order_id)->where('product_id',$quantity[0])->first();
            $store_product = StoreProduct::where('store_id', $order->store_id)->where('product_id',$order_product->product_id)->first();
            $product = Product::where('id',$quantity[0])->select('id','wholesale_quantity_units')->first();
            $min_quantity = $store_product->lower_limit ;
            $max_quantity = $store_product->max_limit;
            if($max_quantity != 0){
                if($min_quantity > $quantity[1] || $max_quantity < $quantity[1]){
                    return ['status'=>false , 'message'=>'لا يمكن طلب هذه الكميه من المنتج برجاء التأكد من اقل كميه واقصى كميه يمكن طلبها من المخزن'];
                }
            }
            $order_product->update([
                'current_unit_quantity'      => $request->unit_quantity[$key][1],
                'current_wholesale_quantity' => $quantity[1],
                'past_unit_quantity'         => $order_product->current_unit_quantity,
                'past_wholesale_quantity'    => $order_product->current_wholesale_quantity,
                'total'                      => ($order_product->wholesale_price * $quantity[1]) + ($order_product->unit_price * $request->unit_quantity[$key][1]),
                'total_cost'                 => ($store_product->buy_price * $quantity[1]) + (($store_product->buy_price / $product->wholesale_quantity_units) * $request->unit_quantity[$key][1]),
            ]);
            $this->addDiscountProduct($quantity[0],$order,$wallet,$order_product);
            $total[]= $order_product->total - ($order_product->item_discount  + $order_product->wholesale_discount);
            $total_cost[]= $order_product->total_cost;

            if($order_product->current_wholesale_quantity > $order_product->past_wholesale_quantity){
                $wholesale_quantity = $order_product->current_wholesale_quantity - $order_product->past_wholesale_quantity;
                $store_product->update([
                    'wholesale_quantity' => $store_product->wholesale_quantity - $wholesale_quantity,
                    'unit_quantity' => $store_product->unit_quantity - ($wholesale_quantity * $product->wholesale_quantity_units)
                ]);
            }else if($order_product->current_wholesale_quantity < $order_product->past_wholesale_quantity){
                $wholesale_quantity = $order_product->past_wholesale_quantity - $order_product->current_wholesale_quantity ;
                $store_product->update([
                    'wholesale_quantity' => $store_product->wholesale_quantity + $wholesale_quantity,
                    'unit_quantity' => $store_product->unit_quantity + ($wholesale_quantity * $product->wholesale_quantity_units)
                ]);
            }


            if($order_product->current_unit_quantity > $order_product->past_unit_quantity){
                $unit_quantity = $order_product->current_unit_quantity - $order_product->past_unit_quantity;
                $store_product->update([
                    'unit_quantity' => $store_product->unit_quantity - $unit_quantity,
                    'wholesale_quantity' => $store_product->wholesale_quantity - intval($unit_quantity/$product->wholesale_quantity_units),
                ]);
            }else if($order_product->current_unit_quantity < $order_product->past_unit_quantity){
                $unit_quantity = $order_product->past_unit_quantity - $order_product->current_unit_quantity;
                $store_product->update([
                    'unit_quantity' => $store_product->unit_quantity + $unit_quantity,
                    'wholesale_quantity' => $store_product->wholesale_quantity + intval($unit_quantity/$product->wholesale_quantity_units),
                ]);
            }
        }
        return ['status'=>true , 'total'=>$total,'total_cost'=>$total_cost];
        // return $total;
    }


    public function deliveredOrder(Request $request){
        $order = Order::where('id',$request->id)->first();
        $order->update(['delivered_from_store'=>true]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order = Order::where('id',$order->id)->first();
        $order_products =OrderProduct::where('order_id',$order->id)->get();
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

    }

    public function printBill($order)
    {
        $order = Order::withSum('discounts','value')->with('shop:id,name,address,area_id','shop.area:id,name','user:id,name,mobile_number','store:id,name','products')->where('id',$order)->first();
        $status = Order::getEnumValues('orders','status');
        $wallet = Wallet::where('user_id',$order->user_id)->first();
        $contact_numbers = Contact::where('type','اتصال')->get();
        return view('admin.order.bill',compact('order','status','wallet','contact_numbers'));
    }

    public function addDirectDiscount(Request $request){
        Order::where('id',$request->order_id)->update(['discount_price'=>$request->direct_discount]);
    }



    public function dropCustodies(Request $request){
        $order = Order::find($request->order_id);
        $custody = Custody::where('order_id',$request->order_id)->update([
            'delivered_from_driver' => true
        ]);
        $treasury = Treasury::where('store_id',$order->store_id)->first();
        $treasury->update(['price' =>  $treasury->price + $custody->mony]);
        OrderReturn::where('order_id',$request->order_id)->update(['status'=>'تم الاستلام']);
    }
}
