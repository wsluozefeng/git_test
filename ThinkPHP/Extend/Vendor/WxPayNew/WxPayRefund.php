<?php

require_once "WxPayDataBase.php";

/**
 * 提交退款输入对象
 * Author: youxi
 * Date:   2015/9/28 15:31
 *
 */
class WxPayRefund extends WxPayDataBase
{

    /**
     * 设置微信订单号
     * @param string $value
     **/
    public function SetTransaction_id( $value )
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
        return array_key_exists( 'transaction_id', $this->values );
    }

    /**
     * 设置商户系统内部的退款单号，商户系统内部唯一，同一退款单号多次请求只退一笔
     * @param string $value
     **/
    public function SetOut_refund_no( $value )
    {
        $this->values['out_refund_no'] = $value;
    }

    /**
     * 获取商户系统内部的退款单号，商户系统内部唯一，同一退款单号多次请求只退一笔的值
     * @return 值
     **/
    public function GetOut_refund_no()
    {
        return $this->values['out_refund_no'];
    }

    /**
     * 判断商户系统内部的退款单号，商户系统内部唯一，同一退款单号多次请求只退一笔是否存在
     * @return true 或 false
     **/
    public function IsOut_refund_noSet()
    {
        return array_key_exists( 'out_refund_no', $this->values );
    }

    /**
     * 设置退款总金额，订单总金额，单位为分，只能为整数，详见支付金额
     * @param string $value
     **/
    public function SetRefund_fee( $value )
    {
        $this->values['refund_fee'] = $value;
    }

    /**
     * 获取退款总金额，订单总金额，单位为分，只能为整数，详见支付金额的值
     * @return 值
     **/
    public function GetRefund_fee()
    {
        return $this->values['refund_fee'];
    }

    /**
     * 判断退款总金额，订单总金额，单位为分，只能为整数，详见支付金额是否存在
     * @return true 或 false
     **/
    public function IsRefund_feeSet()
    {
        return array_key_exists( 'refund_fee', $this->values );
    }

    /**
     * 设置货币类型，符合ISO 4217标准的三位字母代码，默认人民币：CNY，其他值列表详见货币类型
     * @param string $value
     **/
    public function SetRefund_fee_type( $value )
    {
        $this->values['refund_fee_type'] = $value;
    }

    /**
     * 获取货币类型，符合ISO 4217标准的三位字母代码，默认人民币：CNY，其他值列表详见货币类型的值
     * @return 值
     **/
    public function GetRefund_fee_type()
    {
        return $this->values['refund_fee_type'];
    }

    /**
     * 判断货币类型，符合ISO 4217标准的三位字母代码，默认人民币：CNY，其他值列表详见货币类型是否存在
     * @return true 或 false
     **/
    public function IsRefund_fee_typeSet()
    {
        return array_key_exists( 'refund_fee_type', $this->values );
    }

    /**
     * 设置操作员帐号, 默认为商户号
     * @param string $value
     **/
    public function SetOp_user_id( $value )
    {
        $this->values['op_user_id'] = $value;
    }

    /**
     * 获取操作员帐号, 默认为商户号的值
     * @return 值
     **/
    public function GetOp_user_id()
    {
        return $this->values['op_user_id'];
    }

    /**
     * 判断操作员帐号, 默认为商户号是否存在
     * @return true 或 false
     **/
    public function IsOp_user_idSet()
    {
        return array_key_exists( 'op_user_id', $this->values );
    }

    /**
     *
     * 申请退款，WxPayRefund中out_trade_no、transaction_id至少填一个且
     * out_refund_no、total_fee、refund_fee、op_user_id为必填参数
     * appid、mchid、spbill_create_ip、nonce_str不需要填入
     *
     * @param int $timeOut
     * @throws WxPayException
     * @return 成功时返回，其他抛异常
     */
    public function refund( $timeOut = 6 )
    {
        $url = "https://api.mch.weixin.qq.com/secapi/pay/refund";

        static $WxPayCurlObj;
        if ( !is_object( $WxPayCurlObj ) ) {
            $WxPayCurlObj = new WxPayCurl();
        }

        //检测必填参数
        if ( !$this->IsOut_trade_noSet() && !$this->IsTransaction_idSet() ) {
            throw new WxPayException( "退款申请接口中，out_trade_no、transaction_id至少填一个！" );
        } else if ( !$this->IsOut_refund_noSet() ) {
            throw new WxPayException( "退款申请接口中，缺少必填参数out_refund_no！" );
        } else if ( !$this->IsTotal_feeSet() ) {
            throw new WxPayException( "退款申请接口中，缺少必填参数total_fee！" );
        } else if ( !$this->IsRefund_feeSet() ) {
            throw new WxPayException( "退款申请接口中，缺少必填参数refund_fee！" );
        } else if ( !$this->IsOp_user_idSet() ) {
            throw new WxPayException( "退款申请接口中，缺少必填参数op_user_id！" );
        }
        $this->SetAppid( WxPayConfig::APPID );//公众账号ID
        $this->SetMch_id( WxPayConfig::MCHID );//商户号
        $this->SetNonce_str( $WxPayCurlObj->getNonceStr() );//随机字符串

        $this->SetSign();//签名
        $xml = $this->ToXml();

        $response = $WxPayCurlObj->postXmlCurl( $xml, $url, true, $timeOut );
        $result   = WxPayResult::Init( $response );

        return $result;
    }

}