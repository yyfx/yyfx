# controller
**自定义的controller的namespace请设置为appName/controller (appName在index.php中指定)**  
**所有的controller都继承自yyfx\yyfx\controller\Controller类**  

## 自定义请求处理器（handler）
通过实现以下function，来处理的不同的HTTP Method请求
### function get()
HTTP GET 方法处理函数

### function post()
HTTP POST 方法处理函数

### function put()
HTTP PUT方法处理函数

### fucntion delete()
HTTP DELETE方法处理函数


**如请求未定义的function，则直接返回HTTP 406**
## 支持的类内变量($this)
### $suburi
uri中的子uri：在路由配置中，（）括起来的部分

### $payload
POST/PUT请求中，的请求实体

### $queryString
URI中？后的参数，以dict形式呈现

## 支持的类内方法
### sendResponse($message, $status=200, $contentType='application/json; charset=utf-8')
发送响应
对于其他类型的响应码，可直接修改status，无需手动触发header函数
对于json串会直接输出，对于array类型，会序列化成json后输出

### noContent()
发送204响应

### created($body=[])
发送201响应

### notFound($body='')
发送404响应

### badRequest($body='')
发送400响应。$body支持直接使用\Exception对象



## 示例（处理put请求，读取uri中的id，以及请求的body，并返回200响应）
```php
namespace myApp\controller;

class MyController exntends yyfx\yyfx\controller\Controller {
	function put(){
		$id = $this->suburi;
		$payload = json_decode($this->payload);
		$response = ['id'=>$id];
		$this->sendResponse($response);
	}
}

```
