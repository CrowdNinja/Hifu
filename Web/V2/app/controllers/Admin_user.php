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
class Admin_user extends Admin_Controller {
	/**
	 * 构造函数
	 *
	 * @access  public
	 * @return  void
	 */
	 
	private $user_status = array(1 => '正常',  2 => '禁止');
	private $user_type = array("<b style='color:green;'>微信</b>","<b style='color:#6a99ee;'>支付宝</b>");
	public function __construct()
	{
		parent :: __construct();
		$this->load->model('setting_mdl');
		$this->load->model('user_mdl');
	}

	public function index() 
	{
		$page = $this->input->get('page');
		$pagesize = $this->input->get('pagesize');
		if(empty($pagesize))$pagesize = 20;
		$this->assign('page',$page?:1);
		$userid = $this->input->get('userid');	
		$status = $this->input->get('status');
		$type = $this->input->get('type');
		$this->assign('get', $this->input->get());
		
		//处理搜索SQL
		$where = ' 1=1 ';
		if(is_numeric($type)){
			$where .= " and type=$type";
		}
        if(is_numeric($status)){
            $where .= " and status=$status";
        }
		if(is_numeric($userid)){
			$where .= ' and id='.$userid;
			$this->assign('get_userid_account', $this->_getfield('user', 'if(account=nickname,concat(id, ", ", account),concat(id, ", ", account, ", ", nickname))', 'id='.$userid));
		}
		
		//注意php代码不需要处理搜索URL参数，分页URL的处理注意本页模板页尾的JS代码
		$user = $this->_getpage('user', $where, 'id desc', $page, $pagesize);
		foreach($user['list'] as &$v){
			$v['total_momey']=$v['money']+$v['redmoney'];
			$v['foregift']=$this->_getfield('foregift','sum(money)',['userid'=>$v['id'],'status'=>1])?:"0.00";
		}
		unset($v);

		// セッションに購入履歴から戻るためのURI保存
		$_SESSION['purchase_back_uri'] = $_SERVER['REQUEST_URI'];

		$this->assign('user', $user);
		$this->assign('user_status', $this->user_status);
		$this->assign('user_type', $this->user_type);
		$this->display('user/list_user.html');
	}

	public function edit($id=0){
		$account = $this->input->post('account');
        $post=$this->input->post();
        if ($post ){
			$count = $this->_getcount('user', ($id ? "id<>$id and " : "") . "account='".$account."'");
			if($count)die('{"status":0}');
			$data =$post; //$this->_getdata('user', $post, $id ? false : '');
			if($data['pay_password']){
                $data['pay_password1']=$data['pay_password'];
                $data['pay_password']=md5($data['pay_password']);

            } else{
			    unset($data['pay_password']);
            }
            if($data['password']){
                $data['password1']=$data['password'];
                $data['password']=md5($data['password']);
            } else{
                unset($data['password']);
            }
			if($id){
				//$data['money'] = $this->user_mdl->new_money($id, $data['money']);
				$this->log_mdl->update('user', $data, 'id='.$id);
			}else{
				$this->log_mdl->insert('user', $data);
			}
			die('{"status":1}');
		}		
		if($id){
			$row = $this->_getrow('user', '*', 'id='.$id);
			//$row['money'] = $this->user_mdl->cash_money($id);
			$this->assign('row', $row);
		}		
		$this->assign('user_status', $this->user_status);
		$this->display('user/edit_user.html');
	}
	
	public function delete(){
		$ids = $this->input->post('ids');
		if(!empty($ids)){
			//$this->db->where_in('id', explode(',', $ids));
			$this->log_mdl->delete('user',"id in($ids)");
			//$this->user_mdl->fixpath($ids);

			//$this->db->delete('user_cash', "userid in (".$ids.")");
			//$this->db->delete('comment', "userid in (".$ids.")");
			//$this->db->delete('user_coupon', "userid in (".$ids.")");
		}
		die('{"status":1}');	
	}
	
	public function clear(){
		$this->log_mdl->delete('user', ' 1=1 ');
		//$this->db->delete('user_cash', "1=1");
		//$this->db->delete('comment', "1=1");
		//$this->db->delete('user_coupon', "1=1");
		die('{"status":1}');	
	}

