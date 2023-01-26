<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SendOtp implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $mobile_number;

    public function __construct($mobile_number)
    {
        $this->mobile_number= $mobile_number;
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
        ->post("https://smssmartegypt.com/sms/api/otp-send",[
            'username'=>'RNAeg',
            'Password'=>'56D486C9*v',
            'sender'=>'RNA eg',
            'mobile'=>$this->mobile_number
        ]);
        // return $result->body();
    }
}
