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
            $textBlocks[] = new textBlock($queryObject['id'],
                $queryObject['text'],
                $queryObject['x'],
                $queryObject['y'],
                $queryObject['font_size'],
                $queryObject['meme_id']);
        }
        return $textBlocks;

    }

    // specific get methods
    /**
     * Get text block from database based on id
     * @param int $id
     * @return TextBlock|null
     */
    static public function getTextBlockById(int $id): ?TextBlock
    {
        if( $id>0){
            $textBlocks = self::getTextBlock(["id" => $id]);
            if(!empty($textBlocks)){
                return $textBlocks[0];
            }
        }
        return null;
    }
    /**
     * Get text block from database based on meme_id
     * @param int $meme_id
     * @return TextBlock[]
     */

    static public function getTextBlockByMemeId(int $meme_id): ?array
    {
        if( $meme_id>0){
            $textBlocks = self::getTextBlock(["meme_id" => $meme_id]);
            if(!empty($textBlocks)){
                return $textBlocks;
            }
        }
        return [];
    }

    //--------verify existence methods----------------
    /**
     * Verify existence of text block in database based on id
     * @param int $id
     * @return bool
     */
    static public function textBlockExists(int $id): bool
    {
        return !empty(self::getTextBlockById($id)) ;
    }
    /**
     * Verify existence of text block in database based on meme_id
     * @param int $meme_id
     * @return bool
     */
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

        if(empty($text) || empty($font_size) || !is_numeric($x) || !is_numeric($y)){
            return null;
        }
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

        if( !empty($params) && !empty($conditions) && self::verifyExistenceById($conditions["id"]) ){
            DatabaseQuery::executeQuery("update", "text_blocks", $params, $conditions);
        }

    }

    // specific update methods
    /**
     * Update the text of the text block in database based on id
     * @param int $id
     * @param string $text
     * @return void
     */
    static public function updateTextBlockText(int $id, string $text){
        if(empty($text)){
            return;
        }
        self::updateTextBlock(["text" => $text], ["id" => $id]);
    }
    /**
     * Update the attribute X of the text block in database based on id
     * @param int $id
     * @param int $x
     * @return void
     */
    static public function updateTextBlockX(int $id, int $x){
        if(!is_numeric($x)){
            return;
        }
        self::updateTextBlock(["x" => $x], ["id" => $id]);
    }
    /**
     * Update the attribute Y of the text block in database based on id
     * @param int $id
     * @param int $y
     * @return void
     */

    static public function updateTextBlockY(int $id, int $y){
        if(!is_numeric($y)){
            return;
        }
        self::updateTextBlock(["y" => $y], ["id" => $id]);
    }
    /**
     * Update the attribute font_size of the text block in database based on id
     * @param int $id
     * @param string $font_size
     * @return void
     */

    static public function updateTextBlockFontSize(int $id, string $font_size){
        if(empty($font_size)){
            return;
        }
        self::updateTextBlock(["font_size" => $font_size], ["id" => $id]);
    }
    /**
     * Update the attributes X and Y of the text block in database based on id
     * @param int $id
     * @param int $x
     * @param int $y
     * @return void
     */

    static public function updateTextBlockXY(int $id, int $x, int $y){
        if(!is_numeric($x) || !is_numeric($y)){
            return;
        }
        self::updateTextBlock(["x" => $x, "y" => $y], ["id" => $id]);
    }


    //--------delete methods----------------
    /**
     * general delete method
     * Delete text blocks from database based on parameters given in $params preformatted as an associative array
     * @param array $params
     */
    static public function deleteTextBlock(array $params=[]){
        if (!empty($params))
            DatabaseQuery::executeQuery("delete","text_blocks",[],$params);
    }

    /**
     *specific delete methods
     * Delete text blocks from database based on id
     * @param int $id
     * @return void 
     * 
     */ 

    static public function deleteTextBlockById(int $id){
        if( !self::textBlockExists($id) ){
            return;
        }
        self::deleteTextBlock(["id" => $id]);
    }
    /**
     * Delete text blocks from database based on text
     * @param string $text
     * @return void
     */

    static public function deleteTextBlockByText(string $text){
        if(empty($text)){
            return;
        }
        self::deleteTextBlock(["text" => $text]);
    }
    /**
     * Delete text blocks from database based on meme_id
     * @param int $meme_id
     * @return void
     */
    static public function deleteTextBlockByMemeId(int $meme_id){
        self::deleteTextBlock(["meme_id" => $meme_id]);
    }

    //--------verify existence methods----------------
    /**
     * Verify existence of text block in database based on id
     * @param int $id
     * @return bool
     */

    private static function verifyExistenceById($id): bool
    {
        return (!empty (self::getTextBlockById($id)));
    }


    //--------retrieve methods----------------
    /**
     * Retrieve text block from database based on id
     * @param int $id
     * @return TextBlock|null
     */
    public static function retrieve($id): ?TextBlock
    {
        return self::getTextBlockById($id);
    }

}