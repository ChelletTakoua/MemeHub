<?php

namespace Database\TableManagers;

use Models\User;

class UserTableManager extends TableManager
{

    public function save($model)
    {
        echo "UserTableManager save method called";
    }


    public function getUser($attribut,$value) //from database
    {
        $query = new DatabaseQuery();
        $queryObjects = $query->executeQuery("select","users",[],[$attribut => $value]);
        $user=new User($queryObjects[0]["id"],
            $queryObjects[0]["username"],
            $queryObjects[0]["password"],
            $queryObjects[0]["email"],
            $queryObjects[0]["reg_date"],
            $queryObjects[0]["role"]);
        return $user;    
    }
    public function addUser($user) //to database
    {

    }


    public function retrieve($attribut,$value)
    {
        return $this->getUser($attribut,$value);
    }
}
