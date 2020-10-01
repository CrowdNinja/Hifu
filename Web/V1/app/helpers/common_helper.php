<?php if (!defined('BASEPATH')) exit('No direct access allowed.');

function isweixin(){
	if (stripos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false || $_SERVER['HTTP_CLIENT'] == 'MicroMessenger' || $_SERVER['HTTP_CLIENT'] == 'MiniProgram') {
		return true;
	}
	return false;
}
 function is_alipay()
{
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'AlipayClient') !== false) {
        return true;
    }
    return false;
}
function jsonencode($arr){
	if(PHP_VERSION >= 5.4)return json_encode($arr, JSON_UNESCAPED_UNICODE);
	
	function url_encode($str){
		if(is_array($str)){
			foreach($str as &$v){
				if(is_array($v)){
					$v = url_encode($v);
				}else{
					$v = is_string($v) ? urlencode(str_replace('"', '\"', $v)) : $v;
				}
			}
		}else{
			$str = is_string($str) ? urlencode(str_replace('"', '\"', $str)) : $str;
		}
		return $str;
	}
	
	$arr = array_map('url_encode', $arr);
	return urldecode(json_encode($arr));
}

//拼接完整域名
function concaturl($baseurl, $url = false, $split = false){
	$args_num = func_num_args();
	if($args_num == 2){
		$split = $url;
		$url = $baseurl;
		$baseurl = base_url();
	}
	if($url === false){//只传一个参数
		$url = $baseurl;
		$baseurl = base_url();
	}
	if(!$url)return $url;
	if(is_array($url) || $split){
		$urls = $url;
		if(!is_array($url)){
			if($split == "\n")$url = str_replace("\r", "", $url);
			$urls = array_filter(explode($split, $url));
		}
		foreach($urls as &$v){
			if(stripos($v, 'http://') === 0 || stripos($v, 'https://') === 0 || stripos($v, 'weixin://') === 0){
			}else{
				$v = $baseurl.trim($v, '/');
			}
		}
		unset($v);
		return $urls;
	}
	if(stripos($url, 'http://') === 0 || stripos($url, 'https://') === 0 || stripos($url, 'weixin://') === 0)return $url;
	return $baseurl.trim($url, '/');	
}

function relativeurl($baseurl, $url = false){
	if($url === false){//只传一个参数
		$url = $baseurl;
		$baseurl = base_url();
	}
	if(!$url)return $url;
	if(stripos($url, 'http://') !== 0 && stripos($url, 'https://') !== 0 && stripos($url, 'weixin://') !== 0)return $url;
	return '/'.trim(str_ireplace($baseurl, '', $url), '/');	
}

function getrandno($format = 'YmdHis'){
	list($usec, $sec) = explode(" ", microtime());
	return date($format, $sec).substr($usec, 2, 3);
}

function macno2hex($macno, $len = 8){
	if(!$macno)return '';
	return str_pad(dechex($macno), $len, '0', STR_PAD_LEFT);
}

function macno2dec($macno, $len = 10){
	if(!$macno)return '';
	return str_pad(hexdec($macno), $len, '0', STR_PAD_LEFT);
}

function getencrypt(){
	$args = func_get_args();
	$result = '';
	foreach($args as $v){
		$l = strlen($v);
		$ll = strlen($l);
		$result .= $ll.$l.$v;
	}
	return $result;	
}
	
function getdecrypt($encrypt = ''){
	$result = array();
	if(strlen($encrypt)){
		$i = 0;
		while(true){
			$ll = substr($encrypt, $i, 1);
			$l = substr($encrypt, $i + 1, $ll);
			$v = substr($encrypt, $i + 1 + $ll, $l);
			if(strlen($v) == 0)break;
			$result[] = $v;
			$i += 1 + $ll + $l;
		}
	}
	return $result;
}

function getfileext($file, $low = true){
	$ext = strrchr($image, '.');
	if($low)$ext = strtolower($ext);
	return $ext;
}

