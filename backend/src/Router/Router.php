<?php


namespace Router;
use Authentication\Auth;
use Exceptions\HttpExceptions\RouterException;


class Router
{

    public $url;
    private $routes = []; // liste des routes

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function get($path, $callable, $roles = [])
    {
        $route = new Route($path, $callable, $roles);
        $this->routes["GET"][] = $route;
        return $route;
    }

    public function post($path, $callable, $roles = [])
    {
        $route = new Route($path, $callable, $roles);
        $this->routes["POST"][] = $route;
        return $route;
    }

    public function put($path, $callable, $roles = [])
    {
        $route = new Route($path, $callable, $roles);
        $this->routes["PUT"][] = $route;
        return $route;
    }

    public function delete($path, $callable, $roles = [])
    {
        $route = new Route($path, $callable, $roles);
        $this->routes["DELETE"][] = $route;
        return $route;
    }


    public function run()
    {
        if (!isset($this->routes[$_SERVER['REQUEST_METHOD']])) {
            throw new RouterException("REQUEST_METHOD $_SERVER[REQUEST_METHOD] not supported");
        }
        foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
            if ($route->match($this->url)) {
                $route->validateAccess();
                return $route->call();
            }
        }
        throw new RouterException("No matching routes for $this->url");
    }
}