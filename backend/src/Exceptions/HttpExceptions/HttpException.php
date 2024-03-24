<?php

namespace Exceptions\HttpExceptions;

//this class is used to throw exceptions with a specific HTTP response code
class HttpException extends \Exception // maybe rename to FrontendException
{
    protected $httpResponseCode;

    public function __construct($message = "", $httpResponseCode = 500, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->httpResponseCode = $httpResponseCode;
    }

    public function getHttpResponseCode()
    {
        return $this->httpResponseCode;
    }
}