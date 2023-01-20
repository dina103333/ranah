<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Area;
use App\Models\Company;
use App\Models\Product;
use App\Models\Store;
use App\Models\StoreProduct;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stores = Store::with('keeper:id,name,store_id','finance_manager:id,name,store_id','area')->paginate(10);
        return view('admin.store.index',compact('stores'));
    }

    public function getStores(){
        $stores = Store::with('keeper:id,name,store_id','finance_manager:id,name,store_id','area');
        return datatables($stores)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $storekeepers = Admin::where('type','امين مخزن')->where('store_id',null)->get();
        $procurement_officers = Admin::where('type','مسؤول المشتريات')->where('store_id',null)->get();
        $finance_officers = Admin::where('type','مسؤول الماليه')->where('store_id',null)->get();
        $salesmen = Admin::where('type','بائع')->where('store_id',null)->get();
        $companies = Company::where('status','تفعيل')
                            ->with(['products'=>function($q){
                                $q->where('status','تفعيل')->select('id','name','company_id');
                            }])->select('id','name')->get();
        // return $products;
        $areas = Area::where('status','تفعيل')->get();
        $status = Store::getEnumValues('stores','status');
        return view('admin.store.create',compact('storekeepers','procurement_officers','finance_officers','salesmen','companies','areas','status'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $store = Store::create([
            'name' => $request->name,
            'area_id' => $request->area_id,
            'store_keeper_id' => $request->storekeeper_id,
            'store_finance_manager_id' => $request->finance_officer_id,
            'address' => $request->address,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'status' => $request->status,
        ]);
        Admin::whereIn('id',$request->finance_officers)->update(['store_id'=>$store->id]);
        Admin::whereIn('id',$request->storekeepers)->update(['store_id'=>$store->id]);
        foreach($request->products as $key=>$product){
            StoreProduct::create([
                'store_id'              => $store->id,
                'product_id'            => $product,
                'sell_wholesale_price'  => $request->sell_wholesale_price[$key],
                'sell_item_price'       => $request->sell_item_price[$key],
                'max_limit'             => $request->max_limit[$key],
                'lower_limit'           => $request->lower_limit[$key],
                'reorder_limit'         => $request->reorder_limit[$key],
            ]);
        }

        return redirect()->route('admin.stores.index')->with('success','تم اضافه المخزن بنجاح');
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Store $store)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function destroy(Store $store)
    {
        //
    }
}
