<?php

namespace NanBei\Response\Providers;

use Illuminate\Support\ServiceProvider as BasicServiceProvider;

class ServiceProvider extends BasicServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__, 2) . '/config/laravel-response.php',
            'laravel-response'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes(
            [
                __DIR__ . '/../../config/laravel-response.php' => config_path('laravel-response.php'),
            ]
        );
    }
}
