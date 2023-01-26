<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    use ApiResponse;
    public function getAllAreas(){
        $areas = Area::where('status','تفعيل')->select('id','name')->get();
        return $this->successSingle('تم بنجاح', $areas, 200);
    }
}
