<?php

namespace Damnyan\Cmn\Exceptions;

use Exception;

class ResourceNotFoundException extends Exception
{

    public $resource;

    public function __construct($resource = '')
    {
        $this->resource = $resource;
    }
}
