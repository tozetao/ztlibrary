<?php

//文件相关
//--------
//1. 内容输出
	//1.1 读取一行数据
		//example1：
			// $handle = fopen('file.txt','rb');
			// $str = fgets($handle);
			// echo $str;
		//example：
			// $handle = fopen('file.txt', 'rb');
			// $str = '';
			// while(false !== ($char = fgetc($handle))){
			// 	$str .= $char;
			// 	if($char == "\n"){
			// 		break;
			// 	}
			// }

		//example：读取一个中文
			//fgetc()一个字节一个字节读取，对于英文直接读取一个，中文看编码格式，utf8需要读取3次。
			// $handle = fopen('file.txt', 'rb');
			// $str = '';
			// $str .= fgetc($handle);
			// $str .= fgetc($handle);
			// $str .= fgetc($handle);
			
			// $str = fread($handle,3);	//读取指定字节的数据。
			// echo $str;

	//1.2 读取文件所有数据
		//example1：
			// $str = file_get_contents('./file.txt');
			// echo $str;

		//example2：
			// $resource = fopen('./file.txt', 'r');
			// $str = fread($resource,filesize('./file.txt'));
			// var_dump($str);

		//example3：
			// $handle = fopen('./file.txt', 'rb');
			// while(false !== ($str = fgetc($handle))){
			// 	//无法读取中文
			// 	echo $str,"\n";
			// }

//2. 内容写入
	//2.1 头部写入数据 =>  将数据读取出来，进行拼接，再写入。		

	//2.2 尾部写入数据
		// $str = '我是中文人。。。';
		// $rs = file_put_contents('file.txt', $str, FILE_APPEND);
		// echo $rs;
		
		// $str = "这些是测试数据\n";
		// //a模式打开，文件指针在尾部，如果是w模式打开，由于指针在文件首部，所以会覆盖数据。
		// $handle = fopen('file.txt', 'ab');
		// $rs = fwrite($handle, $str);
		// var_dump($rs);

	//2.3 写入一行数据 => 在数据写入的时候，附加当前系统的换行符即可。

//3. 文件操作
	//3.1 创建
		// $rs = fopen('create_file', 'w');
		// var_dump($rs);
	//3.2 删除
		// unlink('create_file');
	//3.3 拷贝
		// $rs = copy('file.txt', 'new_file.txt');
		// echo $rs;

//4. 打开一个网络资源并读取
	//example：
		// $contents = file_get_contents('http://www.baidu.com','rb');
		// echo $contents;

	//example：对PHP5及更高版本
		// $handle = fopen("http://www.baidu.com/", "rb");
		// $contents = stream_get_contents($handle);	//读取资源流全部缓冲数据
		// echo $contents;
		// fclose($handle);

	//example：php4版本
		// $handle = fopen("http://www.baidu.com/", "rb");
		// $str = '';
		// while (!feof($handle)) {
		// 	$str .= fread($handle,20);
		// }
		// echo $str;
		// fclose($handle);

		//Warning 当从任何不是普通本地文件读取时，例如在读取从远程文件或 popen() 以及 fsockopen() 返回的流时，读取会在一个包可用之后停止。这意味着应该如下例所示将数据收集起来合并成大块。 
		
	//example：fsockopen()用于建立一个连接
		// $handle = fsockopen('www.baidu.com',80,$errno,$errstr,5);
		// if(!$handle){
		// 	echo $errstr;
		// }else{
		// 	$str = fread($handle, 20);
		// 	var_dump($str);
		// }

