<?php

namespace App\Providers;

use App\Helpers\Settings;
use App\Setting;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

    public function register() {
        //
    }

    public function boot() {
        Schema::defaultStringLength(191);
        //app()->setLocale(Settings::get('default_lang'));
        Carbon::setLocale(config('app.locale'));
    }

}
