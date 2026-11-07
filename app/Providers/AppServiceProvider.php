<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\system_setting;

class AppServiceProvider extends ServiceProvider
{

public function boot()
{
    view()->share('globalData', system_setting::first());
}
}
