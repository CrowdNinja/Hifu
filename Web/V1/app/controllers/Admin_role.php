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
class Admin_Role extends Admin_Controller {
	/**
	 * 构造函数
	 *
	 * @access  public
	 * @return  void
	 */
	private $role_type = array(0 => '系统', 1 => '代理商', 2 => '商家',3=>'员工');
	private $menu_list = '';
	public function __construct() 
	{
		parent :: __construct();
		$this->load->model('role_mdl');
	}

	public function home() 
	{
		$data = $this->role_mdl->get_all_role("1=1".$this->_rolesql('','aid'));
		foreach($data as $k=>$v){
		    $data[$k]['aid']=$this->_getfield('admin','nickname',['id'=>$v['aid']]);
        }
		$this->assign('values', $data);
		$this->assign('role_type', $this->role_type);
		$this->display('bguser/list_role.html');
	}

 
	
	public function add()
	{
        if ( !$this->_validate_user_form())
		{
			$this->assign('role_type', $this->role_type);
			$this->display('bguser/add_role.html');
		}
		else
		{
			$result = $this->role_mdl->add_role($this->_get_form_data());
			$this->_message("新增成功", "/admin_role/home", TRUE);
		}
	}
	
	
	public function edit($id=0)
	{
		  
		if ($this->_validate_user_form() == FALSE) {
            $data = $this->role_mdl->get_role_by_id($id);
		    $this->assign('data', $data);
			$this->assign('role_type', $this->role_type);
			$this->display('bguser/edit_role.html');
		} else {
			$result = $this->role_mdl->edit_role_by_id($id,$this->_get_form_data(TRUE));
			$this->_message("修改成功", "/admin_role/home", TRUE);
		}
	}
	
	 
	 public function save($id=0)
	 {
	    $result = $this->role_mdl->edit_role_by_id($id,$this->_get_form_data(TRUE));
	    die('{"msg":"' . translate("修改成功"). '"}');
	 }
	
	
	 
	 
	public function del($id=0)
	{
		 
		if($id > 2)$this->role_mdl->del_role_by_id($id);
		$this->_message('删除成功', '/admin_role/home', TRUE);
	}

    private function _validate_user_form()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', "名称", 'required');
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
		if($edit)
		{
			$data['id'] = $this->input->post('id', TRUE);
		}
		$data['type'] = $this->input->post('type', TRUE);
		$data['title'] = $this->input->post('title', TRUE);
		$data['memo'] = $this->input->post('memo', TRUE);
		$data['aid'] = $this->_admin->id?:1;
		return $data;
	}
}