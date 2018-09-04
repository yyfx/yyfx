# db

数据库默认使用conf/config.ini中的数据库配置
数据库代码为 src/component/Db.php


## 常量
- FETCH_NONE 查询不需要返回结果
- FETCH_ALL 查询返回多行结果，以array形式呈现，每个array中的项目以dict形式呈现
- FETCH_ONE 查询返回单行结果，以dict形式呈现(field=>value)

## 方法
### GetDb()
静态函数，通过Db::GetDb()获得数据库操作单例
不需要手动实例化该类

### beginTransaction()
在当前数据库连接上启动事务

### commitTransaction()
在当前数据库连接上提交事务

### rollbackTransaction()
在当前数据库连接上回滚事务

### inTransaction()
返回是否在事务中

### query($sql, $fetch ,$params=[])
执行查询，其中$fetch为常量中表述的部分，返回查询结果 

### getLastInsertId()
获取最后INSERT的自增值


## 示例

```php
use \yyfx\yyfx\component\Db;

$db = Db::getDb();
$sql = "SELECT * FROM mytable WHERE id=:id";
$params = [
	':id' => 1
]
$result = $db->query($sql, Db::FETCH_ALL , $params);
var_dump($result);
```

