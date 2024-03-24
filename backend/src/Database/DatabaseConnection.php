<?php

class DatabaseConnection {
    private static $instance = null;
    private $connection;

    private function __construct($servername, $username, $password, $dbname) {
        $this->connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance($config) {
        if (self::$instance === null) {
            self::$instance = new DatabaseConnection(
                $config['servername'],
                $config['username'],
                $config['password'],
                $config['dbname']
            );
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }
}

