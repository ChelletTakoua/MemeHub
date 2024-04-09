<?php

namespace Database;

use PDO;

class DatabaseQuery
{
    public function __construct()
    {
        //cstructor
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

    static public function executeQuery($queryType, $table, $attributes = [], $conditions = [], $additionalWhereCondition = ""): array
    {
        $connection = DatabaseConnection::getInstance();
        $query = "";
        switch (strtoupper($queryType)) {
            case "SELECT":
                $query = $queryType . " * FROM " . $table;
                if (count($conditions) > 0 || $additionalWhereCondition != "") {
                    $whereClause = [];
                    foreach ($conditions as $condition => $value) {
                        $whereClause[] = "$condition = :where_$condition";
                        $conditions["where_$condition"] = $value;
                        unset($conditions[$condition]);
                    }

                    if ($additionalWhereCondition != "") {
                        $whereClause[] = $additionalWhereCondition;
                    }

                    $query .= " WHERE " . implode(" AND ", $whereClause);
                }
                break;

            case "DELETE":
                $whereClause = [];
                foreach ($conditions as $condition => $value) {
                    $whereClause[] = "$condition = :where_$condition";
                    $conditions["where_$condition"] = $value;
                    unset($conditions[$condition]);
                }
                if ($additionalWhereCondition != "") {
                    $whereClause[] = $additionalWhereCondition;
                }
                $query = $queryType . " FROM " . $table .
                    " WHERE " . implode(" AND ", $whereClause) . $additionalWhereCondition;
                break;

            case "INSERT":
                $columns = [];
                $values = [];
                foreach ($attributes as $column => $value) {
                    $columns[] = $column;
                    $values[] = ":$column";
                }
                $query = $queryType . " INTO " . $table .
                    " (" . implode(", ", $columns) . ") VALUES (" . implode(", ", $values) . ")";
                break;

            case "UPDATE":
                $setClause = [];
                foreach ($attributes as $column => $value) {
                    $setClause[] = "$column = :set_$column";
                    $attributes["set_$column"] = $value;
                    unset($attributes[$column]);
                }
                $whereClause = [];
                foreach ($conditions as $condition => $value) {
                    $whereClause[] = "$condition = :where_$condition";
                    $conditions["where_$condition"] = $value;
                    unset($conditions[$condition]);
                }
                if ($additionalWhereCondition != "") {
                    $whereClause[] = $additionalWhereCondition;
                }
                $query = $queryType . " " . $table .
                    " SET " . implode(", ", $setClause) .
                    " WHERE " . implode(" AND ", $whereClause);
                break;
        }


        $statement = $connection->prepare($query);
        $statement->execute(array_merge($attributes, $conditions));
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get the last inserted id by an INSERT query
     * @return int
     */
    static public function getLastInsertId(): int
    {
        return intval(DatabaseConnection::getInstance()->lastInsertId());
    }

    static public function fileLoader($file)
    {
        $connection = DatabaseConnection::getInstance();
        $query = file_get_contents($file);
        $statement = $connection->prepare("File_Load( $query )");
        $statement->execute();
    }
}
