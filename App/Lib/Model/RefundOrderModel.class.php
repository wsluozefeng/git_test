<?php

/**
 * 退款订单
 * Author: youxi
 * Date:   2015/9/30 16:02
 *
 */
class RefundOrderModel extends Model
{

    public function addRefundOrder( $refundNo, $orderNo, $refundId, $refundFee, $refundType )
    {
        $data['ro_refund_no']     = $refundNo;
        $data['ro_order_no']      = $orderNo;
        $data['ro_refund_id']     = $refundId;
        $data['ro_refund_fee']    = $refundType;
        $data['ro_refund_type']   = $refundFee;

        $id = $this->add( $data );

        return $id ? $id : 0;

    }

    public function updateRefundOrderByOrderNo( $orderNo, $data = array() ){
        $rel = $this->where( array( 'ro_order_no' => $orderNo ) )->save( $data );
        return $rel;
    }

    public function getRefundOrder( $orderNo = '', $refundNo = '', $refundId = '', $refundType = -1, $refundStatus = -1, $limit = '' ){
        $where = array();

        if( !empty( $orderNo ) ){
            $where['ro_order_no'] = $orderNo;
        }

        if( !empty( $refundNo ) ){
            $where['ro_refund_no'] = $refundNo;
        }

        if( !empty( $refundId ) ){
            $where['ro_refund_id'] = $refundId;
        }

        if( !empty( $refundId ) ){
            $where['ro_refund_id'] = $refundId;
        }

        if( $refundType != -1 ){
            $where['ro_refund_type'] = $refundType;
        }

        if( $refundStatus != -1 ){
            $where['ro_refund_status'] = $refundStatus;
        }

        if( !empty( $limit ) ){
            $rel =  $this->where( $where )->limit( $limit )->select();

        }else{
            $rel = $this->where( $where )->select();
        }

        $sql = $this->getLastSql();
        Log::write('-*-*-*-*-*-*'.$sql.'-*-*-*-*-*');

        return $rel;
    }
}