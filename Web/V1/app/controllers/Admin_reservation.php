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
class Admin_reservation extends Admin_Controller {
	/**
	 * 构造函数
	 *
	 * @access  public
	 * @return  void
	 */

	private $pay_type=[0=>'优惠券',1=>"余额",2=>'微信'];
	private $status=[1=>'<b style="color:orange;">已支付未使用</b>',2=>'<b style="color:green;">已使用</b>',3=>'<b style="color:red;">已取消</b>'];
	public function __construct()
	{
		parent :: __construct();
		$this->load->model('setting_mdl');
	}

	public function index() 
	{
		// echo 'error';
		$page = $this->input->get('page');
		$pagesize = $this->input->get('pagesize');
		if(empty($pagesize))$pagesize = 20;
		
		// $macno = trim($this->input->get('macno'));
		$status = $this->input->get('status');
		$shop_name = $this->input->get('shop_name');
		$pack_title = $this->input->get('pack_title');
		$start_time = $this->input->get('start_time');
		$end_time = trim($this->input->get('end_time'));
		
		//处理搜索SQL
		$where = '';
		$shop_where='1=1';
		if($_SESSION['gid']  != 1){
			$shop_where .= ' and id = '.$_SESSION['aid'];
		}
		$this->assign('aid', $_SESSION['aid']);
		if(!empty($shop_name)){
			$shop_where .= ' and nickname like "%'.$shop_name.'%"';
		}
		$pack_where='1=1';
		if(!empty($pack_title)){
			$pack_where .= ' and title like "%'.$pack_title.'%"';
		}
		if(empty($start_time)){
			$start_time = date('Y-m-d', time())." 00:00";
		} else {
		}
		if(empty($end_time)){
			$end_time = date("Y-m-d", (strtotime($start_time) + 86400))." 00:00";
		} else {
		}
		$where .= ' and start_time<"'.$end_time.'"';
		$where .= ' and start_time>"'.$start_time.'"';
		$gets = $this->input->get();
		$gets['start_time'] = $start_time;
		$this->assign('get', $gets);

		$shops = $this->_getpage('admin', $shop_where, 'id', 1, 100);
		$results = [];
		foreach($shops['list'] as $key=>$shop) {
			$shop_reservations = [];
			$list = $this->_getlist(['reservation as a',['trade as b',"a.trade_id=b.id"]],'a.*, b.pack_id, b.paytype, b.subscription_flg, b.subscription_type, b.pay_token', 'b.adminid='.$shop['id'].$where, 'b.adminid asc, a.types desc', $page, $pagesize,'a.*, b.*');
			
			foreach($list as $reservation_key=>&$reservation_val) {
				$user = $this->_getcol('user', 'nickname', 'id='.$reservation_val['user_id']);
				$reservation_val['user_name'] = $user;
				$trade_pack_item= $this->_getrow('trade_pack_item', '*', 'id='.$reservation_val['pack_item_id']);
				$reservation_val['trade_pack_item'] = $trade_pack_item['pack_item_id'];
				$pack_item = $this->_getrow('pack_item', '*', 'id='.$trade_pack_item['pack_item_id']);
				$trade = $this->_getrow('trade', '*', 'id='.$reservation_val['trade_id']);
				$pack = $this->_getrow('pack', '*', $pack_where.' and id='.$trade['pack_id']);
				if (!$pack) {
					unset($list[$key]);
					continue;
				}
				$reservation_val['is_subscription'] = $pack['subscription_flg'];

				// TODO マスタでの紐付けを持つようにすべき

				$devices = ['わたしのハイフボディ', 'わたしのハイフ', 'さよならセルライト'];
				$order = [5, 1, 4];
				$mr_type = $order[$pack_item['mr_type']-1];
				$reserve_type = explode(',', $reservation_val['types']);
				$reservation_val['pack_item_name'] = $trade_pack_item['item_name'];
				$reservation_val['device_type'] = $mr_type;
				if ($pack['treatment_time']) {
					$treatment_time = $pack['treatment_time'];
				} else {
					$treatment_time = $pack['interval_time'];
				}
				$reservation_val['interval_time'] = $treatment_time;
				$reservation_val['device_type_id'] = $this->_getcol('device_son_type', '*', 'id='.$mr_type)[0];
				if ($reservation_val['paytype'] == 4) {
					$reservation_val['paytype'] = '支払い完了　クレジット支払い';
				} else if ($reservation_val['paytype'] == 5) {
					$reservation_val['paytype'] = '支払い完了　Line支払い';
				} else if ($reservation_val['paytype'] == 1) {
					$reservation_val['paytype'] = '支払い完了　残高払い';
				} else if ($reservation_val['paytype'] == 6) {
					if ($reservation_val['pay_token'] != '') {
						$reservation_val['paytype'] = '支払い待ち　現金払い 予約番号<span class="pay_token_modal">'.$reservation_val['pay_token'].'</span>';
						$reservation_val['cash_id'] = $reservation_val['id'];
					} else {
						$reservation_val['paytype'] = '支払い完了　現金払い';
					}
				}
				// $reservation_val['paytype'].=$reservation_val['paytype'];
				$reservation_val['shop_name'] = $this->_getcol('admin', 'nickname', 'id='.$shop['id']);
				if ($reservation_val)
				array_push($shop_reservations, $reservation_val);
			}
			if (sizeof($shop_reservations) != 0)
			array_push($results, $shop_reservations);
			// var_dump(sizeof($shop_reservations));
			// var_dump(sizeof($results));

		}
		$row = 0;
		$rows = [];
		
		foreach ($results as &$reservations) {
			$order_reservations = [];
			foreach($reservations as $key => &$reservation) {
				$floor = 0;
				$start_date = new DateTime($reservation['start_time']);
				$end_date = clone $start_date;
				$end_date->modify('+'.($reservation['interval_time'] != 0? $reservation['interval_time']: 30).' minutes');
				$residence = false;
				foreach($order_reservations as $floor_num => &$floor_reservations) {
					$is_living = false;
					foreach($floor_reservations as $index => $room) {
						$prev_reserv_start_date = new DateTime($room['start_time']);
						$prev_reserv_end_date = clone $prev_reserv_start_date;
						$prev_reserv_end_date->modify('+'.($room['interval_time'] != 0? $room['interval_time']: 30).' minute');
						if (($start_date >= $prev_reserv_start_date && $start_date < $prev_reserv_end_date ) || ($end_date > $prev_reserv_start_date && $end_date <= $prev_reserv_end_date )) {
							$is_living = true;
							$floor++;
							break;
						} else {
							if ($start_date < $prev_reserv_start_date) {
								
							}
						}
					}
					if (!$is_living) {
						$reservation['row'] = $row+$floor;
						array_push($floor_reservations, $reservation);
						$residence = true;
						break;
					}
					if (!$is_living) {
						$reservation['row'] = $row+$floor;
						array_push($floor_reservations, $reservation);
						$residence = true;
						break;
					}
				}
				if (!$residence) {
					$reservation['row'] = $row+$floor;
					array_push($rows, $reservation);
					array_push($order_reservations, array($reservation));
				}
				if (!$residence) {
					$reservation['row'] = $row+$floor;
					array_push($rows, $reservation);
					array_push($order_reservations, array($reservation));
				}
			}
			$row++;
		}
		$this->assign('list', $results);
		$this->assign('rows', $rows);
		$this->assign('max_row', $row);
		$this->display('reservation/list_reservation.html');
	}

