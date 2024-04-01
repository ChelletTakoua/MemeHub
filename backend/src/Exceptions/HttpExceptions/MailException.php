<?php

namespace Exceptions\HttpExceptions;

class MailException extends HttpException
{
    public function __construct($message = "Mail could not be sent", $httpResponseCode = 500, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $httpResponseCode, $code, $previous);
    }
}