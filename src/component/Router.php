<?php
/**
 * Created by PhpStorm.
 * User: yaoyi03
 * Date: 2018/6/7
 * Time: 22:52
 */

namespace yyfx\component;

/**
 * router基类，需要实现具体的route方法(getController)来根据uri获取控制器
 * Class Router
 * @package yyfx\component
 */
abstract class Router
{
    public $name;
    public $uri;
    public $query;
    public $payload;



    function __construct()
    {
        $this->query = $this->getQueryString();
        $this->payload = file_get_contents('php://input');
        $this->uri = $_SERVER['SCRIPT_NAME'];
    }

    function init(){}

    /**
     * return Controller instance to route
     * @param $uri
     * @return mixed
     */
    public abstract function getController();


    function getQueryString() {
        $params = [];
        $query = explode('&', $_SERVER['QUERY_STRING']);
        if (empty($query)) {
            return [];
        }
        foreach ($query as $item) {

            $kv = explode('=', $item);
            if (sizeof($kv) == 2) {
                $params[$kv[0]] = $kv[1];
            } else {
                $params[$kv[0]] = $kv[0];
            }

        }
        return $params;
    }

    public function route() {
        $inst = $this->getController($this->uri);
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $inst->get();
                return;

            case 'POST':
                $inst->post();
                return;

            case 'PUT':
                $inst->put();
                return;

            case 'DELETE':
                $inst->delete();
                return;

            case 'OPTIONS':
                $inst->options();
                return;

            case 'HEAD':
                $inst->head();
                return;

            default:
                header ("HTTP/1.1 406 ". \yyfx\controller\Controller::HttpCode(406));
                return;
        }
    }
}