	public function search() 
	{		
		// $macno = trim($this->input->get('macno'));
		$status = $this->input->post('status');
		$shop_name = $this->input->post('shop_name');
		$pack_title = $this->input->post('pack_title');
		$start_time = $this->input->post('start_time');
		$end_time = $this->input->post('end_time');
		
		//处理搜索SQL
		$where = '';
		$shop_where='1=1';
		if($_SESSION['gid']  != 1){
			$shop_where .= ' and id = '.$_SESSION['aid'];
		}
		$this->assign('aid', $_SESSION['aid']);
		if(!empty($shop_name)){
			$shop_where .= ' and nickname like "%'.$shop_name.'%"';
		}
		$pack_where='1=1';
		if(!empty($pack_title)){
			$pack_where .= ' and title like "%'.$pack_title.'%"';
		}
		if(empty($start_time)){
			$start_time = date('Y-m-d', time())." 00:00";
		} else {
		}
		if(empty($end_time)){
			$end_time = date("Y-m-d", (strtotime($start_time) + 604800))." 00:00";
		} else {
		}
		$where .= ' and start_time<"'.$end_time.'"';
		$where .= ' and start_time>"'.$start_time.'"';
		$posts = $this->input->post();
		$posts['start_time'] = $start_time;
		$this->assign('get', $posts);

		$shops = $this->_getpage('admin', $shop_where, 'id', 1, 1000);
		$results = [];
		foreach($shops['list'] as $key=>$shop) {
			$shop_reservations = [];
			$list = $this->_getlist(['reservation as a',['trade as b',"a.trade_id=b.id"]],'a.*, b.pack_id, b.paytype, b.subscription_flg, b.subscription_type, b.pay_token', 'b.adminid='.$shop['id'].$where, 'b.adminid asc, a.types desc', $page, $pagesize,'a.*, b.*');
			
			foreach($list as $reservation_key=>&$reservation_val) {
				$user = $this->_getcol('user', 'nickname', 'id='.$reservation_val['user_id']);
				$reservation_val['user_name'] = $user;
				$trade_pack_item= $this->_getrow('trade_pack_item', '*', 'id='.$reservation_val['pack_item_id']);
				$reservation_val['trade_pack_item'] = $trade_pack_item['pack_item_id'];
				$pack_item = $this->_getrow('pack_item', '*', 'id='.$trade_pack_item['pack_item_id']);
				$trade = $this->_getrow('trade', '*', 'id='.$reservation_val['trade_id']);
				$pack = $this->_getrow('pack', '*', $pack_where.' and id='.$trade['pack_id']);
				if (!$pack) {
					unset($list[$key]);
					continue;
				}
				$reservation_val['is_subscription'] = $pack['subscription_flg'];
				$devices = ['ハイフボディ', 'ハイフフェイシャル', 'さよならセルライト', 'EMS＆キャビテーション'];
				$mr_type = $pack_item['mr_type'];
				$reserve_type = explode(',', $reservation_val['types']);
				$reservation_val['pack_item_name'] = $trade_pack_item['item_name'];
				$reservation_val['device_type'] = $devices[$mr_type];
				$reservation_val['device_type_id'] = $mr_type;
				if ($reservation_val['paytype'] == 4) {
					$reservation_val['paytype'] = '支払い完了　クレジット支払い';
				} else if ($reservation_val['paytype'] == 5) {
					$reservation_val['paytype'] = '支払い完了　Line支払い';
				} else if ($reservation_val['paytype'] == 1) {
					$reservation_val['paytype'] = '支払い完了　残高払い';
				} else if ($reservation_val['paytype'] == 6) {
					if ($reservation_val['pay_token'] != '') {
						$reservation_val['paytype'] = '支払い待ち　現金払い 予約番号<span class="pay_token_modal">'.$reservation_val['pay_token'].'</span>';
						$reservation_val['cash_id'] = $reservation_val['id'];
					} else {
						$reservation_val['paytype'] = '支払い完了　現金払い';
					}
				}
				// $reservation_val['paytype'].=$reservation_val['paytype'];
				$reservation_val['shop_name'] = $this->_getcol('admin', 'nickname', 'id='.$shop['id']);
				if ($reservation_val)
				array_push($shop_reservations, $reservation_val);
			}
			if (sizeof($shop_reservations) != 0)
			array_push($results, $shop_reservations);
			// var_dump(sizeof($shop_reservations));
			// var_dump(sizeof($results));

		}
		$row = 0;
		$rows = [];
		
		foreach ($results as &$reservations) {
			$order_reservations = [];
			foreach($reservations as $key => &$reservation) {
				$floor = 0;
				$start_date = new DateTime($reservation['start_time']);
				$end_date = clone $start_date;
				$end_date->modify('+2 hours');
				$residence = false;
				foreach($order_reservations as $floor_num => &$floor_reservations) {
					$is_living = false;
					foreach($floor_reservations as $room) {
						$prev_reserv_start_date = new DateTime($room['start_time']);
						$prev_reserv_end_date = clone $prev_reserv_start_date;
						$prev_reserv_end_date->modify('+120 minute');
						if (($start_date >= $prev_reserv_start_date && $start_date < $prev_reserv_end_date ) || ($end_date > $prev_reserv_start_date && $end_date <= $prev_reserv_end_date )) {
							$is_living = true;
							$floor++;
							break;
						}
					}
					if (!$is_living) {
						$reservation['row'] = $row+$floor;
						array_push($floor_reservations, $reservation);
						$residence = true;
						break;
					}
				}
				if (!$residence) {
					$reservation['row'] = $row+$floor;
					array_push($rows, $reservation);
					array_push($order_reservations, array($reservation));
				}
			}
			$row++;
		}
		$this->assign('list', $order_reservations);
		// $this->assign('rows', $rows);
		// $this->assign('max_row', $row);
		$this->display('reservation/search_reservation.html');
	}

