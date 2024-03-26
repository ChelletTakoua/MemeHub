<?php

namespace Exceptions\HttpExceptions;

class NotLoggedInException extends HttpException
{

    public function __construct($message = "Not Logged In", $httpResponseCode = 401, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $httpResponseCode, $code, $previous);
    }

}