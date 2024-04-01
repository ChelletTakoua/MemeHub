<?php
namespace Models;
use Database\TableManagers\TextBlockTableManager;
use Utils\Proxy;
class Meme extends Model{
    private $template;
    private $custom_title;
    private $user;
    private $creation_date;
    private $nb_likes;
    private $result_img;

    public function __construct($id, $template_id, $custom_title, $user_id, $creation_date,$result_img) {
        parent::__construct($id);
        $this->template = new Proxy($template_id, 'Template');
        $this->custom_title = $custom_title;
        $this->user = new Proxy($user_id, 'User');
        $this->creation_date = $creation_date;
        $this->nb_likes = 0;
        $this->result_img = $result_img;
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

    public function getCustomTitle() {
        return $this->custom_title;
    }


    public function getCreationDate() {
        return $this->creation_date;
    }

    public function getNbLikes(): int
    {
        return $this->nb_likes;
    }
    public function getResultImg(){
        return $this->result_img;
    }
  

    /**
     * @return array {id: , template: , custom_title: , user: , creation_date: , nb_likes: }
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => parent::getId(),
            'template' => $this->template,
            'custom_title' => $this->custom_title,
            'user' => $this->user,
            'creation_date' => $this->creation_date,
            'nb_likes' => $this->nb_likes,
            'result_img' => $this->result_img
        ];
    }

    /**
     * get text blocks by id of meme
     * @return array
     */
    public function getTextBlocks():array{
        $textBlocks = [];
        if(TextBlockTableManager::textBlockExistsByMemeId(parent::getId())){
            return TextBlockTableManager::getTextBlockByMemeId(parent::getId());
        }
        else return [];
        
    }
}