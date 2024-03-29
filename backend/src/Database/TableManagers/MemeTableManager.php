<?php

namespace Database\TableManagers;

use Models\Meme;

class UserTableManager extends TableManager
{

    public function save($model)
    {
        echo "MemeTableManager save method called";
    }
    public function getMeme($attribut,$value) //from database
    {
        $query = new DatabaseQuery();
        $queryObjects = $query->executeQuery("select","memes",[],[$attribut => $value]);
        $meme=new meme($queryObjects[0]["id"],
            $queryObjects[0]["template_id"],
            $queryObjects[0]["custom_title"],
            $queryObjects[0]["user_id"],
            $queryObjects[0]["creation_date"]);
        $meme->setNbLikes($queryObjects[0]["nb_likes"]);
        return $user;    
    }

}