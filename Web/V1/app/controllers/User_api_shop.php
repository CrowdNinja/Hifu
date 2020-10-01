<?php
trait User_api_shop{

    //支付方式
    private  $pay_type=[2=>"微信",3=>"支付宝"];
	//合作申请
    public function collaborate_apply(){
	    $user=$this->_get();
	    $name=$this->input->post('name');
	    $phone=$this->input->post('phone');
	    $company_name=$this->input->post('company_name');
	    $mail=$this->input->post('mail');
	    $city=$this->input->post('city');
	    if(empty($name)) $this->_return(-1,'请输入姓名');
	    if(empty($phone)) $this->_return(-1,'请输入联系方式');
	    if(empty($city)) $this->_return(-1,'请输入城市');
	    if(empty($company_name)) $this->_return(-1,'请输入公司名称');
        if( !is_numeric($phone) || strlen($phone) != 11 ) $this->_return(0,'手机号不正确');
        $is_submit=$this->_getrow('collaborate','*',['user_id'=>$user['id']],'id desc');
        if((strtotime($is_submit['ctime'])+60)>time()) $this->_return(0,'已提交申请，请勿重复提交！');
        //生成记录
        $res=$this->db->insert('collaborate',[
            'name'=>$name,
            'phone'=>$phone,
            'city'=>$city,
            'company_name'=>$company_name,
            'mail'=>$mail?:"",
            'user_id'=>$user['id'],
            'ctime'=>date('Y-m-d H:i:s')
        ]);
        if($res) $this->_return(1,'提交成功');
        $this->_return(0,'提交失败');
    }
	


	//商家登入
    public function shop_login(){
	    $username=$this->input->post('username');
	    $password=$this->input->post('password');
	    if(!$username) $this->_return(-1,'请输入账号');
	    if(!$password) $this->_return(-1,'请输入密码');
 	    $admin=$this->_getrow('admin','*',['adminname'=>$username]);
	    if(!$admin) $this->_return(0,'账号错误');
	    if($admin['password']!=md5($password)) $this->_return(0,'密码错误');
	    if(!in_array($admin['gid'],$this->_role[1]) &&!in_array($admin['gid'],$this->_role[2])) $this->_return(-5,'账号没有权限');
        if($admin['status']!=1) $this->_return(0,'账号已禁用,请联系管理员');
	    $token=md5(md5(time().$admin['id'].$username));
	    $this->db->update('admin',['shop_token'=>$token],['id'=>$admin['id']]);
	    $this->_return(1,'登入成功',['shop_token'=>$token,'type'=>$this->_getfield('sys_role','type',['id'=>$admin['gid']])]);
    }

    //判断是否登入
    private function check_shop_token($check=''){
	    $token=$this->input->post('shop_token');
	    if(!$token) $this->_return(-101,'请先登入');
	    $admin=$this->_getrow('admin','*',['shop_token'=>$token]);
	    if(!$admin) $this->_return(-101,'请先登入');
        //if(!in_array($admin['gid'],$this->_role[1]) &&!in_array($admin['gid'],$this->_role[2])) $this->_return(-5,'账号没有权限');
        if(is_numeric($check)){
            if(!in_array($admin['gid'],$this->_role[$check])) $this->_return(-5,'账号没有权限');
        }
        $admin['role_type']=$this->_getfield('sys_role','type',['id'=>$admin['gid']]);
	    return $admin;
    }

