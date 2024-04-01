<?php


if (!isset($_SESSION['requests'])) {
    $_SESSION['requests'] = [];
}


$request = [
    'method' => $_SERVER['REQUEST_METHOD'],
    'url' => $_SERVER['REQUEST_URI'],
    'headers' => getallheaders(),
    'body' => file_get_contents('php://input'), //TODO: MTBH read more about this
    'timestamp' => time()
];
$last_request_key = array_push($_SESSION['requests'], ['request' => $request, 'response' => null]) - 1;


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

// Register the function to be called at the end of the script execution
register_shutdown_function('save_response');
