<?php

namespace Damnyan\Cmn\Abstracts;

use Illuminate\Http\Resources\Json\Resource;

abstract class AbstractResource extends Resource
{
    public function __construct($resource)
    {
        parent::__construct($resource);
        $this->getRelationshipLoads();
    }

    public function toArray($request)
    {
        return parent::toArray($request);
    }

    public function getRelationshipLoads()
    {
        $relationships = request()->get('relationship');

        if (!$relationships) {
            return;
        }

        $relationships = explode(',', $relationships);

        unset(request()['relationship']);

        $this->load($relationships);
    }
}
