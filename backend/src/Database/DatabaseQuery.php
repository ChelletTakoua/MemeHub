<?php

namespace Database;

use PDO;

class DatabaseQuery
{
    private $connection;

    public function __construct()
    {
        $this->connection = DatabaseConnection::getInstance();
    }

    public function executeQuery($query, $params = [])
    {
        $stmt = $this->connection->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}