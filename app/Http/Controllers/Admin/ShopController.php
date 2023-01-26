<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ShopTypeRequest;
use App\Models\Shop;
use App\Models\ShopType;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of the shops.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shops_type = ShopType::latest()->paginate('10');
        return view('admin.shops.index',compact('shops_type'));
    }

    public function getShops()
    {
        $shops_type = ShopType::latest()->select('id','name', 'status');
        return datatables($shops_type)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $status = ShopType::getEnumValues('areas','status');
        return view('admin.shops.create',compact('status'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShopTypeRequest $request)
    {
        ShopType::create([
            'name' =>$request->name,
            'status' =>$request->status,
        ]);

        return redirect()->route('admin.shops.index')->with('success','تم اضافه نوع المحل بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function show(ShopType $shop_type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function edit($shop_type)
    {
        $shop_type = ShopType::find($shop_type);
        $status = ShopType::getEnumValues('areas','status');
        return view('admin.shops.edit',compact('status','shop_type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function update(ShopTypeRequest $request, ShopType $shop_type)
    {
        $shop_type = ShopType::find($shop_type);
        $shop_type->update([
            'name' =>$request->name,
            'status' =>$request->status,
        ]);

        return redirect()->route('admin.shops.index')->with('success','تم تعديل نوع المحل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function destroy($shop_type)
    {
        $shop_type = ShopType::find($shop_type);
        $shop_type->delete();
    }

    public function multiShopsDelete(Request $request)
    {
        $ids = $request->ids;
        ShopType::whereIn('id',explode(",",$ids))->delete();

        return response()->json(['status' => true, 'message' => "Records deleted successfully."]);
    }

}
