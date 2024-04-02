<?php

namespace Utils;

use Database\ModelTableMapper;
use DateTime;
use JsonSerializable;
use Models\Model;
use Models\User;
use Models\Template;
use Models\Like;
use Models\Meme;
use Models\TextBlock;
use Models\Report;
use Models\BlockedMeme;

class Proxy implements JsonSerializable
{

    private $className;
    private $id;
    private $instance;
    private $isLoaded = false;

    const MODEL_NAMESPACE = 'Models\\';
    public function __construct($id, $className)
    {
        $this->id = $id;
        $this->className = self::MODEL_NAMESPACE . $className;
    }

    private function retrieve()
    {
        $this->instance = $this->className::retrieve($this->id);
        if($this->instance == null){
            throw new \Exception("Instance of class $this->className with id $this->id not found");
        }
        $this->isLoaded = true;
    }

    /**
     * This method returns the instance of the class with the id given in the constructor
     * @param bool $force_reload if true, the instance will be reloaded from the database even if it was already loaded
     * @return Model the instance of the class
     */
    public function getInstance(bool $force_reload = false) : Model
    {
        if ($force_reload || !$this->isLoaded) {
            $this->retrieve();
        }
        return $this->instance;
    }

    public function getId()
    {
        return $this->id;
    }


    public function jsonSerialize()
    {
        return $this->getInstance()->jsonSerialize();
    }
}