<?php

/**
 * 微信退款
 * Author: youxi
 * Date:   2015/9/30 15:18
 *
 */
class WxRefundService extends PayGatewayService
{

    public function refund( $orderNo )
    {
        $out_trade_no = $orderNo;
        $total_fee    = 1;
        $refund_fee   = 1;

        vendor( 'WxPayNew.WxPayRefund' );
        $input = new WxPayRefund();
        $input->SetOut_trade_no( $out_trade_no );
        $input->SetTotal_fee( $total_fee );
        $input->SetRefund_fee( $refund_fee );
        $input->SetOut_refund_no( createOrderNo() );
        $input->SetOp_user_id( WxPayConfig::MCHID );
        $data = $input->refund();

        if ( $data['result_code'] == 'SUCCESS' && $data['return_code'] == 'SUCCESS' ) {
            $orderNo    = $data['out_trade_no'];
            $refundNo   = $data['out_refund_no'];
            $refundId   = $data['refund_id'];
            $refundType = 1;
            $refundFee  = $data['refund_fee'];

            //D( 'RefundOrder' )->addRefundOrder( $refundNo, $orderNo, $refundId, $refundFee, $refundType );
            service('Order')->addRefundOrder( $refundNo, $orderNo, $refundId, $refundFee, $refundType );
        }

        return true;
    }


    public function refundQuery( $orderNo )
    {
        vendor( 'WxPayNew.WxPayRefundQuery' );
        $out_trade_no = $orderNo;
        $input        = new WxPayRefundQuery();
        $input->SetOut_trade_no( $out_trade_no );
        $data = $input->refundQuery();

        if ( $data['result_code'] == 'SUCCESS' && $data['return_code'] == 'SUCCESS' ) {
            switch( $data['refund_status_0'] ){
                case 'PROCESSING':
                    return 0;
                    break;
                case 'SUCCESS':
                    return 1;
                    break;
                case 'FAIL':
                    return 2;
                    break;
                case 'NOTSURE':
                    return 3;
                    break;
                case 'CHANGE':
                    return 4;
                    break;
            }

        }

        return false;
    }

    private function printf_info( $data )
    {
        foreach ( $data as $key => $value ) {
            echo "<font color='#f00;'>$key</font> : $value <br/>";
        }
    }

}