<?php

namespace Exceptions\HttpExceptions;

class MethodNotAllowedException extends HttpException
{
    public function __construct($message = "Method Not Allowed", $httpResponseCode = 405, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $httpResponseCode, $code, $previous);
    }
}