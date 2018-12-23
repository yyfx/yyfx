<?php

require_once 'yyfx.php';
$rule = [
    'index' => 'Index'
];
yyfx\yyfx::App()->set('appNamespace', 'myApp')->set('routeRule', $rule)->run();