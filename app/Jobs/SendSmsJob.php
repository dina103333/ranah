<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SendSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $mobile_number;
    protected $message;

    public function __construct($mobile_number,$message)
    {
        $this->mobile_number= $mobile_number;
        $this->message= $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $result = Http::
        withOptions([
            'verify' => false,
        ])
        ->post("https://smssmartegypt.com/sms/api/json",[
            'username'=> base64_decode(substr(config('global.username'),5,-5)),
            'password'=>base64_decode(substr(config('global.Password'),5,-5)),
            'sendername'=>base64_decode(substr(config('global.sender'),5,-5)),
            'mobiles'=>$this->mobile_number,
            'message'=>$this->message
        ]);
    }
}
