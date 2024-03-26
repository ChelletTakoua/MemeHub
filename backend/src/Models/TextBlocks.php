<?php
class TextBlocks {
    private $id;
    private $text;
    private $x;
    private $y;
    private $width;
    private $height;
    private $memeId;

    public function __construct($id, $text, $x, $y, $width, $height, $memeId) {
        $this->id = $id;
        $this->text = $text;
        $this->x = $x;
        $this->y = $y;
        $this->width = $width;
        $this->height = $height;
        $this->memeId = $memeId;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getText() {
        return $this->text;
    }

    public function setText($text) {
        $this->text = $text;
    }

    public function getX() {
        return $this->x;
    }

    public function setX($x) {
        $this->x = $x;
    }

    public function getY() {
        return $this->y;
    }

    public function setY($y) {
        $this->y = $y;
    }

    public function getWidth() {
        return $this->width;
    }

    public function setWidth($width) {
        $this->width = $width;
    }

    public function getHeight() {
        return $this->height;
    }

    public function setHeight($height) {
        $this->height = $height;
    }

    public function getMemeId() {
        return $this->memeId;
    }

    public function setMemeId($memeId) {
        $this->memeId = $memeId;
    }
}