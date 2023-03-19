<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
class SettingController extends Controller
{
   public function edit(){
        $setting=Setting::get();
        return view('admin.setting.edit',compact('setting'));
   }

   public function update(Request $request){
        $dataMapper = [
            "username"              =>  "sms_username" ,
            "password"              =>  "sms_password" ,
            "sender"                =>  "sms_sender"   ,
            "close"                 =>  "غلق الابلكيشن"  ,
            "hide"                  =>  "اخفاء الخصومات" ,
            "show"                  =>  "اظهار الشريط الاخضر الخاص بالخصم" ,
            "version"               =>  "version" ,
            "cahe_bakc"             =>  "تحويل الخصومات الاجله بنظام كاش باك يتم تحصيل العميل المبلغ اوتوماتيكيا عند الطلب مره اخرى" ,
            "all_stores"            =>  "دمج كميات المنتج في جميع المخازن اثناء شراء العميل" ,
            "store_order"           =>  "تععين المخزن للطلبات القادمه يدويا" ,
            "min_order"             =>  "اقل سعر للطلب" ,
            "price"                 =>  "سعر الشحن للكيلو الواحد" ,
            "add-charge"            =>  "تطبيق مصاربف الشحن من اجمالى" ,
            "cancele-charge"        =>  "الغاء الشحن على اجمالى الطلبات الاقل من" ,
            "charge"                =>  "تفعيل الشحن؟",
            "freshchat"             =>  "freshchat",
            "freshchat_app_id"      =>  "freshchat_app_id",
            "freshchat_appkey"      =>  "freshchat_appkey",
            "freshchat_domain"      =>  "freshchat_domain",
        ];

        foreach($request->all() as $key => $value){
            if(in_array($key,array_keys($dataMapper))){
                if($key=='username'){
                    if($value != null){
                        Setting::where('key',$dataMapper[$key])->update([
                            'value'=> 'i6b9A'.base64_encode($value).'W36rb'
                        ]);
                    }
                }elseif($key=='password'){
                    Setting::where('key',$dataMapper[$key])->update([
                        'value'=> 'i6b9A'.base64_encode($value).'W36rb'
                    ]);
                }elseif($key=='sender'){
                    Setting::where('key',$dataMapper[$key])->update([
                        'value'=> 'i6b9A'.base64_encode($value).'W36rb'
                    ]);
                }else{
                    Setting::where('key',$dataMapper[$key])->update([
                        'value'=> $value
                    ]);
                }
            }
        }
        return redirect()->route('admin.edit-setting');
   }
}
