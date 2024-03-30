<?php

namespace Controllers;

use Exceptions\HttpExceptions\BadRequestException;
use Utils\RequestHandler;

class AuthController
{
    /**
    * Logs in a user.
    *
    * This function retrieves the request body as JSON and checks if it contains 'username' and 'password'.
    * If these fields are present, it sanitizes the username, then attempts to log in the user using these details.
    * If login is successful, it returns a success response with the user details.
    * If the required fields are not present in the request body, it throws a BadRequestException.
    *
    * @throws BadRequestException If 'username' and 'password' are not provided in the request body.
    */
    public function login() 
    {
        // Get the JSON request body
        $requestBody = RequestHandler::getJsonRequestBody();
        // Check if the request body is not empty and contains 'username' and 'password'
        if (!empty($requestBody) && isset($requestBody['username']) && isset($requestBody['password'])) {
            // Extract the username and password from the request body
            $username = $requestBody['username'];
            $password = $requestBody['password'];
            // Sanitize the username
            $username = filter_var($username, FILTER_SANITIZE_SPECIAL_CHARS);
            // Attempt to log in the user
            $user=Auth::login($username, $password);
            // Build a success response with the user details
            $response = ApiResponseBuilder::buildSuccessResponse(["user"=>$user]);
            // Output the response as JSON
            echo json_encode($response);
        }else {
            // Throw a BadRequestException if 'username' and 'password' are not provided
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
        // Call the logout method of the Auth class to log out the user
        Auth::logout();
        // Terminate the script execution
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
        // Get the JSON request body
        $requestBody = RequestHandler::getJsonRequestBody();
        // Check if the request body is not empty and contains 'username', 'email', and 'password'
        if (!empty($requestBody) && isset($requestBody['username']) && isset($requestBody['email']) && isset($requestBody['password'])) {
            // Extract the username, email, and password from the request body
            $username = $requestBody['username'];
            $email = $requestBody['email'];
            $password = $requestBody['password'];
            // Sanitize the username and email
            $username = filter_var($username, FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            // Register the user    
            Auth::register($username, $password,$email);
            // Log in the user
            $user = Auth::login($username, $password);
            // Build a success response with the user details
            $response = ApiResponseBuilder::buildSuccessResponse(["user"=>$user]);
            // Output the response as JSON
            echo json_encode($response);
        }else{
            // Throw a BadRequestException if 'username', 'email', and 'password' are not provided
            throw new BadRequestException("Username, email and password must be provided");
        }
    }

    public function forgotPassword()
    {
        echo "AuthController forgotPassword method called";
    }

    public function resetPassword()
    {
        echo "AuthController resetPassword method called";
    }

    public function changePassword()
    {
        echo "AuthController changePassword method called";
    }

    public function verifyEmail()
    {
        echo "AuthController verifyEmail method called";
    }

    public function resendVerificationEmail()
    {
        echo "AuthController resendVerificationEmail method called";
    }

    public function verifyPasswordReset()
    {
        echo "AuthController verifyPasswordReset method called";
    }

    public function resendPasswordResetEmail()
    {
        echo "AuthController resendPasswordResetEmail method called";
    }

    public function verifyEmailChange()
    {
        echo "AuthController verifyEmailChange method called";
    }

    public function resendEmailChangeEmail()
    {
        echo "AuthController resendEmailChangeEmail method called";
    }

    public function changeEmail()
    {
        echo "AuthController changeEmail method called";
    }

    public function verifyPhone()
    {
        echo "AuthController verifyPhone method called";
    }

    public function resendVerificationPhone()
    {
        echo "AuthController resendVerificationPhone method called";
    }

    public function changePhone()
    {
        echo "AuthController changePhone method called";
    }

    public function verifyPhoneChange()
    {
        echo "AuthController verifyPhoneChange method called";
    }

    public function resendPhoneChangePhone()
    {
        echo "AuthController resendPhoneChangePhone method called";
    }

    public function changeUsername()
    {
        echo "AuthController changeUsername method called";
    }

    public function verifyUsernameChange()
    {
        echo "AuthController verifyUsernameChange method called";
    }

    public function resendUsernameChangeEmail()
    {
        echo "AuthController resendUsernameChangeEmail method called";
    }

    public function verifyUsername()
    {
        echo "AuthController verifyUsername method called";
    }

    public function resendVerificationUsername()
    {
        echo "AuthController resendVerificationUsername method called";
    }

    public function deleteAccount()
    {
        echo "AuthController deleteAccount";
    }
}
