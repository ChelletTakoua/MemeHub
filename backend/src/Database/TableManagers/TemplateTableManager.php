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
    static public function getTemplateById(int $id): ?Template{
        $templates = self::getTemplate(["id" => $id]);
        if(!empty($templates)){
            return $templates[0];
        }
        return null;
    }

    static public function getTemplateByURL(string $URL): ?Template{
        $templates = self::getTemplate(["URL" => $URL]);
        if(!empty($templates)){
            return $templates[0];
        }
        return null;
    }

    static public function getTemplateByTitle(string $title): ?array{
        $templates = self::getTemplate(["title" => $title]);
        if(!empty($templates)){
            return $templates;
        }
        return null;
    }

    //--------verify existence methods----------------
    static public function templateExists(int $id): bool{
        return !empty( self::getTemplateById($id) ) ;
    }

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
        if( self::getTemplateByURL($URL) != null ){
            return null;
        }
        $queryObject = DatabaseQuery::executeQuery("insert","templates",["title" => $title, "URL" => $URL]);
        $id = DatabaseQuery::getLastInsertId();
        return new Template($id, $title, $URL);
    }


    //--------update methods----------------
    // general update method
    static public function updateTemplate(array $params = [] , array $conditions = []): void{
        if( !empty($params) && !empty($conditions) )
            DatabaseQuery::executeQuery("update","templates",$params,$conditions);
    }

    // specific update methods
    static public function updateTemplateTitle(int $id, string $title): void{
        self::updateTemplate(["title" => $title], ["id" => $id]);
    }

    static public function updateTemplateURL(string $id, string $URL): void{
        self::updateTemplate(["URL" => $URL], ["id" => $id]);
    }

    //--------delete methods----------------
    static public function deleteTemplateById(int $id): void{
        DatabaseQuery::executeQuery("delete","templates",[],["id" => $id]);
    }

    static public function deleteTemplateByURL(string $URL): void{
        DatabaseQuery::executeQuery("delete","templates",[],["URL" => $URL]);
    }

    //--------save and retrieve methods----------------
    public function save($model)
    {
        echo "TemplateTableManager save method called";
    }

    public static function retrieve($id)
    {
        return self::getTemplateById($id);
    }


}