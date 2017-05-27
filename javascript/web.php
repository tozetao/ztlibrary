<?php

//web应用	
//-------------

//1. 怎样用js、php区分出url各个部分
	/*
		完整的url：scheme://host:port/path?query#fragment
		scheme：协议；
		host：主机；
		port：端口；
		path：路径；
		query：查询
	 */
	
	//php parse_url()：该函数用于解析url
	// $url = 'http://www.oop.com?name=zhangsan';
	// $arrs = parse_url($url);
	// var_dump($arrs);

	//js的解析
	/*
		对于这样一个URL
		http://www.jb51.net:80/seo/?ver=1.0&id=6#imhere，我们可以用javascript获得其中的各个部分
		window.location.href
			整个URl字符串(在浏览器中就是完整的地址栏)

		window.location.protocol
			URL 的协议部分，本例返回值:http:

		window.location.host
			URL 的主机部分，本例返回值:www.jb51.net

		window.location.port
			URL 的端口部分，如果采用默认的80端口(update:即使添加了:80)，那么返回值并不是默认的80而是空字符，本例返回值:”"
		
		window.location.pathname
			URL 的路径部分(就是文件地址)，本例返回值:/seo/

		window.location.search
			查询(参数)部分，除了给动态语言赋值以外，我们同样可以给静态页面,并使用javascript来获得相信应的参数值，本例返回值:?ver=1.0&id=6
		
		window.location.hash
			锚点，本例返回值:#imhere
	 */
//2. 上传验证
	// 文件大小：$_FILES['size']
	// 文件后缀：$_FILES['name']，截取后缀进行判断。
	// 文件类型：$_FILES['type']
	// 文件合法性：$_FILES['error']

//3.php实现页面跳转
	// 设置相应头
	// header("Location: 网址"); 	//直接跳转
	// header("refresh:3;url=http://axgle.za.net");	//三秒后跳转
	// 输出一个meta标签
	//echo "<meta http-equiv=refresh content='0; url=网址'>"; 
