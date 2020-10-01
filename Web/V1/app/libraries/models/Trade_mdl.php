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
class Trade_mdl extends DLC_Model
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
		$this->load->model('setting_mdl');
		$this->load->model('finance_mdl');
	}
	
	//计算费用分成等
	public function calc($trade, $user, $couponids = '', $paytype = 0, $percen = true){
		//检查活动券
		$coupons = array();
		$couponmoney = 0;//红包券
		$couponforegift = 0;
		if($couponids){
			$coupons = $this->_getlist('user_coupon', '*', "(adminid=0 or adminid=".$trade['adminid'].") and userid=".$user['id']." and status=0 and usebegintime<=".time()." and useendtime>=".time()." and id in (".$couponids.")");
			if(!$coupons)return array('code' => -9001, 'msg' => '活动券不可用');
			$temp = array();
			foreach($coupons as $v){
				if($v['limitmoney'] && $v['limitmoney'] > $trade['total'])return array('code' => -9002, 'msg' => '活动券满'.$v['limitmoney'].'元才可用');
				$v['money'] = $v['percen'] == 1 ? round($v['money'] / 100 * $trade['total'], 2) : $v['money'];
				if($v['type'] == 0)$couponmoney += $v['money'];
				$couponforegift += $v['foregift'];
				$temp[$v['adminid'].'-'.$v['type']] = $v;
			}
			if(count($coupons) != count($temp))return array('code' => -9003, 'msg' => '每种活动券只可使用一张');
			$coupons = $temp;
			unset($temp);
		}
		
		$data = array(
			'total' => $trade['total'],
			'couponid' => checknull($couponids),
			'couponmoney' => $couponmoney,
			'couponforegift' => $couponforegift,
			'couponpayforegift' => $couponpayforegift,
			'admin_money' => 0,
			'user_recmd_money' => 0,
			'admin_recmd_money' => 0,
			'user_money' => floatval($coupons['0-1']['money']) + floatval($coupons[$trade['adminid'].'-1']['money']),//返现券
			'corp_money' => 0,
			'sys_money' => 0,
			'money' => 0,//余额
			'redmoney' => 0,//增送
			'paymoney' => 0,//支付
		);
		//计算需支付金额
		$total = max(0, $trade['total'] - $couponmoney);//减活动券
		if($paytype == 0){
			$data['money'] = min($user['money'], $total);
			$data['redmoney'] = min($user['redmoney'], $total - $data['money']);
			if($total - $data['money'] - $data['redmoney'])return array('code' => -9004, 'msg' => '余额不足，请选择其它支付方式');
		}
		$data['paymoney'] = $total - $data['money'] - $data['redmoney'];
		if(!$percen)return array('code' => 1, 'msg' => '', 'data' => $data);
		//计算分红
		$trademoney = $data['paymoney'] + $data['money'] + $data['redmoney'];
		//获取分成设置
		$config_setting = $this->setting_mdl->get('config');
		if($config_setting['percen']['type'] == 3){//代理分成
			if($trade['admin_corpid']){
				$corp_percen = $this->_getfield('admin', 'percen', 'id='.$trade['admin_corpid']);
				if(is_numeric($corp_percen))$config_setting['corp']['percen'] = $corp_percen;
			}
			if($config_setting['corp']['shop'] == 1){//允许代理自定义时
				if($trade['adminid']){
					$shop_percen = $this->_getfield('admin', 'percen', 'id='.$trade['adminid']);
					if(is_numeric($shop_percen))$config_setting['shop']['percen'] = $shop_percen;
				}
			}
		}
		$data['config_set'] = json_encode($config_setting);
		if($trademoney){
			switch($config_setting['percen']['type']){
				case 1://代理优先
					if($trade['admin_corpid'] && $config_setting['corp']['percen']){
						$data['corp_money'] = round($config_setting['corp']['percen'] / 100 * $trademoney, 2);
					}
					if($trade['adminid'] && $config_setting['shop']['percen']){
						$data['admin_money'] = round($config_setting['shop']['percen'] / 100 * ($trademoney - $data['corp_money']), 2);
					}
					break;
				case 2://商家优先
					if($trade['adminid'] && $config_setting['shop']['percen']){
						$data['admin_money'] = round($config_setting['shop']['percen'] / 100 * $trademoney, 2);
					}
					if($trade['admin_corpid'] && $config_setting['corp']['percen']){
						$data['corp_money'] = round($config_setting['corp']['percen'] / 100 * ($trademoney - $data['admin_money']), 2);
					}
					break;
				case 3://代理分成
					if($trade['admin_corpid'] && $config_setting['corp']['percen']){
						$data['corp_money'] = round($config_setting['corp']['percen'] / 100 * $trademoney, 2);
					}
					if($data['corp_money'] > 0 && $trade['adminid'] && $config_setting['shop']['percen']){
						$data['admin_money'] = round($config_setting['shop']['percen'] / 100 * $data['corp_money'], 2);
						$data['corp_money'] -= $data['admin_money'];
					}
					break;
				default://按总额
					if($trade['adminid'] && $config_setting['shop']['percen']){
						$data['admin_money'] = round($config_setting['shop']['percen'] / 100 * $trademoney, 2);
					}
					if($trade['admin_corpid'] && $config_setting['corp']['percen']){
						$data['corp_money'] = round($config_setting['corp']['percen'] / 100 * $trademoney, 2);
					}
			}
			/*//会员推荐人
			if($trade['user_recmdid'] && $config['user']['recmdpercen']){
				$user_recmd = $this->_getrow('user', '*', "status=1 and id=".$trade['user_recmdid']);
				if($user_recmd['id']){
					$data['user_recmd_money'] = round($config['user']['recmdpercen'] / 100 * $trademoney , 2);
				}
			}
			//商家推荐人
			if($trade['admin_recmdid'] && $config['shop']['recmdpercen']){
				$admin_recmd = $this->_getrow('user', '*', "status=1 and id=".$trade['admin_recmdid']);
				if($admin_recmd['id']){
					$data['admin_recmd_money'] = round($config['shop']['recmdpercen'] / 100 * $trademoney, 2);
				}
			}*/
		}
		//计算优惠券支出
		$admin_coupon_money = min($trade['total'], $coupons[$trade['adminid'].'-0']['money'] ? : 0) + floatval($coupons[$trade['adminid'].'-1']['money']);
		$sys_coupon_money = min($trade['total'] - $admin_coupon_money, $coupons['0-0']['money'] ? : 0) + floatval($coupons['0-1']['money']);
		//减掉红包//加上押金
		$data['admin_money'] = $data['admin_money'] - $admin_coupon_money + ($coupons[$trade['adminid'].'-0']['foregift'] ? : 0);
		$data['sys_money'] = $trade['total'] - $data['admin_money'] - $data['corp_money'] - $data['user_recmd_money'] - $data['admin_recmd_money'] - $sys_coupon_money + ($coupons['0-0']['foregift'] ? : 0);
		return array('code' => 1, 'msg' => '', 'data' => $data);
	}

	//计算分成
    public function divide_into($trade_id){
	    $trade=$this->_getrow('trade','*',['id'=>$trade_id]);
	    $is=$this->_getrow('divide_record',"*",['order_no'=>$trade['tradeno']]);
	    if($is) return true;//订单已分成
        $trademoney=$admin_money=$trade['pay_money'];//分成金额
        if($trademoney<=0) return true;
        $agent=$this->_getrow('admin','id,percen',['id'=>$trade['agent_id']]);
        $shop=$this->_getrow('admin','id,percen',['id'=>$trade['adminid']]);
        $agent_money=0;
        $shop_money=0;
        if($agent['percen']) $agent_money=bcdiv(bcmul($trademoney,$agent['percen'],2),100,2);
        if($shop['percen']) $shop_money=bcdiv(bcmul($trademoney,$shop['percen'],2),100,2);
        $admin_money=$admin_money-$agent_money-$shop_money;
        if($agent_money>0){
            $this->db->insert('divide_record',[
                'order_id'=>$trade['id'],
                'order_no'=>$trade['tradeno'],
                'order_money'=>$trade['pay_money'],
                'money'=>$agent_money,
                'proportion'=>$agent['percen'],
                'parameter_id'=>$agent['id'],
                'ctime'=>date('Y-m-d H:i:s')
            ]);
            //增加金额
            $this->db->set('money','money+'.$agent_money,false)->where('id',$agent['id'])->update('admin');
        }

        if($shop_money>0){
            $this->db->insert('divide_record',[
                'order_id'=>$trade['id'],
                'order_no'=>$trade['tradeno'],
                'order_money'=>$trade['pay_money'],
                'money'=>$shop_money,
                'proportion'=>$shop['percen'],
                'parameter_id'=>$shop['id'],
                'ctime'=>date('Y-m-d H:i:s')
            ]);
            //增加金额
            $this->db->set('money','money+'.$shop_money,false)->where('id',$shop['id'])->update('admin');
        }

        if($admin_money>0){
            $this->db->insert('divide_record',[
                'order_id'=>$trade['id'],
                'order_no'=>$trade['tradeno'],
                'order_money'=>$trade['pay_money'],
                'money'=>$admin_money,
                'parameter_id'=>1,
                'ctime'=>date('Y-m-d H:i:s')
            ]);
        }

        return true;

    }
    //获取分成比例
    public function get_agent_proportion($admin_id){
        if(!$admin_id) return [];
        $admin=$this->_getrow('admin','id,pid,percen,path',['id'=>$admin_id]);
        $arr=[];
        $arr[]=['id'=>$admin['id'],'percen'=>$admin['percen']];
        if($admin['path'] && $admin['id']!=1){
            $list=$this->_getlist('admin','id,percen',"id in(".$admin['path'].")",'id desc');
            foreach($list as $k=>$v){
                $arr[]=['id'=>$v['id'],'percen'=>$v['percen']];
            }
        }
        return $arr;
    }
	
	//订单完成处理
	public function finish($tradeid = 0){
		if(empty($tradeid))return false;
		$trade = $this->_getrow('trade', '*', 'status=1 and id='.$tradeid);
		if(!$trade)return false;
		
		if($trade['couponid'])$this->db->update('user_coupon', array('status' => 1, 'usetime' => time()), "id in (".$trade['couponid'].")");
		
		//会员余额变化
		$this->db->set('money', '`money`-'.$trade['money'], false);
		$this->db->set('redmoney', '`redmoney`-'.($trade['redmoney'] - $trade['user_money']), false);
		$this->db->where('id='.$trade['userid']);
		$this->db->update('user');
		
		//代理余额变化
		if($trade['admin_corpid'] && $trade['corp_money']){
			$this->db->set('money', '`money`+'.$trade['corp_money'], false);
			$this->db->where('id='.$trade['admin_corpid']);
			$this->db->update('admin');
		}
		
		//医院余额变化
		if($trade['adminid'] && $trade['admin_money']){
			$this->db->set('money', '`money`+'.$trade['admin_money'], false);
			$this->db->where('id='.$trade['adminid']);
			$this->db->update('admin');
		}
		
		//消费者推荐
		/*if($trade['user_recmdid'] && $trade['user_recmd_money']){
			$this->db->set('redmoney', '`redmoney`+'.$trade['user_recmd_money'], false);
			$this->db->where('id='.$trade['user_recmdid']);
			$this->db->update('user');
		}*/
		
		//商户推荐
		/*if($trade['admin_recmdid'] && $trade['admin_recmd_money']){
			$this->db->set('redmoney', '`redmoney`+'.$trade['admin_recmd_money'], false);
			$this->db->where('id='.$trade['admin_recmdid']);
			$this->db->update('user');
		}*/
		
		//账目明细
		$this->finance_mdl->add($trade, 0);
		
		return true;
	}
	
	//交易退款
	public function refund($tradeid = 0){
		if(empty($tradeid))return false;
		$trade = $this->_getrow('trade', '*', 'id='.$tradeid);
		if(!$trade)return false;

		if($trade['couponid'])$this->db->update('user_coupon', array('status' => 0, 'usetime' => 0), "id in (".$trade['couponid'].")");
		
		//会员余额变化
		$this->db->set('money', '`money`+'.$trade['money']+$trade['paymoney'], false);
		$this->db->set('redmoney', '`redmoney`+'.($trade['redmoney'] - $trade['user_money']), false);
		$this->db->where('id='.$trade['userid']);
		$this->db->update('user');
		
		//代理余额变化
		if($trade['admin_corpid'] && $trade['corp_money']){
			$this->db->set('money', '`money`-'.$trade['corp_money'], false);
			$this->db->where('id='.$trade['admin_corpid']);
			$this->db->update('admin');
		}
		
		//医院余额变化
		if($trade['adminid'] && $trade['admin_money']){
			$this->db->set('money', '`money`-'.$trade['admin_money'], false);
			$this->db->where('id='.$trade['adminid']);
			$this->db->update('admin');
		}
		
		//消费者推荐
		/*if($trade['user_recmdid'] && $trade['user_recmd_money']){
			$this->db->set('redmoney', '`redmoney`-'.$trade['user_recmd_money'], false);
			$this->db->where('id='.$trade['user_recmdid']);
			$this->db->update('user');
		}*/
		
		//商户推荐
		/*if($trade['admin_recmdid'] && $trade['admin_recmd_money']){
			$this->db->set('redmoney', '`redmoney`-'.$trade['admin_recmd_money'], false);
			$this->db->where('id='.$trade['admin_recmdid']);
			$this->db->update('user');
		}*/
		
		//账目明细
		//$this->finance_mdl->add($trade, 8);
		return true;		
	}
}
