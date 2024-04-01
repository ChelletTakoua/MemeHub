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
        $queryObjects =  DatabaseQuery::executeQuery("select","memes",[],$params, " id NOT IN (SELECT meme_id FROM blocked_memes)");

        $memes = [];

        foreach ($queryObjects as $queryObject ) {
            $memes[] = new Meme($queryObject['id'],
                $queryObject['template_id'],
                $queryObject['custom_title'],
                $queryObject['user_id'],
                $queryObject['creation_date'],
                $queryObject['result_img']);
        }
        return $memes;
    }

    // specific get methods
    static public function getMemeById(int $id): ?Meme
    {
        if($id < 0){
            return null;
        }
        $memes = self::getMeme(["id" => $id]);
        if(!empty($memes)){
            return $memes[0];
        }
        return null;
    }

    static public function getMemeByTemplateId(int $template_id): ?array
    {
        if (!TemplateTableManager::templateExists($template_id)) {
            return null;
        }
        return self::getMeme(["template_id" => $template_id]);
    }

    static public function getMemeByUserId(int $user_id): ?array
    {
        if (!UserTableManager::verifyExistenceById($user_id)) {
            return null;
        }
        return self::getMeme(["user_id" => $user_id]);
    }

    static public function getMemeByCreationDate(string $creation_date): ?array
    {
        if(empty($creation_date) || preg_match("/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/", $creation_date) ){
            return null;
        }
        return self::getMeme(["creation_date" => $creation_date]);
    }

    static public function getMemeByCustomTitle(string $custom_title): ?array
    {
        if(empty($custom_title)){
            return null;
        }
        return self::getMeme(["custom_title" => $custom_title]);
    }

    static public function getMemeByNbLikes(int $nb_likes): ?array
    {
        if($nb_likes < 0){
            return null;
        }
        return self::getMeme(["nb_likes" => $nb_likes]);
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
     * @param string $result_img
     * @return Meme|null
     */
    static public function addMeme(int $template_id, string $custom_title, int $user_id, string $result_img ): ?Meme
    {
        if(!UserTableManager::verifyExistenceById($user_id) || !TemplateTableManager::templateExists($template_id)){
            return null;
        }
        DatabaseQuery::executeQuery("insert","memes",["template_id"=>$template_id,"custom_title"=>$custom_title,"user_id"=>$user_id,"result_img"=>$result_img]);
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
        if(!self::memeExists($id)){
            return null;
        }
        DatabaseQuery::executeQuery("update","memes",$attributes,["id"=>$id]);
        return self::getMemeById($id);
    }

    // specific update methods
    static public function updateMemeTemplateId(int $id, int $template_id): ?Meme
    {
        if(!TemplateTableManager::templateExists($template_id) || !self::memeExists($id)){
            return null;
        }
        return self::updateMeme($id,["template_id"=>$template_id]);
    }

    static public function updateMemeCustomTitle(int $id, string $custom_title): ?Meme
    {
        if(empty($custom_title) || !self::memeExists($id)){
            return null;
        }
        return self::updateMeme($id,["custom_title"=>$custom_title]);
    }

    static public function updateMemeUserId(int $id, int $user_id): ?Meme
    {
        if(!UserTableManager::verifyExistenceById($user_id) || !self::memeExists($id)){
            return null;
        }
        return self::updateMeme($id,["user_id"=>$user_id]);
    }
    static public function updateMemeResultImg(int $id, string $result_img): ?Meme
    {
        if(empty($result_img) || !self::memeExists($id)){
            return null;
        }
        return self::updateMeme($id,["result_img"=>$result_img]);
    }

    //--------delete method----------------
    /**
     * Delete meme from database based on id given as parameter
     * @param int $id
     */
    static public function deleteMeme(int $id): void
    {
        if(!self::memeExists($id)){
            return;
        }
        DatabaseQuery::executeQuery("delete","memes",[],["id"=>$id]);
    }

    //--------save and retrieve methods----------------
    public function save($model)
    {
        echo "MemeTableManager save method called";
    }

    public static function retrieve($id): ?Meme
    {
        return self::getMemeById($id);
    }
    

}