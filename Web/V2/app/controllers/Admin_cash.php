<?php
if (!defined('IN_DLC')) exit ('No direct script access allowed');
/**
*
* @package  management    
* @author       
* @copyright    
* @license      
* @link         
* @since       Version 1.0
* @filesource
*/
require('./app/controllers/Admin_cash_export.php');

class Admin_cash extends Admin_Controller {
	/**
	 * 构造函数
	 *
	 * @access  public
	 * @return  void
	 */
	 
	use Admin_cash_export;
	 
	private $cash_status = array(0 => '新申请', 1 => '<b style="color:green">通过</b>', 2 => '<b style="color:red;">拒绝</b>',3=>'<b style="color:green;">已打款</b>');
	public function __construct() 
	{
		parent :: __construct();
		$this->load->model('user_mdl');
		$this->load->model('admin_mdl');
	}
	
	public function index(){
		$page = $this->input->get('page');
		$pagesize = $this->input->get('pagesize');
		if(empty($pagesize))$pagesize = 20;
		
		$userid = $this->input->get('userid');	
		$status = $this->input->get('status');	
		$createtime1 = $this->input->get('createtime1');
		$createtime2 = $this->input->get('createtime2');
		$lasttime1 = $this->input->get('lasttime1');
		$lasttime2 = $this->input->get('lasttime2');
		$this->assign('get', $this->input->get());
		
		//处理搜索SQL
		$where = ' 1=1 ';
		if(is_numeric($userid)){
			$where .= ' and b.id='.$userid;
			$this->assign('get_userid_account', $this->_getfield('user', 'if(account=nickname,concat(id, ", ", account),concat(id, ", ", account, ", ", nickname))', 'id='.$userid));
		}
		if(is_numeric($status)){
			$where .= " and a.status=$status";	
		}
        if(!empty($createtime1)){
            $createtime1 = $createtime1." 00:00:00";
            $where .= " and a.createtime>='".$createtime1."'";
        }

        if(!empty($createtime2)){
            $createtime2 = $createtime2." 23:59:59";
            $where .= " and a.createtime<='".$createtime2."'";
        }

        if(!empty($lasttime1)){
            $lasttime1 = $lasttime1." 00:00:00";
            $where .= " and a.lasttime>='".$lasttime1."'";
        }

        if(!empty($lasttime2)){
            $lasttime2 = $lasttime2." 23:59:59";
            $where .= " and  a.lasttime<='".$lasttime2."'";
        }
		
		//注意php代码不需要处理搜索URL参数，分页URL的处理注意本页模板页尾的JS代码
		$cash = $this->_getpage(array('user_cash as a', array('user as b', 'a.user_id=b.id')), $where, 'a.id desc', $page, $pagesize, 'a.*,b.nickname,b.account');
        foreach($cash['list'] as $k=>&$v){
            $v=$this->replace_null_time($v);
        }
        unset($v);
		$this->assign('cash', $cash);
		$this->assign('cash_status', $this->cash_status);
		$this->display('bguser/list_cash.html');
	}

	
	public function delete(){
		$ids = $this->input->post('ids');
		if(!empty($ids)){
			$this->log_mdl->delete('user_cash',"id in($ids)");
		}
		die('{"status":1}');	
	}
	
	public function clear(){
		$this->log_mdl->delete('user_cash', " 1=1 ");
		die('{"status":1}');	
	}

	public function check(){
		$id = $this->input->post('id');
		$cashno = $this->input->post('cashno');
		if(!empty($cashno)){
			$where = "cashno='".$cashno."'";
			if(!empty($id))$where .= " and id<>".$id;
			$count = $this->_getcount('user_cash', $where);
			die('{"status":"'.$count.'"}');
		}
		die('{"status":"-1"}');
	}

