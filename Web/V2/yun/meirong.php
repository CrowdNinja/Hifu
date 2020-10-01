<?php
require_once __DIR__.'/redisreal.php';
require_once __DIR__.'/gfun.php';

if(!defined('BASEPATH')) define('BASEPATH', __DIR__);
include dirname(__DIR__)."/app/config/config.php";
$server = new swoole_server("0.0.0.0", $config['port'], SWOOLE_PROCESS, SWOOLE_SOCK_UDP);
$server->set(array('worker_num' => 4,'daemonize' => 1,'log_file' => __DIR__.'/redisyun.log'));
//UDP监听数据发送事件
$server->on('Packet', function ($serv, $data, $clientInfo){
	$msg=$clientInfo['server_socket'].date("---Y-m-d H:i:s",time())."----".$clientInfo['address']."|".$clientInfo['port']."Received:".gfun::strtohex($data)."\n";
	echo $msg;
	// $macno=gfun::getmacno($data);
	// $ser=gfun::toasciistr('39.105.17.100')."00".substr("000".dechex(9508),-4);
	// $command="3AA300000006".substr("000000000000000".$macno,-16).substr("000".dechex(strlen('39.105.17.100')+5),-4)."0084".$ser;
	// echo $command;
	// $serv->sendto($clientInfo['address'], $clientInfo['port'],hex2bin($command.gfun::getcrc16($command)),$clientInfo['server_socket']);
	// return;
	$send = Monitor::index($data,$clientInfo);
	
	if(!empty($send)){
		if(is_array($send)){
			$count=1;
			foreach($send as $da){
				$msg=$clientInfo['server_socket'].date("---Y-m-d H:i:s")."----".$clientInfo['address']."|".$clientInfo['port']."Send".$count.":".$da."\n";
				echo $msg;
				$serv->sendto($clientInfo['address'], $clientInfo['port'], hex2bin($da),$clientInfo['server_socket']);
				$count++;
			}
		}
		else
		{
			$msg=$clientInfo['server_socket'].date("---Y-m-d H:i:s")."----".$clientInfo['address']."|".$clientInfo['port']."Send:".$send."\n";
			echo $msg;
			$serv->sendto($clientInfo['address'], $clientInfo['port'], hex2bin($send),$clientInfo['server_socket']);
		}
	}
});

//启动服务器
$server->start();

