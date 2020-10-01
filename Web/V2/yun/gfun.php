<?php
class gfun{
	public static function my_redis(){
		$redis = new Redis();
		$redis->connect('127.0.0.1', 6379);
		$redis->auth("Sunny*1029");
		return $redis;
	}
	public static function set_redis($key,$value){
		$redis=self::my_redis();
		$result = $redis->set($key,$value);
		return $result;
	}
	public static function get_redis($key){
		$redis=self::my_redis();
		$result = $redis->get($key);
		return $result;
	}
	public static function delete_redis($key){
		$redis=self::my_redis();
		$result = $redis->delete($key);
		return $result;
	}
	public static function push_redis($key,$value){
		$redis=self::my_redis();
		$result = $redis->rpush($key,$value);
		return $result;
	}
	public static function pop_redis($key){
		$redis=self::my_redis();
		$result = $redis->lpop($key);
		return $result;
	}
	public static function range_redis($key){
		$redis=self::my_redis();
		$result = $redis->lrange($key);
		return $result;
	}
	public static function get_total_millisecond(){//返回字符串的毫秒数时间戳 
    	$time = explode (" ", microtime () );
    	$time = $time [1] . ($time [0] * 1000);
    	$time2 = explode ( ".", $time );
    	$time = $time2 [0];
    	return $time;
    }
    public static function microtime_float(){//返回当前 Unix 时间戳和微秒数(用秒的小数表示)浮点数表示，常用来计算代码段执行时间
    	list($usec, $sec) = explode(" ", microtime());
    	return ((float)$usec + (float)$sec);
    }
    public static function get_single($data){
    	$bin=substr("0000000000000000000000000000000".decbin(hexdec(bin2hex($data))),-32);
    	$bin1=substr($bin,0,1);
    	$bin2=bindec(substr($bin,1,8))-127;
    	$bin3=substr("00000000000000000000",$bin2>0?0:$bin2).substr($bin,-23);
    	$int=bindec("1".substr($bin3,0,$bin2>=0?$bin2:0));
    	$float=0;
    	for($i=$bin2+1;$i<24;$i++){
    		$float+=intval(substr($bin3,$i,1))*pow (2,$bin2-$i);
    	}
    	echo bin2hex($data)."---".$bin."---".$bin2."|".$int.":".$float.PHP_EOL;
    	return $int+$float;
    }
	public static function getrecordsql($record,$agent,$macno,$type=0){//根据记录数据返回SQL语句
		$empno="";$empname="";$phyid="";$before=0;$occur=0;$after=0;
		if(!empty($record["empno"])) $empno=$record["empno"];
		if(!empty($record["empname"])) $empname=$record["empname"];
		if(!empty($record["cardx4"])) $phyid=$record["cardx4"];
		if(!empty($record["macno"])) $macno=$record["macno"];
		if(!empty($record["before"])) $before=$record["before"];
		if(!empty($record["occur"])) $occur=$record["occur"];
		if(!empty($record["after"])) $after=$record["after"];
		switch($type){
			case 0://520消费
				$sql="r_consume (empno,empname,phyid,macno,sdate,agent_id,befamount,occur,aftamount) values('".$empno."','".$empname."','".$phyid."','".$macno."','";
				$sql.=strtotime($record["datetime"])."','".$agent."','".($before/100.00)."','".($occur/100.00)."','".($after/100.00)."')";
				break;
			case 1://520考勤
				$sql="r_attendance (empno,empname,phyid,macno,sdate,agent_id) values('".$empno."','".$empname."','".$phyid."','".$macno."','".strtotime($record["datetime"])."','".$agent."')";
				break;
			case 2://520门禁
				$sql="r_door (empno,empname,phyid,macno,sdate,agent_id) values('".$empno."','".$empname."','".$phyid."','".$macno."','".strtotime($record["datetime"])."','".$agent."')";
				break;
			default://非注册机器
				$sql="r_invalid (empno,empname,phyid,macno,sdate,agent_id,befamount,occur,aftamount) values('".$empno."','".$empname."','".$phyid."','".$macno."','".strtotime($record["datetime"])."','".$agent."','".($before/100.00)."','".($occur/100.00)."','".($after/100.00)."')";
				break;
		}
		return $sql;
	}
	public static function getrecords($data,$rtype){//根据记录格式分析出多记录
		$addrlength=gfun::getaddrlength($data);
		$startpos=$addrlength+13;//记录开始位置
		$recordlen=ord($data[$addrlength+12]);//记录字节长度
		$recordnum=ord($data[$addrlength+11]);//记录数
		$record=null;
		for($index=0;$index<$recordnum;$index++){
			$record[]=self::getrecord(substr($data,$startpos+$recordlen*$index,$recordlen),substr($rtype,2,strlen($rtype)-4));
		}
		return $record;
	}
	public static function getrecord($data,$rtype){//根据记录格式分析出单记录
		$startpos=0;
		for($rindex=0;$rindex<strlen($rtype)/2;$rindex++){
			$fieldtype=hexdec(substr($rtype,$rindex*2,2));
			$type=gfun::getrecordchar($fieldtype);
			$rdata=substr($data,$startpos,$type["len"]);
			switch($fieldtype){
				case 3://月日时分
					$record[$type["type"]]=substr("0".hexdec(bin2hex(substr($rdata,0,1))),-2).substr("0".hexdec(bin2hex(substr($rdata,1,1))),-2).substr("0".hexdec(bin2hex(substr($rdata,2,1))),-2).substr("0".hexdec(bin2hex(substr($rdata,3,1))),-2);
					break;
				case 4:
					$record[$type["type"]]=hexdec(bin2hex($rdata));
					break;
				case 144:
				case 145:
				case 146:
				case 147:
				case 148:
				case 149:
				case 150:
				case 151:
				case 152:
				case 153:
				case 154:
				case 155:
				case 156:
				case 157:
				case 158:
				case 159:
					$record["empno"]=gfun::safeEncoding($rdata,"GB2312");
					break;
				case 160:
				case 161:
				case 162:
				case 163:
				case 164:
				case 165:
				case 166:
				case 167:
				case 168:
				case 169:
				case 170:
				case 171:
				case 172:
				case 173:
				case 174:
				case 175:
					$record["empname"]=gfun::safeEncoding($rdata,"GB2312");
					break;
				default:
					$record[$type["type"]]=hexdec(bin2hex($rdata));
					break;
			}
			$startpos+=$type["len"];
		}
		$record["datetime"]=$record["Y2"]."-".substr($record["Mdhm"],0,2)."-".substr($record["Mdhm"],2,2)." ".substr($record["Mdhm"],4,2).":".substr($record["Mdhm"],-2).":".$record["second"];
		return $record;
	}
	public static function getmacno($data){//取机号
		$addrlength=gfun::getaddrlength($data);
		$macno=substr(gfun::strtohex($data),12,$addrlength*2);
		if($addrlength<5) $macno=hexdec($macno);
		return $macno;
	}
	public static function getprecom($data){//取命令前置固定字节
		$addrlength=gfun::getaddrlength($data);
		$command=substr(gfun::strtohex($data),0,($addrlength+6)*2);
		return $command;
	}
	public static function getchildchar($data,$start,$length){//取命令数据中子数组
		$addrlength=gfun::getaddrlength($data);
		return substr(gfun::strtohex($data),($addrlength+10+$start)*2,$length*2);
	}
	public static function getaddrlength($data){
		if(ord($data[5])==1||ord($data[5])==4||ord($data[5])==5||ord($data[5])==6||ord($data[5])==7||ord($data[5])==255)
			return 8;
		if(ord($data[5])==3)
			return 4;
		if(ord($data[5])==254)
			return 5;
		return 2;
	}
	public static function strtohex($string){//字符串转十六进制
		$hex=bin2hex($string);
		$hex=strtoupper($hex);
		return $hex;
	}
	public static function hextostr($hex){//十六进制转字符串
		$string=hex2bin($hex);
		return $string;
	}
	public static function getcrc16($Source){
		$crc = 0xA1EC;          // initial value
		$polynomial = 0x1021;   // 0001 0000 0010 0001  (0, 5, 12) 
		$tmp = "";
		$bytes = array();
		for ($i = 0; $i < strlen($Source) - 1; $i++)
		{
			if ($i % 2 == 0)
			{
				$tmp = substr($Source,$i, 2);
				$bytes[$i / 2] = hexdec($tmp);
			}
		}
		foreach ($bytes as $b)
		{
			for ($i = 0; $i < 8; $i++)
			{
				$bit = (($b >> (7 - $i) & 1) == 1);
				$c15 = (($crc >> 15 & 1) == 1);
				$crc <<= 1;
				if ($c15 ^ $bit) $crc ^= $polynomial;
			}
		}
		$crc &= 0xffff;
		$strDest = $crc;
		return strtoupper(substr("000".dechex($strDest),-4));
	}
	public static function gettime($itime=0){
		if(empty($itme)) $itme=time();
		$dt = date("Y-m-d H:i:s",$itime);
		$time = substr("0".dechex(substr($dt,0,4)),-4);
		$time.= substr("0".dechex(substr($dt,5,2)),-2);
		$time.= substr("0".dechex(substr($dt,8,2)),-2);
		$time.= substr("0".dechex(substr($dt,11,2)),-2);
		$time.= substr("0".dechex(substr($dt,14,2)),-2);
		$time.= substr("0".dechex(substr($dt,17,2)),-2);
		$time.=substr("0".dechex(date("N")),-2);
		return strtoupper($time);
	}
	public static function toasciistr($data){
		$ret="";
		for($i=0;$i<strlen($data);$i++){
			$ret.=substr("0".dechex(ord($data[$i])),-2);
		}
		return $ret;
	}
	public static function getweather($ip){//根据IP返回天气
		$url="http://ip.taobao.com/service/getIpInfo.php?ip=".$ip;
		$ip=json_decode(file_get_contents($url));	
		if((string)$ip->code=='1'){
		   return false;
	 	}
	 	$city = $ip->data->city;
		$city = str_split($city,strlen($city)-3);
		$city =$city[0];
		$cityUrl = "http://evenle.com/wei/20130921/city.php";
		$web=json_decode(file_get_contents($cityUrl));
		$arr=array();
		foreach($web as $k=>$w){
			if(is_object($w)) $arr[$k]=json_to_array($w); //判断类型是不是object
			else $arr[$k]=$w;
		}
		$url="http://www.weather.com.cn/data/cityinfo/".$arr[$city].".html";
		$weather=json_decode(file_get_contents($url));
		return $weather;
	}
	public static function safeEncoding($string, $outEncoding = 'UTF-8') {
		$encoding = "UTF-8";
		for ($i = 0; $i < strlen($string); $i++) {
			if (ord($string{$i}) < 128)
				continue;


			if ((ord($string{$i}) & 224) == 224) {
				$char = $string{++$i};
				if ((ord($char) & 128) == 128) {
					$char = $string{++$i};
					if ((ord($char) & 128) == 128) {
						 $encoding = "UTF-8";
						break;
					}
				}
			}

			if ((ord($string{$i}) & 192) == 192) {
				$char = $string{++$i};
				if ((ord($char) & 128) == 128) {
					$encoding = "GB2312";
					break;
				}
			}
		}

		if (strtoupper($encoding) == strtoupper($outEncoding)){
			return $string;
		} else {
			return iconv($encoding, $outEncoding, $string);
		}
	}
	public static function getrecordchar($type){//根据16进制格式返回字符和长度
		$ret=null;
		switch ($type){
			case 1://返回1字节年数据（16进制码）
				$ret["len"] = 1;
				$ret["type"] = "Y1";
				break;
            case 2://返回2字节年数据（16进制码）
				$ret["len"]= 2;
				$ret["type"] = "Y2";
				break;
			case 3://返回4字节mdhm‘月日时分’时间数据（16进制码）
				$ret["len"]= 4;
				$ret["type"] = "Mdhm";
				break;
			case 4://返回1字节秒数据（16进制码）
				$ret["len"]= 1;
				$ret["type"] = "second";
				break;
			case 6://返回1字节秒数据（16进制码）
				$ret["len"]= 1;
				$ret["type"] = "result";
				break;
			case 18://交易状态(1字节)	0x00：表示正常刷卡记录	0x13：表示灰记录
				$ret["len"]= 1;
				$ret["type"] = "status";
				break;
			case 19://交易类型（1字节）0x01：消费；0x02：充值；0x03：联机交易；0x04：记账交易，0x05：表示消费撤销0x06:充值撤销，0x07:清零补贴， 0x08：累加补贴， 0x09:订餐记录，0x0A:验餐
				$ret["len"]= 1;
				$ret["type"] = "dealtype";
				break;
			case 20://交易前余额(4字节，整形数字，高字节在前)
				$ret["len"]= 4;
				$ret["type"] = "before";
				break;
			case 21://交易后余额(4字节，整形数字，高字节在前)
				$ret["len"]= 4;
				$ret["type"] = "after";
				break;
			case 22://交易金额(4字节，整形数字，高字节在前)
				$ret["len"]= 4;
				$ret["type"] = "occur";
				break;
			case 23://终端机交易流水号(4字节，整形数字)
				$ret["len"]= 4;
				$ret["type"] = "mdno";
				break;
			case 24://企业代码(4字节，整形数字)
				$ret["len"]= 2;
				$ret["type"] = "companyno";
				break;
			case 25://卡交易序号(4字节，整形数字)
				$ret["len"]= 4;
				$ret["type"] = "cdno";
				break;
			case 26://自动补贴批次（2字节，整数0-65535）高字节在前，低字节在后
				$ret["len"]= 4;
				$ret["type"] = "auto";
				break;
            case 27://钱包类型(1字节) 0x01：有限余额；0x02：不限余额  0x11：有限次；0x12：不限次
				$ret["len"]= 1;
				$ret["type"] = "bagtype";
				break;
            case 28://操作员卡号或编号（4字节）
				$ret["len"]= 4;
				$ret["type"] = "opcard";
				break;
            case 29://存读卡模式(1字节)  0x00:读卡物理序列号  0x01：读卡逻辑卡号
				$ret["len"]= 1;
				$ret["type"] = "readtype";
				break;
            case 30://记录的读卡器标识（1个字节），表示读卡器编号。=0x01：内部读卡器第1读头；	=0x02：内部读卡器第2读头；	=0x81：外接第1读头。	=0x82：外接第2读头。
				$ret["len"]= 1;
				$ret["type"] = "reader";
				break;
            case 32://补贴钱包交易前余额(4个字节，HEX码，高字节在前)
				$ret["len"]= 4;
				$ret["type"] = "bag2bef";
				break;
            case 33://补贴钱包交易后余额(4个字节，HEX码，高字节在前)
				$ret["len"]= 4;
				$ret["type"] = "bag2aft";
				break;
            case 130://0x82—0x85,0x88:	返回16进制卡号长度(2—5,8字节)。
				$ret["len"]= 2;
				$ret["type"] = "cardx2";
				break;
            case 131://0x82—0x85,0x88:	返回16进制卡号长度(2—5,8字节)。
				$ret["len"]= 3;
				$ret["type"] = "cardx3";
				break;
            case 132://0x82—0x85,0x88:	返回16进制卡号长度(2—5,8字节)。
				$ret["len"]= 4;
				$ret["type"] = "cardx4";
				break;
            case 133://0x82—0x85,0x88:	返回16进制卡号长度(2—5,8字节)。
				$ret["len"]= 5;
				$ret["type"] = "cardx5";
				break;
            case 136://0x82—0x85,0x88:	返回16进制卡号长度(2—5,8字节)。
				$ret["len"]= 8;
				$ret["type"] = "cardx8";
				break;
            case 144://返回工号(长度1—16字节)。
				$ret["len"]= 1;
				$ret["type"] = "empid01";
				break;
            case 145://返回工号(长度1—16字节)。
				$ret["len"]= 2;
				$ret["type"] = "empid02";
				break;
            case 146://返回工号(长度1—16字节)。
				$ret["len"]= 3;
				$ret["type"] = "empid03";
				break;
            case 147://返回工号(长度1—16字节)。
				$ret["len"]= 4;
				$ret["type"] = "empid04";
				break;
            case 148://返回工号(长度1—16字节)。
				$ret["len"]= 5;
				$ret["type"] = "empid05";
				break;
            case 149://返回工号(长度1—16字节)。
				$ret["len"]= 6;
				$ret["type"] = "empid06";
				break;
            case 150://返回工号(长度1—16字节)。
				$ret["len"]= 7;
				$ret["type"] = "empid07";
				break;
            case 151://返回工号(长度1—16字节)。
				$ret["len"]= 8;
				$ret["type"] = "empid08";
				break;
            case 152://返回工号(长度1—16字节)。
				$ret["len"]= 9;
				$ret["type"] = "empid09";
				break;
            case 153://返回工号(长度1—16字节)。
				$ret["len"]= 10;
				$ret["type"] = "empid10";
				break;
            case 154://返回工号(长度1—16字节)。
				$ret["len"]= 11;
				$ret["type"] = "empid11";
				break;
            case 155://返回工号(长度1—16字节)。
				$ret["len"]= 12;
				$ret["type"] = "empid12";
				break;
            case 156://返回工号(长度1—16字节)。
				$ret["len"]= 13;
				$ret["type"] = "empid13";
				break;
            case 157://返回工号(长度1—16字节)。
				$ret["len"]= 14;
				$ret["type"] = "empid14";
				break;
            case 158://返回工号(长度1—16字节)。
				$ret["len"]= 15;
				$ret["type"] = "empid15";
				break;
            case 159://返回工号(长度1—16字节)。
				$ret["len"]= 16;
				$ret["type"] = "empid16";
				break;
            case 160://返回姓名(长度1—16字节)。
				$ret["len"]= 1;
				$ret["type"] = "empname";
				break;
            case 161://返回姓名(长度1—16字节)。
				$ret["len"]= 2;
				$ret["type"] = "empname";
				break;
            case 162://返回姓名(长度1—16字节)。
				$ret["len"]= 3;
				$ret["type"] = "empname";
				break;
            case 163://返回姓名(长度1—16字节)。
				$ret["len"]= 4;
				$ret["type"] = "empname";
				break;
            case 164://返回姓名(长度1—16字节)。
				$ret["len"]= 5;
				$ret["type"] = "empname";
				break;
            case 165://返回姓名(长度1—16字节)。
				$ret["len"]= 6;
				$ret["type"] = "empname";
				break;
            case 166://返回姓名(长度1—16字节)。
				$ret["len"]= 7;
				$ret["type"] = "empname";
				break;
            case 167://返回姓名(长度1—16字节)。
				$ret["len"]= 8;
				$ret["type"] = "empname";
				break;
            case 168://返回姓名(长度1—16字节)。
				$ret["len"]= 9;
				$ret["type"] = "empname";
				break;
            case 169://返回姓名(长度1—16字节)。
				$ret["len"]= 10;
				$ret["type"] = "empname";
				break;
            case 170://返回姓名(长度1—16字节)。
				$ret["len"]= 11;
				$ret["type"] = "empname";
				break;
            case 171://返回姓名(长度1—16字节)。
				$ret["len"]= 12;
				$ret["type"] = "empname";
				break;
            case 172://返回姓名(长度1—16字节)。
				$ret["len"]= 13;
				$ret["type"] = "empname";
				break;
            case 173://返回姓名(长度1—16字节)。
				$ret["len"]= 14;
				$ret["type"] = "empname";
				break;
            case 174://返回姓名(长度1—16字节)。
				$ret["len"]= 15;
				$ret["type"] = "empname";
				break;
            case 175://返回姓名(长度1—16字节)。
				$ret["len"]= 16;
				$ret["type"] = "empname";
				break;
            case 88://返回机器记录号(长度4字节)。
				$ret["len"]= 4;
				$ret["type"] = "mrno";
				break;
            case 8://事件名称（1字节）
				$ret["len"]= 1;
				$ret["type"] = "event";
				break;
            case 34://红外通道的进出方向，0x01:进、0x02：出、其他：未知
				$ret["len"]= 1;
				$ret["type"] = "redio";
				break;
            case 35://照片流水
				$ret["len"]= 4;
				$ret["type"] = "photono";
				break;
            case 31://物理卡ID号(4个字节，HEX码)
				$ret["len"]= 4;
				$ret["type"] = "cardid";
				break;
            case 9://存门编号。0-7，0xFF表示门编号未知
				$ret["len"]= 1;
				$ret["type"] = "doorno";
				break;
            case 10://存读头编号。0-7，0xFF表示读头编号未知
				$ret["len"]= 1;
				$ret["type"] = "readerno";
				break;
            case 11://输入输出通道编号：表示该输入输出事件产生的输入输出端口，当为0xFF表示输入输出通道未知
				$ret["len"]= 1;
				$ret["type"] = "pno";
				break;
            case 12://返回开门密码,BCD码（3字节）
				$ret["len"]= 3;
				$ret["type"] = "doorpass";
				break;
            case 13://密码类型（1字节）
				$ret["len"]= 1;
				$ret["type"] = "passtype";
				break;
            case 14://门实时的状态（1字节）
				$ret["len"]= 1;
				$ret["type"] = "realstatus";
				break;
            case 15://门动作的状态（1字节）
				$ret["len"]= 1;
				$ret["type"] = "workstatus";
				break;
            case 48://充电箱通道号
				$ret["len"]= 2;
				$ret["type"] = "pipeno";
				break;
            case 49://充电箱用电量
				$ret["len"]= 4;
				$ret["type"] = "electricity";
				break;
		}
		return $ret;
	}
}