<?php

namespace App\Http\Controllers\api\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Resources\Api\UserLoginResource;
use App\Jobs\SendOtp;
use App\Models\Setting;
use App\Models\Shop;
use App\Models\Store;
use App\Models\User;
use App\Models\Wallet;
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
            'device_token'=>$request->device_token,
            'status' => 'جديد'
        ]);
        $store = Store::where('area_id',$request->area_id)->select('id')->first();
        $file= Storage::disk('public')->put('shop'.$user->id , $request->file('image'));
        $shop = Shop::create([
            'user_id' => $user->id,
            'name' => $request->shop_name,
            'address' => $request->address,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'area_id' => $request->area_id,
            'shop_types_id' => $request->shop_types_id ,
            'image' => $file ,
            'store_id' => $store->id ,
        ]);
        $user->update(['shop_id' => $shop->id,'store_id' => $store->id]);
        $token = $user->createToken('access_token')->plainTextToken;
        return $this->success('تم  تسجيل الدخول بنجاح', ['user'=>UserLoginResource::make($user),'access_token'=>$token], 201);
    }

    public function login(Request $request)
    {
        if (!Auth::guard('web')->attempt(['mobile_number' => request('mobile_number'), 'password' => request('password') , 'active'=>true])) {
            return $this->error('رقم الهاتق او كلمه المرور غير صحيحه',401);
        }
        $request->user()->update(['device_token'=>$request->device_token ,'type'=>'اونلاين']);
        $user = $request->user();
        $token = $user->createToken('access_token')->plainTextToken;

        if(empty($user->wallet)){
            Wallet::create([
                'user_id' => $user->id,
                'value' => 0,
                'hold_value' => 0,
                'hold_product_value' => 0
            ]);
        }
        return $this->success('تم الدخول بنجاح', ['user'=>UserLoginResource::make($user),'access_token'=>$token], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function sendTextMessage(Request $request,$mobile_number=false){
        $result = Http::
                withOptions([
                    'verify' => false,
                ])
                ->post("https://smssmartegypt.com/sms/api/otp-send",[
                    'username'=> base64_decode(substr(config('global.username'),5,-5)),
                    'Password'=>base64_decode(substr(config('global.Password'),5,-5)),
                    'sender'=>base64_decode(substr(config('global.sender'),5,-5)),
                    'mobile'=>$mobile_number ? $mobile_number : $request->user()->mobile_number
                ]);
        if(json_decode($result->body())->type == 'success'){
            return $this->successSingle('تم  ارسال رمز التحقق بنجاح ',[], 200);
        }else{
            return $this->error('لم يتم ارسال رمز التحقق برجاء مراجعه رقم الهاتف',501);
        }
    }

    public function verifyOtpCode(Request $request){
        $code = $request->code;
        $result = Http::
        withOptions([
            'verify' => false,
        ])
        ->post("https://smssmartegypt.com/sms/api/otp-check",[
            'username'=>base64_decode(substr(config('global.username'),5,-5)),
            'Password'=>base64_decode(substr(config('global.Password'),5,-5)),
            'mobile'=>$request->user()? $request->user()->mobile_number : $request->mobile_number ,
            'otp'=>$code
        ]);
        if(json_decode($result->body())->type == 'success'){
            $request->user() ? $request->user()->update(['status'=>'تفعيل']) : '';
            return $this->successSingle('تم  تأكيد رمز التحقق بنجاح ',$code, 200);
        }else{
            return $this->error('رمز التحقق غير صحيح',501);
        }
    }

    public function forgetPassword(Request $request){
        $user = User::where('mobile_number',$request->mobile_number)->first();
        if($user){
            return $this->sendTextMessage($request ,$request->mobile_number);
        }else{
            return $this->error('عذرا رقم الهاتف غير مسجل لدينا',422);
        }
    }

    public function restPassword(LoginRequest $request){
        $user = User::where('mobile_number',$request->mobile_number)->update(['password'=>bcrypt($request->password)]);
        if($user){
            return $this->successSingle('تم تغيير كلمه المرور بنجاح',[],200);
        }else{
            return $this->error('عذرا رقم الهاتف غير مسجل لدينا',422);
        }
    }
}
