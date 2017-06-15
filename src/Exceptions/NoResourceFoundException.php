<?php

namespace Damnyan\Cmn\Exceptions;

use Exception;

class NoResourceFoundException extends Exception
{
    public $resource;
    public function __construct($resource = '')
    {
        $this->resource = str_plural($resource);
    }
}