<?php

namespace Damnyan\Cmn\Exceptions;

use Exception;

class RequestErrorException extends Exception
{
    public $errors;
    public function __construct($errors)
    {
        $this->errors = $errors;
    }
}