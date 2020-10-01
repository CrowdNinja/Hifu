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
class Finance_mdl extends DLC_Model
{
	
	//private $finance_target = array(0 => '会员', 1 => '代理', 2 => '医院', 3 => '平台');
	//private $finance_type = array(0 => '交易', 8 => '交易退款', 1 => '充值', 7 => '充值无效', 2 => '押金', 3 => '退押金', 4 => '报障', 5 => '提现', 6 => '提现回退');
	/**
     * 构造函数
     *
     * @access  public
     * @return  void
     */
	public function __construct()
	{
		parent::__construct();	
		$this->load->model('setting_mdl');
	}
	
	public function add($o = array(), $type = 0, $fixdata = array(), $params = array()){
		$time = time();
		switch($type){
			case 0:
				if($o['money'] > 0){
					$data = array(
						'target' => 0,
						'targetid' => $o['userid'],
						'type' => $type,
						'typeid' => $o['id'],
						'typeno' => $o['tradeno'],
						'wallet' => 0,
						'money' => -1 * $o['money'],
						'paytype' => (int)$o['paytype'],
						'createtime' => $time,
						'desc' => '余额支出',
					);
					$this->db->insert('finance', $fixdata + $data);
				}
				if($o['paymoney'] > 0){
					$data = array(
						'target' => 0,
						'targetid' => $o['userid'],
						'type' => $type,
						'typeid' => $o['id'],
						'typeno' => $o['tradeno'],
						'wallet' => 0,
						'money' => -1 * $o['paymoney'],
						'paytype' => (int)$o['paytype'],
						'createtime' => $time,
						'desc' => $o['paytype'] == 1 ? '微信支付' : '支付宝支付',
					);
					$this->db->insert('finance', $fixdata + $data);
				}
				if($o['redmoney'] > 0){
					$data = array(
						'target' => 0,
						'targetid' => $o['userid'],
						'type' => $type,
						'typeid' => $o['id'],
						'typeno' => $o['tradeno'],
						'wallet' => 1,
						'money' => -1 * $o['redmoney'],
						'paytype' => (int)$o['paytype'],
						'createtime' => $time,
						'desc' => '返现/增送余额支出',
					);
					$this->db->insert('finance', $fixdata + $data);
				}
				if($o['user_money'] > 0){
					$data = array(
						'target' => 0,
						'targetid' => $o['userid'],
						'type' => $type,
						'typeid' => $o['id'],
						'typeno' => $o['tradeno'],
						'wallet' => 1,
						'money' => $o['user_money'],
						'paytype' => (int)$o['paytype'],
						'createtime' => $time,
						'desc' => '返现入账',
					);
					$this->db->insert('finance', $fixdata + $data);
				}
				/*if($o['user_recmdid'] && $o['user_recmd_money'] > 0){
					$data = array(
						'target' => 0,
						'targetid' => $o['user_recmdid'],
						'type' => $type,
						'typeid' => $o['id'],
						'typeno' => $o['tradeno'],
						'wallet' => 1,
						'money' => $o['user_recmd_money'],
						'paytype' => (int)$o['paytype'],
						'createtime' => $time,
						'desc' => '推荐会员分红',
					);
					$this->db->insert('finance', $fixdata + $data);
				}
				if($o['admin_recmdid'] && $o['admin_recmd_money'] > 0){
					$data = array(
						'target' => 0,
						'targetid' => $o['admin_recmdid'],
						'type' => $type,
						'typeid' => $o['id'],
						'typeno' => $o['tradeno'],
						'wallet' => 1,
						'money' => $o['admin_recmd_money'],
						'paytype' => (int)$o['paytype'],
						'createtime' => $time,
						'desc' => '推荐医院分红',
					);
					$this->db->insert('finance', $fixdata + $data);
				}*/
				if($o['admin_corpid'] && $o['corp_money'] > 0){
					$data = array(
						'target' => 1,
						'targetid' => $o['admin_corpid'],
						'type' => $type,
						'typeid' => $o['id'],
						'typeno' => $o['tradeno'],
						'wallet' => 0,
						'money' => $o['corp_money'],
						'paytype' => (int)$o['paytype'],
						'createtime' => $time,
						'desc' => '交易分成',
					);
					$this->db->insert('finance', $fixdata + $data);
				}
				if($o['adminid'] && $o['admin_money'] > 0){
					$data = array(
						'target' => 2,
						'targetid' => $o['adminid'],
						'type' => $type,
						'typeid' => $o['id'],
						'typeno' => $o['tradeno'],
						'wallet' => 0,
						'money' => $o['admin_money'],
						'paytype' => (int)$o['paytype'],
						'createtime' => $time,
						'desc' => '交易分成',
					);
					$this->db->insert('finance', $fixdata + $data);
				}
				if($o['sys_money'] > 0){
					$data = array(
						'target' => 3,
						'targetid' => 0,
						'type' => $type,
						'typeid' => $o['id'],
						'typeno' => $o['tradeno'],
						'wallet' => 0,
						'money' => $o['sys_money'],
						'paytype' => (int)$o['paytype'],
						'createtime' => $time,
						'desc' => '交易入账',
					);
					$this->db->insert('finance', $fixdata + $data);
				}
				break;	
			case 8:
				if($o['money'] > 0 || $o['paymoney'] > 0){
					$data = array(
						'target' => 0,
						'targetid' => $o['userid'],
						'type' => $type,
						'typeid' => $o['id'],
						'typeno' => $o['tradeno'],
						'wallet' => 0,
						'money' => $o['money']+$o['paymoney'],
						'paytype' => (int)$o['paytype'],
						'createtime' => $time,
						'desc' => '交易退款',
					);
					$this->db->insert('finance', $fixdata + $data);
				}
				if($o['redmoney'] > 0){
					$data = array(
						'target' => 0,
						'targetid' => $o['userid'],
						'type' => $type,
						'typeid' => $o['id'],
						'typeno' => $o['tradeno'],
						'wallet' => 1,
						'money' => $o['redmoney'],
						'paytype' => (int)$o['paytype'],
						'createtime' => $time,
						'desc' => '返现/增送交易退款',
					);
					$this->db->insert('finance', $fixdata + $data);
				}
				if($o['user_money'] > 0){
					$data = array(
						'target' => 0,
						'targetid' => $o['userid'],
						'type' => $type,
						'typeid' => $o['id'],
						'typeno' => $o['tradeno'],
						'wallet' => 1,
						'money' => -1 * $o['user_money'],
						'paytype' => (int)$o['paytype'],
						'createtime' => $time,
						'desc' => '交易退款返现扣除',
					);
					$this->db->insert('finance', $fixdata + $data);
				}
				/*if($o['user_recmdid'] && $o['user_recmd_money'] > 0){
					$data = array(
						'target' => 0,
						'targetid' => $o['user_recmdid'],
						'type' => $type,
						'typeid' => $o['id'],
						'typeno' => $o['tradeno'],
						'wallet' => 1,
						'money' => -1 * $o['user_recmd_money'],
						'paytype' => (int)$o['paytype'],
						'createtime' => $time,
						'desc' => '交易退款推荐会员分红取消',
					);
					$this->db->insert('finance', $fixdata + $data);
				}
				if($o['admin_recmdid'] && $o['admin_recmd_money'] > 0){
					$data = array(
						'target' => 0,
						'targetid' => $o['admin_recmdid'],
						'type' => $type,
						'typeid' => $o['id'],
						'typeno' => $o['tradeno'],
						'wallet' => 1,
						'money' => -1 * $o['admin_recmd_money'],
						'paytype' => (int)$o['paytype'],
						'createtime' => $time,
						'desc' => '交易退款推荐医院分红取消',
					);
					$this->db->insert('finance', $fixdata + $data);
				}*/
				if($o['admin_corpid'] && $o['corp_money'] > 0){
					$data = array(
						'target' => 1,
						'targetid' => $o['admin_corpid'],
						'type' => $type,
						'typeid' => $o['id'],
						'typeno' => $o['tradeno'],
						'wallet' => 0,
						'money' => -1 * $o['corp_money'],
						'paytype' => (int)$o['paytype'],
						'createtime' => $time,
						'desc' => '交易退款交易分成取消',
					);
					$this->db->insert('finance', $fixdata + $data);
				}
				if($o['adminid'] && $o['admin_money'] > 0){
					$data = array(
						'target' => 2,
						'targetid' => $o['adminid'],
						'type' => $type,
						'typeid' => $o['id'],
						'typeno' => $o['tradeno'],
						'wallet' => 0,
						'money' => -1 * $o['admin_money'],
						'paytype' => (int)$o['paytype'],
						'createtime' => $time,
						'desc' => '交易退款交易分成取消',
					);
					$this->db->insert('finance', $fixdata + $data);
				}
				if($o['sys_money'] > 0){
					$data = array(
						'target' => 3,
						'targetid' => 0,
						'type' => $type,
						'typeid' => $o['id'],
						'typeno' => $o['tradeno'],
						'wallet' => 0,
						'money' => -1 * $o['sys_money'],
						'paytype' => (int)$o['paytype'],
						'createtime' => $time,
						'desc' => '交易退款交易入账取消',
					);
					$this->db->insert('finance', $fixdata + $data);
				}
				break;	
			case 1:
				if($o['money'] > 0){
					$data = array(
						'target' => 0,
						'targetid' => $o['userid'],
						'type' => $type,
						'typeid' => $o['id'],
						'typeno' => $o['rechargeno'],
						'wallet' => 0,
						'money' => $o['money'],
						'paytype' => (int)$o['paytype'],
						'createtime' => $time,
						'desc' => '充值入账',
					);
					$this->db->insert('finance', $fixdata + $data);
					//
					$data = array(
						'target' => 3,
						'targetid' => 0,
						'type' => $type,
						'typeid' => $o['id'],
						'typeno' => $o['rechargeno'],
						'wallet' => 0,
						'money' => $o['money'],
						'paytype' => (int)$o['paytype'],
						'createtime' => $time,
						'desc' => '充值入账',
					);
					$this->db->insert('finance', $fixdata + $data);
				}
				if($o['redmoney'] > 0){
					$data = array(
						'target' => 0,
						'targetid' => $o['userid'],
						'type' => $type,
						'typeid' => $o['id'],
						'typeno' => $o['rechargeno'],
						'wallet' => 1,
						'money' => $o['redmoney'],
						'paytype' => (int)$o['paytype'],
						'createtime' => $time,
						'desc' => '充值增送',
					);
					$this->db->insert('finance', $fixdata + $data);
					//
					$data = array(
						'target' => 3,
						'targetid' => 0,
						'type' => $type,
						'typeid' => $o['id'],
						'typeno' => $o['rechargeno'],
						'wallet' => 1,
						'money' => -1 * $o['redmoney'],
						'paytype' => (int)$o['paytype'],
						'createtime' => $time,
						'desc' => '充值增送',
					);
					$this->db->insert('finance', $fixdata + $data);
				}
				break;
			case 7:
				if($o['money'] > 0){
					$data = array(
						'target' => 0,
						'targetid' => $o['userid'],
						'type' => $type,
						'typeid' => $o['id'],
						'typeno' => $o['rechargeno'],
						'wallet' => 0,
						'money' => -1 * $o['money'],
						'paytype' => (int)$o['paytype'],
						'createtime' => $time,
						'desc' => '充值无效',
					);
					$this->db->insert('finance', $fixdata + $data);
					//
					$data = array(
						'target' => 3,
						'targetid' => 0,
						'type' => $type,
						'typeid' => $o['id'],
						'typeno' => $o['rechargeno'],
						'wallet' => 0,
						'money' => -1 * $o['money'],
						'paytype' => (int)$o['paytype'],
						'createtime' => $time,
						'desc' => '充值无效',
					);
					$this->db->insert('finance', $fixdata + $data);
				}
				if($o['redmoney'] > 0){
					$data = array(
						'target' => 0,
						'targetid' => $o['userid'],
						'type' => $type,
						'typeid' => $o['id'],
						'typeno' => $o['rechargeno'],
						'wallet' => 1,
						'money' => -1 * $o['redmoney'],
						'paytype' => (int)$o['paytype'],
						'createtime' => $time,
						'desc' => '充值增送无效',
					);
					$this->db->insert('finance', $fixdata + $data);
					//
					$data = array(
						'target' => 3,
						'targetid' => 0,
						'type' => $type,
						'typeid' => $o['id'],
						'typeno' => $o['rechargeno'],
						'wallet' => 1,
						'money' => $o['redmoney'],
						'paytype' => (int)$o['paytype'],
						'createtime' => $time,
						'desc' => '充值增送无效',
					);
					$this->db->insert('finance', $fixdata + $data);
				}
				break;
			case 2:
				if($o['money'] > 0){
					$data = array(
						'target' => 0,
						'targetid' => $o['userid'],
						'type' => $type,
						'typeid' => $o['id'],
						'typeno' => $o['foregiftno'],
						'wallet' => 0,
						'money' => $o['money'],
						'paytype' => (int)$o['paytype'],
						'createtime' => $time,
						'desc' => '押金充值',
					);
					$this->db->insert('finance', $fixdata + $data);
					//
					$data = array(
						'target' => 3,
						'targetid' => 0,
						'type' => $type,
						'typeid' => $o['id'],
						'typeno' => $o['foregiftno'],
						'wallet' => 0,
						'money' => $o['money'],
						'paytype' => (int)$o['paytype'],
						'createtime' => $time,
						'desc' => '押金充值',
					);
					$this->db->insert('finance', $fixdata + $data);
				}
				break;
			case 3:
				if($o['money'] > 0){
					$data = array(
						'target' => 0,
						'targetid' => $o['userid'],
						'type' => $type,
						'typeid' => $o['id'],
						'typeno' => $o['foregiftno'],
						'wallet' => 0,
						'money' => -1 * $o['money'],
						'paytype' => (int)$o['paytype'],
						'createtime' => $time,
						'desc' => '押金退还',
					);
					$this->db->insert('finance', $fixdata + $data);
					//
					$data = array(
						'target' => 3,
						'targetid' => 0,
						'type' => $type,
						'typeid' => $o['id'],
						'typeno' => $o['foregiftno'],
						'wallet' => 0,
						'money' => -1 * $o['money'],
						'paytype' => (int)$o['paytype'],
						'createtime' => $time,
						'desc' => '押金退还',
					);
					$this->db->insert('finance', $fixdata + $data);
				}
				break;
			case 4:
				if($o['money'] > 0){
					$data = array(
						'target' => 0,
						'targetid' => $o['userid'],
						'type' => $type,
						'typeid' => $o['id'],
						'typeno' => $o['serviceno'],
						'wallet' => 0,
						'money' => $params['action'] == 1 ? $o['money'] : (-1 * $o['money']),
						'paytype' => 0,
						'createtime' => $time,
						'desc' => $params['action'] == 1 ? '报障退款' : '报障费用',
					);
					$this->db->insert('finance', $fixdata + $data);
					//
					$data = array(
						'target' => 3,
						'targetid' => 0,
						'type' => $type,
						'typeid' => $o['id'],
						'typeno' => $o['serviceno'],
						'wallet' => 0,
						'money' => $params['action'] == 1 ? (-1 * $o['money']) : $o['money'],
						'paytype' => 0,
						'createtime' => $time,
						'desc' => $params['action'] == 1 ? '报障退款' : '报障费用',
					);
					$this->db->insert('finance', $fixdata + $data);
				}
				break;
			case 5:
				//会员
				if($o['money'] > 0 && $o['userid']){
					$data = array(
						'target' => 0,
						'targetid' => $o['userid'],
						'type' => $type,
						'typeid' => $o['id'],
						'typeno' => $o['cashno'],
						'wallet' => 0,
						'money' => -1 * $o['money'],
						'paytype' => 0,
						'createtime' => $time,
						'desc' => '余额提现',
					);
					$this->db->insert('finance', $fixdata + $data);
					//
					$data = array(
						'target' => 3,
						'targetid' => 0,
						'type' => $type,
						'typeid' => $o['id'],
						'typeno' => $o['cashno'],
						'wallet' => 0,
						'money' => -1 * $o['money'],
						'paytype' => 0,
						'createtime' => $time,
						'desc' => '余额提现',
					);
					$this->db->insert('finance', $fixdata + $data);
				}
				//代理/医院
				if($o['money'] > 0 && $o['adminid']){
					$data = array(
						'target' => $o['type'],
						'targetid' => $o['adminid'],
						'type' => $type,
						'typeid' => $o['id'],
						'typeno' => $o['cashno'],
						'wallet' => 0,
						'money' => -1 * $o['money'],
						'paytype' => 0,
						'createtime' => $time,
						'desc' => '余额提现',
					);
					$this->db->insert('finance', $fixdata + $data);
					//
					$data = array(
						'target' => 3,
						'targetid' => 0,
						'type' => $type,
						'typeid' => $o['id'],
						'typeno' => $o['cashno'],
						'wallet' => 0,
						'money' => -1 * $o['money'],
						'paytype' => 0,
						'createtime' => $time,
						'desc' => '余额提现',
					);
					$this->db->insert('finance', $fixdata + $data);
				}
				break;
			case 6:
				//会员
				if($o['money'] > 0 && $o['userid']){
					$data = array(
						'target' => 0,
						'targetid' => $o['userid'],
						'type' => $type,
						'typeid' => $o['id'],
						'typeno' => $o['cashno'],
						'wallet' => 0,
						'money' => $o['money'],
						'paytype' => 0,
						'createtime' => $time,
						'desc' => '提现回退',
					);
					$this->db->insert('finance', $fixdata + $data);
					//
					$data = array(
						'target' => 3,
						'targetid' => 0,
						'type' => $type,
						'typeid' => $o['id'],
						'typeno' => $o['cashno'],
						'wallet' => 0,
						'money' => $o['money'],
						'paytype' => 0,
						'createtime' => $time,
						'desc' => '提现回退',
					);
					$this->db->insert('finance', $fixdata + $data);
				}
				//代理/医院
				if($o['money'] > 0 && $o['adminid']){
					$data = array(
						'target' => $o['type'],
						'targetid' => $o['adminid'],
						'type' => $type,
						'typeid' => $o['id'],
						'typeno' => $o['cashno'],
						'wallet' => 0,
						'money' => $o['money'],
						'paytype' => 0,
						'createtime' => $time,
						'desc' => '提现回退',
					);
					$this->db->insert('finance', $fixdata + $data);
					//
					$data = array(
						'target' => 3,
						'targetid' => 0,
						'type' => $type,
						'typeid' => $o['id'],
						'typeno' => $o['cashno'],
						'wallet' => 0,
						'money' => $o['money'],
						'paytype' => 0,
						'createtime' => $time,
						'desc' => '提现回退',
					);
					$this->db->insert('finance', $fixdata + $data);
				}
				break;
		}
	}
}
