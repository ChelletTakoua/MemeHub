<?php
session_start();

require_once '../src/autoload.php';
require_once '../src/Utils/headers.php';
require_once '../src/Exceptions/ErrorHandler.php';
require_once '../src/Debugging/Debug.php';

$router = new Router\Router();
require '../src/Router/routes.php';

$router->run();























