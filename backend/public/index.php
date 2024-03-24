


<?php
session_start();

require_once '../src/autoload.php';

/*
require '../src/Router/Router.php';
require '../src/Controllers/UserController.php';
require '../src/Controllers/ExampleController.php';*/

$router = new Router\Router($_SERVER['REQUEST_URI']);

require '../src/Router/routes.php';

$router->run();

?>

















