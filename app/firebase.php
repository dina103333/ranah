<?php

namespace App;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Firebase
{
    public static function sendNotification($device_token,String $title, String $body,string $type,$id)
    {
        $lang = User::where('device_token', $device_token)->first();

        $postData =
            array(
                "to" => $device_token,
                "data" => array(
                    "click_action" => "FLUTTER_NOTIFICATION_CLICK",
                    'type' => $type,
                    'id' => $id,
                ),
                "priority" => "high",
                "notification" => array(
                    "body" => $body,
                    "title" => $title,
                    "sound" => "default",// required for sound on ios
                    "image" =>asset('uploads/products/'.$product -> image),
                )
            );
        $data = json_encode($postData);
        $firbase_key = Setting::where('key', 'firebase_key')->first()->value;
        $url = "https://fcm.googleapis.com/fcm/send";
        $AUTH_KEY = $firbase_key;
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key=' . $AUTH_KEY
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($ch);
        $error_msg = curl_error($ch);
        Log::debug('Showing the user profile for user: '.$error_msg);
        Log::debug($response);
        curl_close($ch);
    }
}
