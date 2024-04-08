<?php

namespace Router;

use Authentication\Auth;
use Closure;
use Exceptions\HttpExceptions\NotLoggedInException;
use Exceptions\HttpExceptions\UnauthorizedException;
use JsonSerializable;

class Route implements JsonSerializable
{

    private $path;
    private $callable;
    private $matches = [];
    private $params = [];
    private $roles;
    private $developmentMode;

    private $matchingStatus = 'not checked';

    public function __construct($path, $callable, $roles = [], $developmentMode = false)
    {
        $this->path = trim($path, '/');
        $this->callable = $callable;
        $this->roles = $roles;
        $this->developmentMode = $developmentMode;
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
     * return true if the route match the url
     *  @param string $url
     *  @return bool
     **/
    public function match($url)
    {
        // If the route's path is '*', match all URLs and set the matching status to 'matched'
        if ($this->path === '*') {
            $this->matchingStatus = 'matched';
            return true;
        }
        // Trim the trailing slash from the URL and replace any parameters in the path (denoted by ':') with a regex group
        $url = trim($url, '/');
        $path = preg_replace('#:([\w]+)#', '([^/]+)', $this->path);
        $regex = "#^$path$#i";
        // Try to match the URL to the path using a case-insensitive regex
        if (!preg_match($regex, $url, $matches)) {
            // If the URL does not match the path, set the matching status to 'not matched' and return false
            $this->matchingStatus = 'not matched';
            return false;
        }
        // If the URL does match the path, remove the first element from the matches array (which is the entire matched string)
        array_shift($matches);
        // Set the matches property to the remaining matches, set the matching status to 'matched', and return true
        $this->matches = $matches;
        $this->matchingStatus = 'matched';
        return true;
    }

    /**
     * Call the route
     * @return mixed
     * @throws \Exception
     */

    public function call()
    {
        if (is_string($this->callable) && str_contains($this->callable, '.php')) { // php file
            if (!file_exists($this->callable)) {
                throw new \Exception("File not found: $this->callable");
            }
            include $this->callable;
            return null;
        }

        if (is_string($this->callable) && str_contains($this->callable, '@')) { // controller
            $params = explode('@', $this->callable);
            $controller = "Controllers\\" . $params[0];
            $controller = new $controller();
            return call_user_func_array([$controller, $params[1]], $this->matches);
        }

        return call_user_func_array($this->callable, $this->matches); // closure
    }

    /**
     * Validate the access to the route. I access is not permitted, an exception is thrown
     * @throws NotLoggedInException
     * @throws UnauthorizedException
     */
    public function validateAccess()
    {

        if (in_array('guest', $this->roles)) {
            return;
        }
        if (!Auth::isLoggedIn()) {
            throw new NotLoggedInException();
        }
        if (Auth::getActiveUser()->getRole() === 'admin') {
            return;
        }
        if (!in_array(Auth::getActiveUser()->getRole(), $this->roles)) {
            throw new UnauthorizedException();
        }
    }

    /**
     * This method returns the associative array of the matches, the keys are the names of the parameters read from the path and the values are the values of the matches
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'path' => '/' . $this->path,
            'roles' => $this->roles,
            'callable' => $this->getCallable(),
            'matchingStatus' => $this->matchingStatus,
            'matches' => $this->getMatchesAssoc(),
            'developmentMode' => $this->developmentMode,
        ];
    }


    /**
     * This method returns the associative array of the matches, the keys are the names of the parameters read from the path and the values are the values of the matches
     * @return array
     */

    public function getMatchesAssoc(): array
    {
        if ($this->matchingStatus !== 'matched') return [];

        $matchesAssoc = [];
        $path = explode('/', $this->path);

        $i = 0;
        foreach ($path as $key => $value) {
            if (str_starts_with($value, ':')) {
                $matchesAssoc[substr($value, 1)] = $this->matches[$i];
                $i++;
            }
        }
        return $matchesAssoc;
    }
}
