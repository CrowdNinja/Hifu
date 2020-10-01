<?php  
defined('BASEPATH') OR exit('No direct script access allowed');  
   
// 加载支付宝消息推送
require_once APPPATH.'libraries/Alipay/aop/request/AlipayOpenPublicMessageSingleSendRequest.php';
 
/** 
 * 为CI扩展支付宝消息推送类 
 */ 
class Ci_AliSendResquest extends AlipayOpenPublicMessageSingleSendRequest {
   
      
}  