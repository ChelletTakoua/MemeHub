<?php

namespace Exceptions\HttpExceptions;

class InvalidTokenException extends HttpException
{

    public function __construct($message = 'Invalid token' , $httpResponseCode = 403, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $httpResponseCode, $code, $previous);
    }

}