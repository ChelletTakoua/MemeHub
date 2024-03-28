<?php

namespace Database;

use Database\TableManager;

class UserTableManager extends TableManager
{

    public function save($model)
    {
        echo "UserTableManager save method called";
    }


}
