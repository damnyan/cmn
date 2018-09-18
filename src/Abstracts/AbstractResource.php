<?php

namespace Damnyan\Cmn\Abstracts;

use Illuminate\Http\Resources\Json\JsonResource;

abstract class AbstractResource extends JsonResource
{
    /**
     * Constructor
     *
     * @param mixed $resource resource
     */
    public function __construct($resource)
    {
        parent::__construct($resource);
        $this->getRelationshipLoads();
    }

    /**
     * Load relationships based on request
     *
     * @return void
     */
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
