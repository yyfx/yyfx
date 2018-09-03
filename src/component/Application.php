<?php

namespace yyfx\component;


class Application
{
    private static $_config = null;
    private static $_root = '';

    public static function Root($dir=null) {
        if (is_null($dir)) {
            return self::$_root;
        }
        else {
            self::$_root = $dir;
        }

    }

    public static function Config($name=null) {
        if ($name===null) {
            return self::$_config;
        }

        if (isset(self::$_config[$name])) {
            return self::$_config[$name];
        } else {
            return null;
        }


    }

    public function __construct($projDir)
    {
        self::Root($projDir);
    }

    private $configs = [];
    /**
     * @var Router
     */
    private $router;
    public function set($key, $value) {
        $this->configs[$key] = $value;
        return $this;
    }

    public function get($key) {
        if (isset($this->configs[$key])) {
            return $this->configs[$key];
        } else {
            return null;
        }

    }

    public function setConfigFile($filename) {
        if (file_exists($filename)) {
            $this->configFile = $filename;
            self::$_config = parse_ini_file($filename, true);
            return $this;
        } else {
            throw new \Exception('config file not exists');
        }
    }

    /**
     * @param $router Router
     */
    public function setRouter($router) {
        $this->router = $router;
        return $this;
    }


    function run() {
        Logging::SetConfig([], Application::Config('logging')['path']);

        ini_set("memory_limit","4096M");
        set_time_limit(300);
        if (isset($_SERVER['HTTP_DEBUG']) && $_SERVER['HTTP_DEBUG'] === '0') {
            ini_set('display_errors', false);
        }
        try {
            $router = $this->router;
            $router->route();
            $err = error_get_last();
            if (!empty($err)) {
                Logging::Fatal($err);
            }

        } catch (Exception $err) {
            Logging::Fatal($err->getMessage());
        }
    }
}