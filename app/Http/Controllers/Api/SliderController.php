<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ProductResource;
use App\Http\Resources\Api\SliderResource;
use App\Models\Product;
use App\Models\Slider;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    use ApiResponse;
    public function getSliders(){
        $sliders = Slider::with('products')->get();
        return $this->successSingle('تم بنجاح',SliderResource::collection($sliders),200);
    }

    public function getSliderProducts(Request $request){
       $products= Product::whereHas('sliders',function($q) use($request){
        $q->where('sliders.id',$request->slider_id);
       })->get();
        return $this->successSingle('تم بنجاح',ProductResource::collection($products),200);
    }
}
