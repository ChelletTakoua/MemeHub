<?php

namespace Database\TableManagers;

use Models\BlockedMeme;

class UserTableManager extends TableManager
{

    public function save($model)
    {
        echo "BlockedMemesTableManager save method called";
    }

}