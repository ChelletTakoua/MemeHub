<?php


// TODO: to read more about CORS: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
// Allow requests from any origin
header('Access-Control-Allow-Origin: localhost:3000');

// Allow the following methods from the frontend
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

// Allow the following headers from the frontend
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');

// Allow cookies to be sent from the frontend
header('Access-Control-Allow-Credentials: true');


// if the response is not json, just overwrite the content type in the controller
//  ex: header('Content-Type: text/html');
//      header('Content-Type: application/pdf');
header('Content-Type: application/json');




