<?php


function errorHandler($e)
{
    $response = [
        'success' => false,
        'message' => ''
    ];

    if ($e instanceof \Exceptions\HttpExceptions\HttpException) {
        $response['message'] = $e->getMessage();
        http_response_code($e->getHttpResponseCode());
    } else {
        $response['message'] = 'An error occurred. Please try again later.';
        http_response_code(500);
    }

    // Return the response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}
