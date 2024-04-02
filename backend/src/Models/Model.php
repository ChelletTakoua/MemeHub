<?php

namespace Models;

use Database\ModelTableMapper;
use Database\TableManagers\TableManager;
use JsonSerializable;





abstract class Model implements JsonSerializable
{

    private $id;
    /**
     * Create a new instance of the model
     * @param int $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }
    /**
    * get the id of the model
    * @return int
     */

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



    
    



    /**
     * this method returns the TableManager class that handles the database operations, the tableManager name is the class name of the model + 'TableManager'
        * @return string the name of the TableManager class
     */
    public static function getTableManager(): string
    {
       return ModelTableMapper::getTableManagerClassByModel(get_called_class());
    }

}
