<?php

namespace Damnyan\Cmn\Exceptions;

use Exception;

class BadRequestException extends Exception
{

    public $msg;

    public function __construct($msg)
    {
        $this->msg = $msg;
    }
}
