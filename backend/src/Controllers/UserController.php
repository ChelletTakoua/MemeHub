<?php

namespace Controllers;

use Authentication\Auth;
use Database\TableManagers\MemeTableManager;
use Exceptions\HttpExceptions\BadRequestException;
use Exceptions\HttpExceptions\NotFoundException;
use Database\TableManagers\UserTableManager;
use Exceptions\HttpExceptions\NotLoggedInException;
use Utils\RequestHandler;
use Utils\ApiResponseBuilder;

class UserController
{


    public function forgotPassword() {
        // Logic to send email with forgot password token
        //TODO: implement this method
    }

    public function resetPassword() {
        // Logic to reset password with token
        //TODO: implement this method
    }

    public function sendVerificationEmail() {
        // Logic to send verification email
        //TODO: implement this method
    }

    public function verifyEmail() {
        // Logic to verify email with token
        //TODO: implement this method
    }

    /**
     * @throws NotFoundException
     */
    public function getUserProfile($id) {
        //get the user
        $user=UserTableManager::getUserById($id);
        if ($user) {
            // Build a success response with the user details
            $response = ApiResponseBuilder::buildSuccessResponse(["user"=>$user]);
            // Output the response as JSON
            echo json_encode($response);}
        else {
            // Throw a NotFoundException if user profile not found
            throw new NotFoundException("User profile not found");
        }
    }

    /**
     * @throws BadRequestException
     * @throws NotLoggedInException
     */
    public function modifyPassword() {
        // Get the JSON request body
        $requestBody = RequestHandler::getJsonRequestBody();
        // Check if the request body is not empty and contains 'password'
        if (!empty($requestBody) && isset($requestBody['password'] ) ) {
            //get the id and password

            $id = (new Auth)->getActiveUser();
            $password = $requestBody['password'];
            //update password the user
            UserTableManager::updatePassword($id,$password);
            // Output a success message
            $response = ApiResponseBuilder::buildSuccessResponse();
        }else {
            // Throw a BadRequestException 'password' is not provided
            throw new BadRequestException("Password must be provided");
        }
    }

    /**
     * @throws BadRequestException
     * @throws NotLoggedInException
     */
    public function editProfile() {
        // Get the JSON request body
        $requestBody = RequestHandler::getJsonRequestBody();
        // Check if the request body is not empty
        if (!empty($requestBody) &&( isset($requestBody['username']) || isset($requestBody['email']) || isset($requestBody['profile_picture']) ) ){
            // Extract the id from the request body
            $id = Auth::getActiveUserId();
            //update the user
            if(isset($requestBody['username'])){
                $username = $requestBody['username'];
                UserTableManager::updateUsername($id,$username);
            }
            if(isset($requestBody['email'])){
                $email = $requestBody['email'];
                UserTableManager::updateEmail($id,$email);
            }
            if(isset($requestBody['profile_picture'])){
                $profile_picture = $requestBody['profile_picture'];
                UserTableManager::updateProfilePic($id,$profile_picture);
            }
            $user= (new Auth)->getActiveUser(true);
            $response = ApiResponseBuilder::buildSuccessResponse(["user"=>$user]);
            // Output a success message
            echo json_encode($response);
        }else {
            // Throw a BadRequestException if any parameter is provided
            throw new BadRequestException("A parameter must be provided");
        }
    }

    public function deleteProfile() {
        // get the id of active user
        $id = Auth::getActiveUserId();
        //delete the user
        UserTableManager::deleteUserById($id);
    }

}