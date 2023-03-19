<?php

namespace App\Http\Controllers\Api\Driver;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Driver\ConfirmTransferRequest;
use App\Http\Requests\Api\Driver\OrderRequest;
use App\Http\Resources\Api\Driver\CustodyProductResource;
use App\Http\Resources\Api\Driver\OrderProductResource;
use App\Http\Resources\Api\Driver\OrderResource;
use App\Http\Resources\Api\Driver\TransferResource;
use App\Models\Custody;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderReturn;
use App\Models\Product;
use App\Models\Transfer;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    use ApiResponse;

    public function getAllOrders(OrderRequest $request){
        $orders = Order::where('driver_id',$request->user()->id)
        ->with(['user:id,name,mobile_number,seconde_mobile_number,shop_id','user.shop','user.shop.car:id,name',
            'promo'=>function($q){
                $q->withTrashed()->select('id','value');
            }
        ])
        ->select('id','total','distance','discount_price','fee','status','user_id','delivered_to_driver','created_at','promo_code_id')
        ->withSum('discounts','value')
        ->orderBy('created_at',$request->order)->paginate(6);
        $orders = OrderResource::collection($orders)->response()->getData(true);
        return $this->success('تم بنجاح',$orders,200);
    }

    public function getPendingOrders(OrderRequest $request){
        $orders = Order::where('driver_id',$request->user()->id)
        ->with(['user:id,name,mobile_number,seconde_mobile_number,shop_id','user.shop','user.shop.car:id,name',
            'promo'=>function($q){
                $q->withTrashed()->select('id','value');
            }
        ])
        ->select('id','total','distance','discount_price','fee','status','user_id','delivered_to_driver','created_at','promo_code_id')
        ->where('status','في الطريق')
        ->withSum('discounts','value')
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
        $order = Order::where('id',$request->order_id)->first();
        if($order->status != 'في الطريق'){
            return $this->error('لا يمكنك عمل مرتجع على هذا المنتج',422);
        }
        $order_product = OrderProduct::where('order_id',$request->order_id)->where('product_id',$request->product_id)->first();
        if(!$order_product){
            return $this->error('يابنى متزهقناش اتأكد ان المنتج دا ع الطلب دا اصلا الاول',422);
        }
        $order_product->update(['unit_returned_quantity'=>$request->unit_returned_quantity
                    ,'wholesale_returned_quantity' =>$request->wholesale_returned_quantity
                    ,'current_unit_quantity' =>  $order_product->current_unit_quantity - $request->unit_returned_quantity
                    ,'current_wholesale_quantity' =>  $order_product->current_wholesale_quantity - $request->wholesale_returned_quantity
                    ,'total' =>  (($order_product->current_unit_quantity - $request->unit_returned_quantity) * $order_product->unit_price) + (($order_product->current_wholesale_quantity - $request->wholesale_returned_quantity) * $order_product->wholesale_price)
                ]);

        $order_products = OrderProduct::where('order_id',$request->order_id)->get()->sum('total');

        $order->update(['sub_total' => $order_products , 'total' => $order_products + ($order->distance * $order->fee)]);
        $this->saveReturns($request,$order,$order_product);
        return $this->successSingle('تم اضافه المترجعات على الطلب بنجاح',[],200);
    }

    public function orderDetails(Request $request){
        $order_details = Order::where('driver_id',$request->user()->id)
        ->withSum('discounts','value')
        ->with(['products.discounts'=>function($q) use ($request){
            $q->join('discount_products',function($join){
                $join->on('discount_products.id','order_discounts.discount_id');
                $join->on('discount_products.product_id','order_discounts.product_id');
            })->where('order_discounts.order_id',$request->order_id);
        }
        ,'user:id,name,mobile_number,seconde_mobile_number,shop_id','user.shop','user.shop.car:id,name',
        'promo'=>function($q){
            $q->withTrashed()->select('id','value');
        }])
        ->where('id',$request->order_id)->get();
        $products = OrderProductResource::collection($order_details);
        return $this->successSingle('تم بنجاح',$products,200);
    }

    public function saveReturns($request,$order,$order_product){
        $returns = OrderReturn::where('order_id', $order->id)->where('product_id',$request->product_id)->first();
        if($returns){
            $returns->update([
                'unit_quantity'=>$returns->unit_quantity + $request->unit_returned_quantity,
                'wholesale_quantity'=>$returns->wholesale_quantity + $request->wholesale_returned_quantity,
                'unit_price'=> $returns->unit_price,
                'wholesale_price'=>$returns->wholesale_price,
                'total'=>(($returns->unit_quantity + $request->unit_returned_quantity) * $returns->unit_price ) + (($returns->wholesale_quantity + $request->wholesale_returned_quantity) * $returns->wholesale_price ),
                'updated_by'=>$request->user()->id,
            ]);
        }else{
            OrderReturn::create([
                'order_id' => $order->id,
                'shop_id' => $order->shop_id,
                'product_id' => $request->product_id,
                'unit_quantity'=>$request->unit_returned_quantity,
                'wholesale_quantity'=>$request->wholesale_returned_quantity,
                'unit_price'=> $order_product->unit_price,
                'wholesale_price'=>$order_product->wholesale_price,
                'total'=>($request->unit_returned_quantity * $order_product->unit_price)  + ( $request->wholesale_returned_quantity * $order_product->wholesale_price ),
                'updated_by'=>$request->user()->id,
                'driver_id'=>$request->user()->id,
            ]);
        }
    }

    public function getCustodies(Request $request){
        $custodies = Custody::where('driver_id',$request->user()->id)->where('delivered_to_store',false)->get()->sum('mony');
        $quantity = OrderReturn::Where('driver_id',$request->user()->id)->where('status','قيد الانتظار')->get();
        return $this->successSingle('تم بنجاح',['mony'=>$custodies , 'quantity' => $quantity != '[]' ? true : false],200);
    }

    public function getCustodyProducts(Request $request){
        $products = Product::whereHas('returns',function($q) use($request){
            $q->where('order_returns.driver_id',$request->user()->id)->where('status','قيد الانتظار');
        })->withSum('returns','order_returns.wholesale_quantity')
        ->withSum('returns','order_returns.unit_quantity')
        ->get();
        return $this->successSingle('تم بنجاح',CustodyProductResource::collection($products),200);
    }

    public function deliverCustody(Request $request){
        Custody::where('driver_id',$request->user()->id)->update(['delivered_to_store'=>true]);
         OrderReturn::where('driver_id',$request->user()->id)->update(['status'=>'تم الاستلام']);
        return $this->successSingle('تم اسقاط العهده بنجاح من جانب السائق',[],200);
    }

    public function getTransferOrders(Request $request){
        $transfers = Transfer::join('stores','stores.id','transfers.to_store_id')->where('driver_id',$request->user()->id)
        ->select('transfers.id','transfers.received_from_driver','transfers.received_from_store','stores.name','stores.address','stores.longitude','stores.latitude')
        ->with('products')->paginate(6);
        $transfers = TransferResource::collection($transfers)->response()->getData(true);
        return $this->success('تم بنجاح',$transfers,200);
    }

    public function receivedTransfer(ConfirmTransferRequest $request){
         Transfer::where('id',$request->transfer_id)->update([
            'received_from_driver' => true
        ]);
        return $this->successSingle('تم بنجاح',[],200);
    }

    public function receiveTransferFromStore(ConfirmTransferRequest $request){
         Transfer::where('id',$request->transfer_id)->update([
            'received_from_store' => true
        ]);
        return $this->successSingle('تم بنجاح',[],200);
    }
}
