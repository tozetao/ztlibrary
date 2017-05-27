<?php
/*
5. 算法
	用php或js写出二分法和快速排序
*/
	//1. 请3个数最大值
	function max_sum($a,$b,$c){
		return $a>$b? ($a>$c?$a:$c):($b>$c?:$b:$c);
	}

	/*
		把算法的计算公式记下来，就不会写错，也就是机器的比较过程。
	 */

	//2分查找，成功返回索引值
	function mid_sort($arr,$num){
		$start = 0;
		$end = count($arr)-1;	//7
		
		while($start<=$end){
			//求索引中间数，向下取整
			$mid = floor(($end+$start+1)/2);
			if($arr[$mid]>$num){
				$end = $mid - 1;
			}else if($arr[$mid]<$num){
				$start = $mid + 1;
			}else if($arr[$mid] == $num){
				return $mid;
			}
		}
		return false;
	}
	// 注意中间值的求取，起始坐标和结束坐标的计算，就不会犯错。
	// $arr = array(1,5,6,12,23,34,56,100,201);	
	// var_dump(mid_sort($arr,23));

	//快速排序
	function quick_sort($arr){
		$len=count($arr);
		//先判断数组长度
		if($len<=1){
			return $arr;
		}

		$base_num=$arr[0];	//选择第一个元素，作为标尺
		$left_arr=array();
		$right_arr=array();
		for($i=1;$i<$len;$i++){
			if($base_num>$arr[$i]){
				$left_arr[] = $arr[$i];
			}else{
				$right_arr[] = $arr[$i];
			}
		}
		//递归调用
		$left_arr = quick_sort($left_arr);	//8 10
		$right_arr = quick_sort($right_arr);	//
		//合并
		return array_merge($left_arr,array($base_num),$right_arr);
	}
	// $arr = array(1,43,54,62,21,66,32,78,36,76,39); 	//11个数字
	// echo '<pre/>';
	// var_dump(quick_sort($arr));

	//冒泡排序
	function pao_sort($arr){
		$len=count($arr);
		for($i=1;$i<$len;$i++){
			for($k=0;$k<$len-$i;$k++){
				echo $k;
				if($arr[$k]>$arr[$k+1]){
					$temp = $arr[$k];
					$arr[$k]=$arr[$k+1];
					$arr[$k+1]=$temp;
				}
			}
			echo "<br/>";
		}
		return $arr;
	}
	// $arr = array(1,43,54,62,21,66,32,78,36,76,39); 	//11个数字
	// var_dump(pao_sort($arr));

	function showdir($path)
	{
		if(!is_dir($path)) return false;
		$resource = opendir($pah);
		while ($file = readdir($resource)) {
			if($file == '.' || $file == '..')
				continue;
			$temp = $path . '/' . $file;
			echo $temp, '<br/>';
			if(is_dir($temp)){
				showdir($temp);
			}
		}
		closedir($resource);
	}