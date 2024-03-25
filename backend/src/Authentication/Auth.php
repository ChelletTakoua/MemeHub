<?php

namespace Authentication;
class Auth
{
    public static function isLoggedIn()
    {
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
            //TODO: throw a more specific exception
            throw new \Exceptions\HttpExceptions\HttpException('Unauthorized', 401);
        }
    }
    public static function requireAdminAccess(){
        if(!self::isLoggedIn() || $_SESSION['user_id'] !== 1){
            //TODO: throw a more specific exception
            throw new \Exceptions\HttpExceptions\HttpException('Forbidden', 403);
        }
    }


}
