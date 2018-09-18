<?php

namespace Damnyan\Cmn;

use Damnyan\Cmn\Services\ApiResponse;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Damnyan\Cmn\Providers\MacroServiceProvider;
use Damnyan\Cmn\Providers\HelperServiceProvider;
use Damnyan\Cmn\Providers\ValidatorServiceProvider;

class CmnServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the module services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes(
            [__DIR__.'/../config/cmn.php' => config_path('cmn.php')],
            'config'
        );

        $this->loadTranslationsFrom(__DIR__.'/Resources/Lang', 'cmn');
    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(HelperServiceProvider::class);
        $this->app->register(MacroServiceProvider::class);
        $this->app->register(ValidatorServiceProvider::class);

        $this->app->singleton(
            'api_response',
            function ($app) {
                return new ApiResponse;
            }
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['api_response'];
    }
}
