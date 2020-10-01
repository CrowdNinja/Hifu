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
class Admin_trade extends Admin_Controller {
	/**
	 * 构造函数
	 *
	 * @access  public
	 * @return  void
	 */
	 
	private $trade_status = array(-2=>'<b style="color:red;">已退款</b>',-1=>"<b style='color:red;'>等待退款</b>",0 => '<b style="color:#999">未支付</b>', 1 => '<b style="color:green">待预约</b>', 2 => '<b style="color:orange;">待使用</b>', 3 => '<b style="color:green;">已完成</b>',4=>"<b style='color:goldenrod;'>待评价</b>",5=> '<b style="color:#999">已过期</b>');
	private $trade_paytype = array(
                1 => '残高支払い',
                2 => 'WeChat',
                3 => 'Alipay',
                4 => 'LINE Pay',
                5 => 'クレジットカード',
                6 => '現金お支払い'
    );
	private $reservation_status=array('<b >未使用</b>','<b style="color:green">已使用</b>','<b style="color:red;">已取消</b>');
	public function __construct()
	{
		parent :: __construct();
		$this->load->model('setting_mdl');
		$this->load->model('trade_mdl');
    }

    public function search_cash()
    {
		$keywords = $this->input->post('keywords');
		$userid = $this->input->post('userid');
		if(!empty($keywords)){
			$where = "pay_token like '%".$keywords."%'";
			$result = $this->_getlist(['trade', ['pack', 'pack.id=trade.pack_id']], 'trade.pay_token as id, concat(trade.id, ", ", pack.title) as `text`', $where, 'trade.id desc');
			die('{"status":-1, "data":'.json_encode($result).'}');
		}
		die('{"status":-1, "data":[]}');
    }
    
    public function trade_money()
    {
        $page = $this->input->get('page');
		$pagesize = $this->input->get('pagesize');
		if(empty($pagesize))$pagesize = 20;
		
		$keywords = $this->input->get('keywords');
		$corpid = $this->input->get('corpid');
		$createtime2 = $this->input->get('createtime2');
        $tradeno=$this->input->get('tradeno');
        $user_name = $this->input->get('user_name');
        $pay_token = $this->input->get('pay_token');
        $pack_title = $this->input->get('pack_title');
        $device = $this->input->get('device');
		$this->assign('get', $this->input->get());
		
		//处理搜索SQL
		if(is_numeric($corpid)){
			$where = ' 1=1 '.$this->_rolesql('', 'agent_id', $corpid);
		//}elseif($this->_admin->_role_type == 1){
		//	$where = ' 1=1 '.$this->_rolesql('', 'admin_corpid');
		}else{
        	$where = ' 1=1 '.$this->_rolesql('',$this->_getrolefield());
		}
        $where.="  and paytype=6 and pay_token <> ''";
        if($tradeno){
            $where.="  and tradeno='$tradeno'";
        }
		if(!empty($user_name)){
            $user_ids = $this->_getcol('user', 'id', 'nickname like "%'.$user_name.'%"');
            $user_ids_str = implode(',', $user_ids);
            if ($user_ids_str != '')
            $where .= ' and user_id in ('.$user_ids_str.')';
            else 
            $where .= ' and user_id = "-1"';
		}

        if(!empty($createtime2)){
            $createtime2 = $createtime2." 23:59:59";
            $where .= " and ctime<='".$createtime2."'";
        }

        if (!empty($pay_token)) {
            $where .= " and pay_token like '%".$pay_token."%'";
        }

        if (!empty($pack_title)) {
            $pack_ids = $this->_getcol('pack', 'id', 'title like "%'.$pack_title.'%"');
            $pack_ids_str = implode(',', $pack_ids);
            if ($pack_ids_str)
                $where .= " and pack_id in (".$pack_ids_str.")";
            else 
                $where .= " and pack_id = '-1'";
        }

        if (is_numeric($device)) {
            // $where
            // if ($device != -1) {
            //     $where .= " and types='".$device.",'";
            // } 
        }
		
		//注意php代码不需要处理搜索URL参数，分页URL的处理注意本页模板页尾的JS代码
        $trade = $this->_getpage('trade', $where, 'id desc', $page, $pagesize);
		foreach($trade['list'] as &$v){
            // ユーザ情報取得
            $user = $this->_getrow('user', '*', 'id='.$v['user_id']);
            $v['user_name'] = $user['nickname'];
            $v['user_phone_no'] = $user['account'];

			$v['_adminid'] = $this->_getfield('admin', 'concat(id, " ,", nickname)', 'id='.$v['adminid']);
			$v['agent_name'] = $this->_getfield('admin', 'concat(id, " ,", nickname)', 'id='.$v['agent_id']);
            $v['pack']=$this->_getrow('pack','*',['id'=>$v['pack_id']]);
            if ($v['pack']['subscription_flg']==1) {
                $subscription_pack=$this->_getrow('subscription_pack_types', '*', 'id='.$v['pack']['subscription_type']);
                if ($subscription_pack) {
                    $v['pack']['title'] = $subscription_pack['title'];
                    $v['pack']['count'] = $subscription_pack['count'];
                    $v['pack']['discount'] = $subscription_pack['discount'];
                }
            }
            $v['reservations']=$this->_getlist('reservation', '*', 'trade_id='.$v['id']);
            foreach($v['reservations'] as &$reservation) {
                $a = $reservation['types'];
                $a = str_replace('1', '美容刀', $a);
                $a = str_replace('2', '脱毛机', $a);
                $reservation['types'] = explode(',', $a);
            }
            $v=$this->replace_null_time($v);
			//$v['_user_recmdid'] = $v['user_recmdid'] ? $this->_getfield('user', 'if(account=nickname,concat(id, ", ", account),concat(id, ", ", account, ", ", nickname))', 'id='.$v['user_recmdid']) : '';
			//$v['_admin_recmdid'] = $v['admin_recmdid'] ? $this->_getfield('user', 'if(account=nickname,concat(id, ", ", account),concat(id, ", ", account, ", ", nickname))', 'id='.$v['admin_recmdid']) : '';
		}
		unset($v);

		$this->assign('trade', $trade);
		$this->assign('trade_status', $this->trade_status);
		$this->assign('trade_paytype', $this->trade_paytype);
		$this->display('trade/pay_cash.html');
    }

