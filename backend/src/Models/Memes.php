<?php
namespace Models;
use Utils\Proxy;

class Memes {
    private $id;
    private $templateId;
    private $title;
    private $userId;
    private $dateCreation;
    private $nbLikes;

    public function __construct($id, $templateId, $title, $userId, $dateCreation) {
        $this->id = $id;
        $this->templateId = $templateId;
        $this->title = $title;
        $this->userId = new Proxy($userId, User::class);
        $this->dateCreation = $dateCreation;
        $this->nbLikes = 0;
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
        return $this->userId->getId();
    }
    public function getUser() {
        return $this->userId->getInstance();
    }

    public function getDateCreation() {
        return $this->dateCreation;
    }

    public function setDateCreation($dateCreation) {
        $this->dateCreation = $dateCreation;
    }
}