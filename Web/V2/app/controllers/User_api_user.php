<?php
trait User_api_user{

    //判断是否有优惠券可以领
    public function is_get_coupon(){
        $token=$this->input->post('token');
        if($token){
            $user=$this->_get();
        }
        $coupon=$this->_getrow('coupon','id,title,money',['is_send'=>1]);
        //有登入的时候
        if($user){
            if($user['is_coupon']!=0) $this->_return(0,'老用户已经领取优惠券了',(object)array());
        }
        if($coupon) $this->_return(1,'有优惠券可领',$coupon);
        $this->_return(0,'没有优惠券可领取',(object)array());
    }
    //获取个人评价
    public function get_evaluate(){
        $user=$this->_get();
        $page=$this->input->post('page')?:1;
        $pagesize=$this->input->post('pagesize')?:10;

        $where='user_id='.$user['id'];
        $list=$this->_getpage('evaluate',$where,'id desc',$page,$pagesize,'id,user_id,score,ctime,content,pack_id,imgs');

        foreach($list['list'] as $k=>&$v){
            $imgs=[];
            if($v['imgs']){
                foreach(explode("\n", str_replace("\r", "", $v['imgs'])) as $kk=>$vv){
                  $imgs[]=base_url($vv);
                }
            }
            $v['imgs']=$imgs;
            $v['pack_title']=$this->_getfield('pack','title',['id'=>$v['pack_id']])?:"";
            $user=$this->_getrow('user','nickname,avatar',['id'=>$v['user_id']]);
            $v['avatar']=base_url($user['avatar']);
            $v['nickname']=$user['nickname'];
        }
        $this->_return(1,'获取成功',$list);
    }


    //领取优惠券
    public function give_coupon(){
        $id=$this->input->post('coupon_id');
        if(!$id) $this->_return(-1,'缺少参数 优惠券id');
        $coupon=$this->_getrow('coupon',"*",['id'=>$id]);
        $user=$this->_get();
        if($user['is_coupon']!=0) $this->_return(0,'您是老用户，暂时没有优惠券可领');
        //生成优惠券
        $this->db->insert('user_coupon',[
            'userid'=>$user['id'],
            'couponid'=>$coupon['id'],
            'title'=>$coupon['title'],
            'desc'=>$coupon['desc'],
            'money'=>$coupon['money'],
            'end_time'=>$coupon['end_time'],
            'limit_money'=>$coupon['limit_money'],
            'adminid'=>$coupon['adminid'],
            'ctime'=>date('Y-m-d H:i:s')
        ]);
        $this->db->update('user',['is_coupon'=>$id],['id'=>$user['id']]);
        $this->_return(1,'领取成功');
    }
    /**
     * 通过经纬度计算两者间的距离
     * @param float $lon1 对象经度
     * @param float $lon2 当前经度
     * @param float $lat1 对象纬度
     * @param float $lat2 当前纬度
     * @return string     距离数
     */
    private function get_distance($lon1=0, $lon2=0, $lat1=0, $lat2=0)
    {
        if ($lon1 == 0) $lon1 = 113.945712;   //深圳市公司地址
        if ($lat1 == 0) $lat1 = 22.547597;     //深圳市公司地址
        $lon1 = $lon1 * 0.01745329252;
        $lon2 = $lon2 * 0.01745329252;
        $lat1 = $lat1 * 0.01745329252;
        $lat2 = $lat2 * 0.01745329252;
        $d = acos(sin($lat1) * sin($lat2) + cos($lat1) * cos($lat2) * cos($lon1 - $lon2)) * 3963.0;
        if ($d > 1)
            return round($d, 1) . 'km';
        else
            return round($d * 1000, -1) . 'm';
    }

