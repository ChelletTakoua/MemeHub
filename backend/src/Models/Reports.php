<?php
class Reports {
    private $id;
    private $reason;
    private $reportDate;
    private $meme;
    private $user;

    public function __construct($id, $reason, $reportDate, $meme, $user) {
        $this->id = $id;
        $this->reason = $reason;
        $this->reportDate = $reportDate;
        $this->meme = $meme;
        $this->user = $user;
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

    public function getMeme() {
        return $this->meme;
    }

    public function getUser() {
        return $this->user;
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