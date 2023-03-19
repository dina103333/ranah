<?php

namespace App\Console\Commands;

use App\Models\Setting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SendFCMNotification extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:fcm-notification {devices} {--title=Title} {--body=Body}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send FCM notification to multiple devices';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */


    public function handle()
    {
        $devices = explode(',', $this->argument('devices'));
        $title = $this->option('title');
        $body = $this->option('body');
        $type = $this->option('type');
        $id = $this->option('id');
        $firbase_key = Setting::where('key', 'firebase_key')->first()->value;
        
        $headers = [
            'Authorization' => 'key=' . $firbase_key,
            'Content-Type' => 'application/json'
        ];

        foreach ($devices as $device) {
            $payload = [
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                    "sound" => "default",// required for sound on ios
                    "image" =>asset('uploads/products/'.$product -> image),
                ],
                'to' => $device,
                "data" => array(
                    "click_action" => "FLUTTER_NOTIFICATION_CLICK",
                    'type' => $type,
                    'id' => $id,
                ),
                "priority" => "high",
            ];

            Http::withHeaders($headers)->post('https://fcm.googleapis.com/fcm/send', $payload);
        }
    }
}
