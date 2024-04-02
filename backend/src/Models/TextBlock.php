<?php

namespace Models;
use Utils\Proxy;

class TextBlock extends Model{
    private $text;
    private $x;
    private $y;
    private $font_size;
    private $meme;
    /**
     * Create a new instance of TextBlock
     * @param int $id
     * @param string $text
     * @param int $x
     * @param int $y
     * @param int $font_size
     * @param int $meme_id
     */
    public function __construct($id, $text, $x, $y, $font_size,$meme_id) {
        parent::__construct($id);
        $this->text = $text;
        $this->x = $x;
        $this->y = $y;
        $this->font_size = $font_size;
        $this->meme = new Proxy($meme_id, 'Meme');
    }
    /**
     * get the text of the text block
     * @return string
     */


    public function getText() {
        return $this->text;
    }
    /**
     * get the x coordinate of the text block
     * @return int
     */

    public function getX() {
        return $this->x;
    }
    /**
     * get the y coordinate of the text block
     * @return int
     */
    public function getY() {
        return $this->y;
    }


    /**
     * get the font size of the text block
     * @return string
     */
    public function getFontSize() {
        return $this->font_size;
    }
    /**
     * get the meme id
     * @return int
     */
    public function getMemeId(){
        return $this->meme->getId();
    }
    /**
     * get the meme instance
     * @return meme
     */
    public function getMeme(){ 
        return $this->meme->getInstance();
    }
    /**
     * encode the text block as json
     * @return array
     */
    public function jsonSerialize(): array
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