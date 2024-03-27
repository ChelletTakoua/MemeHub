<?php

namespace Controllers;



use Database\UserTableManager;
use Models\User;

class TestController
{

    //use this method if you want to test some code, call it with route /test
    //TODO: add to gitignore after next commit
    public function testMethod()
    {
        /*$userTableManager = UserTableManager::getInstance();
        var_dump($userTableManager);*/

        $user = new User(1,2,3,4,5,6);
        $user->save();


    }



}