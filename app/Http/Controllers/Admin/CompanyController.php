<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CompanyRequest;
use App\Models\Category;
use App\Models\Company;
use App\Models\CompanyCategory;
use App\Models\Product;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::paginate(10);
        return view('admin.company.index',compact('companies'));
    }

    public function getcompanies(){
        $companies = Company::get();
        return datatables($companies)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('parent_id','!=',null)->get();
        $status = Company::getEnumValues('companies','status');
        return view('admin.company.create',compact('categories','status'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request)
    {
        $file = $request->file('image')->store('public/files');
        $filepath=explode('/',$file);
        $company = Company::create([
            'name'      =>$request->name,
            'image'     =>$filepath[1].'/'.$filepath[2],
            'status'    =>$request->status,
        ]);
        foreach($request->categories as $category){
            CompanyCategory::create([
                'company_id' =>$company->id ,
                'category_id' =>$category ,
            ]);
        }
        return redirect(route('admin.companies.index'))->with('success','تم اضافه الشركه بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        $categories = Category::where('parent_id','!=',null)->get();
        $status = Company::getEnumValues('companies','status');
        $company_categories = CompanyCategory::where('company_id',$company->id)->pluck('category_id')->toArray();
        // return $company_categories;
        return view('admin.company.edit',compact('company','categories','status','company_categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        if($request->file('image')){
            $file = $request->file('image')->store('public/files');
            $filepath=explode('/',$file);
        }
        $company->update([
            'name'      =>$request->name,
            'image'     =>$request->file('image') ? $filepath[1].'/'.$filepath[2] : $company->image ,
            'status'    =>$request->status,
        ]);
        CompanyCategory::where('company_id',$company->id)->delete();
        foreach($request->categories as $category){
            CompanyCategory::create([
                'company_id' =>$company->id ,
                'category_id' =>$category ,
            ]);
        }
        return redirect(route('admin.companies.index'))->with('success','تم تعديل الشركه بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        Product::where('company_id',$company->id)->delete();
        CompanyCategory::where('company_id',$company->id)->delete();
        $company->delete();
    }
}
