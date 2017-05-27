<?php
function filterEmoji($str){
    //去除emoji表情
    $str = preg_replace_callback(
        '/./u',
        function (array $match) {
            return strlen($match[0]) >= 4 ? '' : $match[0];
        },
        $str);

    //方法2
//        $str = json_encode($str);
//        $str = preg_replace("#(\\\ud[0-9a-f]{3})#ie","",$str);
//        $str = json_decode($str);

    //去除中英文标点符号
    $str=urlencode($str);//将关键字编码
    $str=preg_replace("/(%7E|%60|%21|%40|%23|%24|%25|%5E|%26|%27|%2A|%28|%29|%2B|%7C|%5C|%3D|\-|_|%5B|%5D|%7D|%7B|%3B|%22|%3A|%3F|%3E|%3C|%2C|\.|%2F|%A3%BF|%A1%B7|%A1%B6|%A1%A2|%A1%A3|%A3%AC|%7D|%A1%B0|%A3%BA|%A3%BB|%A1%AE|%A1%AF|%A1%B1|%A3%FC|%A3%BD|%A1%AA|%A3%A9|%A3%A8|%A1%AD|%A3%A4|%A1%A4|%A3%A1|%E3%80%82|%EF%BC%81|%EF%BC%8C|%EF%BC%9B|%EF%BC%9F|%EF%BC%9A|%E3%80%81|%E2%80%A6%E2%80%A6|%E2%80%9D|%E2%80%9C|%E2%80%98|%E2%80%99)+/",'',$str);
    $str=urldecode($str);//将过滤后的关键字解码

    //去除空格
//        $str = trim($str);
//        $str = preg_replace('/s(?=s)/', '', $str);
//        $str = preg_replace('/[nrt]/', '', $str);

    $search = array("",""," ","　","","","\n","\r","\t");
    $replace = array("","","","","","","","","");
    $str = str_replace($search, $replace, $str);

    $str = preg_replace('/^[(\xc2\xa0)|\s]+/', '', $str);

    // str_replace(" ","",$str);

    return $str;
}
echo '<pre/>';
var_dump($_SERVER);