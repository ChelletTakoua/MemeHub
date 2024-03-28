<?php

namespace Database\TableManagers;

use Models\Meme;

class UserTableManager extends TableManager
{

    public function save($model)
    {
        echo "MemeTableManager save method called";
    }

}