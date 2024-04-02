<?php

namespace Database\TableManagers;

use Database\DatabaseQuery;
use Exceptions\HttpExceptions\MethodNotAllowedException;
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
        if($id > 0){
            $likes = self::getLike(["id" => $id]);
            if(!empty($likes)){
                return $likes[0];
            }
        }
        return null;
    }
    /**
     * Get like from database based on meme_id
     * @param int $meme_id
     * @return Like[]
     */
    static public function getLikeByMemeId(int $meme_id): ?array{
        if( MemeTableManager::memeExists($meme_id)){
            $likes = self::getLike(["meme_id" => $meme_id]);
            if(!empty($likes)){
                return $likes;
            }
        }
        return [];
    }
    /**
     * Get like from database based on user_id
     * @param int $user_id
     * @return Like[]
     */
    static public function getLikeByUserId(int $user_id): ?array{
        if( UserTableManager::verifyExistenceById($user_id)){
            $likes = self::getLike(["user_id" => $user_id]);
            if(!empty($likes)){
                return $likes;
            }
        }
        return [];
    }

    /**
     * Get like from database based on meme_id and user_id
     * @param int $meme_id
     * @param int $user_id
     * @return Like|null
     */
    static public function getLikeByMemeIdAndUserId(int $meme_id, int $user_id): ?Like
    {
        if(!UserTableManager::verifyExistenceById($user_id) || !MemeTableManager::memeExists($meme_id)){
            return null;
        }
        $likes = self::getLike(["meme_id" => $meme_id, "user_id" => $user_id]);
        if (!empty($likes)) {
            return $likes[0];
        }
        return null;
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

    /**
     * Check if like exists in database based on meme_id and user_id
     * @param int $meme_id
     * @param int $user_id
     * @return bool
     */
    static public function likeExistsByMemeIdAndUserId(int $meme_id, int $user_id): bool{
        return !empty( self::getLikeByMemeIdAndUserId($meme_id, $user_id) ) ;
    }

    //--------add methods----------------
    /**
     * Add like to database with parameters given as arguments
     * @param int $meme_id
     * @param int $user_id
     * @return Like|null
     */
    static public function addLike(int $meme_id, int $user_id): ?Like{

        if( self::likeExistsByMemeIdAndUserId($meme_id, $user_id)){
            throw new MethodNotAllowedException('Meme already liked');
        }
        $queryObject = DatabaseQuery::executeQuery("insert","likes",["meme_id" => $meme_id ,"user_id" =>$user_id ]);
        $like = self::getLikeByMemeIdAndUserId($meme_id, $user_id);
        return new Like($like->getId(), $like->getMemeId(), $like->getUserId());

    }

    //--------delete methods----------------
    // general delete method
    /**
     * Delete like from database based on parameters given in $params preformatted as an associative array
     * @param array $params
     * @return bool
     */
    static public function deleteLike(array $params): bool{

        if(empty($params)){
            return false;
        }
        else{
            if(! empty(self::getLike($params))){
                DatabaseQuery::executeQuery("delete","likes",[],$params);
                return true;
            }
        }
        return false;

    }


    // specific delete methods
    static public function deleteLikeById(int $id): bool{
        if($id <= 0){
            return false;
        }
        return self::deleteLike(["id" => $id]);
    }
    static public function deleteLikeByMemeId(int $meme_id): bool{
        if(!self::likeExistsByMemeId($meme_id)){
            return false;
        }
        return self::deleteLike(["meme_id" => $meme_id]);
    }
    static public function deleteLikeByUserId(int $user_id): bool{
        if(!self::likeExistsByUserId($user_id)){
            return false;
        }
        return self::deleteLike(["user_id" => $user_id]);
    }

    static public function deleteLikeByMemeIdAndUserId(int $meme_id, int $user_id): bool{

        if(!self::likeExistsByMemeIdAndUserId($meme_id, $user_id)){
            return false;
        }
        return self::deleteLike(["meme_id" => $meme_id, "user_id" => $user_id]);

    }
    //--------retrive method----------------
    /**
     * Retrieve like from database based on id
     * @param int $id
     * @return Like|null
     */
    public static function retrieve($id) : ?Like
    {
        return self::getLikeById($id);
    }
}