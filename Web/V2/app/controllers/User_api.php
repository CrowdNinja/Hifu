<?php  if ( ! defined('IN_DLC')) exit('No direct script access allowed');

require('./app/controllers/User_api_user.php');
require('./app/controllers/User_api_pay.php');
require('./app/controllers/User_api_coupon.php');
require('./app/controllers/User_api_trade.php');
require('./app/controllers/User_api_shop.php');
require('./app/controllers/User_api_wxsite.php');
require('./app/controllers/User_api_yun.php');

class User_Api extends Api_Controller
{
	use User_api_user;
	use User_api_pay;
	use User_api_coupon;
	use User_api_trade;
	use User_api_shop;
	use User_api_wxsite;
	use User_api_yun;

	private $language=1;
    private $appid = 'er*3gO*U799iuyt';
	private $active = 8640000;//300秒
	private $globals_method = array('yun_result', 'weixin_login', 'weixinpro_login', 'weixin_ticket', 'weixin_qrcode', 'location2address', 'register', 'login', 'forgot', 'captcha', 'sms', 'setting', 'shop');
	public function __construct(){
		parent::__construct();
		$this->load->model('setting_mdl');
		$this->load->model('user_mdl'); 
		$this->load->model('trade_mdl');
		$this->load->model('finance_mdl');
		$func = $this->router->fetch_method();
		//log_message("error",$func.":".json_encode($_POST));
		//log_message("error",var_export($_POST, true));
		//f(!in_array($func, $this->globals_method) && !$this->_checksign())$this->_return(-5, '非法操作');
		/*if(isweixin()){
			$this->load->config('wx_config');
			$this->load->library('jssdk', array($this->config->item('JSAPI_appid'), $this->config->item('JSAPI_appsecret')));
		}
		
		if($_SERVER['HTTP_WEIXINCODE']){
			$row = $this->_get(false);
			if(!$row)$this->weixin_code_login(array('code' => trim($_SERVER['HTTP_WEIXINCODE'])), false);
		}*/
		$language=$this->input->post('language');
		if($language) $this->language=$language;
	}


    //日元转人民币
    public function rmb2ry($money){
        if($money<=0) return 0;
	    $data=json_decode($this->_getfield('setting','val',['key'=>'setting']));
	    return max(bcdiv($money,$data->exchange,2),0.01);//最小单位0.01元
    }
	/*public function index(){
		$this->_return();
    }*/

	public function captcha(){
		$this->load->library('captcha');
		$code = $this->captcha->getCaptcha();
		$this->session->set_userdata('code', $code);
		$this->captcha->showImg();
	}


	//获取手机短信（4位数）
	//action = register 注册 login 登录 edit 绑定手机
	public function sms($action = 'register'){
		$post = $this->input->post();
		if(!$post['area_code']) $this->_return(-1,'请选择地区号');
        if(!empty($post['account']) && is_numeric($post['account']) && strlen($post['account']) == 11){
            $sms = rand(1000, 9999);//生成4位随机数
            $TemplateCode="SMS_186380531";
            $SignName="YASHANG";
            if($post['area_code']=='86'){
                $TemplateCode="SMS_181790183";
                $SignName="雅尚科技";
            }
            $content = $this->ali_sms($TemplateCode,['code'=>$sms],$post['area_code'],$post['account'],$SignName);
            if($content && $content->Code == 'OK'){
                $is_sms=$this->_getrow('sms_record','*',['phone'=>$post['account']]);
                if($is_sms){
                    $this->db->update('sms_record',['sms'=>$sms,'ctime'=>strtotime('+ 5 minute')],['id'=>$is_sms['id']]);
                }else{
                    $this->db->insert('sms_record',['phone'=>$post['account'],'ctime'=>strtotime('+ 5 minute'),'sms'=>$sms]);
                }
                $this->_return(1, '短信发送成功');
            }else{
                $this->_return(0, '短信发送失败,'.$content->Message);
            }
		}
        $this->_return(0, '账号为空或不是手机号码');
	}
/*	//发送短信
    public function sms(){
        $post=$this->input->post();
        if(!empty($post['account']) && is_numeric($post['account']) && strlen($post['account']) == 11) {
            $_SESSION['user_sms_account'] = $post['account'];
            $_SESSION['user_sms_time'] = time() + 300000;
            $sms = rand(1000, 9999);//生成4位随机数
            $sm=urlencode("【华之合】您的验证码是：".$sms."，请妥善保存，不要随意泄露给他人");
            $account=$post['account'];
            $res=json_decode(post_url("http://122.144.179.11:7891/mt?un=520094&pw=hsltyl123&da=$account&sm=$sm&dc=15&rd=1&rf=2&tf=3"));
            if($res->success){
                $is_sms=$this->_getrow('sms_record','*',['phone'=>$post['account']]);
                if($is_sms){
                    $this->db->update('sms_record',['sms'=>$sms,'ctime'=>$_SESSION['user_sms_time']],['id'=>$is_sms['id']]);
                }else{
                    $this->db->insert('sms_record',['phone'=>$post['account'],'ctime'=>$_SESSION['user_sms_time'],'sms'=>$sms]);
                }
                $this->_return(1, '短信发送成功');
            }
            $this->_return(-1001, '短信发送失败');

        }
        $this->_return(-1002, '手机号不正确');

    }*/

