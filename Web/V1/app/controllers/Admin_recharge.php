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
class Admin_recharge extends Admin_Controller {
	/**
	 * 构造函数
	 *
	 * @access  public
	 * @return  void
	 */
	 
	private $recharge_status = array(1 => '<b style="color:green;">已完成</b>', 0 => '<b style="color:#999;">未支付</b>',/* 2 => '关闭'*/);
	private $recharge_paytype = array( 4=>"line支付",2 => '微信',3=>"支付宝");
	public function __construct() 
	{
		parent :: __construct();
		$this->load->model('finance_mdl');
	}

	public function index() 
	{
		$page = $this->input->get('page');
		$pagesize = $this->input->get('pagesize');
		if(empty($pagesize))$pagesize = 20;
		
		$userid = $this->input->get('userid');	
		$status = $this->input->get('status');	
		$paytype = $this->input->get('paytype');
		$createtime1 = $this->input->get('createtime1');
		$createtime2 = $this->input->get('createtime2');
		$this->assign('get', $this->input->get());
		
		//处理搜索SQL
		$where = ' 1=1 ';
		if(is_numeric($status)){
			$where .= " and status=$status";	
		}
        if(is_numeric($paytype)){
            $where .= " and paytype=$paytype";
        }
		if(is_numeric($userid)){
			$where .= ' and userid='.$userid;
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
		$recharge = $this->_getpage('recharge', $where, 'id desc', $page, $pagesize);
		foreach($recharge['list'] as &$v){
			$v['_userid'] = $this->_getfield('user', 'if(account=nickname,concat(id, ", ", account),concat(id, ", ", account, ", ", nickname))', 'id='.$v['userid']);
		}
		unset($v);
		$this->assign('recharge', $recharge);
		$this->assign('recharge_status', $this->recharge_status);
		$this->assign('recharge_paytype', $this->recharge_paytype);
		$this->display('recharge/list_recharge.html');
	}

	public function edit($id=0){
		$rechargeno = $this->input->post('rechargeno');
        if ( !empty($rechargeno) ){
			$count = $this->_getcount('recharge', ($id ? "id<>$id and " : "") . "rechargeno='".$rechargeno."'");
			if($count)die('{"status":0}');
			
			$data = $this->_getdata('recharge', '', $id ? false : 'createtime,paytime');
			if($id){
				if($this->db->update('recharge', $data, 'id='.$id)){
					if($data['status'] != '1' && $this->input->post('_status') == '1'){	
						$this->db->set('money', 'money-'.$data['money'], false);
						$this->db->set('redmoney', 'redmoney-'.$data['redmoney'], false);
						$this->db->where('id='.$data['userid']);
						$this->db->update('user');	
						//账目明细
						$this->finance_mdl->add($this->_getrow('recharge', '*', 'id='.$id), 7);
					}
					if($data['status'] == '1' && $this->input->post('_status') != '1'){	
						$this->db->set('money', 'money+'.$data['money'], false);
						$this->db->set('redmoney', 'redmoney+'.$data['redmoney'], false);
						$this->db->where('id='.$data['userid']);
						$this->db->update('user');	
						//账目明细
						$this->finance_mdl->add($this->_getrow('recharge', '*', 'id='.$id), 1);
					}
				}
			}else{
				if($this->db->insert('recharge', $data)){
					$id = $this->db->insert_id();
					if($data['status'] == '1'){
						$this->db->set('money', 'money+'.$data['money'], false);
						$this->db->set('redmoney', 'redmoney+'.$data['redmoney'], false);
						$this->db->where('id='.$data['userid']);
						$this->db->update('user');	
						//账目明细
						$this->finance_mdl->add($this->_getrow('recharge', '*', 'id='.$id), 1);
					}
				}
			}
			die('{"status":1}');
		}		
		if($id){
			$row = $this->_getrow('recharge', '*', 'id='.$id);
			$row['userid_account'] = $this->_getfield('user', 'if(account=nickname,concat(id, ", ", account),concat(id, ", ", account, ", ", nickname))', "id=".$row['userid']);
			$this->assign('row', $row);
		}		
		$this->assign('recharge_status', $this->recharge_status);
		$this->assign('recharge_paytype', $this->recharge_paytype);
		$this->display('bguser/edit_recharge.html');
	}
	
	public function delete(){
		$ids = $this->input->post('ids');
		if(!empty($ids)){
			$this->db->where_in('id', explode(',', $ids));
			$this->db->delete('recharge');	
		}
		die('{"status":1}');	
	}
	
	public function clear(){
		$this->db->delete('recharge', ' 1=1 ');
		die('{"status":1}');	
	}

	public function check(){
		$id = $this->input->post('id');
		$rechargeno = $this->input->post('rechargeno');
		if(!empty($rechargeno)){
			$where = "rechargeno='".$rechargeno."'";
			if(!empty($id))$where .= " and id<>".$id;
			$count = $this->_getcount('recharge', $where);
			die('{"status":"'.$count.'"}');
		}
		die('{"status":"-1"}');
	}
}