<?php

namespace App\Providers;

use App\Classes\Sayings;
use App\Classes\Images;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Sayings::class, function($app){
            return new Sayings(config('sayings'));
        });
        $this->app->bind(Images::class, function($app){
            return new Images();
        });
    }
}