    public function register(){
        $nickname=$this->input->post('nickname');
        $account=$this->input->post('account');
        $password=$this->input->post('password');
        $area_code=$this->input->post('area_code');
        $sms=$this->input->post('sms');
        if(!$account) $this->_return(-1,'请输入账号',(object)array());
        if(!$password) $this->_return(-1,'请输入登入密码',(object)array());
        if(!$sms) $this->_return(-1,'请输入验证码',(object)array());
        if(strlen($password)<8) $this->_return(0,'密码长度不能小于8位');
        //验证验证码
        $is_sms=$this->_getrow('sms_record','*',['phone'=>$account],'id desc');
        if(!$is_sms) $this->_return(0,'验证码不正确',(object)array());
        if($is_sms['ctime']<time()) $this->_return(0,'验证码已过期',(object)array());
        if ($sms != $is_sms['sms']) $this->_return(0, '短信验证码不正确',(object)array());
    
        //判断手机号有没有注册
        $is_account=$this->_getrow('user','id',['account'=>$account]);
        if($is_account) $this->_return(0,'手机号已注册',(object)array());

        $token=md5(md5(time().$account));
        //生成账号
        $this->db->insert('user',[
           'account' =>$account,
            'password' =>md5($password),
            'password1' =>$password,
            'nickname'=>$nickname?:$account,
            'avatar'=>'images/default_via.jpg',
            'status'=>1,
            'token'=>$token,
            'area_code'=>$area_code,
            'createtime'=>time()
        ]);
        $user_id = $this->db->insert_id();
        $coupon=$this->_getrow('coupon',"*",['id'=>1]);
        $user=$this->_getrow('user', '*', ['id'=>$user_id]);
        if($user['is_coupon']!=0) $this->_return(0,'您是老用户，暂时没有优惠券可领');
        //生成优惠券
        $this->db->insert('user_coupon',[
            'userid'=>$user_id,
            'couponid'=>$coupon['id'],
            'title'=>$coupon['title'],
            'desc'=>$coupon['desc'],
            'money'=>$coupon['money'],
            'end_time'=>$coupon['end_time'],
            'limit_money'=>$coupon['limit_money'],
            'adminid'=>$coupon['adminid'],
            'ctime'=>date('Y-m-d H:i:s')
        ]);
        $this->db->update('user',['is_coupon'=>1],['id'=>$user_id]);
        $this->_return(1,'注册成功',['token'=>$token]);
    }

	public function login(){
		//密码登录
		$post = $this->input->post();
		$row = $this->user_mdl->login($post['account']);
		if (empty($row)) $this->_return(0, '请完成注册再登录');
		if (!$post['password'] || $row['password'] != md5($post['password'])) $this->_return(0, '密码错误，请重新输入');
		if ($row['status'] != 1) $this->_return(0, '账号不可用，请与我们联系');
		//$this->user_mdl->update($row['id']);
        //更新token
        // $token=md5(md5(time().$row['id'].$row['account']));
        // $this->db->update('user',['token'=>$token],['id'=>$row['id']]);
		$this->_return(1, '登录成功',['token'=>$row['token']]);
	}
  
	//重设密码
	public function forgot(){
		$post = $this->input->post();
		if (!empty($post['account']) && is_numeric($post['account']) && strlen($post['account']) == 11 && !empty($post['password'])) {
			//if ($_SESSION['user_sms_account'] != $post['account']) $this->_return(-1001, '短信验证码手机不正确');
			//if ($_SESSION['user_sms_time'] < time()) $this->_return(-1002, '短信验证码已经过期');
			//if ($post['sms'] != $_SESSION['user_sms']) $this->_return(-1003, '短信验证码不正确');
			$row = $this->_getrow('user', '*', "account='" . $post['account'] . "'");
			if (empty($row)) $this->_return(-1004, '会员账号不存在');
			$data = array('password' => md5($post['password']), 'lasttime' => time());
			if ($this->db->update('user', $data, 'id=' . $row['id'])) {
				$this->_return(1, '重置密码成功', $this->_filter($row));
			}
			$this->_return(-1005, '重置密码失败');
		}
		$this->_return(-1006, '账号密码为空或错误');
	}

	//获取个人资料
	public function profile(){
		$row = $this->_get(-102);
        $address=$this->_getrow('user_address','*',['user_id'=>$row['id'],'is_default'=>1]);
        $card = $this->_getrow('user_card', '*', 'user_id='.$row['id']);
        $row['square_customer_id'] = $card['square_customer_id'];
		$row['address']=($address['province'].$address['city'])?:"";
		$row['message_num']=$this->_getfield('message','count(1)',"user_id=".$row['id']." and is_read=0");
		$this->_return(1, '获取数据成功', $row);
	}

