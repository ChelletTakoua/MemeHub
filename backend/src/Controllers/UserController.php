<?php

namespace Controllers;

class UserController
{

    public function getUserById($id)
    {
    echo "User with id $id";
        // Handle GET request
    }

    
    public function post()
    {
        echo "post user called successfully";

        // Handle POST request
    }
    public function forgotPassword(Request $request, Response $response) {
        // Logic to send email with forgot password token
    }

    public function resetPassword(Request $request, Response $response) {
        // Logic to reset password with token
    }

    public function sendVerificationEmail(Request $request, Response $response) {
        // Logic to send verification email
    }

    public function verifyEmail(Request $request, Response $response) {
        // Logic to verify email with token
    }

    public function getUserProfile() {
        // Get the JSON request body
        $requestBody = RequestHandler::getJsonRequestBody();
        // Check if the request body is not empty and contains 'id'
        if (!empty($requestBody) && isset($requestBody['id']) ) {
            // Extract the id from the request body
            $id = $requestBody['id'];
            //get the user
            $user=UserTableMnager::getUserById($id);
            // Build a success response with the user details
            $response = ApiResponseBuilder::buildSuccessResponse(["user"=>$user]);
            // Output the response as JSON
            echo json_encode($response);
        }else {
            // Throw a BadRequestException if 'id' is not provided
            throw new BadRequestException("Id must be provided");
        }
    }

    public function modifyPassword() {
        // Get the JSON request body
        $requestBody = RequestHandler::getJsonRequestBody();
        // Check if the request body is not empty and contains 'password' and 'id'
        if (!empty($requestBody) && isset($requestBody['password']) && isset($requestBody['id']) ) {
            // Extract the id from the request body
            $id = $requestBody['id'];
            // Extract the password from the request body
            $password = $requestBody['password'];
            //update password the user
            UserTableMnager::updatePassword($id,$password);
            // Output a success message
            echo "Password updated successfully";
        }else {
            // Throw a BadRequestException if 'id'and 'password' are not provided
            throw new BadRequestException("Id and password must be provided");
        }
    }

    public function editProfile(Request $request, Response $response) {
        // Logic to edit user profile (username, email, etc.)
    }

    public function deleteProfile(Request $request, Response $response) {
        // Logic to delete user profile
    }
}