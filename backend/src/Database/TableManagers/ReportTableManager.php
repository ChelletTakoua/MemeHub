<?php

namespace Database\TableManagers;

use Database\DatabaseQuery;
use Exceptions\HttpExceptions\HttpException;
use Exceptions\HttpExceptions\MethodNotAllowedException;
use Models\Report;
use Models\User;

class ReportTableManager extends TableManager
{
    //-----------------get methods----------------
    // general get method
    /**
     * Get reports from database based on parameters given in $params preformatted as an associative array
     * @param array $params
     * @return Report[]
     */
    static public function getReport(array $params = []): array{

        $queryObjects = DatabaseQuery::executeQuery("select", "reports", [], $params);
        $reports = [];
        foreach ($queryObjects as $queryObject) {
            $reports[] = new Report($queryObject['id'],
                                    $queryObject['reason'],
                                    $queryObject['report_date'],
                                    $queryObject['meme_id'],
                                    $queryObject['user_id'],
                                    $queryObject['status']);
        }
        return $reports;

    }

    // specific get methods
    static public function getReportById(int $id): ?Report{
        if ($id < 0) {
            return null;
        }
        $reports = self::getReport(["id" => $id]);
        if(!empty($reports)){
            return $reports[0];
        }
        return null;
    }

    static public function getReportByMemeId(int $meme_id): ?array{
        if ( empty(MemeTableManager::getMemeById($meme_id,true)) ) {
            return null;
        }
        $reports = self::getReport(["meme_id" => $meme_id]);
        if(!empty($reports)){
            return $reports;
        }
        return null;
    }

    static public function getReportByUserId(int $user_id): ?array{
        if (!UserTableManager::verifyExistenceById($user_id)) {
            return null;
        }
        $reports = self::getReport(["user_id" => $user_id]);
        if(!empty($reports)){
            return $reports;
        }
        return null;
    }
    
    static public function getReportByStatus(string $status): ?array{
        if ($status == "pending" || $status == "resolved" || $status == "ignored") {
            $reports = self::getReport(["status" => $status]);
            if (!empty($reports)) {
                return $reports;
            }
        }
        return null;
    }

    static public function getReportByMemeIdAndUserId(int $meme_id, int $user_id): ?Report{
        if (!UserTableManager::verifyExistenceById($user_id) || !MemeTableManager::memeExists($meme_id)) {
            return null;
        }
        $reports = self::getReport(["meme_id" => $meme_id, "user_id" => $user_id]);
        if(!empty($reports)){
            return $reports[0];
        }
        return null;
    }


    //-----------------verify existence methods----------------
    static public function reportExists(int $id): bool{
        return self::getReportById($id) != null;
    }


    //-----------------add methods----------------
    /**
     * Add a report to the database
     * @param string $reason
     * @param int $meme_id
     * @param int $user_id
     * @return Report|null
     */
    static public function addReport(string $reason, int $meme_id, int $user_id): ?Report{



        if( empty( MemeTableManager::memeExists($meme_id) && empty( BlockedMemeTableManager::blockedMemeExists($meme_id) ) )
            || empty( UserTableManager::verifyExistenceById($user_id) )
            || !empty(self::getReportByMemeIdAndUserId($meme_id, $user_id) ))
        {
            throw new MethodNotAllowedException("Meme not found or already reported by user or user not found");
        }
        DatabaseQuery::executeQuery("insert", "reports", ["reason" => $reason, "meme_id" => $meme_id, "user_id" => $user_id]);
        $id = DatabaseQuery::getLastInsertId();
        $rep =  self::getReportById($id);
        if($rep == null){
            throw new HttpException("Report not found after creation");
        }
        return $rep;

    }



    //-----------------delete methods----------------
    // general delete method
    /**
     * Delete reports from database based on parameters given in $params preformatted as an associative array
     * @param array $params
     * @return void
     */
    static public function deleteReport(array $params = []): void
    {
        DatabaseQuery::executeQuery("delete", "reports", [], $params);
    }

    // specific delete methods
    static public function deleteReportById(int $id): void{
        if ($id < 0) {
            return;
        }
        self::deleteReport(["id" => $id]);
    }

    static public function deleteReportByMemeId(int $meme_id): void{
        if (!MemeTableManager::memeExists($meme_id)) {
            return;
        }
        self::deleteReport(["meme_id" => $meme_id]);
    }

    static public function deleteReportByUserId(int $user_id): void{
        if (!UserTableManager::verifyExistenceById($user_id)) {
            return;
        }
        self::deleteReport(["user_id" => $user_id]);
    }

    //--------update methods----------------
    // general update method
    /**
     * Update reports in database based on parameters given in $params and conditions given in $conditions
     * @param array $params
     * @param array $conditions
     */
    static public function updateReport(array $params = [], array $conditions = []): void
    {
        if (!empty($params) && !empty($conditions)) {
            DatabaseQuery::executeQuery("update", "reports", $params, $conditions);
        }
    }

    // specific update methods
    static public function updateReportReason(int $id, string $reason): void{
        if ($id < 0 ) {
            return;
        }
        self::updateReport(["reason" => $reason], ["id" => $id]);
    }

    static public function updateReportMemeId(int $id, int $meme_id): void{
        if ($id < 0 || !MemeTableManager::memeExists($meme_id)) {
            return;
        }
        self::updateReport(["meme_id" => $meme_id], ["id" => $id]);
    }
    static public function updateReportStatus(int $id, string $status): void{
        if ($id < 0 || ($status != "pending" && $status != "resolved" && $status != "ignored")) {
            return;
        }
        self::updateReport(["status" => $status], ["id" => $id]);
    }


    //--------save/retrieve methods----------------
    public static function retrieve($id): ?Report
    {
        return self::getReportById($id);
    }
    public function save($model)
    {
        echo "ReportTableManager save method called";
    }

}