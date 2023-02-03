<?php

namespace App\Http\Controllers\Api;
use App\Models\Setting;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class GeneralController extends Controller
{
    use ApiResponse;
    public function generalSetting(){
        $version = Setting::where('key','version')->first()->value;
        $close_application = Setting::where('key','غلق الابلكيشن')->first()->value;
        $hide_discounts = Setting::where('key','اخفاء الخصومات')->first()->value;
        $show_green_line = Setting::where('key','اظهار الشريط الاخضر الخاص بالخصم')->first()->value;
        $min_order_total = Setting::where('key','اقل سعر للطلب')->first()->value;
        $free_charge = Setting::where('key','تفعيل الشحن؟')->first()->value;
        return $this->success('تم بنجاح',['version'=>$version,'close_application'=>$close_application,
        'hide_discounts'=>$hide_discounts,'show_green_line'=>$show_green_line,
        'min_order_total'=>$min_order_total,'free_charge' => $free_charge],200);
    }

    public function getContacts(){
        $contacts = Contact::get();
        return $this->successSingle('تم بنجاح',$contacts,200);
    }
}
