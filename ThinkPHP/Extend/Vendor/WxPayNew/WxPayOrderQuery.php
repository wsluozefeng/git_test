<?php

require_once "WxPayDataBase.php";

/**
 * 订单查询输入对象
 * Author: youxi
 * Date:   2015/9/28 13:53
 *
 */
class WxPayOrderQuery extends WxPayDataBase
{

    /**
     * 设置微信的订单号，优先使用
     * @param string $value
     **/
    public function SetTransaction_id( $value )
    {
        $this->values['transaction_id'] = $value;
    }

    /**
     * 获取微信的订单号，优先使用的值
     * @return 值
     **/
    public function GetTransaction_id()
    {
        return $this->values['transaction_id'];
    }

    /**
     * 判断微信的订单号，优先使用是否存在
     * @return true 或 false
     **/
    public function IsTransaction_idSet()
    {
        return array_key_exists( 'transaction_id', $this->values );
    }

    /**
     *
     * 查询订单，WxPayOrderQuery中out_trade_no、transaction_id至少填一个
     * appid、mchid、spbill_create_ip、nonce_str不需要填入
     * @param int $timeOut
     * @throws WxPayException
     * @return 成功时返回，其他抛异常
     */
    public function orderQuery( $timeOut = 6 )
    {
        $url = "https://api.mch.weixin.qq.com/pay/orderquery";

        static $WxPayCurlObj;
        if ( !is_object( $WxPayCurlObj ) ) {
            $WxPayCurlObj = new WxPayCurl();
        }

        //检测必填参数
        if ( !$this->IsOut_trade_noSet() && !$this->IsTransaction_idSet() ) {
            throw new WxPayException( "订单查询接口中，out_trade_no、transaction_id至少填一个！" );
        }
        $this->SetAppid( WxPayConfig::APPID );//公众账号ID
        $this->SetMch_id( WxPayConfig::MCHID );//商户号
        $this->SetNonce_str( $WxPayCurlObj->getNonceStr() );//随机字符串

        $this->SetSign();//签名
        $xml = $this->ToXml();

        $response = $WxPayCurlObj->postXmlCurl( $xml, $url, false, $timeOut );
        $result   = WxPayResult::Init( $response );

        return $result;
    }


}