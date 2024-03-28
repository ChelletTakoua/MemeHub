<?php
namespace Models;
class Report {
    private $id;
    private $reason;
    private $reportDate;
    private $memeId;
    private $userId;

    public function __construct($id, $reason, $reportDate, $meme, $user) {
        $this->id = $id;
        $this->reason = $reason;
        $this->reportDate = $reportDate;
        $this->memeId = $meme;
        $this->userId = $user;
    }

    public function getId() {
        return $this->id;
    }

    public function getReason() {
        return $this->reason;
    }

    public function getReportDate() {
        return $this->reportDate;
    }

    public function getMemeId() {
        return $this->memeId;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setReason($reason) {
        $this->reason = $reason;
    }

    public function setReportDate($reportDate) {
        $this->reportDate = $reportDate;
    }

   
}