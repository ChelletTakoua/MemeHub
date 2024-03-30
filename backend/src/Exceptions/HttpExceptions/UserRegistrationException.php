<?php

namespace Exceptions\HttpExceptions;


class UserRegistrationException extends HttpException
{
    public function __construct($message, $httpResponseCode = 500, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $httpResponseCode, $code, $previous);
    }
}