	public function change()
	{
		$posts = $this->input->post();
		$this->load->model('reservation_mdl');
		$this->db->update('reservation',['remark'=> $posts['remark'], 'start_time'=>$posts['start_time']], 'id='.$posts['reservation_id']);

		die('{"status":1}');
	}

	public function edit($id=0){
		$post = $this->input->post();
        if ( !empty($post['macno']) ){
			$count = $this->_getcount('device', ($id ? "id<>$id and " : "") . "macno='".$post['macno']."'");
			if($count) $this->admin_return(0,'设备号重复');
			if($post['share_start_time'] && $post['share_end_time']){
			    if($post['share_start_time']>$post['share_end_time']) $this->admin_return(0,'共享开始时间不能大于共享结束时间');
            }
            if($post['discount_start_time'] && $post['discount_end_time']){
							if($post['discount_start_time'] >$post['discount_end_time']) $this->admin_return(0,'优惠开始时间不能大于优惠结束时间');
            }
            if($post['adminid']){
							$parent=$this->_getrow('admin','corpid',['id'=>$post['adminid']]);
							$post['agent_id']=$parent['corpid'];
            }
            if($post['adminid'] || $post['agent_id']) $post['user_id']=0;
            if($post['type']==2) {
							$post['prepay']=0;
							$post['audit_status']=1;
            }
			if($id){
				$device=$this->_getrow('device','*',['id'=>$id]);
				if($device['type']!=$post['type'] && $device['type']==2){
						$post['audit_status']=0;
					}
				$this->db->update('device', $post, 'id='.$id.$this->_rolesql('',$this->_getrolefield([2=>"admin_id",4=>"admin_id"])));
			}else{
				$post['createtime']=date('Y-m-d H:i:s');
				$this->db->insert('device', $post);
			}
			$this->admin_return(1);
		}		
		if($id){
			$row = $this->_getrow('device', '*', 'id='.$id.$this->_rolesql('',$this->_getrolefield([2=>"admin_id",4=>"admin_id"])));
			$row['adminid_account'] = $this->_getfield('admin', 'concat(id, " ,", nickname)', 'id='.$row['adminid']);
			$row['agent_name'] = $this->_getfield('admin', 'concat(id, " ,", nickname)', 'id='.$row['agent_id']);
			$row= $this->replace_null_time($row);
			$this->assign('row', $row);
		}
        $shop_where = "  gid in (".implode(",", $this->_role[2]).")".$this->_rolesql('a', 'id');
		$shop=$this->_getlist('admin as a', 'a.id, concat(a.id, ", ", a.nickname) as nickname', $shop_where, 'a.id desc');
		$this->assign('shop',$shop);
        $this->assign('geocoder_key', $this->config->item('geocoder_key'));
		$this->assign('device_status', $this->device_status);
        $this->assign('device_type', $this->device_type);
		$this->display('device/edit_device.html');
	}

