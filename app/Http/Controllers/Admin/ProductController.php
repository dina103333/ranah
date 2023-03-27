<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ProductsExport;
use App\Exports\ProdutTemplateExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Imports\ProdutTemplateImport;
use App\Models\Category;
use App\Models\Company;
use App\Models\CompanyCategory;
use App\Models\Product;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!in_array(74,permissions())){
            abort(403);
        }
        $products = Product::paginate(10);
        return view('admin.product.index',compact('products'));
    }

    public function getProducts(){
        $products = Product::get();
        return datatables($products)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!in_array(73,permissions())){
            abort(403);
        }
        $companies = Company::where('status','تفعيل')->get();
        $status = Product::getEnumValues('products','status');
        $discount = Product::getEnumValues('products','discount');
        $wating = Product::getEnumValues('products','wating');
        $selling_type = Product::getEnumValues('products','selling_type');
        $product_quantity = Product::getEnumValues('products','product_quantity');
        return view('admin.product.create',compact('companies','status','discount','wating','selling_type','product_quantity'));
    }

    public function getCompanyCategories($company_id){
        $categories = Category::where('parent_id','!=',null)
        ->whereHas('companies',function($q) use($company_id){
            $q->where('companies_categories.company_id',$company_id);
        })->select('id','name')->get();
        return $categories;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $file = $request->file('image')->store('public/files/products');
        $filepath=explode('/',$file);
        $product = Product::create($request->except(['image']));
        $product->image = $filepath[1].'/'.$filepath[2].'/'.$filepath[3];
        $product->save();
        return redirect(route('admin.products.index'))->with('success','تم اضافه المنتج بنجاح');
    }

    public function createImported(){
        return view('admin.product.create_imported');
    }

    public function storePulckProducts(Request $request){

        $index = count(CompanyCategory::get())+9;
        $rows = Excel::toArray(new ProdutTemplateImport(), $request->file('excel_file'));

        $startIndex = 0;
        $length = $index+1;

        array_splice($rows[0], $startIndex, $length);
        foreach ($rows[0] as $row) {
            Product::create([
                'name'                      =>  $row[2],
                'description'               =>  $row[6],
                'category_id'              =>  $row[1],
                'company_id'               =>  $row[0],
                'wholesale_type'            =>  $row[3],
                'item_type'                 =>  $row[5],
                'wholesale_quantity_units'  =>  $row[4],
                'wating'                    =>  $row[8],
                'status'                    =>  $row[9],
                'selling_type'              =>  $row[7],
                'is_available_for_order'    =>  $row[10] == 'نعم' ? '1' : '0',
            ]);
        }
        return redirect(route('admin.products.index'))->with('success','تم اضافه المنتج بنجاح');
    }


    // public function changeQuantityStatus(Request $request){
    //     $product = Product::where('id',$request->id)->first();
    //     if($product->product_quantity == 'نعم'){
    //         $product->product_quantity = 'لا';
    //         $product->save();
    //     }else{
    //         $product->product_quantity = 'نعم';
    //         $product->save();
    //     }
    // }
    public function changeStatus(Request $request){
        $product = Product::where('id',$request->id)->first();
        if($product->status == 'تفعيل'){
            $product->status = 'ايقاف';
            $product->save();
        }else{
            $product->status = 'تفعيل';
            $product->save();
        }
    }

    // public function updateProductQuantity(Request $request){
    //     Product::where('id',$request->id)->update(['wholesale_max_quantity'=>$request->value]);
    // }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        if(!in_array(75,permissions())){
            abort(403);
        }
        $companies = Company::where('status','تفعيل')->get();
        $status = Product::getEnumValues('products','status');
        $discount = Product::getEnumValues('products','discount');
        $wating = Product::getEnumValues('products','wating');
        $selling_type = Product::getEnumValues('products','selling_type');
        $product_quantity = Product::getEnumValues('products','product_quantity');
        $company_categories = Category::whereHas('companies',function($q) use($product){
            $q->where('companies_categories.company_id',$product->company_id);
        })->select('id','name')->get();
        return view('admin.product.edit',compact('product','companies','status',
        'company_categories','discount','wating','selling_type','product_quantity'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        // return $request;
        $product->update($request->except(['image']));
        if($request->file('image')){
            $file = $request->file('image')->store('public/files/products');
            $filepath=explode('/',$file);
            $product->image = $filepath[1].'/'.$filepath[2].'/'.$filepath[3];
            $product->save();
        }
        return redirect(route('admin.products.index'))->with('success','تم تعديل المنتج بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if(!in_array(76,permissions())){
            abort(403);
        }
        $product->delete();
    }

    public function multiProductsDelete(Request $request)
    {
        if(!in_array(76,permissions())){
            abort(403);
        }
        $ids = $request->ids;
        Product::whereIn('id',explode(",",$ids))->delete();

        return response()->json(['status' => true, 'message' => "Records deleted successfully."]);
    }

    public function export()
    {
        return Excel::download(new ProductsExport, 'products.xlsx');
    }

    public function exportTemplate()
    {
        return Excel::download(new ProdutTemplateExport, 'products'.'.xlsx');
    }
}
