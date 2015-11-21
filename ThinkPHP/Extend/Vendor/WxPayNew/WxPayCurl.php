<?php
/**
 * 支付curl类
 * Author: youxi
 * Date:   2015/9/28 9:52
 *  
 */

class WxPayCurl{

    /**
     * 以post方式提交xml到对应的接口url
     *
     * @param string $xml 需要post的xml数据
     * @param string $url url
     * @param bool $useCert 是否需要证书，默认不需要
     * @param int $second url执行超时时间，默认30s
     * @throws WxPayException
     */
    public function postXmlCurl( $xml, $url, $useCert = false, $second = 30 )
    {
        $ch = curl_init();
        //设置超时
        curl_setopt( $ch, CURLOPT_TIMEOUT, $second );


        //如果有配置代理这里就设置代理
        if ( WxPayConfig::CURL_PROXY_HOST != "0.0.0.0"
            && WxPayConfig::CURL_PROXY_PORT != 0
        ) {
            curl_setopt( $ch, CURLOPT_PROXY, WxPayConfig::CURL_PROXY_HOST );
            curl_setopt( $ch, CURLOPT_PROXYPORT, WxPayConfig::CURL_PROXY_PORT );
        }
        curl_setopt( $ch, CURLOPT_URL, $url );
        /*curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,TRUE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);//严格校验*/
        curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );

        //设置header
        curl_setopt( $ch, CURLOPT_HEADER, FALSE );
        //要求结果为字符串且输出到屏幕上
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, TRUE );

        if ( $useCert == true ) {
            //设置证书
            //使用证书：cert 与 key 分别属于两个.pem文件
            curl_setopt( $ch, CURLOPT_SSLCERTTYPE, 'PEM' );
            //curl_setopt( $ch, CURLOPT_SSLCERT, WxPayConfig::SSLCERT_PATH );
            curl_setopt( $ch, CURLOPT_SSLCERT, WxPayConfig::getSslcertPath() );
            curl_setopt( $ch, CURLOPT_SSLKEYTYPE, 'PEM' );
            //curl_setopt( $ch, CURLOPT_SSLKEY, WxPayConfig::SSLKEY_PATH );
            curl_setopt( $ch, CURLOPT_SSLKEY, WxPayConfig::getSslkeyPath() );
        }
        //post提交方式
        curl_setopt( $ch, CURLOPT_POST, TRUE );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $xml );
        //运行curl
        $data = curl_exec( $ch );

        //返回结果
        if ( $data ) {
            curl_close( $ch );
            return $data;
        } else {
            $error = curl_errno( $ch );
            curl_close( $ch );
            print_r($error);exit;
            throw new WxPayException( "curl出错，错误码:$error" );
        }
    }

    /**
     *
     * 产生随机字符串，不长于32位
     * @param int $length
     * @return 产生的随机字符串
     */
    public function getNonceStr( $length = 32 )
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str   = "";
        for ( $i = 0; $i < $length; $i++ ) {
            $str .= substr( $chars, mt_rand( 0, strlen( $chars ) - 1 ), 1 );
        }
        return $str;
    }

}