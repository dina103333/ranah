<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CategoryResource;
use App\Models\Category;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use ApiResponse;
    public function getCategories(){
        $categories = Category::where('status','تفعيل')->where('parent_id',null)->select('id','name','image')
                            ->paginate(6);
        return $this->successSingle('تم بنجاح',CategoryResource::collection($categories)->response()->getData(true),200);
    }

    public function getSubCategory(Request $request){
        $sub_categories = Category::where('parent_id',$request->category_id)
                            ->where('status','تفعيل')->select('id','name','image')
                            ->paginate(6);
        return $this->successSingle('تم بنجاح',CategoryResource::collection($sub_categories)->response()->getData(true),200);
    }
}
