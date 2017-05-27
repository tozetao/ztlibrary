<?php
date_default_timezone_set('Asia/Shanghai');


// 格式化时间戳，可以格式化成：年、月、日、时间、星期
echo date('Y-m-d H:i:s', time());



// 格式化日期
echo mktime(0,0,0, 3, 28, 2017);	//格式化指定日期的事件
echo mktime(0,0,0, 3, 45, 2017);	//mktime会自动计算日期事件，超出的时候会自动递增
echo date('Y-m-d', mktime(0,0,0, 3, 0, 2017));	// 2-28，每个月的最后一天=下个月的第0天


// 文本转时间戳
// echo strtotime('-1 day');




// 案例
// 当前时间的前一天时间戳
echo mktime(0,0,0, date('m'), date('d')-1, date('Y'));

// 上个月的第一天
echo mktime(0,0,0, date('m'), 0, date('Y'));

// 当前月份的最后一天
echo mktime(0,0,0, date('m')+1, 0, date('Y'));