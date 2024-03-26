<?php


function logError($e)
{
    // Log the error message, file, line number, class, method, and stack trace
    $logMessage = sprintf(
        "\033[31mError: %s in %s on line %d\n%s\n%s::%s\nStack trace:\n%s\033[0m",
        $e->getMessage(),
        $e->getFile(),
        $e->getLine(),
        $e->getMessage(),
        $e->getFile(),
        $e->getLine(),
        $e->getTraceAsString()
    );
    error_log($logMessage);
}

function errorHandler($e)
{
    logError($e);

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
