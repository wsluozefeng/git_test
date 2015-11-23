<?php
/**
 * 微信扫描支付驱动类
 * Author: youxi
 * Date:   2015/10/14 19:59
 *  
 */

class WxScanPayService extends PayGatewayService{

    public function pay( $outTradeNo ){
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
        $codeUrl = $result["code_url"];            //二维码链接 例如：weixin://wxpay/bizpayurl?pr=heOzd1P

        return $codeUrl;
    }

}