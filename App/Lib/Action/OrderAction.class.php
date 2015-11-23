<?php
/**
 *
 * Author: youxi
 * Date:   2015/9/22 17:11
 *  
 */

class OrderAction extends Action{

    public function index(){
        $this->display();
    }

    public function createOrder(){

        $payType = $_POST['payType'];
        $orderNo = createOrderNo();
        //$orderNo = '545048480627';
        $orderId = D('Order')->addOrder( $orderNo, 1 );
        $token   = createPageToken( '159753', 'createOrder', array($orderNo) );

        $redis    = CacheRedisGroup::getInstance();
        $redisKey = C('redis_key');
        $redis->hset( $redisKey['hash_page_token_list'], 'order_to_pay', $token );
        $redis->expire( $redisKey['hash_page_token_list'], 600);

        $status  = $orderId ? 1 : 0;
        //$status = 1;

        $rel = json_encode( array( 'status' => $status, 'data' => array('order_no'=>$orderNo, 'token'=>$token, 'payType'=>$payType) ) );

        echo $rel; exit;
    }

}