	private function _uploads($_upload_config = array(), $_resize_config = array()){
		//$row = $this->_get();
		//配置上传参数
		$config['upload_path']      = './upload/user/';
		@mkdir($config['upload_path'], 0777, true);
		$config['allowed_types']    = '*';
		$config['max_size']     = 20480;
		$config['max_width']        = 0;
		$config['max_height']       = 0;
		//载入所需文件上传类库
		$this->load->library('upload', $_upload_config + $config);

		//循环处理上传文件
		$result = array();
		$files = $_FILES;
		foreach ($files as $key => $value) {
			if(is_array($value['name'])){
				$count = count($value['name']);
				for($i = 0; $i < $count; $i ++){
					$_FILES[$key.'#'.$i] = array(
						'name' => time().strrchr($value['name'][$i], '.'),
						'type' => $value['type'][$i],
						'tmp_name' => $value['tmp_name'][$i],
						'error' => $value['error'][$i],
						'size' => $value['size'][$i],
					);
					if (!empty($_FILES[$key.'#'.$i]['name'])) {
						if ($this->upload->do_upload($key.'#'.$i)) {
							//上传成功
							$data = $this->upload->data();
							$result[$key.'#'.$i] = array('filename' => substr($this->_image_resize('./upload/user/'.$data['file_name'], isset($_resize_config[$key]) ? $_resize_config[$key] : (count($_resize_config, 1) == count($_resize_config) ? $_resize_config : array())), 1), 'error' => strip_tags($this->upload->display_errors()));
						} else {
							//上传失败
							$result[$key.'#'.$i] = array('filename' => '', 'error' => strip_tags($this->upload->display_errors()));
						}
					}else{
						$result[$key.'#'.$i] = array('filename' => '', 'error' => '没有选择上传文件');
					}
				}
			}else{
				if (!empty($value['name'])) {
					$value['name'] = time().strrchr($value['name'], '.');
					$_FILES[$key] = $value;
					if ($this->upload->do_upload($key)) {
						//上传成功
						$data = $this->upload->data();
						$result[$key] = array('filename' => substr($this->_image_resize('./upload/user/'.$data['file_name'], isset($_resize_config[$key]) ? $_resize_config[$key] : (count($_resize_config, 1) == count($_resize_config) ? $_resize_config : array())), 1), 'error' => strip_tags($this->upload->display_errors()));
					} else {
						//上传失败
						$result[$key] = array('filename' => '', 'error' => strip_tags($this->upload->display_errors()));
					}
				}else{
					$result[$key] = array('filename' => '', 'error' => '没有选择上传文件');
				}
			}
		}
		return $result;
	}

