<?php
/**
 * Created by PhpStorm.
 * User: yaoyi03
 * Date: 2018/6/7
 * Time: 22:54
 */
namespace yyfx\component\router;

class RegexRouter extends \yyfx\component\Router
{
    private $routeRule = [];
    private $appNamespace = null;

    public function __construct($routeRule, $appNamespace)
    {
        parent::__construct();
        $this->routeRule = $routeRule;
        $this->appNamespace = $appNamespace;
    }


    /**
     * return Controller instance to route
     * @param $uri
     * @return mixed
     */
    public function getController()
    {
        $router = $this->routeRule;
        foreach ($router as $u=>$classname) {
            if (preg_match('@'.$u.'@', $this->uri, $matches)) {
                $fullClassName = $this->appNamespace.'\\' . $classname;
                $inst = new $fullClassName($this->query, $this->payload);
                if (sizeof($matches)>1) {
                    $inst->suburi = $matches[1];
                }
                return $inst;

            }

        }
        $inst = new \yyfx\controller\DefaultController($this->query, $this->payload);
        $inst->defaultRoute(['app'=>\yyfx\component\Application::Config()['app']['name']]);
        return $inst;
    }
}