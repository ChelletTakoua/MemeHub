<?php
// all your routes will go here

global $router;
    

// use this route to test your code (len t7eb ttesti ayy haja)  Yaa Sioua meghir ma tbaddel fl index.php 5allih rayedh!!
$router->get('/test', 'TestController@testMethod');


$router->get('/', function (){echo "welcome to the homepage";});

$router->get('/users', "UserController@getAllUsers", ['user', 'admin']);
$router->get('/users/:id', "UserController@getUserById", ['admin']);
$router->post('/users/:id', "UserController@getUserById", ['admin']);
$router->get('/example', "ExampleController@referenceMethod", ['user', 'admin']);




