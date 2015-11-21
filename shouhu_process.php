<?php
/**
 * pcntl的多进程模拟守护进程, 思路可能存在问题，需要验证
 * Author: youxi
 * Date:   2015/11/4 14:10
 *  
 */

demo( 'doSomething' );

function doSomething( $param = array() ){
    exec( "echo '子进程pid为".$param['pid']."******' >> /tmp/test.txt" );
    exec( "ps -ef | grep ".$param['pid']." >> /tmp/test.txt  && echo '\n\n'  >> /tmp/test.txt " );
    sleep(2);
    exit;
}

function demo( $funName, $param = array(), $childProcessNum = 3 ){

    while( true ){
        $pid = pcntl_fork();

        if( $pid == -1 ){
            exec( "echo 'fork is failed!!!' >> /tmp/test.txt" );
            exit;
        }

        if( $pid > 0 ){
            static $num = 1;

            if( $num <= $childProcessNum ){
                $theId = posix_getpid();
                exec( "echo '".$num."====".$childProcessNum."' >> /tmp/test.txt" );\

                pcntl_waitpid( $pid, $status, WUNTRACED );
                exec( "echo 'master process(".$theId.") is doing  -v-' >> /tmp/test.txt" );
                $num++;

            }else{
                /*//如果不终端，该唯一的主父进程就会一直在内存中
                exec( "echo 'master process is ok +++++++++++' >> /tmp/test.txt" );
                exit;*/
                $num = 1;
            }
        }else{
            $childPid = posix_getpid();
            while(true){
                $funName( array( 'pid' => $childPid ) );
                //sleep(5);
            }
            exit(0);

        }
    }


}
