<?php
class Memes {
    private $id;
    private $templateId;
    private $title;
    private $userId;
    private $dateCreation;

    public function __construct($id, $templateId, $title, $userId, $dateCreation) {
        $this->id = $id;
        $this->templateId = $templateId;
        $this->title = $title;
        $this->userId = $userId;
        $this->dateCreation = $dateCreation;
    }

    public function getMemeId() {
        return $this->id;
    }

    public function setMemeId($id) {
        $this->id = $id;
    }

    public function getTemplateId() {
        return $this->templateId;
    }

    public function setTemplateId($templateId) {
        $this->templateId = $templateId;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function getDateCreation() {
        return $this->dateCreation;
    }

    public function setDateCreation($dateCreation) {
        $this->dateCreation = $dateCreation;
    }
}