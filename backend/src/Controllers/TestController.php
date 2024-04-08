<?php

namespace Controllers;

use Authentication\Auth;
use Authentication\AuthKeyGenerator;
use Cassandra\Date;
use Database\DatabaseConnection;
use Database\DatabaseQuery;
use Database\TableManagers\MemeTableManager;
use Database\TableManagers\TextBlockTableManager;
use Database\TableManagers\UserTableManager;
use DateTime;
use http\Env\Response;
use Mailing\Mail;
use Models\Meme;
use Models\Template;
use Models\TextBlock;
use Models\User;
use Utils\ApiResponseBuilder;


class TestController
{

    /**
     * use this method if you want to test some code, call it with route /test
     */
    public function testMethod()
    {
        Auth::login("Louey","adslo123098",false);
        echo( json_encode($_SESSION["requests"][0]) );
        include __DIR__ . '/../Debugging/requestDetails.php';
    }

}