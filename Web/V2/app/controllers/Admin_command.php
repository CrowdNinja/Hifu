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
class Admin_Command extends Admin_Controller {
	/**
	 * 构造函数
	 *
	 * @access  public
	 * @return  void
	 */
	private $menu_list = '';
	private $role_menu = '';
	public function __construct() 
	{
		parent :: __construct();
		$this->load->model('command_mdl');
		$this->load->model('role_mdl');
	}

	public function home() 
	{
		
		$parentId = $this->uri->segment(3, 0);
		$menus = $this->command_mdl->get_commands_by_parent_id($parentId, -1);
		$tree = $this->_get_command(0);
		$this->assign('parentId', $parentId);
		$this->assign('tree', $tree);
		$this->assign('menus', $menus);
		$this->display('bguser/list_command.html');
	}
	
	 


	public function _get_command($parent = 0,$role_command = FALSE,$ids=[])
	{
		
		$data = $this->command_mdl->get_commands_by_parent_id($parent, -1,$ids);
		if ($data) {
			$this->menu_list .= '<ul>';
			foreach ($data as $v)
			 {
			 	if( $role_command !== false )
			 	{
			 		$this->menu_list .= '<li><input type="checkbox" name="hasPower[]" '. ( $role_command === true || (is_array($role_command) && in_array($v['id'], $role_command)) ?  'checked="checked"' : '' ) .' value="'.$v['id'].'"/> <span><i class="glyphicon glyphicon-minus-sign"></i></span>' . translate($v['title']);
			 	}
			 	else
			 	{
			 		$this->menu_list .= '<li> <span><i class="glyphicon glyphicon-minus-sign"></i></span> <a href="admin_system#page/admin_command/home/'.$v['id'].'">' . translate($v['title']). '</a>';
			 	}
				
				$this->_get_command($v['id'],$role_command,$ids);
				$this->menu_list .= '</li>';
			}
			$this->menu_list .= '</ul>';
		}
		return $this->menu_list;
	}
	
	public function edit_role_command($role_id=0)
	{
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('roleId', "角色", 'required');
		if ($this->form_validation->run() == FALSE)
		{
			$id = $this->uri->segment(3, 0);
			
            $data = $this->role_mdl->get_role_by_id($id);
		    $this->assign('data', $data);
            $commands=[];
            if($this->_admin->_role_type!=0){
                $commands=$this->_getcol("sys_role_command","command_id","role_id=".$_SESSION['gid']);
            }
			$tree = $this->_get_command(0, $this->_getcol( 'sys_role_command', 'command_id', 'role_id='.$id ) ,$commands);
			$this->assign('id', $id);
			$this->assign('tree', $tree);
			$this->display('bguser/edit_role_command.html');
			 
		}
		else
		{
			 
			 $power = $this->input->post('hasPower', TRUE);
			 if(!$power)
			 {
			 	$this->_message('请选择权限列表', "/admin_role/home", TRUE);
			 	exit;
			 }
			 $result = $this->command_mdl->edit_role_command($role_id,$power);
			if($result)
			{
                 
			   /* $this->role_menu = '';//<li class=""><a data-url="page/index" href="ajax.html#page/index"><i class="menu-icon fa fa-tachometer"></i><span class="menu-text"> Dashboard </span></a><b class="arrow"></b></li>';
			    $this->_get_parent_role_menus($role_id,0);
			    
		        $this->load->helper('file');
		         write_file('./app/views/acl/left_menus_'.$role_id.'.txt',  $this->role_menu,'w+');    */
				$this->_message(translate('权限修改成功'), "/admin_role/home", TRUE);
			}else{
			  $this->_message(translate('权限修改失败'), "/admin_role/home", TRUE);
			}
		}
	}
	
