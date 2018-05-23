<?php

namespace yyfx\component;

class Redis
{
    /**
     * @var null|\Redis
     */
    private static $_instance = null;
    public static function GetRedis() {
        if (self::$_instance === null) {
            $redisConfig = Application::Config('redis');
            self::$_instance = new \Redis();
            self::$_instance->pconnect($redisConfig['host'], $redisConfig['port'], $redisConfig['timeout']);
        }

        return self::$_instance;
    }
}