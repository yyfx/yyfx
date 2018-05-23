<?php

namespace yyfx\component;


class Application
{
    private static $_config = null;

    public static function Root() {
        return dirname(__DIR__);
    }

    public static function Config($name=null) {

        if (self::$_config === null) {
            self::$_config = parse_ini_file(dirname(self::Root()) . '/config.ini', true);
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