	public function export(){
		$userid = $this->input->get('userid');	
		$status = $this->input->get('status');
		$createtime1 = $this->input->get('createtime1');
		$createtime2 = $this->input->get('createtime2');
		
		//处理搜索SQL
		$where = ' 1=1 ';
		if(is_numeric($status)){
			$where .= " and status=$status";	
		}
		if(is_numeric($userid)){
			$where .= ' and id='.$userid;
		}
		if(!empty($createtime1)){
			$createtime1 = formattime($createtime1.' 00:00:00');
			$where .= " and createtime>=".$createtime1;
		}
		if(!empty($createtime2)){
			$createtime2 = formattime($createtime2.' 23:59:59');
			$where .= " and createtime<=".$createtime2;
		}

		$filename = './temp/user.csv';
		$fp = fopen($filename, 'w');
		//fwrite($fp,chr(0xEF).chr(0xBB).chr(0xBF));
		fputcsv($fp, array(
			mb_convert_encoding('编号', 'gbk', 'utf8'),
			mb_convert_encoding('账号', 'gbk', 'utf8'),
			mb_convert_encoding('姓名', 'gbk', 'utf8'),
			mb_convert_encoding('微信OPENID', 'gbk', 'utf8'),
			mb_convert_encoding('现金余额', 'gbk', 'utf8'),
			mb_convert_encoding('返现/增送', 'gbk', 'utf8'),
			mb_convert_encoding('押金余额	', 'gbk', 'utf8'),
			mb_convert_encoding('累计提现', 'gbk', 'utf8'),
			mb_convert_encoding('注册日期', 'gbk', 'utf8'),
			mb_convert_encoding('最近登录', 'gbk', 'utf8'),
			mb_convert_encoding('状态', 'gbk', 'utf8'),
		));

        $list = $this->_getlist('user','*',$where,'id desc');
        foreach($list as &$v){
			fputcsv($fp,
				array(
					$v['id'],
					mb_convert_encoding($v['account']."\t", 'gbk', 'utf8'), //账号
					mb_convert_encoding($v['nickname']."\t", 'gbk', 'utf8'),
					mb_convert_encoding($v['weixin_proopenid']."\t", 'gbk', 'utf8'),
					mb_convert_encoding($v['money']."\t", 'gbk', 'utf8'),
					mb_convert_encoding($v['redmoney']."\t", 'gbk', 'utf8'),
					mb_convert_encoding($v['foregift']."\t", 'gbk', 'utf8'),
					mb_convert_encoding($v['cash']."\t", 'gbk', 'utf8'),
					mb_convert_encoding(formattime($v['createtime'])."\t", 'gbk', 'utf8'),
					mb_convert_encoding(formattime($v['lasttime'])."\t", 'gbk', 'utf8'),
					mb_convert_encoding($this->user_status[$v['status']]."\t", 'gbk', 'utf8'),
				)
			);
		}

		fclose($fp);
		$fileinfo = pathinfo($filename);
		header('Content-type: application/x-' . $fileinfo['extension']);
		header('Content-Disposition: attachment; filename=' . $fileinfo['basename']);
		header('Content-Length: ' . filesize($filename));
		readfile($filename);
		exit();
    }

    //明细
    public function  user_details($user_id=0,$p=0){
        $page = $this->input->get('page');
        $pagesize = $this->input->get('pagesize');
        if(empty($pagesize))$pagesize = 20;
        $this->assign('p',$p);
        $type=$this->input->get('type');
        $createtime1 = $this->input->get('createtime1');
        $createtime2 = $this->input->get('createtime2');
        $this->assign('get', $this->input->get());

        //处理搜索SQL
        $where='user_id='.$user_id;

        if(!empty($createtime1)){
            $createtime1 = formattime($createtime1.' 00:00:00');
            $where .= " and ctime>=".$createtime1;
        }
        if(!empty($createtime2)){
            $createtime2 = formattime($createtime2.' 23:59:59');
            $where .= " and ctime<=".$createtime2;
        }
        if(is_numeric($type)){
            $where.=' and type='.$type;
        }
        //注意php代码不需要处理搜索URL参数，分页URL的处理注意本页模板页尾的JS代码
        $list= $this->_getpage('finance', $where, 'id desc', $page,  $pagesize);
        foreach ($list['list'] as $k=>$v){
            if($v['type']==0){
                $list['list'][$k]['type_name']="<b style=' color:red'>消费 </b>";
                $list['list'][$k]['order']=$this->_getrow('trade','*',['tradeno'=>$v['order_no']]);
                $list['list'][$k]['symbol']="<b style=' color:red'> -</b>";
            }else if($v['type']==1){
                $list['list'][$k]['type_name']="<b style=' color:green'>充值</b>";
                $list['list'][$k]['order']=$this->_getrow('recharge','*',['rechargeno'=>$v['order_no']]);
                $list['list'][$k]['symbol']="<b style=' color:green'> +</b>";
            }else{
                $list['list'][$k]['type_name']="<b style=' color:green'>订单退款</b>";
                $list['list'][$k]['symbol']="<b style=' color:green'> +</b>";
            }
        }


        $this->assign('list',$list);
        $this->display('user/user_details.html');
    }
    public  function deleteDetails()
    {
        $ids = $this->input->post('ids');
        if (!empty($ids)) {
            //$this->db->where_in('id', explode(',', $ids));
            $this->log_mdl->delete('finance',"id in($ids)");
        }
        die(json_encode(['status'=>1]));
    }
		