    public function pay_money()
    {
        $inputs = $this->input->post();
        if ($inputs) {
            $ids = $inputs['ids'];
            $this->db->update('trade', ['pay_token'=>null], 'id in ('.$ids.')');
        }
        die('{"status": 1}');
    }

    public function delete_trades()
    {
        $inputs = $this->input->post();
        if ($inputs) {
            $ids = $inputs['ids'];
            $this->db->delete('trade', 'id in ('.$ids.')');
        }
    }

    public function edit_cash($trade_id = 0)
    {
        $posts = $this->input->post();
        if ($posts) {
            $pack = $this->_getrow('pack', '*', 'id='.$posts['pack_id']);
            if ($pack['subscription_flg'] == 0) {
                $subsc = $this->_getrow('subscription_pack_types', '*', 'id='.$pack['subscription_type']);
                $pack['title'] = $subsc['title'];
                $pack['count'] = $subsc['count'];
                $pack['discount'] = $subsc['discount'];
            }
            $pack_items = $this->_getlist('pack_item', '*', 'pack_id='.$pack['id']);
            $reservations = $this->_getlist('reservation', '*', 'trade_id='.$trade_id);
            die('{"status":1, "pack":'.json_encode($pack).', "pack_items":'.json_encode($pack_items).', "reservations":'.json_encode($reservations)."}");
        }
        $cash = $this->_getrow('trade', '*', 'id='.$trade_id);
        $pack = $this->_getrow('pack', '*', 'id='.$cash['pack_id']);
        if ($pack['subscription_flg'] == 0) {
            $subsc = $this->_getrow('subscription_pack_types', '*', 'id='.$pack['subscription_type']);
            $pack['title'] = $subsc['title'];
            $pack['count'] = $subsc['count'];
            $pack['discount'] = $subsc['discount'];
        }
        $pack_items = $this->_getlist('pack_item', '*', 'pack_id='.$pack['id']);
        $reservations = $this->_getlist('reservation', '*', 'trade_id='.$trade_id);
        $this->assign('cash', $cash);
        $this->assign('reservations', $reservations);
        $this->assign('pack', $pack);
        $this->assign('pack_items', $pack_items);
        $this->display('trade/edit_cash.html');
    }

	public function index() 
	{
		$page = $this->input->get('page');
		$pagesize = $this->input->get('pagesize');
		if(empty($pagesize))$pagesize = 20;
		
		$keywords = $this->input->get('keywords');
		$userid = $this->input->get('userid');
		$adminid = $this->input->get('adminid');
		$corpid = $this->input->get('corpid');
		$user_recmdid = $this->input->get('user_recmdid');
		$admin_recmdid = $this->input->get('admin_recmdid');
		$tradeid = $this->input->get('tradeid');
		$paytype = $this->input->get('paytype');
		$createtime1 = $this->input->get('createtime1');
		$createtime2 = $this->input->get('createtime2');
		$tradeno=$this->input->get('tradeno');
		$status = $this->input->get('status');
		$this->assign('get', $this->input->get());
		
		//处理搜索SQL
		if(is_numeric($corpid)){
			$where = ' 1=1 '.$this->_rolesql('', 'agent_id', $corpid);
		//}elseif($this->_admin->_role_type == 1){
		//	$where = ' 1=1 '.$this->_rolesql('', 'admin_corpid');
		}else{
        	$where = ' 1=1 '.$this->_rolesql('',$this->_getrolefield());
		}
		if($keywords){
            $where .= " and macno like '%$keywords%'";
		}
		if($paytype){
		    $where.="  and paytype=$paytype";
        }
        if($tradeno){
            $where.="  and tradeno='$tradeno'";
        }
		if(is_numeric($userid)){
			$where .= ' and user_id='.$userid;
			$this->assign('get_userid_account', $this->_getfield('user', 'if(account=nickname,concat(id, ", ", account),concat(id, ", ", account, ", ", nickname))', 'id='.$userid));
		}
		if(is_numeric($adminid)){
			$where .= ' and adminid='.$adminid;
			$this->assign('get_adminid_account', $this->_getfield('admin', 'concat(id, ", ", nickname)', 'id='.$adminid));
		}
		if(is_numeric($corpid)){
			$where .= ' and agent_id='.$corpid;
			$this->assign('get_corpid_account', $this->_getfield('admin', 'concat(id, ", ", nickname)', 'id='.$corpid));
		}
		if(is_numeric($user_recmdid)){
			$where .= ' and user_recmdid='.$user_recmdid;
			$this->assign('get_user_recmdid_account', $this->_getfield('user', 'if(account=nickname,concat(id, ", ", account),concat(id, ", ", account, ", ", nickname))', 'id='.$user_recmdid));
		}
		if(is_numeric($admin_recmdid)){
			$where .= ' and admin_recmdid='.$admin_recmdid;
			$this->assign('get_admin_recmdid_account', $this->_getfield('user', 'if(account=nickname,concat(id, ", ", account),concat(id, ", ", account, ", ", nickname))', 'id='.$admin_recmdid));
		}
		if(is_numeric($tradeid)){
			$where .= ' and id='.$tradeid;
			$this->assign('get_tradeid_tradeno', $this->_getfield('trade', 'concat(id, ", ", tradeno)', 'id='.$tradeid));
		}
		if(is_numeric($status)){
			$where .= ' and status='.$status;
		}
        if(!empty($createtime1)){
            $createtime1 = $createtime1." 00:00:00";
            $where .= " and ctime>='".$createtime1."'";
        }

        if(!empty($createtime2)){
            $createtime2 = $createtime2." 23:59:59";
            $where .= " and ctime<='".$createtime2."'";
        }

        // 未払いは非表示とする
        $where .= " and status <> 0 ";
		
		//注意php代码不需要处理搜索URL参数，分页URL的处理注意本页模板页尾的JS代码
		$trade = $this->_getpage('trade', $where, 'id desc', $page, $pagesize);
		foreach($trade['list'] as &$v){
			$v['_userid'] = $this->_getfield('user', 'if(account=nickname,concat(id, ", ", account),concat(id, ", ", account, ", ", nickname))', 'id='.$v['user_id']);
			$v['_adminid'] = $this->_getfield('admin', 'concat(id, " ,", nickname)', 'id='.$v['adminid']);
			$v['agent_name'] = $this->_getfield('admin', 'concat(id, " ,", nickname)', 'id='.$v['agent_id']);
			$v['pack']=$this->_getrow('pack','*',['id'=>$v['pack_id']]);
			$v=$this->replace_null_time($v);
			//$v['_user_recmdid'] = $v['user_recmdid'] ? $this->_getfield('user', 'if(account=nickname,concat(id, ", ", account),concat(id, ", ", account, ", ", nickname))', 'id='.$v['user_recmdid']) : '';
			//$v['_admin_recmdid'] = $v['admin_recmdid'] ? $this->_getfield('user', 'if(account=nickname,concat(id, ", ", account),concat(id, ", ", account, ", ", nickname))', 'id='.$v['admin_recmdid']) : '';
		}
		unset($v);

		$this->assign('trade', $trade);
		$this->assign('trade_status', $this->trade_status);
		$this->assign('trade_paytype', $this->trade_paytype);
		$this->display('trade/list_trade.html');
	}

