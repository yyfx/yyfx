<?php

namespace yyfx\component;


class Logging
{
    private static $_config = [];
    private static $_output = '';
    private static $_level = '';
    public static function SetConfig($config, $output='') {
        self::$_config = $config;
//        self::$_output = $config['output'];
//        self::$_level = $config['level'];
        self::$_output = $output;
    }
    public static function Info($message) {
        $caller = debug_backtrace();
        self::_PrintLog($message, 'INFO', $caller);
    }

    public static function Warning($message) {
        $caller = debug_backtrace();
        self::_PrintLog($message, 'WARNING', $caller);
    }

    public static function Fatal($message) {
        $caller = debug_backtrace();
        self::_PrintLog($message, 'FATAL', $caller);
        exit();
    }

    public static function Trace($trace, $message) {
        $caller = debug_backtrace();
        $message = sprintf("%s [%s] [%s:%d] %s \n", 'TRACE', date('Y-m-d H:i:s'), $caller[0]['file'], $caller[0]['line'], $message);
        $message .= "\n" . $trace;
        file_put_contents(self::$_output.'.trace', $message, FILE_APPEND);
    }

    private static function _PrintLog($message, $level, $caller) {
        if (is_array($message) || is_object($message)) {
            $message = json_encode($message);
        }
        $message = sprintf("%s [%s] [%s:%d] %s \n", $level, date('Y-m-d H:i:s'), $caller[0]['file'], $caller[0]['line'], $message);
        file_put_contents(self::$_output, $message, FILE_APPEND);
    }
}