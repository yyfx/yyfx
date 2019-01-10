# 新手入门

## 下载代码
```bash
git clone https://github.com/yyfx/yyfx.git
```

## 环境
框架依赖php5.4以上版本，推荐php7，由于需要使用mysql数据库，所以需要安装pdo-mysql包

## 运行
程序根目录下配置一个index.php用作所有接口的引导文件，关于index.php的写法可以参考index.demo.php

## 路由
index.php中可以配置路由信息，路由key是正则表达式，()中提取的内容，可以透传到controller中的$suburi中的变量，1.0版本，只支持透传1个变量
注意，路由按照先后顺序执行（chain式），建议将更细节的路由放在前面，避免上一个路由规则命中导致无法处理后续路由

## 项目配置
可以在conf目录中的config.ini写入配置
目前可参考如下配置：
```ini
[db]
host=127.0.0.1
port=3306
username=root
password=
database=test
charset=utf8

[logging]
path=/var/log/yyfx-app.log
level=debug

[redis]
host=127.0.0.1
port=6379
timeout=1

[php.ini]
display_errors=1

[es]
host=127.0.0.1:8200
```

## index.php示例
```php
<?php
require_once(__DIR__.'/vendor/autoload.php');

$routeRule = [
    '^/demo/?(\\w*)$'   => 'controller\\Demo',
];



yyfx\yyfx::App()
    ->setAppRoot(__DIR__)
    ->setConfigPath(__DIR__.'/config.ini')
    ->setAppNamespace('demo')
    ->setRoute($routeRule)
    ->run();

```
