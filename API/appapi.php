<?php
/*
1. APP接口
	一个app软件要开发的话，需要客户端开发工程师，主要负责界面的布局，并把数据填充到客户端。
	 而数据，则来自于app接口，也叫做通信接口。

	客户端加载的时候会发送一个http请求，我们把这个地址叫做接口地址，请求后接口会进行相应的处理，它会返回接口数据，然后客户端开发工程师就会解析这些数据，解析这些数据后填充到客户端。

	客户端工程师只关注接口地址和接口数据。

	定义
	 	app(通信)接口定义：
	 		必须要有一个接口地址：http://app.com/apiphp?
	 		必须要有对应的接口文件，用于处理一些业务逻辑
	 		返回接口数据，给客户端开发工程师用的。
	
	其实就是自己的服务器对外提供了一些web服务，并定义好了有哪些接口供人使用。

2. APP接口如何通信
	Client：APP客户端
		客户端发送http请求，调用服务器提供的接口，服务器端响应客户端并把数据按照一定格式返回。

	Server：服务器

	APP软件并不像B/S通信，APP软件的信息是xml显示的。

3. xml和json
	标记数据
	定义数据类型
	允许用户对自己的标记语言进行定义

	跨平台，格式统一，跨语言。

	xml的根节点只能有一个，标签必须有结束标签。
	
	json：不急少了

	区别：
		可读性：xml胜出

		数据的生成
			json方便
			xml比较麻烦
		传输速度：
			json传输速度更快，json数据小，xml容量要大于xml

4. app接口
	用于获取数据：从数据库或者缓存中获取数据，然后通过接口数据返回客户端。
	用于提交数据：通过接口提交数据给服务器，然后服务器入库处理，或者其他处理。

	app经常做的事情：
		更新app软件，app软件的更新，需要服务器端有一个版本升级的接口，版本升级接口，用到了获取数据和提交数据。

		页面展示：就是获取数据。

		意见反馈：就是提交数据

	web的更新：web更新只需要把最新的代码更新就可以了，

5. 封装通信接口数据方法
	5.1 json封装接口数据方法
		php生成json数据：json_encode()，只能接受UTF-8编码的数据，如果是其他格式会返回null。
		你想试验的话，可以把文件的编码格式转成其他编码，或者用iconv(原始编码，要转换的编码，字符串)将字符串转码。

		2. 通信数据的标准格式
			通信数据要有一个标准格式，否则乱套了，标准格式如下：
			code：状态码，200,400
			message：提示信息(报错或者成功等提示)
			data：封装成功后返回的数据。

	xml方式封装接口数据方法，PHP生成XML数据
		a. 字符串拼接
		b. DOMDocument对象
		c. XMLWrite
		d. SimpleXML
		第一种方法比较容易理解，也简单。

		xml节点不能是数组

	综合通信方式封装

 */

//json封装数据的方法
class Response{
	/**
	 * 返回json格式的数据
	 * @return mixed 成功返回json数据，失败返回false
	 */
	public static function json($code, $message='', $data=array()){
		if(!is_numeric($code)){
			return '';
		}
		$res = array(
			'code'=>$code,
			'message'=>$message,
			'data'=>$data
		);
		return json_encode($res);
	}
	//xml方式封装接口数据
	public static function xmlEncode($code, $message="", $data=array()){
		if(!is_numeric($code)){
			return '';
		}
		$result = array(
			'code'=>$code,
			'message'=>$message,
			'data'=>$data
		);
		header("Content-Type:text/xml");
		$xml = "<?xml version='1.0' encoding='UTF-8'?>";
		$xml .= "<root>";
		$xml .= self::buildXML($result);
		$xml .= "</root>";
		echo $xml;
	}

	private static function buildXML($data){
		$xml = $attr = '';
		foreach ($data as $key => $val) { 
			//键是数字，表明是索引数组，对于索引数组，将其转换成<item id='index'>number</item>
			if(is_numeric($key)){
				$attr = "id='$key'";
				$key = "item";
			}

			$xml .= "<$key {$attr}>";
			$xml .= is_array($val) ? self::buildXML($val) : $val;
			$xml .="</$key>";
		}
		return $xml;
	}
}
// header("Content-Type:text/html");	//能以文字直接显示xml文件，
$data = array(
	'id'=>'15',
	'name'=>'lisi',
	'numbers'=>array(1,2,3,4,25,'ahahah'),
);
// Response::xmlEncode(200,'success',$data);
$encodeArr = json_encode($data);
var_dump($encodeArr);
$dencodeArr = json_decode($encodeArr);
// var_dump($dencodeArr,true);
echo $dencodeArr->name;