	/**
	 * 予約キャンセル
	 */
	public function cancel()
	{
		// POST
		$id = $this->input->post('id');

	    if($id){
			// 予約情報存在チェック
			$reservation = $this->_getrow('reservation', '*', 'id='.$id.' and status = 0');
			if(!$reservation){
				$this->admin_return(0,'対象予約データはキャンセルできません');
			}
			// 購入情報チェック
			$trade = $this->_getrow('trade', '*', 'id='.$reservation['trade_id'].' and paytype=6 and pay_token IS NULL');
			if($trade){
				$this->admin_return(0,'現金支払いが完了しているため、キャンセルできません');
			}
			// 予約キャンセル更新
            $this->db->update('reservation', ['status'=>2], ['id'=>$reservation['id']]);
			$this->db->update('trade', ['status'=>1], ['id'=>$reservation['trade_id']]);
			$this->db->set('use_num',"use_num-1",false)->where('id in('.$reservation['pack_item_id'].")")->update('trade_pack_item');
            $this->admin_return(1);
        }else{
			$this->admin_return(0, 'パラメータエラー');
		}
    }

	public function delete(){
		$ids = $this->input->post('ids');
		if(!empty($ids)){
			$this->db->where_in('id', explode(',', $ids));
			$this->db->delete('reservation');
		}
		$this->admin_return(1);
	}

