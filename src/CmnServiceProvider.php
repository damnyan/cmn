<?php

namespace Damnyan\Cmn;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Query\Builder as QBuilder;
use Illuminate\Database\Eloquent\Builder as EBuilder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class CmnServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes(
            [__DIR__.'/../config/cmn.php' => config_path('cmn.php')],
            'config'
        );

        $this->loadTranslationsFrom(__DIR__.'/Resources/Lang', 'cmn');
        $this->bootValidators();
        $this->bootMacros();
    }

    private function bootValidators()
    {
        Validator::extend(
            'uc_image',
            '\Damnyan\Cmn\Validators\ImageValidator@ucImage'
        );
    }

    private function bootMacros()
    {
        $parent = $this;

        QBuilder::macro(
            'getOrPaginate',
            function () use($parent) {
                return $parent::getOrPaginate($this);
            }
        );

        EBuilder::macro(
            'getOrPaginate',
            function () use($parent) {
                return $parent::getOrPaginate($this);
            }
        );

        BelongsToMany::macro(
            'getOrPaginate',
            function () use($parent) {
                return $parent::getOrPaginate($this);
            }
        );

        HasManyThrough::macro(
            'getOrPaginate',
            function () use($parent) {
                return $parent::getOrPaginate($this);
            }
        );
    }

    public static function getOrPaginate($macroable)
    {
        $isPaginated = (string) request()->get('paginate', 1);
        $perPage     = (int) (request()->get('per_page', config('cmn.default_per_page')));

        if ($isPaginated != '0') {
            return $macroable->paginate($perPage)
                ->appends(request()->except('page'));
        }

        return $macroable->get();
    }

    public function register()
    {
        //
    }
}
