<?php
namespace Models;
use Utils\Proxy;
class Meme extends Model{
    private $template;
    private $title;
    private $user;
    private $creationDate;
    private $nbLikes;

    public function __construct($id, $template, $title, $user, $creationDate) {
        $this->id = $id;
        $templateId = new Proxy($template_id, 'Template');
        $this->title = $title;
        $userId = new Proxy($user_id, 'User');
        $this->creationDate = $creationDate;
        $this->nbLikes = 0;
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
        return $this->creationDate;
    }

    public function setCreationDate($creationDate) {
        $this->creationDate = $creationDate;
    }
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'template' => $this->template,
            'title' => $this->title,
            'user' => $this->user,
            'dateCreation' => $this->dateCreation,
            'nbLikes' => $this->nbLikes,
        ];
    }
}