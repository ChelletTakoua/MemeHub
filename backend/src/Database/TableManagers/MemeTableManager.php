<?php

namespace Database\TableManagers;

use Database\DatabaseQuery;
use Models\Meme;

class MemeTableManager extends TableManager
{

    //--------get methods----------------
    // general get method
    /**
     * Get memes from database based on parameters given in $params preformatted as an associative array
     * @param array $params
     * @return Meme[]
     */
    static public function getMeme(array $params=[]): array
    {
        //check if the meme exists in blocked memes if yes then don't return it
        $queryObjects = DatabaseQuery::executeQuery("select","blocked_memes",[],[]);
        $blockedMemes = [];
        foreach ($queryObjects as $queryObject ) {
            $blockedMemes[] = $queryObject['meme_id'];
        }
        // if the blocked memes array doesn't contain the meme_id then return the meme
            $queryObjects2 = DatabaseQuery::executeQuery("select","memes",[],$params);
            $memes = [];
            foreach ($queryObjects2 as $queryObject ) {

                if(!in_array($queryObject['id'],$blockedMemes)) {
                    $memes[] = new Meme($queryObject['id'],
                        $queryObject['template_id'],
                        $queryObject['custom_title'],
                        $queryObject['user_id'],
                        $queryObject['creation_date']);
                }

            }
            return $memes;



    }

    // specific get methods
    static public function getMemeById(int $id): ?Meme
    {
        $memes = self::getMeme(["id" => $id]);
        if(!empty($memes)){
            return $memes[0];
        }
        return null;
    }

    static public function getMemeByTemplateId(int $template_id): ?array
    {
        $memes = self::getMeme(["template_id" => $template_id]);
        if (!empty($memes)) {
            return $memes;
        }
        return null;
    }

    static public function getMemeByUserId(int $user_id): ?array
    {
        $memes = self::getMeme(["user_id" => $user_id]);
        if (!empty($memes)) {
            return $memes;
        }
        return null;
    }

    static public function getMemeByCreationDate(string $creation_date): ?array
    {
        $memes = self::getMeme(["creation_date" => $creation_date]);
        if (!empty($memes)) {
            return $memes;
        }
        return null;
    }

    static public function getMemeByCustomTitle(string $custom_title): ?array
    {
        $memes = self::getMeme(["custom_title" => $custom_title]);
        if (!empty($memes)) {
            return $memes;
        }
        return null;
    }

    static public function getMemeByNbLikes(int $nb_likes): ?array
    {
        $memes = self::getMeme(["nb_likes" => $nb_likes]);
        if (!empty($memes)) {
            return $memes;
        }
        return null;
    }

    //--------verify existence methods----------------
    static public function memeExists(int $id): bool
    {
        return !empty(self::getMemeById($id));
    }

    static public function memeExistsByTemplateId(int $template_id): bool
    {
        return !empty(self::getMemeByTemplateId($template_id));
    }

    static public function memeExistsByUserId(int $user_id): bool
    {
        return !empty(self::getMemeByUserId($user_id));
    }

    static public function memeExistsByCustomTitle(string $custom_title): bool
    {
        return !empty(self::getMemeByCustomTitle($custom_title));
    }


    //--------add method----------------
    /**
     * Add meme to database based on template_id, custom_title and user_id given as parameters and return the meme object
     * @param int $template_id
     * @param string $custom_title
     * @param int $user_id
     * @return Meme|null
     */
    static public function addMeme(int $template_id, string $custom_title, int $user_id): ?Meme
    {
        DatabaseQuery::executeQuery("insert","memes",["template_id"=>$template_id,"custom_title"=>$custom_title,"user_id"=>$user_id]);
        $id = DatabaseQuery::getLastInsertId();
        return self::getMemeById($id);
    }

    //--------update methods----------------
    // general update method
    /**
     * Update meme in database based on id and attributes given as parameters and return the meme object
     * @param int $id
     * @param array $attributes
     * @return Meme|null
     */
    static public function updateMeme(int $id, array $attributes): ?Meme
    {
        DatabaseQuery::executeQuery("update","memes",$attributes,["id"=>$id]);
        return self::getMemeById($id);
    }

    // specific update methods
    static public function updateMemeTemplateId(int $id, int $template_id): ?Meme
    {
        return self::updateMeme($id,["template_id"=>$template_id]);
    }

    static public function updateMemeCustomTitle(int $id, string $custom_title): ?Meme
    {
        return self::updateMeme($id,["custom_title"=>$custom_title]);
    }

    static public function updateMemeUserId(int $id, int $user_id): ?Meme
    {
        return self::updateMeme($id,["user_id"=>$user_id]);
    }

    //--------delete method----------------
    /**
     * Delete meme from database based on id given as parameter
     * @param int $id
     */
    static public function deleteMeme(int $id): void
    {
        DatabaseQuery::executeQuery("delete","memes",[],["id"=>$id]);
    }

    //--------save and retrieve methods----------------
    public function save($model)
    {
        echo "MemeTableManager save method called";
    }

    public function retrieve($id): ?Meme
    {
        return $this->getMemeById($id);
    }
    

}