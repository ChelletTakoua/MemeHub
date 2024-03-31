<?php

namespace Controllers;

use Database\TableManagers\BlockedMemeTableManager;
use Database\TableManagers\MemeTableManager;
use Database\TableManagers\ReportTableManager;
use Utils\ApiResponseBuilder;
use Models\Report;
use Exceptions\HttpExceptions\NotFoundException;
use Models\BlockedMeme;

class ReportController
{

    public function getAllReports()
    {
        $reports = ReportTableManager::getReport();
        $response = ApiResponseBuilder::buildSuccessResponse(["reports" => $reports]);
        echo json_encode($response);
    }

    public function resolveReport($id)
    {
        //get the report
        $report=ReportTableManager::getReportById($id);
        if ($report) {
            //update the report status to resolved
            ReportTableManager::updateReportStatus($id, "resolved");
            
            //block the meme
            $meme= $report->getMeme();
            $meme_id=$meme->getId();
            $blockedMeme= BlockedMemeTableManager::addBlockedMeme($meme_id, $report->getUserId(), $id);
            // Build a success response
            $response = ApiResponseBuilder::buildSuccessResponse();
            echo json_encode($response);
        } 
        else {
            throw new NotFoundException("Report not found");
        }
    }

    public function ignoreReport($id)
    {
        //get the report
        $report=ReportTableManager::getReportById($id);
        if ($report) {
            //update the report status to resolved
            ReportTableManager::updateReportStatus($id, "ignored");
            // Build a success response
            $response = ApiResponseBuilder::buildSuccessResponse();
            echo json_encode($response);
        } 
        else {
            throw new NotFoundException("Report not found");
        }
        //ignore pending resolve
    }

    public function deleteReport($id)
    {
        //get the report
        $report=ReportTableManager::getReportById($id);
        if ($report) {
            //delete the report
            ReportTableManager::deleteReport($id);
            // Build a success response
            $response = ApiResponseBuilder::buildSuccessResponse();
            echo json_encode($response);
        } 
        else {
            throw new NotFoundException("Report not found");
        }
    }


}