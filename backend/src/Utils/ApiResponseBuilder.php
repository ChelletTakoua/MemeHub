<?php

namespace Utils;

class ApiResponseBuilder
{
    public static function buildSuccessResponse($data, $statusCode = 200)
    {
        return [
            'status' => 'success',
            'code' => $statusCode,
            'data' => $data
        ];
    }

    public static function buildErrorResponse($message, $statusCode)
    {
        return [
            'status' => 'error',
            'code' => $statusCode,
            'message' => $message
        ];
    }
}
