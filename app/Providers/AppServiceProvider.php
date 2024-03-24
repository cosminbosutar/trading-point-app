<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\AlphaVantageService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(AlphaVantageService::class, function ($app) {
            return new AlphaVantageService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