    //首页
    public function shop_home(){
	    $admin=$this->check_shop_token();
	    $type=$this->input->post('type')?:1;
        //type==1 今日，type==2 昨日，type==3 本月,type==4 本周
	    if(!in_array($type,[1,2,3,4])) $this->_return(-1,'参数错误 type');
        //今日起始
        $beginToday =  get_time_block('sToday');
        $endToday = get_time_block('eToday');

        //昨日起始
        $beginYesterday = get_time_block('sYesterday');
        $endYesterday = get_time_block('eYesterday');

        //本月起始
        $beginThismonth = get_time_block('sMonth');
        $endThismonth = get_time_block('eMonth');
        //本周起始
        $sweek=get_time_block('sWeek');
        $eweek=get_time_block('eWeek');


        $divide_record_where=" status = 0 and parameter_id=".$admin['id'];
        $order_where=" status>0 ";
        if($admin['role_type']==1){
            $order_where.=" and agent_id=".$admin['id'];
        }elseif($admin['role_type']==2){
            $order_where.=" and adminid=".$admin['id'];
        }

        if($type==1){//今日
            $order_where.=" and ctime between'". date("Y-m-d H:i:s",$beginToday)."' and '".date('Y-m-d H:i:s',$endToday)."'";
            $divide_record_where.=" and ctime between'". date("Y-m-d H:i:s",$beginToday)."' and '".date('Y-m-d H:i:s',$endToday)."'";
        }elseif($type==4){//本周
            $order_where.=" and ctime between'". date("Y-m-d H:i:s",$sweek)."' and '".date('Y-m-d H:i:s',$eweek)."'";
            $divide_record_where.=" and ctime between'". date("Y-m-d H:i:s",$sweek)."' and '".date('Y-m-d H:i:s',$eweek)."'";
        }elseif($type==3){//本月
            $order_where.=" and ctime between'". date("Y-m-d H:i:s",$beginThismonth)."' and '".date('Y-m-d H:i:s',$endThismonth)."'";
            $divide_record_where.=" and ctime between'". date("Y-m-d H:i:s",$beginThismonth)."' and '".date('Y-m-d H:i:s',$endThismonth)."'";
        }else{
            $order_where.=" and ctime between'". date("Y-m-d H:i:s",$beginYesterday)."' and '".date('Y-m-d H:i:s',$endYesterday)."'";
            $divide_record_where.=" and ctime between'". date("Y-m-d H:i:s",$beginYesterday)."' and '".date('Y-m-d H:i:s',$endYesterday)."'";
        }

        //总收益
        $total_money=$this->_getfield('trade',"sum(pay_money)",$order_where);
        //余额
        $balance_money=$this->_getfield('trade','sum(pay_money)',$order_where." and paytype=1");
        //微信 金额
        $wx_money=$this->_getfield('trade','sum(pay_money)',$order_where." and paytype=2");
        //支付宝
        $ali_money=$this->_getfield('trade','sum(pay_money)',$order_where." and paytype=3");
        //line
        $line_money=$this->_getfield('trade','sum(pay_money)',$order_where." and paytype=4");
        $count=$this->_getfield('trade','count(1)',$order_where);
        $data=[
            'total_money'=>$total_money?:"0.00",
            'balance_money'=>$balance_money?:"0.00",
            'wx_money'=>$wx_money?:"0.00",
            'ali_money'=>$ali_money?:"0.00",
            'line_money'=>$line_money?:"0.00",
            'count'=>$count,
        ];
        $this->_return(1,'获取成功',$data);
    }

    //设备列表
    public function  device_list(){
        $admin=$this->check_shop_token();
        $page=$this->input->post('page')?:1;
        $pagesize=$this->input->post('pagesize')?:10;
        $keyword=trim($this->input->post('keyword'));
        $type=$this->input->post('type');
        if(!in_array($type,[1,2])) $this->_return(-1,'type 参数错误');
        $where=" gid in(".implode(',',$this->_role[2]).")";
        if($admin['role_type']==1){//代理商
            $where.=" and corpid=".$admin['id'];
        }elseif($admin['role_type']==2){//商家
          $where.=" and id=".$admin['id'];
        }

        if($keyword) $where.=" and (nickname like '%".$keyword."%' or address like '%".$keyword."%')";
        $list=$this->_getpage('admin',$where,'id desc',$page,$pagesize,'id ,nickname,address');
        foreach($list['list'] as $k=>&$v){
            $v['device_count']=$this->_getfield('device','count(1)',['adminid'=>$v['id'],'type'=>$type]);
        }
        unset($v);
        $this->_return(1,'获取成功',$list);
    }
    //设备详情
    public function device_list_details(){
        $admin=$this->check_shop_token();
        $shop_id=$this->input->post('shop_id');
        $type=$this->input->post('type');
        if(!$shop_id) $this->_return(-1,'缺少参数 shop_id');
        if(!in_array($type,[1,2])) $this->_return(-1,' type 参数错误');
        $page=$this->input->post('page')?:1;
        $pagesize=$this->input->post('pagesize')?:10;
        $keyword=trim($this->input->post('keyword'));
        $where=" adminid=$shop_id  and type=$type";
        if($keyword){
            $where.=" and ( macno like '%".$keyword."%' or address like'%".$keyword."%')";
        }
        $list=$this->_getpage('device',$where,'id desc',$page,$pagesize,'macno,address,beat_time');
        foreach($list['list'] as $k=>&$v){
            $v['status_name']="在线";
            $v['status']=1;
            if(strtotime($v['beat_time'])<time()){
                $v['status_name']="离线";
                $v['status']=2;
            }
        }
        $this->_return(1,'获取成功',$list);
    }


