<?php

namespace Database\TableManagers;

use Database\DatabaseQuery;
use Models\BlockedMeme;

class BlockedMemeTableManager extends TableManager
{
    //--------get methods----------------
    // general get method
    /**
     * Get blocked memes from database based on parameters given in $params preformatted as an associative array
     * @param array $params
     * @return BlockedMeme[]
     */
    static public function getBlockedMeme(array $params=[]): array
    {
        $queryObjects = DatabaseQuery::executeQuery("select","blocked_memes",[],$params);
        $blockedMemes = [];
        foreach ($queryObjects as $queryObject ) {
            $blockedMemes[] = new BlockedMeme($queryObject['id'],
                                $queryObject['meme_id'],
                                $queryObject['admin_id'],
                                $queryObject['report_id']);
        }
        return $blockedMemes;
    }
    // specific get methods

    /**
     * Get blocked meme from database based on id
     * @param int $id
     * @return BlockedMeme|null
     */
    static public function getBlockedMemeById(int $id): ?  BlockedMeme
    {
        if($id < 0){
            return null;
        }
        $blockedMemes = self::getBlockedMeme(["id" => $id]);
        if(!empty($blockedMemes)){
            return $blockedMemes[0];
        }
        return null;
    }

    /**
     * Get blocked meme from database based on meme_id given as parameter
     * @param int $meme_id
     * @return  BlockedMeme[]
     */
    static public function getBlockedMemeByMemeId(int $meme_id):   array
    {
        if( empty(MemeTableManager::getMemeById($meme_id,true)) ){
            return [];
        }
        $blockedMemes = self::getBlockedMeme(["meme_id" => $meme_id]);
        if(!empty($blockedMemes)){
            return $blockedMemes;
        }
        return [];
    }
    /**
     * Get blocked meme from database based on admin_id given as parameter
     * @param int $admin_id
     * @return BlockedMeme[]
     */
    static public function getBlockedMemeByAdminId(int $admin_id):   array
    {
        if(!UserTableManager::verifyExistenceById($admin_id)){
            return [];
        }
        $blockedMemes = self::getBlockedMeme(["admin_id" => $admin_id]);
        if(!empty($blockedMemes)){
            return $blockedMemes;
        }
        return [];

    }
    /**
     * Get blocked meme from database based on report_id given as parameter
     * @param int $report_id
     * @return BlockedMeme|null
     */
    static public function getBlockedMemeByReportId(int $report_id): ?  BlockedMeme
    {
        if( $report_id < 0 && !ReportTableManager::reportExists($report_id) ){
            return null;
        }
        $blockedMemes = self::getBlockedMeme(["report_id" => $report_id]);
        if(!empty($blockedMemes)){
            return $blockedMemes[0];
        }
        return null;

    }

    //--------verify existence methods----------------

    /**
     * Check if blocked meme exists in database based on id
     * @param int $id
     * @return bool
     */
    static public function blockedMemeExists(int $id): bool
    {
        return !empty( self::getBlockedMemeById($id) ) ;
    }
    /**
     * Check if blocked meme exists in database based on meme_id
     * @param int $meme_id
     * @return bool
     
     */
    static public function blockedMemeExistsByMemeId(int $meme_id): bool
    {
        return !empty( self::getBlockedMemeByMemeId($meme_id) ) ;
    }
    /**
     * Check if blocked meme exists in database based on admin_id
     * @param int $admin_id
     * @return bool
     */
    static public function blockedMemeExistsByAdminId(int $admin_id): bool
    {
        return !empty( self::getBlockedMemeByAdminId($admin_id) ) ;
    }
    /**
     * Check if blocked meme exists in database based on report_id
     * @param int $report_id
     * @return bool
     */
    static public function blockedMemeExistsByReportId(int $report_id): bool
    {
        return !empty( self::getBlockedMemeByReportId($report_id) ) ;
    }

    //--------add methods----------------
    /**
     * Add blocked meme to database based on report_id given as parameters and return the blocked meme object
     * @param int $meme_id
     * @param int $admin_id
     * @param int $report_id
     * @return BlockedMeme|null
     */
    static public function addBlockedMeme(int $meme_id, int $admin_id, int $report_id): ?BlockedMeme
    {
        if( self::blockedMemeExistsByMemeId($meme_id) || !UserTableManager::verifyExistenceById($admin_id) || !ReportTableManager::reportExists($report_id)) {
            return null;
        }
        DatabaseQuery::executeQuery("insert","blocked_memes",["meme_id"=>$meme_id,"admin_id"=>$admin_id,"report_id"=>$report_id]);
        $blockedMeme = DatabaseQuery::executeQuery("select","blocked_memes",[],
            ["meme_id"=>$meme_id,"admin_id"=>$admin_id,"report_id"=>$report_id]);

        $id = $blockedMeme[0]["id"];
        return new BlockedMeme($id,$meme_id,$admin_id,$report_id);
    }
    //--------delete methods----------------
    // general delete method
    /**
     * Delete blocked meme from database based on parameters given in $params
     * @param array $params
     * @return bool
     */
    static public function deleteBlockedMeme(array $params): bool
    {
        if( empty(self::getBlockedMeme($params)) ){
            return false;
        }
        DatabaseQuery::executeQuery("delete","blocked_memes",[],$params);
        return true;
    }

    // specific delete methods
    /**
     * Delete blocked meme from database based on id
     * @param int $id
     * @return bool
     */
    static public function deleteBlockedMemeById(int $id): bool
    {
        if($id <= 0){
            return false;
        }
        return self::deleteBlockedMeme(["id" => $id]);
    }
    /**
     * Delete blocked meme from database based on meme_id
     * @param int $meme_id
     * @return bool
     */
    static public function deleteBlockedMemeByMemeId(int $meme_id): bool
    {
        if(!self::blockedMemeExistsByMemeId($meme_id)){
            return false;
        }
        return self::deleteBlockedMeme(["meme_id" => $meme_id]);
    }
    /**
     * Delete blocked meme from database based on admin_id
     * @param int $admin_id
     * @return bool
     */
    static public function deleteBlockedMemeByAdminId(int $admin_id): bool
    {
        if(!self::blockedMemeExistsByAdminId($admin_id)){
            return false;
        }
        return self::deleteBlockedMeme(["admin_id" => $admin_id]);
    }
    /**
     * Delete blocked meme from database based on report_id
     * @param int $report_id
     * @return bool
     */
    static public function deleteBlockedMemeByReportId(int $report_id): bool
    {
        if(!self::blockedMemeExistsByReportId($report_id)){
            return false;
        }
        return self::deleteBlockedMeme(["report_id" => $report_id]);
    }


    //--------retrieve method----------------
    /**
     * Retrieve blocked meme from database based on id
     * @param int $id
     * @return BlockedMeme|null
     */
    public static function retrieve($id): ?BlockedMeme
    {
        return self::getBlockedMemeById($id);
    }

}