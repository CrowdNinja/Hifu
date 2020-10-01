<?php if ( ! defined('IN_DLC')) exit('No direct script access allowed');
 /**
 *  
 *
 * @package     shared.models
 * @subpackage  Models
 * @category    Models
 * @author      
 * @link        
 */
 class Command_mdl extends CI_Model
{
	
	/**
     *  
     *
     * @access  public
     * @return  void
     */
	public function __construct()
	{
		parent::__construct();	
	}
	
	/**
	*  
     *
     * @access  public
     * @param   int
     * @return  object
     */
	public function get_commands_by_parent_id($parent_id = 0,$ismenu = 0,$ids=array())
	{
		$table_command = $this->db->dbprefix('sys_command');
		$this->db->where("$table_command.parent_id", $parent_id);
		if($ids) $this->db->where_in("id",$ids);
		if($ismenu!=-1)
		{
			$this->db->where("$table_command.ismenu", $ismenu);
		}
		$this->db->order_by("sort_order", "asc"); 
		return $this->db->from($table_command)
						->get()
						->result_array();
	}
	
	/**
	*  
     *
     * @access  public
     * @param   int
     * @return  object
     */
	public function get_role_command_by_role_id($role_id,$parent_id=0,$ismenu = 1)
	{
		$table_command = $this->db->dbprefix('sys_command');
		$table_role = $this->db->dbprefix('sys_role_command');
		$this->db->where($table_role.'.role_id', $role_id);
		$this->db->where($table_command.'.parent_id', $parent_id);
		$this->db->where($table_command.'.ismenu', $ismenu);
		$this->db->order_by($table_command.'.sort_order', 'asc'); 
		return $this->db->from($table_command)
		                 ->join($table_role, "$table_role.command_id = $table_command.id")
						->get()
						->result_array();
	}
	
	
	public function exist_role_command_by_role_id($role_id,$command_id)
	{
		$this->db->where('role_id', $role_id);
		$this->db->where('command_id', $command_id);
		return	$this->db->count_all_results('sys_role_command');
	}
	/**
	*  
     *
     * @access  public
     * @param   int
     * @return  object
     */
	public function count_role_command_by_role_id($role_id,$parent_id=0,$ismenu = 1)
	{
		$table_command = $this->db->dbprefix('sys_command');
		$table_role = $this->db->dbprefix('sys_role_command');
		$this->db->where($table_role.'.role_id', $role_id);
		$this->db->where($table_command.'.parent_id', $parent_id);
		$this->db->where($table_command.'.ismenu', $ismenu);
	    $this->db->from($table_command)
		                 ->join($table_role, "$table_role.command_id = $table_command.id");
		return	$this->db->count_all_results();
	}
	
    public function get_role_command($role_id)
    {
    	$table_command = $this->db->dbprefix('sys_command');
		$table_role = $this->db->dbprefix('sys_role_command');
		$this->db->where($table_role.'.role_id', $role_id);
	    $this->db->from($table_command)
		                 ->join($table_role, "$table_role.command_id = $table_command.id");
       	return $this->db->get()->result_array();
    }
	
    
   /**
     * 通过角色ID和URL统计是否存在授权
     *
     * @access  public
     * @param    role_id 角色编号,$url地址
     * @return  object
     */
    public function count_role_command($role_id,$url)
    {	
		$url = rtrim($url, '/');
		$temp = str_replace('/index', '', $url);
		if($temp == '/')$temp = '/index';
		$url = $temp;
		$urls = array(
			$url,
			$url.'/',
			$url.'/index',
			$url.'/index/'
		);
    	$table_command = $this->db->dbprefix('sys_command');
		$table_role = $this->db->dbprefix('sys_role_command');
		$this->db->where_in($table_command.'.link_page', $urls);
		$count = $this->db->from($table_command)->count_all_results();
		if(!$count)return 0;//没有添加的权限默认全无
		$this->db->where($table_role.'.role_id', $role_id);
		$this->db->where_in($table_command.'.link_page', $urls);
	    $this->db->from($table_command)
		                 ->join($table_role, "$table_role.command_id = $table_command.id");
       	return $this->db->count_all_results();
    }
	
	
	/**
	*  
     *
     * @access  public
     * @param   int
     * @return  object
     */
	public function get_command_by_id($id = 0)
	{
		return $this->db->where('id', $id)->get($this->db->dbprefix('sys_command'))->row();
	}
	
	/**
     * 修改
     *
     * @access  public
     * @param   int
     * @param   array
     * @return  bool
     */
	public function edit_command($data)
	{
		return $this->db->where('id', $data['id'])->update($this->db->dbprefix('sys_command'), $data);	
	}
	
	 /**
     * 
     *
     * @access  public
     * @param   uid
     * @return  bool
     */
	public function del_command($id)
	{
		return $this->db->where('id', $id)->delete($this->db->dbprefix('sys_command'));
	}
	/**
     * 添加
     *
     * @access  public
     * @param   array
     * @return  bool
     */
	public function add_command($data)
	{
		return $this->db->insert($this->db->dbprefix('sys_command'), $data);
	}
	
	/**
     * 权限处理
     *
     * @access  public
     * @param   array
     * @return  bool
     */
	public function edit_role_command($role_id,$data)
	{
		$this->db->trans_start();
		$this->db->where('role_id', $role_id)->delete($this->db->dbprefix('sys_role_command'));
		foreach($data as $v)
		{
			$this->db->set('command_id', $v); 
			$this->db->set('role_id', $role_id); 
            $this->db->insert($this->db->dbprefix('sys_role_command')); 
			 
		}
		$this->db->trans_complete();
	    return $this->db->trans_status();
	}
	
}