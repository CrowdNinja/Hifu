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
class Admin_finance extends Admin_Controller {
	/**
	 * 构造函数
	 *
	 * @access  public
	 * @return  void
	 */
	private $finance_target = array(0 => '会员', 1 => '代理', 2 => '医院', 3 => '平台');
	private $finance_type = array(0 => '交易', 8 => '交易退款', 1 => '充值', 7 => '充值无效', 2 => '押金', 3 => '退押金', 4 => '报障', 5 => '提现', 6 => '提现回退');
	 
	public function __construct() 
	{
		parent :: __construct();
		$this->load->model('setting_mdl');
	}

	public function index() 
	{
		$page = $this->input->get('page');
		$pagesize = $this->input->get('pagesize');
		if(empty($pagesize))$pagesize = 20;
		
		$keywords = $this->input->get('keywords');	
		$target = $this->input->get('target');	
		$targetid = $this->input->get('targetid');	
		$type = $this->input->get('type');
		$moneytype = $this->input->get('moneytype');	
		$createtime1 = $this->input->get('createtime1');
		$createtime2 = $this->input->get('createtime2');
		$this->assign('get', $this->input->get());
		
		//处理搜索SQL
		if($this->_admin->_role_type != 0){
			$where = ' 1=1 and target='.$this->_admin->_role_type.' '.$this->_rolesql('', 'targetid');
		}else{
        	$where = ' 1=1 ';
		}
		if(!empty($keywords)){
			$where .= " and (concat(`desc`, typeno) like '%". $keywords ."%')";	
		}
		if(is_numeric($target)){
			$where .= " and target=$target";	
		}
		if($target != 3 && is_numeric($targetid)){
			$where .= " and targetid=$targetid";	
			if($target == 0){
				$this->assign('get_targetid_account', $this->_getfield('user', 'if(account=nickname,concat(id, ", ", account),concat(id, ", ", account, ", ", nickname))', 'id='.$targetid));
			}elseif($target == 3){
				$this->assign('get_targetid_account', '平台');
			}else{
				$this->assign('get_targetid_account', $this->_getfield('admin', 'concat(id, ", ", nickname)', 'id='.$targetid));
			}
		}
		if(is_numeric($type)){
			$where .= " and type=$type";	
		}
		if(is_numeric($moneytype)){
			if($moneytype){
				$where .= " and money>=0";
			}else{
				$where .= " and money<0";
			}
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
		$finance = $this->_getpage('finance', $where, 'id desc', $page, $pagesize);
		foreach($finance['list'] as &$v){
			if($v['target'] == 0){
				$v['_targetid'] = $this->_getfield('user', 'if(account=nickname,concat(id, ", ", account),concat(id, ", ", account, ", ", nickname))', 'id='.$v['targetid']);
			}elseif($v['target'] == 3){
				$v['_targetid'] = '平台';
			}else{
				$v['_targetid'] = $this->_getfield('admin', 'concat(id, ", ", nickname)', 'id='.$v['targetid']);
			}
		}
		unset($v);
		
		$stats = $this->_getcols('finance', array('target,sum(if(money>=0, abs(money), 0)) as sum_in, sum(if(money<0, abs(money), 0)) as sum_out', 'target'), $where);
		$this->assign('sum_user_out', $this->_getfield('user', 'sum(if(money<0,abs(money),0))'));
		$this->assign('stats', $stats);
		$this->assign('finance', $finance);
		$this->assign('finance_target', $this->finance_target);
		$this->assign('finance_type', $this->finance_type);
		$this->display('bguser/list_finance.html');
	}
	
	public function delete(){
		$ids = $this->input->post('ids');
		if(!empty($ids)){
			if($this->_admin->_role_type != 0){
				$where = ' 1=1 and target='.$this->_admin->_role_type.' '.$this->_rolesql('', 'targetid');
			}else{
				$where = ' 1=1 ';
			}
			$this->db->where($where);
			$this->db->where_in('id', explode(',', $ids));
			$this->db->delete('finance');	
		}
		die('{"status":1}');	
	}
	
	public function clear(){
		if($this->_admin->_role_type != 0){
			$where = ' 1=1 and target='.$this->_admin->_role_type.' '.$this->_rolesql('', 'targetid');
		}else{
			$where = ' 1=1 ';
		}
		$this->db->delete('finance', $where);
		die('{"status":1}');	
	}
	
	public function export(){
		$keywords = $this->input->get('keywords');	
		$target = $this->input->get('target');	
		$targetid = $this->input->get('targetid');	
		$type = $this->input->get('type');
		$moneytype = $this->input->get('moneytype');	
		$createtime1 = $this->input->get('createtime1');
		$createtime2 = $this->input->get('createtime2');
		
		//处理搜索SQL
		if($this->_admin->_role_type != 0){
			$where = ' 1=1 and target='.$this->_admin->_role_type.' '.$this->_rolesql('', 'targetid');
		}else{
        	$where = ' 1=1 ';
		}
		if(!empty($keywords)){
			$where .= " and (concat(`desc`, typeno) like '%". $keywords ."%')";	
		}
		if(is_numeric($target)){
			$where .= " and target=$target";	
		}
		if($target != 3 && is_numeric($targetid)){
			$where .= " and targetid=$targetid";	
		}
		if(is_numeric($type)){
			$where .= " and type=$type";	
		}
		if(is_numeric($moneytype)){
			if($moneytype){
				$where .= " and money>=0";
			}else{
				$where .= " and money<0";
			}
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
		$finance = $this->_getlist('finance', '*', $where, 'id desc');
		foreach($finance as &$v){
			if($v['target'] == 0){
				$v['_targetid'] = $this->_getfield('user', 'if(account=nickname,concat(id, ", ", account),concat(id, ", ", account, ", ", nickname))', 'id='.$v['targetid']);
			}elseif($v['target'] == 3){
				$v['_targetid'] = '平台';
			}else{
				$v['_targetid'] = $this->_getfield('admin', 'concat(id, ", ", nickname)', 'id='.$v['targetid']);
			}
		}
		unset($v);

		$fp = fopen('./temp/finance.csv', 'w');
		//fwrite($fp,chr(0xEF).chr(0xBB).chr(0xBF));
		fputcsv($fp, array(mb_convert_encoding('编号', 'gbk', 'utf8'), 
						  mb_convert_encoding('来源', 'gbk', 'utf8'), 
						  mb_convert_encoding('账号', 'gbk', 'utf8'), 
						  mb_convert_encoding('收支', 'gbk', 'utf8'), 
						  mb_convert_encoding('类型', 'gbk', 'utf8'), 
						  mb_convert_encoding('金额', 'gbk', 'utf8'), 
						  mb_convert_encoding('描述', 'gbk', 'utf8'), 
						  mb_convert_encoding('时间', 'gbk', 'utf8')
						  ));
		foreach($finance as $v){
			fputcsv($fp, array(mb_convert_encoding($v['id'], 'gbk', 'utf8'),
							   mb_convert_encoding($this->finance_target[$v['target']], 'gbk', 'utf8'),
			                   mb_convert_encoding($v['_targetid'], 'gbk', 'utf8'),
			                   mb_convert_encoding($v['money'] >= 0 ? '收入' : '支出', 'gbk', 'utf8'),
							   mb_convert_encoding($this->finance_type[$v['type']], 'gbk', 'utf8'),
							   mb_convert_encoding($v['money'], 'gbk', 'utf8'),
							   mb_convert_encoding($v['desc'], 'gbk', 'utf8'),
							   mb_convert_encoding(formattime($v['createtime']), 'gbk', 'utf8')
							   )
					);
		}
		fclose($fp);
		die('{"status":1, "url":"/temp/finance.csv"}');
	}	
}