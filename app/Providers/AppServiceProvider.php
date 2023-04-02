<?php

namespace App\Providers;

use App\Gateways\Music\LastFmApiGateway;
use App\Gateways\Music\MusicContract;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // music gateway
        $this->app->singleton(MusicContract::class, function ($app) {
            return new LastFmApiGateway();
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
