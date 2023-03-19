<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['id'=>1 ,'key' => 'sms_username', 'value'=> 'elmnofy123'],
            ['id'=>2 ,'key' => 'sms_password', 'value'=> '11EB86*qD'],
            ['id'=>3 ,'key' => 'sms_sender', 'value'=> 'ERABA7'],
            ['id'=>4 ,'key' => 'غلق الابلكيشن', 'value'=> 'false'],
            ['id'=>5 ,'key' => 'اخفاء الخصومات', 'value'=> 'true'],
            ['id'=>6 ,'key' => 'اظهار الشريط الاخضر الخاص بالخصم', 'value'=> 'true'],
            ['id'=>7 ,'key' => 'version', 'value'=> '1.1.1.1'],
            ['id'=>8 ,'key' => 'تحويل الخصومات الاجله بنظام كاش باك يتم تحصيل العميل المبلغ اوتوماتيكيا عند الطلب مره اخرى', 'value'=> 'false'],
            ['id'=>9 ,'key' => 'دمج كميات المنتج في جميع المخازن اثناء شراء العميل', 'value'=> 'false'],
            ['id'=>10 ,'key' => 'تععين المخزن للطلبات القادمه يدويا', 'value'=> 'false'],
            ['id'=>11 ,'key' => 'اقل سعر للطلب', 'value'=> '500'],
            ['id'=>12 ,'key' => 'سعر الشحن للكيلو الواحد', 'value'=> '1'],
            ['id'=>13 ,'key' => 'تطبيق مصاربف الشحن من اجمالى', 'value'=> '100'],
            ['id'=>14 ,'key' => 'الغاء الشحن على اجمالى الطلبات الاقل من', 'value'=> '50'],
            ['id'=>15 ,'key' => 'تفعيل الشحن؟', 'value'=> 'true'],
            ['id'=>16 ,'key' => 'freshchat', 'value'=> 'enable'],
            ['id'=>17 ,'key' => 'freshchat_app_id', 'value'=> '489fd229-d039-42dc-af54-d9e91b41662c'],
            ['id'=>18 ,'key' => 'freshchat_appkey', 'value'=> '5d342f32-8638-4ad3-a5f9-92b77929e957'],
            ['id'=>19 ,'key' => 'freshchat_domain', 'value'=> 'msdk.freshchat.com'],
        ];

        foreach($items as $item){
            Setting::updateOrCreate(['id' => $item['id']], $item);
        }
    }
}
