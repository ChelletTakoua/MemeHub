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
    public function getUserById($id){
        return getUser("id", $id);
    }
    
    public function getUserByEmail($email){
        return getUser("email", $email);
    }

    public function getUserByUsername($username) {
        return getUser("username", $username);
    }

    public function verifyExistenceByUserName($username){
        $query = new DatabaseQuery();
        $queryObjects = $query->executeQuery("select","users",[],["username"=>$username]);
        if(count($queryObjects)>0){
            return true;
        }
        return false;
    }
    public function verifyExistenceByEmail($email){
        $query = new DatabaseQuery();
        $queryObjects = $query->executeQuery("select","users",[],["email"=>$email]);
        if(count($queryObjects)>0){
            return true;
        }
        return false;
    }
    public function AddUser($username,$email,$password,$role) //to database
    {
        if(verifyExistenceByUserName($username))
            return false;
        else if(verifyExistenceByEmailByUserName($email))
            return false;
        else
        {
            $query = new DatabaseQuery();
            $query->executeQuery("insert","users",["username"=>$username,"email"=>$email,"password"=>$password , "role"=>$role]);
            return true;
        }
    }

    public function updateRole($id,$role){
        $query = new DatabaseQuery();
        $query->executeQuery("update","users",["role"=>$role],["id"=>$id]);
    }

    public function retrieve($id)
    {
        return $this->getUserById($id);
    }
}