//拆分地址
function address2array($address){
	$result = array(
		'province' => '',
		'city' => '',
		'address' => '',
	);
	//匹配本地地址库
	$cnAreaList = trim(file_get_contents(APPPATH."../style/js/cnarealist.js"));
	$cnAreaList = substr($cnAreaList, strpos($cnAreaList, '{'), -1);
	$cnAreaList = json_decode($cnAreaList, true);
	foreach($cnAreaList['parent'] as $v){
		if(strpos($address, $v['name']) !== false || strpos($v['name'], $address) !== false){
			$result['province'] = $v['name'];
		}
		foreach($v['child'] as $vv){
			if(strpos($address, $vv['name']) !== false || strpos($vv['name'], $address) !== false){
				$result['city'] = $vv['name'];
				if(!$result['province'])$result['province'] = $v['name'];
			}
		}
	}
	return $result;
}

function address2location($address, $filter = true){
	$CI = &get_instance();
	if($filter){
		$address = str_replace(array(' ', '&gt;', '>', '&nbsp;'), '', $address);	
	}
	$geocode = json_decode(post_url('http://restapi.amap.com/v3/geocode/geo?address='.urlencode($address).'&output=JSON&key='.$CI->config->item('geocoder_webkey')), true);
	$location = explode('|',$geocode['geocodes'][0]['location']);
	return explode(',', $location[0]);
}

//$location = '113.7434,23.01278';
function location2address($location){
	$CI = &get_instance();
	$geocode = json_decode( post_url('http://restapi.amap.com/v3/geocode/regeo?location='.$location.'&output=JSON&key='.$CI->config->item('geocoder_webkey')), true);
	$province = $geocode['regeocode']['addressComponent']['province'];
	$city = $geocode['regeocode']['addressComponent']['city'];
	
	if($province || $city){
		//匹配本地地址库
		$cnAreaList = trim(file_get_contents(APPPATH."../style/js/cnarealist.js"));
		$cnAreaList = substr($cnAreaList, strpos($cnAreaList, '{'), -1);
		$cnAreaList = json_decode($cnAreaList, true);
		foreach($cnAreaList['parent'] as $v){
			if(strpos($province, $v['name']) !== false || strpos($v['name'], $province) !== false){
				$province = $v['name'];
			}
			foreach($v['child'] as $vv){
				if(strpos($city, $vv['name']) !== false || strpos($vv['name'], $city) !== false){
					$city = $vv['name'];
				}
			}
		}
	}
	return array(
		$province,
		$city
	);
}

 // 翻訳
 function translate($data){
    $language=$_SESSION['language']?:2;
    $chinese=explode("\n",file_get_contents("./chinese.txt"));
    $japanese=explode("\n",file_get_contents("./japanese.txt"));
    if(is_array($data)){
        foreach($data as $k=>$v){
            $data[$k]=translate($v);
        }
    }elseif(is_object($data)){
        foreach($data as $k=>$v){
            $data->$k=translate($v);
        }
	}
	else{
        $key='';
        if($language==1){ // 日本語→中国語
            foreach($japanese as $k=>$v){
                if($v==strval($data)){
                    $key=$k;
                    break;
                }
            }
            if(is_numeric($key)) $data=$chinese[$key];
		}elseif(is_string($data)){ // 中国語→日本語
            foreach($chinese as $k=>$v){
                if(strcmp(get_certain_string( $chinese[$k]), get_certain_string($data)) == 0){
					$key=$k;
                    break;
                }
            }
            if(is_numeric($key)) $data=get_certain_string($japanese[$key]);
        }
    }
    return $data;
}
function get_certain_string($string) {
	return strip_tags(trim(preg_replace('/\s+/', ' ', $string)));
}
function array_col2row($arr){
	$result = array();
	if(!$arr)return $result;
	$keys = array_keys($arr);
	foreach($arr[$keys[0]] as $k => $v){
		foreach($keys as $kk){
			$result[$k][$kk] = $arr[$kk][$k];
		}
	}
	return $result;
}

