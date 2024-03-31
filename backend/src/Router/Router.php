<?php


namespace Router;
use Authentication\Auth;
use Exceptions\HttpExceptions\RouterException;


class Router
{

    public $url;
    public $routes = []; // liste des routes

    public function __construct()
    {
        $this->url = explode("?",$_SERVER['REQUEST_URI'])[0];
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
    public function options($path, $callable, $roles = [])
    {
        $route = new Route($path, $callable, $roles);
        $this->routes["OPTIONS"][] = $route;
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

    /**
     * Get the value of routes
     * @return array
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * A function that prints all the routes in a readable and beautiful html way
     * @return void
     */
    public function printRoutes(){
        echo "<h1>Routes</h1>";
        echo "<table border='1'>";
        echo "<tr><th>Method</th><th>Path</th><th>Callable</th><th>Roles</th></tr>";

        foreach ($this->routes as $method => $routes) {
            foreach ($routes as $route) {
                echo "<tr>";
                echo "<td>$method</td>";
                echo "<td>". $route->getPath()  ."</td>";
                echo "<td>". $route->getCallable() ."</td>";
                echo "<td>".implode(", ", $route->getRoles())."</td>";
                echo "</tr>";
            }
        }
        echo "</table>";
    }

    //TODO: add an option to print the routes in the console for debugging (print each route and if it's matched or not)


}