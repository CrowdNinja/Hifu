<?php if ( ! defined('IN_DLC')) exit('No direct script access allowed');
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
 class Admin_Bguser extends Admin_Controller
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
	}
	
	public function index()
	{
		$admins = $this->admin_mdl->get_admins(" gid in (".implode(",", $this->_role[0]).")");
		$this->assign("data",$admins);
		$this->display('bguser/list_bguser.html');
	}
	
	public function orderby(){
		$orderby = $this->input->post('orderby');
		foreach($orderby as $k => $v){
			$this->db->where('id='.$k)->update('admin', array('orderby' => $v));
		}
		echo json_encode(array('status' => 1));
	}
	
	
	public function edit($id=0)
	{
		//if($id==1)
		//{
		//	$this->_message('admin不可以更改', '/admin_bguser/', TRUE);
		//	exit;
		//}
		if ($this->_validate_user_form() == FALSE) {
            $data = $this->admin_mdl->get_admin_by_id($id);
            $this->load->model('role_mdl');
            $roles = $this->role_mdl->get_all_role("id in (".implode(",", $this->_role[0]).")");
		    $this->assign('data', $data);
			$this->assign('roles',$roles);			
			$this->display('bguser/edit_bguser.html');
		} else {
			$data = $this->_get_form_data(TRUE);
			if(!$this->admin_mdl->chk_admin($id, $data['adminname']))die('{"msg":"账号已存在"}');
			$result = $this->admin_mdl->edit_admin_by_id($id,$data);
			$this->_message('修改成功.', '/admin_bguser/', TRUE);
		}		 
	}
	
	public function delete($id=0){
		$result = $this->admin_mdl->del_user($id);
		if($result){
			$this->_message('删除成功.', '/admin_bguser/', TRUE);
			exit;
		}
		$this->_message('操作员不允许删除.', '/admin_bguser/', TRUE);
	}
	
	public function save($id=0){
		$data = $this->_get_form_data(TRUE);
		if(!$this->admin_mdl->chk_admin($id, $data['adminname']))die('{"msg":"账号已存在"}');
	    $result = $this->admin_mdl->edit_admin_by_id($id,$data);
		die('{"msg":"修改成功","redirect":"admin_system#page/admin_bguser/"}');
	}
	
	public function save_pwd(){
		$id = $this->input->post('pk');
		$name = $this->input->post('name');
		$value = $this->input->post('value');
		$result = $this->admin_mdl->edit_admin_by_id($id, array($name => $value));
		die('{"msg":"修改成功"}');
	}
	
	public function add()
	{
		if ( !$this->_validate_user_form())
		{
			$this->load->model('role_mdl');
			$roles = $this->role_mdl->get_all_role("id in (".implode(",", $this->_role[0]).")");
			$this->assign('roles',$roles);
			$this->display('bguser/add_bguser.html');
		}
		else
		{
			$data = $this->_get_form_data();
			if(!$this->admin_mdl->chk_admin(0, $data['adminname']))die('{"msg":"账号已存在"}');
			$this->admin_mdl->add_admin($data);
			$this->_message("新增成功.", "/admin_bguser/", TRUE);
		}
	}
	
	public function save_add(){
		//if ($this->_validate_user_form()){
			$data = $this->_get_form_data();
			if(!$this->admin_mdl->chk_admin(0, $data['adminname']))die('{"msg":"账号已存在"}');
			$this->admin_mdl->add_admin($data);
			die('{"msg":"新增成功","redirect":"admin_system#page/admin_bguser/"}');
		//}else{
		//	die('{"msg":"新增失败"}');
		//}
	}

	public function check(){
		$id = $this->input->post('id');
		$adminname = $this->input->post('adminname');
		if(!empty($adminname)){
			$count = $this->admin_mdl->chk_admin($id, $adminname) ? 0 : 1;
			die('{"status":"'.$count.'"}');
		}
		die('{"status":"-1"}');
	}
	
	 private function _validate_user_form($edit=FALSE)
	{
		$this->load->library('form_validation');
		if(!$edit)
		{
			$this->form_validation->set_rules('adminName', '用户名', 'trim|required|min_length[3]|max_length[16]');
		}
		$this->form_validation->set_rules('password', '密码', 'trim|required|min_length[6]|max_length[16]');
		$this->form_validation->set_rules('repasswd', '重复用户密码', 'trim|required|min_length[6]|max_length[16]|matches[password]');
		if ($this->form_validation->run() == FALSE)
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	/* 获取表单数据
	*
	* @access  private
	* @param   bool
	* @return  array
	*/
	private function _get_form_data($edit = FALSE)
	{
		//if(!$edit)
		//{
			$data['adminname'] = $this->input->post('adminname', TRUE);
		//}
		$data['nickname'] = $this->input->post('nickname', TRUE);
		$data['password'] = $this->input->post('password', TRUE);
		$data['gid'] = $this->input->post('gid', TRUE);
		$data['status'] = $this->input->post('status', TRUE);	
		if(!$edit)$data['createtime'] = time();	
		return $data;
	}
}