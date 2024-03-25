<?php


// this is not tested. @MariemElFouzi
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
            $config = include 'src/config/database.php';
            $servername = $config['servername'];
            $username = $config['username'];
            $password = $config['password'];
            $dbname = $config['dbname'];

            var_dump($config);
            self::$connection = new mysqli($servername, $username, $password, $dbname);

            if (self::$connection->connect_error) {
                die("Connection failed: " . self::$connection->connect_error);
            }
        }

        return self::$connection;
    }
}


