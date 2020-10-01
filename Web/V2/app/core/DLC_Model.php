<?php
/**
 *
 * 模型继承类
 *
 * @copyright www.locojoy.com
 * @author lihuixu@joyogame.com
 * @version v1.0 2015.3.20
 *
 */
class DLC_Model extends CI_Model
{
	private $_role = NULL;
    public function __construct()
    {
		parent::__construct();
        $this->load->database();
		$this->load->library('session');
		$this->_role = $this->_getcol('sys_role', 'type,id');
		if(empty($this->_role[0]))$this->_role[0] = array(0);
		if(empty($this->_role[1]))$this->_role[1] = array(0);
		if(empty($this->_role[2]))$this->_role[2] = array(0);
    }
	
	public function _log($log){
		$this->log->write_log('error', var_export($log, true));
	}
	
	//代理拥有权限的商家或下级
	public function _corpaids($corpid, $shop = true){
		$this->load->model('corptree_mdl');
		$row = $this->corptree_mdl->get_row($corpid);
		if($shop && $row['_allchild']){//医院
			$ids = $this->_getcol('admin', 'id', "corpid in (".$row['_allchild'].")");
			if($ids)$row['_allchild'] .= ','.implode(',', $ids);
		}
		return $row['_allchild'];
	}
	
	public function _rolerow($aid, $gid){
		$row = array();
		if(in_array($gid, $this->_role[1])){
			$this->load->model('corptree_mdl');
			$row = $this->corptree_mdl->get_row($aid);
			if($row['_allchild']){//医院//供应商
				$ids = $this->_getcol('admin', 'id', "corpid in (".$row['_allchild'].")");
				if($ids)$row['_allchild'] .= ','.implode(',', $ids);
			}
		}elseif(in_array($gid, $this->_role[2])){
			$this->load->model('shoptree_mdl');
			$row = $this->shoptree_mdl->get_row($aid);
		}
		return $row;
	}
	
	public function _rolepid($pid = 0, $role_type = 1){
		$aid = $this->_admin->id;
		$gid = $this->_admin->gid;
		$type = 1;
		if(in_array($gid, $this->_role[1]))$type = 1;
		if(in_array($gid, $this->_role[2]))$type = 2;
		if($type != $role_type)return $pid;
		if(!in_array($gid, $this->_role[0])){
			$row = $this->_rolerow($aid, $gid);
			$aids = $row['_allchild'];
			if(!$aids)$aids = $aid;
			$aids = explode(',', $aids);
			if(in_array($pid, $aids))return $pid;
			return $aid;
		}
		return $pid;
	}
	
	public function _rolesql($alias = '', $field = 'adminid', $adminid = 0){		
		if($adminid){
			$admin = $this->_getrow('admin', 'id,gid', "id=$adminid");
			$aid = $admin['id'];
			$gid = $admin['gid'];
		}else{
			$aid = $this->_admin->id;
			$gid = $this->_admin->gid;
		}
		if(!in_array($gid, $this->_role[0])){
			$row = $this->_rolerow($aid, $gid);
			$aids = $row['_allchild'];
			if(!$aids)$aids = $aid;
			return " and ".($alias ? $alias.'.' : '').$field." in (".$aids.") ";
		}
		return '';
	}
	
	//有权限的所有id
	public function _roleids(){
		$aid = $this->_admin->id;
		$gid = $this->_admin->gid;
		if(!in_array($gid, $this->_role[0])){
			$row = $this->_rolerow($aid, $gid);
			$aids = $row['_allchild'];
			if(!$aids)$aids = $aid;
			return $aids;
		}
		return -1;
	}
 
	public function _getpage($table, $where, $order = false, $page = 1, $page_size = 20, $field = '*'){
		$result = array();
		
		if(is_array($field)){
			if(isset($field[2])){
				$total_rows = $this->_getcount($table, $where, $field);//having
			}else{
				$total_rows = $this->_getfield($table, 'COUNT(DISTINCT '.$field[1].')', $where);
			}
		}else{
			$total_rows = $this->_getcount($table, $where);	
		}

		$result['total'] = $total_rows;
		$result['totalpage'] = ceil($total_rows / $page_size);
		if(empty($page))$page = 1;
		if($page > $result['totalpage'])$page = $result['totalpage'];
		$result['page'] = $page;
		$offset = $page_size * ($page -1);		
		if($offset < 0)$offset = 0;	
		
		$this->load->library('pagination');
		//$base_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$this->pagination->init($total_rows,$base_url,$page_size);		
		$result['pages'] = $this->pagination->create_links();
		
		$result['list'] = $this->_getlist($table, $field, $where, $order, array($offset, $page_size));
		//$result['sql'] = $this->db->last_query();
		
		return $result;
	}

