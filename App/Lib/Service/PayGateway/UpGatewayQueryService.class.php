<?php

/**
 * 银联网关支付方式 查询 驱动类
 * Author: youxi
 * Date:   2015/10/15 18:29
 *
 */
class UpGatewayQueryService extends PayGatewayService
{

    public function query( $orderId, $txnTime )
    {

        vendor( 'UnionPay.Gateway.GatewayQuery' );
        $gatewayQuery = new GatewayQuery();
        $rel          = $gatewayQuery->query( $orderId, $txnTime );

        return $rel;
    }

}