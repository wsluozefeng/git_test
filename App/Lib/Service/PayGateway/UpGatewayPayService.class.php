<?php
/**
 * 银联网关支付驱动类
 * Author: youxi
 * Date:   2015/10/15 10:54
 *  
 */

class UpGatewayPayService extends PayGatewayService{

    public function pay( $outTradeNo ){
        vendor( 'UnionPay.Gateway.GatewayPay' );
        $gatewayPay = new GatewayPay();

        //构建表单html
        $rel = $gatewayPay->createHtml( $outTradeNo );

        return $rel;
    }

}