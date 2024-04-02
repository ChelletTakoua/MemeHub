<?php
/**
 * This file is used to autoload classes
 */
function load($className){
    $className = str_replace("\\", "/", $className);
    $file = __DIR__ . "/$className.php";
    //echo "loading $file\n";
    if (file_exists($file)) {
        //echo "start $file\n";
        require_once $file;
        //echo "end $file\n";
    }
}

spl_autoload_register('load');

