<?php
namespace yyfx ;
use yyfx\component\Application;
require_once 'autoload.php';

class yyfx {
    public static function App($root, $namespace) {
        spl_autoload_register(function($classname) use ($root , $namespace){
            if (preg_match('/^'.$namespace.'\\\\/',$classname)) {
                $pureClassName = str_replace('\\','/',substr($classname,strlen($namespace)+1));
                $classFilename = $root.'/src/' .$pureClassName . '.php';
                require_once ($classFilename);
            }
        });
        return new Application($root);

    }
}


