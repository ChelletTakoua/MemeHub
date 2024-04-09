<?php

namespace Controllers;

use Database\TableManagers\MemeTableManager;
use Database\TableManagers\UserTableManager;
use Exceptions\HttpExceptions\BadRequestException;
use Exceptions\HttpExceptions\NotFoundException;
use Exceptions\HttpExceptions\UnauthorizedException;
use Utils\ApiResponseBuilder;
use Utils\RequestHandler;

class AdminController
{

    /** gets all the users and sends them in the response
     * @throws NotFoundException
     */
    public function getAllUsers()
    {
        $users = UserTableManager::getUser();
        if ($users) {
            $response = ApiResponseBuilder::buildSuccessResponse(["users" => $users]);
            echo json_encode($response);
        } else {
            throw new NotFoundException("No users found");
        }
    }

    /** gets all the admins and sends them in the response
     * @throws NotFoundException
     */
    public function getAdminDashboard()
    {
        $admins = UserTableManager::getUserByRole("admin");
        if ($admins) {
            $response = ApiResponseBuilder::buildSuccessResponse(["admins" => $admins]);
            echo json_encode($response);
        } else {
            throw new NotFoundException("No admins found");
        }
    }

    /** takes in a user id and sends the user profile in the response
     * @param $id
     * @throws NotFoundException
     */
    public function getUserProfile($id)
    {
        $user = UserTableManager::getUserById($id);
        if ($user) {
            $response = ApiResponseBuilder::buildSuccessResponse(["user" => $user]);
            echo json_encode($response);
        } else {
            throw new NotFoundException("User not found");
        }
    }

    /** takes in a user id and changes the role of the user which is specified in the body of the request
     * @param $id
     * @throws NotFoundException
     * @throws BadRequestException
     */
    public function changeUserRole($id)
    {
        $request = RequestHandler::getJsonRequestBody();
        if (empty($request) || !isset($request['role'])) {
            throw new BadRequestException("Role not found in request body");
        }
        if ($request["role"] != "admin" && $request["role"] != "user") {
            throw new BadRequestException("Invalid role, must be 'admin' or 'user'");
        }
        $role = $request['role'];
        $user = UserTableManager::getUserById($id);
        if (!$user) {
            throw new NotFoundException("User not found");
        }
        UserTableManager::updateRole($id, $role);
        ApiResponseBuilder::buildSuccessResponse();
    }

    /** takes in a user id and deletes the user
     * @param $id
     */
    public function deleteUser($id)
    {
        UserTableManager::deleteUserById($id);
        ApiResponseBuilder::buildSuccessResponse();
    }

    /** takes in a meme id and deletes the meme
     * @param $id
     */
    public function deleteMeme($id)
    {
        MemeTableManager::deleteMeme($id);
        ApiResponseBuilder::buildSuccessResponse();
    }


    /**
     * This method checks if the development mode is active
     * @throws UnauthorizedException
     */
    public function devMode()
    {
        $devMode = (include __DIR__ . '/../config/app.php')['development_mode'];
        $response = ApiResponseBuilder::buildSuccessResponse(["devMode" => $devMode]);
        echo json_encode($response);
    }
}
