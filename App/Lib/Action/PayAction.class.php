<?php
/**
 *
 * Author: youxi
 * Date:   2015/9/25 11:53
 *  
 */

class PayAction extends Action{

    /**
     * 微信的扫码支付
     * @throws WxPayException
     */
    public function index(){
        /*$outTradeNo = '214400700257935';
        vendor('WxPay.WxPayApi');

        $input = new WxPayUnifiedOrder();
        $input->SetBody("ck-秋季牛仔裤");
        $input->SetAttach("test");
        //$input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));
        $input->SetOut_trade_no( $outTradeNo );
        $input->SetTotal_fee("1");
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("test");
        $input->SetNotify_url("http://shwguan.com/ajia.php");   //支付成功后的异步回调url
        $input->SetTrade_type("NATIVE");
        $input->SetProduct_id("123456789");

        $result  = WxPayApi::unifiedOrder($input);
        $codeUrl = $result["code_url"];            //二维码链接 例如：weixin://wxpay/bizpayurl?pr=heOzd1P
        //$codeUrl = urlencode($result["code_url"]);

        $this->assign('codeUrl', $codeUrl);
        $this->display();*/

        $orderNo      = $_REQUEST['orderNo'];
        $token        = $_REQUEST['token'];
        $payType      = $_REQUEST['payType'];

        $tokenIsRight = comparePageToken( '159753', 'createOrder', array( $orderNo ), $token );

        $redis        = CacheRedisGroup::getInstance();
        $redisKey     = C( 'redis_key' );
        $redisToken   = $redis->hget( $redisKey['hash_page_token_list'], 'order_to_pay' );  //过期时间为60秒

        if ( !$tokenIsRight || !$redisToken ) {
            exit( '订单异常或不存在此订单' );
        }

        $className  = Service('PayGateway.PayGateway')->getPayType( $payType );
        $payTypeObj = Service('PayGateway.PayGateway')->init( $className );
        $codeUrl    = $payTypeObj->pay( $orderNo );

        /*var_dump($className);exit;
        $outTradeNo = $orderNo;
        vendor('WxPayNew.WxPayUnifiedOrder');

        $input = new WxPayUnifiedOrder();
        $input->SetBody("CK-秋季牛仔裤");
        $input->SetAttach("test");
        //$input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));
        $input->SetOut_trade_no( $outTradeNo );
        $input->SetTotal_fee("1");
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("test");
        $input->SetNotify_url("http://shwguan.com/ajia.php");   //支付成功后的异步回调url
        $input->SetTrade_type("NATIVE");
        $input->SetProduct_id("123456789");

        $result  = $input->unifiedOrder();
        $codeUrl = $result["code_url"];            //二维码链接 例如：weixin://wxpay/bizpayurl?pr=heOzd1P*/

        if( $payType == 1 ){
            $this->assign('codeUrl', $codeUrl);
            $this->display();
        }elseif( $payType == 2 ){
            $this->assign('formHtml', $codeUrl);
            $this->display('upPay');
        }


    }

    /**
     * 订单查询 可根据 out_trade_no 或者 transaction_id 字段查询
     * @throws WxPayException
     */
    public function orderQuery(){

        $rel = Service('PayGateway.PayGateway')->init('UpGatewayQuery')->query( 1,2 );
        print_r( $rel );

        /*vendor('WxPayNew.WxPayOrderQuery');
        $out_trade_no = $_REQUEST['out_trade_no'];
        $input = new WxPayOrderQuery();
        $input->SetOut_trade_no($out_trade_no);
        //print_r( json_encode( $input->orderQuery() ) ) ;

        $this->printf_info($input->orderQuery());*/
        exit();

    }

    /**
     * 退款  并没有回调函数，确认是否退款真正成功，使用“退款查询”接口来确定
     * 退款需要证书，证书的路径需要使用绝对路径
     * @throws WxPayException
     */
    public function refund(){
        /*if(isset($_REQUEST["out_trade_no"]) && $_REQUEST["out_trade_no"] != ""){
            service('PayGateway.PayGateway')->init('WxRefund')->refund( $_REQUEST["out_trade_no"] );
        }*/

        $rel = Service('PayGateway.PayGateway')->init('UpGatewayRefund')->refund( $_REQUEST["out_trade_no"] );
        print_r($rel);
        exit;
    }

    /**
     * 退款查询
     * 交退款申请后，通过调用该接口查询退款状态。退款有一定延时，用零钱支付的退款20分钟内到账，银行卡支付的退款3个工作日后重新查询退款状态。
     * @throws WxPayException
     */
    public function refundQuery(){
        if(isset($_REQUEST["out_trade_no"]) && $_REQUEST["out_trade_no"] != ""){

            $status = service('PayGateway.PayGateway')->init('WxRefund')->refundQuery( $_REQUEST["out_trade_no"] );
            if( false !== $status ){
                $rel = array( 'code' => 1, 'msg'=>'', 'data'=>array( 'refund_status_0'=> $status ) );
            }else{
                $rel = array( 'code' => -1, 'msg'=>'', 'data'=>array() );
            }

            print_r( json_encode($rel) );
            exit;

        }else{
            $rel = array( 'code' => -1, 'msg'=>'请在url中输入out_trade_no参数', 'data'=>array() );
            print_r( json_encode($rel) );
            exit;
        }
    }

    /**
     * thinkphp_cli项目下的退款订单后台处理
     */
    public function shellDealWxRefundOrder(){
        ignore_user_abort ( TRUE );
        service('Shell.RefundOrder')->WxRefundOrder();
    }

    /**
     * thinkphp_cli并发curl测试
     */
    public function curlMulti(){
        if(isset($_REQUEST["out_trade_no"]) && $_REQUEST["out_trade_no"] != ""){
            D("test")->add( array('order_no' => $_REQUEST["out_trade_no"] ) );
            echo "result is => ".$_REQUEST["out_trade_no"];
            exit;
        }
    }

    public function unionPayFrontReceive(){
        $data = $_POST;
        print_r($data);
        exit;
        $this->display();
    }

    private function printf_info($data)
    {
        foreach($data as $key=>$value){
            echo "<font color='#f00;'>$key</font> : $value <br/>";
        }
    }

}