	public function shop(){
		$page = $this->input->get('page');
		$pagesize = $this->input->get('pagesize');
		if(empty($pagesize))$pagesize = 20;
		
		$adminid = $this->input->get('adminid');	
		$status = $this->input->get('status');	
		$createtime1 = $this->input->get('createtime1');
		$createtime2 = $this->input->get('createtime2');
		$lasttime1 = $this->input->get('lasttime1');
		$lasttime2 = $this->input->get('lasttime2');
		$this->assign('get', $this->input->get());
		
		//处理搜索SQL
		$where = ' a.type=2 '.$this->_rolesql('b', 'id');
		if(is_numeric($adminid)){
			$where .= ' and b.id='.$adminid;
			$this->assign('get_adminid_account', $this->_getfield('admin', 'concat(id, ", ", nickname)', 'id='.$adminid));
		}
		if(is_numeric($status)){
			$where .= " and a.status=$status";	
		}
        if(!empty($createtime1)){
            $createtime1 = $createtime1." 00:00:00";
            $where .= " and a.createtime>='".$createtime1."'";
        }

        if(!empty($createtime2)){
            $createtime2 = $createtime2." 23:59:59";
            $where .= " and a.createtime<='".$createtime2."'";
        }

        if(!empty($lasttime1)){
            $lasttime1 = $lasttime1." 00:00:00";
            $where .= " and a.lasttime>='".$lasttime1."'";
        }

        if(!empty($lasttime2)){
            $lasttime2 = $lasttime2." 23:59:59";
            $where .= " and  a.lasttime<='".$lasttime2."'";
        }


		
		//注意php代码不需要处理搜索URL参数，分页URL的处理注意本页模板页尾的JS代码
		$cash = $this->_getpage(array('admin_cash as a', array('admin as b', 'a.adminid=b.id')), $where, 'a.id desc', $page, $pagesize, 'a.*,b.nickname as account');
		foreach($cash['list'] as $k=>&$v){
		    $cash['list'][$k]['bank_info']=json_decode($v['bankdata'],1);
            if($v['user_id']) $v['nickname']=$this->_getfield('user','nickname',['id'=>$v['user_id']]);
		    $v=$this->replace_null_time($v);
        }
        unset($v);
		$this->assign('cash', $cash);
		$this->assign('cash_status', $this->cash_status);
		$this->display('bguser/list_shop_cash.html');
	}


	public function shop_delete(){
		$ids = $this->input->post('ids');
		if(!empty($ids)){
			$this->log_mdl->delete('admin_cash',"id in($ids) and type=2".$this->_rolesql());
		}
		die('{"status":1}');	
	}
	
	public function shop_clear(){
		$this->log_mdl->delete('admin_cash', " type=2 ".$this->_rolesql());
		die('{"status":1}');	
	}

	public function shop_check(){
		$id = $this->input->post('id');
		$cashno = $this->input->post('cashno');
		if(!empty($cashno)){
			$where = "type=2 and cashno='".$cashno."'";
			if(!empty($id))$where .= " and id<>".$id;
			$count = $this->_getcount('admin_cash', $where);
			die('{"status":"'.$count.'"}');
		}
		die('{"status":"-1"}');
	}

	public function corp(){
		$page = $this->input->get('page');
		$pagesize = $this->input->get('pagesize');
		if(empty($pagesize))$pagesize = 20;
		
		$adminid = $this->input->get('adminid');	
		$status = $this->input->get('status');	
		$createtime1 = $this->input->get('createtime1');
		$createtime2 = $this->input->get('createtime2');
		$lasttime1 = $this->input->get('lasttime1');
		$lasttime2 = $this->input->get('lasttime2');
		$this->assign('get', $this->input->get());
		
		//处理搜索SQL
		$where = ' a.type=1 '.$this->_rolesql('b', 'id');
		if(is_numeric($adminid)){
			$where .= ' and b.id='.$adminid;
			$this->assign('get_adminid_account', $this->_getfield('admin', 'concat(id, ", ", nickname)', 'id='.$adminid));
		}
		if(is_numeric($status)){
			$where .= " and a.status=$status";	
		}
        if(!empty($createtime1)){
            $createtime1 = $createtime1." 00:00:00";
            $where .= " and a.createtime>='".$createtime1."'";
        }

        if(!empty($createtime2)){
            $createtime2 = $createtime2." 23:59:59";
            $where .= " and a.createtime<='".$createtime2."'";
        }

        if(!empty($lasttime1)){
            $lasttime1 = $lasttime1." 00:00:00";
            $where .= " and a.lasttime>='".$lasttime1."'";
        }

        if(!empty($lasttime2)){
            $lasttime2 = $lasttime2." 23:59:59";
            $where .= " and  a.lasttime<='".$lasttime2."'";
        }

		
		//注意php代码不需要处理搜索URL参数，分页URL的处理注意本页模板页尾的JS代码
		$cash = $this->_getpage(array('admin_cash as a', array('admin as b', 'a.adminid=b.id')), $where, 'a.id desc', $page, $pagesize, 'a.*,b.nickname as account');
		foreach($cash['list'] as $k=>&$v){
		    $v['bank_info']=json_decode($v['bankdata'],true);
		    if($v['user_id']) $v['nickname']=$this->_getfield('user','nickname',['id'=>$v['user_id']]);
            $v=$this->replace_null_time($v);
        }
        unset($v);
		$this->assign('cash', $cash);
		$this->assign('cash_status', $this->cash_status);
		$this->display('bguser/list_corp_cash.html');
	}


