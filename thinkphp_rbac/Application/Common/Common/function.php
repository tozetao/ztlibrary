<?php 

function p($data){
	echo '<pre>';
	print_r($data);
	echo '</pre>';
}

/**
 * 无限极分类
 * @param  [type] $data [description]
 * @param  string $pid  [description]
 * @return [type]       [description]
 */
function category($data,$pid='0'){
    $arr = array();
    foreach($data as $v){
        if($v['pid'] == $pid){
            $v['child'] = category($data,$v['id']);
            $arr[] = $v;    
        }
        
    }
    return $arr;
}

/**
 * 无限极分类
 * @param  [type]  $cate  [description]
 * @param  integer $pid   [description]
 * @param  integer $level [description]
 * @param  string  $html  [description]
 * @return [type]         [description]
 */
function sortOut($cate,$pid=0,$level=0,$html='--'){
    $tree = array();
    foreach($cate as $v){
        if($v['pid'] == $pid){
            $v['level'] = $level + 1;
            $v['html'] = str_repeat($html, $level);
            $tree[] = $v;
            $tree = array_merge($tree, sortOut($cate,$v['id'],$level+1,$html));
        }
    }
    return $tree;
}