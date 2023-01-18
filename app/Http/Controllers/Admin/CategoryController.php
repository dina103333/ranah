<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Category;
use App\Models\CompanyCategory;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::with('subCategory')->paginate('10');
        return view('admin.category.index',compact('categories'));
    }

    public function getCategories()
    {
        $categories = Category::with('subCategory');
        return datatables($categories)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sub_categories = Category::where('parent_id',null)->get();
        $status = Category::getEnumValues('categories','status');
        return view('admin.category.create',compact('sub_categories','status'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $file = $request->file('image')->store('public/files');
        $filepath=explode('/',$file);
        Category::create([
            'name'      =>$request->name,
            'image'     =>$filepath[1].'/'.$filepath[2],
            'status'    =>$request->status,
            'parent_id' =>$request->parent_id == 0 ? null : $request->parent_id,
        ]);
        return redirect(route('admin.categories.index'))->with('success','تم اضافه فئه بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $status = Category::getEnumValues('categories','status');
        $sub_categories = Category::where('parent_id',null)->where('id','!=',$category->id)->get();
        return view('admin.category.edit',compact('status','sub_categories','category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        if($request->file('image')){
            $file = $request->file('image')->store('public/files');
            $filepath=explode('/',$file);
        }
        $category->update([
            'name'      =>$request->name,
            'image'     =>$request->file('image') ? $filepath[1].'/'.$filepath[2] : $category->image ,
            'status'    =>$request->status,
            'parent_id' =>$request->parent_id,
        ]);
        return redirect(route('admin.categories.index'))->with('success','تم تعديل فئه بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        Product::where('category_id',$category->id)->delete();
        CompanyCategory::where('category_id',$category->id)->delete();
        Category::where('parent_id',$category->id)->delete();
        $category->delete();
    }
}
