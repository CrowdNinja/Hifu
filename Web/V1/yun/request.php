<?php
require_once __DIR__."/gfun.php";
class Request{
	public static function post2($url, $post_data = '', $timeout = 5){//curl
		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_URL, $url);
		if($post_data != ''){
			curl_setopt ($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		}
		@curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.91 Safari/537.36');
		@curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_HEADER, false);
		$file_contents = curl_exec($ch);
		curl_close($ch);
		return $file_contents;
	}
	public static function post($url, $data){//file_get_content
		$postdata = http_build_query($data);
		$opts = array('http' =>	array(
			'method'=> 'POST',
			'header'=> 'Content-type: application/x-www-form-urlencoded',
			'content' => $postdata)
		);
		$context = stream_context_create($opts);
		$result = file_get_contents($url, false, $context);
		return $result;
	}
	public static function post3($host,$path,$query,$others=''){//fsocket
		$post="POST $path HTTP/1.1\r\nHost: $host\r\n";
		$post.="Content-type: application/x-www-form-";
		$post.="urlencoded\r\n${others}";
		$post.="User-Agent: Mozilla 4.0\r\nContent-length: ";
		$post.=strlen($query)."\r\nConnection: close\r\n\r\n$query";
		//register_shutdown_function(array($this, "sockpost"),$host,$post);
		$h=fsockopen($host,80);
		fwrite($h,$post);
		/*//不接收返回
		for($a=0,$r='';!$a;){
			$b=fread($h,8192);
			$r.=$b;
			$a=(($b=='')?1:0);
		}*/
		fclose($h);
		//return $r;
	}
	public function sockpost($host,$post){
		echo gfun::get_total_millisecond().PHP_EOL;
		$h=fsockopen($host,80);
		fwrite($h,$post);
		fclose($h);
	}
	public static function get($url){
		$html = file_get_contents($url);
		return $html;
	}
	public static function get2($url){
		$fp = fopen($url, 'r');
		stream_get_meta_data($fp);
		while(!feof($fp)) {
		$result .= fgets($fp, 1024);
		}
		echo "url body: $result";
		fclose($fp);
	}
}