	public function edit($id=0,$page=1){
		if($id){
			$row = $this->_getrow('trade', '*', 'id='.$id.$this->_rolesql('',$this->_getrolefield()));
			$row['user_account'] = $this->_getfield('user', 'if(account=nickname,concat(id, ", ", account),concat(id, ", ", account, ", ", nickname))', 'id='.$row['user_id']);
			$row['admin_account'] = $this->_getfield('admin', 'concat(id, ", ", nickname)', 'id='.$row['adminid']);
			$row['corp_account'] = $this->_getfield('admin', 'concat(id, ", ", nickname)', 'id='.$row['agent_id']);
			$row['device_macno'] = $this->_getfield('device', ' concat(id, ", ", macno) as `text`', 'id='.$row['device_id']);
			$divide_record=$this->_getlist('divide_record','*',"order_no='".$row['tradeno']."'");
			$row['pack']=$this->_getrow('pack','*',['id'=>$row['pack_id']]);
			$row['trade_pack']=$this->_getlist('trade_pack_item','*',['trade_id'=>$row['id']]);
			foreach($divide_record as $k=>&$v){
			    if($v['parameter_id']==1){
                    $v['agentname']=translate("平台");;
                    $v['proportion']=round($v['money']/$v['order_money']*100,2);
                }else{
                    $v['agentname']=$this->_getfield('admin','nickname',['id'=>$v['parameter_id']]);
                }
            }
            unset($v);
			$row=$this->replace_null_time($row);
			$this->assign('row', $row);
			$this->assign('divide_record', $divide_record);
		}
		$this->assign('trade_status', $this->trade_status);
		$this->assign('trade_paytype', $this->trade_paytype);
		$this->assign('page',$page);
		$this->display('trade/edit_trade.html');
	}

