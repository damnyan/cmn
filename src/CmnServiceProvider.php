<?php

namespace Damnyan\Cmn;

use Illuminate\Support\ServiceProvider;

class CmnServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__.'/Resources/Lang', 'cmn');
    }

    public function register(){}
}
