<?php

namespace Damnyan\Cmn\Abstracts;

use Illuminate\Http\Resources\Json\ResourceCollection;

abstract class AbstractResourceCollection extends ResourceCollection
{
    /**
     * Constructor
     *
     * @param mixed $resource resource
     */
    public function __construct($resource)
    {
        $resource = $this->getRelationshipLoads($resource);
        parent::__construct($resource);
    }

    /**
     * Load relationships based on request
     *
     * @param string $resource CSV relationship
     * @return mixed
     */
    public function getRelationshipLoads($resource)
    {
        $relationships = request()->get('relationship');

        if (!$relationships) {
            return $resource;
        }

        $relationships = explode(',', $relationships);

        unset(request()['relationship']);

        $resource->load($relationships);

        return $resource;
    }
}
