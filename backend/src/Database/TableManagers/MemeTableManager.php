<?php

namespace Database\TableManagers;

use Models\Meme;

class MemeTableManager extends TableManager
{

    public function save($model)
    {
        echo "MemeTableManager save method called";
    }

    public function retrieve($id)
    {
        // TODO: Implement retrieve() method.
    }
}