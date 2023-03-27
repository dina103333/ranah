<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ExpensesRequest;
use App\Models\Revenu;
use App\Models\Treasury;
use Illuminate\Http\Request;

class RevenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($store_id)
    {
        if(!in_array(22,permissions())){
            abort(403);
        }
        $revenues = Revenu::where('store_id',$store_id)->orderBy('id','desc')->paginate(10);
        $total = $revenues->sum('price');
        return view('admin.revenue.index',compact('revenues','store_id','total'));
    }

    public function getRevenues($store_id){
        $revenues = Revenu::where('store_id',$store_id)->orderBy('id','desc');
        return datatables($revenues)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($store_id)
    {
        if(!in_array(21,permissions())){
            abort(403);
        }
        return View('admin.revenue.create',compact('store_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExpensesRequest $request)
    {
        $treasury =Treasury::where('store_id',$request->store_id)->first();
        $revenues = Revenu::create($request->all());
        $treasury->update(['price'=>$treasury->price + $revenues->price]);
        return redirect()->route('admin.index-revenues',$revenues->store_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Revenu  $revenu
     * @return \Illuminate\Http\Response
     */
    public function show(Revenu $revenu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Revenu  $revenu
     * @return \Illuminate\Http\Response
     */
    public function edit($revenues)
    {
        if(!in_array(23,permissions())){
            abort(403);
        }
        $revenue= Revenu::where('id',$revenues)->first();
        return View('admin.revenue.edit',compact('revenue'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expenses  $expenses
     * @return \Illuminate\Http\Response
     */
    public function update(ExpensesRequest $request, $revenues)
    {
        $treasury =Treasury::where('store_id',$request->store_id)->first();
        $revenues = Revenu::find($revenues);
        $price = $revenues->price > $request->price ? $revenues->price - $request->price : $request->price - $revenues->price ;
        $revenues->update($request->all());
        $treasury->update(['price'=>$treasury->price + ($price)]);
        return redirect()->route('admin.index-revenues',$revenues->store_id);
    }


}
