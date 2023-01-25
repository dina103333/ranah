<?php

namespace App\Http\Controllers\api\auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\UserLoginResource;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    use ApiResponse;
    public function register(Request $request)
    {
        // return $request;

        $user = User::create([
            'name' => $request->name,
            'mobile_number' => $request->mobile_number ,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('access_token')->plainTextToken;

        return $this->success('تم  تسجيل الدخول بنجاح', ['user'=>UserLoginResource::make($user),'access_token'=>$token], 201);
    }

    public function login(Request $request)
    {
        if (!Auth::guard('web')->attempt($request->only('mobile_number', 'password'))) {
            return $this->error('رقم الهاتق او كلمه المرور غير صحيحه',401);
        }
        $user = $request->user();
        $token = $user->createToken('access_token')->plainTextToken;
        return $this->success('تم الدخول بنجاح', ['user'=>UserLoginResource::make($user),'access_token'=>$token], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
