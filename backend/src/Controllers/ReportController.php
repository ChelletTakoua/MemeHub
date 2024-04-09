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
    /**
     * Get all reports in the database
     */
    public function getAllReports()
    {
        $reports = ReportTableManager::getReport();
        $response = ApiResponseBuilder::buildSuccessResponse(["reports" => $reports]);
        echo json_encode($response);
    }

    /**
     * Resolve a report (changes the status to resolved and blocks the meme)
     * @param $id
     * @throws NotFoundException
     */
    public function resolveReport($id)
    {
        $report = ReportTableManager::getReportById($id);
        if ($report) {
            ReportTableManager::updateReportStatus($id, "resolved");
            $meme_id = $report->getMemeId();
            $blockedMeme = BlockedMemeTableManager::addBlockedMeme($meme_id, $report->getUserId(), $id);
            $response = ApiResponseBuilder::buildSuccessResponse();
            echo json_encode($response);
        } else {
            throw new NotFoundException("Report not found");
        }
    }

    /**
     * Ignore a report (changes the status to ignored)
     * @param $id
     * @throws NotFoundException
     */
    public function ignoreReport($id)
    {
        $report = ReportTableManager::getReportById($id);
        if ($report) {
            ReportTableManager::updateReportStatus($id, "ignored");
            if (BlockedMemeTableManager::blockedMemeExistsByReportId($id)) {
                BlockedMemeTableManager::deleteBlockedMemeByReportId($id);
            }
            $response = ApiResponseBuilder::buildSuccessResponse();
            echo json_encode($response);
        } else {
            throw new NotFoundException("Report not found");
        }
    }

    /**
     * Delete a report from the database
     * @param $id
     * @throws NotFoundException
     */
    public function deleteReport($id)
    {
        $report = ReportTableManager::getReportById($id);
        if ($report) {
            ReportTableManager::deleteReport($id);
            $response = ApiResponseBuilder::buildSuccessResponse();
            echo json_encode($response);
        } else {
            throw new NotFoundException("Report not found");
        }
    }
}
