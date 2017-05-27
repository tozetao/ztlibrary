<?php
/*
web：http协议
远程管理：ssh
邮件协议：smtp

1. smtp
	simple mail transfer protocol
	简单邮件传输协议，它是一组用于由源地址到目的地址传送邮件的规则，由它来控制信件的中转方式。
	smtp协议属于tcp/ip协议族，它帮助每台计算机在发送或中转信件时找到下一个目的地。

	通过smtp协议所指定的服务器，就可以把e-mail邮寄到指定人的服务器上了，整个过程只需几分钟。
	smtp服务器则是遵循smtp协议的发送邮件服务器，用来发送或中转发出的电子邮件。

2. 发送方式
	1. 可以自己手动将数据以smtp协议的格式进行封装，发送给指定的邮箱服务器，由邮箱服务器转发。
	
	2. 默认例如：我们在126邮箱上面发送邮件，是126邮箱的服务器帮我们发送给邮件中转服务器，邮件中转服务器再帮我们转发到邮箱上面。

3. 命令
	nslookup
	example：
		名词：163.com
		address：123.58.180.8
				 123.58.180.7
	这个叫做a记录，该命令会显示dns服务器引导的ip主机地址。

	nslookup -q=mx 163.com
	查某个主机的邮箱服务器。

4. stmp
	smtp走的是25端口，email服务器使用的端口是：25

	telnet 	主机地址 端口号
	
	helo name
	mail from:(obama@whitehouse.gov)
	rcpt to:(tozetao@163.com)
	data 输入该命令后，写入主题内容
	subject: for the peatce of ther wwrld
	to: my dear
	from: goodman

	welcome to usa,
	.


	------------------
	helo obama		#该命令表示和邮件服务器打声招呼

	mail from:<>	#邮件来自哪里
	rcpt to:<>		#发送到哪里
	mail和rcpt表示信封的信息。

	data

	subject: for the peatce of the world
	to: my dear
	from: goodman
	这部分叫做信头，是信内的头部信息。

			1、使用telnet连接smtp服务器
			2、发送一个helo或者ehlo指令
			3、验证用户（使用邮件名登陆）
			4、使用mail命令准备发送邮件
			5、使用rcpt命令指定对方邮箱地址
			6、使用data命令开始输入内容
			7、输入test或者hello world类似字样（即邮件内容）
			8、输入邮件内容结束标志.
			9、退出smtp服务器

5. esmtp协议
	e表示extension扩展的smtp协议
	使用这个协议发送服务不能匿名，必须经过账号认证。

	在helo命令后面，增加权限验证功能
			auth login
			客户端：用户名
			客户端：密码
			注意：用户名和密码必须是用base64加密过的。
	emial from:xxx
	rcpt to:xxx

	
	刚才上面的是直投

区别：邮箱服务器和邮箱中转服务器

7. smtp.163.com
	往邮箱服务器
------------------------------------------------上面是使用telnect来发送邮件：直通和转投








直投：直接投递到指定邮件服务器
转投：由邮件中转服务器(也就是我们登陆邮箱的服务器)，将邮件发送到指定的邮件服务器


 */

//php发送邮件
/*
	mail()
		通过smtp协议与服务器交互，并投邮件，mail()函数只能直投，不支持esmtp协议。
	
	说明：
		该函数只能直投至最终的收件服务器地址，这个地址是在php.ini中指定的。

	如果我们要用mail()函数往tozetao@163.com发信
	1. 需要查询163邮件服务器的最终地址。
	2. 把该地址写到php.ini地址中，SMTP = 
	


垃圾邮件的标识
	你的ip是否动态的，如果是动态的，表示私人用户，极易成为垃圾邮件。
	你的ip是否短期内发了大良邮件
	你的邮件是否含有 禁止关键字，例如 交友、发票
	各大的邮件商相互协议好，友一份白名单用于放行。

可以使用大公司的smtp邮件中转服务器帮我们发送，例如smtp.163.com。


//PHPMailer
	1. 发信方式
		win系统下的mail()
		linux下的qmail，sendmail
		利用smtp登陆到某个账户上发送

 */
/*
include('PHPMailer/PHPMailerAutoload.php');
include('PHPMailer/class.phpmailer.php');
$mailer = new PHPMailer();

$mailer->isSMTP();
//设置参数
$mailer->Host = 'smtp.126.com';
$mailer->SMTPAuth = true;
$mailer->Username = 'tozetao';
$mailer->Password = 'woshishei';

//设置内容
$mailer->From = 'tozetao@126.com';
$mailer->FromName = 'tozetao';
$mailer->Subject = '我来自广东省，你要买少平么';
$mailer->Body = 'thsi ms  yfdsjfkj ldsfjlskdjfkls sdlkjfklsdjfklsdf';

$mailer->AddAddress('473464608@qq.com','zetao');	//收信人
$mailer->AddCC('tozetao@126.com','伟大的农场主');	//抄送

//发信
$rs = $mailer->send();
var_dump($rs);

*/









/*
pop3协议
	该协议用于收取邮件，默认端口110.
	他的作用是收取邮件，常用命令。

	常用命令：
	user：用户名
	pass：密码
	stat：统计，返回邮件数量及所占总空间。

	top：邮件号 行号，查看邮件头。
		邮件从旧到新，从1 2 3，递增编号，例如：top 1 5，则是取第一封邮件的前邮件头信息的前5行。

	retr：邮件号 行号，查看主题。例如：retr 2 6，则是取第2封邮件的主题内容的前5行。同上，邮件是从旧到新。注意读到的数据可能是base64编码后的数字，如果是注意解码。

	dele：邮件号，加上删除标记 dele 1
	rset：邮件号 取消删除标记
	quit：退出


create table user(
	uid int primary key auto_increment,
	uname char(20) not null default '',
	pass char(32) not null default '',
	status tinyint not null default 0
)engine myisam charset utf8;

create table activecode(
	cid int primary key auto_increment,
	uname char(20) not null default '',
	code char(16) not null default '',
	expire int not null 0
)engine myisam charset utf8;

往用户邮箱发送这个链接：active.php?activecode=dsdfsdfdsf

激活邮件的实战应用
1. 

 */