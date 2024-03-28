<?php

namespace Models;

use Database\ModelTableMapper;
use Database\TableManagers\TableManager;
use JsonSerializable;


//TODO: make all Models extend this class
// implement the method jsonSerialize
// this method should return the json object to return to the client (example in user)
//


abstract class Model implements JsonSerializable
{

    private $id;

    public function getId()
    {
        return $this->id;
    }



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

}
