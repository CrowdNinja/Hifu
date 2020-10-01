<?php
 class Weixin_api {
 	private $appid = '';
 	private $appsecret = '';
 	                      
 	private $enabe_log = false; //日志开关。可填值：true、
 	private $send_msg = FALSE;//send weixin msg 
 	private $filename="wx_log.txt"; //日志文件
 	private $handle; 
 	private $errcode = '40013';
 	function __construct($config=[])
	{
	    if($config){
        $this->appid =$config['appid'];
        $this->appsecret = $config['appsecret'];
	    }
        //$this->handle = fopen($this->filename, 'a');
	}
 	
 	/**
     * 获取access token
     */
 	function get_token()
 	{
 		$file = 'access_token.txt';
        if (file_exists($file)) {
            $res = json_decode(file_get_contents($file), 1);
            //print_r($res);
           // exit;
            if ($res && $res['expire_time'] > time()) {
                return $res['access_token'];
            }
        }
 		//$url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$this->appid.'&secret='.$this->appsecret.'';
 		//$result =  $this->curl_request($url);       https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=APPID&secret=APPSECRET
 		$obj = json_decode(file_get_contents(sprintf('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s', $this->appid, $this->appsecret)), 1);
 		$this->showlog("get_token = ".serialize($obj));
 		 if ($obj && isset($obj['access_token'])) {
            $obj['expire_time'] = time() + $obj['expires_in']- 60;
            file_put_contents($file, json_encode($obj));
            return $obj['access_token'];
        }else{
            return $this->errcode;
        }
 	}
 	
 	function get_openid_url($return_url)
 	{
 		return sprintf('https://open.weixin.qq.com/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect', $this->appid, $return_url);
 	}
 	
 	function get_token_url($code)
 	{
 		return sprintf(
		        'https://api.weixin.qq.com/sns/oauth2/access_token?appid=%s&secret=%s&code=%s&grant_type=authorization_code',
		        $this->appid,
		        $this->appsecret,
		        $code
		    );
 	}
 	
 	
 	/**
     * 创建菜单
     */
 
 	function create_menu($token,$data)
 	{
 		$url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$token;
 		$result =  $this->curl_request($url,$data);
 		$this->showlog("create_menu = ".$result);
 		return $result;
 	}
 	
 	/**
     * 获取用户信息
     */
 	function get_user($openid)
 	{ 
 		$token = $this->get_token();
 	 
 		if($token)
 		{
 			$url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$token.'&openid='.$openid.'&lang=zh_CN';
 		    $data =  $this->curl_request($url);
 		    $this->showlog("get_user = ".$data);
 		    return $data;
 		}
 		//$this->showlog("get_user = ".$result);
 	}
 	
 	 /**
     * 得到网页授权code
     */
   function get_web_code($request_url)
   {
   	
   	    
   	   $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$this->appid.'&redirect_uri='.'&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect';
   	   header("Location:$url"); 
   }
   
    /**
     * 得到网页授权token
     */
   function get_web_token($code)
   {
   	   $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$this->appid.'&secret='.$this->appsecret.'&code='.$code.'&grant_type=authorization_code';
   	            
   	   $data =  $this->curl_request($url);
 	   $this->showlog("get_web_token = ".$data);
 	   
 	   return $data;
   }
   
   function get_web_user($code)
   {
   	  $result = $this->get_web_token($code);
   	  $obj = json_decode($result);
   	  if($obj->access_token)
 		{
 			$url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$obj->access_token.'&openid='.$obj->openid.'&lang=zh_CN';
 			$data =  $this->curl_request($url);
 			$this->showlog("get_web_user = ".$data);
 			return $data;
 		}
   	  $this->showlog("get_web_user = ".$result);
   }
   
 	 /**
     * 发起HTTPS请求
     */
 	function curl_request($url, $data = null)
	{
	        $curl = curl_init();
	        curl_setopt($curl, CURLOPT_URL, $url);
	        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
	        if (!empty($data)){
	            curl_setopt($curl, CURLOPT_POST, 1);
	            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	        }
	        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	        $output = curl_exec($curl);
	        curl_close($curl);
	        return $output;
	  }
	  


   function encode($var) {
    switch (gettype($var)) {
        case 'boolean':
            return $var ? 'true' : 'false'; // Lowercase necessary!
        case 'integer':
        case 'double':
            return sprintf( '"%s"', $var);
        case 'resource':
        case 'string':
            return '"'. str_replace(array("\r", "\n", "\t", '\\\'', "/"),
                array('\r', '\n', '\t', '\'', '\\/'),
                addslashes($var)) .'"';
       case 'array':
            // Arrays in JSON can't be associative. If the array is empty or if it
            // has sequential whole number keys starting with 0, it's not associative
            // so we can go ahead and convert it as an array.
            if ( empty ($var) || array_keys($var) === range(0, sizeof($var) - 1)) {
                $output = array();
                foreach ($var as $v) {
                    $output[] = $this->encode($v);
                }
                return '['. implode(',', $output) .']';
            }
        // Otherwise, fall through to convert the array as an object.
      case 'object':
            $output = array();
            foreach ($var as $k => $v) {
                $output[] =  $this->encode(strval($k)) .':'.  $this->encode($v);
            }
            return '{'. implode(',', $output) .'}';
        default:
            return 'null';
    }
}
 /*
     *  发送模板消息
     */
    public function tmpl($openid, $data,$force=false)
    {
        if($this->send_msg&&!empty($openid)){
            
                $token = $this->get_token();
                $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$token;
                $api_content = $data;
                $api_content['touser']= $openid;
                $api_content = json_encode($api_content);
                $returninfo = $this->curl_post($url,$api_content);
                if($returninfo){
                	 $this->showlog("tmpl = true");
                    return array('code'=>0,'msg'=>'发送成功');  
                }
            }else{
            	$this->showlog("tmpl = false");
                return array('code'=>-1,'msg'=>'获取access_token失败');
                
        } 
        $this->showlog("tmpl = ");
    }
    
     function curl_post($url, $data){
        $ch = curl_init();
        $header = "Accept-Charset: utf-8";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        //curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $tmpInfo = curl_exec($ch);

        if (curl_errno($ch)) {
            return false;
        }else{
            return $tmpInfo;
        }
    }
	
	
 	 /**
    * 打印日志
    * 
    * @param log 日志内容
    */
    function showlog($log){
      if($this->enabe_log){
         fwrite($this->handle,date("m-d H:i:s",strtotime(time())).",ip:".$_SERVER["REMOTE_ADDR"].",log:".$log."\r\n");  
      }
    }
    
    //--------------------------------------------------js_sdk-----------------------------------
    
    function get_sign_package() {
    $jsapiTicket = $this->get_js_api_ticket();
    // 注意 URL 一定要动态获取，不能 hardcode.
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    $timestamp = time();
    $nonceStr = $this->create_nonce_str();

    // 这里参数的顺序要按照 key 值 ASCII 码升序排序
    $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

    $signature = sha1($string);

    $signPackage = array(
      "appId"     => $this->appid,
      "nonceStr"  => $nonceStr,
      "timestamp" => $timestamp,
      "url"       => $url,
      "signature" => $signature,
      "rawString" => $string
    );
    return $signPackage; 
  }
  
  
  private function create_nonce_str($length = 16) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $str = "";
    for ($i = 0; $i < $length; $i++) {
      $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $str;
  }

  private function get_js_api_ticket() {
    // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
    $data = json_decode(file_get_contents("jsapi_ticket.json"));
    if ($data->expire_time < time()) {
      $accessToken = $this->get_js_access_token();
      // 如果是企业号用以下 URL 获取 ticket
      // $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
      $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
      $res = json_decode($this->curl_request($url));
      $ticket = $res->ticket;
      if ($ticket) {
        $data->expire_time = time() + 7000;
        $data->jsapi_ticket = $ticket;
        $fp = fopen("jsapi_ticket.json", "w");
        fwrite($fp, json_encode($data));
        fclose($fp);
      }
    } else {
      $ticket = $data->jsapi_ticket;
    }
    return $ticket;
  }
  
  private function get_js_access_token() {
    // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
    $data = json_decode(file_get_contents("access_token.json"));
    if ($data->expire_time < time()) {
      // 如果是企业号用以下URL获取access_token
      // $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";
      $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appid&secret=$this->appsecret";
      $res = json_decode($this->curl_request($url));
      $access_token = $res->access_token;
      if ($access_token) {
        $data->expire_time = time() + 7000;
        $data->access_token = $access_token;
        $fp = fopen("access_token.json", "w");
        fwrite($fp, json_encode($data));
        fclose($fp);
      }
    } else {
      $access_token = $data->access_token;
    }
    return $access_token;
  }
  
    
 }