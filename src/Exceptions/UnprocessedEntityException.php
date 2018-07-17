<?php

namespace Damnyan\Cmn\Exceptions;

use Exception;

class UnprocessedEntityException extends Exception
{
    public $errors;
    public function __construct($errors)
    {
        $this->errors = $errors;
    }
}
