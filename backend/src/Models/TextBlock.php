<?php

namespace Models;
use Utils\Proxy;

class TextBlock extends Model{
    private $text;
    private $x;
    private $y;
    private $font_size;
    private $meme;

    public function __construct($id, $text, $x, $y, $font_size,$meme_id) {
        parent::__construct($id);
        $this->text = $text;
        $this->x = $x;
        $this->y = $y;
        $this->font_size = $font_size;
        $this->meme = new Proxy($meme_id, 'Meme');
    }


    public function getText() {
        return $this->text;
    }

    public function getX() {
        return $this->x;
    }


    public function getY() {
        return $this->y;
    }


    public function getFontSize() {
        return $this->font_size;
    }

    public function getMemeId(){
        return $this->meme->getId();
    }
    public function getMeme(){ 
        return $this->meme->getInstance();
    }
    public function jsonSerialize()
    {
        return [
            'id' => parent::getId(),
            'text' => $this->text,
            'x' => $this->x,
            'y' => $this->y,
            'font_size' => $this->font_size,
        ];
    }
}