<?php

namespace yyfx\component;


class Application
{
    private static $_config = null;
    private static $_configPath = null;

    public static function Root() {
        return dirname(__DIR__);
    }

    public static function SetConfig($config) {
        self::$_configPath = $config;
    }

    public static function Config($name=null) {

        if (self::$_configPath === null) {
            self::$_config = parse_ini_file(dirname(self::Root()) . '/config.ini', true);
        } else {
            self::$_config = parse_ini_file(self::$_configPath, true);
        }


        if ($name===null) {
            return self::$_config;
        }

        if (isset(self::$_config[$name])) {
            return self::$_config[$name];
        } else {
            return null;
        }


    }
}