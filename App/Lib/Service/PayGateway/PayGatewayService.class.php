<?php
/**
 * 支付服务基类
 * Author: youxi
 * Date:   2015/9/30 14:25
 *  
 */

class PayGatewayService extends Service{

    /**
     * 支付类型的类名
     * @var array
     */
    protected $payTypeClassName = array(
        1 => 'WxScanPay',
        2 => 'UpGatewayPay',  //银联网关支付
    );

    /**
     * 退款类型的类名
     * @var array
     */
    protected $refundTypeClassName = array(
        1 => 'WxRefund',
        2 => 'UpGatewayRefund',
    );

    /**
     * PayGateway的驱动类实例化
     * @param $className 类名
     * @return null
     */
    public function init( $className ){
        return service( 'PayGateway.'.$className );
    }

    /**
     * 获取支付类名
     * @param $payType
     * @param bool $showSuffix 是否显示后缀
     * @return string
     */
    public function getPayType( $payType, $showSuffix = false ){
        $suffix           = $showSuffix ? 'Service' : '';
        $payTypeClassName = $this->payTypeClassName[ $payType ] . $suffix;
        return $payTypeClassName;
    }

    /**
     * 获取退款类名
     * @param $refundType
     * @param bool $showSuffix 是否显示后缀
     * @return string
     */
    public function getRefundType( $refundType, $showSuffix = false ){
        $suffix           = $showSuffix ? 'Service' : '';
        $payTypeClassName = $this->refundTypeClassName[ $refundType ] . $suffix;
        return $payTypeClassName;
    }




}