	public function _getcount($table, $where = '', $field = false){
		if(is_array($field)){
			$this->db->select($field[0].',count(*)');
			if(!empty($field[1]))$this->db->group_by($field[1]);
			if(!empty($field[2]))$this->db->having($field[2]);
		}elseif($field){
			$this->db->select($field.',count(*)');
		}
		if($where)$this->db->where($where);
		if(is_array($table)){
			$this->db->from($table[0]);
			for($i = 1; $i < count($table); $i ++){
				$this->db->join($table[$i][0], $table[$i][1], 'left');	
			}
		}else{
        	$this->db->from($table);
		}
		if(!$field){
    		return $this->db->count_all_results();
		}else{
			$list = $this->db->get()
						->result_array();
			$count = 0;
			if($list){
				foreach($list as $v){
					$count += $v['count(*)'];
				}
			}
			return $count;
		}
	}
   
	public function _getfield($table, $field = '*', $where = '', $order = false){
		if(is_array($field)){
			$this->db->select($field[0]);
			if(!empty($field[1]))$this->db->group_by($field[1]);
			if(!empty($field[2]))$this->db->having($field[2]);
		}else{
			$this->db->select($field);
		}
		if(!empty($where))$this->db->where($where);
		if($order !== false)$this->db->order_by($order, '', false); 
		if(is_array($table)){
			$this->db->from($table[0]);
			for($i = 1; $i < count($table); $i ++){
				$this->db->join($table[$i][0], $table[$i][1], 'left');	
			}
		}else{
        	$this->db->from($table);
		}		
	    $row = $this->db->get()
						->row_array(); 
		return @implode(',', @array_values($row));
		//return is_array($field) ? $row[$field[0]] :  $row[$field];		
	}
   
	public function _getrow($table, $field = '*', $where = '', $order = false){
		if(is_array($field)){
			$this->db->select($field[0]);
			if(!empty($field[1]))$this->db->group_by($field[1]);
			if(!empty($field[2]))$this->db->having($field[2]);
		}else{
			$this->db->select($field);
		}
		if(!empty($where))$this->db->where($where);
		if($order !== false)$this->db->order_by($order, '', false); 
		if(is_array($table)){
			$this->db->from($table[0]);
			for($i = 1; $i < count($table); $i ++){
				$this->db->join($table[$i][0], $table[$i][1], 'left');	
			}
		}else{
        	$this->db->from($table);
		}		
	    return $this->db->get()
						->row_array();
	}
	
	public function _getcol($table, $field = '*', $where = '', $order = false, $limit = false, $distinct = false){
		$list = $this->_getlist($table, $field, $where, $order, $limit, $distinct);
		$result = array();
		foreach($list as $v){
			$keys = array_keys($v);
			if(count($keys) > 2){
				$result[$v[$keys[0]]][] = $v;	
			}elseif(count($keys) == 2){
				$result[$v[$keys[0]]][] = $v[$keys[1]];	
			}else{
				$result[] = $v[$keys[0]];	
			}
		}
		return $result;
	}
	
	public function _getcols($table, $field = '*', $where = '', $order = false, $limit = false, $distinct = false){
		$list = $this->_getlist($table, $fields, $where, $order, $limit, $distinct);
		if(empty($list))return $list;
		$field = array_keys($list[0]);
		$field = $field[0];
		$result = array();
		foreach($list as $v){
			$result[$v[$field]] = $v;	
		}
		return $result;
	}
	
