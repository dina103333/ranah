<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PointRequest;
use App\Http\Requests\Admin\PromoRequest;
use App\Models\PromoCode;
use Illuminate\Http\Request;

class PromoCodeController extends Controller
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
        $promos = PromoCode::orderBy('id','desc')->paginate(10);
        return view('admin.promo.index',compact('promos'));
    }

    public function getPromos(){
        $promos =PromoCode::orderBy('id','desc')->get();
        return datatables($promos)->make(true);
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
        $status = PromoCode::getEnumValues('promo_code','status');
        return view('admin.promo.create',compact('status'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PromoRequest $request)
    {
        PromoCode::create([
            'name'  => $request->name,
            'value'     => $request->value,
            'status'    => $request->status,
        ]);
        return redirect()->route('admin.promos.index')->with('success','تم اضافه الكوبون بنجاح');
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
    public function edit(PromoCode $promo)
    {
        if(!in_array(121,permissions())){
            abort(403);
        }
        $status = PromoCode::getEnumValues('promo_code','status');
        return view('admin.promo.edit',compact('status','promo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PromoRequest $request, PromoCode $promo)
    {
        $promo->update([
            'name'  => $request->name,
            'value'     => $request->value,
            'status'    => $request->status,
        ]);
        return redirect()->route('admin.promos.index')->with('success','تم تعديل الكوبون بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PromoCode $promo)
    {
        if(!in_array(122,permissions())){
            abort(403);
        }
        $promo->delete();
    }

    public function multiPromoDelete(Request $request)
    {
        if(!in_array(122,permissions())){
            abort(403);
        }
        $ids = $request->ids;
        PromoCode::whereIn('id',explode(",",$ids))->delete();
        return response()->json(['status' => true, 'message' => "Records deleted successfully."]);
    }
}
