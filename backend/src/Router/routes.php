<?php
// all your routes will go here

global $router;
function testFunction(){
    echo "this is test";
}

$router->get('/', function(){ echo "Bienvenue sur ma homepage !"; });
$router->get('/helloWorld', function(){ echo "Hello World !"; });
$router->get('/test', 'testFunction');
$router->get('/posts/:id', function($id){ echo "Voila l'article $id"; });

$router->post('/users/:id', "UserController@getUserById" );

$router->get('/example', "ExampleController@referenceMethod" );
$router->get('/users/:id', "UserController@getUserById" );

