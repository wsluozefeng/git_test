<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/7/13
 * Time: 15:20
 *
 * 项目函数库，系统自动加载，必须以common命名
 */

function createOrderNo(){
    return rand(1000,9999).rand(100,999).rand(10000,99990);
}

function createPageToken( $uid, $action, $otherArgv = array() ){

    $code = '!@#$%^#$_12345634';
    $str  = $code.$uid.$action;
    if( is_array( $otherArgv ) && !empty( $otherArgv ) ){
        foreach( $otherArgv as $key => $val ){
            $str .= $val;
        }
    }
    return md5($str);
}

function comparePageToken( $uid, $action, $otherArgv = array(), $token ){
    $theToken = createPageToken( $uid, $action, $otherArgv );
    return ( $theToken == $token ) ? 1 : 0;

}
