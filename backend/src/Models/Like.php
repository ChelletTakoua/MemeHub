<?php
namespace Models;
class Like {
    private $id;
    private $memeId;
    private $userId;

    public function __construct($id, $memeId, $userId) {
        $this->id = $id;
        $this->memeId = $memeId;
        $this->userId = $userId;
    }

    public function getId() {
        return $this->id;
    }

    public function getMemeId() {
        return $this->memeId;
    }

    public function getUserId() {
        return $this->userId;
    }
}