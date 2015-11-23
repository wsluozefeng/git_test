<?php
/**
 * linux下使用curl命令访问php的调试文件
 * Author: youxi
 * Date:   2015/11/20 9:49
 *  
 */


/**
 * 测试输入流php://input 与 $_POST
 */

print_r($_POST);

echo "<br>\n";

$tmp = file_get_contents( 'php://input' ); //todo POST 请求的情况下，最好使用 php://input 来代替 $HTTP_RAW_POST_DATA（原生的post数据），因为它不依赖于特定的 php.ini配置,内存消耗更少，但是enctype="multipart/form-data" 的时候 php://input 是无效的

print_r($tmp);

echo "<br>\n";

print_r($_GET);

echo "<br>\n";

exit;
