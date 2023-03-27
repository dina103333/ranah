<?php

namespace App\Http\Controllers\Admin;

use App\Exports\SupplierExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SupplierRequest;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!in_array(194,permissions())){
            abort(403);
        }
        $suppliers = Supplier::latest()->paginate('10');
        return view('admin.supplier.index',compact('suppliers'));
    }

    public function getSellers()
    {
        $suppliers = Supplier::latest()->select('id','name');
        return datatables($suppliers)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!in_array(193,permissions())){
            abort(403);
        }
        $status = Supplier::getEnumValues('suppliers','status');
        return view('admin.supplier.create',compact('status'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupplierRequest $request)
    {
        Supplier::create([
            'name' =>$request->name,
        ]);

        return redirect()->route('admin.suppliers.index')->with('success','تم اضافه بائع بنجاح');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Seller $seller
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $seller)
    {
       //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Seller $seller
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        if(!in_array(192,permissions())){
            abort(403);
        }
        $status = Supplier::getEnumValues('suppliers','status');
        return view('admin.supplier.edit',compact('supplier','status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Seller $seller
     * @return \Illuminate\Http\Response
     */
    public function update(SupplierRequest $request, Supplier $supplier)
    {
        $supplier->update([
            'name' =>$request->name,
        ]);

        return redirect(route('admin.suppliers.index'))->with('success','تم تعديل المورد بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Seller $seller
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        if(!in_array(195,permissions())){
            abort(403);
        }
        $supplier->delete();
    }

    public function multiSuppliersDelete(Request $request)
    {
        if(!in_array(195,permissions())){
            abort(403);
        }
        $ids = $request->ids;
        Supplier::whereIn('id',explode(",",$ids))->delete();

        return response()->json(['status' => true, 'message' => "Records deleted successfully."]);
    }

    public function export()
    {
        return Excel::download(new SupplierExport, 'sellers.xlsx');
    }
}