function array_row2col($arr, $kkey = false, $vkey = false){
	$result = array();
	if(!$arr)return $result;
	$keys = array_keys(current($arr)); 
	foreach($arr as $k => $v){
		$result[$v[$kkey ? : $keys[0]]] = $vkey ? $v[$vkey] : $v;
	}
	return $result;
}
	
function xml2array($xml){
	//将XML转为array
	$array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
	return $array_data;
}

//检查链接权限
function chkcommand($url = '', $cmds = false){
	if($cmds === false){
		$CI = &get_instance();
		$CI->load->model('command_mdl');
		$cmds = (array)$CI->command_mdl->get_role_command($CI->session->userdata('gid'));
	}
	$url = strtolower(trim($url, '/'));
	foreach($cmds as $v){
		$link_path = strtolower(trim($v['link_page'], '/'));
		if($url == $link_path)return true;
	}
	return false;
}

function enbase64($destr){
	return trim(str_replace(array('+', '=', "\r", "\n"), '', base64_encode(urlencode($destr))));
}

function debase64($enstr){
	return urldecode(base64_decode($enstr));
}

function formattime($time, $format = 'Y-m-d H:i:s', $default = '-'){
	if(empty($time))return $default;
	if(is_numeric($time))return date($format, $time);
	return strtotime($time);
}

function formatnumber($number, $decimals = 2){
	return str_replace(',', '', number_format(floatval($number), $decimals));
}

function mobile2star($mobile){
	$result = substr($mobile, 0, 2);
	$result = str_pad($result, rand(5, 9), '*');
	$result .= substr($mobile, strlen($result), rand(2, 3));
	return str_pad($result, 11, '*');
}

function qrcode($url, $filename = false)
{
	include APPPATH."libraries/phpqrcode.php";
	if($filename === false)ob_clean();//这个一定要加上，清除缓冲区  
	return QRcode::png($url,$filename,'H','8',2);
}

function multi_array_sort($multi_array, $sort_key, $sort = SORT_DESC)
{
    if (is_array($multi_array)) {
        foreach ($multi_array as $row_array) {
            if (is_array($row_array)) {
                $key_array[] = $row_array[$sort_key];
            } else {
                return false;
            }
        }
    } else {
        return false;
    }
    array_multisort($key_array, $sort, $multi_array);
    return $multi_array;
}

function multi_array_unique($multi_array, $key = 'id'){
	$multi_array = array_row2col($multi_array, $key);	
	return array_values($multi_array);
}

function array_urlencode($data, $enkey = true){
    $new_data = array();
    foreach($data as $key => $val){
        // 这里我对键也进行了urlencode
		$newkey = $enkey ? urlencode($key) : $key;
        $new_data[$newkey] = is_array($val) ? array_urlencode($val, $enkey) : urlencode($val);
    }
    return $new_data;
}

function urlparam($url, $param){
	foreach($param as $k => $v){
		if(is_array($v)){
			$vv = current($v);
			if(strlen($vv))$url .= (strpos($url, '?') === false ? '?' : '&') . key($v) . '=' . urlencode($vv);	
		}else{
			if(strlen($v))$url .= (strpos($url, '?') === false ? '?' : '&') . $k . '=' . urlencode($v);	
		}
	}
	return $url;
}

function array_urldecode($data, $dekey = true){
    $new_data = array();
    foreach($data as $key => $val){
        // 这里我对键也进行了urlencode
		$newkey = $dekey ? urldecode($key) : $key;
        $new_data[$newkey] = is_array($val) ? array_urldecode($val, $enkey) : urldecode($val);
    }
    return $new_data;
}

function getarr4key($arr, $key, $chr = ','){
	if($chr === false)$arr = json_decode($arr, true);
	if(!is_array($arr))$arr = explode($chr, $arr);
	return $arr[$key];	
}

