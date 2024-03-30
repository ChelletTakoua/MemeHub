<?php
namespace Models;
use Utils\Proxy;
class Meme extends Model{
    private $template;
    private $custom_title;
    private $user;
    private $creation_date;
    private $nb_likes;

    public function __construct($id, $template_id, $custom_title, $user_id, $creation_date) {
        parent::__construct($id);
        $this->template = new Proxy($template_id, 'Template');
        $this->custom_title = $custom_title;
        $this->user = new Proxy($user_id, 'User');
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

    public function getcustom_title() {
        return $this->custom_title;
    }

    public function setcustom_title($custom_title) {
        $this->custom_title = $custom_title;
    }

    public function getCreationDate() {
        return $this->creation_date;
    }

    public function setCreationDate($creation_date) {
        $this->creation_date = $creation_date;
    }
    public function getNbLikes(): int
    {
        return $this->nb_likes;
    }
    public function setNbLikes($nb_likes) {
        $this->nb_likes = $nb_likes;
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
        ];
    }

    //get text blocks by id of meme
    public function getTextBlocks():array{
        $textBlocks = [];
        $textBlocksId=[];
        if(TextBlockTableManager::textBlockExistsByMemeId(parent::getId())){
            $textBlocks = TextBlockTableManager::getTextBlockByMemeId(parent::getId());
            foreach ($textBlocks as $textBlock) {
                $textBlocksId[] = $textBlock->getId();
            }
            return $textBlocksId;
        }
        else return [];
        
    }
}