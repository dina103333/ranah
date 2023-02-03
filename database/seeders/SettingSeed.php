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
        ];

        foreach($items as $item){
            Setting::updateOrCreate(['id' => $item['id']], $item);
        }
    }
}
