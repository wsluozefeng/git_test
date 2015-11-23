<?php
/**
 * 订单服务
 * Author: youxi
 * Date:   2015/10/8 16:16
 *  
 */

class OrderService extends Service{

    /**
     * 新增退款订单
     * @param $refundNo
     * @param $orderNo
     * @param $refundId
     * @param $refundFee
     * @param $refundType
     * @return mixed
     */
    public function addRefundOrder( $refundNo, $orderNo, $refundId, $refundFee, $refundType ){
        return D( 'RefundOrder' )->addRefundOrder( $refundNo, $orderNo, $refundId, $refundFee, $refundType );
    }

    /**
     * 更新退款订单状态
     * @param $orderNo
     * @param array $data
     * @return bool
     */
    public function updateRefundOrderByOrderNo( $orderNo, $data = array() ){
        if( !empty( $orderNo ) && !empty( $data ) ){
            return D( 'RefundOrder' )->updateRefundOrderByOrderNo( $orderNo, $data );
        }

        return false;
    }

    /**
     * 获取退款订单
     * @param string $orderNo
     * @param string $refundNo
     * @param string $refundId
     * @param int    $refundType
     * @param int    $refundStatus
     * @return mixed
     */
    public function getRefundOrder( $orderNo = '', $refundNo = '', $refundId = '', $refundType = -1, $refundStatus = -1 ){
        return D( 'RefundOrder' )->getRefundOrder( $orderNo, $refundNo, $refundId, $refundType, $refundStatus );
    }

    public function shellGetRefundOrder( $refundType = -1, $refundStatus = 0 ){

        $key = 'shell_get_not_complete_refund_order:'.$refundType;
        $redis = CacheRedisGroup::getInstance();

        $pageNum     = 1;
        //$currentPage = !( $redis->get($key) ) ? intval( $redis->get($key) ) : 1;
        $currentPage = $redis->incr( $key );
        $limit       = ($currentPage - 1) * $pageNum . "," . $pageNum;
        $data        = D( 'RefundOrder' )->getRefundOrder( '', '', '', $refundType, $refundStatus, $limit );


        if( count( $data ) < $pageNum ){
            $redis->delete( $key );
        }

        return $data;
    }

}