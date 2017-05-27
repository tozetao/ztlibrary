<?php
/*
求和函数
注意,rpc服务器在调用函数时,传的参数是这样的:
array(0=>'函数名' , 1=>array(实参1,实参2,...实参N) , 2=>NULL)
*/
function hello() {
	return 'hello';
}
function sum($method , $args , $extra) {
	return array_sum($args);
} 
// 创建RPC Server
$server = xmlrpc_server_create();

//注册自定义接口
xmlrpc_server_register_method ($server , 'hello' , 'hello');
xmlrpc_server_register_method ($server , 'sum' , 'sum');

// 收取请求，该$HTTP_RAW_POST_DATA接受了客户端的数据，内容是xml格式。
$request = $HTTP_RAW_POST_DATA;

// 执行调用客户端的XML请求后获取执行结果
$xmlrpc_response = xmlrpc_server_call_method($server, $request , null);

// 把函数处理后的结果XML进行输出
header('Content-Type: text/xml');
echo $xmlrpc_response;

// 销毁XML-RPC服务器端资源
xmlrpc_server_destroy($server);