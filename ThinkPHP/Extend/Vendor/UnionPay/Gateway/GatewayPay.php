<?php
/**
 * 网关支付
 * Author: youxi
 * Date:   2015/10/15 10:33
 *  
 */

require_once "GatewayBase.php";

class GatewayPay extends GatewayBase{

    /**
     * 创建form表单
     * @param  array  $outTradeNo    参数
     * @return string
     * 交易步骤：
        1、持卡人选择商品进行支付；
        2、商户组织交易报文，通过浏览器发送给银联全渠道系统；
        3、持卡人在银联全渠道支付系统页面中输入相关交易信息；
        4、全渠道系统完成用户的交易处理；
        5、银联全渠道系统，组装交易结果报文，通过浏览器跳转回商户；（非资金类交易流程至此结束） frontUrl
        6、涉及"资金类"的成功交易，全渠道系统发送后台通知给商户； backUrl
        7、如果商户未收到交易结果，交易状态未知的情况下，应向全渠道系统发起交易状态查询，查询交易处理结果。若未收到后台通知(如3分钟后)，则可间隔（2的n次方秒）发起交易查询
     */
    public function createHtml( $outTradeNo  ){

        // 初始化日志
        $log = new PhpLog ( SDK_LOG_FILE_PATH, "PRC", SDK_LOG_LEVEL );
        $log->LogInfo ( "============处理前台请求开始===============" );

        // 初始化日志
        $param = array(
            'version'        => '5.0.0',                 //版本号
            'encoding'       => 'utf-8',                 //编码方式
            'certId'         => getSignCertId(),         //证书ID
            'txnType'        => '01',                    //交易类型
            'txnSubType'     => '01',                    //交易子类
            'bizType'        => '000201',                //业务类型：B2C网关支付
            'frontUrl'       => $this->getFrontUrl(),    //前台通知地址：付款到银联的流程结束后的回调（这时候资金还未确定支付）
            'backUrl'        => $this->getBackUrl(),     //后台通知地址：资金确定支付后的异步回调
            'signMethod'     => '01',                    //签名方法
            'channelType'    => '07',                    //渠道类型，07-PC，08-手机
            'accessType'     => '0',                     //接入类型
            'merId'          => '777290058119902',       //商户代码，请改自己的测试商户号
            'orderId'        => $outTradeNo,             //商户订单号
            'txnTime'        => date( 'YmdHis' ),        //订单发送时间
            'txnAmt'         => '1',                     //交易金额，单位分
            'currencyCode'   => '156',                   //交易币种
            'defaultPayType' => '0001',                  //默认支付方式
            'reqReserved'    => ' 透传信息',             //请求方保留域，透传字段，查询、通知、对账文件中均会原样出现

            //'orderDesc' => '订单描述',                 //订单描述，网关支付和wap支付暂时不起作用
        );

        // 签名
        sign( $param );

        return create_html( $param, SDK_FRONT_TRANS_URL );
    }

}