    //订单列表
    public function order_list(){
        $admin=$this->check_shop_token();
        $page=$this->input->post('page')?:1;
        $pagesize=$this->input->post('pagesize')?:10;
        $status=$this->input->post('status');
        $shop_id=$this->input->post('shop_id');
        $type=$this->input->post('type');
        if(!in_array($type,[1,2])) $this->_return(-1,'type 参数错误');
        if(!in_array($status,[-1,1,2]))$this->_return(-1,'status 参数错误');

        if($admin['role_type']==1){//代理商
            $where=" agent_id =".$admin['id'];
        }elseif($admin['role_type']==2){//商家
            $where=" adminid=".$admin['id'];
        }
        if($status>0){
            $where.=" and status=$status";
        }else{
            $where.=" and status<0";
        }
        if($shop_id){
            $where.=" and adminid=$shop_id";
        }
        if($type==1){
            $pack_ids=$this->_getcol('pack_item','pack_id',"type=$type")?:[0];
        }else{
            $pack_ids=$this->_getcol('pack_item','pack_id',"type=2")?:[0];
        }
        $where.=" and pack_id in(".implode(',',$pack_ids).")";

        $list=$this->_getpage('trade',$where,'id desc',$page,$pagesize,"id ,adminid,pack_info,ctime,pay_money,user_id,status,reservation_id");
        foreach($list['list'] as $k=>&$v){
            $shop=$this->_getrow('admin','nickname,address,thumb',['id'=>$v['adminid']]);
            $v['shop_name']=$shop['nickname']?:"";
            $v['shop_address']=$shop['address']?:"";
            $v['shop_thumb']=$shop['thumb']?base_url($shop['thumb']):"";
            $pack=json_decode($v['pack_info'],1);
            $v['pack_img']=$pack['img']?base_url($pack['img']):"";
            $v['status_name']="待消费";
            $v['reservation_time']='';
            if($v['status']==2){
                $v['reservation_time']=$this->_getfield('reservation','start_time',['id'=>$v['reservation_id']]);
                $v['status_name']="待使用";
            }elseif($v['status']==-1){
                $v['status_name']="待退款";
            }elseif($v['status']==-2){
                $v['status_name']="已退款";
            }
            $v['nickname']=$this->_getfield('user','nickname',['id'=>$v['user_id']]);
            unset($v['pack_info']);
        }
        unset($v);
        $this->_return(1,'获取成功',$list);
    }

