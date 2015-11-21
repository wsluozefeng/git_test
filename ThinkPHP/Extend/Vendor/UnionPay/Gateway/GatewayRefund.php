<?php
/**
 * 网关支付方式 退款
 * Author: youxi
 * Date:   2015/10/15 18:52
 *  
 */

require_once 'GatewayBase.php';

/**
 * Class GatewayRefund
 * 交易步骤：
    1、 商户发起交易，商户组织退货交易报文，发送报文给全渠道系统；
    2、 全渠道系统完成商户的交易处理；
    3、 全渠道系统组织受理结果报文，返回给商户；
    4、 因退货交易涉及资金清算，全渠道系统发送后台通知（交易结果）给商户。 backUrl
 */

class GatewayRefund extends GatewayBase{

    public function refund( $origQryId ){

        $param = array(
            'version' => '5.0.0',		//版本号
            'encoding' => 'utf-8',		//编码方式
            'certId' => getSignCertId (),	//证书ID
            'signMethod' => '01',		//签名方法
            'txnType' => '04',		    //交易类型：退货
            'txnSubType' => '00',		//交易子类
            'bizType' => '000201',		//业务类型
            'accessType' => '0',		//接入类型
            'channelType' => '07',		//渠道类型
            'orderId' => date('YmdHis'),	//商户订单号，重新产生，不同于原消费
            'merId' => '777290058119902',	//====商户代码，请修改为自己的商户号
            'origQryId' => $origQryId,    //原消费的queryId(原交易查询流水号)，可以从查询接口或者通知接口中获取
            'txnTime' => date('YmdHis'),	//订单发送时间，重新产生，不同于原消费
            'txnAmt' => '1',              //=====交易金额，退货总金额需要小于等于原消费
            'backUrl' => $this->getBackUrl(),	   //后台通知地址
            'reqReserved' =>' 透传信息', //请求方保留域，透传字段，查询、通知、对账文件中均会原样出现
        );

        // 签名
        sign ( $param );

        $rel = sendHttpRequest ( $param, SDK_BACK_TRANS_URL );  //TODO 返回处理结果报文（非资金交易处理结果，资金交易处理由后台异步返回）

        return $rel;

    }

}