    public function reservation(){
        $page = $this->input->get('page');
        $pagesize = $this->input->get('pagesize');
        if(empty($pagesize))$pagesize = 20;

        $keywords = $this->input->get('keywords');
        $userid = $this->input->get('user_id');
        $adminid = $this->input->get('adminid');
        $tradeid = $this->input->get('tradeid');
        $trade_id = $this->input->get('trade_id');
        $createtime1 = $this->input->get('createtime1');
        $createtime2 = $this->input->get('createtime2');
        $tradeno=$this->input->get('tradeno');
        $this->assign('get', $this->input->get());

        //处理搜索SQL

        $where = ' 1=1 '.$this->_rolesql('',"shop_id");

        if($keywords){
            $where .= " and macno like '%$keywords%'";
        }
        if($trade_id){
            $where.=" and trade_id=$trade_id";
        }
        if(is_numeric($userid)){
            $where .= ' and user_id='.$userid;
            $this->assign('get_userid_account', $this->_getfield('user', 'if(account=nickname,concat(id, ", ", account),concat(id, ", ", account, ", ", nickname))', 'id='.$userid));
        }
        if(is_numeric($adminid)){
            $where .= ' and shop_id='.$adminid;
            $this->assign('get_adminid_account', $this->_getfield('admin', 'concat(id, ", ", nickname)', 'id='.$adminid));
        }

        if(is_numeric($tradeid)){
            $where .= ' and trade_id='.$tradeid;
            $this->assign('get_tradeid_tradeno', $this->_getfield('trade', 'concat(id, ", ", tradeno)', 'id='.$tradeid));
        }

        if(!empty($createtime1)){
            $createtime1 = $createtime1." 00:00:00";
            $where .= " and start_time>='".$createtime1."'";
        }

        if(!empty($createtime2)){
            $createtime2 = $createtime2." 23:59:59";
            $where .= " and start_time<='".$createtime2."'";
        }

        //注意php代码不需要处理搜索URL参数，分页URL的处理注意本页模板页尾的JS代码
        $list = $this->_getpage('reservation', $where, 'id desc', $page, $pagesize,['shop_id','shop_id']);
        foreach($list['list'] as &$v){
            $v['shop_name']=$this->_getfield('admin','nickname',['id'=>$v['shop_id']]);
            $v['mr_num']=$this->_getfield('reservation','sum(mr_num)',"shop_id=".$v['shop_id']." and status<2 and start_time>='".date('Y-m-d')."' and start_time<='".date('Y-m-d')." 23:59:59'")?:"0";
            $v['tm_num']=$this->_getfield('reservation','sum(tm_num)',"shop_id=".$v['shop_id']." and status<2 and start_time>='".date('Y-m-d')."' and start_time<='".date('Y-m-d')." 23:59:59'")?:"0";

        }
        unset($v);

        $this->assign('list', $list);
        $this->assign('page',$page?:1);
        $this->display('trade/list_reservation.html');
    }
	//预约列表
    public function reservation_details($shop_id=0,$type=1,$p=1){
        $page = $this->input->get('page');
        $pagesize = $this->input->get('pagesize');
        if(empty($pagesize))$pagesize = 20;

        $keywords = $this->input->get('keywords');
        $userid = $this->input->get('user_id');
        $adminid = $this->input->get('adminid');
        $tradeid = $this->input->get('tradeid');
        $trade_id = $this->input->get('trade_id');
        $createtime1 = $this->input->get('createtime1');
        $createtime2 = $this->input->get('createtime2');
        $tradeno=$this->input->get('tradeno');
        $this->assign('get', $this->input->get());

        //处理搜索SQL
        $where = ' shop_id='.$shop_id." and find_in_set(".$type.", types)>0";


        if($keywords){
            $where .= " and macno like '%$keywords%'";
        }
        if($trade_id){
            $where.=" and trade_id=$trade_id";
        }
        if(is_numeric($userid)){
            $where .= ' and user_id='.$userid;
            $this->assign('get_userid_account', $this->_getfield('user', 'if(account=nickname,concat(id, ", ", account),concat(id, ", ", account, ", ", nickname))', 'id='.$userid));
        }
        if(is_numeric($adminid)){
            $where .= ' and shop_id='.$adminid;
            $this->assign('get_adminid_account', $this->_getfield('admin', 'concat(id, ", ", nickname)', 'id='.$adminid));
        }

        if(is_numeric($tradeid)){
            $where .= ' and trade_id='.$tradeid;
            $this->assign('get_tradeid_tradeno', $this->_getfield('trade', 'concat(id, ", ", tradeno)', 'id='.$tradeid));
        }

        if(!empty($createtime1)){
            $createtime1 = $createtime1." 00:00:00";
            $where .= " and start_time>='".$createtime1."'";
        }

        if(!empty($createtime2)){
            $createtime2 = $createtime2." 23:59:59";
            $where .= " and start_time<='".$createtime2."'";
        }

        //注意php代码不需要处理搜索URL参数，分页URL的处理注意本页模板页尾的JS代码
        $list = $this->_getpage('reservation', $where, 'id desc', $page, $pagesize);
        foreach($list['list'] as &$v){
            $v['trade']=$this->_getrow('trade','*',['id'=>$v['trade_id']]);
            $v['shop_name']=$this->_getfield('admin','nickname',['id'=>$v['shop_id']]);
            $v['user']=$this->_getrow('user','id,nickname,avatar,account',['id'=>$v['user_id']]);
            $pack_item_id=explode(',',$v['pack_item_id']);
            $use_status=explode(',',$v['use_status']);
            $arr=[];
            for($i=0;$i<count($pack_item_id);$i++){
                $title=$this->_getfield('trade_pack_item',"item_name","id=".$pack_item_id[$i]);
                if($use_status[$i]==0) $qr=base_url("user_api/item_qrcode/".$pack_item_id[$i]."/".$v['id']);
                if($use_status[$i]==1) $qr="images/use_qr.jpg";
                if($v['status']==2) $qr='';
                $arr[]=['title'=>$title,'status'=>($use_status[$i]==0)?translate("未使用"):translate("已使用"),'qr'=>$qr];
            }
            $v['item_list']=$arr;
        }
        unset($v);

        $this->assign('list', $list);
        $this->assign('p', $p);
        $this->assign('type', $type);
        $this->assign('shop_id', $shop_id);
        $this->assign('reservation_status',$this->reservation_status);
        $this->display('trade/list_reservation_details.html');
    }

