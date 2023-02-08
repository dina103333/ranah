<?php

namespace App\Http\Controllers\Api\Driver;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponse;

class LoginController extends Controller
{
    use ApiResponse;
    public function login(Request $request)
    {
        if (!Auth::guard('drivers')->attempt(['mobile_number' => request('mobile_number'), 'password' => request('password') , 'status'=>'تفعيل'])) {
            return $this->error('رقم الهاتق او كلمه المرور غير صحيحه',401);
        }
        $driver = Driver::where('mobile_number', $request->mobile_number)->first();
        $token = $driver->createToken('access_token')->plainTextToken;
        return $this->success('تم الدخول بنجاح', ['driver'=>$driver,'access_token'=>$token], 200);
    }
}
