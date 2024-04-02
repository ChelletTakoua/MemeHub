<?php

namespace Database;

class ModelTableMapper
{

    private static $mappings = [];

     const MODEL_NAMESPACE = 'Models\\';
     const TABLE_MANAGER_NAMESPACE = 'Database\\TableManagers\\';
    /**
     * Register a mapping between a model class and a table manager class and the database table name
     * @param string $modelClass the model class
     * @param string $tableManagerClass the table manager class
     * @param string $tableName the name of the table in the database
     */
    public static function registerMapping(string $modelClass, string $tableManagerClass, string $tableName)
    {
        $modelClass = self::addModelNamespace($modelClass);
        $tableManagerClass = self::addTableManagerNamespace($tableManagerClass);
        self::$mappings[$modelClass] = ['tableManager' => $tableManagerClass, 'tableName' => $tableName];
        self::$mappings[$tableManagerClass] = ['model' => $modelClass, 'tableName' => $tableName];
    }
    /**
     * Get the table manager class for a model class
     * @param string $modelClass the model class
     * @return string the table manager class
     */
    public static function getTableManagerClassByModel(string $modelClass): string
    {
        $modelClass = self::addModelNamespace($modelClass);
        return self::$mappings[$modelClass]['tableManager'] ?? '';
    }
    /**
     * Get the table name for a model class
     * @param string $modelClass the model class
     * @return string the model class
     */

    public static function getTableNameByModel(string $modelClass): string
    {
        $modelClass = self::addModelNamespace($modelClass);
        return self::$mappings[$modelClass]['tableName']  ?? '';
    }
    /**
     * Get the model class for a table manager class
     * @param string $tableManagerClass the table manager class
     * @return string the model class
     */

    public static function getModelClassByTableManager(string $tableManagerClass): string
    {
        $tableManagerClass = self::addTableManagerNamespace($tableManagerClass);
        return self::$mappings[$tableManagerClass]['model'] ?? '';
    }
    /**
     * Get the table name for a table manager class
     * @param string $tableManagerClass the table manager class
     * @return string the table name
     */
    public static function getTableNameByTableManager(string $tableManagerClass): string
    {
        $tableManagerClass = self::addTableManagerNamespace($tableManagerClass);
        return self::$mappings[$tableManagerClass]['tableName'] ?? '';
    }


    /**
     * this method adds the namespace to the model class if it is not already present
     * @param string $modelClass
     * @return string the model class with the namespace
     */
    private static function addModelNamespace(string $modelClass): string
    {
        if (strpos($modelClass, self::MODEL_NAMESPACE) === false) {
            return self::MODEL_NAMESPACE . $modelClass;
        }
        return $modelClass;
    }


    /**
     * this method adds the namespace to the table manager class if it is not already present
     * @param string $tableManagerClass
     * @return string the table manager class with the namespace
     */
    private static function addTableManagerNamespace(string $tableManagerClass): string
    {
        if (strpos($tableManagerClass, self::TABLE_MANAGER_NAMESPACE) === false) {
            return self::TABLE_MANAGER_NAMESPACE . $tableManagerClass;
        }
        return $tableManagerClass;
    }
}

require 'modelTableMapping.php';

