<?php
trait User_api_coupon{

    //领取优惠券(扫码领取)
    public function scan_give_coupon(){
        $id=$this->input->post('id');
        if(!$id) $this->_return(-1,'缺少参数 id');
        $coupon=$this->_getrow('coupon',"*",['id'=>$id]);
        if(!$coupon) $this->_return(-1,'优惠券二维码不正确');
        if($coupon['limit']<1) $this->_return(0,'优惠券不能领哦！');
        $user=$this->_get();
        $give_max_num=$this->_getfield('user_give_coupon_log','sum(num)',['coupon_id'=>$coupon['id']])?:0;
        if($coupon['amount']<=$give_max_num) $this->_return(0,'来晚了，优惠券已领完！');
        //判断是否领取过这个优惠券
        $is_give_coupon=$this->_getrow('user_give_coupon_log','*',['coupon_id'=>$coupon['id'],'user_id'=>$user['id']]);
        if($is_give_coupon){
            if($is_give_coupon['num']>=$coupon['limit']) $this->_return(0,'您已经领取过该优惠券了，不要贪心哦！');
            //生成优惠券
            $this->db->insert('user_coupon',[
                'userid'=>$user['id'],
                'couponid'=>$coupon['id'],
                'title'=>$coupon['title'],
                'desc'=>$coupon['desc'],
                'money'=>$coupon['money'],
                'end_time'=>$coupon['end_time'],
                'limit_money'=>$coupon['limit_money'],
                'adminid'=>1,
                'ctime'=>date('Y-m-d H:i:s')
            ]);
            //优惠券领取次数加1
            $this->db->update('user_give_coupon_log',['num'=>$is_give_coupon['num']+1],['id'=>$is_give_coupon['id']]);
        }else{
            //生成优惠券
            $this->db->insert('user_coupon',[
                'userid'=>$user['id'],
                'couponid'=>$coupon['id'],
                'title'=>$coupon['title'],
                'desc'=>$coupon['desc'],
                'money'=>$coupon['money'],
                'end_time'=>$coupon['end_time'],
                'limit_money'=>$coupon['limit_money'],
                'adminid'=>1,
                'ctime'=>date('Y-m-d H:i:s')
            ]);
            $this->db->insert('user_give_coupon_log',['user_id'=>$user['id'],'coupon_id'=>$coupon['id'],'num'=>1,'ctime'=>time()]);
        }
        $this->_return(1,'领取成功');
    }
	
	public function user_coupon(){
		$row = $this->_get();
		$page = $this->input->post('page');
		$pagesize = $this->input->post('pagesize');
		$shop_id=$this->input->post('shop_id');
		if(empty($pagesize))$pagesize = 20;
		
		$where = "userid=".$row['id'];
		// if($shop_id){
		//     $shop=$this->_getrow('admin','id,corpid',['id'=>$shop_id]);
		//     $where.=" and adminid in(".implode(',',[$shop['id'],$shop['corpid'],1]).") and order_id=0 and end_time>'".date('Y-m-d H:i:s')."'";
        // }
        //删除以过期10天的优惠券
        $this->db->delete('user_coupon',"end_time<'".date('Y-m-d H:i:s',strtotime('- 10 day'))."'");
		$list=$this->_getpage('user_coupon',$where,' usetime asc',$page,$pagesize,"id,money,limit_money,end_time,usetime,order_id,adminid,title,desc");
		foreach($list['list'] as $k=>&$v){
		    $v['status']=1;
		    $v['status_name']="未使用";
		    if(strtotime($v['end_time'])<time()){
		        $v['status']=3;
		        $v['status_name']="已过期";
            }elseif($v['order_id']!=0){
		        $v['status']=2;
		        $v['status_name']="已使用";
            }
            $v['shop_name']="全店舗使用可能";
            if($v['adminid']>1)$v['shop_name']=$this->_getfield('admin','nickname',['id'=>$v['adminid']]);
        }
        unset($v);
		$this->_return(1, '获取成功', $list);
	}
}