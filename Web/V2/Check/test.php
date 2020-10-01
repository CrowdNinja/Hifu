<?php
require_once 'PushMsg.php';
require_once 'function.inc.php';

$push = new PushMsg ();

$FromUserId = "2088102135237921";
// $FromUserId = "BM7PjM8f8-v6VFqeTlFUqo97w0QKRHRl-OmymTOxsGHnKDWiwQekMHiEi06tEbjg01";

$image_text_msg1 = $push->mkImageTextMsg ( "标题，进入服务窗", "描述：进入服务窗", "http://wap.taobao.com", "", "loginAuth" );
// $image_text_msg2 = $push->mkImageTextMsg ( "标题", "描述", "http://wap.taobao.com", "https://i.alipayobjects.com/e/201310/1H9ctsy9oN_src.jpg", "loginAuth" );
// 组装多条图文信息
$image_text_msg = array (
		$image_text_msg1 
// $image_text_msg2
);

// 发给这个关注的用户
$biz_content = $push->mkImageTextBizContent ( $FromUserId, $image_text_msg );

echo $biz_content;
// exit();

// var_dump($biz_content);
// exit;
// $return_msg = $push->sendMsgRequest ( $biz_content );
$return_msg = $push->sendRequest ( $biz_content );
// $return_msg = $push->pushMsgRequest ( $biz_content );
var_dump($return_msg);
exit ();

$mediaId = "L21pZnMvVDE3eFFQWGdYWFhYYWdPRmJYP3Q9anBnJnhzaWc9NjEzM2EyY2EzN2YyOWVkYTQwMDdiZGQ1MzM2ZWI5OTM=122";
$fileName = realpath ( "./img" ) . "/$mediaId.$format";
$biz_content = "{\"mediaId\":\"" . $mediaId . "\"}";

$result = $push->downMediaRequest ( $biz_content, $fileName );
echo $result;		

// $xiaogui= new Xiaogui();
// $xiaogui->imgDownloadRequest("L21pZnMvVDFtR01QWGpwYVhYYWdPRmJYP3Q9anBnJnhzaWc9MmYzMTFlNWQ1MjY0MjBjMWRmYWNlYjRlNmNiNzlmZWE=467", "jpg");