function split2array($str, $chr = false){
	if(empty($str))return array();
	if($chr !== false)return array_filter(explode($chr, $str));
	$chr = ',';
	$str = str_replace(' ', $chr, $str);
	$str = str_replace(',,', ',', $str);
	if(empty($str))return array();
	return array_values(array_filter(explode($chr, $str)));
}

function object2array($object){
	return json_decode(json_encode($object), true);
}

function checknull($varname, $defalut1 = '', $defalut2 = ''){
	if(is_null($varname))return is_null($defalut1) ? (is_null($defalut2) ? '' : $defalut2) : $defalut1;
	return $varname;
}

function arraysum($arr, $key1, $key2 = false){
	if(!is_array($arr) || empty($arr))return 0;
	$result = 0;
	foreach($arr as $k => $v){
		if($key2 !== false){
			$result += floatval($v[$key1][$key2]);
		}else{
			$result += floatval($v[$key1]);
		}
	}
	return $result;
}
function ali_sms($phone,$TemplateCode,$config,$param='code',$value='1234'){
    include APPPATH.'libraries/aliyun-dysms-php-sdk-lite/SignatureHelper.php';
    $params = array ();
    $accessKeyId = $config['aliyun_sms_key'];//$this->config->item('aliyun_sms_key');
    $accessKeySecret = $config['aliyun_sms_secret'];//$this->config->item('aliyun_sms_secret');
    // fixme 必填: 短信接收号码
    $params["PhoneNumbers"] = $phone;

    // fixme 必填: 短信签名，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
    $params["SignName"] = "唯一陪护床";

    // fixme 必填: 短信模板Code，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
    $params["TemplateCode"] = $TemplateCode;

    // fixme 可选: 设置模板参数, 假如模板中存在变量需要替换则为必填项
    $params['TemplateParam'] = Array (
        "$param" => $value
    );

    // fixme 可选: 设置发送短信流水号
    //$params['OutId'] = "12345";

    // fixme 可选: 上行短信扩展码, 扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段
    //$params['SmsUpExtendCode'] = "1234567";


    // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
    if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
        $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
    }

    // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
    $helper = new \Aliyun\DySDKLite\SignatureHelper();

    // 此处可能会抛出异常，注意catch
    $content = $helper->request(
        $accessKeyId,
        $accessKeySecret,
        "dysmsapi.aliyuncs.com",
        array_merge($params, array(
            "RegionId" => "cn-hangzhou",
            "Action" => "SendSms",
            "Version" => "2017-05-25",
        ))
    );
    if($content && $content->Code == 'OK'){
        return true;
    }else{
        return false;
    }
}

function check_image_type($image){
	$bits = array(
		'jpg' => "\xFF\xD8\xFF",
		'gif' => "GIF",
		'png' => "\x89\x50\x4e\x47\x0d\x0a\x1a\x0a",
	);
	foreach ($bits as $type => $bit) {
		if (substr($image, 0, strlen($bit)) === $bit) {
			return $type;
		}
	}
	return false;
}

function get_week_block($sdefaultDate = false, $first = 1){
	//当前日期    
	//$first =1 表示每周星期一为开始日期 0表示每周日为开始日期  
 	if(!$sdefaultDate)$sdefaultDate = time();
	if(is_numeric($sdefaultDate))$sdefaultDate = date('Y-m-d', $sdefaultDate);
	//获取当前周的第几天 周日是 0 周一到周六是 1 - 6  
	$w=date('w', strtotime($sdefaultDate));  
	//获取本周开始日期，如果$w是0，则表示周日，减去 6 天  
	$week_start=date('Y-m-d',strtotime("$sdefaultDate -".($w ? $w - $first : 6).' days'));  
	//本周结束日期  
	$week_end=date('Y-m-d',strtotime("$week_start +6 days"));
	
	return array(strtotime($week_start.' 00:00:00'), strtotime($week_end.' 23:59:59'));
}

