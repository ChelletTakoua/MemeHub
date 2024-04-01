<?php
session_start();

require_once '../src/autoload.php';
require_once '../src/Utils/headers.php';
require_once '../src/Exceptions/ErrorHandler.php';

$router = new Router\Router();

require_once '../src/Debugging/debug.php';
require '../src/Router/routes.php';

$router->run();























