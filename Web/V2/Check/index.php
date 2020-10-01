<?php



// require_once 'lotusphp_runtime/Lotus.php';
require_once 'function.inc.php';
require_once 'AopSdk.php';
require_once 'HttpRequst.php';
require_once 'config.php';
require_once 'UserInfo.php';
require_once 'PushMsg.php';

header ( "Content-type: text/html; charset=utf-8" );
/**
 * 此文件是手机支付宝钱包访问商户网站的wap页面。商户的业务处理可以在本文件中处理。
 * 此文件的访问URL，请填入支付宝服务窗后台的菜单设置中，点击服务窗菜单即可访问到本文件。
 */

// 日志记录下受到的请求
writeLog ( "POST: " . var_export ( $_POST, true ) );
writeLog ( "GET: " . var_export ( $_GET, true ) );
?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>支付宝手机网页</title>
<meta name="viewport"
	content="width=device-width, initial-scale=1.0, user-scalable=yes" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<!-- <a href="wap.php?param=msg">发送消息</a><br></br> -->
	<a  target="_blank" href="index.php?param=qr">生成二维码</a>
	<br> <a target="_blank" href="index.php?param=follow">获取关注列表</a> 
	<br> <a target="_blank"	href="index.php?param=gis">获取地理位置</a>
<?php
$auth_code=  HttpRequest::getRequest ( "auth_code" );
if (! empty ( $auth_code )) {
	require_once 'UserInfo.php';
	
	$userinfo = new UserInfo ();
	$userinfo->getUserInfo ( $auth_code );
}

// if (HttpRequest::getRequest ( "param" ) == "msg"){
// 	$push = new PushMsg ();
// 	$image_text_msg1 = $push->mkImageTextMsg ( "标题，发消息测试", "描述：发消息测试", "http://wap.taobao.com", "", "loginAuth" );
// 	$image_text_msg = array (
// 			$image_text_msg1
// 	);
// 	require_once 'Message.php';
// 	$biz_content = HttpRequest::getRequest ( "biz_content" );
// 	echo "biz_conteng:".$biz_content;
// 	exit();
// 	$msg=new Message($biz_content);
// 	$FromUserId = $msg->getNode ( $biz_content, "FromUserId" );
		
// 	// 发给这个关注的用户
// 	$biz_content = $push->mkImageTextBizContent ( $FromUserId, $image_text_msg );
		
// 	$return_msg = $push->sendMsgRequest ( $biz_content );
// 	// 日志记录
// 	writeLog ( $return_msg );
// }

//带参推广二维码
//https://fuwu.alipay.com/platform/doc.htm#c0701
if (HttpRequest::getRequest ( "param" ) == "qr") {
	$qr_biz = array (
			'codeInfo' => array (
					'scene' => array (
							'sceneId' => '1234' 
					) 
			),
			'codeType' => 'TEMP',
			'expireSecond' => '1800',
			'showLogo' => 'N' 
	);
	$qr_biz = json_encode ( $qr_biz );
	// echo $qr_biz;
	
	$request = new AlipayMobilePublicQrcodeCreateRequest ();
	$request->setBizContent ( $qr_biz );
	
	
	
	$result = aopclient_request_execute($request);
	
	var_dump($result);
	if ($result->alipay_mobile_public_qrcode_create_response->code == 200) {
		$qr_img_url = $result->alipay_mobile_public_qrcode_create_response->code_img;
		writeLog ( "返回的二维码地址：" . $qr_img_url );
		echo $qr_img_url;
		echo "<img src='$qr_img_url'/>";
	}
}

//获取关注者列表
//https://fuwu.alipay.com/platform/doc.htm#c0501
if (HttpRequest::getRequest ( "param" ) == "follow") {
	$biz_content = "{\"nextUserId\":\"\"}";
	
	$request = new AlipayMobilePublicFollowListRequest ();
	$request->setBizContent ( $biz_content );
	
	$result = aopclient_request_execute($request);
	// var_dump($result);
	
	if ($result != null && $result->alipay_mobile_public_follow_list_response->code == 200) {
		$list = $result->alipay_mobile_public_follow_list_response->data->user_id_list->string;
		print_r ( $list );
	}
}

//获取用户地理位置
//https://fuwu.alipay.com/platform/doc.htm#c0502
if (HttpRequest::getRequest ( "param" ) == "gis") {
	$userid = "BM7PjM8f8-v6VFqeTlFUqo97w0QKRHRl-OmymTOxsGHnKDWiwQekMHiEi06tEbjg01";
	$biz_content = "{\"userId\":\"$userid\"}";
	
	$request = new AlipayMobilePublicGisGetRequest ();
	$request->setBizContent ( $biz_content );
	
	$result = aopclient_request_execute($request);
	// var_dump($result);
	
	if ($result != null && $result->alipay_mobile_public_gis_get_response->code == 200) {
		
		// 精确度
		$accuracy = $result->alipay_mobile_public_gis_get_response->accuracy;
		// 城市
		$city = $result->alipay_mobile_public_gis_get_response->city;
		// 纬度
		$latitude = $result->alipay_mobile_public_gis_get_response->latitude;
		// 经度
		$longitude = $result->alipay_mobile_public_gis_get_response->longitude;
		// 省份
		$province = $result->alipay_mobile_public_gis_get_response->province;
		
		echo $province ." " .$city;
	}
}

?>






</body>
</html>
