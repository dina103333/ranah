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
        if(!in_array(6,permissions())){
            abort(403);
        }
        $categories = Category::where('parent_id',null)->paginate('10');
        return view('admin.category.index',compact('categories'));
    }

    public function getCategories()
    {
        $categories = Category::where('parent_id',null);
        return datatables($categories)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!in_array(5,permissions())){
            abort(403);
        }
        $status = Category::getEnumValues('categories','status');
        return view('admin.category.create',compact('status'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $file = $request->file('image')->store('public/files/categories');
        $filepath=explode('/',$file);
        Category::create([
            'name'      =>$request->name,
            'image'     =>$filepath[1].'/'.$filepath[2].'/'.$filepath[3],
            'status'    =>$request->status,
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
        if(!in_array(7,permissions())){
            abort(403);
        }
        $status = Category::getEnumValues('categories','status');
        return view('admin.category.edit',compact('status','category'));
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
            $file = $request->file('image')->store('public/files/categories');
            $filepath=explode('/',$file);
        }
        $category->update([
            'name'      =>$request->name,
            'image'     =>$request->file('image') ? $filepath[1].'/'.$filepath[2].'/'.$filepath[3] : $category->image ,
            'status'    =>$request->status,
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
        if(!in_array(8,permissions())){
            abort(403);
        }
        Product::where('category_id',$category->id)->delete();
        CompanyCategory::where('category_id',$category->id)->delete();
        Category::where('parent_id',$category->id)->delete();
        $category->delete();
    }
}
