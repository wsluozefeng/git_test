<?php

require_once "WxPayDataBase.php";

/**
 * 退款查询输入对象
 * Author: youxi
 * Date:   2015/9/28 17:23
 *  
 */

class WxPayRefundQuery extends WxPayDataBase
{

    /**
     * 设置微信订单号
     * @param string $value
     **/
    public function SetTransaction_id($value)
    {
        $this->values['transaction_id'] = $value;
    }
    /**
     * 获取微信订单号的值
     * @return 值
     **/
    public function GetTransaction_id()
    {
        return $this->values['transaction_id'];
    }
    /**
     * 判断微信订单号是否存在
     * @return true 或 false
     **/
    public function IsTransaction_idSet()
    {
        return array_key_exists('transaction_id', $this->values);
    }

    /**
     * 设置商户退款单号
     * @param string $value
     **/
    public function SetOut_refund_no($value)
    {
        $this->values['out_refund_no'] = $value;
    }
    /**
     * 获取商户退款单号的值
     * @return 值
     **/
    public function GetOut_refund_no()
    {
        return $this->values['out_refund_no'];
    }
    /**
     * 判断商户退款单号是否存在
     * @return true 或 false
     **/
    public function IsOut_refund_noSet()
    {
        return array_key_exists('out_refund_no', $this->values);
    }

    /**
     * 设置微信退款单号refund_id、out_refund_no、out_trade_no、transaction_id四个参数必填一个，如果同时存在优先级为：refund_id>out_refund_no>transaction_id>out_trade_no
     * @param string $value
     **/
    public function SetRefund_id($value)
    {
        $this->values['refund_id'] = $value;
    }
    /**
     * 获取微信退款单号refund_id、out_refund_no、out_trade_no、transaction_id四个参数必填一个，如果同时存在优先级为：refund_id>out_refund_no>transaction_id>out_trade_no的值
     * @return 值
     **/
    public function GetRefund_id()
    {
        return $this->values['refund_id'];
    }
    /**
     * 判断微信退款单号refund_id、out_refund_no、out_trade_no、transaction_id四个参数必填一个，如果同时存在优先级为：refund_id>out_refund_no>transaction_id>out_trade_no是否存在
     * @return true 或 false
     **/
    public function IsRefund_idSet()
    {
        return array_key_exists('refund_id', $this->values);
    }

    /**
     *
     * 查询退款 ( ===>后台脚本定时查询退款订单的状态来确定 )
     * 提交退款申请后，通过调用该接口查询退款状态。退款有一定延时，
     * 用零钱支付的退款20分钟内到账，银行卡支付的退款3个工作日后重新查询退款状态。
     * WxPayRefundQuery中out_refund_no、out_trade_no、transaction_id、refund_id四个参数必填一个
     * appid、mchid、spbill_create_ip、nonce_str不需要填入
     * @param int $timeOut
     * @throws WxPayException
     * @return 成功时返回，其他抛异常
     */
    public function refundQuery( $timeOut = 6 )
    {
        $url = "https://api.mch.weixin.qq.com/pay/refundquery";

        static $WxPayCurlObj;
        if ( !is_object( $WxPayCurlObj ) ) {
            $WxPayCurlObj = new WxPayCurl();
        }

        //检测必填参数
        if ( !$this->IsOut_refund_noSet() &&
            !$this->IsOut_trade_noSet() &&
            !$this->IsTransaction_idSet() &&
            !$this->IsRefund_idSet()
        ) {
            throw new WxPayException( "退款查询接口中，out_refund_no、out_trade_no、transaction_id、refund_id四个参数必填一个！" );
        }
        $this->SetAppid( WxPayConfig::APPID );//公众账号ID
        $this->SetMch_id( WxPayConfig::MCHID );//商户号
        $this->SetNonce_str( $WxPayCurlObj->getNonceStr() );//随机字符串

        $this->SetSign();//签名
        $xml = $this->ToXml();


        $response       = $WxPayCurlObj->postXmlCurl( $xml, $url, false, $timeOut );
        $result         = WxPayResult::Init( $response );

        return $result;
    }


}