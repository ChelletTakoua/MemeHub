<?php
class BlockedMemes {
    private $id;
    private $memeId;
    private $adminId;
    private $reportId;

    public function __construct($id, $memeId, $adminId, $reportId) {
        $this->id = $id;
        $this->memeId = $memeId;
        $this->adminId = $adminId;
        $this->reportId = $reportId;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getMemeId() {
        return $this->memeId;
    }

    public function setMemeId($memeId) {
        $this->memeId = $memeId;
    }

    public function getAdminId() {
        return $this->adminId;
    }

    public function setAdminId($adminId) {
        $this->adminId = $adminId;
    }

    public function getReportId() {
        return $this->reportId;
    }

    public function setReportId($reportId) {
        $this->reportId = $reportId;
    }
}