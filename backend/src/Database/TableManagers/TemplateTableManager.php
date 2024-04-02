<?php

namespace Database\TableManagers;

use Database\DatabaseQuery;
use Models\Template;

class TemplateTableManager extends TableManager
{
    //--------get methods----------------
    // general get method
    /**
     * Get templates from database based on parameters given in $params preformatted as an associative array
     * @param array $params
     * @return Template[]
     */
    static public function getTemplate(array $params=[]): array{
        $queryObjects = DatabaseQuery::executeQuery("select","templates",[],$params);
        $templates = [];
        foreach ($queryObjects as $queryObject ) {
            $templates[] = new Template($queryObject['id'],
                                $queryObject['title'],
                                $queryObject['URL']);
        }
        return $templates;
    }

    // specific get methods
    /**
     * Get template from database based on id
     * @param int $id
     * @return Template|null
     */
    static public function getTemplateById(int $id): ?Template{
        if( $id>0) {
            $templates = self::getTemplate(["id" => $id]);
            if (!empty($templates)) {
                return $templates[0];
            }
        }
        return null;
    }
    /**
     * Get template from database based on URL
     * @param string $URL
     * @return Template|null
     */

    static public function getTemplateByURL(string $URL): ?Template{
        if( !empty($URL) ){
            $templates = self::getTemplate(["URL" => $URL]);
            if( !empty($templates) ){
                return $templates[0];
            }
        }

        return null;

    }
    /**
     * 
     * Get template from database based on title
     * @param string $title
     * @return Template|null
     * 
     */
    static public function getTemplateByTitle(string $title): ?array{
        if( empty($title) ){
            return null;
        }
        $templates = self::getTemplate(["title" => $title]);
        if(!empty($templates)){
            return $templates;
        }
        return null;

    }

    //--------verify existence methods----------------
    /**
     * Check if a template exists in the database based on the given id
     * @param int $id
     * @return bool
     */
    static public function templateExists(int $id): bool{
        return !empty( self::getTemplateById($id) ) ;
    }

    /**
     * Check if a template exists in the database based on the given URL
     * @param string $URL
     * @return bool
     */
    static public function templateExistsByURL(string $URL): bool{
        return !empty( self::getTemplateByURL($URL) ) ;
    }


    //--------add methods----------------
    /**
     * Add a template to the database with the given title and URL then return the new Template object
     * @param string $title
     * @param string $URL
     * @return Template|null
     */
    static public function addTemplate(string $title, string $URL): ?Template{

        if( empty($title) || empty($URL) || self::templateExistsByURL($URL) ){
            return null;
        }
        DatabaseQuery::executeQuery("insert","templates",["title" => $title, "URL" => $URL]);
        $id = DatabaseQuery::getLastInsertId();
        return new Template($id, $title, $URL);

    }


    //--------update methods----------------
    // general update method
    /**
     * Update templates in database based on parameters given in $params and $conditions preformatted as associative arrays
     * @param array $params
     * @param array $conditions
     * @return void
     */
    static public function updateTemplate(array $params = [] , array $conditions = []): void{
        if( !empty($params) && !empty($conditions) )
            DatabaseQuery::executeQuery("update","templates",$params,$conditions);

    }

    // specific update methods
    /**
     * Update template title in database based on id and title given as parameters
     * @param int $id
     * @param string $title
     * @return void
     */
    static public function updateTemplateTitle(int $id, string $title): void{
        if( empty($title) || $id<1){
            return;
        }
        self::updateTemplate(["title" => $title], ["id" => $id]);
    }
    /**
     * Update template URL in database based on id and URL given as parameters
     * @param int $id
     * @param string $URL
     * @return void
     */

    static public function updateTemplateURL(string $id, string $URL): void{
        if( empty($URL) || $id<1){
            return;
        }
        self::updateTemplate(["URL" => $URL], ["id" => $id]);
    }

    //--------delete methods----------------
    /**
     * Delete templates from database based id given as parameter
     * @param int $id 
     * @return void
     */
    static public function deleteTemplateById(int $id): void{
        if( $id<1 ){
            return;
        }
        DatabaseQuery::executeQuery("delete","templates",[],["id" => $id]);
    }
    /**
     * Delete templates from database based on URL given as parameter
     * @param string $URL
     * @return void
     */

    static public function deleteTemplateByURL(string $URL): void{
        if( empty($URL) ){
            return;
        }
        DatabaseQuery::executeQuery("delete","templates",[],["URL" => $URL]);
    }

    //--------retrieve method----------------
   /**
    * Retrieve template from database based on id
    * @param int $id
    * @return Template|null
    */
    public static function retrieve($id): ?Template
    {
        return self::getTemplateById($id);
    }


}