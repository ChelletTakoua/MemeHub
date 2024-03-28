<?php

namespace Models;

use Database\TableManager;

abstract class Model
{

    //TODO: @MariemELFouzi @LoueySiwa this is just a suggestion
    // we can add the following properties to the Model class
    // $primaryKeys: an array to store the primary key column names (@louey fasrelha el faza hedhi)
    // $attributes: a map to store the attributes of the model (column name => attribute name). This one is optional, but it can be useful.
    protected static $primaryKeys = []; // The primary key column names
    protected static $attributes = []; // Array to store the attributes of the model



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
    public function getTableManager(): TableManager
    {
        $tableManagerName = 'Database\\' . basename(get_class($this)) . 'TableManager';
        return  $tableManagerName::GetInstance();
    }

}