	public function tree(){
		$page = $this->input->get('page');
		$pagesize = $this->input->get('pagesize');
		if(empty($pagesize))$pagesize = 20;
		
		$pid = checknull($this->input->get('pid'), 0);	
		$userid = $this->input->get('userid');	
		$status = $this->input->get('status');
		$createtime1 = $this->input->get('createtime1');
		$createtime2 = $this->input->get('createtime2');
		$this->assign('get', $this->input->get());
		
		//处理搜索SQL
		$where = " pid=$pid ";
		if(is_numeric($status)){
			$where .= " and status=$status";	
		}
		if(is_numeric($userid)){
			$where .= ' and id='.$userid;
			$this->assign('get_userid_account', $this->_getfield('user', 'if(account=nickname,concat(id, ", ", account),concat(id, ", ", account, ", ", nickname))', 'id='.$userid));
		}
		if(!empty($createtime1)){
			$createtime1 = formattime($createtime1.' 00:00:00');
			$where .= " and createtime>=".$createtime1;
		}
		if(!empty($createtime2)){
			$createtime2 = formattime($createtime2.' 23:59:59');
			$where .= " and createtime<=".$createtime2;
		}
		
		//注意php代码不需要处理搜索URL参数，分页URL的处理注意本页模板页尾的JS代码
		$user = $this->_getpage('user', $where, 'id desc', $page, $pagesize, 'id,account,nickname,pid,toppid,path');
		foreach($user['list'] as &$v){
			$v['ocount'] = (int)$this->_getcount('trade', 'status=1 and userid='.$v['id']);
			$v['osum'] = (int)$this->_getfield('trade', 'sum(total)', 'status=1 and userid='.$v['id']);
			$v['count1'] = (int)$this->_getcount('user', 'pid='.$v['id']);
			$v['count2'] = (int)$this->_getcount('user', "path REGEXP '^".($v['path'] ? $v['path'].',' : '').$v['id'].",[0-9]+$'");
			$v['count3'] = (int)$this->_getcount('user', "path REGEXP '^".($v['path'] ? $v['path'].',' : '').$v['id'].",[0-9]+,[0-9]+$'");
		}
		unset($v);
		$this->assign('user', $user);
		$this->display('bguser/tree_user.html');
	}

	public function check(){
		$id = $this->input->post('id');
		$account = $this->input->post('account');
		if(!empty($account)){
			$where = "account='".$account."'";
			if(!empty($id))$where .= " and id<>".$id;
			$count = $this->_getcount('user', $where);
			die('{"status":"'.$count.'"}');
		}
		die('{"status":"-1"}');
	}