	/**
	 * 予約管理一覧
	 */
	public function list_reservation()
	{
		$page = $this->input->get('page');
		$pagesize = $this->input->get('pagesize');
		if(empty($pagesize))$pagesize = 20;

		// get parameter
		$adminid = $this->input->get('adminid');
		$start_time = $this->input->get('start_time');
		$end_time = trim($this->input->get('end_time'));

		// 予約検索条件作成
		$where = 'a.status <> 2 and a.pack_item_id = b.id and a.trade_id = b.trade_id';
		// アカウント種別が加盟店の時
        if($_SESSION['gid'] == 4){
			$where .= ' and a.shop_id = '.$_SESSION['aid'];
		}else{
			if(!empty($adminid)){
				$where .= ' and a.shop_id = '.$adminid;
			}
		}
		$this->assign('aid', $_SESSION['aid']);
		$pack_where='1=1';
		if(empty($start_time)){
			// 現在時刻
			$startDate = new DateTime();
			$start_time = $startDate->format('Y-m-d H:i');
		}
		if(empty($end_time)){
			// 現在日付の翌日の00:00
			$endDate = new DateTime();
			$endDate->setTime(23, 59, 59);
			$end_time = $endDate->format('Y-m-d H:i');
		}
		$where .= ' and a.start_time>="'.$start_time.'"';
		$where .= ' and a.start_time<="'.$end_time.'"';

		// デフォルト日付の登録
		$gets = $this->input->get();
		$gets['start_time'] = $start_time;
		$gets['end_time'] = $end_time;
		$this->assign('get', $gets);

		// 予約リスト取得
		$reservationList = $this->_getpage(['reservation as a', ['trade_pack_item as b', 'a.pack_item_id = b.id and a.trade_id = b.trade_id']],
							$where, 'a.start_time asc, a.id asc', $page, $pagesize,
							'a.*, b.pack_item_id as packItemId');

		foreach($reservationList['list'] as &$v){
			// パッケージ商品情報取得
			$packItem = $this->_getrow('pack_item', '*', 'id='.$v['packItemId']);
			$v['interval_time'] = $packItem['interval_time'];
			$v['treatment_time'] = $packItem['treatment_time'];
			$v['title'] = $packItem['title'];

			// 購入情報取得
			$trade = $this->_getrow('trade', '*', 'id='.$v['trade_id']);
			$v['paytype'] = $trade['paytype'];
			$v['pay_token'] = $trade['pay_token'];

			// ユーザ情報取得
			$user = $this->_getrow('user', '*', 'id='.$v['user_id']);
			$v['user_name'] = $user['nickname'];
			$v['phone_no'] = $user['account'];

			// 店舗情報取得
			$shop = $this->_getrow('admin', '*', 'id='.$v['shop_id']);
			$v['shop_name'] = $shop['nickname'];

			// 予約時間計算
			$treatmentTime = $v['interval_time'];
			if(!empty($v['treatment_time'])){
				$treatment_time = $v['treatment_time'];
			}
			// 開始時間と終了時間の算出
			$startTime = new DateTime($v['start_time']);
			$endTime = clone $startTime;
			$endTime->modify('+'.$treatmentTime.' minute');
			$v['reserve_time'] = $startTime->format('Y-m-d H:i').' - '.$endTime->format('H:i');
		}

        // アカウント種別が加盟店の時
        if($_SESSION['gid'] == 4){
            $this->assign('member_store_id', $_SESSION['aid']);
            $this->assign('get_adminid_account', $this->_getfield('admin', 'concat(id, ", ", nickname)', 'id=' . $_SESSION['aid']));
        }
		$this->assign('gid', $_SESSION['gid']);
		
		// 未読のお知らせ件数取得
		$unread_count = $this->unread_notice_count();
		$this->assign('unread_count', $unread_count);

		// セッションに購入履歴から戻るためのURI保存
		$_SESSION['purchase_back_uri'] = $_SERVER['REQUEST_URI'];

        $this->assign('reservationList', $reservationList);
		$this->assign('page', $page);
		$this->display('reservation/list_reservation_info.html');
	}

    /**
     * 予約一覧用店舗名検索
     */
    public function shop_reservation_search()
    {
        $keywords = $this->input->post('keywords');
        if (!empty($keywords)) {
            $where = "(a.id='" . $keywords . "' or concat(a.nickname,a.phone,a.mobile,a.adminname,a.address,a.name) like '%" . $keywords . "%') and gid in (" . implode(",", $this->_role[2]) . ")" . $this->_rolesql('a', 'id');
            $result = $this->_getlist('admin as a', 'a.id, concat(a.id, ", ", a.nickname) as `text`', $where, 'a.id desc');
            die('{"status":-1, "data":' . json_encode($result) . '}');
        }
        die('{"status":-1, "data":[]}');
    }
	
    /**
     * お知らせ未読判定
     */
    public function unread_notice_count()
    {
		$adminid = $_SESSION['aid'];
		$count = '';

		// アカウント種別が加盟店の時
        if($_SESSION['gid'] == 4){
			// 既読情報取得
			$readInfo = $this->_getrow('notice_read', '*', 'admin_id='.$adminid);
			// お知らせの最新情報
			$newNoticeInfo = $this->_getlist('notice_info', '*', "regist_date >= '".$readInfo['read_date']."'");

			if($newNoticeInfo){
				// 既読日時以降に登録されたお知らせが存在する場合
				$count = count($newNoticeInfo);
			}
		}

        return $count;
    }

}