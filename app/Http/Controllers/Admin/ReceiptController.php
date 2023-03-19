<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ReceiptRequest;
use App\Models\Product;
use App\Models\Receipt;
use App\Models\ReceiptProduct;
use App\Models\Store;
use App\Models\StoreProduct;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $receipts = Receipt::with('store:id,name','keeper:id,name','supplier:id,name')->paginate(10);
        // return $receipts;
        return view('admin.receipt.index',compact('receipts'));
    }

    public function getReceipts(){
        $receipts = Receipt::with('store:id,name','keeper:id,name','supplier:id,name')->get();
        return datatables($receipts)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::With(['company'=>function($q){
            $q->where('status','تفعيل')->select('id','name');
        }])->select('id','name','company_id')->get();
        $suppliers = Supplier::Where('status','تفعيل')->get();
        $stores = Store::Where('status','تفعيل')->get();
        return view('admin.receipt.create',compact('products','suppliers','stores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReceiptRequest $request)
    {
        $products = array_filter($request->products);
        $quantity = array_filter($request->quantity);
        $price = array_filter($request->price);

        $production_date = array_filter($request->production_date);
        $expiry_date = array_filter($request->expiry_date);

        if(empty($products) || empty($quantity) || empty($price) || empty($production_date) || empty($expiry_date)){
            return redirect()->back()->with('error','يجب ادخال المنتجات بكمياتها واسعارها وتاريخ الانتاج والانتهاء الخاص بها');
        }

        $receipt = Receipt::Create([
            'store_id' => $request->store_id,
            'supplier_id' => $request->supplier_id,
            'total' => (double) $request->total,
            'created_by' => auth()->user()->id,
        ]);


        foreach($products as $Key=>$product){
            $price = str_replace( ',', '', $price[$Key] );
            ReceiptProduct::create([
                'receipt_id' => $receipt->id,
                'product_id' => $product,
                'quantity' => $quantity[$Key],
                'buy_price' => $price,
                'total' => $quantity[$Key] * $price,
                'production_date' => $production_date[$Key],
                'expiry_date' => $expiry_date[$Key],
            ]);
        }
        return redirect(route('admin.receipts.index'))->with('success','تم عمل فاتوره شراء ');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function show(Receipt $receipt)
    {
        $receipt = $receipt->load('products');
        return view('admin.receipt.show', compact('receipt'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function edit(Receipt $receipt)
    {
       $receipt = $receipt->load('products');
       $suppliers = Supplier::Where('status','تفعيل')->get();
       $stores = Store::Where('status','تفعيل')->get();
       $products = Product::With(['company'=>function($q){
            $q->where('status','تفعيل')->select('id','name');
        }])->select('id','name','company_id')->get();
        return view('admin.receipt.edit', compact('receipt','suppliers','stores','products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Receipt $receipt)
    {
        $products = array_filter($request->products);
        $quantity = array_filter($request->quantity);
        $price = array_filter($request->price);
        $production_date = array_filter($request->production_date);
        $expiry_date = array_filter($request->expiry_date);

        if(empty($products) || empty($quantity) || empty($price) || empty($production_date) || empty($expiry_date)){
            return redirect()->back()->with('error','يجب ادخال المنتجات بكمياتها واسعارها وتاريخ الانتاج والانتهاء الخاص بها');
        }

        $receipt->update([
            'store_id' => $request->store_id,
            'supplier_id' => $request->supplier_id,
            'total' => (double) str_replace(",", "", $request->total),
            'created_by' => auth()->user()->id,
        ]);

        ReceiptProduct::where('receipt_id',$receipt->id)->delete();
        foreach($products as $Key=>$product){
            $price = str_replace( ',', '', $price[$Key] );
            ReceiptProduct::create([
                'receipt_id' => $receipt->id,
                'product_id' => $product,
                'quantity' => $quantity[$Key],
                'buy_price' => $price,
                'total' => $quantity[$Key] * $price,
                'production_date' => $production_date[$Key],
                'expiry_date' => $expiry_date[$Key],
            ]);
        }
        return redirect(route('admin.receipts.index'))->with('success','تم تعديل فاتوره شراء ');
    }


    public function receiveReceipt($id){
        $receipt= Receipt::find($id);
        $receipt->update(['is_received' => true]);
        $products = ReceiptProduct::where('receipt_id', $receipt->id)->get();
         foreach($products as $product) {
            $product_data = Product::find($product->product_id);
            $product_store = StoreProduct::updateOrCreate(['store_id' => $receipt->store_id,'product_id' => $product->product_id],
            [
                'production_date'   => $product->production_date,
                'expiry_date'   => $product->expiry_date,
                'buy_price'   => $product->buy_price,
            ]);
            $total_quantity = $product_store->wholesale_quantity + $product->quantity;
            $product_store->update([
                'wholesale_quantity'   => $total_quantity ,
                'unit_quantity'   => $total_quantity * $product_data->wholesale_quantity_units
            ]);
         }

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receipt $receipt)
    {
        ReceiptProduct::where('receipt_id', $receipt)->delete();
        $receipt->delete();
    }
}