    //订单详情
    public function order_details(){
        $admin=$this->check_shop_token();
        $trade_id=$this->input->post('trade_id');
        if(!$trade_id) $this->_return(-1,'缺少参数 trade_id');
        $trade=$this->_getrow('trade','id,tradeno,user_id,ctime,pack_info,pack_id,reservation_id,pay_money,refund_cause,refund_memo,status',['id'=>$trade_id]);
        if(!$trade) $this->_return(0,'trade_id 参数错误');
        $user=$this->_getrow('user','nickname,account',['id'=>$trade['user_id']]);
        $trade['nickname']=$user['nickname']?:"";
        $trade['phone']=$user['account']?:"";
        $pack=json_decode($trade['pack_info'],true);
        $trade['pack_title']=$pack['title'];
        $trade['item_list']=$this->_getlist('pack_item','title,num,knife,text',['pack_id'=>$trade['pack_id']]);
        $trade['reservation_time']='';
        $trade['reservation_item']=[];
        if($trade['status']==2){
            $reservation=$this->_getrow('reservation','*',['id'=>$trade['reservation_id']]);
            $trade['reservation_time']=$reservation['start_time'];
            $pack_item_ids=$this->_getcol('trade_pack_item','pack_item_id',"id in(".$reservation['pack_item_id'].")")?:[0];
            $trade['reservation_item']=$this->_getlist('pack_item','title,knife',"id in(".implode(',',$pack_item_ids).')');
        }
        $this->_return(1,'获取成功',$trade);
    }
    //预约总览
    public function reservation_pandect(){
        $admin=$this->check_shop_token();
        $time=$this->input->post('time');
        if(!$time) $this->_return(-1,'请选择需要查询的时间');
        $start_time=$time."-01 00:00:00";
        $end_time=$time."-".date('t')." 23:59:59";

        if($admin['role_type']==1){//代理商
            $where=" agent_id =".$admin['id'];
        }elseif($admin['role_type']==2){//商家
            $where=" adminid=".$admin['id'];
        }
        $trade_ids=$this->_getcol('trade','id',$where." and status>0")?:[0];
        $where="trade_id in(".implode(',',$trade_ids).") and status<2 and start_time BETWEEN'".$start_time."' and '".$end_time."'";
        $list=$this->_getlist('reservation',['count(id) as count,start_time',"start_time"],$where);
        $this->_return(1,'获取成功',$list);
    }
    //退款
    public function refund(){
        $admin=$this->check_shop_token();
        $trade_id=$this->input->post('trade_id');
        if(!$trade_id) $this->_return(-1,'缺少参数 trade_id');
        $trade=$this->_getrow('trade','*',['id'=>$trade_id]);
        if(!$trade) $this->_return(0,'trade_id 参数错误');
        if($trade['status']!=-1) $this->_return(0,'订单状态错误');
        if($admin['role_type']==1){//代理商
            if($trade['agent_id']!=$admin['id']) $this->_return(-5,'没有权限操作');
        }elseif($admin['role_type']==2){//商家
            if($trade['adminid']!=$admin['id']) $this->_return(-5,'没有权限操作');
        }
        //退款到余额（客户需求）
        if($trade['pay_money']>0) $this->db->set('money','money+'.$trade['pay_money'],false)->where('id',$trade['user_id'])->update('user');
        //修改订单状态
        $this->db->update('trade',['status'=>-2,'refund_time'=>date('Y-m-d H:i:s')],['id'=>$trade['id']]);
        $this->_return(1,'操作成功');
    }


    //营收统计
    public function income(){
        $admin=$this->check_shop_token();
        $page=$this->input->post('page')?:1;
        $pagesize=$this->input->post('pagesize')?:10;
        $keyword=trim($this->input->post('keyword'));

        $start_time=trim($this->input->post('start_time'));
        $end_time=trim($this->input->post('end_time'));
        //今日起始
        $beginToday =  get_time_block('sToday');
        $endToday = get_time_block('eToday');
        //昨日起始
        $beginYesterday = get_time_block('sYesterday');
        $endYesterday = get_time_block('eYesterday');
        //本月起始
        $beginThismonth = get_time_block('sMonth');
        $endThismonth = get_time_block('eMonth');
        //本周起始
        $sweek=get_time_block('sWeek');
        $eweek=get_time_block('eWeek');
        //type==1 今日，type==2 昨日，type==3 本月,type==4 本周
        $type=$this->input->post('type')?:1;
        if(!in_array($type,[1,2,3,4])) $this->_return(-1,'type 参数错误');

        $where='1=1';
        if($admin['role_type']==1){//代理商
            $where=" agent_id =".$admin['id'];
        }elseif($admin['role_type']==2){//商家
            $where=" adminid=".$admin['id'];
        }
        if($start_time || $end_time) {//搜索
            if ($start_time) {
                $start_time .= " 00:00:00";
                $where .= " and paytime>='" . $start_time . "'";
            }
            if ($end_time) {
                $end_time .= " 23:59:59";
                $where .= " and paytime<='" . $end_time . "'";
            }
        }else{
            if($type==1){
                $where.= " and paytime between'". date("Y-m-d H:i:s",$beginToday)."' and '".date('Y-m-d H:i:s',$endToday)."'";
            }elseif($type==2){
                $where.= " and paytime between'". date("Y-m-d H:i:s",$beginYesterday)."' and '".date('Y-m-d H:i:s',$endYesterday)."'";
            }elseif($type==4){
                $where.=  " and paytime between'". date("Y-m-d H:i:s",$sweek)."' and '".date('Y-m-d H:i:s',$eweek)."'";
            }else{
                $where.= " and paytime between'". date("Y-m-d H:i:s",$beginThismonth)."' and '".date('Y-m-d H:i:s',$endThismonth)."'";
            }
        }


        $where.=" and status>0";
        $list=$this->_getpage('trade',$where,'id desc',$page,$pagesize,'ctime,pay_money,paytype');

        $total=$this->_getrow('trade','sum(pay_money) as total_money,count(id) as count',$where);
        //余额
        $balance_money=$this->_getfield('trade','sum(pay_money)',$where." and paytype=1");
        //微信 金额
        $wx_money=$this->_getfield('trade','sum(pay_money)',$where." and paytype=2");
        //支付宝
        $ali_money=$this->_getfield('trade','sum(pay_money)',$where." and paytype=3");
        //line
        $line_money=$this->_getfield('trade','sum(pay_money)',$where." and paytype=4");
        $data=[
            'total_money'=>$total['total_money']?:'0.00',
            'count'=>$total['count'],
            'balance_money'=>$balance_money?:"0.00",
            'wx_money'=>$wx_money?:"0.00",
            'ali_money'=>$ali_money?:"0.00",
            'line_money'=>$line_money?:"0.00",
            'list'=>$list
        ];
        $this->_return(1,'获取成功',$data);
    }

