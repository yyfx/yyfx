<?php

$root = __DIR__;
require_once $root.'/autoload.php';
yyfx\component\Logging::SetConfig([], yyfx\component\Application::Config('logging')['path']);

ini_set('max_execution_time', 0);
ini_set("memory_limit","4096M");

function help(){
    return <<<END
Usage:
    php cli.php <module> [arg1] [arg2] [...argn]

END;
}

//try {
if ($argc<2){
    echo help();
    exit(1);
}

$module = '\\yyfx\\cli\\'.$argv[1];

$moduleObj = new $module();
$moduleObj->run(array_slice($argv,2));
