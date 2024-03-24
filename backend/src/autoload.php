<?php

function load($className){
    $className = str_replace("\\", "/", $className);
    $file = __DIR__ . "/$className.php";
    echo "loading $file\n";
    if (file_exists($file)) {
        require_once $file;
    }
}

spl_autoload_register('load');

