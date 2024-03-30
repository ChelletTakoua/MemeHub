<?php

namespace Controllers;



use Database\UserTableManager;
use Database\DatabaseConnection;
use Database\DatabaseQuery;
use Models\User;
use Utils\Mail;

class TestController
{

    //use this method if you want to test some code, call it with route /test
    public function testMethod()
    {
        $mail = new \Utils\Mail();
        $mail->sendMail('taki74ayadi@gmail.com', 'test', 'test');
    }



}