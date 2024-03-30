<?php

namespace Database\TableManagers;

use Database\DatabaseQuery;
use Models\Like;

class LikeTableManager extends TableManager
{
    //--------get methods----------------
    // general get method

    /**
     * Get likes from database based on parameters given in $params preformatted as an associative array
     * @param array $params
     * @return Like[]
     */
    static public function getLike(array $params=[]): array{
        $queryObjects = DatabaseQuery::executeQuery("select","likes",[],$params);
        $likes = [];
        foreach ($queryObjects as $queryObject ) {
            $likes[] = new Like($queryObject['id'],
                                $queryObject['meme_id'],
                                $queryObject['user_id']);
        }
        return $likes;
    }
    // specific get methods
    /**
     * Get like from database based on id
     * @param int $id
     * @return Like|null
     */
    static public function getLikeById(int $id): ?Like{
        $likes = self::getLike(["id" => $id]);
        if(!empty($likes)){
            return $likes[0];
        }
        return null;
    }
    /**
     * Get like from database based on meme_id
     * @param int $meme_id
     * @return Like[]
     */
    static public function getLikeByMemeId(int $meme_id): ?array{
        $likes = self::getLike(["meme_id" => $meme_id]);
        if(!empty($likes)){
            return $likes;
        }
        return [];
    }
    /**
     * Get like from database based on user_id
     * @param int $user_id
     * @return Like[]
     */
    static public function getLikeByUserId(int $user_id): ?array{
        $likes = self::getLike(["user_id" => $user_id]);
        if(!empty($likes)){
            return $likes;
        }
        return [];
    }

    //--------verify existence methods----------------
    /**
     * Check if like exists in database based on id
     * @param int $id
     * @return bool
     */
    static public function likeExists(int $id): bool{
        return !empty( self::getLikeById($id) ) ;
    }

    /**
     * Check if like exists in database based on meme_id
     * @param int $meme_id
     * @return bool
     */
    static public function likeExistsByMemeId(int $meme_id): bool{
        return !empty( self::getLikeByMemeId($meme_id) ) ;
    }

    /**
     * Check if like exists in database based on user_id
     * @param int $user_id
     * @return bool
     */
    static public function likeExistsByUserId(int $user_id): bool{
        return !empty( self::getLikeByUserId($user_id) ) ;
    }

    //--------add methods----------------
    /**
     * Add like to database with parameters given as arguments
     * @param int $meme_id
     * @param int $user_id
     * @return Like|null
     */
    static public function addLike(int $meme_id, int $user_id): ?Like{
        if( self::likeExistsByMemeId($meme_id) && self::likeExistsByUserId($user_id) ){
            return null;
        }
        $queryObject = DatabaseQuery::executeQuery("insert","likes",["meme_id","user_id"],[$meme_id,$user_id]);
        return new Like($queryObject['id'],$meme_id,$user_id);
    }

    //--------delete methods----------------

    /**
     * Delete like from database based on id
     * @param int $id
     * @return bool
     */
    static public function deleteLikeById(int $id): bool{
        return DatabaseQuery::executeQuery("delete","likes",["id" => $id]);
    }
    static public function deleteLikeByMemeId(int $meme_id): bool{
        return DatabaseQuery::executeQuery("delete","likes",["meme_id" => $meme_id]);
    }
    static public function deleteLikeByUserId(int $user_id): bool{
        return DatabaseQuery::executeQuery("delete","likes",["user_id" => $user_id]);
    }
    //--------save/retrive methods----------------
    public function save($model)
    {
        echo "LikeTableManager save method called";
    }

    public function retrieve($id) : ?Like
    {
        return self::getLikeById($id);
    }
}