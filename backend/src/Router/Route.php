<?php

namespace Router;

use Authentication\Auth;
use Exceptions\HttpExceptions\NotLoggedInException;
use Exceptions\HttpExceptions\UnauthorizedException;

class Route {

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
}