	//修改个人资料
	public function edit(){
		$row = $this->_get();
		$post = $this->input->post();
        unset($post['language']);
		if(!empty($post) || !empty($_FILES)){
			$data = $this->_getdata('user', $post, false, 'account,password,pid,toppid,path,money,redmoney,cash,avatar,status,weixin_openid,weixin_appopenid,weixin_proopenid,weixin_unionid,mobile_bind');

            if (isset($post['account'])) {
                if (isset($post['sms'])) {
                    $sms=$this->_getrow('sms_record','*',['phone'=>$post['account']]);
                    if (!$sms) $this->_return(0, '短信验证码手机不正确');
                    if ($sms['ctime'] < time()) $this->_return(0, '短信验证码已经过期');
                    if ($post['sms'] != $sms['sms']) $this->_return(0, '短信验证码不正确');
                }
                //if (md5($post['auth_password']) != $row['password']) $this->_return(-1004, '验证密码错误');
                $count = $this->_getcount('user', "account='".$post['account']."' and id<>".$row['id']);
                if($count)$this->_return(0, '手机号码已经被注册');
                $data['account'] = $post['account'];
                $data['mobile_bind'] = 1;
            }
				//if (isset($post['password'])) $data['password'] = md5($post['password']);

			if ($post['auth_password'] && $post['password']) {
				if (md5($post['auth_password']) != $row['password']) $this->_return(0, '旧密码错误');
				if(strlen($post['password'])<8) $this->_return(0,'密码长度不能小于8位');
				if($post['password']!=$post['password1']) $this->_return(0,'两次输入密码不一致');
				$data['password1'] = $post['password'];
				$data['password'] = md5($post['password']);
			}
			
      		$uploads = $this->_uploads();
			if ($uploads['avatar']['filename']) $data['avatar'] = $uploads['avatar']['filename'];
			if(!$data['avatar'] && isset($post['avatar'])){
				$data['avatar'] = $this->_uploadbase64($post['avatar'], './upload/user/'.$row['id'].'/');
				if($data['avatar'] == -1)$this->_return(0, '头像上传文件类型不正确');
				if($data['avatar'] == -2)$this->_return(0, '头像上传文件太大');
				if(!$data['avatar'])$this->_return(0, '头像上传文件失败');
			}
			if(!$data) $this->_return(0,'没有修改数据');
			$this->db->update('user', $data, 'id='.$row['id']);
			$row = $this->_update($row['id']);
			$this->_return(1, '资料修改成功', $row);
		}
		$this->_return(0, '未提交任何数据');
	}

	//忘记密码
    public function reset_password(){
        $sms=$this->input->post('sms');
        $password=$this->input->post('password');
        $account=$this->input->post('account');
        if(!$account) $this->_return(-1,'请输入手机号');
        if(!$sms) $this->_return(-1,'请输入短信验证码');
        if(!$password) $this->_return(-1,'请输入新密码');
        if(strlen($password)<8) $this->_return(0,'密码长度不能小于8位');
        $row_sms=$this->_getrow('sms_record','*',['phone'=>$account]);
        if (!$row_sms) $this->_return(0, '短信验证码手机不正确');
        if ($row_sms['ctime'] < time()) $this->_return(0, '短信验证码已经过期');
        if ($sms != $row_sms['sms']) $this->_return(0, '短信验证码不正确');
        $row=$this->_getrow('user','*',['account'=>$account]);
        if(!$row) $this->_return(0,'没有找到用户');

        $this->db->update('user',['password'=>md5($password),'password1'=>$password],['id'=>$row['id']]);
        $this->_return(1,'操作成功');

    }
	//判断支付密码
    public function check_pay_pass(){
        $user=$this->_get();
        $password=$this->input->post('password');
        if(!$password) $this->_return(-1,'请输入旧密码');
        if(empty($user['pay_password'])) $this->_return(0,'还未设置支付密码');
        if(md5($password)!=$user['pay_password']) $this->_return(0,'密码与旧密码不匹配');
        $this->_return(1,'匹配成功');
    }
    //短信验证码验证
    public function check_sms(){
        $account=$this->input->post('account');
        $sms=$this->input->post('sms');
        if(!$account) $this->_return(-1,'请输入手机号');
        if(!$sms) $this->_return(-1,'请输入短信验证码');
        $row=$this->_getrow('user','*',['account'=>$account]);
        if(!$row) $this->_return(0,'没有找到用户');
        $row_sms=$this->_getrow('sms_record','*',['phone'=>$account]);
        if (!$row_sms) $this->_return(0, '短信验证码手机不正确');
        if ($row_sms['ctime'] < time()) $this->_return(0, '短信验证码已经过期');
        if ($sms != $row_sms['sms']) $this->_return(0, '短信验证码不正确');
        $this->_return(1,'验证成功');
    }

