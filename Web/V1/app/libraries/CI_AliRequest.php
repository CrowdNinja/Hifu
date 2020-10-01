<?php  
defined('BASEPATH') OR exit('No direct script access allowed');  
   
// 加载微信支付  
require_once APPPATH.'libraries/Alipay/aop/request/AlipaySystemOauthTokenRequest.php';
 
/** 
 * 为CI扩展微信支付类 
 */ 
class CI_AliRequest extends AlipaySystemOauthTokenRequest {
   
      
}  