    //取消预约
    public function cancel_reservation(){
	    $id=$this->input->post('id');
	    if($id){
            $reservation=$this->_getrow('reservation','*',['id'=>$id]);
            if(!$reservation) $this->admin_return(0,'没有找到预约信息');
            if($reservation['status']!=0) $this->admin_return(0,'预约信息 状态错误');
            $arr_use_status=explode(',',$reservation['use_status']);
            if(in_array(1,$arr_use_status)) $this->admin_return(0,'已使用不能取消');
            $trade=$this->_getrow('trade','*',['id'=>$reservation['trade_id']]);
            //判断是到使用那天之前取消的还是其它时间取消
            if(strtotime(date('Y-m-d',strtotime($reservation['start_time'])))==strtotime(date('Y-m-d'))){//当天取消的要扣掉使用次数
                $this->admin_return(0,'不能取消当天的预约');
                //判断订单是否还有使用次数
               /* $is_success=$this->_getfield('trade_pack_item','id',"(num-use_num)>0 and trade_id=".$reservation['trade_id']);
                if(!$is_success){//订单已经使用完这个时候开始分成
                    $trade=$this->_getrow('trade','*',['id'=>$reservation['trade_id']]);
                    //TODO 分成
                    $this->trade_mdl->divide_into($trade['id']);
                    //判断订单是否评价过
                    if($trade['is_evaluate']==1){
                        $status=3;
                    }else{
                        $status=4;
                    }
                }*/
            }else{//提前结束 退还使用次数
                $this->db->set('use_num',"use_num-1",false)->where('id in('.$reservation['pack_item_id'].")")->update('trade_pack_item');
                $status=1;
            }

            $trade_arr=['status'=>$status];
            if($status==4) $trade_arr['success_time']=date('Y-m-d H:i:s');
            //修改订单状态
            $this->db->update('trade',$trade_arr,['id'=>$trade['id']]);
            //修改预约单状态
            $this->db->update('reservation',['status'=>2],['id'=>$reservation['id']]);
            $this->admin_return(1,'取消成功');
        }
        $this->admin_return(0,'数据错误');

    }
    //详情
    public function reservation_edit($id=0){
	    $row=$this->_getrow('reservation','*',['id'=>$id]);
        $pack_item_id=explode(',',$row['pack_item_id']);
        $use_status=explode(',',$row['use_status']);
        $arr=[];
        for($i=0;$i<count($pack_item_id);$i++){
            $title=$this->_getfield('trade_pack_item',"item_name","id=".$pack_item_id[$i]);
            if($use_status[$i]==0) $qr=base_url("user_api/item_qrcode/".$pack_item_id[$i]."/".$row['id']);
            if($use_status[$i]==1) $qr="images/use_qr.jpg";
            if($row['status']==2) $qr='';
            $arr[]=['title'=>$title,'status'=>($use_status[$i]==0)?translate("未使用"):translate("已使用"),'qr'=>$qr];
        }
        $row['shop']=$this->_getrow('admin','id,nickname',['id'=>$row['shop_id']]);
        $row['user']=$this->_getrow('user','id,nickname,account',['id'=>$row['user_id']]);
        $row['item_list']=$arr;
	    $this->assign('row', $row);
        $this->assign('reservation_status',$this->reservation_status);
        $this->display('trade/reservation.html');
    }
    //预约删除
    public function reservation_delete(){
	    $ids=$this->input->post('ids');
	    if($ids){
	        $this->log_mdl->delete('reservation',"id in ($ids)");
        }
        $this->admin_return(1);
    }

	//退款
    public function refund(){
	    $id=$this->input->post('id');
	    if($id){
	        $time=date('Y-m-d H:i:s');
	        $trade=$this->_getrow('trade','*',['id'=>$id]);
	        if(!in_array($trade['status'],['-1','3',"4"])) $this->admin_return(0,'订单状态错误');
	        if($trade['pay_money']<=0){
                //修改订单状态
                $this->log_mdl->update('trade',['status'=>-2,'refund_time'=>$time],['id'=>$id]);
	            $this->admin_return(1);
            }
            //修改订单状态
            $this->log_mdl->update('trade',['status'=>-2,'refund_time'=>$time],['id'=>$id]);
            $this->refund_divide($trade);
            //订单金额退回到用户余额
            $this->db->set('money','money+'.$trade['pay_money'],false)->where('id',$trade['user_id'])->update('user');

            $this->admin_return(1);

	        /*if($trade['paytype']==1){
                //修改订单状态
                $this->log_mdl->update('trade',['status'=>2,'refund_time'=>$time],['id'=>$id]);
                $this->refund_divide($trade);
                //订单金额退回到用户余额
                $this->db->set('money','money+'.$trade['pay_money'],false)->where('id',$trade['user_id'])->update('user');

                $this->admin_return(1);
            }elseif($trade['paytype']==2){//微信
	            $refund_money=$trade['pay_money']-$trade['timeout_money'];
	            if($refund_money<=0 && $trade['timeout_money']>0){
                    $res=$this->wx_refund($trade,$trade['timeout_money'],2);
                    if($res['return_code'] == "SUCCESS" && $res['result_code'] == "SUCCESS"){
                        $this->log_mdl->update('trade',['status'=>2,'refund_time'=>$time],['id'=>$id]);
                        $this->refund_divide($trade);
                        $this->admin_return(1);
                    }
                }else{
                    $res=$this->wx_refund($trade,$trade['pay_money']-$trade['timeout_money']);
                    if($res['return_code'] == "SUCCESS" && $res['result_code'] == "SUCCESS"){
                        if($trade['takes_no']) $this->wx_refund($trade,$trade['timeout_money'],2);
                        //修改订单状态
                        $this->log_mdl->update('trade',['status'=>2,'refund_time'=>$time],['id'=>$id]);
                        $this->refund_divide($trade);
                        $this->admin_return(1);
                    }
                }

                $this->admin_return(0,  '退款失败:'.$res['err_code_des']);
            }else{//3支付宝
                $res=$this->ali_refund($trade);
                $refund_money=$trade['pay_money']-$trade['timeout_money'];
                if($refund_money<=0 && $trade['timeout_money']>0){
                    $res=$this->ali_refund($trade,2);
                    if(!empty($res)&&$res == 10000){
                        //修改订单状态
                        $this->log_mdl->update('trade',['status'=>2,'refund_time'=>$time],['id'=>$id]);
                        $this->refund_divide($trade);
                        $this->admin_return(1);
                    }
                }else{
                    if(!empty($res)&&$res == 10000){
                        $res=$this->ali_refund($trade,2);
                        //修改订单状态
                        $this->log_mdl->update('trade',['status'=>2,'refund_time'=>$time],['id'=>$id]);
                        $this->refund_divide($trade);
                        $this->admin_return(1);
                    }
                }
                $this->admin_return(0,  '退款失败');
            }*/

        }
        $this->admin_return(0,'数据错误');
    }