    //修改支付密码
    public function edit_pay_pass(){
        $user=$this->_get();
        $password=$this->input->post('password');
        if(!$password) $this->_return(-1,'请输入支付密码');
        $this->db->update('user',['pay_password'=>md5($password),'pay_password1'=>$password],['id'=>$user['id']]);
        $this->_return(1,'修改成功');
    }

    //收货地址列表
    public function user_address_list(){
        $user=$this->_get();
        $page=$this->input->post('page')?:1;
        $pagesize=$this->input->post('pagesize')?:10;
        $where='user_id='.$user['id'];
        $list=$this->_getpage('user_address',$where,' is_default desc',$page,$pagesize,'id,name,phone,province,city,area,address,is_default');
        $this->_return(1,'获取成功',$list);
    }

    //添加地址
    public function add_address(){
        $user=$this->_get();
        $name=$this->input->post('name');
        $phone=$this->input->post('phone');
        $province=$this->input->post('province');
        $city=$this->input->post('city');
        $area=$this->input->post('area');
        $address=$this->input->post('address');

        if(!$name) $this->_return(-1,'请输入收货人姓名');
        if(!$phone || !is_numeric($phone) || strlen($phone)!==11) $this->_return(-1,'请输入正确的手机号');
        if(!$province || !$city) $this->_return(-1,'请选择省市区');
        if(!$address) $this->_return(-1,'请输入详细地址');
        $is_default=$this->_getfield('user_address','id',['user_id'=>$user['id'],'is_default'=>1]);
        if(!$is_default){
            $is_default=1;
        } else{
            $is_default=0;
        }
        $data=[
            'name'=>$name,
            'phone'=>$phone,
            'province'=>$province?:"",
            'city'=>$city?:"",
            'area'=>$area?:"",
            'address'=>$address?:"",
            'is_default'=>$is_default,
            'user_id'=>$user['id'],
            'ctime'=>time()
        ];
        $this->db->insert('user_address',$data);

        $this->_return(1,'添加成功');
    }

    //编辑收货地址
    public function edit_address(){
        $id=$this->input->post('address_id');
        $name=$this->input->post('name');
        if(!$id) $this->_return(-1,'缺少参数 id');
        $row=$this->_getrow('user_address','*',['id'=>$id]);
        if(!$row) $this->_return(0,'没有找到收货地址');
        $user=$this->_get();
        if($row['user_id']!=$user['id']) $this->_return(0,'数据错误');
        if($name){
            $phone=$this->input->post('phone');
            $province=$this->input->post('province');
            $city=$this->input->post('city');
            $area=$this->input->post('area');
            $address=$this->input->post('address');

            if(!$phone || !is_numeric($phone) || strlen($phone)!==11) $this->_return(-1,'请输入正确的手机号');
            if(!$province || !$city) $this->_return(-1,'请选择省市区');
            if(!$address) $this->_return(-1,'请输入详细地址');

            $data=[
                'name'=>$name,
                'phone'=>$phone,
                'province'=>$province?:"",
                'city'=>$city?:"",
                'area'=>$area?:"",
                'address'=>$address?:"",
            ];
            $this->db->update('user_address',$data,['id'=>$id]);
            $this->_return(1,'修改成功',(object)array());
        }
        $this->_return(1,'获取成功',$row);
    }

