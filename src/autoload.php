<?php

spl_autoload_register(function($className){
    if (!preg_match('/^\\?yyfx\\/', $className)) {
        return;
    }
    $classPath = substr($className, 5);
    $classPath = str_replace('\\', DIRECTORY_SEPARATOR, $classPath);
    $classFile = __DIR__ . DIRECTORY_SEPARATOR . $classPath . '.php';

    if (file_exists($classFile)) {
        include $classFile;
    } else {
        throw new Exception("script file '$classFile' not found for loading class '$className'. ");
    }

});
require_once dirname(__DIR__).DIRECTORY_SEPARATOR.'vendor/autoload.php';