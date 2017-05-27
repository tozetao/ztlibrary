<?php
echo '<pre/>';
$matches = array();

// 1. 要求匹配010-45789654 或 0754-84435966
// $reg = '/0\d{2}-\d{8}|0\d{3}-\d{8}/';

// 2. 匹配一个ip地址


// 3. 匹配重复的字符
$reg = '/(.)\1*/';
$content = '22222abcdefg33333';
preg_match($reg, $content, $matches);
var_dump($matches);

// 4. 匹配重复的单词
$reg = '/\s?((\w+)\s?)\1*/';
$content = ' hello hello hello hello ';
preg_match($reg, $content, $matches);
var_dump($matches);

// 5. 匹配一个数字
$reg = '/\d+/';
if(preg_match($reg, '23')){
	echo 'matched', '<br/>';
}

// 6. 匹配数字、字符和下划线
$reg = '/\w+/';

// 7. url匹配
// http://www.baidu.com
$reg = '/^(http|https):\/\/(\w+\.){2}[a-zA-Z]+$/i';
$url = 'https://test.baidu.net';
preg_match($reg, $url, $matches);
var_dump($matches);

// 7. 邮箱匹配
// 456789@qq.com
$reg = '/\w+@/i';

// 8. 检测是否中文
$reg = '/[\x80-\xff]+/';	//匹配的应该是utf-8编码中的非ascii编码字符
// $reg = '@\p{Han}+@u';
$content = '你好';
preg_match($reg, $content, $matches);
var_dump($matches);

// 9. 匹配所有字符，包括单字节和多字节字符
$reg = '/[\w\W]+/';
$content = "he llo \n what is this!.中国";
preg_match($reg, $content, $matches);
var_dump($matches);

// 10. 匹配一个斜杠
$reg = '/[\/]+/';

$content = '<img src="./nav.jpg"/>';
preg_match($reg, $content, $matches);
var_dump($matches);

/// 11. 匹配标签的事件属性
$reg = '/on[A-Za-z]+=[\'\"][\w\W]*[\'\"]/';
$content = "<img src='./nav.jpg' onclick=\"console.log(1);\" onload='alert(1);'/>";
preg_match($reg, $content, $matches);
var_dump($matches);


// <img src='' alt=''/>
// onclick=''
// on[A-Za-z]+=[\'\"][\w\W]*[\'\"]


// 8. 手机匹配
// html匹配
// a标签匹配
// image标签匹配
// css样式匹配
// js脚本匹配
// 



//富文本编辑器的过滤：过滤js标签、过滤css代码、过滤黑名单html标签

/*
preg_match()
	使用正则表达式进行匹配




javascript正则表达式
	1. 正则对象的创建
		a. 隐式创建
			正则：var reg=/表达式/模式;

		b. 显示创建
			正则：var reg=new RegExp(正则表达式，模式);
	
		区别：
			使用第二种的话，由于正则表达式是写在字符串中的，必须对字符串进行转义，使用起来比较麻烦，建议使用第一种。
		example：
			var reg=/\d/gi;		//查找一个字符串是否含有数字
			var reg=new RegExp('\d','gi');
			var str='asd123456sdfd';
			alert(reg.test(str));
	
	2. 模式
		有三种模式。
		g：global，全局匹配。遍历字符串，把所有满足表达式结果的都匹配出来。
		i：ignore，在正则表达式中，表示忽略大小写。
		
	3. 转义字符
		所有的ASCII码都可以用'\'加数字来表示，
		在C语言中，定义了'\'+字母来表示那些不能显示的ASCII字符，如\t(制表符) \n(换行) ，这种字符串就称为转义字符串，这个转义字符并非是原本的ASCII字符，而是用于表示特殊字符的意思。

		alert('\n');//输出换行  \转义，表示n用于换行
		alert('\\n');//输出\n，可以认为不要转义
		在字符串中，对于\后的字符，程序是把其当作转义字符来看待的。

三、使用方式
	1. RegExp类
		test(str)：判断字符串中是否有指定模式匹配的字符或字符串，返回Boolbean。
		exec(str)： 返回指定模式的字符串。

	2. String 类
		search	  ： 返回指定模式的字符串所在位置，单匹配。
		match	  ： 返回指定模式的字符串，返回数组，多匹配。
		replace	  ： 返回指定模式替换后的字符串
		split		  ： 返回指定模式分割后的字符串，返回数组

 */