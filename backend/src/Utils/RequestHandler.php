<?php

namespace Utils;

class RequestHandler {

    /**
     * Get the request body as an associative array
     *
     * @return array
     */
    public static function getJsonRequestBody(): array
    {
        return json_decode(file_get_contents('php://input'), true) ?? [];
    }



    /**
     * Retrieves parameters from the current request.
     *
     * This function returns an associative array containing parameters passed to the current script,
     * regardless of the HTTP request method used (GET, POST, etc.). It combines parameters from the
     * $_GET, $_POST, and $_COOKIE superglobal arrays into a single array.
     *
     * @return array An associative array containing parameters from the current request.
     */
    public static function getRequestParameters() :array
    {
        return !empty($_REQUEST) ? $_REQUEST : [];
    }
}
