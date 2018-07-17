<?php

namespace Damnyan\Cmn;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;

class CmnServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/cmn.php' => config_path('cmn.php'),
        ], 'config');

        $this->loadTranslationsFrom(__DIR__.'/Resources/Lang', 'cmn');

        Builder::macro('getOrPaginate', function () {
            $isPaginated = (string) request()->get('paginate', 1);
            $perPage = (int) (request()->get('per_page', config('cmn.default_per_page')));

            if ($isPaginated != '0') {
                return $this->paginate($perPage)
                    ->appends(request()->except('page'));
            }

            return $this->get();
        });
    }

    public function register(){}
}
