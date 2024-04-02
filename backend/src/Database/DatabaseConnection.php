<?php

namespace Database;
use PDO;

class DatabaseConnection
{
    private static $connection;
    /**
     * DatabaseConnection constructor.
     */
    private function __construct()
    {
        // Private constructor to prevent instantiation
    }
    /**
     * Get the database connection
     * @return PDO
     */
    public static function getInstance()
    {
        if (self::$connection === null) {
            $config = include __DIR__ . '/../config/database.php';
            $servername = $config['servername'];
            $username = $config['username'];
            $password = $config['password'];
            $dbname = $config['dbname'];

            self::$connection = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8",
                                            $username,
                                            $password,
                                            array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'));
        }

        return self::$connection;
    }
}


