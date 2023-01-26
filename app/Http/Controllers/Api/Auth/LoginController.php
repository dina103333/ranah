<?php

namespace App\Http\Controllers\api\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Resources\Api\UserLoginResource;
use App\Jobs\SendOtp;
use App\Models\Shop;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    use ApiResponse;
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'mobile_number' => $request->mobile_number ,
            'password' => Hash::make($request->password),
        ]);

        $file= Storage::disk('public')->put('shop'.$user->id , $request->file('image'));
        Shop::create([
            'user_id' => $user->id,
            'name' => $request->shop_name,
            'address' => $request->address,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'area_id' => $request->area_id,
            'shop_types_id' => $request->shop_types_id ,
            'image' => $file ,
        ]);

        $token = $user->createToken('access_token')->plainTextToken;

         dispatch(new SendOtp($user->mobile_number));

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


    public function verifyOtpCode(Request $request){
        $code = $request->code;
        $result = Http::
        withOptions([
            'verify' => false,
        ])
        ->post("https://smssmartegypt.com/sms/api/otp-check",[
            'username'=>'RNAeg',
            'Password'=>'56D486C9*v',
            'mobile'=>$request->mobile_number,
            'otp'=>$code
        ]);
        if(json_decode($result->body())->type == 'success'){
            return $this->successSingle('تم  تأكيد رمز التحقق بنجاح ',$code, 200);
        }
    }
}
