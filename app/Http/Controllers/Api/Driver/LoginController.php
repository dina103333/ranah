<?php

namespace App\Http\Controllers\Api\Driver;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Resources\Api\Driver\DriverResource;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Http;

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
        return $this->success('تم الدخول بنجاح', ['driver'=>DriverResource::make($driver),'access_token'=>$token], 200);
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
        $driver = Driver::where('mobile_number',$request->mobile_number)->first();
        if($driver){
            return $this->sendTextMessage($request ,$request->mobile_number);
        }else{
            return $this->error('عذرا رقم الهاتف غير مسجل لدينا',422);
        }
    }

    public function restPassword(LoginRequest $request){
        $driver = Driver::where('mobile_number',$request->mobile_number)->update(['password'=>bcrypt($request->password)]);
        if($driver){
            return $this->successSingle('تم تغيير كلمه المرور بنجاح',[],200);
        }else{
            return $this->error('عذرا رقم الهاتف غير مسجل لدينا',422);
        }
    }
}
