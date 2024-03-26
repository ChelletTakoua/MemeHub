<?php

namespace Exceptions\HttpExceptions;

class InternalServerErrorException extends HttpException
{
    public function __construct($message = "Internal Server Error", $httpResponseCode = 500, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $httpResponseCode, $code, $previous);
    }
}