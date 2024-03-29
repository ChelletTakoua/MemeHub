<?php

namespace Database\TableManagers;

use Models\Like;

class LikeTableManager extends TableManager
{

    public function save($model)
    {
        echo "LikeTableManager save method called";
    }

}