    //退分成
    private function refund_divide($trade=0){
        //分成退款
        $list=$this->_getlist('divide_record','*',['order_no'=>$trade['tradeno']]);
        if($list){
            foreach($list as $k=>$v){
                $this->log_mdl->update('divide_record',['status'=>-1,'refund_time'=>date('Y-m-d H:i:s')],['id'=>$v['id']]);
                //退分成
                $this->db->set('money','money-'.$v['money'],false)->where('id',$v['parameter_id'])->update('admin');
            }
        }
        return true;
    }


	public function delete(){
		$ids = $this->input->post('ids');
		if(!empty($ids)){
			/*$this->db->where('1=1'.$this->_rolesql('',$this->_getrolefield()));
			$this->db->where_in('id', explode(',', $ids));*/
			$this->log_mdl->delete('trade',"id in($ids)".$this->_rolesql('',$this->_getrolefield()));
		}
		die('{"status":1}');	
	}
	
	public function clear(){
		$this->log_mdl->delete('trade', ' 1=1 '.$this->_rolesql('',$this->_getrolefield()));
		die('{"status":1}');	
	}
	
	public function check(){
		$id = $this->input->post('id');
		$tradeno = $this->input->post('tradeno');
		if(!empty($tradeno)){
			$where = "tradeno='".$tradeno."'";
			if(!empty($id))$where .= " and id<>".$id;
			$count = $this->_getcount('trade', $where);
			die('{"status":"'.$count.'"}');
		}
		die('{"status":"-1"}');
	}
    //分成记录
    public function divide_record($id=0,$p=1,$url=""){
        $page = $this->input->get('page');
        $pagesize = $this->input->get('pagesize');
        if (empty($pagesize)) $pagesize = 20;
        $order_no=trim($this->input->get('order_no'));
        $createtime1 = $this->input->get('createtime1');
        $createtime2 = $this->input->get('createtime2');

        $this->assign('p', $p );
        $this->assign('id',$id);
        $this->assign('url',$url);
        $where = 'a.parameter_id='.$id.' and a.money>0';
        if($order_no){
            $where.=" and a.order_no like'%".$order_no."%'";
        }

        if(!empty($createtime1)){
            $createtime1 = $createtime1." 00:00:00";
            $where .= " and a.ctime>='".$createtime1."'";
        }

        if(!empty($createtime2)){
            $createtime2 = $createtime2." 23:59:59";
            $where .= " and a.ctime<='".$createtime2."'";
        }

        //注意php代码不需要处理搜索URL参数，分页URL的处理注意本页模板页尾的JS代码
        $row = $this->_getpage(array('divide_record as a', array('admin as b', 'a.parameter_id = b.id')), $where, 'a.id desc', $page, $pagesize, 'a.*,b.nickname');

        $total_money=$this->_getfield(array('divide_record as a', array('admin as b', 'a.parameter_id = b.id')),'sum(a.money)',$where)?:"0.00";
        $refund_money=$this->_getfield(array('divide_record as a', array('admin as b', 'a.parameter_id = b.id')),'sum(a.money)',$where." and a.status=-1")?:"0.00";
        $this->assign("total_money", $total_money);
        $this->assign("refund_money", $refund_money);
        $this->assign("money", $total_money-$refund_money);
        $this->assign("gid", $_SESSION['gid']);
        $this->assign('row', $row);
        $this->display('trade/list_divide_record.html');
    }
    

	public function search_pack(){
		$keywords = $this->input->post('keywords');
		if(!empty($keywords)){
            $where = "(a.id='".$keywords."' or a.title like '%".$keywords."%' or a.price like '%".$keywords."%')";
            $result = $this->_getlist('pack as a', '*', $where, 'a.id desc');
            foreach($result as &$pack) {
                $pack['text'] = $pack['title'];
                if ($pack['subscription_flg'] == 1) {
                    $result = $this->_getrow('subscription_pack_types', '*', 'id='.$pack['subscription_type']);
                    $pack['text'] = $result['title'];
                    $pack['count'] = $result['count'];
                    $pack['discount'] = $pack['discount'];
                }
            }
            // var_dump($result);
			die('{"status":-1, "data":'.json_encode(multi_array_unique($result)).'}');
		}
		die('{"status":-2, "data":[]}');
	}
		
	public function search(){
		$keywords = $this->input->post('keywords');
		$userid = $this->input->post('userid');
		if(!empty($keywords)){
			$where = "(id='".$keywords."' or tradeno like '%".$keywords."%')".$this->_rolesql('',$this->_getrolefield());
			if($userid)$where .= ' and userid='.$userid;
			$result = $this->_getlist('trade', 'id, concat(id, ", ", tradeno) as `text`', $where, 'id desc');
			die('{"status":-1, "data":'.json_encode($result).'}');
		}
		die('{"status":-1, "data":[]}');
	}

