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

    /**
     * Execute a query on the database and return the result (if any) as an associative array of rows(columns => values).
     * No need to write a separate method for each query type (SELECT, INSERT, UPDATE, DELETE). You need to create the connection to the database first
     * , instantiate the DatabaseQuery class and call the executeQuery method with the following parameters:
     * @param $queryType : SELECT, INSERT, UPDATE, DELETE
     * @param $table : the table name
     * @param $attributes : associative array of columns => values for INSERT and UPDATE queries (pass it empty for SELECT and DELETE queries)
     * @param $conditions : associative array of columns => values for WHERE clause (pass it empty for INSERT queries)
     * @return array|false
     * @example
     * $query = new DatabaseQuery();
     * $queryObjects = $query->executeQuery("insert","users",["username" => "louey" , "password" => "123456"] ,"email" => "h@gmail.com","role" => "admin"]);
     * $queryObjects = $query->executeQuery("update","users",["username" => "louey"],["username" => "nero"]);
     */

    public function executeQuery($queryType, $table, $attributes = [], $conditions = [])
    {
        $query = "";
        switch (strtoupper($queryType)){
            case "SELECT":
                $query = $queryType . " * FROM " . $table;
                if(count($conditions) > 0){
                    $whereClause = [];
                    foreach($conditions as $condition => $value){
                        $whereClause[] = "$condition = :where_$condition";
                        $conditions["where_$condition"] = $value;
                        unset($conditions[$condition]);
                    }
                    $query .= " WHERE " . implode(" AND ", $whereClause);
                }
                break;

            case "DELETE":
                $whereClause = [];
                foreach($conditions as $condition => $value){
                    $whereClause[] = "$condition = :where_$condition";
                    $conditions["where_$condition"] = $value;
                    unset($conditions[$condition]);
                }
                $query = $queryType . " FROM " . $table .
                         " WHERE " . implode(" AND ", $whereClause);
                break;

            case "INSERT":
                $columns = [];
                $values = [];
                foreach($attributes as $column => $value){
                    $columns[] = $column;
                    $values[] = ":$column";
                }
                $query = $queryType . " INTO " . $table .
                         " (" . implode(", ", $columns) . ") VALUES (" . implode(", ", $values) . ")";
                break;

            case "UPDATE":
                $setClause = [];
                foreach($attributes as $column => $value){
                    $setClause[] = "$column = :set_$column";
                    $attributes["set_$column"] = $value;
                    unset($attributes[$column]);
                }
                $whereClause = [];
                foreach($conditions as $condition => $value){
                    $whereClause[] = "$condition = :where_$condition";
                    $conditions["where_$condition"] = $value;
                    unset($conditions[$condition]);
                }
                $query = $queryType . " " . $table .
                         " SET " . implode(", ", $setClause) .
                         " WHERE " . implode(" AND ", $whereClause);
                break;

        }

        echo "<hr> $query <hr>";

        $statement = $this->connection->prepare($query);
        $statement->execute(array_merge($attributes, $conditions));
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


}