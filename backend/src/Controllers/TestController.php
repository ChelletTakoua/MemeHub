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
        $query = new DatabaseQuery();
        $queryObjects = $query->executeQuery("select","users",[],
                                            ["username" => "taki"]);

        var_dump($queryObjects);
        echo "<br><br>";
        foreach ($queryObjects as $queryObject ) {
            foreach ($queryObject as $column => $value) {
                echo $column . " => " . $value . "<br>";
            }
            echo"<hr>";
        }
    }



}