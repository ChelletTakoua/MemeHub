<?php
namespace Models;

class Template extends Model {
    private $url;
    private $title;
   
    /**
     * Create a new instance of Template
     * @param int $id
     * @param string $title
     * @param string $url
     */
    public function __construct($id, $title, $url) {
        parent::__construct($id);
        $this->title = $title;
        $this->url = $url;
    }
    /**
     * get the url of the template
     * @return string
     */

    public function getUrl() {
        return $this->url;
    }
    /**
     * get the title of the template
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }
    /**
     * encode the template as json
     * @return array
     */
    
    public function jsonSerialize(): array
    {
        return [
            'id' => parent::getId(),
            'url' => $this->url,
            'title' => $this->title,
        ];
    }
}