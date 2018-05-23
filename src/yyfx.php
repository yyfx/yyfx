<?php
namespace yyfx ;
use yyfx\component\Router;

require_once 'autoload.php';
require_once 'router.php';

class yyfx {
    private $configs = [];
    function set($key, $value) {
        $this->configs[$key] = $value;
        return $this;
    }

    function run() {
        component\Logging::SetConfig([], component\Application::Config('logging')['path']);

        ini_set("memory_limit","4096M");
        set_time_limit(300);
        if (isset($_SERVER['HTTP_DEBUG']) && $_SERVER['HTTP_DEBUG'] === '0') {
            ini_set('display_errors', false);
        }
        try {
            $router = new Router($this->configs['routeRule'], $this->configs['appNamespace']);
            $router->router($_SERVER['REQUEST_URI']);
            $err = error_get_last();
            if (!empty($err)) {
                component\Logging::Fatal($err);
            }

        } catch (Exception $err) {
            component\Logging::Fatal($err->getMessage());
        }
    }
}