//5. url加载操作
	//5.1 用php读取url中网页内容，将超链接存在url.txt中
	//思路：加载url内容 => 正则匹配 => 写入文件中
	function write_url(){
		$reg = "/href=(['\"])([^'\"]*)\\1/i";	//匹配a标签的链接
		$matches = array();
		$str = file_get_contents('http://www.baidu.com');

		if(preg_match_all($reg, $str, $matches)){
			$handle = fopen('urls.txt', 'wb');
			for ($i=0; $i < count($matches[2]); $i++) { 
				fwrite($handle, $matches[2][$i]."\n");
			}
			fclose($handle);
		}	
	}
	
	//5.2 抓取远程图片，你会使用什么函数
	//file_get_contents 或者 fopen()

	//5.3 连级目录
	function create_dir($pathname,$mode=0777){
		if(is_dir($pathname)){
			echo '该目录已经存在';
		}else{
			if(mkdir($pathname,$mode,true)){
				echo '目录创建成功';
			}else{
				echo '目录创建失败';
			}
		}
	}
	//5.4 遍历所有文件夹
	function my_scandir($dir){
		$list = array();
		if(is_dir($dir)){
			if($handle=opendir($dir)){
				while ($file = readdir($handle)!==false) {
					if($file=='.' || $file == '..'){
						continue;
					}
					if(is_dir($dir.'/'.$file)){
						$list[$file]=my_scandir($dir.'/'.$file);
					}else{
						$list[]=$file;
					}
				}
				closedir($handle);
				return $list;
			}
		}
		return false;
	}	

//6. 日期操作
	//1. 打印出前一天的操作
	// echo date('Y-m-d H:i:s',strtotime('-1 day')),"\n";
	// echo date('Y-m-d H:i:s',time()-3600*24);

	//2. 能打印出某个时间戳是星期几，是一个月中的第几天，1个月共多少天
	
	//3. 求两个日期的差数，例如2007-2-5 ~ 2007-3-6 的日期差数
	//思路：计算出俩个日期的时间戳，然后相减并除以一天的秒数，就能求出相差多少天
	function get_days1($date1, $date2){
		$time1 = strtotime($date1);
		$time2 = strtotime($date2);
		return ($time2-$time1)/86400;
	}

	function get_days2($date1, $date2){
		$temp1 = explode('-', $date1);
		// mktime(0,0,0,);
	}

	//4. 给定日期打印出上一个月最后一天
	//上个月最后一天 = 当前时间 - 当前时间月份的第几天
	function get_last_day($time){
		$days = date('j',$time);	//算出当前时间戳是当前月份的第几天
		return date('Y-d-m',strtotime("-{$days} day",$time));
	}
	//5. 求俩个时间点 相差多少
	$t = strtotime('2016-3-7 20:00:10')-strtotime('2016-3-7 20:00:00');

	//6. 求当前时间是当前内的多少分钟
	$limit = strtotime(date('Y-m-d',time()));	//求当前时间0点时间戳
	$t = time() - $limit;

//7. 函数
	// 7.1 empty()和isset()的区别
	// isset()函数用于检测变量是否被设置并且不是null。empty()检测变量是否是空的。
	// 7.2 
	// error_reporting();	该函数用于设置php的错误级别。以2进制的位来表示
	

// 8. 字符串处理
	//例如: http://www.sina.com.cn/abc/de/fg.php?id=1 需要取出 php 或 .php
	function getExt1($url){
		$arr = parse_url($url);
		/*
			["scheme"] => string(4) "http"
			["host"] => string(15) "www.sina.com.cn"
			["path"] => string(14) "/abc/de/fg.php"
			["query"] => string(4) "id=1"
		 */
		$filename = basename($arr['path']);
		// $ext = explode('.', $filename)[1];
		// echo $ext;
		$ext = substr($filename,strpos($filename, '.'));
		echo $ext;
	}

	function getExt2($url) {
		$url = basename($url);
		$pos1 = strpos($url,'.');
		$pos2 = strpos($url,'?');
		if(strstr($url,'?')){
			return substr($url,$pos1 + 1,$pos2-$pos1-1);
		}else{
			return substr($url,$pos1);
		}
	}
	//反转字符串
	 function getRev($str,$encoding='utf-8'){
        $result = '';
        $len = mb_strlen($str);
        for($i=$len-1; $i>=0; $i--){
            $result .= mb_substr($str,$i,1,$encoding);
        }
        return $result;
    }
    // $string = 'OK你是正确的Ole';
    // // echo getRev($string);
    // echo mb_strlen($string,'utf8');

    //strrev()：该函数能很好的将英文字符进行反转。

//4. 常用正则表达式


//9.
	// 9.1 
	// echo '<br/>';
	// echo $_SERVER["REMOTE_ADDR"];	//客户端ip地址
	// echo '<br/>';
	// echo $_SERVER["QUERY_STRING"];	//url中的query
	// echo '<br/>';
	// echo $_SERVER["DOCUMENT_ROOT"];	//文档根目录




/*
js
 */