function get_month_block($sdefaultDate = false){
 	if(!$sdefaultDate)$sdefaultDate = time();
	return array(strtotime(date('Y-m-1 0:0:0', $sdefaultDate)), strtotime(date('Y-m-'.date('t', $sdefaultDate).' 23:59:59', $sdefaultDate)));
}

function get_time_block($type = 'sToday'){
	switch ($type) {
		case 'sToday': //本日开始时间
			return mktime(0, 0, 0, date('m'), date('d'), date('Y'));
			break;
		case 'eToday': //本日结束时间
			return mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')) - 1;
			break;
		case 'sYesterday': //昨日开始时间
			return mktime(0, 0, 0, date('m'), date('d') - 1, date('Y'));
			break;
		case 'eYesterday': //昨日结束时间
			return mktime(0, 0, 0, date('m'), date('d'), date('Y')) - 1;
			break;
		case 'sWeek': //本周开始时间
			return mktime(0, 0, 0, date('m'), date('d') - date('w') + 1, date('Y'));
			break;
		case 'eWeek': //本周结束时间
			return mktime(23, 59, 59, date('m'), date('d') - date('w') + 7, date('Y'));
			break;
		case 'spWeek': //上周开始时间
			return mktime(0, 0, 0, date('m'), date('d') - date('w') + 1 - 7, date('Y'));
			break;
		case 'epWeek': //上周结束时间
			return mktime(23, 59, 59, date('m'), date('d') - date('w') + 7 - 7, date('Y'));
			break;
		case 'sMonth': //本月开始时间
			return mktime(0, 0, 0, date('m'), 1, date('Y'));
			break;
		case 'eMonth': //本月结束时间
			return mktime(23, 59, 59, date('m'), date('t'), date('Y'));
			break;
		case 'spMonth': //上月开始时间
			return mktime(0, 0, 0, date('m') - 1, 1, date('Y'));
			break;
		case 'epMonth': //上月结束时间
			return strtotime(date('Y-m-t 23:59:59', strtotime('-1 month')));
			break;
		case 'sYear': //今年开始时间
			return strtotime(date('Y-01-01 00:00:00'));
			break;
		case 'eYear': //今年结束时间
			return strtotime(date('Y-12-30 23:59:59'));
			break;
		case 'spYear': //去年开始时间
			return strtotime(date('Y-01-01 00:00:00', strtotime('-1 year')));
			break;
		case 'epYear': //去年结束时间
			return strtotime(date('Y-12-30 23:59:59', strtotime('-1 year')));
			break;
	}
}

