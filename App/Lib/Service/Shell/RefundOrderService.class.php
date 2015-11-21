<?php
/**
 * Shell后台订单退款处理
 * Author: youxi
 * Date:   2015/10/8 16:09
 *  
 */

class RefundOrderService extends Service{

    public function WxRefundOrder(){

        $data = service('Order')->shellGetRefundOrder( 1, 0 );

        if( !empty( $data ) ){
            foreach( $data as $key => $row ){
                $status = service('PayGateway.PayGateway')->init('WxRefund')->refundQuery( $row["ro_order_no"] );
                if( $status == 1 ){
                    $rel = service('Order')->updateRefundOrderByOrderNo( $row["ro_order_no"], array( 'ro_refund_status' => 1 ) );
                    if( !$rel ){
                        //todo 更新状态失败的数据 记录到日志
                        Log::write( "退款订单表(ajia_refund_order)中ro_order_no字段值为：".$row["ro_order_no"]." 的记录更新状态失败" );
                    }
                }
            }
        }

    }

}