<?php

namespace Database\TableManagers;

use Models\User;

class UserTableManager extends TableManager
{

    public function save($model)
    {
        echo "UserTableManager save method called";
    }


    public function getUserById($id) //from database
    {
        //send query to database

        $data  = ['id' => $id,
            'name' => 'John Doe',
            'email' => 'mzqdq'];

        return new User($data['id'], $data['name'], 'password', $data['email'], '2021-01-01', 'admin');

    }

    public function addUser($user) //to database
    {

    }


    public function retrieve($id)
    {
        return $this->getUserById($id);
    }
}