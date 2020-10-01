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
class Admin_service extends Admin_Controller {
	/**
	 * 构造函数
	 *
	 * @access  public
	 * @return  void
	 */
	 
	private $service_status = array(0 => '<b style="color:orangered;">未处理</b>',2 => '<b style="color:orange;">处理中</b>', 1 => '<b style="color:green;">完成</b>');
	private $service_action = array(0 => '扣款', 1 => '退款');
	private $service_type = array(0 => '门锁问题', 2 => '床的问题', 3 => '消毒灯问题', 4 => '押金退还', 5 => '无法结束计费', 6 => '其它',  1 => '丢失');
	public function __construct() 
	{
		parent :: __construct();
	}

	public function index() 
	{

		$page = $this->input->get('page');
		$pagesize = $this->input->get('pagesize');
		if(empty($pagesize))$pagesize = 20;
		$macno = trim($this->input->get('macno'));
		$title=trim($this->input->get('title'));
		$tradeid = $this->input->get('tradeid');	
		$type = $this->input->get('type');
		$status = $this->input->get('status');
		$userid = $this->input->get('userid');
		$createtime1 = $this->input->get('createtime1');
		$createtime2 = $this->input->get('createtime2');
		$this->assign('get', $this->input->get());
		
		//处理搜索SQL
        $where = ' 1=1 ';//.$this->_rolesql();

		/*if($keywords){
			$where .= " and (serviceno='{$keywords}' or devicemacno='{$keywords}' or device_goodsmacno='{$keywords}' or device_goodsmacno2='{$keywords}')";	
		}*/
		if($macno){
		    $where.=" and macno like '%".$macno."%'";
        }
        if($title){
            $where.=" and title like '%".$title."%'";
        }
		if(is_numeric($type)){
			$where .= " and type=$type";	
		}
		if(is_numeric($status)){
			$where .= " and status=$status";	
		}
		if(is_numeric($tradeid)){
            $where .= ' and trade_id='.$tradeid;
            $this->assign('get_tradeid_tradeno', $this->_getfield('trade', 'concat(id, ", ", tradeno, ", ", devicemacno)', 'id='.$tradeid));
        }
		if(!empty($createtime1)){
			$createtime1 = formattime($createtime1.' 00:00:00');
			$where .= " and ctime>=".$createtime1;
		}
		if(!empty($createtime2)){
			$createtime2 = formattime($createtime2.' 23:59:59');
			$where .= " and ctime<=".$createtime2;
		}
		if(is_numeric($userid)){
			$where .= " and user_id=$userid";
			$this->assign('get_userid_account', $this->_getfield('user', 'if(account=nickname,concat(id, ", ", account),concat(id, ", ", account, ", ", nickname))', 'id='.$userid));
		}
		
		//注意php代码不需要处理搜索URL参数，分页URL的处理注意本页模板页尾的JS代码
		$service = $this->_getpage('feedback', $where, 'id desc', $page, $pagesize);
		foreach($service['list'] as &$v){
			$v['_userid'] = $this->_getfield('user', 'if(account=nickname,concat(id, ", ", account),concat(id, ", ", account, ", ", nickname))', 'id='.$v['user_id']);
			if($v['trade_id'])$v['tradeno'] = $this->_getfield('trade', 'tradeno', "id=".$v['trade_id']);
			$v['device_detail'] = $this->_getrow(array('device as d', array('admin as a', 'd.adminid=a.id')), 'concat(a.id,", ",a.nickname) as nickname,concat(a.address,d.address) as address', "d.macno='".$v['macno']."'");
		}
		unset($v);
		
		$this->assign('service', $service);
		$this->assign("service_type",$this->service_type);
		$this->assign('service_status', $this->service_status);
		$this->display('service/list_service.html');
	}
	
	public function edit($id=0){
		$post = $this->input->post();
        if (!empty($post) ){
            $data = $this->_getdata('service', '', $id ? false : '');
			if($data['action'] == 2 && !$data['tradeid'])die('{"status":0,"msg":"交易退款必须选择交易信息"}');
            if($id){
                $this->db->update('feedback', $data, 'id='.$id);
            }
			/*if($data['status'] == 1){
				$o = $this->_getrow('feedback', '*', 'id='.$id);
				if($o['trade_id']){
				    $trade=$this->_getrow('trade','*',['id'=>$o['trade_id']]);
				    if($trade){
				        if($o['action']==0){
				            $this->db->set('money','money-'.$o['money'],false)->where('id',$o['user_id'])->update('user');//扣除用户余额
                        }elseif($o['action']==1){
				            $this->db->set('money',"money+".$o['money'],false)->where('id',$o['user_id'])->update('user');//退款
                            //更新订单状态
                            $this->db->insert('trade',['status'=>6],['id'=>$o['trade_id']]);
                        }
                    }
				}
			}*/
            die('{"status":1}');
		}		
		if($id){
			$row = $this->_getrow('feedback', '*', 'id='.$id);
			$row['userid_account'] = $this->_getfield('user', 'if(account=nickname,concat(id, ", ", account),concat(id, ", ", account, ", ", nickname))', "id=".$row['user_id']);
			if($row['trade_id'])$row['tradeid_tradeno'] = $this->_getfield('trade', 'concat(id, ", ", tradeno, ", ", devicemacno)', "id=".$row['trade_id']);
			$row['device_detail'] = $this->_getrow(array('device as d', array('admin as a', 'd.adminid=a.id')), 'concat(a.id,", ",a.nickname) as nickname,concat(a.address,d.address) as address', "d.macno='".$row['macno']."'");
			$this->assign('row', $row);
		}		
		$this->assign("service_type",$this->service_type);
		$this->assign('service_status', $this->service_status);
		$this->assign('service_action', $this->service_action);
		$this->display('service/edit_service.html');
	}
	
	public function delete(){
		$ids = $this->input->post('ids');
		if(!empty($ids)){
			$this->db->where('1=1'.$this->_rolesql());
			$this->db->where_in('id', explode(',', $ids));
			$this->db->delete('feedback');
		}
		die('{"status":1}');	
	}
	
	public function clear(){
		$this->db->delete('feedback', ' 1=1 '.$this->_rolesql());
		die('{"status":1}');	
	}

	public function check(){
		$id = $this->input->post('id');
		$serviceno = $this->input->post('serviceno');
		if(!empty($serviceno)){
			$where = "serviceno='".$serviceno."'";
			if(!empty($id))$where .= " and id<>".$id;
			$count = $this->_getcount('service', $where);
			die('{"status":"'.$count.'"}');
		}
		die('{"status":"-1"}');
	}
}