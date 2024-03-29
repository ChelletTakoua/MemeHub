<?php

namespace Models;
use Utils\Proxy;

class TextBlock extends Model{
    private $text;
    private $x;
    private $y;
    private $fontSize;
    private $meme;

    public function __construct($id, $text, $x, $y, $fontSize,$meme_id) {
        $this->id = $id;
        $this->text = $text;
        $this->x = $x;
        $this->y = $y;
        $this->fontSize = $fontSize;
        $meme = new Proxy($meme_id, 'Meme');
    }


    public function getText() {
        return $this->text;
    }

    public function setText($text) {
        $this->text = $text;
    }

    public function getX() {
        return $this->x;
    }

    public function setX($x) {
        $this->x = $x;
    }

    public function getY() {
        return $this->y;
    }

    public function setY($y) {
        $this->y = $y;
    }

    public function getFontSize() {
        return $this->fontSize;
    }
    public function setFontSize($fontSize) {
        $this->fontSize = $fontSize;
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
            'id' => $this->id,
            'text' => $this->text,
            'x' => $this->x,
            'y' => $this->y,
            'fontSize' => $this->fontSize,
            'meme' => $this->meme,
        ];
    }
}