<?php   
defined('BASEPATH') OR exit('No direct script access allowed');  
   
    /** 
     * TODO: 修改这里配置为您自己申请的商户信息 
     * 微信公众号信息配置 
     *  
     * APPID：绑定支付的APPID（必须配置，开户邮件中可查看） 
     *  
     * MCHID：商户号（必须配置，开户邮件中可查看） 
     *  
     * KEY：商户支付密钥，参考开户邮件设置（必须配置，登录商户平台自行设置） 
     * 设置地址：https://pay.weixin.qq.com/index.php/account/api_cert 
     *  
     * APPSECRET：公众帐号secert（仅JSAPI支付的时候需要配置， 登录公众平台，进入开发者中心可设置）， 
     * 获取地址：https://mp.weixin.qq.com/advanced/advanced?action=dev&t=advanced/dev&token=2005451881&lang=zh_CN 
     * @var string 
     */ 
   
    $config['APP_appid'] = 'wx28ca5fdc61046a06';
    $config['APP_mch_id'] = '1560220251';
    $config['APP_apikey'] = 'yashangkeji888888888888888888888';
    $config['APP_appsecret'] = '5661ddf3bc739df8d52d2627915387a1';
   
    $config['NATIVE_appid'] = '';          
    $config['NATIVE_mch_id'] = '';          
    $config['NATIVE_apikey'] = '';          
    $config['NATIVE_appsecret'] = '';  

    //公众号
    $config['JSAPI_appid'] = 'wxb265f3ec09f9001b';
    $config['JSAPI_mch_id'] = '1555391601';
    $config['JSAPI_apikey'] = 'guangzhouqianlanshenlan111111111';
    $config['JSAPI_appsecret'] = '5462097b31665a136323d157db760515';
    $config['JSAPI_token'] = '';
	$config['JSAPI_aeskey'] = '';
	
    //小程序
    $config['JSAPP_appid'] = 'wxe7fbcbc564a4b736';
    $config['JSAPP_mch_id'] = '1542945061';
    $config['JSAPP_apikey'] = 'gongxiangtingchewei8888888888888';
    $config['JSAPP_appsecret'] = '851f85876a280db8b46ca73b1f285276';
        
    $config['sslcertPath'] =  APPPATH.'libraries/Wxpay/cert/apiclient_cert.pem';
        
    $config['sslkeyPath'] = APPPATH.'libraries/Wxpay/cert/apiclient_key.pem';
