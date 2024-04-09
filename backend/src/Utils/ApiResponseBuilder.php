<?php

namespace Utils;

use http\Message;

/**
 * This class is used to build API responses
 */
class ApiResponseBuilder
{
    /**
     * This method is used to build a success response
     * @param array $data The data to be returned (not returned if empty)
     * @param string $message The message to be returned, will not be returned if empty (default is empty)
     * @param int $statusCode The status code to be returned, default is 200
     * @return array
     */
    public static function buildSuccessResponse(array $data=[], string $message = "" , int $statusCode = 200): array
    {
        http_response_code($statusCode);

        $response = [
            'status' => 'success',
            'code' => $statusCode
        ];

        if (!empty($data)) {
            $response['data'] = $data;
        }

        if (!empty($message)) {
            $response['message'] = $message;
        }

        return $response;
    }


    /**
     * This method is used to build an error response
     * @param string $message The message to be returned
     * @param int $statusCode The status code to be returned
     * @param array $data The data to be returned (not returned if empty)
     * @return array
     */
    public static function buildErrorResponse(string $message,int  $statusCode,array $data=[]): array
    {
        $response = [
            'status' => 'error',
            'code' => $statusCode,
            'message' => $message
        ];
        if (!empty($data)) {
            $response['data'] = $data;
        }
        return $response;
    }
}
