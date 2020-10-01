<?php
class Jssdk {
    private $appId;
    private $appSecret;
	
    public function __construct($params = array()) {
      $this->appId = $params[0];
      $this->appSecret = $params[1];
    }

	public function get_current_selfmenu_info(){
		$url = 'https://120.198.199.239/cgi-bin/get_current_selfmenu_info?access_token='.$this->getAccessToken();
		return json_decode($this->httpCurl($url), true);
	}	
	
	public function menu_create($data){
		$url = 'https://120.198.199.239/cgi-bin/menu/create?access_token='.$this->getAccessToken();
		return json_decode($this->httpCurl($url, '', jsonencode($data)), true);
	}
	
	public function message_custom($data){
		$url = 'https://120.198.199.239/cgi-bin/message/custom/send?access_token='.$this->getAccessToken();
		return json_decode($this->httpCurl($url, '', jsonencode($data)), true);
	}
	
	public function message_template($data){
		$url = 'https://120.198.199.239/cgi-bin/message/template/send?access_token='.$this->getAccessToken();
		return json_decode($this->httpCurl($url, '', jsonencode($data)), true);
	}
	
    public function getSignPackage() {
		$jsapiTicket = $this->getJsApiTicket();
		$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$timestamp = time();
		$nonceStr = $this->createNonceStr();
		// 这里参数的顺序要按照 key 值 ASCII 码升序排序
		$string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
		$signature = sha1($string);
		$signPackage = array(
			"appId"     => $this->appId,
			"nonceStr"  => $nonceStr,
			"timestamp" => $timestamp,
			"url"       => $url,
			"signature" => $signature,
			"rawString" => $string
		);
		return $signPackage; 
    }
	
	private function createNonceStr($length = 16) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$str = "";
		for ($i = 0; $i < $length; $i++) {
			$str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
		}
		return $str;
	}
	
	public function getInfo($openids){
		if(is_array($openids)){
			$url = 'https://120.198.199.239/cgi-bin/user/info/batchget?access_token='.$this->getAccessToken();
			$data = array('user_list' => array());
			foreach($openids as $openid){
				$data['user_list'][] = array('openid' => $openid, 'lang' => 'zh_CN');
			}
			return json_decode($this->httpCurl($url, '', $data), true);
		}
		$url = "https://120.198.199.239/cgi-bin/user/info?access_token=".$this->getAccessToken()."&openid=$openids&lang=zh_CN";  
		return json_decode($this->httpCurl($url), true);
	}
	
	public function getQrcodeTicket($scene_id = 0, $action_name = 'QR_SCENE'){
		$data = array(
			'expire_seconds' => 2592000,
			'action_name' => $action_name,
			'action_info' => array('scene' => array('scene_id' => intval($scene_id))),
		);
		if($action_name == 'QR_LIMIT_SCENE')unset($data['expire_seconds']);
		$res = json_decode($this->httpCurl('https://120.198.199.239/cgi-bin/qrcode/create?access_token='.$this->getAccessToken(), 
				'',
				json_encode($data)
				), true);
		return array('ticket' => $res['ticket'], 'expire' => $action_name == 'QR_LIMIT_SCENE' ? 2177423999 : (time() + 2592000 - 60));
	}
	
	public function getJsApiTicket() {
		// jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
		$data = json_decode(file_get_contents("./temp/jsapi_ticket_".md5($this->appId.$this->appSecret).".json"));
		if (intval($data->expire_time) < time()) {
			$accessToken = $this->getAccessToken();
			$url = "https://120.198.199.239/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
			$res = json_decode($this->httpCurl($url));
			$ticket = $res->ticket;
			if ($ticket) {
				$data->expire_time = time() + 7000;
				$data->jsapi_ticket = $ticket;
				$fp = fopen("./temp/jsapi_ticket_".md5($this->appId.$this->appSecret).".json", "w");
				fwrite($fp, json_encode($data));
				fclose($fp);
			}
		} else {
			$ticket = $data->jsapi_ticket;
		}
		return $ticket;
	}
	
	public function getAccessToken() {
		// access_token 应该全局存储与更新，以下代码以写入到文件中做示例
		$data = json_decode(file_get_contents("./temp/access_token_".md5($this->appId.$this->appSecret).".json"));
		if (intval($data->expire_time) < time()) {
			$url = "https://120.198.199.239/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
			$res = json_decode($this->httpCurl($url));
			$access_token = $res->access_token;
			if ($access_token) {
				$data->expire_time = time() + 7000;
				$data->access_token = $access_token;
				$fp = fopen("./temp/access_token_".md5($this->appId.$this->appSecret).".json", "w");
				fwrite($fp, json_encode($data));
				fclose($fp);
			}
		} else {
			$access_token = $data->access_token;
		}
		return $access_token;
	}
	
	public function httpCurl($url, $header = '', $data = '', $delete = false) {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_TIMEOUT, 500);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		if(!empty($header))curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
		if(!empty($data)){
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		}
		if($delete)curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
		curl_setopt($curl, CURLOPT_URL, $url);
		$res = curl_exec($curl);
		curl_close($curl);
		return $res;
	}
}
?>