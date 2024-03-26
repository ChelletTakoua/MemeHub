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

    if (! $e instanceof \Exceptions\HttpExceptions\HttpException) {
        logError($e);
            $e = new \Exceptions\HttpExceptions\InternalServerErrorException();
    }

    $response = [
        'success' => false,
        'message' => $e->getMessage()
    ];

    header('Content-Type: application/json');
    http_response_code($e->getHttpResponseCode());
    echo json_encode($response);
}
