<?php
/**
 * 网关支付方式 查询
 * Author: youxi
 * Date:   2015/10/15 18:19
 *  
 */
require_once "GatewayBase.php";

class GatewayQuery extends GatewayBase{

    public function query( $orderId, $txnTime ){

        $param = array(
            'version' => '5.0.0',		//版本号
            'encoding' => 'utf-8',		//编码方式
            'certId' => getSignCertId (),	//证书ID
            'signMethod' => '01',		//签名方法
            'txnType' => '00',		//交易类型
            'txnSubType' => '00',		//交易子类
            'bizType' => '000000',		//业务类型
            'accessType' => '0',		//接入类型
            'channelType' => '07',		//渠道类型
            'orderId' => '954681622541',	//请修改被查询的交易的订单号
            'merId' => '777290058119902',	//商户代码，请修改为自己的商户号
            'txnTime' => '20151015171607',	//请修改被查询的交易的订单发送时间
        );

        // 签名
        sign ( $param );

        // 发送信息到后台
        $data = sendHttpRequest ( $param, SDK_SINGLE_QUERY_URL );
        $rel  = coverStringToArray( $data );

        return $rel;
    }
}