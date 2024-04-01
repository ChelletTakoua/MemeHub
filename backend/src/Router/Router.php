<?php


namespace Router;
use Authentication\Auth;
use Exceptions\HttpExceptions\RouterException;


class Router
{

    private static $devMode = false; // TODO: store this in a config file instead of hardcoding it

    public $url;
    public $routes = []; // liste des routes

    private $matchedRoute;

    public function __construct()
    {
        $this->url = explode("?",$_SERVER['REQUEST_URI'])[0];
    }


    /**
     * Add a new route to the router with the GET method
     * @param string $path the path of the route
     * @param string|callable $callable the function to call when the route is matched, can be a string like "Controller@function" or a closure or a path to a php file
     * @param array $roles the roles that can access this route
     * @param bool $developmentMode if true, the route will only be added if the server is in development mode
     * @return void
     */
    public function get($path, $callable, $roles = [], $developmentMode = false)
    {
        if($developmentMode && !self::$devMode) return;

        $route = new Route($path, $callable, $roles);
        $this->routes["GET"][] = $route;
    }


    /**
     * Add a new route to the router with the POST method
     * @param string $path the path of the route
     * @param string|callable $callable the function to call when the route is matched, can be a string like "Controller@function" or a closure or a path to a php file
     * @param array $roles the roles that can access this route
     * @param bool $developmentMode if true, the route will only be added if the server is in development mode
     * @return void
     *
     */
    public function post($path, $callable, $roles = [], $developmentMode = false)
    {
        if($developmentMode && !self::$devMode) return;

        $route = new Route($path, $callable, $roles);
        $this->routes["POST"][] = $route;
    }


    /**
     * Add a new route to the router with the PUT method
     * @param string $path the path of the route
     * @param string|callable $callable the function to call when the route is matched, can be a string like "Controller@function" or a closure or a path to a php file
     * @param array $roles the roles that can access this route
     * @param bool $developmentMode if true, the route will only be added if the server is in development mode
     * @return void
     */
    public function put($path, $callable, $roles = [], $developmentMode = false)
    {
        if($developmentMode && !self::$devMode) return;

        $route = new Route($path, $callable, $roles);
        $this->routes["PUT"][] = $route;
    }


    /**
     * Add a new route to the router with the DELETE method
     * @param string $path the path of the route
     * @param string|callable $callable the function to call when the route is matched, can be a string like "Controller@function" or a closure or a path to a php file
     * @param array $roles the roles that can access this route
     * @param bool $developmentMode if true, the route will only be added if the server is in development mode
     * @return void
     */
    public function delete(string $path, callable|string $callable, array $roles = [], bool $developmentMode = false)
    {
        if($developmentMode && !self::$devMode) return;

        $route = new Route($path, $callable, $roles);
        $this->routes["DELETE"][] = $route;
    }

    /**
     * Add a new route to the router with the OPTIONS method
     * @param string $path the path of the route
     * @param string|callable $callable the function to call when the route is matched, can be a string like "Controller@function" or a closure or a path to a php file
     * @param array $roles the roles that can access this route
     * @param bool $developmentMode if true, the route will only be added if the server is in development mode
     * @return void
     */
    public function options($path, $callable, $roles = [], $developmentMode = false)
    {
        if($developmentMode && !self::$devMode) return;

        $route = new Route($path, $callable, $roles);
        $this->routes["OPTIONS"][] = $route;
    }


    public function run()
    {
        if (!isset($this->routes[$_SERVER['REQUEST_METHOD']])) {
            throw new RouterException("REQUEST_METHOD $_SERVER[REQUEST_METHOD] not supported");
        }
        foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
            if ($route->match($this->url)) {
                $this->matchedRoute = $route;
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

    public function getMatchedRoute()
    {
        return $this->matchedRoute;
    }


    /**
     * This function returns an array of all the routes and a log for each route ("not matched" or "matched" or "not checked")
     */
    public function getRouteMatchingLogs()
    {
        $logs = [];
        foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
            $logs[] = $route->JsonSerialize();
        }
        return $logs;


    }


}