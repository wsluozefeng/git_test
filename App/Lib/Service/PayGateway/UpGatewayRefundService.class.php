<?php
/**
 * 银联网关支付类型 退款 驱动类
 * Author: youxi
 * Date:   2015/10/15 18:50
 *  
 */

class UpGatewayRefundService extends PayGatewayService{

    public function refund( $id ){

        vendor('UnionPay.Gateway.GatewayRefund');
        $gatewayRefund = new GatewayRefund();
        return $gatewayRefund->refund( $id );

    }

}