	public function search(){
		$keywords = $this->input->post('keywords');
		$bindmobile = $this->input->post('bindmobile');
		if(!empty($keywords)){
			if($this->_admin->_role_type != 0){
				$where = "(a.id='".$keywords."' or a.account like '%".$keywords."%' or a.nickname like '%".$keywords."%')";
				if($bindmobile)$where .= " and a.account REGEXP '^[1][3457869][0-9]{9}$'";
				$result1 = $this->_getlist('user as a', 'a.id, if(a.account=a.nickname,concat(a.id, ", ", a.account),concat(a.id, ", ", a.account, ", ", a.nickname)) as `text`', $where, 'a.id desc');
				$where = "( a.id='".$keywords."' or a.account like '%".$keywords."%' or a.nickname like '%".$keywords."%')".$this->_rolesql('b', $this->_admin->_role_type == 1 ? 'admin_corpid' : 'adminid');
				if($bindmobile)$where .= " and a.account REGEXP '^[1][3457869][0-9]{9}$'";
				$result2 = $this->_getlist(array('user as a', array('trade as b', 'a.id=b.user_id')), 'a.id, if(a.account=a.nickname,concat(a.id, ", ", a.account),concat(a.id, ", ", a.account, ", ", a.nickname)) as `text`', $where, 'a.id desc');
				$result = array_merge($result1, $result2);
			}else{
				$where = "(a.id='".$keywords."' or a.account like '%".$keywords."%' or a.nickname like '%".$keywords."%')";
				if($bindmobile)$where .= " and a.account REGEXP '^[1][3457869][0-9]{9}$'";
				$result = $this->_getlist('user as a', 'a.id, if(a.account=a.nickname,concat(a.id, ", ", a.account),concat(a.id, ", ", a.account, ", ", a.nickname)) as `text`', $where, 'a.id desc');
			}
			die('{"status":-1, "data":'.json_encode(multi_array_unique($result)).'}');
		}
		die('{"status":-1, "data":[]}');
	}

    //收货地址
    public function user_address($user_id=0,$p=1){
        $page = $this->input->get('page');
        $pagesize = $this->input->get('pagesize');
        if(empty($pagesize))$pagesize = 20;
        $name=trim($this->input->get('name'));
        $phone=trim($this->input->get('phone'));
        $createtime1 = $this->input->get('createtime1');
        $createtime2 = $this->input->get('createtime2');
        $this->assign('get', $this->input->get());

        //处理搜索SQL
        $where = " user_id=$user_id";

        if($name) $where.=" and name like '%".$name."%'";
        if($phone) $where.=" and phone like '%".$phone."%'";

        if(!empty($createtime1)){
            $createtime1 = formattime($createtime1.' 00:00:00');
            $where .= " and ctime>=".$createtime1;
        }
        if(!empty($createtime2)){
            $createtime2 = formattime($createtime2.' 23:59:59');
            $where .= " and ctime<=".$createtime2;
        }
        //注意php代码不需要处理搜索URL参数，分页URL的处理注意本页模板页尾的JS代码
        $user = $this->_getpage('user_address', $where, 'id desc', $page, $pagesize);

        $this->assign('user_id',$user_id);
        $this->assign('user', $user);
        $this->assign('p',$p);
        $this->display('user/user_address.html');
    }

    public function address_delete(){
        $ids = $this->input->post('ids');
        if(!empty($ids)){
            $this->log_mdl->delete('user_address',"id in($ids)");
        }
        die('{"status":1}');
    }