	private function _get_parent_role_menus($role_id=0,$parent_id=0)
	{
		$roles = $this->command_mdl->get_role_command_by_role_id($role_id,$parent_id);
		foreach ($roles as $v)
		{
			if($this->command_mdl->count_role_command_by_role_id($role_id,$v['command_id'])>0)
			{
				$this->role_menu .='<li class=""><a href="#" class="dropdown-toggle"><i class="menu-icon '.$v['icon_css'].'"></i><span class="menu-text"> '.$v['title'].' </span><b class="arrow fa fa-angle-down"></b></a><b class="arrow"></b><ul class="submenu">';
				$this->_get_child_role_menus($role_id,$v['command_id']);
				$this->role_menu .='</ul></li>';
			}else
			{
				$this->role_menu .= '<li class=""><a data-url="page'.$v['link_page'].'" href="admin_system#page'.$v['link_page'].'"><i class="menu-icon fa fa-list-alt"></i><span class="menu-text"> '.$v['title'].' </span></a><b class="arrow"></b></li>';
				
			}
		}
		 
	}
	private function _get_child_role_menus($role_id=0,$parent_id=0)
	{
		
		$roles = $this->command_mdl->get_role_command_by_role_id($role_id,$parent_id);
		foreach ($roles as $v)
		{
			   $this->role_menu .= '<li class=""><a data-url="page'.$v['link_page'].'" href="admin_system#page'.$v['link_page'].'"><i class="menu-icon fa fa-caret-right"></i> '.$v['title'].' </a><b class="arrow"></b></li>';
			  
		}
		 
		
	}
	
	 
	
	
	public function edit($parent_id=0,$id=0) 
	{
		 if($id == 0)
		 {
		 	$parent_id = $this->uri->segment(3, 0);
			$this->assign('parentId', $parent_id);
			$this->display('bguser/add_command.html');
		 }
		 else
		 {
		 	$parent_id = $this->uri->segment(3, 0);
			$id = $this->uri->segment(4, 0);
            $data = $this->command_mdl->get_command_by_id($id);
		    $this->assign('data', $data);
		    $this->assign('id', $id);
			$this->assign('parentId', $parent_id);
			$this->display('bguser/edit_command.html');
		 }
		 
	}
	
	public function save($id=0)
	{
		$this->load->library('form_validation');
	    $data = $this->_get_form_data();
	    $msg['status'] =FALSE;
	    if(!$this->form_validation->required($data['title']))
		{
		  $msg['msg'] = translate('名称必填');
		  echo json_encode($msg);
		  return;
		}
		if($id==0)
		{
			$result = $this->command_mdl->add_command($this->_get_form_data());
			if($result)
			{
				$msg['msg'] =translate('新增成功');
				$msg['status'] =TRUE;
				$msg['redirect']='admin_system#page/admin_command/home/0/';
				
			}else{
				$msg['msg'] =translate('新增失败');
			}
			
		}
		else
		{
			$result = $this->command_mdl->edit_command($this->_get_form_data(TRUE));
			if($result)
			{
				$msg['msg'] =translate('修改成功');
				$msg['status'] =TRUE;
				$msg['redirect']='admin_system#page/admin_command/home/0/';
				
			}else{
				$msg['msg'] =translate('修改失败');
			}
		}
		echo json_encode($msg);
	    
	}
	public function del($id=0)
	{
		 
		$this->command_mdl->del_command($id);
		$this->_message(translate('删除成功'), '/admin_command/home/0', TRUE);
	}

    private function _validate_user_form()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', "名称", 'required');
		$this->form_validation->set_rules('sortOrder', "排序", 'required');
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
		$data['title'] = $this->input->post('title', TRUE);
		$data['ismenu'] = $this->input->post('ismenu', TRUE);
		$data['sort_order'] = $this->input->post('sortOrder', TRUE);
		$data['link_page'] = $this->input->post('linkPage', TRUE);
		$data['parent_id'] = $this->input->post('parentId', TRUE);
		if($data['parent_id']==0)
		{
			$data['icon_css'] = $this->input->post('icon', TRUE);
		}
		return $data;
	}
}