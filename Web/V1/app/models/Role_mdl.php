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
 class Role_mdl extends CI_Model
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
	/*
	*  
     *
     * @access  public
     * @param   int
     * @return  object
     */
	public function get_all_role($where = "1=1")
	{
		$table_role = $this->db->dbprefix('sys_role');
		return $this->db->from($table_role)
						->where($where)
						->get()
						->result_array();
	}
	
	
	
	
	
	/**
     * 修改
     *
     * @access  public
     * @param   int
     * @param   array
     * @return  bool
     */
	public function edit_role_by_id($id,$data)
	{
		return $this->db->where('id', $id)->update($this->db->dbprefix('sys_role'), $data);	
	}
	
	 /**
     * 
     *
     * @access  public
     * @param   uid
     * @return  bool
     */
	public function del_role_by_id($id)
	{
		$this->db->trans_start();
		$this->db->where('id', $id)->delete($this->db->dbprefix('sys_role'));
		$this->db->where('role_id', $id)->delete($this->db->dbprefix('sys_role_command'));
		$this->db->trans_complete();
	    return $this->db->trans_status();
	}
	
	/*
	*  
     *
     * @access  public
     * @param   int
     * @return  object
     */
	public function get_role_by_id($id = 0)
	{
		return $this->db->where('id', $id)->get($this->db->dbprefix('sys_role'))->row();
	}
	/**
     * 添加
     *
     * @access  public
     * @param   array
     * @return  bool
     */
	public function add_role($data)
	{
		return $this->db->insert($this->db->dbprefix('sys_role'), $data);
	}
}