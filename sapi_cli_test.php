<?php
/**
 * linux下使用cli方式的访问调试文件
 * Author: youxi
 * Date:   2015/11/20 9:49
 *
 */


/**
 * I/O流中的进程的
 * 输入流：php://stdin或者STDIN
 * 输出流：php://stdout或者STDOUT
 * STDIN和STDOUT类似句柄的原理，可以直接操作，不需在通过fopen打开
 */
/*$fp = fopen('php://stdin','r'); //如果需要循环输入，使用while条件即可
echo "请输入内容：\n";
echo fgets( $fp );*/

//todo 另一种方式：直接使用STDIN常量,该常量类似句柄作用，可直接操作
/*echo "请输入内容：\n";
echo fgets( STDIN );*/

echo "请输入内容：\n";
while( $fp = fopen( 'php://stdin', 'r' ) ){
    $input = fgets( $fp );
    if( $input != 1 ){
        echo $input;
        file_put_contents( "php://filter/write=string.toupper/resource=php://stdout", '---is stdout--' );  //todo 这里额外使用了I/O流中的过滤流来修饰进程的输出流

        file_put_contents( "php://output", '====is oupput====' );   //todo 在cli模式下，php://output流依旧可以使用，但是不建议使用

        stream_filter_append( STDOUT, 'string.tolower' );
        fwrite( STDOUT, '*****STDOUT*****' );

        echo "请输入内容：\n";
    }else{
        break;
    }

}

exit;


/**
 * 文件指针位移单位的调试
 */
$fp = fopen('/data/web/tmp/test.txt', 'r');

if( isset($argv[1]) && $argv[1] == 1 ){
    fseek($fp, "3"); //todo 这里的指针位移单位是字节：英文字母是一个字节，utf8下的中文是3个字节、gbk的是2个字节
}

echo fread( $fp, 6 );
exit;

