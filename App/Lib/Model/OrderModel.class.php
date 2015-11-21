<?php
/**
 * 流水订单
 * Author: youxi
 * Date:   2015/9/23 14:20
 *  
 */

class OrderModel extends Model{

    public function addOrder( $orderNo, $payType ){
        $data = array(
            'order_no'    => $orderNo,
            'pay_type'    => $payType,
            'create_time' => date("Y-m-d H:i:s")
        );

        $id = $this->add($data);

        return $id ? $id : false;

    }

    public function updateOrder( $orderNo, $transactionId ){
        $where['order_no'] = $orderNo;
        $data['transaction_id'] = $transactionId;
        $this->where($where)->save($data);

    }

}