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


       $user = UserTableManager::getUserById(1);

        $jwk = AuthKeyGenerator::encodeJWK($user);

        echo $jwk;
/*
        $decoded = AuthKeyGenerator::getUserFromToken($jwk);

        var_dump($user);
        echo "\n\n\n";
        var_dump($decoded);
*/





    }



}