<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use  Illuminate\Support\Facades\Schema;
use Illuminate\Http\Resources\Json\JsonResource ;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        config(['global.username' => \App\Models\Setting::where('key','sms_username')->first()->value]);
        config(['global.Password' => \App\Models\Setting::where('key','sms_password')->first()->value]);
        config(['global.sender' => \App\Models\Setting::where('key','sms_sender')->first()->value]);

        JsonResource::withoutWrapping();
    }
}
