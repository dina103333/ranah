<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\SliderResource;
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
}
