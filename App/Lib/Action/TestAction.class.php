<?php
/**
 *
 * Author: youxi
 * Date:   2015/10/29 14:04
 *  
 */

class TestAction extends Action{

    public function stream_context_create_demo_callback(){


        $xmlstr   = file_get_contents("php://input");
        print_r($xmlstr);exit;
        $filename = "/data/web/".time().'.png';
        if(file_put_contents($filename,$xmlstr))
        {
            echo 'success';
        }
        else
        {
            echo 'failed';
        }



        /*echo "post数组：<br />";
        print_r($_POST);
        //TODO post通过http的实体body的传递参数的，而仅当http的Content-Type为application/x-www-form-urlencoded或者multipart/form-data时候php才会把实体body中的参数写入$_POST数组中并且也会做相应的处理，例如变量空格会被处理成下划线

        echo "<br />php://input流：<br />";
        echo file_get_contents( 'php://input' );
        //TODO php://input则除开Content-Type为multipart/form-data的时候，永远都会与实体的值一致，且不会记录get过来的数值，与$HTTP_RAW_POST_DATA一样，但是$HTTP_RAW_POST_DATA需要php.ini中的配置always_populate_raw_post_data值为On

        echo "<br />get数组：<br />";
        print_r($_GET);*/

        exit;
    }

    /**
     * 创建影响访问上下文的http流：stream_context_create()
     * I/O流中的输入流 php://input
     */
    public function stream_context_create_demo(){

        $url = "http://www.tp.com/index.php/Test/stream_context_create_demo_callback";

        //$postData = 'is me=2&laibai=>kong';
        $postData = file_get_contents('/data/web/dock.png');
        $option = array(
            'http' => array(
                'method'  => 'POST',
                'header'  => "Content-type:application/x-www-form-urlencoded\r\n" . "Content-Length:".strlen( $postData )."\r\n" . "Cookie:name=123\r\n",
                'content' => $postData,
            ),
        );

        $context = stream_context_create( $option );  //todo 创建影响上下文的http流

        //$con = file_get_contents( $url, false, $context );  //加了http流的情况下，访问的连接需要是动态脚本？？？ 待解决，目前调试的是这样
        //$con = file_get_contents( $url );
        //var_dump($con);

        //方式二：通过句柄和fpassthru函数输出内容
        $fp = fopen( $url, 'r', false, $context );  //todo test.php文件中$_POST数组和php://input流都有数据
        fpassthru( $fp );  //todo 输出”当前指针所在位置之后“ 的内容
        fclose($fp);

        //print_r($http_response_header);
        exit;

    }

    /**
     * I/O流中的输出流 php://outer
     */
    public function php_outer_io_demo(){
        file_put_contents( "php://output", time() );  //todo php://outer流是一个只写的，和echo、print等相似，将内容写入到输出缓冲区，这个例子等同于 echo time();
        exit;
    }

    /**
     * I/O流中的过滤流 php://filter
     */
    public function php_filter_io_demo(){

        //todo php中的输出缓冲区：进程中的echo、print等内容的输出其实都是先将内容写入输出缓冲区，等待进程执行完毕后强制输出该缓冲区内容
        //todo 读取文件时候将内容通过过滤流处理，resource=选项必须在最末尾处,多个过滤流规则使用"|"来隔开，下面例子是将输出的内容大写话和rot13编码加密
        ob_start();
        readfile( 'php://filter/read=string.toupper|string.rot13/resource=/data/web/tmp/test.txt' );  //readfile函数直接将内容写入输出缓冲区，开启缓冲区控制函数ob_start禁止所有缓冲输出，为了捕捉当前的文件内容
        $con = ob_get_contents();
        ob_end_clean();
        echo str_rot13( $con );  //string.rot13加密的内容，可用str_rot13函数解密

        exit;
        //todo 写入文件的内容通过过滤流进行处理
        $a = file_put_contents( 'php://filter/write=string.toupper/resource=/data/web/tmp/test.txt', '***--come on' );

        //todo 另一种方式：通过句柄和stream_filter_append函数添加过滤规则，无论是读写都会经过规则处理
        $fp = fopen( '/data/web/tmp/test.txt', 'w+' );
        stream_filter_append( $fp, 'string.toupper' );
        $a = fwrite( $fp, 'gogogo' );

        var_dump($a);
        exit;
    }

    /**
     * 获取访问的响应头
     */
    public function get_headers_demo(){
        $url = 'http://www.tp.com';
        $tmp = get_headers( $url );
        print_r($tmp);
        //$http_response_header须在访问了url后才被赋值，例如curl、file_get_contents等
        print_r($http_response_header);

        exit;
    }