    //已消费订单
    public function use_trade_list(){
        $admin=$this->check_shop_token();
        $page=$this->input->post('page')?:1;
        $pagesize=$this->input->post('pagesize')?:10;
        $type=$this->input->post('type');
        if(!in_array($type,[1,2])) $this->_return(-1,'type 参数错误');
        $where='1=1';
        if($admin['role_type']==1){//代理商
            $where=" agent_id =".$admin['id'];
        }elseif($admin['role_type']==2){//商家
            $where=" adminid=".$admin['id'];
        }
        if($type==1){
            $pack_ids=$this->_getcol('pack_item','pack_id',"title like '%美容%'")?:[0];
        }else{
            $pack_ids=$this->_getcol('pack_item','pack_id',"title like '%脱毛%'")?:[0];
        }

        $where.=" and status>2 and pack_id in(".implode(',',$pack_ids).")";
        $list=$this->_getpage('trade',$where,' total_money desc',$page,$pagesize,['adminid as shop_id,sum(pay_money) as total_money,count(1) as count','adminid']);
        foreach($list['list'] as $k=>&$v){
            $shop=$this->_getrow('admin','nickname,address',['id'=>$v['shop_id']]);
            $v['shop_name']=$shop['nickname']?:"";
            $v['shop_address']=$shop['address']?:"";
        }
        unset($v);
        $this->_return(1,'获取成功',$list);
    }

    //获取商家已消费订单列表
    public function get_shop_use_trade(){
        $admin=$this->check_shop_token();
        $page=$this->input->post('page')?:1;
        $pagesize=$this->input->post('pagesize')?:10;
        $shop_id=$this->input->post('shop_id');
        if(!$shop_id) $this->_return(-1,'缺少参数 shop_id');
        $shop=$this->_getrow('admin','nickname,address',['id'=>$shop_id]);
        $where=" adminid=$shop_id and status>2";
        $pay_type=[1=>"余额支付",2=>"微信支付",3=>"支付宝支付",4=>"line支付"];
        $list=$this->_getpage('trade',$where,'id desc',$page,$pagesize,'id,ctime,pack_info,paytype,pay_money');
        foreach($list['list'] as $k=>&$v){
            $pack=json_decode($v['pack_info'],true);
            $v['pack_title']=$pack['title'];
            $v['pay_type_name']=$pay_type[$v['paytype']];
            unset($v['pack_info']);
        }
        unset($v);
        $data=[
            'shop_name'=>$shop['nickname']?:"",
            'shop_address'=>$shop['address']?:"",
            'count'=>$this->_getfield('trade','count(1)',$where),
            'total_money'=>$this->_getfield('trade','sum(pay_money)',$where)?:"0.00",
            'list'=>$list
        ];
        $this->_return(1,'获取成功',$data);
    }
    //商家列表
    public function shop_list(){
        $admin=$this->check_shop_token();
        $where=" gid in(".implode(',',$this->_role[2]).")";
        if($admin['role_type']==1){
            $where.=" and corpid =".$admin['id'];
        }elseif($admin['role_type']==2){
            $where.=" and id =".$admin['id'];
        }
        $list=$this->_getlist('admin','id as shop_id,nickname',$where,'id desc');
        $this->_return(1,'获取成功',$list);
    }




