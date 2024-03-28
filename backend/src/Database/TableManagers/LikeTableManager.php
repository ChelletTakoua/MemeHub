<?php

namespace Database\TableManagers;

use Models\Like;

class UserTableManager extends TableManager
{

    public function save($model)
    {
        echo "LikeTableManager save method called";
    }

}