	public function _getlist($table, $field = '*', $where = '', $order = false, $limit = false, $distinct = false){
		if(is_array($field)){
			$this->db->select($field[0]);
			if(!empty($field[1]))$this->db->group_by($field[1]);
			if(!empty($field[2]))$this->db->having($field[2]);
		}else{
			$this->db->select($field);
		}
		if(!empty($where))$this->db->where($where);
		if($order !== false)$this->db->order_by($order, '', false); 
		if($limit !== false){
			if(!is_array($limit))$limit = explode(',', $limit);
			$this->db->limit($limit[1], $limit[0]);
		}
		if($distinct !== false)$this->db->distinct();
		if(is_array($table)){
			$this->db->from($table[0]);
			for($i = 1; $i < count($table); $i ++){
				$this->db->join($table[$i][0], $table[$i][1], 'left');	
			}
		}else{
        	$this->db->from($table);
		}		
	    return $this->db->get()
						->result_array();
	}
	
	//自动处理数据字段
	//$table表
	//$data POST数据
	//$auto是否自动处理时间密码IP//要排除auto的字段可加入在此参数中
	//$filter要过滤的字段数组比如前端不允许修改账号/状态 $filter = array('account', 'status')
	//$prefix表单name添加了前缀，可为数组，按顺序优先//适用于表单同时插入两个表并有共享字段时
	public function _getdata($table, $data = '', $auto = '', $filter = '', $prefix = ''){
		if(!is_array($data))$data = $this->input->post();
		if(!is_array($prefix))$prefix = explode(',', $prefix);
		if(!is_array($filter))$filter = explode(',', $filter);
		if($auto !== false)if(!is_array($auto))$auto = explode(',', $auto);
		$fields = object2array($this->db->field_data($table));		
		$result = array();
		foreach($fields as $k => $v){
			if($v['primary_key'])continue;
			if(is_array($filter) && in_array($v['name'], $filter))continue;//排除
			if($v['name'] == 'password'){
				foreach($prefix as $kk => $vv){
				 	if(isset($data[$vv.$v['name']])){
						 if(empty($data[$vv.$v['name']]))continue 2;//空值不修改密码
					}
				}
			}
			$isset = false;
			foreach($prefix as $kk => $vv){
				if(isset($data[$vv.$v['name']])){
					$result[$v['name']] = $data[$vv.$v['name']];
					$isset = true;
					break;
				}
			}
			//if($auto !== false || $isset)$result[$v['name']]  = checknull($result[$v['name']], checknull($v['defalut']));
			if($isset)$result[$v['name']]  = checknull($result[$v['name']], checknull($v['defalut']));
			if($auto !== false && (is_string($result[$v['name']]) || !isset($result[$v['name']]))){
				if(!isset($result[$v['name']]) || trim($result[$v['name']]) == ''){
					if(!in_array($v['name'], $auto)){
						if($v['type'] == 'int' && strrpos(trim($v['name'], '0123456789'), 'time') === strlen(trim($v['name'], '0123456789')) - 4){
							$result[$v['name']] = time();
						}elseif($v['type'] == 'date'){
							$result[$v['name']] = date('Y-m-d', time());
						}elseif(strrpos(trim($v['name'], '0123456789'), 'ip') === strlen(trim($v['name'], '0123456789')) - 2){
							$result[$v['name']] = $this->input->ip_address();
						}elseif(trim($v['name'], '0123456789') == 'adminid'){
							$result[$v['name']] = (int)$this->_admin->id;
						}else{
							$result[$v['name']] = checknull($v['default']);
						}
					}
				}
			}
			//数组
			if(isset($result[$v['name']]) && !is_string($result[$v['name']]))$result[$v['name']] = json_encode($result[$v['name']]);
			//时间
			if($result[$v['name']] && !is_numeric($result[$v['name']]) && $v['type'] == 'int' && strrpos(trim($v['name'], '0123456789'), 'time') === strlen(trim($v['name'], '0123456789')) - 4){
				$result[$v['name']] = formattime($result[$v['name']], '', time());
			}
			//密码
			if($result[$v['name']] && trim($v['name'], '0123456789') == 'password'){
				$result[$v['name']] = md5($result[$v['name']]);
			}			
		}
		return $result;
	}
	
	//给表字段加表别名。前缀。用于left join等查询
	public function _sqlfields($table, $alias = '', $prefix = '', $filter = false){
		if(!is_array($filter))$filter = explode(',', $filter);
		$fields = object2array($this->db->field_data($table));
		$sql = '';
		foreach($fields as $k => $v){
			if(in_array($v['name'], $filter))continue;
			$sql .= (empty($alias) ? '' : $alias.'.').$v['name'].' as '.$prefix.$v['name'].',';
		}
		return trim($sql, ',');
	}
}