    public function export(){

        $keywords = $this->input->get('keywords');
        $userid = $this->input->get('userid');
        $adminid = $this->input->get('adminid');
        $corpid = $this->input->get('corpid');
        $user_recmdid = $this->input->get('user_recmdid');
        $admin_recmdid = $this->input->get('admin_recmdid');
        $tradeid = $this->input->get('tradeid');
        $createtime1 = $this->input->get('createtime1');
        $createtime2 = $this->input->get('createtime2');
        $tradeno=$this->input->get('tradeno');
        $status = $this->input->get('status');
        $this->assign('get', $this->input->get());

        //处理搜索SQL
        if(is_numeric($corpid)){
            $where = ' 1=1 '.$this->_rolesql('', 'agent_id', $corpid);
            //}elseif($this->_admin->_role_type == 1){
            //	$where = ' 1=1 '.$this->_rolesql('', 'admin_corpid');
        }else{
            $where = ' 1=1 '.$this->_rolesql('',$this->_getrolefield());
        }
        if($keywords){
            $where .= " and (devicemacno like '%$keywords%' or device_goodsmacno like '%$keywords%' or device_goodsmacno2 like '%$keywords%')";
        }
        if($tradeno){
            $where.="  and tradeno='$tradeno'";
        }
        if(is_numeric($userid)){
            $where .= ' and user_id='.$userid;
            $this->assign('get_userid_account', $this->_getfield('user', 'if(account=nickname,concat(id, ", ", account),concat(id, ", ", account, ", ", nickname))', 'id='.$userid));
        }
        if(is_numeric($adminid)){
            $where .= ' and adminid='.$adminid;
            $this->assign('get_adminid_account', $this->_getfield('admin', 'concat(id, ", ", nickname)', 'id='.$adminid));
        }
        if(is_numeric($corpid)){
            $where .= ' and agent_id='.$corpid;
            $this->assign('get_corpid_account', $this->_getfield('admin', 'concat(id, ", ", nickname)', 'id='.$corpid));
        }
        if(is_numeric($user_recmdid)){
            $where .= ' and user_recmdid='.$user_recmdid;
            $this->assign('get_user_recmdid_account', $this->_getfield('user', 'if(account=nickname,concat(id, ", ", account),concat(id, ", ", account, ", ", nickname))', 'id='.$user_recmdid));
        }
        if(is_numeric($admin_recmdid)){
            $where .= ' and admin_recmdid='.$admin_recmdid;
            $this->assign('get_admin_recmdid_account', $this->_getfield('user', 'if(account=nickname,concat(id, ", ", account),concat(id, ", ", account, ", ", nickname))', 'id='.$admin_recmdid));
        }
        if(is_numeric($tradeid)){
            $where .= ' and id='.$tradeid;
            $this->assign('get_tradeid_tradeno', $this->_getfield('trade', 'concat(id, ", ", tradeno)', 'id='.$tradeid));
        }
        if(is_numeric($status)){
            $where .= ' and status='.$status;
        }
        if(!empty($createtime1)){
            $createtime1 = $createtime1." 00:00:00";
            $where .= " and ctime>='".$createtime1."'";
        }

        if(!empty($createtime2)){
            $createtime2 = $createtime2." 23:59:59";
            $where .= " and ctime<='".$createtime2."'";
        }
        $filename = './temp/trade.csv';
        $fp = fopen($filename, 'w');
        //fwrite($fp,chr(0xEF).chr(0xBB).chr(0xBF));
        fputcsv($fp, array(
            mb_convert_encoding(translate("中文"), 'gbk', 'utf8'),
            mb_convert_encoding(translate("日文"), 'gbk', 'utf8'),
            //mb_convert_encoding('取消时间', 'gbk', 'utf8'),
        ));

        $list = translate($this->_getlist('phone_area_code', '*', $where, 'id desc'));

        foreach ($list as $v) {

            fputcsv($fp,
                array(
                    mb_convert_encoding($v['country']."\t", 'gbk', 'utf8'),
                    //mb_convert_encoding(formattime($v['canceltime'])."\t", 'gbk', 'utf8'),
                )
            );
        }
        /*$filename = './temp/trade.csv';
        $fp = fopen($filename, 'w');
        //fwrite($fp,chr(0xEF).chr(0xBB).chr(0xBF));
        fputcsv($fp, array(
            mb_convert_encoding(translate("序号"), 'gbk', 'utf8'),
            mb_convert_encoding(translate("交易号"), 'gbk', 'utf8'),
            mb_convert_encoding(translate("设备编号"), 'gbk', 'utf8'),
            mb_convert_encoding(translate("代理名称"), 'gbk', 'utf8'),
            mb_convert_encoding(translate("商家名称"), 'gbk', 'utf8'),
            mb_convert_encoding(translate("消费会员"), 'gbk', 'utf8'),
            mb_convert_encoding(translate("套餐名称"), 'gbk', 'utf8'),
            mb_convert_encoding(translate("订单金额"), 'gbk', 'utf8'),

            mb_convert_encoding(translate("优惠金额"), 'gbk', 'utf8'),
            mb_convert_encoding(translate("实付金额"), 'gbk', 'utf8'),
            mb_convert_encoding(translate("交易状态"), 'gbk', 'utf8'),
            mb_convert_encoding(translate("支付方式"), 'gbk', 'utf8'),
            mb_convert_encoding(translate("创建时间"), 'gbk', 'utf8'),
            mb_convert_encoding(translate("支付时间"), 'gbk', 'utf8'),
            //mb_convert_encoding('取消时间', 'gbk', 'utf8'),
        ));

        $list = translate($this->_getlist('trade', '*', $where, 'id desc'));

        foreach ($list as $v) {
            $v['_userid'] = $this->_getfield('user', 'if(account=nickname,concat(id, ", ", account),concat(id, ", ", account, ", ", nickname))', 'id='.$v['user_id']);
            $v['_adminid'] = $this->_getfield('admin', 'concat(id, " ,", nickname)', 'id='.$v['adminid']);
            $v['agent_name'] = $this->_getfield('admin', 'concat(id, " ,", nickname)', 'id='.$v['agent_id']);
            $v['pack_title']=$this->_getfield('pack','title',['id'=>$v['pack_id']]);
            $v=$this->replace_null_time($v);
            //$v['_user_recmdid'] = $v['user_recmdid'] ? $this->_getfield('user', 'if(account=nickname,concat(id, ", ", account),concat(id, ", ", account, ", ", nickname))', 'id='.$v['user_recmdid']) : '';
            //$v['_admin_recmdid'] = $v['admin_recmdid'] ? $this->_getfield('user', 'if(account=nickname,concat(id, ", ", account),concat(id, ", ", account, ", ", nickname))', 'id='.$v['admin_recmdid']) : '';
            if($v['status']==0){
                $pay_type=translate("未支付");
            }else{
                $pay_type=strip_tags($this->trade_paytype[$v['paytype']]);
            }
            fputcsv($fp,
                array(
                    $v['id'],
                    mb_convert_encoding($v['tradeno']."\t", 'gbk', 'utf8'),
                    mb_convert_encoding($v['macno']."\t", 'gbk', 'utf8'),
                    mb_convert_encoding($v['agent_name']."\t", 'gbk', 'utf8'),
                    mb_convert_encoding($v['_adminid']."\t", 'gbk', 'utf8'),
                    mb_convert_encoding($v['_userid']."\t", 'gbk', 'utf8'),
                    mb_convert_encoding($v['pack_title']."\t", 'gbk', 'utf8'),
                    $v['money'],
                    $v['discount'],
                    $v['pay_money'],
                    mb_convert_encoding(strip_tags($this->trade_status[$v['status']])."\t", 'gbk', 'utf8'),
                    mb_convert_encoding($pay_type."\t", 'gbk', 'utf8'),
                    mb_convert_encoding($v['ctime']."\t", 'gbk', 'utf8'),
                    mb_convert_encoding($v['paytime']."\t", 'gbk', 'utf8'),
                    //mb_convert_encoding(formattime($v['canceltime'])."\t", 'gbk', 'utf8'),
                )
            );
        }*/

        fclose($fp);
        $fileinfo = pathinfo($filename);
        header('Content-type: application/x-' . $fileinfo['extension']);
        header('Content-Disposition: attachment; filename=' . $fileinfo['basename']);
        header('Content-Length: ' . filesize($filename));
        readfile($filename);
        exit();
    }

