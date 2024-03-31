<?php
namespace Models;

class Template extends Model {
    private $url;
    private $title;
   

    public function __construct($id, $title, $url) {
        parent::__construct($id);
        $this->title = $title;
        $this->url = $url;
    }

    public function getUrl() {
        return $this->url;
    }

    public function getTitle() {
        return $this->title;
    }
    
    public function jsonSerialize()
    {
        return [
            'id' => parent::getId(),
            'url' => $this->url,
            'title' => $this->title,
        ];
    }
}