	public function corp_delete(){
		$ids = $this->input->post('ids');
		if(!empty($ids)){
			$this->log_mdl->delete('admin_cash'," id in($ids) and type=1".$this->_rolesql());
		}
		die('{"status":1}');	
	}
	
	public function corp_clear(){
		$this->log_mdl->delete('admin_cash', " type=1 ".$this->_rolesql());
		die('{"status":1}');	
	}

	public function corp_check(){
		$id = $this->input->post('id');
		$cashno = $this->input->post('cashno');
		if(!empty($cashno)){
			$where = "type=1 and cashno='".$cashno."'";
			if(!empty($id))$where .= " and id<>".$id;
			$count = $this->_getcount('admin_cash', $where);
			die('{"status":"'.$count.'"}');
		}
		die('{"status":"-1"}');
	}

	//审核
    public function audit(){
	    $id=$this->input->post('id');
	    $status=$this->input->post('status');
	    $reject_cause=$this->input->post('reject_cause');//拒绝原因
	    if($id){
	        $row=$this->_getrow('admin_cash','*',['id'=>$id]);
	        if($status!=3) $this->log_mdl->update('admin_cash',['status'=>$status,'lasttime'=>date('Y-m-d H:i:s')],['id'=>$id]);
	        if($status==2){//拒绝 退钱
	            $this->db->set('money','money+'.$row['money'],false)->where('id',$row['adminid'])->update('admin');
                $this->log_mdl->update('admin_cash',['fail'=>$reject_cause?:""],['id'=>$id]);
            }elseif($status==3){//打款
	            if($row['user_id']!=0){
	                $user=$this->_getrow('user','*',['id'=>$row['user_id']]);
	                if(!$user) $this->admin_return(0,'没有找到微信到账用户');
	                //TODO 企业支付 到个人账号
                    $res=$this->xml2array($this->payToUser($user['weixin_openid'],"提现",$row['money']*100));//微信企业支付
                    if($res['return_code']=="SUCCESS"&&$res['result_code']=="SUCCESS"){//提现成功
                        $this->log_mdl->update('admin_cash',['status'=>$status,'lasttime'=>date('Y-m-d H:i:s')],['id'=>$id]);
                    }else{
                        //保存提现失败原因
                        $this->log_mdl->update('admin_cash',['fail'=>$res['err_code_des']],['id'=>$id]);
                        $this->admin_return(0,'打款失败：'.$res['err_code_des']);
                    }
                }else{
                    $this->log_mdl->update('admin_cash',['status'=>$status,'lasttime'=>date('Y-m-d H:i:s')],['id'=>$id]);
                }
            }
            $this->admin_return(1);
        }
        $this->admin_return(0,'数据错误');
    }
    //会员提现审核
    public function user_audit(){
        $id=$this->input->post('id');
        $status=$this->input->post('status');
        if($id){
            $row=$this->_getrow('user_cash','*',['id'=>$id]);
            if($status!=3) $this->log_mdl->update('user_cash',['status'=>$status,'lasttime'=>date('Y-m-d H:i:s')],['id'=>$id]);
            if($status==2){//拒绝 退钱
                $this->db->set('money','money+'.$row['money'],false)->where('id',$row['user_id'])->update('user');
            }elseif($status==3){//打款
                if($row['user_id']!=0){
                    $user=$this->_getrow('user','*',['id'=>$row['user_id']]);
                    if(!$user) {
                        $this->log_mdl->update('user_cash',['status'=>0,'lasttime'=>date('Y-m-d H:i:s')],['id'=>$id]);
                        $this->admin_return(0,'没有找到微信到账用户');
                    }
                    //TODO 企业支付 到个人账号
                    $res=$this->xml2array($this->payToUser($user['weixin_proopenid'],"提现",$row['money']*100));//微信企业支付
                    if($res['return_code']=="SUCCESS"&&$res['result_code']=="SUCCESS"){//提现成功
                        $this->log_mdl->update('user_cash',['status'=>$status,'lasttime'=>date('Y-m-d H:i:s')],['id'=>$id]);
                    }else{
                        //保存提现失败原因
                        $this->log_mdl->update('user_cash',['fail'=>$res['err_code_des']],['id'=>$id]);
                        $this->admin_return(0,'打款失败：'.$res['err_code_des']);
                    }
                }else{
                    $this->log_mdl->update('user_cash',['status'=>$status,'lasttime'=>date('Y-m-d H:i:s')],['id'=>$id]);
                }
            }
            $this->admin_return(1);
        }
        $this->admin_return(0,'数据错误10001');
    }
    /**
     *  array转xml
     */
    private function arrayToXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key => $val) {
            if (is_numeric($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            } else
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
        }
        $xml .= "</xml>";
        return $xml;
    }
    //使用证书，以post方式提交xml到对应的接口url

    /**
     *   作用：使用证书，以post方式提交xml到对应的接口url
     */
    private function curl_post_ssl($url, $vars, $second=30)
    {
        $ch = curl_init();
        //超时时间
        curl_setopt($ch,CURLOPT_TIMEOUT,$second);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);

        //以下两种方式需选择一种
        /******* 此处必须为文件服务器根目录绝对路径 不可使用变量代替*********/
        curl_setopt($ch,CURLOPT_SSLCERT,APPPATH.'libraries/Wxpay/cert/apiclient_cert.pem');
        curl_setopt($ch,CURLOPT_SSLKEY,APPPATH.'libraries/Wxpay/cert/apiclient_key.pem');


        curl_setopt($ch,CURLOPT_POST, 1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$vars);

        $data = curl_exec($ch);
        if($data){
            curl_close($ch);
            return $data;
        }
        else {
            $error = curl_errno($ch);
            echo "call faild, errorCode:$error\n";
            curl_close($ch);
            return false;
        }
    }

    private function xml2array($xml) {
        $array = array();
        $tmp = null;
        try{
            $tmp = (array) simplexml_load_string($xml);
        }catch(Exception $e){}
        if($tmp && is_array($tmp)){
            foreach ( $tmp as $k => $v) {
                $array[$k] = (string) $v;
            }
        }
        return $array;
    }
    //企业向个人付款
    private function payToUser($openid='oXl-Y1Eg1nppS2y5rAoCwLxdcp4E',$desc='提现成功',$amount='500',$order_no='')
    {
        //微信付款到个人的接口
        $url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';

        $this->load->config('wx_config');
        $params["mch_appid"]        = $this->config->item('JSAPI_appid');   //公众账号appid
        $params["mchid"]            = $this->config->item('JSAPI_mch_id');   //商户号 微信支付平台账号
        $params["nonce_str"]        = 'longdongzhiye99'.mt_rand(100,999);   //随机字符串
        $params["partner_trade_no"] = $order_no?:mt_rand(10000000,99999999);           //商户订单号
        $params["amount"]           = $amount;          //金额
        $params["desc"]             = $desc;            //企业付款描述
        $params["openid"]           = $openid;          //用户openid
        $params["check_name"]       = 'NO_CHECK';       //不检验用户姓名
        $params['spbill_create_ip'] = '47.106.136.130';   //获取IP
        $api_key= $this->config->item('JSAPI_apikey');   //apikey
        //生成签名(签名算法后面详细介绍)
        $str = 'amount='.$params["amount"].'&check_name='.$params["check_name"].'&desc='.$params["desc"].'&mch_appid='.$params["mch_appid"].'&mchid='.$params["mchid"].'&nonce_str='.$params["nonce_str"].'&openid='.$params["openid"].'&partner_trade_no='.$params["partner_trade_no"].'&spbill_create_ip='.$params['spbill_create_ip'].'&key='.$api_key;
        //md5加密 转换成大写
        $sign = strtoupper(md5($str));

        $params["sign"] = $sign;//签名

        $xml = $this->arrayToXml($params);

        return $this->curl_post_ssl($url, $xml);
    }
}