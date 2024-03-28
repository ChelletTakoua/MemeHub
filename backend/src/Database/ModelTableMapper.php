<?php

namespace Database;

class ModelTableMapper
{
    private static $mappings = [];

     const MODEL_NAMESPACE = 'Models\\';
     const TABLE_MANAGER_NAMESPACE = 'Database\\TableManagers\\';

    public static function registerMapping(string $modelClass, string $tableManagerClass, string $tableName)
    {
        $modelClass = self::addModelNamespace($modelClass);
        $tableManagerClass = self::addTableManagerNamespace($tableManagerClass);
        self::$mappings[$modelClass] = ['tableManager' => $tableManagerClass, 'tableName' => $tableName];
        self::$mappings[$tableManagerClass] = ['model' => $modelClass, 'tableName' => $tableName];
    }

    public static function getTableManagerClassByModel(string $modelClass): string
    {
        $modelClass = self::addModelNamespace($modelClass);
        return self::$mappings[$modelClass]['tableManager'] ?? '';
    }

    public static function getTableNameByModel(string $modelClass): string
    {
        $modelClass = self::addModelNamespace($modelClass);
        return self::$mappings[$modelClass]['tableName']  ?? '';
    }

    public static function getModelClassByTableManager(string $tableManagerClass): string
    {
        $tableManagerClass = self::addTableManagerNamespace($tableManagerClass);
        return self::$mappings[$tableManagerClass]['model'] ?? '';
    }
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

