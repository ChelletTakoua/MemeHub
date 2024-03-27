<?php
// all your routes will go here

global $router;


/*
 *
 $router->get('/users', "UserController@getAllUsers" );
$router->get('/users/:id', "UserController@getUserById" );
$router->post('/users/:id', "UserController@getUserById" );

$router->get('/example', "ExampleController@referenceMethod" );

*/

$router->get('/users', "UserController@getAllUsers", ['user', 'admin']);
$router->get('/users/:id', "UserController@getUserById", ['admin']);
$router->post('/users/:id', "UserController@getUserById", ['admin']);
$router->get('/example', "ExampleController@referenceMethod", ['user', 'admin']);




