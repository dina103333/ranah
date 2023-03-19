<?php

namespace App\Jobs;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendFCMNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $devices;
    private $notification;
    private $title;
    private $body;
    private $type;
    private $id;
    private $image;
    private $name;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $devices,$title,$body,$type,$id,$name,$image)
    {
        $this->devices = $devices;
        $this->title = $title;
        $this->body = $body;
        $this->type = $type;
        $this->id = $id;
        $this->name = $name;
        $this->image = $image;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // $firbase_key = Setting::where('key', 'firebase_key')->first()->value;
        $headers = [
            'Authorization' => 'key=' . env('FIREBASE_SERVER_KEY'),
            'Content-Type' => 'application/json'
        ];
        foreach ($this->devices as $device) {
            $payload = [
                'notification' => [
                    'title' => $this->title,
                    'body' => $this->body,
                    "sound" => "default",// required for sound on ios
                    "image" =>$this->image,
                ],
                'to' => $device,
                "data" => array(
                    "click_action" => "FLUTTER_NOTIFICATION_CLICK",
                    'type' => $this->type,
                    'id' => $this->id,
                    'name' => $this->name,
                ),
                "priority" => "high",
            ];
            Http::withOptions([
                'verify' => false,
            ])->withHeaders($headers)->post('https://fcm.googleapis.com/fcm/send', $payload);
        }
    }
}
