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
class Shoptree_mdl extends DLC_Model
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
	
	//$ids有权限的ID
	function search_row($keyword = '', $ids = false, $fields = false){
		if(is_array($ids))$ids = implode(',', $ids);
		if(is_numeric($keyword)){
			$where = "gid in (".implode(",", $this->_role[2]).") and id='".$keyword."'";
			if($ids)$where .= " and id in ($ids)";
			$row = $this->_getrow('admin', '*', $where);
		}
		if(!$row){
			$where = "gid in (".implode(",", $this->_role[2]).") and (adminname='".$keyword."' or nickname='".$keyword."')";
			if($ids)$where .= " and id in ($ids)";
			$row = $this->_getrow('admin', '*', $where);
		}
		if($row){
			//$row['_child'] = implode(',', $this->_getcol('admin', 'id', "pid=".$row['id']));
			$row['_allchild'] = trim($row['id'].','.implode(',', $this->_getcol('admin', 'id', "find_in_set(".$row['id'].", path)>0")), ',');
			$row['_strpath'] = !$row['path'] ? $row['nickname'] : implode(' &gt; ', $this->_getcol('admin', 'nickname', "id in (".$row['path'].")", "field(id, '".$row['path']."')")).' &gt; '.$row['nickname'];
			$row['_grade'] = $row['path'] ? count(explode(',', $row['path'])) : 0;
		}
		if($fields){
			if(!is_array($fields))$fields = explode(',', $fields);	
			$temp = array();
			foreach($fields as $v)$temp[$v] = $row[$v];
			$row = $temp;
		}
		return $row;
	}

	//$ids有权限的ID
	function get_row($id, $ids = false, $fields = false){
		if(is_array($ids))$ids = implode(',', $ids);
		$where = "gid in (".implode(",", $this->_role[2]).") and id=$id";
		if($ids)$where .= " and id in ($ids)";
		$row = $this->_getrow('admin', '*', $where);
		$row = $this->_getrow('admin', '*', $where);
		if($row){
			//$row['_child'] = implode(',', $this->_getcol('admin', 'id', "pid=".$row['id']));
			$row['_allchild'] = trim($row['id'].','.implode(',', $this->_getcol('admin', 'id', "find_in_set(".$row['id'].", path)>0")), ',');
			$row['_strpath'] = !$row['path'] ? $row['nickname'] : implode(' &gt; ', $this->_getcol('admin', 'nickname', "id in (".$row['path'].")", "field(id, '".$row['path']."')")).' &gt; '.$row['nickname'];
			$row['_grade'] = $row['path'] ? count(explode(',', $row['path'])) : 0;
		}
		if($fields){
			if(!is_array($fields))$fields = explode(',', $fields);	
			$temp = array();
			foreach($fields as $v)$temp[$v] = $row[$v];
			$row = $temp;
		}
		return $row;
	}
}
