<?php

namespace Database\TableManagers;


use Database\ModelTableMapper;

abstract class TableManager
{
    private static $instances = [];
    /**
     * TableManager constructor.
     */
    private function __construct()
    {
        // Private constructor to prevent direct instantiation
    }
    /**
     * this function is used to get the class name of an object
     * @return static
     */
    public static function getInstance()
    {
        $className = static::class;
        if (!isset(self::$instances[$className])) {
            self::$instances[$className] = new static();
        }
        return self::$instances[$className];
    }
   
    /**
     * Retrieves the model from the database.
     * @param array $params
     */
    public static abstract function retrieve($id);
    /**
     * gets the table name of the table manager
     * @return string
     */
    public function getTableName(): string
    {
        return ModelTableMapper::getTableNameByTableManager(static::class);
    }






}
