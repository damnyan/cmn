<?php

namespace Damnyan\Cmn\Exceptions;

use Exception;

class NoResourceFoundException extends Exception
{

    public $resource;

    /**
     * Constructor
     *
     * @param string $resource Resource name
     */
    public function __construct($resource = '')
    {
        $this->resource = str_plural($resource);
    }
}
