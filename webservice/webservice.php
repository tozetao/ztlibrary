<?php
/*
webservice
1. 概念
	按一定的XML格式,调用远程服务器的方法,且服务器按一定的格式返回XML内容，这就是webservice。

	SOAP（ Simple Object Access Protocol ） 
		"一定的格式" ---- 简单对象访问协议是在分散或分布式的环境中交换信息的简单的协议,是一个基于XML的协议.
	
	简单的说，WERSERVICE就是数据交换的标准。
	总结: WebServie == HTTP协议 + Soap格式的XML	

2. php客户端调用
	2.1 soap模块
		修改php.ini配置，开启模块。
		extension=php_soap.dll 前的";"去掉，并重启apache。

	2.2 类调用
		header('Content-type:text/html;charset=utf8');
		$soap = new SoapClient('http://ws.webxml.com.cn/WebServices/WeatherWS.asmx?wsdl');

		var_dump($soap->__getFunctions());
		echo '<pre/>';
		var_dump($soap->getRegionDataset());

3. wsdl
	wsdl是webservice的规则说明书，详细描述了服务器所提供的服务，可调用的方法。
	客户端通过wsdl，才可了解能调用的方法及参数的细节。

	一个service可以定制多个port，每个port代表着一个 web 服务。
	每个port要定义可执行操作(operation)列表 并 定义每个端口的消息格式和协议细节。

	每个operation要定义输入和输出参数类型。
	
	3.1 关于传递和返回数组参数说明
		如果传递或返回的参数为数组,可以在message标签中做说明.
		<message name='testRequest'>
		<part name="term" type="xsd:ArrayOfString"/>
		</message>
		<message name='testResponse'>
		<part name="value" type="xsd:ArrayOfString"/>
		</message>

	说明：实例参见wdsl.xml文件。

4. 搭建WebService服务器
	demo详见：service.php、client.php、wsdl.xml3个文件。
	
5. XML-RPC调用
	XML-RPC可以理解为简化版的soap,对数据的包装相对简洁，也是用于调用远程服务器的数据。

	流程：
		a. 客户端请求远程服务器url，将请求的方法，参数封装成xml文件传递过去。
		b. 远程服务器端接受请求的xml数据，最后将数据封装成xml进行输出返回。
		c. 客户端处理远程服务器的数据。

	注：php.ini中,要打开extension=php_xmlrpc.dll

	个人感觉跟webservice最大不同之处是，客户端参数是以xml文件的形式传递的。

 */

