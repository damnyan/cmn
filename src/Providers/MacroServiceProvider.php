<?php

namespace Damnyan\Cmn\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Query\Builder as QBuilder;
use Illuminate\Database\Eloquent\Builder as EBuilder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class MacroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $parent = $this;

        QBuilder::macro(
            'getOrPaginate',
            function () use ($parent) {
                return $parent::getOrPaginate($this);
            }
        );

        EBuilder::macro(
            'getOrPaginate',
            function () use ($parent) {
                return $parent::getOrPaginate($this);
            }
        );

        BelongsToMany::macro(
            'getOrPaginate',
            function () use ($parent) {
                return $parent::getOrPaginate($this);
            }
        );

        HasManyThrough::macro(
            'getOrPaginate',
            function () use ($parent) {
                return $parent::getOrPaginate($this);
            }
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Get or paginate macro
     *
     * @param mixed $macroable Macroable class
     * @return void
     */
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
}
