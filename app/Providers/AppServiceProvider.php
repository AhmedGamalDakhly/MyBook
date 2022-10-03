<?php

namespace App\Providers;

use App\Profile;
use App\User;
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
        $this->app->singleton(User::class, function () {
            return auth()->user();;
        });

        $this->app->singleton(Profile::class, function () {
            return auth()->user()->profile;
        });


    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
