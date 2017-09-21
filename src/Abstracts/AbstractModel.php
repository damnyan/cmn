<?php

namespace Damnyan\Cmn\Abstracts;

use Damnyan\Cmn\Exceptions\BadRequestException;
use Damnyan\Cmn\Exceptions\NoResourceFoundException;
use Damnyan\Cmn\Exceptions\ResourceNotFoundException;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractModel extends Model
{
    protected $resourceName = 'Resource';

    protected $userClass = \App\Modules\User\Models\User::class;

    protected $creatorOnly = false;

    public function getCreatedAtAttribute($date)
    {
        return $this->modelDefaultFormat($date);
    }

    public function getUpdatedAtAttribute($date)
    {
        return $this->modelDefaultFormat($date);
    }

    public static function createOrThrow(array $attributes = [])
    {
        $resource = parent::create($attributes);

        if (!$resource) {
            throw new BadRequestException('Failed to create '.parent::getResourceName().'. Please try again later.');
        }

        return $resource;
    }

    public function updateOrThrow(array $values)
    {
        $resource = parent::update($values);

        if (!$resource) {
            throw new BadRequestException('Failed to update '.$this->resourceName.'. Please try again later.');
        }

        return $resource;
    }

    public function deleteOrThrow()
    {
        $resource = parent::delete();

        if (!$resource) {
            throw new BadRequestException('Failed to delete '.$this->resourceName.'. Please try again later.');
        }

        return $resource;
    }

    private function modelDefaultFormat($date)
    {
        $date = new Carbon($date);
        return $date->format(env('RESPONSE_DEFAULT_DATE_FORMAT', 'm/d/Y H:i:s'));
    }

    public function scopeFindOrThrow($query, $id, $columns = ['*'])
    {
        if (!$resource = $query->find($id, $columns)) {
            throw new ResourceNotFoundException($this->resourceName);
        }

        return $resource;
    }

    public function scopeFirstOrThrow($query, $columns = ['*'])
    {
        if (!$resource = $query->first($columns)) {
            throw new ResourceNotFoundException($this->resourceName);
        }

        return $resource;
    }

    public function scopeFindByIds($query, $ids, $columns = ['*'])
    {
        return $query->whereIn('id', $ids);
    }

    public function scopeAllOrThrow($query, $columns = ['*'])
    {
        $resources = $query->get($columns);
        
        if ($resources->count()<1) {
            throw new NoResourceFoundException($this->resourceName);
        }

        $isPaginated = Request::get('is_paginated');
        if ($isPaginated) {
            return $resources->paginate(25);
        }

        return $resources;
    }

    public function scopeFindByIdsOrThrow($query, $ids, $columns = ['*'])
    {
        $resources = $query->findByIds($ids);
        if($resources->count()<1)
            throw new NoResourceFoundException($this->resourceName);

        return $resources->get();
    }

    public function scopeFindByOrThrow($query, $field, $value, $operator = '=')
    {
        if(is_array($value))
            $resources = $query->whereIn($field, $value);
        else
            $resources = $query->where($field, $operator, $value);

        if($resources->count()<1)
            throw new NoResourceFoundException($this->resourceName);

        return $resources;
    }

    public function getResourceName()
    {
        return $this->resourceName;
    }
}
