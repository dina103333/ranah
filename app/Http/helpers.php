<?php

use Illuminate\Support\Facades\Cache;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;


function sendNotificationToUsers($tokens, $target_id, $message, $title, $msgType = "1")
{
    try {
        $headers = [
            'Authorization: key=' . env("FireBaseKey"),
            'Content-Type: application/json'
        ];

        if (!empty($tokens)) {
            $data = [
                "registration_ids" => $tokens,
                "data" => [
                    'body' => $message,
                    'type' => "notify",
                    'title' => $title,
                    'target_id' => $target_id, // order_id or user_id
                    'msgType' => $msgType, //1=>order , 2=>msg
                    'badge' => 1,
                    "click_action" => 'FLUTTER_NOTIFICATION_CLICK',
                    'icon' => 'myicon', //Default Icon
                    'sound' => 'mySound' //Default sound
                ],
                "notification" => [
                    'body' => $message,
                    'type' => "notify",
                    'title' => $title,
                    'target_id' => $target_id, // order_id or user_id
                    'msgType' => $msgType, //1=>order , 2=>msg
                    'badge' => 1,
                    "click_action" => 'FLUTTER_NOTIFICATION_CLICK',
                    'icon' => 'myicon', //Default Icon
                    'sound' => 'mySound' //Default sound
                ]
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            $result = curl_exec($ch);
            curl_close($ch);
            // $resultOfPushToIOS = "Done";
            //   return $result; // to check does the notification sent or not
        }
    } catch (\Exception $ex) {
        return $ex->getMessage();
    }
}

function updateFirebaseChat($type, $target, $value = 1)
{
    $database = app('firebase.database');
    $x = $database->getReference("chats/$target")->getSnapshot()->getValue();
    $newValue = 0;
    if ($type === 'increment') $newValue = $x + $value;
    if ($type === 'decrement') $newValue = ($x - $value > 0) ? $x - $value : 0;
    if ($type === 'reset') $newValue = 0;
    if ($type === 'newValue') $newValue = $value;
    $database->getReference("chats")->update([
        $target => $newValue,
    ]);
}

function addFirebaseNotification($id,$message) {
    $database = app('firebase.database');
    $notificationsRef = $database->getReference("notifications");
    $newNotificationRef = $notificationsRef->push();
    $newNotificationRef->set([
        "id" => $id,
        "message" => $message,
        "timestamp" => time()
    ]);
}
function updateFirebaseNotification($type, $value = 1)
{
    $database = app('firebase.database');
    $x = $database->getReference("notifications/1")->getSnapshot()->getValue();
    $newValue = 0;
    if ($type === '+') $newValue = $x + $value;
    if ($type === '-') $newValue = ($x - $value > 0) ? $x - $value : 0;
    if ($type === '0') $newValue = 0;
    $database->getReference("notifications")->update([
        '1' => $newValue,
    ]);
}

function unreadedNotfication()
{
    $database = app('firebase.database');
    $notifications = $database->getReference("notifications")->orderByChild('read')->getSnapshot()->getValue();
    $unreadNotifications = $notifications[1];
    return $unreadNotifications;
}


function allnotifications(){
    $database = app('firebase.database');
    $notifications = $database->getReference("notifications")->orderByChild('read')->getSnapshot()->getValue();
    return $notifications;
}
