<?php


ini_set('display_errors', 'Off');
ini_set('error_reporting', E_ALL);
/**
 * Log the error message, file, line number, class, method, and stack trace
 * @param Exception $e the exception to log
 * @param bool $red whether to color the error message red
 * @return void
 */

function logError($e, $red = true)
{
    $logMessage = sprintf(
        ($red ? "\e[0;31m" : "") . "Error: %s in %s on line %d\n%s\n%s::%s\nStack trace:\n%s\n\nLink to code: vscode://file/%s:%d" . ($red ? "\033[0m" : ""),
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

/**
 * Handle the error by logging it, setting the response code, and sending a JSON response
 * @param Exception $e the exception to handle
 * @return void
 */
function errorHandler($e)
{
    // If the exception is not an instance of HttpException, log the error and replace the exception with an InternalServerErrorException
    if (!$e instanceof \Exceptions\HttpExceptions\HttpException) {
        logError($e);
        $e = new \Exceptions\HttpExceptions\InternalServerErrorException();
    } else {
        // If the exception is an instance of HttpException, log the error without replacing the exception
        logError($e, false);
    }
    // Set the Content-Type header to application/json
    header('Content-Type: application/json');
    // Build an error response using the message and HTTP response code from the exception
    $response = \Utils\ApiResponseBuilder::buildErrorResponse($e->getMessage(), $e->getHttpResponseCode());
    // Set the HTTP response code to the response code from the exception
    http_response_code($e->getHttpResponseCode());
    // Echo the error response as a JSON string
    echo json_encode($response);
}
// Set this function as the exception handler
set_exception_handler('errorHandler');
