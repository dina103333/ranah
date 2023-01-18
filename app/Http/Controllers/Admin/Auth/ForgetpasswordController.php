<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;

class ForgetpasswordController extends Controller
{
    public function __construct()
    {
       $this->middleware('guest:admin');
    }

    public function getResetPasswordForm(){
        return view('admin.auth.reset_password');
    }

    public function sendTextMessage($number){
        $result = Http::
        withOptions([
            'verify' => false,
        ])
        ->post("https://smssmartegypt.com/sms/api/otp-send",[
            'username'=>'RNAeg',
            'Password'=>'56D486C9*v',
            'sender'=>'RNA eg',
            'mobile'=>$number
        ]);
        return $result->body();
    }

    public function sendOtp(Request $request){
        $admin = Admin::where('mobile_number',$request->mobile_number)->first();
        if ($admin) {
            return $this->sendTextMessage($admin->mobile_number);
        } else {
            return 'failed';
        }
    }

    public function verifyOtpPage(Request $request){
        $mobile = $request->mobile;
        return view('admin.auth.twoStep',compact('mobile'));
    }

    public function verifyOtpCode(Request $request){
        $code = str_replace(',','',implode(',',array_reverse($request->codes)));
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
        return $result->body();
    }

    public function NewPasswordPage(Request $request){
        $mobile = $request->mobile;
        return view('admin.auth.new_password',compact('mobile'));
    }

    public function resetPassword(Request $request){
        $mobile = '0'.$request->mobile_number;
        Admin::where('mobile_number',$mobile )->update(['password'=>bcrypt($request->password)]);
        return 'ok';
    }
}
