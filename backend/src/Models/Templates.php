<?php
namespace Models;
class Templates {
    private $id;
    private $url;
    private $title;
    private $width;
    private $height;

    public function __construct($id, $url, $title, $width, $height) {
        $this->id = $id;
        $this->url = $url;
        $this->title = $title;
        $this->width = $width;
        $this->height = $height;
    }

    public function getId() {
        return $this->id;
    }

    public function setTemplateId($id) {
        $this->id = $id;
    }

    public function getUrl() {
        return $this->url;
    }

    public function setUrl($url) {
        $this->url = $url;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
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
}