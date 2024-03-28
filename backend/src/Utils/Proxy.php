<?php

namespace Utils;

use Database\ModelTableMapper;
use Models\User;

class Proxy
{

    private $className;
    private $id;
    private $instance;
    private $isLoaded = false;

    public function __construct($id, $className)
    {
        $this->id = $id;
        $this->className = $className;
    }


    private function retrieve()
    {

        $this->instance = $this->className::retrieve($this->id);
        $this->isLoaded = true;
    }
    public function getInstance()
    {
        if (!$this->isLoaded) {
            $this->retrieve();
        }
        return $this->instance;
    }
    public function getId()
    {
        return $this->id;
    }


}