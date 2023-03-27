<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DiscountProductRequest;
use App\Models\DiscountProduct;
use App\Models\Order;
use App\Models\OrderDiscount;
use App\Models\Product;
use App\Models\Store;
use App\Models\Wallet;
use Illuminate\Http\Request;

class DiscountProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!in_array(119,permissions())){
            abort(403);
        }
        $discounts =DiscountProduct::with('Product:id,name','store:id,name')->orderBy('id','desc')->paginate(10);
        // return $discounts;
        return view('admin.product_discounts.index',compact('discounts'));
    }

    public function getProductDiscounts(){
        $discounts =DiscountProduct::with('Product:id,name','store:id,name')->orderBy('id','desc')->get();
        return datatables($discounts)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!in_array(120,permissions())){
            abort(403);
        }
        $status = DiscountProduct::getEnumValues('discounts','status');
        $types = DiscountProduct::getEnumValues('discounts','type');
        $stores = Store::where('status','تفعيل')->select('id','name')->get();
        return view('admin.product_discounts.create',compact('status','types','stores'));
    }

    public function getStoreProducts($store_id){
        $products = Product::whereHas('stores',function($q) use($store_id){
            $q->where('stores_products.store_id',$store_id);
        })->select('id','name')->get();
        return $products;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DiscountProductRequest $request)
    {
        if(count($request->type)>1){
            foreach($request->type as $type){
                DiscountProduct::create([
                    'store_id' =>  $request->store_id,
                    "product_id"=> $request->product_id,
                    "type"=> $type,
                    "item_value"=> $request->item_value,
                    "item_ratio"=> $request->item_ratio,
                    "wholesale_value"=> $request->wholesale_value,
                    "wholesale_ratio"=> $request->wholesale_ratio,
                    "from_item_total"=> $request->from_item_total,
                    "to_item_total"=> $request->to_item_total,
                    "from_wholesale_total"=> $request->from_wholesale_total,
                    "to_wholesale_total"=> $request->to_wholesale_total,
                    "status"=> $request->status,
                ]);
            }
        }else{
            DiscountProduct::create([
                'store_id' =>  $request->store_id,
                "product_id"=> $request->product_id,
                "type"=>$request->type[0],
                "item_value"=> $request->item_value,
                "item_ratio"=> $request->item_ratio,
                "wholesale_value"=> $request->wholesale_value,
                "wholesale_ratio"=> $request->wholesale_ratio,
                "from_item_total"=> $request->from_item_total,
                "to_item_total"=> $request->to_item_total,
                "from_wholesale_total"=> $request->from_wholesale_total,
                "to_wholesale_total"=> $request->to_wholesale_total,
                "status"=> $request->status,
            ]);
        }
        return redirect()->route('admin.discountproducts.index')->with('success','تم اضافه الخصم بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($discount)
    {
        if(!in_array(121,permissions())){
            abort(403);
        }
        $discount =DiscountProduct::find($discount);
        $status = DiscountProduct::getEnumValues('discounts','status');
        $types = DiscountProduct::getEnumValues('discounts','type');
        $stores = Store::where('status','تفعيل')->select('id','name')->get();
        $products = Product::whereHas('stores',function($q) use($discount){
            $q->where('stores_products.store_id',$discount->store_id);
        })->select('id','name')->get();
        return view('admin.product_discounts.edit',compact('status','types','stores','products','discount'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DiscountProductRequest $request, $discount)
    {
        $discount =DiscountProduct::find($discount);
        if(count($request->type)>1){
            foreach($request->type as $type){
                $discount->update([
                    'store_id' =>  $request->store_id,
                    "product_id"=> $request->product_id,
                    "type"=> $type,
                    "item_value"=> $request->item_value,
                    "item_ratio"=> $request->item_ratio,
                    "wholesale_value"=> $request->wholesale_value,
                    "wholesale_ratio"=> $request->wholesale_ratio,
                    "from_item_total"=> $request->from_item_total,
                    "to_item_total"=> $request->to_item_total,
                    "from_wholesale_total"=> $request->from_wholesale_total,
                    "to_wholesale_total"=> $request->to_wholesale_total,
                    "status"=> $request->status,
                ]);
            }
        }else{
            $discount->update([
                'store_id' =>  $request->store_id,
                "product_id"=> $request->product_id,
                "type"=>$request->type[0],
                "item_value"=> $request->item_value,
                "item_ratio"=> $request->item_ratio,
                "wholesale_value"=> $request->wholesale_value,
                "wholesale_ratio"=> $request->wholesale_ratio,
                "from_item_total"=> $request->from_item_total,
                "to_item_total"=> $request->to_item_total,
                "from_wholesale_total"=> $request->from_wholesale_total,
                "to_wholesale_total"=> $request->to_wholesale_total,
                "status"=> $request->status,
            ]);
        }

        if($discount->status == 'ايقاف'){
            OrderDiscount::where('discount_id',$discount->id)->update('active',false);
        }
        return redirect()->route('admin.discountproducts.index')->with('success','تم تديل الخصم بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($discount)
    {
        if(!in_array(122,permissions())){
            abort(403);
        }
        DiscountProduct::find($discount)->delete();
    }

    public function multiDiscountsDelete(Request $request)
    {
        if(!in_array(122,permissions())){
            abort(403);
        }
        $ids = $request->ids;
        DiscountProduct::whereIn('id',explode(",",$ids))->delete();

        return response()->json(['status' => true, 'message' => "Records deleted successfully."]);
    }

    public function convertToDirect(){
        $discounts = DiscountProduct::where('type','مؤجل')->where('status','تفعيل');
        OrderDiscount::whereIn('discount_id',$discounts->pluck('id')->toArray())->update(['active'=>true]);

        $users = OrderDiscount::whereIn('discount_id',$discounts->pluck('id')->toArray())->pluck('user_id')->toArray();

        $wallets = Wallet::whereIn('user_id',array_unique($users))->get();
        foreach($wallets as $wallet){
            $wallet->update([
                'value' => $wallet->value + $wallet->hold_value,
                'hold_product_value' => 0
            ]);
        }
        $discounts->update(['type'=>'فورى']);
    }
}
