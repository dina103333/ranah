<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\StoreRequest;
use App\Http\Resources\Admin\StoreResource;
use App\Models\Admin;
use App\Models\Area;
use App\Models\Company;
use App\Models\Expenses;
use App\Models\Product;
use App\Models\Receipt;
use App\Models\ReceiptProduct;
use App\Models\Revenu;
use App\Models\Store;
use App\Models\StoreProduct;
use App\Models\Treasury;
use Facade\FlareClient\View;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\Double;
use DataTables;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!in_array(91,permissions())){
            abort(403);
        }
        if(auth()->user()->type == 'المسؤول العام'){
            $stores = Store::paginate(10);
        }else{
            $stores = Store::where('id',auth()->user()->store_id)->first();
        }
        return view('admin.store.index',compact('stores'));
    }

    public function getStores(){
        if(auth()->user()->type == 'admin'){
            $stores = Store::get();
        }else{
            $stores = Store::where('id',auth()->user()->store_id);
        }
        return datatables($stores)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!in_array(90,permissions())){
            abort(403);
        }
        $storekeepers = Admin::where('type','امين مخزن')->where('store_id',null)->get();
        $procurement_officers = Admin::where('type','مسؤول المشتريات')->where('store_id',null)->get();
        $finance_officers = Admin::where('type','مسؤول الماليه')->where('store_id',null)->get();
        $salesmen = Admin::where('type','بائع')->where('store_id',null)->get();
        $areas = Area::where('status','تفعيل')->where('store_id',null)->get();
        $status = Store::getEnumValues('stores','status');

        return view('admin.store.create',compact('storekeepers','procurement_officers','finance_officers','salesmen','areas','status'));


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $store = Store::create([
            'name' => $request->name,
            'address' => $request->address,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'status' => $request->status,
        ]);

        Treasury::create([
            'store_id' => $store->id,
            'price' => 0,
        ]);
        Area::whereIn('id',$request->area_id)->update(['store_id'=>$store->id]);
        Admin::whereIn('id',$request->finance_officers)->update(['store_id'=>$store->id]);
        Admin::whereIn('id',$request->storekeepers)->update(['store_id'=>$store->id]);
        Treasury::create(['store_id'=>$store->id]);
        return redirect()->route('admin.stores.index')->with('success','تم اضافه المخزن بنجاح');
    }

    public function getStoreProducts($store_id){
        if(!in_array(30,permissions())){
            abort(403);
        }
        $products = Product::whereHas('stores',function($q) use($store_id){
                        $q->where('stores_products.store_id',$store_id)->select('stores.id');
                    })
                    ->with(['stores'=>function($q) use($store_id){
                            $q->where('stores_products.store_id',$store_id)->select('stores.id');
                        },'company:id,name','category:id,name'])
                    ->select('products.name','products.id','wholesale_type','item_type','company_id','category_id')->paginate(10);
        $products = StoreResource::collection($products);

        $treasury = Treasury::where('store_id',$store_id)->sum('price');
        $revenues = Revenu::where('store_id',$store_id)->get()->Sum('price');
        $expenses = Expenses::where('store_id',$store_id)->get()->Sum('price');

        return view('admin.store.product',compact('products','store_id','treasury','revenues','expenses'));


    }

    public function getStoreProductsTable($store_id){
        $products = Product::whereHas('stores',function($q) use($store_id){
                        $q->where('stores_products.store_id',$store_id)->select('stores.id');
                    })
                    ->with(['stores'=>function($q) use($store_id){
                            $q->where('stores_products.store_id',$store_id)->select('stores.id');
                        },'company:id,name','category:id,name'])
                    ->select('products.name','products.id','wholesale_type','item_type','company_id','category_id')->get();
        $products = StoreResource::collection($products);
        return DataTables::of($products)->toJson();

    }

    public function editStoreProduct($product_id,$store_id){
        if(!in_array(77,permissions())){
            abort(403);
        }
        $product = Product::with(['stores'=>function($q) use($store_id){
            $q->where('stores_products.store_id',$store_id)->select('stores.id')->first();
        }])->where('products.id',$product_id)
        ->select('products.name','products.id','wholesale_quantity_units')->first();
        return View('admin.store.product_form',compact('product','product_id','store_id'));
    }

    public function updateStoreProduct(StoreProductRequest $request){
        $product = Product::where('id',$request->product_id)->select('wholesale_quantity_units')->first();
        $store_product = StoreProduct::where('product_id',$request->product_id)->where('store_id',$request->store_id)->first();
        $quantity = $product->wholesale_quantity_units;
        $buy_price = $store_product->buy_price/$quantity;
        $store_product->update([
            "reorder_limit"             => $request->reorder_limit,
            "lower_limit"               => $request->lower_limit,
            "max_limit"                 => $request->max_limit,
            "sell_wholesale_price"      => $request->sell_wholesale_price,
            "sell_item_price"           => $request->sell_item_price,
            "unit_gain_ratio"           => ((($request->sell_item_price - $buy_price) / $buy_price)* 100 ),
            "wholesale_gain_ratio"      => ((($request->sell_wholesale_price - $store_product->buy_price) / $store_product->buy_price) * 100),
            "wholesale_gain_value"      => $request->sell_wholesale_price - $store_product->buy_price,
            "unit_gain_value"           => $request->sell_item_price - $buy_price,
            "loss"                      => (Double) $request->loss,
        ]);

        return redirect()->route('admin.get-store-products',$request->store_id)->with('success','تم تعديل المنتج بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function show(Store $store)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function edit(Store $store)
    {
        $keepers = Admin::where('type','امين مخزن')->where('store_id',$store->id)->pluck('id')->toArray();

        $storekeepers = Admin::where('type','امين مخزن')->where(function($q) use ($store){
            $q->where('store_id',$store->id)->orWhere('store_id',null);
        })->get();

        $store_finance_officers = Admin::where('type','مسؤول الماليه')->where('store_id',$store->id)->pluck('id')->toArray();

        $finance_officers = Admin::where('type','مسؤول الماليه')->where(function($q) use ($store){
            $q->where('store_id',$store->id)->orWhere('store_id',null);
        })->get();

        $stor_salesmen = Admin::where('type','بائع')->where('store_id',$store->id)->pluck('id')->toArray();

        $salesmen = Admin::where('type','بائع')->where(function($q) use ($store){
            $q->where('store_id',$store->id)->orWhere('store_id',null);
        })->get();

        $areas = Area::where('status','تفعيل')->where(function($q) use($store){
            $q->where('store_id',null)->orWhere('store_id',$store->id);
        })->get();
        $store_areas = Area::where('status','تفعيل')->where('store_id',$store->id)->pluck('id')->toArray();
        $status = Store::getEnumValues('stores','status');
        if(in_array(92,permissions())){
            return view('admin.store.edit',compact('keepers','storekeepers','finance_officers','store_finance_officers','store_areas','salesmen','stor_salesmen','areas','status','store'));
        }else{
            abort(403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRequest $request, Store $store)
    {
        $store->update([
            'name' => $request->name,
            'address' => $request->address,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'status' => $request->status,
        ]);

        Admin::where('store_id',$store->id)->update(['store_id'=>null]);
        Area::where('store_id',$store->id)->update(['store_id'=>null]);

        Area::whereIn('id',$request->area_id)->update(['store_id'=>$store->id]);

        Admin::whereIn('id',$request->finance_officers)->update(['store_id'=>$store->id]);
        Admin::whereIn('id',$request->storekeepers)->update(['store_id'=>$store->id]);
        Admin::whereIn('id',$request->sales)->update(['store_id'=>$store->id]);
        return redirect()->route('admin.stores.index')->with('success','تم تعديل المخزن بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function destroy(Store $store)
    {
        if(!in_array(93,permissions())){
            abort(403);
        }
        $recepits =Receipt::where('store_id',$store->id)->pluck('id');
        ReceiptProduct::whereIn('receipt_id', $recepits)->delete();
        Receipt::where('store_id',$store->id)->delete();
        Treasury::where('store_id',$store->id)->delete();
        StoreProduct::where('store_id',$store->id)->delete();
        $store->delete();
    }
}
