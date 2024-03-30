<?php

namespace Router;

use Authentication\Auth;
use Closure;
use Exceptions\HttpExceptions\NotLoggedInException;
use Exceptions\HttpExceptions\UnauthorizedException;
use JsonSerializable;

class Route implements JsonSerializable {

    private $path;
    private $callable;
    private $matches = [];
    private $params = [];
    private $roles;

    public function __construct($path, $callable, $roles = []) {
        $this->path = trim($path, '/');
        $this->callable = $callable;
        $this->roles = $roles;
    }

    /**
     *  Get the path of the route
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }
    /**
     *  Get the Roles permitted to access the route
     *  @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     *  Get the callable name of the route
     * @return string
     */
    public function getCallable(): string
    {
        if ($this->callable instanceof Closure) {
            return 'Closure';
        }
        return $this->callable;
    }



    /**
     * Permettra de capturer l'url avec les paramètre
     * get('/posts/:id') par exemple
     **/
    public function match($url){

        $url = trim($url, '/');
        $path = preg_replace('#:([\w]+)#', '([^/]+)', $this->path);
        $regex = "#^$path$#i";
        if(!preg_match($regex, $url, $matches)){
            return false;
        }
        array_shift($matches);
        $this->matches = $matches;
        return true;
    }

    public function call(){
        //si $callable est de la forme ExampleController@exemple
        if (is_string($this->callable) && strpos($this->callable, '@') !== false){
            $params = explode('@', $this->callable);
            $controller = "Controllers\\" . $params[0];
            $controller = new $controller();

            return call_user_func_array([$controller, $params[1]], $this->matches);
        } else {
            return call_user_func_array($this->callable, $this->matches);
        }
    }

    public function validateAccess() {
        return; // TODO: to remove this line (it's just for testing purposes to allow all requests to pass through)
        if(in_array('guest', $this->roles)){
            return;
        }
        if (!Auth::isLoggedIn()) {
            throw new NotLoggedInException();
        }
        if (Auth::getActiveUser()->getRole()==='admin') {
            return;
        }
        if (!in_array(Auth::getActiveUser()->getRole(), $this->roles)) {
            throw new UnauthorizedException();
        }
    }


    public function jsonSerialize()
    {
        return [
            'path' => '/'.$this->path,
            'roles' => $this->roles,
            'callable' => $this->getCallable()
        ];
    }
}