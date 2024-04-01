<?php

// if the development mode is not enabled, we don't need to do anything
$appConfig = include __DIR__ . '/../config/app.php';

if ( ! $appConfig['development_mode']) {
    return;
}


if (!isset($_SESSION['requests'])) {
    $_SESSION['requests'] = [];
}


$request = [
    'method' => $_SERVER['REQUEST_METHOD'],
    'url' => $_SERVER['REQUEST_URI'],
    'get_params' => $_GET,
    'post_params' => $_POST,
    'headers' => getallheaders(),
    'body' => file_get_contents('php://input'), //TODO: MTBH read more about this
    'timestamp' => time()
];


$last_request_key = array_push($_SESSION['requests'], ['request' => $request,'routing'=>null,'response'=>null]) - 1;


function get_headers_assoc() {
    $headers = [];
    foreach (headers_list() as $header) {
        list($name, $value) = explode(': ', $header, 2);
        $headers[$name] = $value;
    }
    return $headers;
}

function save_response() {
    global $last_request_key;

    $response = [
        'headers' => get_headers_assoc(),
        'body' => ob_get_contents(),
        'timestamp' => time()
    ];
    $_SESSION['requests'][$last_request_key]['response'] = $response;

}
function save_routing() {
    global $last_request_key;
    global $router;

    //var_dump($router->getRouteMatchingLogs());

    $routing = [
        'matched_route' => $router->getMatchedRoute()?->jsonSerialize(),
        'matching_logs' => $router->getRouteMatchingLogs(),
    ];
    $_SESSION['requests'][$last_request_key]['routing'] = $routing;
}

register_shutdown_function('save_response');
register_shutdown_function('save_routing');
