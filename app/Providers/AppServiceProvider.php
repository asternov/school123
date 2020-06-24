<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

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
        Blade::if('admin', function () {
            return Auth::check() && Auth::user()->is_admin &&
                isset($_COOKIE['is_admin']) && $_COOKIE['is_admin'];
        });
        Blade::if('member', function ($course) {
            return Auth::check() && Auth::user()->courses->contains($course);
        });
    }
}
