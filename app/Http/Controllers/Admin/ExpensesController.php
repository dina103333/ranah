<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ExpensesRequest;
use App\Models\Expenses;
use App\Models\Treasury;
use Facade\FlareClient\View;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Exporter;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($store_id)
    {
        if(!in_array(160,permissions())){
            abort(403);
        }
        $expenses = Expenses::where('store_id',$store_id)->orderBy('id','desc')->paginate(10);
        $total = $expenses->sum('price');
        return view('admin.expenses.index',compact('expenses','store_id','total'));
    }

    public function getExpenses($store_id){
        $expenses = Expenses::where('store_id',$store_id)->orderBy('id','desc');
        return datatables($expenses)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($store_id)
    {
        if(!in_array(135,permissions())){
            abort(403);
        }
        return View('admin.expenses.create',compact('store_id'));
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
        if($request->price > $treasury->price){
            return redirect()->back()->with('error','لا يوجد فى المخزن رصيد كافى لهذا المبلغ');
        }
        $expenses = Expenses::create($request->all());
        $treasury->update(['price'=>$treasury->price - $expenses->price]);
        return redirect()->route('admin.index-expenses',$expenses->store_id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expenses  $expenses
     * @return \Illuminate\Http\Response
     */
    public function edit($expenses)
    {
        if(!in_array(136,permissions())){
            abort(403);
        }
        $expenses= Expenses::where('id',$expenses)->first();
        return View('admin.expenses.edit',compact('expenses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expenses  $expenses
     * @return \Illuminate\Http\Response
     */
    public function update(ExpensesRequest $request, $expenses)
    {
        $treasury =Treasury::where('store_id',$request->store_id)->first();
        if($request->price > $treasury->price){
            return redirect()->back()->with('error','لا يوجد فى المخزن رصيد كافى لهذا المبلغ');
        }
        $expenses = Expenses::find($expenses);
        $price = $expenses->price > $request->price ? $expenses->price - $request->price : $request->price - $expenses->price ;
        $expenses->update($request->all());
        $treasury->update(['price'=>$treasury->price - $price]);
        return redirect()->route('admin.index-expenses',$expenses->store_id);
    }

}
