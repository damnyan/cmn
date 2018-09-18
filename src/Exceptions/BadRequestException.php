<?php

namespace Damnyan\Cmn\Exceptions;

use Exception;

class BadRequestException extends Exception
{

    public $message;

    /**
     * Constructor
     *
     * @param string $message message
     */
    public function __construct($message)
    {
        $this->message = $message;
    }
}
