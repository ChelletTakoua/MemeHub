<?php
namespace Models;

class Template extends Model {
    private $url;
    private $title;
   

    public function __construct($id, $url, $title) {
        $this->id = $id;
        $this->url = $url;
        $this->title = $title;
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
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'url' => $this->url,
            'title' => $this->title,
        ];
    }
}