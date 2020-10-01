<?php
require_once 'HttpRequst.php';
require_once 'AopSdk.php';
require_once 'function.inc.php';
// $pushmsg = new PushMsg ();
// $pushmsg->test ();
class PushMsg {
	// 测试
	public function test() {
		$image_text_msg1 = $this->mkImageTextMsg ( "标题", "描述", "http://wap.taobao.com", "https://i.alipayobjects.com/e/201310/1H9ctsy9oN_src.jpg", "loginAuth" );
		$image_text_msg2 = $this->mkImageTextMsg ( "标题", "描述", "http://wap.taobao.com", "https://i.alipayobjects.com/e/201310/1H9ctsy9oN_src.jpg", "loginAuth" );
		// 组装多条图文信息
		$image_text_msg = array (
				$image_text_msg1,
				$image_text_msg2 
		);
		
		$toUserId = "xLF-4RvtNKGlYDC8xLgTnI97w0QKRHRl-OmymTOxsGHnKDWiwQekMHiEi06tEbjg01";
		// $toUserId="BM7PjM8f8-v6VFqeTlFUqo97w0QKRHRl-OmymTOxsGHnKDWiwQekMHiEi06tEbjg01";
		$biz_content = $this->mkImageTextBizContent ( $toUserId, $image_text_msg );
		// echo $biz_content;exit();
		// echo $this->sendMsgRequest ( $biz_content );
		print_r ( $this->sendRequest ( $biz_content ) );
	}
	
	// 纯文本消息
	public function mkTextMsg($content) {
		$text = array (
				'content' => $content 
		);
		return $text;
	}
	
	// 图文消息，
	// $authType=loginAuth时，用户点击链接会将带有auth_code，可以换取用户信息
	public function mkImageTextMsg($title, $desc, $url, $imageUrl, $authType) {
		$articles_arr = array (
				'actionName' => "立即查看" ,
				'desc' =>  $desc ,
				'imageUrl' => $imageUrl,
				'title' =>  $title ,
				'url' => $url,
				'authType' => $authType 
		);
		return $articles_arr;
	}
	
	/**
	 * 返回图文消息的biz_content
	 *
	 * @param string $toUserId        	
	 * @param array $articles        	
	 * @return string
	 */
	public function mkImageTextBizContent($toUserId, $articles) {
		$biz_content = array (
				'msgType' => 'image-text',
				'createTime' => time (),
				'articles' => $articles 
		);
		return $this->toBizContentJson ( $biz_content, $toUserId );
	}
	/**
	 * 返回纯文本消息的biz_content
	 *
	 * @param unknown $toUserId        	
	 * @param unknown $text        	
	 * @return string
	 */
	public function mkTextBizContent($toUserId, $text) {
		$biz_content = array (
				'msgType' => 'text',
				'text' => $text 
		);
		return $this->toBizContentJson ( $biz_content, $toUserId );
	}
	private function toBizContentJson($biz_content, $toUserId) {
		// 如果toUserId为空，则是发给所有关注的而用户，且不可删除，慎用
		if (isset ( $toUserId ) && ! empty ( $toUserId )) {
			$biz_content ['toUserId'] = $toUserId;
		}
		
		$content = $this->JSON ( $biz_content );
		return $content;
	}
	/**
	 * 使用sdk中的异步单发消息接口，发送组装好的信息
	 *
	 * @param unknown $biz_content        	
	 */
	public function sendRequest($biz_content) {
		$custom_send = new AlipayOpenPublicMessageCustomSendRequest();
		$custom_send->setBizContent ( $biz_content );
		
		return aopclient_request_execute ( $custom_send );
	}

	function is_utf8($text) {
		$e = mb_detect_encoding ( $text, array (
				'UTF-8',
				'GBK' 
		) );
		switch ($e) {
			case 'UTF-8' : // 如果是utf8编码
				return true;
			case 'GBK' : // 如果是gbk编码
				return false;
		}
	}
	
	/**
	 * 下载用户发送过来的图片
	 *
	 * @param unknown $biz_content        	
	 * @param unknown $fileName        	
	 */
	public function downMediaRequest($biz_content, $fileName) {
		require 'config.php';
		
		date_default_timezone_set ( PRC );
		$paramsArray = array (
				'method' => "alipay.mobile.public.multimedia.download",
				'biz_content' => $biz_content,
				'charset' => $config ['charset'],
				'sign_type' => $config['sign_type'],
				'app_id' => $config ['app_id'],
				'timestamp' => date ( 'Y-m-d H:i:s', time () ),
				'version' => "1.0" 
		);
		// echo $biz_content;
		
		// print_r($paramsArray);
		require_once 'AopSdk.php';
		$as = new AopClient();
		$signContent=$as->getSignContent($paramsArray);
		$sign=$as->alonersaSign($signContent,$config['merchant_private_key'],$config['sign_type']);
		$paramsArray ['sign'] = $sign;
		$url = "https://openfile.alipay.com/chat/multimedia.do?";
		
		writeLog(HttpRequest::sendPostRequst ( $url, $paramsArray ));
		file_put_contents ( $fileName, HttpRequest::sendPostRequst ( $url, $paramsArray ) );
	}
	
	/**
	 * ************************************************************
	 *
	 * 使用特定function对数组中所有元素做处理
	 *
	 * @param
	 *        	string &$array 要处理的字符串
	 * @param string $function
	 *        	要执行的函数
	 * @return boolean $apply_to_keys_also 是否也应用到key上
	 * @access public
	 *        
	 *         ***********************************************************
	 */
	protected function arrayRecursive(&$array, $function, $apply_to_keys_also = false) {
		foreach ( $array as $key => $value ) {
			if (is_array ( $value )) {
				$this->arrayRecursive ( $array [$key], $function, $apply_to_keys_also );
			} else {
				$array [$key] = $function ( $value );
			}
			
			if ($apply_to_keys_also && is_string ( $key )) {
				$new_key = $function ( $key );
				if ($new_key != $key) {
					$array [$new_key] = $array [$key];
					unset ( $array [$key] );
				}
			}
		}
	}
	
	/**
	 * ************************************************************
	 *
	 * 将数组转换为JSON字符串（兼容中文）
	 *
	 * @param array $array
	 *        	要转换的数组
	 * @return string 转换得到的json字符串
	 * @access public
	 *        
	 *         ***********************************************************
	 */
	protected function JSON($array) {
		$this->arrayRecursive ( $array, 'urlencode', true );
		$json = json_encode ( $array );
		return urldecode ( $json );
	}
}