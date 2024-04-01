<?php

namespace Exceptions\HttpExceptions;

class ExpiredTokenException extends HttpException
{

    public function __construct($message = 'Expired token', $httpResponseCode = 408, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $httpResponseCode, $code, $previous);
    }
}