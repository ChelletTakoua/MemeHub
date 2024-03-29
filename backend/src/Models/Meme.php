<?php
namespace Models;
use Utils\Proxy;
class Meme extends Model{
    private $template;
    private $title;
    private $user;
    private $creation_date;
    private $nb_likes;

    public function __construct($id, $template_id, $title, $user_id, $creation_date) {
        parent::__construct($id);
        $template = new Proxy($template_id, 'Template');
        $this->title = $title;
        $user = new Proxy($user_id, 'User');
        $this->creation_date = $creation_date;
        $this->nb_likes = 0;
    }
    public function getUserId(){
        return $this->user->getId();
    }
    public function getTemplateId(){
        return $this->template->getId();
    }
    public function getUser(){ 
        return $this->user->getInstance();
    }
    public function getTemplate(){ 
        return $this->template->getInstance();
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getCreationDate() {
        return $this->creation_date;
    }

    public function setCreationDate($creation_date) {
        $this->creation_date = $creation_date;
    }
    public function getNbLikes() {
        return $this->nb_likes;
    }
    public function setNbLikes($nb_likes) {
        $this->nb_likes = $nb_likes;
    }
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'template' => $this->template,
            'title' => $this->title,
            'user' => $this->user,
            'creation_date' => $this->creation_date,
            'nb_likes' => $this->nb_likes,
        ];
    }
}