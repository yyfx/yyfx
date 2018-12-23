<?php
namespace yyfx ;
use yyfx\component\Router;

require_once 'autoload.php';
require_once 'router.php';

class yyfx {
    private $configPath = '';
    private $routeRule = [];
    private $appNamespace = '';
    private $appRoot = '';
    public static function App() {
        return new self();
    }
    private $configs = [];

    public function set($key, $value) {
        $this->configs[$key] = $value;
        return $this;
    }

    public function setAppNamespace($appNamespace) {
        $this->appNamespace = $appNamespace;
        return $this;
    }

    public function setRoute($route) {
        $this->routeRule = $route;
        return $this;
    }

    public function setConfigPath($configPath) {
        $this->configPath = $configPath;
        return $this;
    }

    public function setAppRoot($appRoot) {
        $this->appRoot = $appRoot;
        return $this;
    }

    public function run() {
        component\Application::SetConfig($this->configPath);
        component\Logging::SetConfig([], component\Application::Config('logging')['path']);

        ini_set("memory_limit","4096M");
        set_time_limit(300);
        if (isset($_SERVER['HTTP_DEBUG']) && $_SERVER['HTTP_DEBUG'] === '0') {
            ini_set('display_errors', false);
        }

        spl_autoload_register(function($className){
            $registredNamespace = $this->appNamespace;

            if (!preg_match("/^$registredNamespace/", $className)) {
                return;
            }


            $classPath = substr($className, strlen($registredNamespace) + 1);

            $classPath = str_replace('\\', DIRECTORY_SEPARATOR, $classPath);
            $classFile = $this->appRoot . DIRECTORY_SEPARATOR . $classPath . '.php';
            if (file_exists($classFile)) {
                include $classFile;
            } else {
                throw new \Exception("script file '$classFile' not found for loading class '$className'. ");
            }
        });

        try {
            $router = new Router($this->routeRule, $this->appNamespace);
            $router->router($_SERVER['REQUEST_URI']);
            $err = error_get_last();
            if (!empty($err)) {
                component\Logging::Fatal($err);
            }

        } catch (\Exception $err) {
            component\Logging::Fatal($err->getMessage());
        }
    }
}


