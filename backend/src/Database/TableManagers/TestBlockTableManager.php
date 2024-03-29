<?php

namespace Database\TableManagers;

use Models\TextBlock;

class TestBlockTableManager extends TableManager
{

    public function save($model)
    {
        echo "TextBlockTableManager save method called";
    }


    public function retrieve($id)
    {
        // TODO: Implement retrieve() method.
    }
}