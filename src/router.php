<?php

namespace yyfx\component;
class Router {
    private $routeRule = [];
    private $appNamespace = null;

    function __construct($rule, $appNamespace)
    {
        $this->routeRule = $rule;
        $this->appNamespace = $appNamespace;
    }

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
    function router($uri) {
        $query = $this->getQueryString();
        $payload = file_get_contents('php://input');

        $router = $this->routeRule;

        foreach ($router as $u=>$classname) {
            if (preg_match('@'.$u.'@', $uri, $matches)) {
                $fullClassName = $this->appNamespace.'\\' . $classname;
                $inst = new $fullClassName($query, $payload);
                if (sizeof($matches)>1) {
                    $inst->suburi = $matches[1];
                }

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

        $inst = new \yyfx\controller\DefaultController($query, $payload);
        $inst->defaultRoute();
    }
}
