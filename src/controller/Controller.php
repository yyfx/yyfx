<?php

namespace yyfx\controller;
use yyfx\component;

abstract class Controller
{
    public static function HttpCode($code=null) {
        $mapping = [
            100 => 'Continue',
            101 => 'Switching Protocols',
            102 => 'Processing',
            103 => 'Checkpoint',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            207 => 'Multi-Status',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => 'Switch Proxy',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            418 => 'I\'m a teapot',
            422 => 'Unprocessable Entity',
            423 => 'Locked',
            424 => 'Failed Dependency',
            425 => 'Unordered Collection',
            426 => 'Upgrade Required',
            449 => 'Retry With',
            450 => 'Blocked by Windows Parental Controls',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported',
            506 => 'Variant Also Negotiates',
            507 => 'Insufficient Storage',
            509 => 'Bandwidth Limit Exceeded',
            510 => 'Not Extended'
        ];

        if (empty($code)) {
            return $mapping;
        } else if (isset ($mapping[$code])){
            return $mapping[$code];
        } else {
            return null;
        }
    }


    protected $queryString = [];
    protected $payload = [];
    public $suburi='';
    
    function __construct($queryString=[], $payload='')
    {
        $this->payload = $payload;
        $this->queryString = $queryString;

        register_shutdown_function(function(){
            $e = error_get_last();
            if (!empty($e) && in_array($e['type'], [E_ERROR, E_COMPILE_ERROR, E_CORE_ERROR, E_PARSE])) {
                $this->sendResponse(['err_no'=>500, 'err_msg'=>$e['message']], 500);
                component\Logging::Fatal(implode($e));
            }
        });

        $this->init();

    }



    function init() {}

    function getQueryString($key, $default=null, $validater=null) {

        if (isset($this->queryString[$key]) ) {
            $val = $this->queryString[$key];
        } else {
            $val = $default;
        }

        if (is_callable($validater)) {
            if (!$validater($val)) {
                throw new \Exception('Not accept param for '. $key);
            }
        }

        return $val;
    }

    function sendResponse($data, $code=200, $contentType='application/json; charset=utf-8'){
        header ('HTTP/1.1 '. $code . ' '. self::HttpCode($code));
        header('content-type: '. $contentType);

        if (!empty($data)) {
//            var_dump($data);
            echo $this->_jsonFormat($data);
        }
        else {
            echo $this->_jsonFormat(array());
        }
    }

    function noContent() {
        header ('HTTP/1.1 204 No Content');
        exit();
    }

    function notAcceptableRequest() {
        header('HTTP/1.1 406 Not Acceptable Request');
        exit();
    }

    function created($body=[]) {
        header('HTTP/1.1 201 Created');
        echo json_encode($body);
        exit();
    }

    function notFound($body='') {
        header('HTTP/1.1 404 Not Found');
        if (empty($body)) {
            $body = [
                'err_code'=>404,
                'err_msg'=>'resource not exists'
            ];
        }
        exit($this->_jsonFormat($body));
    }


    /**
     * @param string|\Exception|array $body
     */
    function badRequest($body='') {
        header('HTTP/1.1 400 Bad Request');
        if (is_a($body, '\\Exception')) {

            $body = [
                'err_msg' => $body->getMessage(),
                'err_code'  => $body->getCode(),
            ];
        }
        if (is_string($body)) {
            $body = [
                'err_msg'=>$body,
                'err_code'=>400,
            ];
        }
        exit($this->_jsonFormat($body));
    }

    function _jsonFormat($data) {
        if (is_array($data)) {
            return json_encode($data, JSON_UNESCAPED_UNICODE);
        }
        return $data;
    }



    function get(){
        $this->notAcceptableRequest();
    }
    function post() {
        $this->notAcceptableRequest();
    }
    function put() {
        $this->notAcceptableRequest();
    }
    function delete() {
        $this->notAcceptableRequest();
    }

    function head() {
        $this->noContent();
    }

    function options() {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Max-Age: 86400");
        header("Access-Control-Allow-Methods: PUT,POST,GET,DELETE,OPTIONS");
    }

    function defaultRoute($data) {
//        $this->sendResponse($data);
    }

}