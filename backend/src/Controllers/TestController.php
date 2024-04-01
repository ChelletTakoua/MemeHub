<?php

namespace Controllers;

use Authentication\AuthKeyGenerator;
use Cassandra\Date;
use Database\DatabaseConnection;
use Database\DatabaseQuery;
use Database\TableManagers\MemeTableManager;
use Database\TableManagers\UserTableManager;
use DateTime;
use http\Env\Response;
use Mailing\Mail;
use Models\Meme;
use Models\Template;
use Models\User;
use Utils\ApiResponseBuilder;


class TestController
{

    //use this method if you want to test some code, call it with route /test
    public function testMethod()
    {
        //test code here
        UserTableManager::updateUser(["username" => "test"] , ["id" => 1]);
    }

}