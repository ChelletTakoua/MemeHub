<?php

namespace Database\TableManagers;

use Database\DatabaseQuery;
use Models\TextBlock;

class TextBlockTableManager extends TableManager
{
    //--------get methods----------------
    // general get method
    /**
     * Get text blocks from database based on parameters given in $params preformatted as an associative array
     * @param array $params
     * @return TextBlock[]
     */
    static public function getTextBlock(array $params=[]): array
    {
        $queryObjects = DatabaseQuery::executeQuery("select","text_blocks",[],$params);
        $textBlocks = [];
        foreach ($queryObjects as $queryObject ) {
            $textBlocksData= [
                "id"=>$queryObject['id'],
                "text"=>$queryObject['text'],
                "x"=> $queryObject['x'],
                "y"=>$queryObject['y'],
                "font_size"=>$queryObject['font_size'],];
            $textBlocks[] = $textBlocksData;
        }
        return $textBlocks;

    }

    // specific get methods
    static public function getTextBlockById(int $id): ?TextBlock
    {
        $textBlocks = self::getTextBlock(["id" => $id]);
        if(!empty($textBlocks)){
            return $textBlocks[0];
        }
        return null;
    }

    static public function getTextBlockByMemeId(int $meme_id): ?array
    {
        $textBlocks = self::getTextBlock(["meme_id" => $meme_id]);
        if(!empty($textBlocks)){
            return $textBlocks;
        }
        return [];
    }

    //--------verify existence methods----------------
    static public function textBlockExists(int $id): bool
    {
        return !empty(self::getTextBlockById($id)) ;
    }

    static public function textBlockExistsByMemeId(int $meme_id): bool
    {
        return !empty(self::getTextBlockByMemeId($meme_id)) ;
    }

    //--------add methods----------------
    /**
     * Add text block to database with parameters given as arguments
     * @param string $text
     * @param int $x
     * @param int $y
     * @param string $font_size
     * @param int $meme_id
     * @return TextBlock|null
     */
    static public function addTextBlock(string $text, int $x, int $y, string $font_size, int $meme_id): ?TextBlock
    {
        DatabaseQuery::executeQuery("insert", "text_blocks",
                                    ["text" => $text, "x" => $x, "y" => $y, "font_size" => $font_size , "meme_id" => $meme_id]);
        $id = DatabaseQuery::getLastInsertId();
        return self::getTextBlockById($id);
    }

    //--------update methods----------------
    // general update method
    /**
     * Update text blocks in database based on parameters given in $params and $conditions preformatted as associative arrays
     * @param array $params
     * @param array $conditions
     */
    static public function updateTextBlock(array $params=[], array $conditions=[]){
        if(!empty($params) && !empty($conditions)) {
            DatabaseQuery::executeQuery("update", "text_blocks", $params, $conditions);
        }
    }

    // specific update methods
    static public function updateTextBlockText(int $id, string $text){
        self::updateTextBlock(["text" => $text], ["id" => $id]);
    }
    static public function updateTextBlockX(int $id, int $x){
        self::updateTextBlock(["x" => $x], ["id" => $id]);
    }

    static public function updateTextBlockY(int $id, int $y){
        self::updateTextBlock(["y" => $y], ["id" => $id]);
    }

    static public function updateTextBlockFontSize(int $id, string $font_size){
        self::updateTextBlock(["font_size" => $font_size], ["id" => $id]);
    }

    static public function updateTextBlockXY(int $id, int $x, int $y){
        self::updateTextBlock(["x" => $x, "y" => $y], ["id" => $id]);
    }


    //--------delete methods----------------
    // general delete method
    /**
     * Delete text blocks from database based on parameters given in $params preformatted as an associative array
     * @param array $params
     */
    static public function deleteTextBlock(array $params=[]){
        if (!empty($params))
            DatabaseQuery::executeQuery("delete","text_blocks",[],$params);
    }

    // specific delete methods
    static public function deleteTextBlockById(int $id){
        self::deleteTextBlock(["id" => $id]);
    }

    static public function deleteTextBlockByText(string $text){
        self::deleteTextBlock(["text" => $text]);
    }
    static public function deleteTextBlockByMemeId(int $meme_id){
        self::deleteTextBlock(["meme_id" => $meme_id]);
    }

    //--------save and retrieve methods----------------

    public function save($model)
    {
        echo "TextBlockTableManager save method called";
    }

    public static function retrieve($id): ?TextBlock
    {
        return self::getTextBlockById($id);
    }

}