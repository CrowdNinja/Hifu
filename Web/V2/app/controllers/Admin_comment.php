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
class Admin_comment extends Admin_Controller {
	/**
	 * 构造函数
	 *
	 * @access  public
	 * @return  void
	 */
	 
	private $comment_status = array(1 => '显示', 0 => '隐藏');
	public function __construct() 
	{
		parent :: __construct();
	}

	public function index() 
	{
		$page = $this->input->get('page');
		$pagesize = $this->input->get('pagesize');
		if(empty($pagesize))$pagesize = 20;
		
		$status = $this->input->get('status');
		$createtime1 = $this->input->get('createtime1');
		$createtime2 = $this->input->get('createtime2');
		$this->assign('get', $this->input->get());
		
		//处理搜索SQL
		$where = ' type=2 '.$this->_rolesql();
		
		if(is_numeric($status)){
			$where .= " and status=$status";	
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
		$comment = $this->_getpage('comment', $where, 'id desc', $page, $pagesize);
		
		foreach($comment['list'] as &$v){
			$v['_userid'] = $this->_getfield('user', "concat(id,', ',account)", "id=".$v['userid']);
			$v['_adminid'] = $this->_getfield('admin', "concat(id,', ',nickname)", "id=".$v['adminid']);
		}
		unset($v);
		$this->assign('comment', $comment);
		$this->assign('comment_status', $this->comment_status);
		$this->display('bguser/list_comment.html');
	}

	public function update(){
		$ids = $this->input->post('id');
		$status = $this->input->post('status');
		if(!empty($ids)){
			$data = array();
			foreach($ids as $v){
				$data[] = array('id' => $v, 'status' => $status[$v]);
			}
			$this->db->where(" 1=1 ".$this->_rolesql());
			$this->db->update_batch('comment', $data, 'id');
		}
		die('{"status":1}');	
	}	
	
	public function delete(){
		$ids = $this->input->post('ids');
		if(!empty($ids)){
			$this->db->where(' type=2 '.$this->_rolesql());
			$this->db->where_in('id', explode(',', $ids));
			$this->db->delete('comment');	
		}
		die('{"status":1}');	
	}
	
	public function clear(){
		$this->db->delete('comment', ' type=2 '.$this->_rolesql());
		die('{"status":1}');	
	}
}