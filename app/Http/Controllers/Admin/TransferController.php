<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TransferRequest;
use App\Models\Driver;
use App\Models\Product;
use App\Models\Store;
use App\Models\StoreProduct;
use App\Models\Transfer;
use App\Models\TransferProduct;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    public function getStoreTransfers($store_id){
        $transfers = Transfer::with(['stores'=>function($q){
            $q->select('id','name');
        }])->where('to_store_id',$store_id)->where('received_from_driver',true)->where('arrived_to_store',false)->paginate(10);
        return view('admin.transfer.index',compact('transfers','store_id'));
    }

    public function getTransfers($store_id)
    {
        $transfers = Transfer::with(['stores'=>function($q){
            $q->select('id','name');
        }])->where('to_store_id',$store_id)->where('received_from_driver',true)->where('arrived_to_store',false);

        return datatables($transfers)->make(true);
    }

    public function getTransferProducts(Request $request){
        $products = Product::whereHas('transfers', function ($q) use($request){
            $q->where('transfers.id',$request->transfer_id);
        })->with(['transfers'=>function ($q) use($request){
            $q->where('transfers.id',$request->transfer_id);
        }])->get();
        return $products;
    }

    public function createTransferProduct($store_id){
        $products = Product::select('id','name')->whereHas('stores',function($q) use($store_id){
            $q->where('stores.id',$store_id)
            ->where('stores_products.wholesale_quantity','!=',0);
        })->with(['stores'=>function($q) use($store_id){
            $q->where('stores.id',$store_id)
            ->where('stores_products.wholesale_quantity','!=',0)
            ->select('stores_products.wholesale_quantity');
        }])->get();
        $drivers = Driver::where('store_id',$store_id)->get();
        $stores = Store::where('id','!=',$store_id)->get();
        return view('admin.transfer.create',compact('products','drivers','stores','store_id'));
    }

    public function saveTransferProduct(TransferRequest $request){
        $transfer = Transfer::create([
            'from_store_id' => $request->store_id,
            'to_store_id' => $request->to_store_id,
            'driver_id' => $request->driver_id,
        ]);
        $products = array_filter($request->products);
        $quantity = array_filter($request->quantity);

        if(empty($products) || empty($quantity)){
            return redirect()->back()->with('error','يجب ادخال المنتجات بكمياتها الخاصه بها');
        }

        foreach($products as $key=>$product){
            $product_data = Product::where('id',$product)->select('id','wholesale_quantity_units')->first();
            $store_product = StoreProduct::where('product_id',$product)->where('store_id',$request->store_id)->first();
            if($store_product->wholesale_quantity - $quantity[$key] < 0){
                return redirect()->back()->with('error','يرجى التأكد من الكميات المراد نقلها لعدم توافيرها فى المخزن');
            }
            $store_product->update([
                'wholesale_quantity' => $store_product->wholesale_quantity - $quantity[$key],
                'unit_quantity' => ($store_product->wholesale_quantity - $quantity[$key]) * $product_data->wholesale_quantity_units,
            ]);
            TransferProduct::create([
                'transfers_id' => $transfer->id,
                'product_id' => $product,
                'wholesale_quantity' => $quantity[$key],
                'unit_quantity' => $product_data->wholesale_quantity_units * $quantity[$key],
                'production_date' => $store_product->production_date,
                'expiry_date' => $store_product->expiry_date,
                'buy_price' => $store_product->buy_price,
            ]);
        }

        return redirect()->route('admin.stores.index')->with('success','تم نقل المنتجات من المخزن بنجاح');
    }

    public function changeTransferStatus(Request $request){
        $transfer = Transfer::where('id',$request->transfer_id)->first();
        $transfer->update(['arrived_to_store' => true]);
        foreach($transfer->products as $product){
            $store_product = StoreProduct::where('product_id',$product->id)->where('store_id',$request->store_id)->first();
            if($store_product){
                $store_product->update([
                    'wholesale_quantity' => $store_product->wholesale_quantity + $product->pivot->wholesale_quantity,
                    'unit_quantity' => ($store_product->wholesale_quantity + $product->pivot->wholesale_quantity) * $product->pivot->wholesale_quantity_units,
                ]);
            }else{
                StoreProduct::create([
                    'store_id' => $request->store_id,
                    'product_id' => $product->id,
                    'wholesale_quantity' => $product->pivot->wholesale_quantity,
                    'unit_quantity' =>$product->pivot->wholesale_quantity * $product->wholesale_quantity_units,
                    'production_date' => $product->pivot->production_date,
                    'expiry_date' => $product->pivot->expiry_date,
                    'buy_price' => $product->pivot->buy_price,
                ]);
            }

        }
    }
}
