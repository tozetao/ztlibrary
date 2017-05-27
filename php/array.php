<?php
echo '<pre/>';

/*
	// null的判断
	$array = array();
	if(empty($array)) or if($array == null)

	// 入栈
	$array = array(1, 2, 3);
	$array[] = 24;
	array_push($array, 'hello');
	print_r($array);

	// 读取值
	$val = $array[0];
	echo $val;

	// 移除第一个单元
	$val = array_shift($array);
	echo $val;

	// 弹出最后一个单元，reset指针，reset数组长度
	$val = array_pop($array);
	echo $val;


	// 值的集合
	$array = [
		'name' => 'zhangsan',
		'age' => 25
	];
	$tempArray = array_values($array);
	print_r($tempArray);

	// 键的集合
	$array = [
		'name' => 'zhangsan',
		'age' => 25
	];
	$tempArray = array_keys($array);
	print_r($tempArray);


	// 查找
	$array = [
		'name' => 'zhangsan',
		'age' => 25
	];
	array_key_exists('name', $array);
	in_array('zhangsan', $array);

	$key = array_search(25, $array);
	print_r($key);


	// 合并
	$aArray = [1, 2, 3, 'name' => 'zhangsan'];
	$bArray = [1, 2, 3, 'name' => 'lisi'];
	$rArray = array_merge($aArray, $bArray);
	print_r($rArray);

	$unorderArr = [
		0 => 'a',
		2 => 'b',
		3 => 'c',
	];
	$orderArr = array_merge($unorderArr);
	print_r($orderArr);

	// 递归合并：相同键名的值将会合并成数组，这将递归下去
	$ar1 = array("color" => array("favorite" => "red", [1, 2, 3]), 5);
	$ar2 = array(10, "color" => array("favorite" => "green", "blue"));
	$result = array_merge_recursive($ar1, $ar2);
	print_r($result);
	

	// 拼接
	$str = implode(',', [1,2,3,4,5]);
	echo $str;


	// 切割一个数组来分组
	$array = [1, 3, 2, 3, 4, 5, 6, 7, 7, 19];
	$tmpArr = array_chunk($array, 3);
	print_r($tmpArr);


	// 获取多维数组指定键名值的集合
	$records = array(
	    array(
	        'id' => 2135,
	        'first_name' => 'John',
	        'last_name' => 'Doe',
	    ),
	    array(
	        'id' => 3245,
	        'first_name' => 'Sally',
	        'last_name' => 'Smith',
	    ),
	    array(
	        'id' => 5342,
	        'first_name' => 'Jane',
	        'last_name' => 'Jones',
	    ),
	    array(
	        'id' => 5623,
	        'first_name' => 'Peter',
	        'last_name' => 'Doe',
	    )
	);
	print_r(array_column($records, 'first_name'));
	print_r(array_column($records, 'first_name', 'id'));

	// 回调遍历
	// map能够以回调函数去遍历多个数组，filter是以回调函数单独遍历一个数组
	$nums = array_map(
		function($a, $b){
			return $a * $b;
		},
		[1,2,3,4],
		[1,2,3,4]
	);
	print_r($nums);

	$nums = array_filter([1, 2, 3, 4, 5, 6], function($element){
		return $element & 1;
	});
	print_r($nums);

	// 差集：待补齐
	$aArray = ['a' => 'green', 'b' => 'bronw', 'red'];
	$bArray = ['a' => 'green' , 'yellow', 'red'];

	print_r(array_diff($aArray, $bArray));
	print_r(array_diff_assoc($aArray, $bArray));// 键、值一起做差集的比较(包括数字索引)

	// 交集
	$aArray = ['a' => 'green', 'red', 'blue'];
	$bArray = ['a' => 'green' , 'red', 'red'];
	print_r(array_intersect($aArray, $bArray));
*/
	// 统计
	array_unique([1, 2, 3, 4, 1]);	//返回一个不重复值的数组
	array_count_values(['hell', 'hell', '1', '1', 'world']);	//统计相同值出现的次数

		// 排序
	sort(['a', 'b', 'c', 80]);	//值的排序
	ksort(['name' => 'zhangsan', 'age' => 25]);	//以键来排序

	// 指针操作