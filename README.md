# yyfx-php-mvc
a restful php mvc framework

## api参考
- [入门](docs/start.md)
- [controller](docs/api/controller.md)
- [model](docs/api/model.md)
- [数据库](docs/api/db.md)  

## 代码结构
├── composer.json  
├── composer.lock  
├── docs  
│   ├── api  
│   │   ├── controller.md  
│   │   ├── db.md  
│   │   └── model.md  
│   └── start.md  
├── README.md  
├── src  
│   ├── autoload.php  
│   ├── cli  
│   │   └── CliBase.php  
│   ├── cli.php  
│   ├── component  
│   │   ├── Application.php  
│   │   ├── DataAccessObject.php  
│   │   ├── Db.php  
│   │   ├── Logging.php  
│   │   ├── Redis.php  
│   │   ├── router  
│   │   │   └── RegexRouter.php  
│   │   └── Router.php  
│   ├── controller  
│   │   ├── Controller.php  
│   │   └── DefaultController.php  
│   ├── index.sample.php  
│   ├── router.php  
│   └── yyfx.php  
└── vendor  
    ├── autoload.php  
    └── composer  
        ├── autoload_classmap.php  
        ├── autoload_namespaces.php  
        ├── autoload_psr4.php  
        ├── autoload_real.php  
        ├── autoload_static.php  
        ├── ClassLoader.php  
        ├── installed.json  
        └── LICENSE  
