<?php

namespace Exceptions\HttpExceptions;

/**
 * Class HttpException is the base class for all HTTP exceptions.
 * HTTP exceptions represent an HTTP error status code to be returned to the client.
 * @package Exceptions\HttpExceptions
 */
class HttpException extends \Exception
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