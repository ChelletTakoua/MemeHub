<?php
namespace Models;
use Utils\Proxy;
class Like extends Model{
    private $meme;
    private $user;
    /**
     * Create a new instance of Like
     * @param int $id
     * @param int $meme_id
     * @param int $user_id
     */
    public function __construct($id, $meme_id, $user_id) {
        parent::__construct($id);
        $this->meme = new Proxy($meme_id, 'Meme');
        $this->user = new Proxy($user_id, 'User');
    }
    /**
     * get the user id
     * @return int
     */
    public function getUserId(){
        return $this->user->getId();
    }
    /**
     * get the meme id
     * @return int
     */
    public function getMemeId(){
        return $this->meme->getId();
    }
    /**
     * get the user instance
     * @return user
     */
    public function getUser(){ 
        return $this->user->getInstance();
    }
    /**
     * get the meme instance
     * @return meme
     */
    public function getMeme(){ 
        return $this->meme->getInstance();
    }
    /**
     * encode the like as json
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => parent::getId(),
            'meme' => $this->meme,
            'user' => $this->user,
        ];
    }
}