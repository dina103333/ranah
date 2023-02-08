<?php

namespace App\Http\Controllers\Api\Driver;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Driver\OrderRequest;
use App\Http\Resources\Api\Driver\OrderResource;
use App\Models\Custody;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class OrderController extends Controller
{
    use ApiResponse;

    public function getAllOrders(OrderRequest $request){
        $orders = Order::where('driver_id',$request->user()->id)
        ->with('user:id,name,mobile_number,seconde_mobile_number,shop_id','user.shop','user.shop.car:id,name')
        ->select('id','total','distance','fee','status','user_id','delivered_to_driver','created_at')
        ->orderBy('created_at',$request->order)->paginate(6);
        $orders = OrderResource::collection($orders)->response()->getData(true);
        return $this->success('تم بنجاح',$orders,200);
    }

    public function getPendingOrders(OrderRequest $request){
        $orders = Order::where('driver_id',$request->user()->id)
        ->with('user:id,name,mobile_number,seconde_mobile_number,shop_id','user.shop','user.shop.car:id,name')
        ->select('id','total','distance','fee','status','user_id','delivered_to_driver','created_at')
        ->where('status','في الطريق')
        ->orderBy('created_at',$request->order)->paginate(6);
        $orders = OrderResource::collection($orders)->response()->getData(true);
        return $this->success('تم بنجاح',$orders,200);
    }

    public function deliveredOrder(Request $request){
        $order = Order::where('id',$request->order_id)->where('delivered_from_store',true)->first();
        if(!$order){
            return $this->error('لا يمكن تأكيد استلام الطلب قبل تأكيد تسليمه من جه المخزن',422);
        }
        $order->update(['delivered_to_driver'=>true]);
        return $this->successSingle('تم بنجاح',[],200);
    }

    public function completeOrder(Request $request){
        $order = Order::where('id',$request->order_id)->where('status','!=','تم التسليم')->first();
        if($order){
            $order->update(['status'=>'تم التسليم']);
            Custody::create([
                'driver_id' => $request->user()->id,
                'order_id' => $order->id,
                'mony' => $order->total,
            ]);
            return $this->successSingle('تم بنجاح',[],200);
        }else{
            return $this->error('عفوا هذا الطلب تم تسليمه من قبل',422);
        }
    }

    public function addReturn(Request $request){
        $order_product = OrderProduct::where('order_id',$request->order_id)->where('product_id',$request->product_id)->first();
        if(!$order_product){
            return $this->error('يابنى متزهقناش اتأكد ان المنتج دا ع الطلب دا اصلا الاول',422);
        }
        $order_product->update(['unit_returned_quantity'=>$request->unit_returned_quantity
                    ,'wholesale_returned_quantity' =>$request->wholesale_returned_quantity
                    ,'current_unit_quantity' =>  $order_product->current_unit_quantity - $request->unit_returned_quantity
                    ,'current_wholesale_quantity' =>  $order_product->current_wholesale_quantity - $request->wholesale_returned_quantity
                    ,'total' =>  ($request->unit_returned_quantity == 0 ?  ($order_product->current_unit_quantity * $order_product->unit_price) : ($request->unit_returned_quantity * $order_product->unit_price)  )
                    +  ($request->wholesale_returned_quantity == 0 ?  ($order_product->current_wholesale_quantity * $order_product->wholesale_price) : ($request->wholesale_returned_quantity * $order_product->wholesale_price))
                ]);
        $order = Order::where('id',$request->order_id)->first();
        $order->update(['sub_total' => $order_product->total , 'total' => $order_product->total + ($order->distance * $order->fee)]);
        Custody::where('order_id',$request->order_id)->update(['unit_quantity'=>$request->unit_returned_quantity ,
                                                                'wholesale_quantity'=>$request->wholesale_returned_quantity ,
                                                                'mony' => $order->total]);
        return $this->successSingle('تم اضافه المترجعات على الطلب بنجاح',[],200);
    }

    
}
