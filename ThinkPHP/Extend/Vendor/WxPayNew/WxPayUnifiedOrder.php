<?php
require_once "WxPayDataBase.php";

/**
 * 统一下单输入对象
 * Author: youxi
 * Date:   2015/9/28 9:33
 *  
 */

class WxPayUnifiedOrder extends WxPayDataBase{

    protected $unifiedOrderUrl = "https://api.mch.weixin.qq.com/pay/unifiedorder";

    /**
     *
     * 统一下单，WxPayUnifiedOrder中out_trade_no、body、total_fee、trade_type必填
     * appid、mchid、spbill_create_ip、nonce_str不需要填入
     * @param int $timeOut
     * @throws WxPayException
     * @return 成功时返回，其他抛异常
     */
    public function unifiedOrder( $timeOut = 6 )
    {
        static $WxPayCurlObj;
        if( !is_object( $WxPayCurlObj ) ){
            $WxPayCurlObj = new WxPayCurl();
        }

        //检测必填参数
        if ( !$this->IsOut_trade_noSet() ) {
            throw new WxPayException( "缺少统一支付接口必填参数out_trade_no！" );
        } else if ( !$this->IsBodySet() ) {
            throw new WxPayException( "缺少统一支付接口必填参数body！" );
        } else if ( !$this->IsTotal_feeSet() ) {
            throw new WxPayException( "缺少统一支付接口必填参数total_fee！" );
        } else if ( !$this->IsTrade_typeSet() ) {
            throw new WxPayException( "缺少统一支付接口必填参数trade_type！" );
        }

        //关联参数
        if ( $this->GetTrade_type() == "JSAPI" && !$this->IsOpenidSet() ) {
            throw new WxPayException( "统一支付接口中，缺少必填参数openid！trade_type为JSAPI时，openid为必填参数！" );
        }
        if ( $this->GetTrade_type() == "NATIVE" && !$this->IsProduct_idSet() ) {
            throw new WxPayException( "统一支付接口中，缺少必填参数product_id！trade_type为JSAPI时，product_id为必填参数！" );
        }

        //异步通知url未设置，则使用配置文件中的url
        if ( !$this->IsNotify_urlSet() ) {
            $this->SetNotify_url( WxPayConfig::NOTIFY_URL );//异步通知url
        }

        $this->SetAppid( WxPayConfig::APPID );//公众账号ID
        $this->SetMch_id( WxPayConfig::MCHID );//商户号
        $this->SetSpbill_create_ip( $_SERVER['REMOTE_ADDR'] );//终端ip
        //$this->SetSpbill_create_ip("1.1.1.1");
        $this->SetNonce_str( $WxPayCurlObj->getNonceStr() );//随机字符串

        //签名
        $this->SetSign();
        $xml = $this->ToXml();

        $response = $WxPayCurlObj->postXmlCurl( $xml, $this->unifiedOrderUrl, false, $timeOut );
        $result   = WxPayResult::Init( $response );

        return $result;
    }

}