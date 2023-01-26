<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ShopType;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ShopTypeController extends Controller
{
    use ApiResponse;
    public function getAllShopTypes(){
        $types = ShopType::where('status','تفعيل')->select('id','name')->get();
        return $this->successSingle('تم بنجاح', $types, 200);
    }
}
