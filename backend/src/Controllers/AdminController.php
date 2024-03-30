<?php

namespace Controllers;

class AdminController
{

    public function getAllUsers()
    {
        echo "Get all users";
    }

    public function getUserProfile($id)
    {
        echo "Get user with id $id";
    }

    public function changeUserRole($id)
    {
        echo "Change user role with id $id";
    }

    public function deleteUser($id)
    {
        echo "Delete user with id $id";
    }

    public function deleteMeme($id)
    {
        echo "Delete meme with id $id";
    }
}