<?php


namespace Router;
use Exceptions\HttpExceptions\RouterException;

//require 'Route.php';
//require '../src/Exceptions/HttpExceptions/RouterException.php';
class Router {

    public $url;
    private $routes = []; // liste des routes

    public function __construct($url){
        $this->url = $url;
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


    public function run()
    {
        try {


            if (!isset($this->routes[$_SERVER['REQUEST_METHOD']])) {
                throw new RouterException('REQUEST_METHOD does not exist');
            }
            foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
                if ($route->match($this->url)) {
                    return $route->call();
                }
            }
            throw new RouterException("No matching routes for $this->url");


        } catch (\Exceptions\HttpExceptions\HttpException $e) {
            http_response_code($e->getHttpResponseCode());
            echo $e->getMessage();
        } catch (\Exception $e) {
            // For any other exception, set a generic 500 error code
            http_response_code(500);
            //echo $e->getMessage();
            echo 'An error occurred. Please try again later.';
        }
    }
}