    /**
     * 購入履歴一覧
     */
    public function purchase_history($id=0,$page=0)
    {
        // 顧客ID取得
        if(empty($id)){
            $user_id = $this->input->get('id');
        }else{
            $user_id = $id;
        }
        // ページ情報取得
        if(empty($page)){
            $page = $this->input->get('page');
        }
		$pagesize = $this->input->get('pagesize');
        if(empty($pagesize))$pagesize = 20;
        
        $this->assign('get', $this->input->get());

        $trade = array();

		if($user_id){
            // 購入履歴情報取得条件
            $where = 'user_id='.$user_id;
            // 未払いは非表示とする
            $where .= " and status <> 0 ";

            // 購入履歴情報取得
            $trade = $this->_getpage('trade', $where, 'id desc', $page, $pagesize);
            foreach($trade['list'] as &$v){
                $v['_userid'] = $this->_getfield('user', 'if(account=nickname,concat(id, ", ", account),concat(id, ", ", account, ", ", nickname))', 'id='.$v['user_id']);
                $v['_adminid'] = $this->_getfield('admin', 'concat(id, " ,", nickname)', 'id='.$v['adminid']);
                $v['agent_name'] = $this->_getfield('admin', 'concat(id, " ,", nickname)', 'id='.$v['agent_id']);
                $v['pack'] = $this->_getrow('pack','*',['id'=>$v['pack_id']]);
                $v = $this->replace_null_time($v);
            }
            unset($v);
        }

        $this->assign('returnUri', $_SESSION['purchase_back_uri']);
		$this->assign('trade', $trade);
		$this->assign('trade_status', $this->trade_status);
		$this->assign('trade_paytype', $this->trade_paytype);
		$this->display('trade/list_purchase_history.html');
    }

    /**
     * 購入履歴詳細
     */
    public function purchase_history_detail($id=0,$page=0)
    {
		if($id){
			$row = $this->_getrow('trade', '*', 'id='.$id.$this->_rolesql('',$this->_getrolefield()));
			$row['user_account'] = $this->_getfield('user', 'if(account=nickname,concat(id, ", ", account),concat(id, ", ", account, ", ", nickname))', 'id='.$row['user_id']);
			$row['admin_account'] = $this->_getfield('admin', 'concat(id, ", ", nickname)', 'id='.$row['adminid']);
			$row['corp_account'] = $this->_getfield('admin', 'concat(id, ", ", nickname)', 'id='.$row['agent_id']);
			$row['device_macno'] = $this->_getfield('device', ' concat(id, ", ", macno) as `text`', 'id='.$row['device_id']);
			$divide_record = $this->_getlist('divide_record','*',"order_no='".$row['tradeno']."'");
			$row['pack'] = $this->_getrow('pack','*',['id'=>$row['pack_id']]);
			$row['trade_pack'] = $this->_getlist('trade_pack_item','*',['trade_id'=>$row['id']]);
			foreach($divide_record as $k => &$v){
			    if($v['parameter_id'] == 1){
                    $v['agentname'] = translate("プラットフォーム");;
                    $v['proportion'] = round($v['money'] / $v['order_money'] * 100, 2);
                }else{
                    $v['agentname']=$this->_getfield('admin', 'nickname', ['id'=>$v['parameter_id']]);
                }
            }
            unset($v);
			$row = $this->replace_null_time($row);
			$this->assign('row', $row);
			$this->assign('divide_record', $divide_record);
		}
		$this->assign('trade_status', $this->trade_status);
        $this->assign('trade_paytype', $this->trade_paytype);
		$this->assign('page',$page);
		$this->display('trade/detail_purchase_history.html');
    }

}