    public function test(){

        ignore_user_abort(true);
        set_time_limit(0);

        sleep(5);
        $name = !$_REQUEST['name'] ? "******" : $_REQUEST['name'];
        //$age  = $_REQUEST['age'];
        exec( "echo 'name is ".$name."' >> /tmp/test.txt" );
        echo "-*-*-*-*";
        exit;

        //echo __FILE__;exit;
        /*$uid = posix_getuid();
        $info = posix_getpwuid( $uid );  //根据用户id获取用户数据，posix_getpwnam通过用户名获取用户数据
        $info = posix_times();      //获取当前进程所在cup的使用情况
        $info = posix_uname();  //获取系统的相关信息：名称、版本、内核等
        echo posix_getgid();
        echo posix_getegid();
        var_dump($info);
        exit;


        $id = getmypid();
        exec("ps -ef | grep ".$id, $result);
        print_r($result);
        echo get_current_user();
        echo posix_getpid();
        exit;*/
        //$this->display();
    }

    public function fsockopen_demo(){

        $url = "http://www.tp.com/index.php?m=Test&a=test&name=yeah".date('Y-m-d H:i:s');

        $info  = parse_url($url);
        $fp    = fsockopen($info["host"], 80, $errno, $errstr, 3);
        if( !$fp ){
            die('fsockopen is failed');
        }

        stream_set_blocking( $fp,0 );
        $head  = "GET ".$info['path']."?".$info["query"]." HTTP/1.1\r\n";
        $head .= "Host: ".$info['host']."\r\n";
        $head .= "Connection: Close\r\n\r\n";  //响应完就断开

        fwrite($fp, $head);

//        while (!feof($fp)){
//            $line = fread($fp,128);  //不关心输出
//            //echo $line;
//        }

        fclose($fp);

        echo "--------get is over-----";

        exit;
    }


    /**
     * 通过fastcgi_finish_request函数实现异步非阻塞
     */
    public function fastcgi_finish_request_demo(){
        echo '这会显示<br>';
        echo "处理该请求的php进程id是：".posix_getpid();
        //fastcgi模式下
        if( function_exists("fastcgi_finish_request") ){
            fastcgi_finish_request();  //todo fastcgi_finish_request后,客户端响应就已经结束,但与此同时服务端脚本却继续运行！
        }

        echo '这里不会输出------但是php当前进程仍旧在执行';
        $pid = posix_getpid();
        exec(" echo '=====fastcgi_finish_request=====".$pid."' >> /tmp/test.txt ");

        /*当然更科学的做法是：使用fastcgi_finish_request()函数集成队列消息，可以把消息异步发 送到队列。
        fastcgi_finish_reques()函数的缺点：
        1.PHP FastCGI 进程数有限，正在处理异步操作的php-cgi进程，无法处理新请求；
        2.如果并发访问量较大，php-cgi进程数用满，新访问请求，将没有php-cgi去处理。Nginx服务器会出现： 502 Bad Gateway。*/

        exit;
    }

    /**
     * 多进程pcntl扩展
     */
    public function pcntlFunction(){
        //todo 通过pcntl_XXX系列函数使用多进程功能。注意：pcntl_XXX只能运行在php CLI（命令行）环境下，在web服务器环境下，会出现无法预期的结果，请慎用！
        //todo 根目录下的pcntl.php和shouhu_process.php实现这部分逻辑
        //exec( '/usr/local/php/bin/php /data/web/thinkphp/pcntl_bak.php ' );  //即使用这种方式来实现在cli方式下执行多进程，在浏览器运行还是无法达到预期效果
    }


