<?php

namespace Exceptions\HttpExceptions;



class RouterException extends HttpException
{

    public function __construct($message = "Router Exception", $httpResponseCode = 400, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $httpResponseCode, $code, $previous);
    }
}