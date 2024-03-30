<?php

namespace Exceptions\HttpExceptions;


class BadRequestException extends HttpException
{
    public function __construct($message , $httpResponseCode = 400, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $httpResponseCode, $code, $previous);
    }
}