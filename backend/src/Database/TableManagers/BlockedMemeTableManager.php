<?php

namespace Database\TableManagers;

use Models\BlockedMeme;

class BlockedMemeTableManager extends TableManager
{

    public function save($model)
    {
        echo "BlockedMemesTableManager save method called";
    }

    public function retrieve($id)
    {
        // TODO: Implement retrieve() method.
    }
}