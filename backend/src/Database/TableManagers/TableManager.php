<?php

namespace Database\TableManagers;


use Database\ModelTableMapper;

abstract class TableManager
{
    private static $instances = [];

    private function __construct()
    {
        // Private constructor to prevent direct instantiation
    }

    public static function getInstance()
    {
        $className = static::class;
        if (!isset(self::$instances[$className])) {
            self::$instances[$className] = new static();
        }
        return self::$instances[$className];
    }
    public function save($model)
    {
        echo "TableManager save method called";
    }

    public abstract function retrieve($id);

    public function getTableName()
    {
        return ModelTableMapper::getTableNameByTableManager(static::class);
    }






}
