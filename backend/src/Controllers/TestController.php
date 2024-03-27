<?php

namespace Controllers;



use Database\UserTableManager;
use Database\DatabaseConnection;
use Database\DatabaseQuery;
use Models\User;

class TestController
{

    //use this method if you want to test some code, call it with route /test
    public function testMethod()
    {

        $connection = DatabaseConnection::getInstance();
        var_dump($connection);
        $query = new DatabaseQuery();
        var_dump($query->executeQuery("SELECT * FROM users"));

    }



}