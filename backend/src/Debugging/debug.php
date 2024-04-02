<?php


// if the development mode is not enabled, we don't need to do anything
$appConfig = include __DIR__ . '/../config/app.php';

if ( ! $appConfig['development_mode']) {
    return;
}


if (!isset($_SESSION['requests'])) {
    $_SESSION['requests'] = [];
}
ob_start();

$request = [
    'method' => $_SERVER['REQUEST_METHOD'],
    'url' => $_SERVER['REQUEST_URI'],
    'get_params' => $_GET,
    'post_params' => $_POST,
    'headers' => getallheaders(),
    'body' => file_get_contents('php://input'), //TODO: MTBH read more about this
    'timestamp' => microtime(true)
];


$last_request_key = array_push($_SESSION['requests'], ['request' => $request,'routing'=>null,'response'=>null]) - 1;

/**
 * Get the headers as an associative array
 * @return array
 */
function get_headers_assoc() {
    $headers = [];
    foreach (headers_list() as $header) {
        list($name, $value) = explode(': ', $header, 2);
        $headers[$name] = $value;
    }
    return $headers;
}
/**
 * Save the response in the session
 * @return void
 
 */
function save_response() {
    global $last_request_key;

    $body = json_decode( ob_get_contents(),true);

    $response = [
        'headers' => get_headers_assoc(),
        'body' => $body,
        'status_code' => http_response_code(),
        'timestamp' => microtime(true)
    ];
    

    if(isset($body) && isset($body['message']) && isset($body["status"]) && $body["status"] == "error"){
        $response["error_message"] = $body['message'];
    }



    $_SESSION['requests'][$last_request_key]['response'] = $response;

}
/**
 * Save the routing in the session
 * @return void
 */
function save_routing() {
    global $last_request_key;
    global $router;

    $routing = [
        'matched_route' => $router->getMatchedRoute()?->jsonSerialize(),
        'matching_logs' => $router->getRouteMatchingLogs(),
    ];
    $_SESSION['requests'][$last_request_key]['routing'] = $routing;
}

register_shutdown_function('save_response');
register_shutdown_function('save_routing');