    //获取商家信息
    public function get_shop_info(){
	    $admin=$this->check_shop_token();
	    $this->_return(1,'获取成功',['money'=>$admin['money'],'bank_name'=>$admin['bank_name'],'bank_card'=>$admin['bank_card'],'compellation'=>$admin['compellation']]);
    }

    //修改添加银行卡信息
    public function edit_shop_bankcard(){
        $admin=$this->check_shop_token();
        $bank_name=$this->input->post('bank_name');
        $bank_card=$this->input->post('bank_card');
        $compellation=$this->input->post('compellation');
        if(!$bank_name) $this->_return(-1,'请输入开户行名称');
        if(!$bank_card) $this->_return(-1,'请输入银行卡号');
        if(!$compellation) $this->_return(-1,'请输入开户人姓名');
        $this->db->update('admin',['bank_name'=>$bank_name,'bank_card'=>$bank_card,'compellation'=>$compellation],['id'=>$admin['id']]);
        $this->_return(1,'操作成功');
    }
    //提现
    public function shop_cash(){

        $admin=$this->check_shop_token();
        $money=$this->input->post('money');
        if(!is_numeric($money))$this->_return(0 ,'请输入正确的提现金额');
        if($money<=0) $this->_return(-1,'提现金额不能小于0');
        if($admin['money']<$money) $this->_return(0,'可提现金额不足');
        if(!$admin['bank_name'] || !$admin['bank_card']) $this->_return(0,'未绑定银行卡 请先绑定银行卡');
        //扣除余额
        $this->db->set('money',"money-".$money,false)->where('id',$admin['id'])->update('admin');

        $bankdata=[
            'bank_name'=>$admin['bank_name'],
            'bank_card'=>$admin['bank_card'],
            'name'=>$admin['compellation']
        ];
        //发起提现
        $res=$this->db->insert('admin_cash',[
            'type'=> $admin['role_type'],
            'adminid'=>$admin['id'],
            'money'=>$money,
            'bankdata'=>json_encode($bankdata),
            'createtime'=>date('Y-m-d H:i:s'),
        ]);
        if($res) $this->_return(1,'申请已提交请等待平台审核！');
        $this->_return(0,'提交失败,请稍后在试');
    }

    //提现记录
    public function cash_list(){
        $admin=$this->check_shop_token();
        $page=$this->input->post('page')?:1;
        $pagesize=$this->input->post('pagesize')?:10;

        $where="adminid=".$admin['id'];
        $list=$this->_getpage('admin_cash',$where,'id desc',$page,$pagesize,"id,money,createtime,status,fail");
        $this->_return(1,'获取成功',$list);
    }

    //忘记密码
    public function forget_password(){
        $post=$this->input->post();
        if(!$post['nickname']) $this->_return(-1,'请输入商家名称');
        if(!$post['bank_name']) $this->_return(-1,'请输入开户行名称');
        if(!$post['bank_card']) $this->_return(-1,'请输入开户卡号');
        if(!$post['compellation']) $this->_return(-1,'请输入开户人姓名');
        if(!$post['phone']) $this->_return(-1,'请输入联系方式');
        $pass=$this->_getfield('admin','pass',['nickname'=>$post['nickname'],'bank_name'=>$post['bank_name'],'bank_card'=>$post['bank_card'],'compellation'=>$post['compellation'],'phone'=>$post['phone']]);
        if($pass){//
            $this->_return(1,'密码是'.$pass);
        }else{
            $this->_return(0,"没有找到商家");
        }
    }

    //退出登入
    public function outlogin(){
        $admin=$this->check_shop_token();
        $token=md5(md5(time().$admin['id'].$admin['adminname']));
        $this->db->update('admin',['shop_token'=>$token],['id'=>$admin['id']]);
        $this->_return(1,'退出成功');
    }

}