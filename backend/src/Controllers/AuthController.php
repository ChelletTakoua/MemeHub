<?php

namespace Controllers;

use Authentication\AuthKeyGenerator;
use Exceptions\HttpExceptions\BadRequestException;
use Authentication\Auth;
use Exceptions\HttpExceptions\InvalidTokenException;
use Exceptions\HttpExceptions\LoginFailedException;
use Utils\ApiResponseBuilder;
use Utils\RequestHandler;
use Exceptions\HttpExceptions\UserRegistrationException;

class AuthController
{
    /**
     * Logs in a user.
     *
     * This function retrieves the request body as JSON and checks if it contains 'username' and 'password'.
     * If these fields are prese nt, it sanitizes the username, then attempts to log in the user using these details.
     * If login is successful, it returns a success response with the user details.
     * If the required fields are not present in the request body, it throws a BadRequestException.
     *
     * @throws BadRequestException|LoginFailedException If 'username' and 'password' are not provided in the request body.
     */
    public function login()
    {
        $requestBody = RequestHandler::getJsonRequestBody();
        if (!empty($requestBody) && isset($requestBody['username']) && isset($requestBody['password'])) {
            $username = $requestBody['username'];
            $password = $requestBody['password'];
            $username = filter_var($username, FILTER_SANITIZE_SPECIAL_CHARS);
            $user = Auth::login($username, $password);
            $response = ApiResponseBuilder::buildSuccessResponse(["user" => $user]);
            echo json_encode($response);
        } else {
            throw new BadRequestException("Username and password must be provided");
        }
    }


    /**
     * Logs out the current user.
     *
     * This function calls the logout method of the Auth class to log out the user, then terminates the script execution.
     */
    public function logout()
    {
        Auth::logout();
        exit();
    }


    /**
     * Registers a new user.
     *
     * This function retrieves the request body as JSON and checks if it contains 'username', 'email', and 'password'.
     * If these fields are present, it sanitizes the username and email, then attempts to register the user using these details.
     * If registration is successful, it logs in the user and returns a success response with the user details.
     * If the required fields are not present in the request body, it throws a BadRequestException.
     *
     * @throws BadRequestException If 'username', 'email', and 'password' are not provided in the request body.
     */
    public static function register()
    {
        $requestBody = RequestHandler::getJsonRequestBody();
        if (!empty($requestBody) && isset($requestBody['username']) && isset($requestBody['email']) && isset($requestBody['password'])) {
            $username = $requestBody['username'];
            $email = $requestBody['email'];
            $password = $requestBody['password'];
            $username = filter_var($username, FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            Auth::register($username, $password, $email);
            $response = ApiResponseBuilder::buildSuccessResponse();
            echo json_encode($response);
        } else {
            throw new BadRequestException("Username, email and password must be provided");
        }
    }


    /**
     * Verifies the JWK token and returns the user object.
     * @return void
     * @throws BadRequestException If the token is not provided in the request body.
     * @throws InvalidTokenException If the token is invalid.
     */
    public function verifyToken()
    {
        $token = RequestHandler::getJsonRequestBody()['token'];
        $user = AuthKeyGenerator::getUserFromToken($token);
        $response = ApiResponseBuilder::buildSuccessResponse(["user" => $user]);
        echo json_encode($response);
    }
    /**
     * Checks if the user is authenticated and returns the user object.
     * @return void
     */

    public static function checkAuth()
    {

        $user = null;
        if (Auth::isLoggedIn()) {
            $user = Auth::getActiveUser();
        }
        $response = ApiResponseBuilder::buildSuccessResponse(["user" => $user]);
        echo json_encode($response);
    }
}
