<?php
namespace Models;
class BlockedMemes {
    private $id;
    private $memeId;
    private $adminId;
    private $reportId;

    public function __construct($id, $meme, $admin, $report) {
        $this->id = $id;
        $this->memeId = $meme;
        $this->adminId = $admin;
        $this->reportId = $report;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getMeme() {
        return $this->memeId;
    }



    public function getAdmin() {
        return $this->adminId;
    }


    public function getReport() {
        return $this->reportId;
    }


}