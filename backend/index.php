


<?php
require 'src/Router/Router.php';
require 'src/Controllers/UserController.php';


$router = new Router\Router($_SERVER['REQUEST_URI']);

function testFunction(){
    echo "this is test";
}

$router->get('/', function(){ echo "Bienvenue sur ma homepage !"; });
$router->get('/helloWorld', function(){ echo "Hello World !"; });
$router->get('/test', );
$router->get('/posts/:id', function($id){ echo "Voila l'article $id"; });
$router->post('/users/:id', "UserController@getUserById" );

$router->run();

?>

















<!--

/*$router->get('/users/:id', "UserController@get" );

//$router->get('/', function($id){ echo "Bienvenue sur ma homepage !"; });
$router->get('/posts/:id', function($id){ echo "Voila l'article $id"; });
$router->get('/:abc', 'test');
*/-->
