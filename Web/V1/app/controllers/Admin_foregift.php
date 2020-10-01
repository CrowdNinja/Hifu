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
class Admin_foregift extends Admin_Controller {
	/**
	 * 构造函数
	 *
	 * @access  public
	 * @return  void
	 */
	private $foregift_status = array(1 => '<b style="color:green;">正常</b>', /*0 => '未支付',*/ 2 => '<b style="color:#999">已退还</b>', 3 => '<b style="color:#999">退款中</b>',-1=>'<b style="color:red;">已扣除</b>');
	private $foregift_paytype = array(0 => '人工', 1 => '微信', 2 => '支付宝');
	public function __construct() 
	{
		parent :: __construct();
		$this->load->model('setting_mdl');
		$this->load->model('finance_mdl');
	}

	public function index() 
	{
		$page = $this->input->get('page');
		$pagesize = $this->input->get('pagesize');
		if(empty($pagesize))$pagesize = 20;
		
		$userid = $this->input->get('userid');	
		$user_id = $this->input->get('user_id');
		$status = $this->input->get('status');
		$mac_type=$this->input->get('mac_type');
		$createtime1 = $this->input->get('createtime1');
		$createtime2 = $this->input->get('createtime2');
		$this->assign('get', $this->input->get());
		
		//处理搜索SQL
		$where = ' status!=0 ';
		if(is_numeric($status)){
			$where .= " and status=$status";	
		}
		if(is_numeric($userid)){
			$where .= ' and userid='.$userid;
			$this->assign('get_userid_account', $this->_getfield('user', 'if(account=nickname,concat(id, ", ", account),concat(id, ", ", account, ", ", nickname))', 'id='.$userid));
		}
		if( is_numeric($user_id) ){
		    $where .= " and userid=$user_id";
        }
        if(is_numeric($mac_type)){
            $where.=" and mac_type=$mac_type";
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
		$foregift = $this->_getpage('foregift', $where, 'id desc', $page, $pagesize);
		foreach($foregift['list'] as &$v){
			$v['_userid'] = $this->_getfield('user', 'if(account=nickname,concat(id, ", ", account),concat(id, ", ", account, ", ", nickname))', 'id='.$v['userid']);
		}
		unset($v);
		$this->assign('foregift', $foregift);
		$this->assign('foregift_status', $this->foregift_status);
		$this->assign('foregift_paytype', $this->foregift_paytype);
		$this->display('bguser/list_foregift.html');
	}
    
	public function edit($id=0){
		$foregiftno = $this->input->post('foregiftno');
        if ( !empty($foregiftno) ){
			$count = $this->_getcount('foregift', ($id ? "id<>$id and " : "") . "foregiftno='".$foregiftno."'");
			if($count)die('{"status":0}');
			
			$data = $this->_getdata('foregift', '', $id ? false : 'createtime,paytime,refundtime');
			if($id){
				if($this->db->update('foregift', $data, 'id='.$id)){
					if($data['status'] != '1' && $this->input->post('_status') == '1'){	
						$this->db->set('foregift', 'foregift-'.$data['money'], false);
						$this->db->where('id='.$data['userid']);
						$this->db->update('user');	
						//账目明细
						$this->finance_mdl->add($this->_getrow('foregift', '*', 'id='.$id), 3, array('desc' => '押金无效'));
					}
					if($data['status'] == '1' && $this->input->post('_status') != '1'){	
						$this->db->set('foregift', 'foregift+'.$data['money'], false);
						$this->db->where('id='.$data['userid']);
						$this->db->update('user');	
						//账目明细
						$this->finance_mdl->add($this->_getrow('foregift', '*', 'id='.$id), 2);
					}
				}
			}else{
				if($this->db->insert('foregift', $data)){
					$id = $this->db->insert_id();
					if($data['status'] == '1'){
						$this->db->set('foregift', 'foregift+'.$data['money'], false);
						$this->db->where('id='.$data['userid']);
						$this->db->update('user');	
						//账目明细
						$this->finance_mdl->add($this->_getrow('foregift', '*', 'id='.$id), 2);
					}
				}
			}
			die('{"status":1}');
		}		
		if($id){
			$row = $this->_getrow('foregift', '*', 'id='.$id);
			$row['userid_account'] = $this->_getfield('user', 'if(account=nickname,concat(id, ", ", account),concat(id, ", ", account, ", ", nickname))', "id=".$row['userid']);
			$this->assign('row', $row);
		}		
		$this->assign('foregift_status', $this->foregift_status);
		$this->assign('foregift_paytype', $this->foregift_paytype);
		$this->assign('setting_config', $this->setting_mdl->get('config'));
		$this->display('bguser/edit_foregift.html');
	}

	public function delete(){
		$ids = $this->input->post('ids');
		if(!empty($ids)){
			$this->db->where_in('id', explode(',', $ids));
			$this->db->delete('foregift');	
		}
		die('{"status":1}');	
	}
	
	public function clear(){
		$this->db->delete('foregift', ' 1=1 ');
		die('{"status":1}');	
	}

	public function check(){
		$id = $this->input->post('id');
		$foregiftno = $this->input->post('foregiftno');
		if(!empty($foregiftno)){
			$where = "foregiftno='".$foregiftno."'";
			if(!empty($id))$where .= " and id<>".$id;
			$count = $this->_getcount('foregift', $where);
			die('{"status":"'.$count.'"}');
		}
		die('{"status":"-1"}');
	}
}