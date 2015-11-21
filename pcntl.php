<?php
/**
 * pcntl的多进程原理
 * Author: youxi
 * Date:   2015/11/3 10:42
 *  
 */


$sapi = php_sapi_name();
if( $sapi != 'cli' ){
    exit( 'this program should be done in cli' );
}

demo();

function demo( $nums = 3 ){
    for ($i=0; $i<$nums; ++$i){

        $pid = pcntl_fork();
        //todo 父进程通过该函数创建子进程，接着父进程和子进程都会并行执行下面的代码，执行区别是父进程的$pid=所创建的子进程的pid（也就是 $pid > 0 ），而子进程的$pid=0,而且父进程只有一个，就是当前执行该文件的进程
        //todo 此时该父进程会常驻在内存，而子进程进行责任分发执行，且在执行完毕后正常退出，被内核进行资源回收，释放内存

        if ($pid == -1){
            die ("cannot fork" );
        } else if ($pid > 0){
            $parentPid = posix_getpid(); //todo 获取当前进程的pid
            echo "父进程（pid为：{$parentPid}）挂起，等待其子进程执行.... \n\n";

            //$childPid  = pcntl_wait( $status, WUNTRACED );         //todo WUNTRACED 表示子进程已经退出并且其状态未报告时返回； WNOHANG 表示如果没有子进程退出立刻返回(该值的情况需要斟酌使用)
            $childPid  = pcntl_waitpid( $pid, $status, WUNTRACED );  //pcntl_waitpid的参选值情况参考手册

            if( pcntl_wifexited( $status ) ){  //pcntl_wifexited判断$status所代表的进程是否正常退出
                echo "父进程（{$parentPid}）的子进程（{$childPid}）结束操作****************","\n\n\n\n";
            }

            //exit (0);  //todo 父进程不能有退出，否则整个执行会终端

        } else if ($pid == 0){
            //todo 子进程操作
            $childPid = posix_getpid();
            echo "子进程（{$childPid}）开始执行","\n";
            for ($j=0; $j<3; ++$j){
                beep();
            }

            //在子进程（该子进程被视为父进程了）中创建子进程
           /* $thePid = pcntl_fork();
            if( $thePid > 0 ){
                $id = posix_getpid();
                echo "fu的pid为：{$id}等待执行-------------";
                $id2 = pcntl_waitpid($thePid, $status, WUNTRACED);
                if( pcntl_wifexited($status) ){
                    echo "父进程（{$id}）的子进程（{$id2}）结束操作啦啦啦啦啦啦啦啦啦啦啦啦啦啦","\n\n\n\n";
                }
            }else{
                $id3 = posix_getpid();
                echo "子进程（{$id3}）开始执行","\n";
                for ($j=0; $j<3; ++$j){
                    beep();
                }
            }*/

            exit (0);   //todo 子进程需要有退出，否则会进行递归多进程
        }
    }
}

function beep(){
    echo getmypid(), "\t" , date( 'Y-m-d H:i:s', time()), "\n" ;
    sleep(1);
}



