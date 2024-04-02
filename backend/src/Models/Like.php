<?php
namespace Models;
use Utils\Proxy;
class Like extends Model{
    private $meme;
    private $user;

    public function __construct($id, $meme_id, $user_id) {
        parent::__construct($id);
        $this->meme = new Proxy($meme_id, 'Meme');
        $this->user = new Proxy($user_id, 'User');
    }
    public function getUserId(){
        return $this->user->getId();
    }
    public function getMemeId(){
        return $this->meme->getId();
    }
    public function getUser(){ 
        return $this->user->getInstance();
    }
    public function getMeme(){ 
        return $this->meme->getInstance();
    }
    public function jsonSerialize(): array
    {
        return [
            'id' => parent::getId(),
            'meme' => $this->meme,
            'user' => $this->user,
        ];
    }
}