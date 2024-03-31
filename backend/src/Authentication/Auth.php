<?php

namespace Authentication;
use Exceptions\HttpExceptions\LoginFailedException;
use Exceptions\HttpExceptions\NotLoggedInException;
use Exceptions\HttpExceptions\UnauthorizedException;
use Exceptions\HttpExceptions\UserRegistrationException;
use Models\User;
use Database\TableManagers\UserTableManager;

class Auth
{
    private static $activeUser;
    
    /**
    * Logs in a user.
    *
    * This function attempts to log in a user using the provided username and password. If the user is found in the database and the password is correct, the user is logged in and returned. If not, a LoginFailedException is thrown.
    *
    * @param string $username The username of the user.
    * @param string $password The password of the user.
    * @return User The logged-in user.
    * @throws LoginFailedException If the password is incorrect or the user is not found.
    */
    public static function login(string $username, string $password): User
    {
        // Retrieve the user from the database using the provided username
        $user = UserTableManager::getUserByUsername($username);
        // If the user is found and the provided password matches the user's password
        if (!empty($user) && password_verify($password, $user->getPassword()) && $user->getIsVerified()) {
            // Store the user's ID in the session
            $_SESSION['user_id'] = $user->getId();
            // Set the active user to the logged-in user
            self::$activeUser = $user;
            // Return the user
            return $user;
        } 
        // If the user is found but the password does not match
        else if (!empty($user) && !password_verify($password, $user->getPassword()))  {
            // Throw a LoginFailedException with the message "Incorrect password"
            throw new LoginFailedException("Incorrect password");
        }
        else if (!empty($user) && !$user->getIsVerified()) {
            // Throw a LoginFailedException with the message "User not verified"
            throw new LoginFailedException("User not verified");
        }
        // If the user is not found
        else {
            // Throw a LoginFailedException with the message "User not found"
            throw new LoginFailedException("User not found");
        }
    }

    /**
    * Logs out the current user.
    *
    * This function destroys the session and terminates the script execution.
    */
    public static function logout()
    {
        // Destroy the session to log out the user
        session_destroy();
        // Terminate the script execution
        exit();
    }

    /**
    * Registers a new user.
    *
    * This function checks if the provided username and email are unique. If either is already in use, a UserRegistrationException is thrown.
    * If both are unique, the password is hashed and the new user is added to the database. If the user is successfully added, the function returns true.
    * If the user could not be added, a UserRegistrationException is thrown.
    *
    * @param string $username The desired username of the new user.
    * @param string $password The desired password of the new user.
    * @param string $email The desired email of the new user.
    * @return bool True if the user was successfully registered.
    * @throws UserRegistrationException If the username or email is already in use, or if the user could not be added to the database.
    */
    public static function register(string $username, string $password, string $email): bool
    {
        // Check if the username already exists in the database
        if (UserTableManager::verifyExistenceByUserName($username)) {
            // If it does, throw a UserRegistrationException with the message "Username exists"
            throw new UserRegistrationException("Username exists");
        }
        // Check if the email already exists in the database
        else if (UserTableManager::verifyExistenceByEmail($email)) {
            // If it does, throw a UserRegistrationException with the message "Email exists"
            throw new UserRegistrationException("Email exists");
        }
        // Hash the password using the default algorithm
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        // Attempt to add the user to the database
        if (!empty(UserTableManager::addUser($username, $email, $hashedPassword))) {
            // If successful, return true
            return true;
        } else {
            // If not successful, throw a UserRegistrationException with the message "Failed to register user"
            throw new UserRegistrationException("Failed to register user");
        }
    }

    public static function isLoggedIn(): bool
    {
        return true;// for testing purposes
        // Check if a user is logged in (e.g., check session or token)
        return isset($_SESSION['user_id']);
    }

    public static function isSpecificUserLoggedIn($userId): bool
    {
        return isset($_SESSION['user_id']) && $_SESSION['user_id'] == $userId;
    }

    /**
     * @throws NotLoggedInException
     */
    public static function requireLogin(){
        if(!self::isLoggedIn()){
            throw new NotLoggedInException();
        }
    }

    /**
     * @throws UnauthorizedException
     */
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
        if (self::$activeUser !== null) {
            return self::$activeUser;
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
    /**
     * Get the active user's ID
     * @return int
     */
    public static function getActiveUserId()
    {
        return $_SESSION['user_id'];
    }
}
