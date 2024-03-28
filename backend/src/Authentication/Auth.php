<?php

namespace Authentication;
use Exceptions\HttpExceptions\NotLoggedInException;
use Exceptions\HttpExceptions\UnauthorizedException;
use Models\User;

class Auth
{
    private $activeUser;
    public static function isLoggedIn()
    {
        return true;// for testing purposes
        // Check if a user is logged in (e.g., check session or token)
        return isset($_SESSION['user_id']);

    }

    public static function login($username, $password)
    {
        // Validate the username and password (e.g., check against database)
        if ($username === 'admin' && $password === 'password') {
            // Set session or token to indicate the user is logged in
            $_SESSION['user_id'] = 1;
            return true;
        }
        //maybe throw error in case of invalid credentials (to handle cases differently in frontend)
        return false;
    }

    public static function logout()
    {
// Unset session or token to log the user out
        unset($_SESSION['user_id']);
    }

    public static function requireLogin(){
        if(!self::isLoggedIn()){
            throw new NotLoggedInException();
        }
    }
    public static function requireAdminAccess(){
        if(!self::isLoggedIn() || $_SESSION['user_id'] !== 1){
            throw new UnauthorizedException();
        }
    }

    /**
     * Get the active user
     *
     * @return User
     * @throws NotLoggedInException
     */
    public function getActiveUser(): User
    {
        // If activeUser is already set, return it
        if ($this->activeUser !== null) {
            return $this->activeUser;
        }

        if (!self::isLoggedIn()) {
            throw new NotLoggedInException();
        }

        // Fetch the user from the database
        $userId = $_SESSION['user_id'];

        /* TODO: fetch from database
        $userTableManager = UserTableManager::GetInstance();
        $this->activeUser = $userTableManager->find($userId);
        */

        // If the user was not found, throw an exception
        if ($this->activeUser === null) {
            throw new \Exception("User with ID $userId not found");
        }

        return $this->activeUser;
    }
    public static function getActiveUser()
    {

        return new User(1, 'admin', 'password', 'mm', '2021-01-01', 'admin');//for now, return a hardcoded user
    }


}
