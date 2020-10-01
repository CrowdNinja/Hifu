<?php if ( ! defined('IN_DLC')) exit('No direct script access allowed');
/**
 *  
 *
 * @package     admin.models
 * @subpackage  Models
 * @category    Models
 * @author      
 * @link         
 */
class User_mdl extends DLC_Model
{
	
	/**
     * 构造函数
     *
     * @access  public
     * @return  void
     */
	public function __construct()
	{
		parent::__construct();	
		$this->load->model('setting_mdl');
		$this->load->model('finance_mdl');
	}
	
	
	public function update($where = false, $data = false){
		if(empty($data)){
			$this->db->set('lasttime', time());
			$this->db->set('lastip', $this->input->ip_address());
			$this->db->set('logincount', 'logincount+1', false);
			$this->db->where(is_numeric($where) ? "id=$where" : $where);
			return $this->db->update('user');
		}
		return $this->db->update('user', $data, is_numeric($where) ? "id=$where" : $where);
	}
	
	public function login($account, $status = 1){
		if(empty($account)){
			return false;	
		}
		return $this->_getrow('user', '*', "account='$account' and status=$status");
	}

	//删除或独立会员调整下线层级树
	public function fixpath($ids){
		if(!is_array($ids))$ids = explode(',', $ids);
		foreach($ids as $k => $v){
			if(empty($v))continue;
			$childs = $this->_getlist('user', 'id,path', "FIND_IN_SET('".$v."', path)");
			if(!empty($childs)){
				foreach($childs as $kk => $vv){
					if($vv['id'] == $v)continue;//排除自己
					$path = trim(str_replace(','.$v.',', '', ','.$vv['path'].','), ',');
					$paths = explode(',', $path);
					$toppid = intval(current($paths));
					$pid = intval(end($paths));
					$this->db->update('user', array('pid' => $pid, 'toppid' => $toppid, 'path' => $path), "id=".$vv['id']);
				}
			}
		}
	}
	
	public function cash($data, $id = 0){
		if(empty($data['userid']))return false;
		$flag = false;
		if($data['status'] == '1'){
			if($data['_status'] != '1'){
				//加入已提现
				$flag = true;
				$this->db->set('cash', 'cash+'.$data['money'], false);
				$this->db->set('money', 'money-'.$data['money'], false);
				//账目明细
				if($id)$this->finance_mdl->add($this->_getrow('user_cash', '*', 'id='.$id), 5);
			}
		}else{
			if($data['_status'] == '1'){
				//取消已提现
				$flag = true;
				$this->db->set('cash', 'cash-'.$data['money'], false);
				$this->db->set('money', 'money+'.$data['money'], false);
				//账目明细
				if($id)$this->finance_mdl->add($this->_getrow('user_cash', '*', 'id='.$id), 6);
			}
		}
		if(!$flag)return false;
		$this->db->where("id=".$data['userid']);
		return $this->db->update('user');
	}

	//可提现余额
	public function cash_money($id){
		$cash_money = floatval($this->_getfield('user_cash', "sum(money)", "status=0 and userid=".$id));//未完成提现//锁定
		$user_money = $this->_getfield('user', "money", "id=".$id);//余额
		return $user_money - $cash_money;
	}
	
	//获取余额调整结果
	public function new_money($id, $edit_money = 0){
		$cash_money = floatval($this->_getfield('user_cash', "sum(money)", "status=0 and userid=".$id));//未完成提现//锁定
		return $edit_money + $cash_money;
	}
}
