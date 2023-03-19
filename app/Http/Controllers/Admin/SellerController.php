<?php

namespace App\Http\Controllers\Admin;

use App\Exports\SellersExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SellerRequest;
use App\Models\Seller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sellers = Seller::latest()->paginate('10');
        return view('admin.sellers.index',compact('sellers'));
    }

    public function getSellers()
    {
        $sellers = Seller::latest()->select('id','name', 'mobile_number');
        return datatables($sellers)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.sellers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SellerRequest $request)
    {
        $seller = Seller::create([
            'name' =>$request->name,
            'mobile_number' =>$request->mobile,
        ]);

        return redirect()->route('admin.sellers.index')->with('success','تم اضافه بائع بنجاح');
    }

    public function generateQrCode($seller_id){

        $seller = Seller::where('id',$seller_id)->first();
        $code = Str::slug($seller->id) . '.' . 'png';

        $arrData = [
            'id'  => $seller->id
        ];
        $body = json_encode($arrData);
        QrCode::format('png')
                ->size(500)->errorCorrection('H')
                ->generate($body, '../public/qr_code/' . $code);
        $qr_code_url= url('qr_code/'.$code);
        return view('admin.sellers.qr',compact('qr_code_url'));
                // return response()->json(['qr_code_url'=>url('qr_code/'.$code)]) ;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Seller $seller
     * @return \Illuminate\Http\Response
     */
    public function show(Seller $seller)
    {
       //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Seller $seller
     * @return \Illuminate\Http\Response
     */
    public function edit(Seller $seller)
    {
        return view('admin.sellers.edit',compact('seller'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Seller $seller
     * @return \Illuminate\Http\Response
     */
    public function update(SellerRequest $request, Seller $seller)
    {
        $seller->update([
            'name' =>$request->name,
            'mobile_number' =>$request->mobile,
        ]);

        return redirect(route('admin.sellers.index'))->with('success','تم تعديل بائع بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Seller $seller
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seller $seller)
    {
        $seller->delete();
    }

    public function multiDriversDelete(Request $request)
    {
        $ids = $request->ids;
        Seller::whereIn('id',explode(",",$ids))->delete();

        return response()->json(['status' => true, 'message' => "Records deleted successfully."]);
    }

    public function export()
    {
        return Excel::download(new SellersExport, 'sellers.xlsx');
    }
}
