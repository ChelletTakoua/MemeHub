<?php

namespace Database;
// this is not tested. @MariemElFouzi
use PDO;
use PDOException;

class DatabaseConnection
{
    private static $connection;

    private function __construct()
    {
        // Private constructor to prevent instantiation
    }

    public static function getInstance()
    {
        if (self::$connection === null) {
            $config = include __DIR__ . '/../config/database.php';
            $servername = $config['servername'];
            $username = $config['username'];
            $password = $config['password'];
            $dbname = $config['dbname'];

            var_dump($config);
            try {
                self::$connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            }
            catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
        }

        return self::$connection;
    }
}


