<?php

namespace Models;

use Database\ModelTableMapper;
use Database\TableManagers\TableManager;
use JsonSerializable;

abstract class Model implements JsonSerializable
{


    //public abstract function getPrimaryKeyColumnName(): string;


    /**
     * this method retrieves the model from the database
     * @param int $id the id of the model
     * @return Model the model retrieved from the database
     */
    public static function retrieve($id)
    {
        $tableManager = self::getTableManager();
        return $tableManager->retrieve($id);
    }

    //TODO: the id is created by the database (maybe other attributes too), so we should retrieve the new object from the database after saving it
    // either return the new object or update the current object with the new values
    /**
     * this method saves the model to the database
     * @return void
     *
     */
    public function save()
    {
        // save the model to the database
        $tableManager = $this->getTableManager();
        $tableManager->save($this);

    }




    /**
     * this method returns the TableManager class that handles the database operations, the tableManager name is the class name of the model + 'TableManager'
     * @return TableManager the TableManager class that handles the database operations
     */
    public static function getTableManager(): TableManager
    {
       return ModelTableMapper::getTableManagerClassByModel(get_called_class())::getInstance();
    }

    /*public static function getTableManager(): TableManager
    {
        $tableManagerName = 'Database\\' . basename(get_called_class()) . 'TableManager';
        if (class_exists($tableManagerName) && is_subclass_of($tableManagerName, TableManager::class)) {
            return $tableManagerName::GetInstance();
        }
        throw new \Exception("Class $tableManagerName does not exist or does not extend TableManager");
    }*/
}
