<?php

namespace Exceptions\HttpExceptions;

class NotFoundException extends HttpException
{
    public function __construct($message = "Not Found", $httpResponseCode = 404, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $httpResponseCode, $code, $previous);
    }
}