<?php
require_once __DIR__."/gfun.php";
require_once __DIR__."/request.php";
class Monitor
{
	static function index($data,$clientInfo){
		if(strlen($data)>10&&ord($data[0])==58&&ord($data[1])==163&&ord($data[2])==0&&ord($data[3])==0&&ord($data[4])==0){//判断是否机器命令
			$addrlength=gfun::getaddrlength($data);
			$macno=gfun::getmacno($data);
			//保存连接信息到redis
			$redis_mac=array("ip"=>$clientInfo['address'],"port"=>$clientInfo['port'],"lastbeat"=>time());
	        gfun::set_redis($macno.":COM",json_encode($redis_mac));
			if(ord($data[$addrlength+8])==9){//机器主动指令
				if(ord($data[$addrlength+9])==1){//登录01
					$command=self::logon($data,$clientInfo);
					return $command;
				}
				if(ord($data[$addrlength+9])==2){//心跳02
					$command=self::jump($data,$clientInfo);
					return $command;
				}
				if(ord($data[$addrlength+9])==3){//上传二维码数据03
					$post['macno'] = $macno;
					$post['ctime'] = hexdec(bin2hex(substr($data,$addrlength+10,4)));//时间 整型
					$post['index'] = hexdec(bin2hex(substr($data,$addrlength+14,2)));//序号
					$len = ord($data[$addrlength+17]);
					$post['qrcode'] = substr($data,$addrlength+18,$len);//二维码内容

					if(!defined('BASEPATH')) define('BASEPATH', __DIR__);
					include dirname(__DIR__)."/app/config/config.php";
					request::post3(substr($config['base_url'],7),"/macback/qrcode",http_build_query($post));//异步发POST，不阻塞等待接收

					echo json_encode($post).PHP_EOL;
					$command=gfun::getprecom($data)."0003090300";
					return $command.gfun::getcrc16($command);
				}
				if(ord($data[$addrlength+9])==208){//联机交易D0
					$addrlength=gfun::getaddrlength($data);
					$post['macno']=gfun::getmacno($data);
					$post['status']=ord($data[$addrlength+10]);//交易结果:0：交易成功，表示已接收到命令并正确处理；1：交易失败，重复交易流水，不需重发相同系统交易流水；2：交易失败，设备正处于交易状态;3：交易失败，设备故障;16:设置失败，指令错误
					$post['sysnum']=hexdec(bin2hex(substr($data,$addrlength+11,4)));
					$post["macnum"]=hexdec(bin2hex(substr($data,$addrlength+15,4)));
					gfun::set_redis($post['macno'].":09D0",json_encode($post));
					return;
				}
				if(ord($data[$addrlength+9])==209){//停止设备D1
					$addrlength=gfun::getaddrlength($data);
					$post['macno']=gfun::getmacno($data);
					$post['ctime']=time();
					$post['status']=ord($data[$addrlength+10]);//交易结果:0：清空交易成功，表示已接收到命令并正确处理；3：清空交易失败，设备故障;16:设置失败，指令错误
					$post['remain']=hexdec(bin2hec(substr($data,$addrlength+11,2)));//剩余使用次数
					gfun::set_redis($post['macno'].":09D1",json_encode($post));
					return;
				}
			}else{//机器应答指令
				$addrlength=gfun::getaddrlength($data);
				$macno=gfun::getmacno($data);
				$content='机器指令应答';
				$com=strtoupper(bin2hex(substr($data,$addrlength+8,2)));
				switch($com){
					case "8005"://设置参数
					case "8085"://读取参数
                        $save['result']=ord($data[$addrlength+10]);
                        $save['rate']=hexdec(bin2hex(substr($data,$addrlength+11,4)));//波特率
                        $save['macType']=ord($data[$addrlength+15]);//设备类型
						break;
					case "8000"://读取设备状态
                        $save['result']=ord($data[$addrlength+10]);
						$save["status"]=ord($data[$addrlength+13]);//设备状态:0【设备空闲状态】;1【设备使用状态】;2【设备异常状态】
						$save["macType"]=ord($data[$addrlength+14]);//设备类型
						$save["isClosed"]=ord($data[$addrlength+15]);//设备开机状态:0x00开机，0x01关机
						$save["usedTimes"]=hexdec(bin2hex(substr($data,$addrlength+16,2)));//使用次数
						$save["error"]=ord($data[$addrlength+18]);//错误码
						break;
					case "8006"://设置参数
					case "8086"://读取参数
					case "8007"://设置参数
					case "8087"://读取参数
					case "8008"://设置参数
					case "8088"://读取参数
                        $save['result']=ord($data[$addrlength+10]);
                        $len = ord($data[$addrlength+12]);
                        $save['value']=substr($data,$addrlength+13,$len);
						break;
                }
                gfun::set_redis($macno.":".$com,json_encode(array("ctime"=>time(),"data"=>$save)));
				if(!empty($command)) return $command.gfun::getcrc16($command);
			}
		}else{
			//initiative::saveothercommand($data,$clientInfo["address"],$clientInfo["port"],0,"其他指令");
			return gfun::strtohex("Received:".$data);
		}
	}
	
	static function logon($data,$clientInfo){//登录
		$command=gfun::getprecom($data)."0003090100";
		return $command.gfun::getcrc16($command);
	}
	static function jump($data,$clientInfo){//心跳
		self::updaterealbeat($data,$clientInfo);
		$command=gfun::getprecom($data)."000B090201".gfun::gettime(time());
		return $command.gfun::getcrc16($command);
	}
	static function updaterealbeat($data,$clientInfo){//心跳信息新接口
		$addrlength=gfun::getaddrlength($data);
		$macno=gfun::getmacno($data);
		$post["macno"]=$macno;
		$post["status"]=ord($data[$addrlength+13]);//设备状态:0【设备空闲状态】;1【设备使用状态】;2【设备异常状态】
		$post["macType"]=ord($data[$addrlength+14]);//设备类型
		$post["isClosed"]=ord($data[$addrlength+15]);//设备开机状态:0x00开机，0x01关机
		$post["usedTimes"]=hexdec(bin2hex(substr($data,$addrlength+16,2)));//使用次数
		$post["error"]=ord($data[$addrlength+18]);//错误码

		if(!defined('BASEPATH')) define('BASEPATH', __DIR__);
		include dirname(__DIR__)."/app/config/config.php";
		request::post2($config['base_url']."/macback/beat",http_build_query($post));//异步发POST，不阻塞等待接收
			
	}
}