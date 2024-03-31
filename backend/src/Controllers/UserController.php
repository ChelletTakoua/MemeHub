<?php

namespace Controllers;

use Authentication\Auth;
use Authentication\AuthKeyGenerator;
use Database\TableManagers\MemeTableManager;
use Exceptions\HttpExceptions\BadRequestException;
use Exceptions\HttpExceptions\InvalidTokenException;
use Exceptions\HttpExceptions\NotFoundException;
use Database\TableManagers\UserTableManager;
use Exceptions\HttpExceptions\NotLoggedInException;
use Mailing\Mail;
use Utils\RequestHandler;
use Utils\ApiResponseBuilder;

class UserController
{

    /**
     * This function is used to send an email to the user with a link to reset his password
     * It takes the username of the user as a parameter
     * @param string $username
     * @return void
     */
    public function forgotPassword($username) {

        //TODO: @takoua
        // fetch user from database
        // send email to user with password reset link
        // rodd les 2 methodes mte3 mail ye5dhou user fel parametre
        // Mail::sendPasswordResetMail($user);


    }


    /**
     *  This function is used to reset the password of a user
     * It takes a token and a new password from the request body
     * @return void
     * @throws BadRequestException if the token or password is not provided
     * @throws InvalidTokenException
     */
    public function resetPassword() {

        $requestBody = RequestHandler::getJsonRequestBody();

        if(!isset($requestBody['token'])) {
            throw new BadRequestException("Token must be provided");
        }
        if (!isset($requestBody['password'])) {
            throw new BadRequestException("Password must be provided");
        }

        $token = $requestBody['token'];
        $password = $requestBody['password'];

        $user = AuthKeyGenerator::getUserFromToken($token);

        Auth::modifyPassword($user->getId(), $password);

        $response = ApiResponseBuilder::buildSuccessResponse();
        echo json_encode($response);

    }

    /**
     * This function is used to send a verification email to the user
     * @return void
     */
    public function sendVerificationEmail(){

        //TODO: @takoua
        // Logic to send verification email
        //TODO: implement this method
    }


    /**
     * This function is used to verify the email of a user
     * It takes a token from the request body
     * @return void
     * @throws BadRequestException if the token is not provided
     * @throws InvalidTokenException if the token is invalid
     */
    public function verifyEmail() {

        $requestBody = RequestHandler::getJsonRequestBody();
        $token = $requestBody['token'];

        $user = AuthKeyGenerator::getUserFromToken($token);

        UserTableManager::updateIsVerified($user->getId());

        $response = ApiResponseBuilder::buildSuccessResponse();
        echo json_encode($response);
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
        if (!empty($requestBody) &&( isset($requestBody['username']) || isset($requestBody['email']) || isset($requestBody['profile_pic']) ) ){
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
            if(isset($requestBody['profile_pic'])){
                $profile_pic = $requestBody['profile_pic'];
                UserTableManager::updateProfilePic($id,$profile_pic);
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