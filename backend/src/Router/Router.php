<?php


namespace Router;
require 'Route.php';
require 'RouterException.php';
class Router {

    public $url;
    private $routes = []; // liste des routes

    public function __construct($url){
        $this->url = $url;
        echo "this is in router";
    }

    public function get($path, $callable){
        $route = new Route($path, $callable);
        $this->routes["GET"][] = $route;
        return $route;
    }
    public function post($path, $callable){
        $route = new Route($path, $callable);
        $this->routes["POST"][] = $route;
        return $route;
    }
    public function put($path, $callable){
        $route = new Route($path, $callable);
        $this->routes["PUT"][] = $route;
        return $route;
    }
    public function delete($path, $callable){
        $route = new Route($path, $callable);
        $this->routes["DELETE"][] = $route;
        return $route;
    }


    public function run(){
        if(!isset($this->routes[$_SERVER['REQUEST_METHOD']])){
            throw new RouterException('REQUEST_METHOD does not exist');
        }
        foreach($this->routes[$_SERVER['REQUEST_METHOD']] as $route){
            if($route->match($this->url)){
                return $route->call();
            }
        }
        throw new RouterException('No matching routes');
    }
}