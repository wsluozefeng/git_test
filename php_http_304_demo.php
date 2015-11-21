<?php

/**
 * php实现http304状态
 * Author: youxi
 * Date:   2015/11/6 9:47
 *  
 */

//在f5刷新情况下无效，只在新开窗口下有作用

echo getmypid();
exit;

$cache_time = 0;
//header("Cache-Control: max-age=".$cache_time);
header("Cache-Control: no-store");
echo time();



/*$cache_time = 600;
header("Expires: ".gmdate("D, d M Y H:i:s", time()+$cache_time )." GMT");
echo time();*/


//在f5刷新情况下，通过Last-Modified的值来实现304状态，减少http请求返回的内容，提速
/*$cache_time    = 120;
$modified_time = @$_SERVER['HTTP_IF_MODIFIED_SINCE'];

if( strtotime($modified_time)+$cache_time > time() ){  //如果还没过期
    header("HTTP/1.1 304");
    exit;
}

header("Last-Modified: ".gmdate("D, d M Y H:i:s", time() )." GMT");  //todo 第一次访问后，响应报文中就会有Last-Modified:******, 第二次访问时候$_SERVER中就存在HTTP_IF_MODIFIED_SINCE元素，该值等于Last-Modified的值，虽然设置了Last-Modified，但是请求还是会请求到服务器
echo time();*/

