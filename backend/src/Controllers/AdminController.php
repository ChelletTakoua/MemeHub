<?php

namespace Controllers;

use Database\TableManagers\MemeTableManager;
use Database\TableManagers\UserTableManager;
use Exceptions\HttpExceptions\NotFoundException;
use Utils\ApiResponseBuilder;
use Utils\RequestHandler;

class AdminController
{

    /**
     * @throws NotFoundException
     */
    public function getAllUsers()
    {
        $users = UserTableManager::getUser();
        if($users) {
            $response = ApiResponseBuilder::buildSuccessResponse(["users"=>$users]);
            echo json_encode($response);
        }
        else {
            throw new NotFoundException("No users found");
        }
    }

    /**
     * @throws NotFoundException
     */
    public function getAdminDashboard()
    {
        $admins = UserTableManager::getUserByRole("admin");
        if ($admins) {
            $response = ApiResponseBuilder::buildSuccessResponse(["admins"=>$admins]);
            echo json_encode($response);
        }
        else {
            throw new NotFoundException("No admins found");
        }

    }

    /**
     * @throws NotFoundException
     */
    public function getUserProfile($id)
    {
        $user = UserTableManager::getUserById($id);
        if($user) {
            $response = ApiResponseBuilder::buildSuccessResponse(["user"=>$user]);
            echo json_encode($response);
        }
        else {
            throw new NotFoundException("User not found");
        }

    }

    /** takes in a user id and changes the role of the user which is specified in the body of the request
     * @throws NotFoundException
     */
    public function changeUserRole($id)
    {
        $request = RequestHandler::getJsonRequestBody();
        // Check if the request body is not empty and contains 'role'
        if(!empty($request) && isset($request['role'])) {
            $role = $request['role'];
            $user = UserTableManager::getUserById($id);
            if($user) {
                UserTableManager::updateRole($id, $role);
                ApiResponseBuilder::buildSuccessResponse();
            }
            else {
                throw new NotFoundException("User not found");
            }
        }
        else {
            throw new NotFoundException("Role not found in request body");
        }

    }

    public function deleteUser($id)
    {
        UserTableManager::deleteUserById($id);
        ApiResponseBuilder::buildSuccessResponse();
    }

    public function deleteMeme($id)
    {
        MemeTableManager::deleteMeme($id);
        ApiResponseBuilder::buildSuccessResponse();
    }


}
