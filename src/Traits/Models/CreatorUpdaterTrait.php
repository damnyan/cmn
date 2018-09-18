<?php

namespace Damnyan\Cmn\Traits\Models;

use Auth;

trait CreatorUpdaterTrait
{
    /**
     * Boot for creator updater trait
     *
     * @return void
     */
    public static function bootCreatorUpdaterTrait()
    {
        static::creating(
            function ($model) {
                if (Auth::check()) {
                    $model->created_by = Auth::user()->id;
                    if (!$model->creatorOnly) {
                        $model->updated_by = Auth::user()->id;
                    }
                }
            }
        );

        static::updating(
            function ($model) {
                if (Auth::check()) {
                    if (!$model->creatorOnly) {
                        $model->updated_by = Auth::user()->id;
                    }
                }
            }
        );

        static::deleting(
            function ($model) {
                if (Auth::check()) {
                    if (!$model->creatorOnly) {
                        $model->updated_by = Auth::user()->id;
                    }
                }
            }
        );

        if (function_exists('restoring')) {
            static::restoring(
                function ($model) {
                    if (Auth::check()) {
                        if (!$model->creatorOnly) {
                            $model->updated_by = Auth::user()->id;
                        }
                    }
                }
            );
        }
    }

    /**
     * Creator relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo($this->userClass, 'created_by', 'id')
            ->withTrashed();
    }

    /**
     * Updater relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function updater()
    {
        return $this->belongsTo($this->userClass, 'updated_by', 'id')
            ->withTrashed();
    }
}
