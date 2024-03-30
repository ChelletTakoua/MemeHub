<?php
session_start();

require_once '../src/autoload.php';
require_once '../src/Utils/headers.php';
require_once '../src/Exceptions/ErrorHandler.php';
set_exception_handler('errorHandler');

$router = new Router\Router($_SERVER['REQUEST_URI']);
require '../src/Router/routes.php';

$router->run();

//if you want to test connection to the database and test the query
// 1- run xampp , start mysql and apache and select the database test
// 2-
// 2- you have to run the schema.sql script located in database directory on the test database of xampp
// 3- uncomment the following code

/*
$connection = Database\DatabaseConnection::getInstance();
var_dump($connection);
$query = new Database\DatabaseQuery();
var_dump($query->executeQuery("SELECT * FROM users"));
*/