	/**
	 * メッセージリスト
	 */
    public function message_model(){
        $page = $this->input->get('page');
        $pagesize = $this->input->get('pagesize');
        if(empty($pagesize))$pagesize = 20;
        $userid=$this->input->get('user_id');
        $is_read=$this->input->get('is_read');
        $title=trim($this->input->get('title'));
        $createtime1 = $this->input->get('createtime1');
        $createtime2 = $this->input->get('createtime2');
        $this->assign('get', $this->input->get());

        //处理搜索SQL
        $where = " 1=1";

        if($title) $where.=" and title like '%".$title."%'";

        if(is_numeric($is_read)) $where.=" and is_read=$is_read";
        if(!empty($createtime1)){
            $createtime1 = $createtime1." 00:00:00";
            $where .= " and ctime>='".$createtime1."'";
        }

        if(!empty($createtime2)){
            $createtime2 = $createtime2." 23:59:59";
            $where .= " and ctime<='".$createtime2."'";
        }
        if(is_numeric($userid)){
            $where .= ' and user_id='.$userid;
            $this->assign('get_userid_account', $this->_getfield('user', 'if(account=nickname,concat(id, ", ", account),concat(id, ", ", account, ", ", nickname))', 'id='.$userid));
        }

		// メッセージモデルリスト
		$msg_model_list = $this->_getlist('message_model', '*', $where, 'id desc');

		// 対象のmessage_modelのIDを抽出
		$message_id_arr = array();
		foreach ($msg_model_list as $k => $v) {
			$message_id_arr[] = "'".$v['id']."'";
		}
		$message_id_arr = array_unique($message_id_arr);
		$message_ids = implode(',', $message_id_arr);

		$msgWhere = '';
		if($message_ids){
			$msgWhere = 'message_id in ('.$message_ids.')';
		}

		// messageデータをページング情報を指定して取得
		$list = $this->_getpage('message', $msgWhere, 'id desc', $page, $pagesize);
		
		// messageを基準にuser,message_modelの情報を追加
		foreach ($list['list'] as $k => &$v) {
			$v['nickname'] = $this->_getfield('user', 'nickname', ['id' => $v['user_id']]);
			foreach ($msg_model_list as $mk => $mv) {
				if ($v['message_id'] === $mv['id']){
					$v['title'] = $mv['title'];
					$v['img'] = $mv['img'];
					$v['content'] = $mv['content'];
					break;
				}
			}
        }

        $this->assign('page', $page?:1);
        $this->assign('list', $list);
        $this->display('user/message_model.html');
    }
    //消息详情
    public function message_model_details($id=0){
	    $row=$this->_getrow('message_model','*',['id'=>$id]);
	    $this->assign('row',$row);
        $this->display('user/message_model_details.html');
    }

    //消息列表
    public function message($id=0,$p=1){
        $page = $this->input->get('page');
        $pagesize = $this->input->get('pagesize');
        if(empty($pagesize))$pagesize = 20;
        $userid=$this->input->get('user_id');
        $is_read=$this->input->get('is_read');
        $title=trim($this->input->get('title'));
        $createtime1 = $this->input->get('createtime1');
        $createtime2 = $this->input->get('createtime2');
        $this->assign('get', $this->input->get());

        //处理搜索SQL
        $where = " message_id=$id";

        if($title) $where.=" and title like '%".$title."%'";

        if(is_numeric($is_read)) $where.=" and is_read=$is_read";
        if(!empty($createtime1)){
            $createtime1 = $createtime1." 00:00:00";
            $where .= " and ctime>='".$createtime1."'";
        }

        if(!empty($createtime2)){
            $createtime2 = $createtime2." 23:59:59";
            $where .= " and ctime<='".$createtime2."'";
        }
        if(is_numeric($userid)){
            $where .= ' and user_id='.$userid;
            $this->assign('get_userid_account', $this->_getfield('user', 'if(account=nickname,concat(id, ", ", account),concat(id, ", ", account, ", ", nickname))', 'id='.$userid));
        }
        //注意php代码不需要处理搜索URL参数，分页URL的处理注意本页模板页尾的JS代码
        $list = $this->_getpage('message', $where, 'id desc', $page,$pagesize);
        foreach($list['list'] as $k=>$v){
            $list['list'][$k]['user']=$this->_getrow('user','id,nickname,account,avatar',['id'=>$v['user_id']]);
        }
        $this->assign('list', $list);
        $this->assign('p', $p);
        $this->assign('id',$id);
        $this->display('user/message.html');
    }
    //发送消息
    public function send_message(){
	    $post=$this->input->post();
	    if($post){
            $touserids = array_filter(explode(',', $post['touserids']));
            if(!$touserids)$touserids = $this->_getcol('user', 'id', '1=1');
            unset($post['touserids']);
            $post['ctime']=date('Y-m-d H:i:s');
            $this->db->insert('message_model',$post);
            $message_id=$this->db->insert_id();
            foreach($touserids as $k=>$v){
                $this->db->insert('message',[
                    'img'=>$post['img'],
                    'title'=>$post['title'],
                    'content'=>$post['content'],
                    'message_id'=>$message_id,
                    'user_id'=>$v,
                    'ctime'=>date('Y-m-d H:i:s')
                ]);
            }
            $this->admin_return(1);
	    }
        $this->display('user/send_message.html');
    }

    public function message_delete(){
        $ids = $this->input->post('ids');
        if(!empty($ids)){
            $this->log_mdl->delete('message_model',"id in($ids)");
            $this->log_mdl->delete('message',"message_id in($ids)");
        }
        die('{"status":1}');
    }
}