    //删除收货地址
    public  function del_address(){
        $id=$this->input->post('address_id');
        if(!$id) $this->_return(-1,'缺少参数 id ');
        $this->db->delete('user_address',['id'=>$id]);
        $this->_return(1,'删除成功');
    }
    //设置为默认地址
    public function set_default_address(){
        $user=$this->_get();
        $id=$this->input->post('address_id');
        if(!$id) $this->_return(-1,'缺少参数 address_id');
        $row=$this->_getrow('user_address','*',['id'=>$id]);
        if(!$row) $this->_return(0,'数据错误');
        if($row['user_id']!=$user['id']) $this->_return(0,'数据错误');
        $this->db->update('user_address',['is_default'=>0],['user_id'=>$user['id']]);
        $this->db->update('user_address',['is_default'=>1],['id'=>$id]);
        $this->_return(1,'设置成功');
    }

    //消息列表
    public function message(){
        $user=$this->_get();
        $page=$this->input->post('page')?:1;
        $pagesize=$this->input->post('pagesize')?:10;
        $list=$this->_getpage('message',['user_id'=>$user['id']],'id desc,is_read asc',$page,$pagesize);
        foreach($list['list'] as $k=>&$v){
            if($v['is_read']==0) $this->db->update('message',['is_read'=>1],['id'=>$v['id']]);//修改为已读
            $v['img']=$v['img']?base_url($v['img']):base_url("images/default_via.jpg");
        }
        unset($v);
        $this->_return(1,'获取成功',$list);
    }

    //消息详情
    public function message_info(){
        $message_id=$this->input->post('message_id');
        if(!$message_id) $this->_return(-1,'缺少参数 message_id');
        $row=$this->_getrow('message','*',['id'=>$message_id]);
        $row['img']=$row['img']?base_url($row['img']):base_url("images/default_via.jpg");
        $this->_return(1,'获取成功',$row);
    }

	//获取充值套餐
    public function get_recharge(){
        $recharge=array_col2row($this->setting_mdl->get('recharge'));
        $this->_return(1,'获取成功',$recharge);
    }

    //获取使用协议
    public function get_protocol()
    {
        $row = str_ireplace('/upload/', base_url() . 'upload/', $this->setting_mdl->get('service'));
        $this->_return(1, '获取成功',$row['text']);
    }

    //关于我们
    public function about(){
        $about=str_ireplace('/upload/', base_url().'upload/', $this->setting_mdl->get('about'));
        $this->_return(1,'获取成功',$about);
    }

    //使用指南
    public function help(){
        $help=str_ireplace('/upload/', base_url().'upload/', $this->setting_mdl->get('help'));
        $this->_return(1,'获取成功',$help);
    }

	private function _update($id){
		$row = $this->_getrow('user', '*', "id=$id and status=1");
		if(empty($row))$this->_return(-5, '请完成注册再登录');		
		$_SESSION['user'] = $row;	
		return $this->_filter($row);
	}
	
	private function _filter($user){
		$user['avatar'] = concaturl($user['avatar']);		
		/*$user['manger_adminids'] = (array)$this->_getcol('admin', 'id', "find_in_set(".$user['id'].",mangerids)>0");//管理员
		$user['shop_adminids'] = (array)$this->_getcols('admin', 'id,nickname,status', "userid=".$user['id']." and gid in (".implode(',', $this->_role[2]).")");//医院		
		$user['corp_adminids'] = (array)$this->_getcols('admin', 'id,nickname,status', "userid=".$user['id']." and gid in (".implode(',', $this->_role[1]).")");//代理*/
		//$cash_total = $this->_getfield('user_cash', 'sum(money)', "status=0 and userid=".$user['id']);//统计未处理的提现
		//$user['sum_money'] = $user['money']+$user['redmoney'];//余额加赠送余额
		return $user;
	}
	
	private function _get($code=-101){
		$token=$this->input->post('token');
		if(!$token) $this->_return($code,'请登入', $token);
		$user=$this->_getrow('user','*',['token'=>$token]);
		if(!$user) $this->_return($code,'请登入');
		if($user['status']!=1) $this->_return(-5,'账号已禁用请联系客服');
		return  $this->_filter($user);
	}	
}