<?php
function microtime_float(){
	list($usec, $sec) = explode(' ', microtime());
	return $sec + $usec;
}

set_time_limit(0);
$conn = mysql_connect('192.168.0.125', 'root', '');

mysql_query('use test', $conn);
mysql_query('set names utf8', $conn);

$str = 'abcdefghijklmnopqrstuvwxyz0123456789';
$str = $str .$str .$str .$str .$str .$str;

for($i=1; $i<=1000000; $i++){
	$sql = sprintf("insert into covert_i values('%s', %d, '%s', '%s', '%s')", 'hello' . $i, $i, $str, $str, $str);

	if(!mysql_query($sql)){
		echo $i, 'failure<br/>';
	}
}



// GRANT ALL PRIVILEGES ON *.* TO 'root'@'192.168.1.100' IDENTIFIED BY '' WITH GRANT OPTION;

// on *.*
// # 授予所有权限

// @192.168.1.100
// # 允许100ip地址链接，ip地址可以换成%，表示任意地址