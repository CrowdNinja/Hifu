<?php  if ( ! defined('IN_DLC')) exit('No direct script access allowed');

class Weixin extends SM_Controller
{
    private $appid = 'er*3gO*U799iuyt';

	public function __construct()
	{
		parent::__construct();
		$this->load->config('wx_config');
		$appid = $this->config->item('JSAPI_appid');
		$secret = $this->config->item('JSAPI_appsecret');
		$this->load->library('jssdk', array($appid, $secret));	
		$this->load->model('setting_mdl');
		$this->load->model('user_mdl');
	}
	
	private function _chk_usercode($usercode, $chkonly = false){
		$usercode = intval($usercode);
		if($chkonly){
			$user = $this->_getrow('user', 'id', "id=$usercode");
			if($user){
				//$_SESSION['usercode'] = checknull($_SESSION['usercode'], $usercode);
				return $user['id'];	
			}
			return 0;
		}
		//以下会员树关系
		$res = array(
			'pid' => 0,
			'toppid' => 0,
			'path' => '',
		);
		if($usercode){
			$user = $this->_getrow('user', 'id,pid,toppid,path', "id=$usercode");		
			if($user){
				$res['pid'] = $user['id'];
				$res['toppid'] = $user['toppid'] ? : $user['id'];	
				$res['path'] = trim($user['path'].','.$user['id'], ',');
				//$_SESSION['usercode'] = checknull($_SESSION['usercode'], $usercode);
			}
		}
		return $res;
	}
	 
	public function index()
	{
		if($this->_checkSignature()){			
			echo $this->input->get('echostr');
		}else{
			exit('');	
		}
    }
		
    public function callback(){
        if ($this->_checkSignature()) {
            $data = xml2array($GLOBALS['HTTP_RAW_POST_DATA']);
            if($data['FromUserName'] && $data['Event'] == 'subscribe'){
				if($data['EventKey']){
					$_SESSION['usercode'] = strtok(strtok($data['EventKey'], '_'));
				}
				$row = $this->_getrow('user', '*', "weixin_openid='".$data['FromUserName']."'");
                if($row){
					if(!$row['weixin_subscribe'] || !$row['weixin_unionid']){
						if($row['weixin_unionid']){
							$this->db->update('user', array('weixin_subscribe' => 1), "id=".$row['id']);	
						}else{
							$res = $this->jssdk->getInfo($data['FromUserName']);
							$this->db->update('user', array('weixin_unionid' => $res['unionid'], 'weixin_subscribe' => 1), "id=".$row['id']);
						}
						//$row['weixin_subscribe'] = 1;
						//$this->_message_subscribe($row);
					}
				}else{
					$res = $this->jssdk->getInfo($data['FromUserName']);
					$this->_register($res, 1);
				}
            }
			if($data['FromUserName'] && $data['Event'] == 'unsubscribe'){//取消关注
				$this->db->update('user', array('weixin_subscribe' => 0), "weixin_openid='".$data['FromUserName']."'");	
			}
        }
        echo $_GET['echostr'];
    }	
	
	public function redirect($action = 'login'){		
		$code = $this->input->get('code');
		$this->load->config('wx_config');
		$appid = $this->config->item('JSAPI_appid');
		$secret = $this->config->item('JSAPI_appsecret');
		$url = 'https://120.198.199.239/sns/oauth2/access_token?appid='.$appid.'&secret='.$secret.'&code='.$code.'&grant_type=authorization_code';
		$res = json_decode($this->jssdk->httpCurl($url), true);
		if(!empty($res['openid'])){			
			if($action == 'login'){
				//$jssdkres = $this->jssdk->getInfo($res['openid']);//关注才能获取到昵称
				$url = 'https://120.198.199.239/sns/userinfo?access_token='.$res['access_token'].'&openid='.$res['openid'].'&lang=zh_CN';
				$res = json_decode($this->jssdk->httpCurl($url), true);
				if($res['openid']){
					$row = $this->_register($res, $jssdkres['subscribe']);
					$_SESSION['user'] = $row;//登录
					$time = time();
					$token = md5($this->appid.$time.$_SESSION['user']['id']).$_SESSION['user']['id'].$time;	
					$redirect = $_SESSION['weixin_redirect'];
					if(!empty($redirect)){
						@header("Location:".urlparam($redirect, array('token' => $token)));
					}else{
						exit(json_encode(array('msg' => 'success', 'token' => $token)));
					}
				}else{
					exit(json_encode(array('msg' => 'weixinerr', 'data' => $res)));
				}
			}	
		}
		exit(json_encode(array('msg' => 'weixinerr', 'data' => $res)));
	}
	
	private function _register($res, $subscribe = 0){
		if($res['unionid']){
			$row = $this->_getrow('user', '*', "weixin_unionid='".$res['unionid']."'");
		}
		if(!$row){
			$row = $this->_getrow('user', '*', "weixin_openid='".$res['openid']."'");
		}
		if(!$row){
			$parent_data = $this->_chk_usercode($_SESSION['usercode']);
			$data = $this->_getdata('user', array('weixin_openid' => $res['openid'],
												  'weixin_unionid' => $res['unionid'],
												  'avatar' => $res['headimgurl'],
												  'sex' => $res['sex'],
												  'account' => $res['nickname'],
												  'nickname' => $res['nickname'],
												  'address' => checknull($res['country'].$res['province'].$res['city']),
												  'status' => 1,
												  'weixin_subscribe' => checknull($subscribe),
												  ));
			$data = $parent_data + $data;
			$this->db->insert('user', $data);
			$row = $data;
			$row['id'] = $this->db->insert_id();
			$this->user_mdl->update($row['id']);
		}else{
			$data = array('weixin_openid' => $res['openid'],
						  'weixin_unionid' => $res['unionid'],
						  'avatar' => $res['headimgurl'],
						  'sex' => $res['sex'],
						  //'account' => $res['nickname'],
						  'nickname' => $res['nickname'],
						  'address' => checknull($res['country'].$res['province'].$res['city']),
						  //'weixin_subscribe' => $subscribe,
						  );
			$this->db->update('user', $data, 'id='.$row['id']);
			$this->user_mdl->update($row['id']);	
		}
		return $row;
	}
	
	private function _checkSignature()
	{
		$signature = $this->input->get("signature");
		$timestamp = $this->input->get("timestamp");
		$nonce = $this->input->get("nonce");	
		
		$this->load->config('wx_config');
		$token = $this->config->item('JSAPI_token');
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}