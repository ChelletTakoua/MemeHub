<?php

namespace Exceptions\HttpExceptions;


class LoginFailedException extends HttpException
{
    public function __construct($message , $httpResponseCode = 401, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $httpResponseCode, $code, $previous);
    }
}