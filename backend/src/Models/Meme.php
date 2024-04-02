<?php
namespace Models;
use Authentication\Auth;
use Database\TableManagers\LikeTableManager;
use Database\TableManagers\TemplateTableManager;
use Database\TableManagers\TextBlockTableManager;
use Utils\Proxy;
class Meme extends Model{
    private $template;
    private $custom_title;
    private $user;
    private $creation_date;
    private $nb_likes;
    private $result_img;
    /**
     * Create a new instance of Meme
     * @param int $id
     * @param int $template_id
     * @param string $custom_title
     * @param int $user_id
     * @param string $creation_date
     * @param string $result_img
     * @param int $nb_likes
     */
    public function __construct($id, $template_id, $custom_title, $user_id, $creation_date,$result_img,$nb_likes) {
        parent::__construct($id);
        $this->template = new Proxy($template_id, 'Template');
        $this->custom_title = $custom_title;
        $this->user = new Proxy($user_id, 'User');
        $this->creation_date = $creation_date;
        $this->nb_likes = $nb_likes;
        $this->result_img = $result_img;
    }
    /**
     * get the user id
     * @return int
     */
    public function getUserId(){
        return $this->user->getId();
    }
    /**
     * get the template id
     * @return int
     */
    public function getTemplateId(){
        return $this->template->getId();
    }
    /**
     * get the user instance
     * @return user
     */
    public function getUser(){ 
        return $this->user->getInstance();
    }
    /**
     * get the template instance
     * @return template
     */
    public function getTemplate(){ 
        return $this->template->getInstance();
    }
    /**
     * get the custom title
     * @return string
     */
    public function getCustomTitle() {
        return $this->custom_title;
    }

    /**
     * get the creation date
     * @return string
     */
    public function getCreationDate() {
        return $this->creation_date;
    }
    /**
     * get the number of likes
     * @return int
     */
    public function getNbLikes()
    {
        return $this->nb_likes;
    }
    /**
     * get the result image
     * @return string
     */
    public function getResultImg(){
        return $this->result_img;
    }
  

    /**
     * @return array {id: , template: , custom_title: , user: , creation_date: , nb_likes:,result_img: }
     */
    public function jsonSerialize(): array
    {
        return [
            "id" => $this->getId(),
            "template" => $this->template,
            "user_id" => $this->getUserId(),
            "nb_likes" => $this->nb_likes,
            "liked" =>  LikeTableManager::likeExistsByMemeIdAndUserId($this->getId(), $this->getUserId()),
            "liked" => Auth::isLoggedIn() && LikeTableManager::likeExistsByMemeIdAndUserId($this->getId(), Auth::GetActiveUserId()),
            "creation_date" => $this->getCreationDate(),
            "text_blocks" => TextBlockTableManager::getTextBlockByMemeId($this->getId()),
            "result_img" => $this->getResultImg(),
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