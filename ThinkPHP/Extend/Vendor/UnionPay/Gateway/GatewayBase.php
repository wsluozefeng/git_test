<?php
/**
 * 网关支付方式基类
 * Author: youxi
 * Date:   2015/10/15 10:36
 *  
 */

require_once "Config.php";
require_once "log.class.php";
require_once "common.php";
require_once "secureUtil.php";
require_once "PublicEncrypte.php";
require_once "httpClient.php";

/**
 * Class GatewayBase
 * 交易索引号 origQryId
 *
 */

class GatewayBase{

    /**
     * 签名
     * @param array $param 参数
     * @return bool
     */
    public function sign( &$param ){
        sign( $param );
        return true;
    }

    /**
     * 获取签名证书ID
     * @return string
     */
    public function getSignCertId(){
        return getSignCertId();
    }

    /**
     * 获取前台通知地址
     * @return string
     */
    public function getFrontUrl(){
        return SDK_FRONT_NOTIFY_URL;
    }

    /**
     * 获取后台通知地址
     * @return string
     */
    public function getBackUrl(){
        return SDK_BACK_NOTIFY_URL;
    }

}