    /**
     * 执行外部命令（Linux中的shell命令）
     */
    public function linuxFunction(){

        //需要安装扩展
        /*for( $i = 0; $i<=3; $i++ ){
            $cmd = readline("input you cmd");
            readline_add_history( $cmd );
        }

        print_r( readline_list_history() );
        exit;*/


        exec("ps -ef | grep php-fpm | wc -l >> /tmp/php-fpm-worker.txt");
        exit;

        //执行linux命令的5个函数
        /*
         * 当你使用这些函数来执行系统命令时，可以使用escapeshellcmd()和escapeshellarg()函数阻止用户恶意在系统上执行命令，
         * escapeshellcmd()针对的是执行的系统命令，而escapeshellarg()针对的是执行系统命令的参数。
         * 这两个参数有点类似addslashes()的功能。
         * */

        $handle = popen( '/usr/local/php/bin/php /data/tmp/a.php >> /data/tmp/log.txt 2>&1', 'r' ); //todo  对于执行数据的操作,在r（只读模式）下，该进程句柄必须有输出操作才能执行，例如添加“>> /data/tmp/log.txt 2>&1” 或者 “fread( $handle, 5000 )”
        //fread( $handle, 5000 );
        //$handle = popen( '/usr/local/php/bin/php /data/tmp/a.php', 'w' );  //todo 若在“w”方式下则不需要
        fclose($handle);

        exit;

        $task = "ping -c 3 www.youxi.com";
        //$task = "cat /data/tmp/dock.png";

        $result = shell_exec( $task );  //执行命令，返回所有的输出结果
        var_dump($result);
        exit;

        header("Content-type:image/png");
        passthru( $task, $status );  //passthru 会直接将内容输出到浏览器，且其可以输出二进制，比如图像数据， 第二个参数是命令执行的状态，0表示执行成功，非0表示各种意义的错误
        exit;

        $result = system( $task, $status );  //区别于exec函数，它直接返回命令执行后的所有结果，第二个参数才是命令执行的状态，0表示执行成功，非0表示各种意义的错误
        var_dump($result);
        var_dump($status);
        exit;

        //$result = exec( $task );           //直接执行命令，只会将命令的最后一行输出作为结果返回
        //exec( 'pwd && ls -al', $result );  //如果需要将命令的所有输出都返回需要使用第二个参数（一个变量）来存储所有的输出, 该变量为数组，每一行输出为一个数组元素
        exec( $task, $result, $status );     //第三个参数，返回命令执行的状态，0表示执行成功，非0表示各种意义的错误

        var_dump( $result );
        var_dump( $status );
        exit;

    }

    /**
     * mysql的事务操作,采用单个事务的方式，而不是通过设置全局ATTR_AUTOCOMMIT=0的方式
     */
    public function mysqlShiwu(){

        // pdo的方式

        try{
            $pdo = new pdo("mysql:host=127.0.0.1;dbname=thinkphp", "root", ""/*, array(PDO::ATTR_AUTOCOMMIT=>0)*/);

        }catch(PDOException $e){
            echo "数据库连接失败：".$e->getMessage();
            exit;
        }

        $pdo->beginTransaction();//开启事务处理

        $num  = rand( 1,999 );
        $sql1 = "insert into ajia_order ( order_no, transaction_id ) VALUE ( 'is_test_1_order_no".$num."', 'is_test_1_transaction_id".$num."' )";
        $sql2 = "insert into ajia_order_good ( order_nog, good_id ) VALUE ( 'is_test_1_order_no".$num."', 'is_test_1_good_id".$num."' )";
        $status1 = $pdo->exec($sql1);
        $status2 = $pdo->exec($sql2);

        var_dump($status1);
        echo "<hr>";
        var_dump($status2);
        echo "<hr>";

        if( $status1 && $status2 ){
            $pdo->commit();
            echo '提交成功';
        } else{
            $pdo->rollBack();
            echo '回滚';
        }

        exit;



        //mysql的模式

        $con = mysql_connect( "127.0.0.1", "root", "" );
        if ( !$con ) {
            die( 'Could not connect: ' . mysql_error() );
        }
        mysql_select_db( "thinkphp", $con );

        mysql_query('BEGIN');  //step 1

        $num = rand( 1,999 );
        $sql1  = "insert into ajia_order ( order_no, transaction_id ) VALUE ( 'is_test_1_order_no".$num."', 'is_test_1_transaction_id".$num."' )";
        //$sql2 = "insert into ajia_order_good ( order_nog, good_id ) VALUE ( 'is_test_1_order_no".$num."', 'is_test_1_good_id".$num."' )";

        $sql2 = "insert into ajia.order_1 ( order_nog ) VALUE ( 'is_test_1_order_no".$num."' )";  //TODO 事务可夸 “同实例下的不同库”，因为其只针对sql语句

        $status1 = mysql_query($sql1);
        $status2 = mysql_query($sql2);

        var_dump($status1);
        echo "<hr>";
        var_dump($status2);
        echo "<hr>";

        if( $status1 && $status2 ){
            mysql_query('COMMIT');    //step 2
            echo '提交成功';
        }else{
            mysql_query('ROLLBACK');  //step 2
            echo '回滚';
        }

        mysql_query('END'); //step 3

    }

}