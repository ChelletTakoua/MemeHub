<?php

namespace Authentication;

use Exceptions\HttpExceptions\LoginFailedException;
use Exceptions\HttpExceptions\NotLoggedInException;
use Exceptions\HttpExceptions\UnauthorizedException;
use Exceptions\HttpExceptions\UserRegistrationException;
use Models\User;
use Database\TableManagers\UserTableManager;
use Exceptions\HttpExceptions\BadRequestException;
use Exceptions\HttpExceptions\NotFoundException;

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
    public static function login(string $username, string $password, $requirePassword = true): User
    {
        $user = UserTableManager::getUserByUsername($username);
        if (empty($user)) {
            throw new LoginFailedException("User not found");
        }
        if ($requirePassword && !password_verify($password, $user->getPassword())) {
            throw new LoginFailedException("Incorrect password");
        }
        if (!$user->getIsVerified()) {
            throw new LoginFailedException("User not verified", 403);
        }
        self::setSessionUser($user);
        return $user;
    }


    /**
     * sets the user id of the active user in the session
     * @param string $userId The id of the user.
     *@return void
     */

    private static function setSessionUserId($userId): void
    {
        $_SESSION['user_id'] = $userId;
        self::$activeUser = null;
    }
    /**
     * sets the active user in the session
     * @param User $user The user.
     * @return void
     */
    private static function setSessionUser($user): void
    {
        $_SESSION['user_id'] = $user->getId();
        self::$activeUser = $user;
    }

    /**
     * Logs out the current user.
     *
     * This function destroys the session and terminates the script execution.
     */
    public static function logout()
    {
        session_destroy();
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
        if (UserTableManager::verifyExistenceByUserName($username)) {
            throw new UserRegistrationException("Username exists");
        } else if (UserTableManager::verifyExistenceByEmail($email)) {
            throw new UserRegistrationException("Email exists");
        }
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        if (!empty(UserTableManager::addUser($username, $email, $hashedPassword))) {
            return true;
        } else {
            throw new UserRegistrationException("Failed to register user");
        }
    }

    /**
     * Modify the password of a user
     * @param $userId
     * @param $password
     * @return bool
     */
    public static function modifyPassword($userId, $password): bool
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        UserTableManager::updatePassword($userId, $hashedPassword);
        self::forceReloadActiveUser();
        return true;
    }

    /**
     * this function is used to check if a user is logged in
     * @return bool
     * 
     */
    public static function isLoggedIn(): bool
    {
        return isset($_SESSION['user_id']);
    }
    /**
     * this function is used to check if a specific user is logged in
     * @param int $userId The id of the user.
     * @return bool
     */
    public static function isSpecificUserLoggedIn($userId): bool
    {
        return isset($_SESSION['user_id']) && $_SESSION['user_id'] == $userId;
    }

    /**
     * this function throw an exception if there is no user logged in
     * @throws NotLoggedInException
     */
    public static function requireLogin()
    {
        if (!self::isLoggedIn()) {
            throw new NotLoggedInException();
        }
    }

    /**
     * this function throw an exception if the user logged in is not the admin 
     * @throws UnauthorizedException
     */
    public static function requireAdminAccess()
    {
        if (!self::isLoggedIn() || self::getActiveUser()->getRole() != 'admin') {
            throw new UnauthorizedException();
        }
    }

    /**
     * this function is used to force the active user to be reloaded from the database on the next call to getActiveUser()
     * this is useful when the user's data has been modified in the database and the active user's data needs to be updated
     * @return void
     */
    private static function forceReloadActiveUser()
    {
        self::$activeUser = null;
    }

    /**
     * Get the active user
     *
     * @return User
     * @throws NotLoggedInException
     */
    public static function getActiveUser(): User
    {
        if (self::$activeUser !== null) {
            return self::$activeUser;
        }
        if (!self::isLoggedIn()) {
            throw new NotLoggedInException();
        }
        $userId = $_SESSION['user_id'];
        self::$activeUser = UserTableManager::getUserById($userId);
        if (self::$activeUser === null) {
            throw new NotFoundException("User not found");
        }
        return self::$activeUser;
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
