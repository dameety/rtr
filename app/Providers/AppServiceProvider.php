<?php

namespace App\Providers;

use App\Meal;
use App\Observers\MealObserver;
use Illuminate\Routing\UrlGenerator;
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
     * @param UrlGenerator $url
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        if(\App::environment('production')) {
            $url->forceScheme('https');
        }

        Meal::observe(MealObserver::class);

    }
}
