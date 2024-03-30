<?php

namespace Models;

use Database\ModelTableMapper;
use Database\TableManagers\TableManager;
use JsonSerializable;


//TODO: make all Models extend this class
// implement the method jsonSerialize
// this method should return the json object to return to the client (example in user)
// .
// The foreign keys should be implemented as Proxies


abstract class Model implements JsonSerializable
{

    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }



    /**
     * this method retrieves the model from the database
     * @param int $id the id of the model
     * @return Model the model retrieved from the database
     * @noinspection PhpUndefinedMethodInspection
     */
    public static function retrieve(int $id) : Model
    {
        return self::getTableManager()::retrieve($id);
    }



    //TODO: to remove if not needed
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
        * @return string the name of the TableManager class
     */
    public static function getTableManager(): string
    {
       return ModelTableMapper::getTableManagerClassByModel(get_called_class());
    }

}
