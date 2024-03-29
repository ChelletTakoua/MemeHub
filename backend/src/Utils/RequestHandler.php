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
        return json_decode(file_get_contents('php://input'), true);
    }
}
