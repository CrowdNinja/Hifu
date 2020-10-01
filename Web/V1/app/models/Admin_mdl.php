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
class Admin_mdl extends DLC_Model
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
		$this->load->model('finance_mdl');
	}

	public function cash($data, $id = 0){
		if(empty($data['adminid']))return false;
		$flag = false;
		if($data['status'] == '1'){
			if($data['_status'] != '1'){
				//加入已提现
				$flag = true;
				$this->db->set('cash', 'cash+'.$data['money'], false);
				$this->db->set('money', 'money-'.$data['money'], false);
				//账目明细
				if($id)$this->finance_mdl->add($this->_getrow('admin_cash', '*', 'id='.$id), 5);
			}
		}else{
			if($data['_status'] == '1'){
				//取消已提现
				$flag = true;
				$this->db->set('cash', 'cash-'.$data['money'], false);
				$this->db->set('money', 'money+'.$data['money'], false);
				//账目明细
				if($id)$this->finance_mdl->add($this->_getrow('admin_cash', '*', 'id='.$id), 6);
			}
		}
		if(!$flag)return false;
		$this->db->where("id=".$data['adminid']);
		return $this->db->update('admin');
	}
	
	//可提现余额
	public function cash_money($id = 0){
		if($id){
			$cash_money = floatval($this->_getfield('admin_cash', "sum(money)", "status=0 and adminid=".$id));//未完成提现//锁定
			$admin_money = $this->_getfield('admin', "money", "id=".$id);//余额
		}else{
			$cash_money = floatval($this->_getfield('admin_cash', "sum(money)", "status=0"));//未完成提现//锁定
			$admin_money = $this->_getfield('admin', "sum(money)", "1=1");//余额
		}
		return $admin_money + $cash_money;
	}
	
	//获取余额调整结果
	public function new_money($id, $edit_money = 0){
		$cash_money = floatval($this->_getfield('admin_cash', "sum(money)", "status=0 and adminid=".$id));//未完成提现//锁定
		return $edit_money + $cash_money;
	}

	//删除或独立调整下线层级树
	public function fixpath($ids){
		if(!is_array($ids))$ids = explode(',', $ids);
		foreach($ids as $k => $v){
			if(empty($v))continue;
			$childs = $this->_getlist('admin', 'id,path', "FIND_IN_SET('".$v."', path)>0");
			if(!empty($childs)){
				foreach($childs as $kk => $vv){
					if($vv['id'] == $v)continue;//排除自己
					$path = trim(str_replace(','.$v.',', '', ','.$vv['path'].','), ',');
					$paths = explode(',', $path);
					$toppid = intval(current($paths));
					$pid = intval(end($paths));
					$this->db->update('admin', array('pid' => $pid, 'toppid' => $toppid, 'path' => $path), "id=".$vv['id']);
				}
			}
		}
	}
	
	public function fixcorp($id, $newcorpid = 0){
		if(!is_numeric($newcorpid))return false;
		return $this->db->update('admin', array('corpid' => $newcorpid), "FIND_IN_SET('".$id."', path)>0");
	}
	
	// ------------------------------------------------------------------------

    /**
     * 根据用户名或者用户UID称获取该用户完整的信息
     *
     * @access  public
     * @param   $username 帐号,$type 类型
     * @return  object
     */
	public function get_full_admin_by_username($username = '', $type = 'username')
	{
		$table_admins = $this->db->dbprefix('admin');
		if ($type == 'id')
		{
			$this->db->where($table_admins . '.id', $username);
			
		}
		else
		{
			 $this->db->where($table_admins . '.adminname', $username);
			 
		}
		return $this->db->select("*")
							  ->from($table_admins)
							  ->get()
							  ->row();
	}
	
	// ------------------------------------------------------------------------

    /**
     * 根据用户ID获取用户信息
     *
     * @access  public
     * @param   int
     * @return  object
     */
	public function get_admin_by_id($id = 0)
	{
		return $this->db->where(is_numeric($id) ? "id=$id" : $id)->get($this->db->dbprefix('admin'))->row();
	}

	// ------------------------------------------------------------------------

    /**
     * 根据用户名获取用户信息
     *
     * @access  public
     * @param   string
     * @return  object
     */
	public function get_admin_by_name($username)
	{
		return $this->db->where('adminname', $username)->get($this->db->dbprefix('admin'))->row();
	}
	
	// ------------------------------------------------------------------------

    /**
     * 用户自己密码
     *
     * @access  public
     * @return  bool
     */
	public function update_admin_password()
	{
        $data['pass']=$this->input->post('passwd', TRUE);
		$data['password'] = md5($this->input->post('passwd', TRUE));
		 
		 
		return $this->db->where('id', $this->_admin->id)->update($this->db->dbprefix('admin'), $data);		
	}

	// ------------------------------------------------------------------------

	public function chk_admin($id, $adminname){
		if(empty($adminname))return true;
		return $this->_getcount('admin', "id<>".intval($id)." and adminname='$adminname'") ? false : true;	
	}
  

    /**
     * 添加用户
     *
     * @access  public
     * @param   array
     * @return  bool
     */
	public function add_admin($data)
	{
		$data['password'] = md5($data['password']);
		$this->db->insert($this->db->dbprefix('admin'), $data);
		return $this->db->insert_id();
	}
	
	// ------------------------------------------------------------------------

    /**
     * 修改用户
     *
     * @access  public
     * @param   int
     * @param   array
     * @return  bool
     */
	public function edit_admin_by_id($id, $data)
	{
		if (!empty($data['password']))
		{			 
			$data['password'] = md5($data['password']);
		}else{
			unset($data['password']);
		}
		if(intval($id) === 1){
			unset($data['adminname']);
			unset($data['gid']);
			unset($data['status']);
		}
		return $this->db->where(is_numeric($id) ? "id=$id" : $id)->update($this->db->dbprefix('admin'), $data);	
	}
	
	// ------------------------------------------------------------------------

    /**
     * 删除用户
     *
     * @access  public
     * @param   uid
     * @return  bool
     */
	public function del_user($id)
	{
		if(intval($id) === 1)return false;
		return $this->db->where(is_numeric($id) ? "id=$id" : $id)->delete($this->db->dbprefix('admin'));
	}
    
    /*
	*  
     *
     * @access  public
     * @param   int
     * @return  object
     */
	public function get_admins($where = '1=1')
	{
		$table_admin = $this->db->dbprefix('admin');
		$list = $this->db->from($table_admin)
						->where($where)
						->order_by('orderby desc', '', false)
						->get()
						->result();
		foreach($list as $k => &$v){
			$v->_gid = $this->_getfield('sys_role', 'title', 'id='.$v->gid);
		}
		unset($v);
		return $list;
	}
	// ------------------------------------------------------------------------
	
}

/* End of file admin_mdl.php */
/* Location: ./admin/models/admin_mdl.php */