/*
$url 请求地址
$post POST参数
$files 上传文件数组,相对路径
*/
function post_url($url, $post = '', $header = '',$files = '', $host = '', $referrer = '', $cookie = '', $proxy = -1, $sock = false, $useragent = 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1)'){
	if(empty($post) && empty($files) && empty($host) && empty($referrer) && empty($cookie) && ($proxy == -1 || empty($proxy)) && empty($useragent))return @file_get_contents($url);
	$method = empty($post) && empty($files) ? 'GET' : 'POST';
	if($post && is_array($post)){
		if(count($post) != count($post, 1))$post = http_build_query($post);
	}
	
	if(function_exists('curl_init')){
		$ch = @curl_init();
		@curl_setopt($ch, CURLOPT_URL, $url);
		if($proxy != -1 && !empty($proxy))@curl_setopt($ch, CURLOPT_PROXY, 'http://'.$proxy);
		@curl_setopt($ch, CURLOPT_REFERER, $referrer);
		@curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
		@curl_setopt($ch, CURLOPT_COOKIE, $cookie); 
		@curl_setopt($ch, CURLOPT_COOKIEJAR, COOKIE_FILE_PATH);
		@curl_setopt($ch, CURLOPT_COOKIEFILE, COOKIE_FILE_PATH);
		@curl_setopt($ch, CURLOPT_HEADER, 0);
        @curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		@curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		@curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		@curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		@curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		@curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);

		if ($method == 'POST') {
			@curl_setopt($ch, CURLOPT_POST, 1);			
			//处理文件上传
			if($files){
				if(!$post)$post = array();
				foreach($files as $k => $v){
					if (class_exists('CURLFile')) {
						$post[$k] = new CURLFile(realpath($v));
					} else {
						$post[$k] = '@'.realpath($v);
					}
				}
			}
			@curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		}

		$result = @curl_exec($ch);
		@curl_close($ch);
	}
	
	if($post && is_array($post))$post = http_build_query($post);
	if($result === false && function_exists('file_get_contents')){
		$urls = parse_url($url);
		if(empty($host))$host = $urls['host'];
		$httpheader = $method." ".$url." HTTP/1.1\r\n";   
		$httpheader .= "Accept: */*\r\n";   
		$httpheader .= "Accept-Language: zh-cn\r\n";   
		$httpheader .= "Referer: ".$referrer."\r\n";   
		if($method == 'POST')$httpheader .= "Content-Type: application/x-www-form-urlencoded\r\n";   
		$httpheader .= "User-Agent: ".$useragent."\r\n";   
		$httpheader .= "Host: ".$host."\r\n";   
		if($method == 'POST')$httpheader .= "Content-Length: ".strlen($post)."\r\n";   
		$httpheader .= "Connection: Keep-Alive\r\n";   
		$httpheader .= "Cookie: ".$cookie."\r\n";   
		
		$opts = array(
		   'http'=>array(
				'method'=>$method,
				'header'=>$httpheader,
				'timeout' => 60,
				'content'=> ($method == 'POST' ? $post : '')
		   )
		 );			
		if($proxy != -1 && !empty($proxy)){
			$opts['http']['proxy'] = 'tcp://'.$proxy;
			$opts['http']['request_fulluri'] = true;
		}
		$context = @stream_context_create($opts);
		$result = @file_get_contents($url, 'r', $context);
	}
	
	if($sock && $result === false && function_exists('fsockopen')){
		$urls = parse_url($url);
		if(empty($host))$host = $urls['host'];
		$port = empty($urls['port']) ? 80 : $urls['port'];
		
		$httpheader = $method." ".$url." HTTP/1.1\r\n";   
		$httpheader .= "Accept: */*\r\n";   
		$httpheader .= "Accept-Language: zh-cn\r\n";   
		$httpheader .= "Referer: ".$referrer."\r\n";   
		if($method == 'POST')$httpheader .= "Content-Type: application/x-www-form-urlencoded\r\n";   
		$httpheader .= "User-Agent: ".$useragent."\r\n";   
		$httpheader .= "Host: ".$host."\r\n";   
		if($method == 'POST')$httpheader .= "Content-Length: ".strlen($post)."\r\n";   
		$httpheader .= "Connection: Keep-Alive\r\n";   
		$httpheader .= "Cookie: ".$cookie."\r\n";   
		$httpheader .= "\r\n";   
		if($method == 'POST')$httpheader .= $post; 
		$fd = false;
		if($proxy != -1 && !empty($proxy)){
			$proxys = explode(':', $proxy);
			$fd = @fsockopen($proxys[0], $proxys[1]);
		}else{
			$fd = @fsockopen($host, $port);   
		}
		@fwrite($fd, $httpheader);
		@stream_set_timeout($fd, 60);
		$result = '';   
		while(!@feof($fd)){   
			$result .= @fread($fd, 8192);   
		}   
		@fclose($fd);   
	}
	
	return $result;
}

/**
 * 日本円の場合の金額表記
 * 
 * @param $price 金額
 */
function displayPrice($price)
{
	$language = $_SESSION['language']? : 2;
	$dispPrice = $price;

	if(is_numeric($price)){
		// 日本語の場合、整数表示
		if($language != 1){
			$dispPrice = number_format($price, 0);
		}else{
			$dispPrice = number_format($price, 2);
		}
	}

	return $dispPrice;
}

?>