	//文件上传
	public function upload($_upload_config = array(), $_resize_config = array()){
		$upfile = $this->input->post('upfile');
		if(!$upfile)$upfile = current(array_keys($_FILES));
		$upname = checknull($this->input->post('upname'), $upfile);
		$cbfunc = $this->input->post('cbfunc');
		$return = checknull($this->input->post('return'), 'js/json');
		if(empty($upname) || empty($upfile))$this->_return(-1001, '上传参数为空');

        $config['upload_path']      = './upload/user/';
		@mkdir($config['upload_path'], 0777, true);
        $config['allowed_types']    = '*';
        $config['max_size']     = 20480;
        $config['max_width']        = 0;
        $config['max_height']       = 0;
		$config = $_upload_config + $config;

		//base64上传
		if(!isset($_FILES[$upfile])){
			$filename = $this->_uploadbase64($upfile, $config['upload_path'], $_upload_config, $_resize_config);
			if(!$filename || $filename == -1 || $filename == -2){
				$uperr = '上传文件失败';
				if($filename == -1)$uperr = '上传文件类型不正确';
				if($filename == -2)$uperr = '上传文件太大';
				if($return == 'js/json'){
					if($cbfunc){
						echo '<script>(window.opener || window.parent).'.$cbfunc.'("'.$upname.'", "", "'.$uperr.'");</script>';
					}else{
						$this->_return(-1002, $uperr);
					}
				}else{
					return array($upname, '', $uperr);
				}
			}else{
				if($return == 'js/json'){
					if($cbfunc){
						echo '<script>(window.opener || window.parent).'.$cbfunc.'("'.$upname.'", '.concaturl($filename).');</script>';
					}else{
						$this->_return(1, '文件上传成功', array('upname' => $upname,'filename' => concaturl($filename)));
					}
				}else{
					return array($upname, $filename, '');
				}
			}
		}
		//表单上传
		$filename = explode(" ", microtime());
		$filename[0] = $filename[0] * 10000000;
		$config['file_name'] = $filename[0] + $filename[1];

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload($upfile))
        {
			if($return == 'js/json'){
				if($cbfunc){
					echo '<script>(window.opener || window.parent).'.$cbfunc.'("'.$upname.'", "", "'.strip_tags($this->upload->display_errors()).'");</script>';
				}else{
					$this->_return(-1001, strip_tags($this->upload->display_errors()));
				}
			}else{
				return array($upname, '', $this->upload->display_errors());
			}
        }
        else
        {
			$data = array('upload_data' => $this->upload->data());
			if($return == 'js/json'){
				if($cbfunc){
					echo '<script>(window.opener || window.parent).'.$cbfunc.'("'.$upname.'", "'.concaturl(substr($this->_image_resize('./upload/user/'.$data['upload_data']['file_name'], $_resize_config), 1)).'");</script>';
				}else{
					$this->_return(1, '上传文件成功', array('upname' => $upname,'file_url'=>'/upload/user/'.$data['upload_data']['file_name'], 'filename' => concaturl(substr($this->_image_resize('./upload/user/'.$data['upload_data']['file_name'], $_resize_config), 1))));
				}
			}else{
				return array($upname, '/upload/user/'.$data['upload_data']['file_name'], '');
			}
        }
	}

	private function _uploadbase64($data, $upload_path = './upload/user/', $_upload_config = array(), $_resize_config = array()){
		if(strpos(relativeurl($data), '/upload/') === 0)return relativeurl($data);//已上传的文件非base64
		$image = base64_decode($data);
		$fileext = check_image_type($image);
		if(!$fileext)return -1;
		if(strlen($image) / 1024 > 1024)return -2;//文件太大

		@mkdir($upload_path, 0777, true);
		$filename = explode(" ", microtime());
		$filename[0] = $filename[0] * 10000000;
		$newfilename = $upload_path.($filename[0] + $filename[1]).'.'.$fileext;
		file_put_contents($newfilename, $image);
		return substr($this->_image_resize($newfilename, $_resize_config), 1);
	}
	
	private function _image_resize($image, $_config = array()){
		if(!is_array($_config))return $image;
		$ext = getfileext($image);
		if(!in_array($ext, array('', '.jpg', '.jpeg', '.png', '.gif')))return $image;
		
		$config['image_library'] = 'gd2';
		$config['source_image'] = $image;
		$config['create_thumb'] = false;
		$config['maintain_ratio'] = true;
		$config['width']     = 1024;
		$config['height']   = 1024;
		
		$config = $_config + $config;
		
		$this->load->library('image_lib', $config);
		$this->image_lib->initialize($config);
		if(!$this->image_lib->resize() || $this->image_lib->clear())return $image;//$this->image_lib->display_errors();
		return $config['new_image'] ? : $image;
	}

	//获取设置
	public function setting(){
		//$row = $this->_get();
		$config = $this->setting_mdl->get('config');
		//$recharge=$this->setting_mdl->get('recharge');
		$service=$this->setting_mdl->get('service');
        //$min_recharge_money=$recharge['min_recharge_money'];
        //unset($recharge['min_recharge_money']);
		$result = array(
			'help' => str_ireplace('/upload/', base_url().'upload/', $this->setting_mdl->get('help')),
			'about' => str_ireplace('/upload/', base_url().'upload/', $this->setting_mdl->get('about')),
			'contact' => $this->setting_mdl->get('contact'),
			'price' => $this->setting_mdl->get('price'),
			'question' => explode(',',$this->setting_mdl->get('question')['text']),
			//'recharge' => array_col2row($recharge),
            //'min_recharge_money'=>$min_recharge_money,
            'service'=>$service,
            'rent'=>str_ireplace('/upload/', base_url().'upload/', $this->setting_mdl->get('rent')),
		);
		$result['contact']['text'] = str_ireplace('/upload/', base_url().'upload/', $result['contact']['text']);
		$this->_return(1, '获取设置成功', $result);
	}
	//根据地址获取经纬度
	public function query_address($key_words)
	{
			$header[] = 'Referer: http://lbs.qq.com/webservice_v1/guide-suggestion.html';
			$header[] = 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.139 Safari/537.36';
			$url = "http://apis.map.qq.com/ws/place/v1/suggestion/?&region=&key=OB4BZ-D4W3U-B7VVO-4PJWW-6TKDJ-WPB77&keyword=" . $key_words;

			$ch = curl_init();
			//设置选项，包括URL
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HEADER, 0);

			//执行并获取HTML文档内容
			$output = curl_exec($ch);
			// print_r($output);die;
			//释放curl句柄
			curl_close($ch);
			// return $output;
			$result = json_decode($output, true);
			// print_r($result);
			$res = $result['data'][0];
			return $res;
			//echo json_encode(['error_code'=>'SUCCESS','reason'=>'查询成功','result'=>$result);

	}
	
	public function location2address(){
		$result = location2address($this->input->post('lng').','.$this->input->post('lat'));
		$this->_return(1, '获取成功', $result);
	}
    
	private function _return($code = 1, $msg = '', $data = array()){
		$time = time();
		$result = array('code' => $code, 'msg' => $msg, 'data' => $data);
		/*if($code == 1 && !empty($_SESSION['user']['id'])){
			//if(count($data) == count($data, 1)){
				$result['data']['token'] = md5($this->appid.$time.$_SESSION['user']['id']).$_SESSION['user']['id'].$time;
			//}
		}*/
    // log_message("error", $this->router->fetch_method() . ":" . json_encode($_POST) . "------" . json_encode($result));
		$callback = $this->input->get('callback');
		if(!empty($callback)){
			echo '<script>(parent || top).'.$callback.'(\''.json_encode($result).'\');</script>';
			exit;
		}
		exit(json_encode($result));
	}

	public function testlanguage(){
	    $_SESSION['language']=$_POST['language'];
	    echo translate($_POST['text']);

    }
    //把数据库语言写入文件
    public function setlanguagetxt(){
	    $list=$this->_getlist('language',"*",'');
	    $chinese='';
	    $japanese='';
	    foreach($list as $k=>$v){
            $chinese.=$v['chinese']."\n";
            $japanese.=$v['japanese']."\n";
        }
        $this->load->helper('file');
        if($chinese) write_file('./chinese.txt',  $chinese,'w+');
        if($japanese) write_file('./japanese.txt',  $japanese,'w+');
        $this->load->helper('file');
        $string = read_file('./japanese.txt');
        die($string);
    }
}