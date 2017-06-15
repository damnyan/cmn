<?php

namespace Damnyan\Cmn\Exceptions;

use Exception;

class InvalidRequestException extends Exception
{
    public $msg;
    public function __construct($msg)
    {
        $this->msg = $msg;
    }
}