<?php


function logError($e)
{
    // Log the error message, file, line number, class, method, and stack trace
    $logMessage = sprintf(
        "\033[31mError: %s in %s on line %d\n%s\n%s::%s\nStack trace:\n%s\n\nLink to code: vscode://file/%s:%d\033[0m",
        $e->getMessage(),
        $e->getFile(),
        $e->getLine(),
        $e->getMessage(),
        $e->getFile(),
        $e->getLine(),
        $e->getTraceAsString(),
        $e->getFile(),
        $e->getLine()
    );
    error_log($logMessage);
}

function errorHandler($e)
{

    if (! $e instanceof \Exceptions\HttpExceptions\HttpException) {
        logError($e);
            $e = new \Exceptions\HttpExceptions\InternalServerErrorException();
    }

    header('Content-Type: application/json');
    $response = \Utils\ApiResponseBuilder::buildErrorResponse($e->getMessage(), $e->getHttpResponseCode());
    http_response_code($e->getHttpResponseCode());
    echo json_encode($response);
}
