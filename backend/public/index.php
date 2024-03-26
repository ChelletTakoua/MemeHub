<?php
session_start();

require_once '../src/autoload.php';

require_once '../src/Exceptions/ErrorHandler.php';
//set_exception_handler('errorHandler');



$router = new Router\Router($_SERVER['REQUEST_URI']);
require '../src/Router/routes.php';

$router->run();
$connection = \Database\DatabaseConnection::getInstance();
echo"\n\n";
var_dump($connection);
echo __DIR__ . "/../src/config/database.php";















