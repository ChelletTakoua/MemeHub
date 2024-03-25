<?php

namespace Exceptions\HttpExceptions;


//require '../src/Exceptions/HttpExceptions/HttpException.php';


class UnauthorizedException extends HttpException
{
    public function __construct($message = "Unauthorized", $httpResponseCode = 401, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $httpResponseCode, $code, $previous);
    }
}