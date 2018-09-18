<?php

namespace Damnyan\Cmn\Exceptions;

use Exception;

class ResourceNotFoundException extends Exception
{

    public $resource;

    /**
     * Constructor
     *
     * @param string $resource Resource name
     */
    public function __construct($resource = '')
    {
        $this->resource = $resource;
    }
}
