<?php

trait User_api_trade
{

    //获取首页轮播图 和logo
    public function get_img()
    {
        $row = json_decode($this->_getfield('setting', 'val', ['key' => "setting"]), 1);
        $img = [];
        if ($row['img']) {
            foreach (explode("\n", str_replace("\r", "", $row['img'])) as $k => $v) {
                $img[] = base_url($v);
            }
        } else {
            $img[0] = base_url('images/default.png');
        }
        $data = [
            'logo' => ($row['logo']) ? base_url($row['logo']) : base_url('images/logo1.png'),
            'img' => $img,
        ];
        $this->_return(1, '获取成功', $data);
    }

    //首页
    public function user_home(){
        $lat=$this->input->post('lat');
        $lng=$this->input->post('lng');
        $city=$this->input->post('city');
        if (empty($lat) || empty($lng)) {
            $this->_return(-1,'自身坐标不能为空');
        }
        $where="business_status=0 and gid in(".implode(',',$this->_role[2]).")";
       /* if($city){
            $last_str=mb_substr($city,-1);
            if($last_str=="市")$city=mb_substr($city,0,-1);
            $where.=" and area like '%".$city."%'";
        }*/

        $item=$this->_getlist('item','id,title',"",'id asc');

        $list=$this->_getlist('admin','id as shop_id,thumb,nickname,keywords,score,lat,lng,address,truncate(SQRT(POWER('.$lat.' - lat, 2) + POWER('.$lng.' - lng, 2)),2) AS d',$where,'d asc','0,100');
        foreach($list as $k=>$v){
            $keyword=explode(',',$v['keywords']);
            $list[$k]['keywords']='';
            foreach($keyword as $kk=>$vv){
                $list[$k]['keywords'].=$vv." ";
            }
            $list[$k]['d'] = $this->get_distance($lng, $v['lng'], $lat, $v['lat']);
            $list[$k]['thumb'] = $v['thumb']?base_url($v['thumb']):base_url("images/default_via.jpg");
            $pack=$this->_getlist('pack','id,title,price,subscription_flg, subscription_type, img',"adminid=".$v['shop_id']." and validity_time>'".date('Y-m-d H:i:s')."'",'id asc','3');
            $array = [100, 200, 300, 400, 500, 600, 700, 800, 900];
            foreach($pack as $kk=>$vv){
                $pack_item = $this->_getrow('pack_item', 'knife, num', 'pack_id='.$vv['id']);
                $pack[$kk]['knife'] = $pack_item['knife'];
                $pack[$kk]['num'] = $pack_item['num'];
                // $pack[$kk]['sell_num']=$this->_getfield('trade','count(1)',"pack_id =".$vv['id']." and status >0")?:"0";
                $pack[$kk]['sell_num'] = array_rand($array)*100;
                $pack[$kk]['num']=$this->_getfield('pack_item','sum(num)',['pack_id'=>$vv['id']])?:"0";
                $pack[$kk]['img']=base_url($pack[$kk]['img']);
            }
            $list[$k]['pack']=$pack;
        }
        $this->_return(1,'获取成功',['item'=>$item,'list'=>$list]);
    }

    

    public function get_agreements() {
        $agreements = $this->_getlist('subscription_privacy_contents', '*');
        $this->_return(1,'获取成功',['agreements'=>$agreements]);
    }

    //店铺详情
    public function shop_details(){
        if ($this->input->post('token')) {
            
            $auth_user=$this->_getrow('user', '*', ['token'=>$this->input->post('token')]);
            // $this->_return(5, 'error',$auth_user);
        }
        $page=$this->input->post('page')?:1;
        $pagesize=$this->input->post('pagesize')?:10;
        $shop_id=$this->input->post('shop_id');
        if(!$shop_id) $this->_return(-1,'缺少参数 shop_id');
        $shop=$this->_getrow('admin','id as shop_id,nickname,score,hours,address,phone,thumb,text',['id'=>$shop_id]);
        if(!$shop) $this->_return(-1,'缺少参数 shop_id');
        $shop['thumb']= $shop['thumb']?base_url($shop['thumb']):base_url("images/default_via.jpg");
        $shop['text']=str_ireplace('/upload/', base_url().'upload/',$shop['text']);
        if(!$shop) $this->_return(0,'没有找到店铺');
        //获取套餐
        $pack=$this->_getlist('pack','id,title,price,number,service_process,img,subscription_flg,subscription_type',"adminid=".$shop['shop_id']." and validity_time>'".date('Y-m-d H:i:s')."'");
        foreach($pack as $k=>$v){
            if ($pack[$k]['subscription_flg'] == 1) {
                $subscription_pack = $this->_getrow('subscription_pack_types','id,title,count,discount',"id=".$pack[$k]['subscription_type']);
                if ($subscription_pack) {
                    $pack[$k]['title'] = $subscription_pack['title'];
                    $pack[$k]['count'] = $subscription_pack['count'];
                    $pack[$k]['discount'] = $subscription_pack['discount'];
                }
            }
            $pack[$k]['sell_num']=$this->_getfield('trade','count(1)',"pack_id =".$v['id']." and status >0")?:"0";
            $pack[$k]['num']=$this->_getfield('pack_item','sum(num)',['pack_id'=>$v['id']])?:'0';
            $pack[$k]['img']=base_url($pack[$k]['img']);
        }
        //好评率
        $praise_ratio=0;
        $praise_count = $this->_getfield('evaluate',"count(1)","shop_id=".$shop['shop_id']." and score>=3");
        $total_count = $this->_getfield('evaluate',"count(1)","shop_id=".$shop['shop_id']);
        if($total_count>0) $praise_ratio=round($praise_count/$total_count*100,1);

        //评价列表
        $list=$this->_getpage('evaluate',['shop_id'=>$shop['shop_id']],'id asc',$page,$pagesize,'id,content,user_id,imgs,score,ctime');
        foreach($list['list'] as $k=>&$v){
            $user=$this->_getrow('user','nickname,avatar',['id'=>$v['user_id']]);
            $v['nickname'] = "名無しさん";
            $v['avatar']=$user['avatar']?base_url($user['avatar']):base_url("images/default_via.jpg");
            $img=[];
            if($v['imgs']){
                foreach (explode("\n", str_replace("\r", "", $v['imgs'])) as $kk => $vv) {
                    $img[] = base_url($vv);
                }
            }
            $v['imgs']=$img;
        }

        $is_favorite = false;
        if ($auth_user) {
            $favorites = $this->_getcol('favorite','id',['admin_id'=>$shop_id, 'user_id'=>$auth_user['id']]);
        }
        
        if (sizeof($favorites)>0) {
            $is_favorite = true;
        }
        $this->_return(1,'获取成功',[
            'shop'=>$shop,
            'pack'=>$pack,
            'total_count'=>$total_count,
            'praise_ratio'=>$praise_ratio,
            'list'=>$list,
            'is_favorite'=>$is_favorite
        ]);
    }

    //获取店铺品牌介绍
    public function get_shop_introduce(){
        $shop_id=$this->input->post('shop_id');
        if(!$shop_id) $this->_return(-1,'缺少参数 shop_id');
        $text=$this->_getfield('admin','text',['id'=>$shop_id]);
        $this->_return(1,'获取成功',str_ireplace('/upload/', base_url().'upload/',$text));
    }

    //搜索店铺
    public function search_shop(){
        $page=$this->input->post('page')?:1;
        $pagesize=$this->input->post('pagesize')?:10;

        $city=trim($this->input->post('city'));
        $keywords=trim($this->input->post('keywords'));

        $type=$this->input->post('type');
        if(!in_array($type,[1,2])) $type=0;//过滤掉其它类型的商家
        $orderby=$this->input->post('orderby');

        $lat=$this->input->post('lat');
        $lng=$this->input->post('lng');

        if (empty($lat) || empty($lng)) {
            $this->_return(-1,'自身坐标不能为空');
        }

        $where="a.business_status=0 and  a.gid in(".implode(',',$this->_role[2]).")";

        if($city) {
            $where.=" and ((a.address like '%".$city."%' or a.area like '%".$city."%') or (a.address like '%".$this->translate($this->language==1?2:1,$city)."%' or a.area like '%".$this->translate($this->language==1?2:1,$city)."%'))";
            /*//判断关键字是否搜索过
            $is_city=$this->_getfield('hot_keyword','id',['keyword'=>$city]);
            if($is_city){
                $this->db->set('num','num+1',false)->where('id',$is_city)->update('hot_keyword');
            }else{
                $this->db->insert('hot_keyword',['keyword'=>$city,'num'=>1]);
            }*/
        }
        if($keywords) $where.=" and  (concat(a.nickname,a.phone,a.mobile,a.nickname,a.address,a.name,a.keywords,a.area) like '%".$keywords."%' or concat(a.nickname,a.phone,a.mobile,a.nickname,a.address,a.name,a.keywords,a.area) like'%".$this->translate($this->language==1?2:1,$keywords)."%')";

        if($type){
            $title=$this->_getfield('item','title',['id'=>$type]);
            if($type){
                //$where.=" and keywords like '%".$title."%'";
                $where.=" and (find_in_set('".$this->translate(2,$title)."', keywords)>0 or find_in_set('".$title."', keywords)>0 )";
            }
        }

        $order="d asc";
        if(is_numeric($orderby)){
            if($orderby==1){//销量排序
                $order="yyq desc";
            }elseif($orderby==2){//价格降序 （从高到底）
                $order=" a.min_price desc";
            }elseif($orderby==3){//价格升序 （从底到高）
                $order=" a.min_price asc";
            }
        }

        $list=$this->_getpage(array(' admin as a',array("( select count(1) as yyq ,adminid from trade where `adminid`=id and status>0 ) as b","a.id=b.adminid")),$where,$order,$page,$pagesize,'a.id as shop_id,a.nickname,a.keywords,a.score,a.address,a.thumb,a.lat,a.lng,truncate(SQRT(POWER('.$lat.' - lat, 2) + POWER('.$lng.' - lng, 2)),2) AS d');
        //log_message('error',$this->db->last_query());
        foreach($list['list'] as $k=>$v){
            $keyword=explode(',',$v['keywords']);
            $list['list'][$k]['keywords']='';
            foreach($keyword as $kk=>$vv){
                $list['list'][$k]['keywords'].=$vv." ";
            }
            $list['list'][$k]['thumb'] = $v['thumb']?base_url($v['thumb']):base_url("images/default_via.jpg");
            $list['list'][$k]['d'] = $this->get_distance($lng, $v['lng'], $lat, $v['lat']);
            $pack=$this->_getlist('pack',"id,title,price,subscription_flg, subscription_type,reservation_info",['adminid'=>$v['shop_id']],'price asc','2');
            foreach($pack as $key=>$value){
                $pack[$key]['sell_num']=$this->_getfield('trade','count(1)',"pack_id =".$value['id']." and status >0")?:"0";
                $pack[$key]['num']=$this->_getfield('pack_item','sum(num)',['pack_id'=>$value['id']])?:'0';
            }
            $list['list'][$k]['pack']=$pack;
        }
        $this->_return(1,'获取成功',$list);
    }

    //热门搜索关键字
    public function hot_keyword(){
        $keyword=$this->_getcol('hot_keyword','keyword',['language'=>$this->language],'id asc',"0,20");
        $this->_return(1,'获取成功',$keyword);
    }

    //购买详情
    public function pack_details(){
        $shop_id=$this->input->post('shop_id');
        $pack_id=$this->input->post('pack_id');
        if(!$shop_id) $this->_return(-1,'缺少参数 shop_id');
        if(!$pack_id) $this->_return(-1,'缺少参数 pack_id');
        $shop=$this->_getrow('admin','id as shop_id,thumb,nickname',['id'=>$shop_id]);
        if(!$shop) $this->_return(0,'shop_id 参数错误');
        $shop['thumb']= $shop['thumb']?base_url($shop['thumb']):base_url("images/default_via.jpg");
        $pack=$this->_getrow('pack','id as pack_id,img,title,price,reservation_info,validity_time,number,subscription_flg,subscription_type,efficacy,position,service_process',['id'=>$pack_id,'adminid'=>$shop_id]); 
        if ($pack['subscription_flg'] == 1) {
            $subscription_pack = $this->_getrow('subscription_pack_types','id,title,count,discount',"id=".$pack['subscription_type']);
            if ($subscription_pack) {
                $pack['title'] = $subscription_pack['title'];
                $pack['count'] = $subscription_pack['count'];
                $pack['discount'] = $subscription_pack['discount'];
            }
        }
        $pack['img']= $pack['img']?base_url($pack['img']):base_url("images/default_via.jpg");
        if(!$pack) $this->_return(0,'没有找到套餐');
        $pack_item=$this->_getlist('pack_item',"title,knife,num,text",['pack_id'=>$pack['pack_id']]);
        $this->_return(1,'获取成功',['shop'=>$shop,'pack'=>$pack,'pack_item'=>$pack_item]);
    }

    //下单支付页面
    public function pay_info_page(){
        $user=$this->_get();
        $shop_id=$this->input->post('shop_id');
        $pack_id=$this->input->post('pack_id');
        if(!$shop_id) $this->_return(-1,'缺少参数 shop_id');
        if(!$pack_id) $this->_return(-1,'缺少参数 pack_id');
        $shop=$this->_getrow('admin','*',['id'=>$shop_id]);
        if(!$shop) $this->_return(0,'shop_id 参数错误');
        $pack=$this->_getrow('pack','*',['id'=>$pack_id,'adminid'=>$shop_id]);
        if(!$pack) $this->_return(0,'pack_id 参数错误');
        $coupon_id=$this->input->post('coupon_id')?:0;
        if($coupon_id){
            $coupon_money=$this->check_coupon($shop_id,$coupon_id,$pack['price']);
        }
        $data=[
            'shop_id'=>$shop_id,
            'pack_id'=>$pack_id,
            'pack_title'=>$pack['title'],
            'price'=>max(round($pack['price']-$coupon_money,2),0),
            'user_money'=>$user['money']
        ];
        $this->_return(1,'获取成功',$data);
    }

    /**
     * 購入処理
     */
    public function pay_order(){
        // ユーザ情報取得
        $user = $this->_get();
        // POST parameter
        $shop_id = $this->input->post('shop_id');
        $pack_id = $this->input->post('pack_id');
        $pay_type = $this->input->post('pay_type');
        $coupon_id = $this->input->post('coupon_id')?:0;
        $pay_password = $this->input->post('pay_password');
        $square_source_id = $this->input->post('source_id');

        // パラメータチェック
        if(!in_array($pay_type,[1,2,3,4,5,6])){
            $this->_return(-1, 'お支払い方法を選択してください');
        }
        if(!$shop_id){
            $this->_return(-1, '店舗が指定されていません（shop_id）');
        }
        if(!$pack_id){
            $this->_return(-1, '商品が指定されていません（pack_id）');
        }

        // 店舗情報取得
        $shop = $this->_getrow('admin','*',['id'=>$shop_id]);
        if(!$shop){
            $this->_return(0, '店舗が見つかりませんでした');
        }

        // 商品情報取得
        $pack = $this->_getrow('pack','*',['id'=>$pack_id,'adminid'=>$shop_id]);
        if(!$pack){
            $this->_return(0,'商品が見つかりませんでした');
        }
        if(strtotime($pack['validity_time'])<time()){
            $this->_return(0,'パッケージの有効期限が切れています');
        }

        // サブスク商品の購入チェック
        if(intval($pack['subscription_flg']) === 1){
            $trades = $this->_getlist(['trade', ['pack', 'pack.id=trade.pack_id']],
                             '*',
                             'pack.adminid='.$shop_id.' and trade.user_id='.$user['id'].' and pack.id=trade.pack_id and pack.subscription_flg=1 and status NOT IN (0,-1,-2) and DATE_FORMAT(DATE_ADD(paytime, INTERVAL 1 MONTH), "%Y-%m-%d") >= DATE_FORMAT(NOW(), "%Y-%m-%d")'
            );
            if($trades){
                log_message('error', '同店舗でのサブスク購入済みのため、購入できません user_id:'.$user['id'].' pack_id:'.$pack_id);
                $this->_return(0, '同店舗でのサブスク購入済みのため、購入できません');
            }
        }

        // 商品パッケージ情報取得
        $pack_item = $this->_getlist('pack_item','*',['pack_id'=>$pack_id]);
        if(!$pack_item){
            $this->_return(0,'商品パッケージが見つかりませんでした');
        }

        // クーポン情報取得
        $coupon_money = 0;
        if($coupon_id){
            $coupon_money = $this->check_coupon($coupon_id,$pack['price']);
        }
        $pay_money = max($pack['price']-$coupon_money,0);
        $discount = min($pack['price'],$coupon_money);
        $tradeno = date('YmdHis').mt_rand(10000,99999);
        if($pay_type == 1 && $pay_money > $user['money']){
            $this->_return(0,'残高が不足しています');
        }
        if($pay_type == 6) {
            $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < 8; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            $pay_token = $randomString;
        } else {
            $pay_token = '';
        }

        // 購入情報登録
        $this->db->insert('trade',[
            'tradeno'=>$tradeno,
            'agent_id'=>$shop['corpid']?:0,
            'adminid'=>$shop['id'],
            'user_id'=>$user['id'],
            'pack_id'=>$pack_id,
            'pack_info'=>json_encode($pack),
            'money'=>$pack['price'],
            'pay_money'=>$pay_money,
            'coupon_id'=>$coupon_id,
            'discount'=>$discount,
            'ctime'=>date('Y-m-d H:i:s'),
            'end_time'=>$pack['validity_time'],
            'paytype'=>$pay_type,
            'pack_item_info'=>json_encode($pack_item),
            'pay_token'=>$pay_token,
            'subscription_flg'=>$pack['subscription_flg'],
            'subscription_type'=>$pack['subscription_type']
        ]);
        $trade_id=$this->db->insert_id();//交易订单id
        if($pay_money<=0) {//订单余额小于等于0 直接支付成功
            $this->tradeSuccess($trade_id);
            $this->_return(88,'付款成功',['trade_id'=>$trade_id]);
        }
        if($pay_type==1){//余额支付
            //扣除余额
            if(!$user['pay_password']) $this->_return(8,'还未设置支付密码 请先设置支付密码');
            if(!$pay_password) $this->_return(-1,'请输入支付密码');
            if(md5($pay_password)!=$user['pay_password']) $this->_return(0,'支付密码不正确');
            //扣除余额
            $this->db->set('money','money-'.$pay_money,false)->where('id',$user['id'])->update('user');
            $this->tradeSuccess($trade_id);
            // exit(json_encode(['code'=>88, 'msg'=>'付款成功', 'data'=>['trade_id'=>$trade_id]]));
            $this->_return(88,'付款成功',['trade_id'=>$trade_id]);
        } elseif ($pay_type==2){//微信支付
            $trade=$this->_getrow('trade','*',['id'=>$trade_id]);
            $pay_money=$this->rmb2ry($pay_money);
            $this->wx_pay("APP","购买套餐",$tradeno,$pay_money*100,$trade);
        } elseif ($pay_type==3){//支付宝支付
            $pay_money=$this->rmb2ry($pay_money);
            $result=$this->alipay($tradeno,$pay_money,"购买套餐",$trade_id,1);
            $this->_return(1,'获取支付参数成功', array('trade_id' => $trade_id, 'payparams' => $result));
        } elseif ($pay_type==4){//line 支付
            //$this->_return(0,'未开发');
           $this->line_pay($tradeno,$pay_money,$this->translate(2,"购买套餐"),$trade_id,1);
        } elseif ($pay_type==5){//Square 支付
          $card = $this->_getrow('user_card', '*', 'user_id='.$user['id']);
          if (!$card) {
            $customer_id = $this->create_square_customer_id($user);
            $card_id = $this->create_square_card($customer_id, $square_source_id);
            // $key = $this->getUniqueKey();
            if ($card_id) {
                $this->db->insert('user_card', ['user_id' => $user['id'], 'square_id'=>$card_id, 'square_customer_id'=>$customer_id]);
                $result = $this->square_pay($card_id, $pay_money, $customer_id );
            }
            if (!$result->errors) {
              $this->tradeSuccess($trade_id);
              $this->_return(88,'付款成功',['trade_id'=>$trade_id, 'result' => $result, 'square_customer_id' => $customer_id]);
            } else {
              $this->_return(-1,'缺少参数', $result);
            }
            $this->_return(-1,'缺少参数', $result);
          } else {
            if (!$card['square_id']) $this->_return(0,'square_source_id 参数错误');
            $result = $this->square_pay($card['square_id'] , $pay_money, $card['square_customer_id']);
            if ($result->errors) {
              $this->_return(-1,'失敗しました。', $result);
            }
            $this->tradeSuccess($trade_id);
            $this->_return(88,'付款成功',['trade_id'=>$trade_id, 'result' => $result]);
          }
        } elseif ($pay_type==6){//line 支付
            // $this->tradeSuccess($trade_id);
            $this->tradeSuccess($trade_id);
            $this->_return(88,'付款成功',['trade_id'=>$trade_id]);
        }
    }
    
    //获取订单支付支付
    public function get_trade_status(){
        $trade_id=$this->input->post('trade_id');
        if(!$trade_id) $this->_return(-1,'缺少参数 trade_id');
        $trade=$this->_getrow('trade','*',['id'=>$trade_id]);
        if(!$trade) $this->_return(0,'没有找到订单');
        $this->_return(1,'获取成功',['status'=>$trade['status']]);
    }

    //订单交易完成操作
    private function tradeSuccess($trade_id){
        $trade=$this->_getrow('trade','*',['id'=>$trade_id]);
        if(!$trade) return false;
        if($trade['status']!=0) return false;
        $time=date('Y-m-d H:i:s');
        //修改订单状态
        $this->db->update('trade',['status'=>1,'paytime'=>$time],['id'=>$trade['id']]);
        if($trade['coupon_id']) $this->db->update('user_coupon',['usetime'=>$time,'order_id'=>$trade['id']],['id'=>$trade['coupon_id']]);//处理优惠券
        //生成订单套餐项目
        $arr=json_decode($trade['pack_item_info'],1);
        foreach($arr as $k=>$v){
            for ($i = 0; $i < $v['num']; $i++) {
                $this->db->insert('trade_pack_item',[
                    'trade_id'=>$trade['id'],
                    'pack_item_id'=>$v['id'],
                    'item_name'=>$v['title'],
                    'num'=> 1,
                    'knife'=>$v['knife']
                ]);
            }
        }
        return true;
    }

    //预约 项目
    public function get_reservation_item(){
        $trade_id=$this->input->post('trade_id');
        if(!$trade_id) $this->_return(-1,'缺少参数 trade_id');
        $trade=$this->_getrow('trade','*',['id'=>$trade_id]);
        $user=$this->_get();

        if(!$trade) $this->_return(0,'没有找到订单');
        if($trade['status']<=0) $this->_return(0,'订单状态错误');
        if($trade['status']>2) $this->_return(0,'订单已使用完成');
        if($trade['user_id']!=$user['id']) $this->_return(0,'订单只能本人预约');
        $pack=json_decode($trade['pack_info'],1);
        //获取订单项目套餐
        $item=$this->_getlist('trade_pack_item','id,item_name,knife,pack_item_id',"trade_id=".$trade['id']." and (num-use_num)>0");
        if(empty($item))$this->_return(0,'没有可预约的套餐');
        foreach($item as $k=>&$v){
            $pack_item=$this->_getrow('pack_item','type,mr_type',['id'=>$v['pack_item_id']]);
            $v['time']=30;
            if($pack_item['type']==1) if($pack_item['mr_type']==2) $v['time']=15;
        }
        $hours=$this->_getfield('admin','hours',['id'=>$trade['adminid']])?:"";
        $data=[
            'paytime'=>$trade['paytime'],
            'number'=>$pack['number'],
            'hours'=>$hours,
            'list'=>$item,
            'is_subsc'=>$trade['subscription_flg']==1?true: false
        ];
        $this->_return(1,'获取成功',$data);
    }

    /**
     * 予約基本情報取得
     */
    public function get_reservation_basic_info(){
        // POST
        $trade_id = $this->input->post('trade_id');
        $item_id = $this->input->post('item_id');
        // パラメータチェック
        if(!$trade_id){
            $this->_return(-1,'パラメータがありません');
        }
        // 購入情報取得
        $trade = $this->_getrow('trade','*',['id'=>$trade_id]);
        if(!$trade){
            $this->_return(-1,'注文が見つかりません');
        }

        // 基本情報
        $basic = array();

        // 店舗情報取得
        $shopInfo = $this->_getrow('admin', '*', ['id'=>$trade['adminid']]);

        // 曜日別休業日取得
        $basic['holidays'] = explode(',', $shopInfo['week']);

        // 受付時間取得
        $basic['reception_time'] = json_decode($this->_getfield('setting','val',['key'=>'reception_time']));

        // 時間間隔（分）
        $basic['interval'] = 15;

        // 曜日別営業時間
        $arr = explode('-', $shopInfo['hours']);
        $hours_st = $arr[0];
        $hours_ed = $arr[1];

        $weekHoursColumnNames = 
                array('mon_st_hours','mon_ed_hours','tue_st_hours','tue_ed_hours','wed_st_hours',
                    'wed_ed_hours','thu_st_hours','thu_ed_hours','fri_st_hours','fri_ed_hours',
                    'sat_st_hours','sat_ed_hours','sun_st_hours','sun_ed_hours');
        $hours = array();
        foreach($weekHoursColumnNames as $col){
            if(empty($shopInfo[$col])){
                if(strpos($col, '_ed_hours') === false){
                    $hours[$col] = $hours_st;
                }else{
                    $hours[$col] = $hours_ed;
                }
            }else{
                $hours[$col] = $shopInfo[$col];
            }
        }
        $basic['hours'] = $hours;

        if($item_id){
            // 施術時間
            $pack_item = $this->_getrow(['pack_item as a', ['trade_pack_item as b', " a.id=b.pack_item_id"]], 'a.*', ['b.id'=>$item_id]);

            $treatmentTime = $pack_item['interval_time'];
            if(!empty($pack_item['treatment_time'])){
                $treatmentTime = $pack_item['treatment_time'];
            }
            $basic['treatment_time'] = $treatmentTime;
        }

        $this->_return(1, 'success', array_values($basic));
    }

    /**
     * 予約不可時間の取得
     */
    public function get_forbid_reservation_time(){
        // POST
        $trade_id = $this->input->post('trade_id');
        $item_id = $this->input->post('item_id');
        // パラメータチェック
        if(!$trade_id){
            $this->_return(-1,'パラメータがありません');
        }
        // 購入情報取得
        $trade = $this->_getrow('trade','*',['id'=>$trade_id]);
        if(!$trade){
            $this->_return(-1,'注文が見つかりません');
        }
        $shopId = $trade['adminid'];

        // 商品情報取得
        $pack_item = $this->_getrow(['pack_item as a', ['trade_pack_item as b', " a.id=b.pack_item_id"]], 'a.*', ['b.id'=>$item_id]);

        // 商品から対象デバイスの台数確認
        $mrTypeToDeviceSonTypeList = array(1 => 5, 2 => 1, 3 => 4); // TODO マスタでの紐付けを持つようにすべき
        $mrType = intval($pack_item['mr_type']);
        
        // デバイス数の取得
        $deviceNum = $this->_getfield('shop_device_admin', 'device_count', 'admin_id='.$shopId.' and device_son_type_id='.$mrTypeToDeviceSonTypeList[$mrType]);
        if($deviceNum == 0){
            $this->_return(0,'店舗にデバイスがないため予約できません');
        }

        // 予約状況確認
        $mrTypes = '';
        if($mrType === 1 || $mrType === 3){
            // ハイフボディと高周波は一つの個室にあるため、ボディと高周波はカレンダーを共有
            $mrTypes = '1,3';
        }elseif($mrType === 2){
            $mrTypes = '2';
        }

        // 該当商品の商品詳細ID取得
        $targetPackItemIdList = $this->_getlist(['pack_item as a', ['pack as b', " a.pack_id = b.id"]], 
                        'a.id, a.interval_time, a.treatment_time',
                        'a.mr_type in ('.$mrTypes.') and b.adminid = '.$shopId);
        $targetPackItemIds = '';
        $targetPackItemInfoList = array();
        foreach($targetPackItemIdList as $p){
            if(empty($targetPackItemIds)){
                $targetPackItemIds = $p['id'];
            }else{
                $targetPackItemIds .= ','.$p['id'];
            }
            $targetPackItemInfoList[$p['id']] = $p;
        }

        // 購入商品情報取得
        $targetTradePackItemIds = '';
        $targetTradePackItemIdList = $this->_getlist('trade_pack_item', '*', "pack_item_id in (".$targetPackItemIds.")");
        $convPackItemArray = array();
        foreach($targetTradePackItemIdList as $p){
            if(empty($targetTradePackItemIds)){
                $targetTradePackItemIds = $p['id'];
            }else{
                $targetTradePackItemIds .= ','.$p['id'];
            }
            $convPackItemArray[$p['id']] = $p['pack_item_id'];
        }

        // 予約状況取得
        $noReservationDateList = array();
        $time = date('Y-m-d H:i:s');
        // reservation の pack_item_id は trade_pack_itemのidのこと
        $reservationInfoList = $this->_getlist('reservation', '*', 
                        " status!=2 and shop_id=".$shopId." and start_time>'".$time."' and pack_item_id in (".$targetTradePackItemIds.")");
        foreach($reservationInfoList as $k=>$v){
            // 予約不可時間帯情報
            $noReservationDateInfo = array();
            // 施術時間の取得
            $targetPackItem = $targetPackItemInfoList[$convPackItemArray[$v['pack_item_id']]];
            $treatmentTime = $targetPackItem['interval_time'];
            if(!empty($targetPackItem['treatment_time'])){
                $treatmentTime = $targetPackItem['treatment_time'];
            }
            // 開始時間と終了時間の算出
            $startTime = new DateTime($v['start_time']);
            $endTime = clone $startTime;
            $endTime->modify('+'.$treatmentTime.' minute');
            $noReservationDateInfo['start_time'] = $startTime->format('Y-m-d H:i');
            $noReservationDateInfo['end_time'] = $endTime->format('Y-m-d H:i');

            $noReservationDateList[] = $noReservationDateInfo;
        }

        $reservationDeviceNumInfoList = $this->_getlist('reservation',
                ['count(1) as count,start_time','start_time'],
                " status!=2 and shop_id=".$shopId." and start_time>'".$time."'");
        foreach($reservationDeviceNumInfoList as $k=>$v){
            // 台数を確認し、台数より予約が少なければ予約可能なので対象外
            if($v['count']<$deviceNum){
                foreach($noReservationDateList as $key=>$val){
                    $targetDate = new DateTime($v['start_time']);
                    $repairDate = new DateTime($val['start_time']);
                    if($targetDate == $repairDate){
                        unset($noReservationDateList[$key]);
                    }
                }
            }
        }

        // 休憩時間を予約不可情報に追加
        $restList = $this->_getlist('shop_rest', '*', "admin_id=".$shopId." and rest_ed_date>'".$time."'");
        foreach($restList as $k=>$v){
            $restInfo = array();
            $startDate = new DateTime($v['rest_st_date']);
            $endDate = new DateTime($v['rest_ed_date']);
            $restInfo['start_time'] = $startDate->format('Y-m-d H:i');
            $restInfo['end_time'] = $endDate->format('Y-m-d H:i');
            $noReservationDateList[] = $restInfo;
        }

        $this->_return(1, 'success', array_values($noReservationDateList));
    }

    /**
     * 予約可否チェック
     * ※現在未使用
     */
    public function check_reservation_time(){
        $trade_id=$this->input->post('trade_id');
        $time=$this->input->post('time');
        $item_id=$this->input->post('item_id');

        if(!$trade_id) $this->_return(-1,'缺少参数 trade_id');
        if(!$time) $this->_return(-1,'请选择预约时间');

        if(strtotime($time)>strtotime('+ 3 month')) $this->_return(0,'只能预约3个月以内的时间');
        if(strtotime($time)<time()) $this->_return(0,'预约时间不能小于当前时间');
        $trade=$this->_getrow('trade','*',['id'=>$trade_id]);
        if(!$trade) $this->_return(0,'没有找到订单');
        if($trade['status']<=0) $this->_return(0,'订单状态错误');
        if($trade['status']>2) $this->_return(0,'订单已使用完成');
        if(strtotime($time)>strtotime($trade['end_time']))$this->_return(0,'您预约的时间已超过订单过期时间') ;
        $where=" status =0 and shop_id=".$trade['adminid'];
        $device_where="adminid=".$trade['adminid'];
        if($item_id){
            $pack_item=$this->_getrow(['pack_item as a',['trade_pack_item as b'," a.id=b.pack_item_id"]],'a.*',['b.id'=>$item_id]);
            if(!$pack_item) $this->_return(0,'item_id 参数错误');
            $where.=" and start_time between '".date('Y-m-d H:i:s',strtotime($time))."' and '".date('Y-m-d H:i:s',strtotime($time))."' and types='".$pack_item['type'].','."'";
            $device_where.=" and type=".$pack_item['type'];
        }else{
            $where.=" and start_time='".$time."'";
        }
        //$shop=$this->_getrow('admin','*',['id'=>$trade['adminid']]);
        //获取商家设备数量
        $device_num=$this->_getfield('device','count(1)',$device_where);
        //获取当前时间 商家预约数量
        $reservation_num=$this->_getfield('reservation','count(1)',$where);
        if($device_num==0)$this->_return(0,'商家未绑定设备不能预约');
        //echo $this->db->last_query();
        if($reservation_num>=$device_num){
            //获取可预约的时间点
            if ($pack_item['treatment_time']) {
                $treatment_time = $pack_item['treatment_time'];
            } else {
                $treatment_time = $pack_item['interval_time'];
            }
            $start_time=date('Y-m-d H:i:s',strtotime($time)+$treatment_time*60);
            $end_time=date('Y-m-d H:i:s',strtotime($time)+$treatment_time*120);
            $use_time="";//可预约时间
            for($i=0;$i<=4320;$i++){//三个月内的半小时
                if($i>0) {
                    $start_time=date("Y-m-d H:i:s",strtotime($start_time)+($i*$treatment_time*60));
                    $end_time=date("Y-m-d H:i:s",strtotime($end_time)+($i*$treatment_time*60));
                }
                $select_where="status=0 and shop_id=".$trade['adminid']." and types='".$pack_item['type'].','."' and start_time between '".$start_time."' and '".$end_time."'";
                $reservation_num=$this->_getfield('reservation','count(1)',$select_where);
                //echo $this->db->last_query();
                if($reservation_num<$device_num) {
                    $use_time=$start_time;
                    break;
                }
            }
            if($use_time){
                $this->_return(0,'当前时间段不可预约，可预约：'.$use_time);
            }else{
                $this->_return(0,'当前时间段商家设备已没有空闲设备可以使用');
            }

        }
        $this->_return(1,'当前时间可预约');
    }

    /**
     * 予約実行
     */
    public function reservation(){
        // POST
        $trade_id = $this->input->post('trade_id');
        $item_ids = trim($this->input->post('item_ids'),',');
        $time = $this->input->post('time');
        $remark = $this->input->post('remark');
        $phone = $this->input->post('phone');

        // パラメータチェック
        if(!$trade_id) $this->_return(-1,'パラメータがありません');
        if(!$time) $this->_return(-1,'予約時間を選択してください');
        if(!$phone) $this->_return(-1,'携帯電話番号を入力してください');
        if(strtotime($time)>strtotime('+ 3 month')) $this->_return(0,'3か月以内にのみ予約できます');
        if(strtotime($time)<time()) $this->_return(0,'予約時間は現在の時間より短くすることはできません');
        if(!$item_ids) $this->_return(-1,'予約を選択してください');

        // 購入情報取得
        $trade = $this->_getrow('trade','*',['id'=>$trade_id]);
        if(!$trade) $this->_return(0, '注文が見つかりません');
        if($trade['status'] <= 0) $this->_return(0, '注文状況エラー');
        if($trade['status'] > 2) $this->_return(0, '注文が完了しています');
        $shopId = $trade['adminid'];

        // 休業日チェック
        $targetDate = new DateTime($time);
        $dayOfWeek = (int)$targetDate->format('w');
        $week = explode(',',$this->_getfield('admin','week',['id'=>$trade['adminid']]));
        if($week[$dayOfWeek] == 1) $this->_return(0,'今日は予約できません');
        // 予約可能回数チェック
        $check = $this->_getfield('trade_pack_item','id',"id in($item_ids) and (num-use_num)<=0");
        if($check) $this->_return(0, '予約上限回数に達しました（'.$item_ids.'）');
        if(strtotime($time)>strtotime($trade['end_time'])) $this->_return(0,'予約時間が注文の有効期限を超えました') ;
        // ユーザチェック
        $user=$this->_get();
        if($trade['user_id']!=$user['id']) $this->_return(0, '不正なユーザです');

        // 予約不可情報取得
        // 商品情報取得
        $pack_item = $this->_getrow(['pack_item as a', ['trade_pack_item as b', " a.id=b.pack_item_id"]], 'a.*', ['b.id'=>$item_ids]);
        // 商品から対象デバイスの台数確認
        $mrTypeToDeviceSonTypeList = array(1 => 5, 2 => 1, 3 => 4); // TODO マスタでの紐付けを持つようにすべき
        $mrType = intval($pack_item['mr_type']);
        
        // デバイス数の取得
        $deviceNum = $this->_getfield('shop_device_admin', 'device_count', 'admin_id='.$shopId.' and device_son_type_id='.$mrTypeToDeviceSonTypeList[$mrType]);
        if($deviceNum == 0){
            $this->_return(0,'店舗にデバイスがないため予約できません');
        }

        // 予約状況確認
        $mrTypes = '';
        if($mrType === 1 || $mrType === 3){
            // ハイフボディと高周波は一つの個室にあるため、ボディと高周波はカレンダーを共有
            $mrTypes = '1,3';
        }elseif($mrType === 2){
            $mrTypes = '2';
        }

        // 該当商品の商品詳細ID取得
        $targetPackItemIdList = $this->_getlist(['pack_item as a', ['pack as b', " a.pack_id = b.id"]], 
                        'a.id, a.interval_time, a.treatment_time',
                        'a.mr_type in ('.$mrTypes.') and b.adminid = '.$shopId);
        $targetPackItemIds = '';
        $targetPackItemInfoList = array();
        foreach($targetPackItemIdList as $p){
            if(empty($targetPackItemIds)){
                $targetPackItemIds = $p['id'];
            }else{
                $targetPackItemIds .= ','.$p['id'];
            }
            $targetPackItemInfoList[$p['id']] = $p;
        }

        // 購入商品情報取得
        $targetTradePackItemIds = '';
        $targetTradePackItemIdList = $this->_getlist('trade_pack_item', '*', "pack_item_id in (".$targetPackItemIds.")");
        $convPackItemArray = array();
        foreach($targetTradePackItemIdList as $p){
            if(empty($targetTradePackItemIds)){
                $targetTradePackItemIds = $p['id'];
            }else{
                $targetTradePackItemIds .= ','.$p['id'];
            }
            $convPackItemArray[$p['id']] = $p['pack_item_id'];
        }

        // 予約状況取得
        $noReservationDateList = array();
        $nowtime = date('Y-m-d H:i:s');
        // reservation の pack_item_id は trade_pack_itemのidのこと
        $reservationInfoList = $this->_getlist('reservation', '*', 
                        " status!=2 and shop_id=".$shopId." and start_time>'".$nowtime."' and pack_item_id in (".$targetTradePackItemIds.")");
        foreach($reservationInfoList as $k=>$v){
            // 予約不可時間帯情報
            $noReservationDateInfo = array();
            // 開始時間と終了時間の算出
            $targetPackItem = $targetPackItemInfoList[$convPackItemArray[$v['pack_item_id']]];
            // 施術時間の取得
            $treatmentTime = $targetPackItem['interval_time'];
            if(!empty($targetPackItem['treatment_time'])){
                $treatmentTime = $targetPackItem['treatment_time'];
            }

            $startTime = new DateTime($v['start_time']);
            $endTime = clone $startTime;
            $endTime->modify('+'.$treatmentTime.' minute');
            $noReservationDateInfo['start_time'] = $startTime;
            $noReservationDateInfo['end_time'] = $endTime;

            $noReservationDateList[] = $noReservationDateInfo;
        }

        $reservationDeviceNumInfoList = $this->_getlist('reservation',
                        ['count(1) as count,start_time','start_time'],
                        " status!=2 and shop_id=".$shopId." and start_time>'".$nowtime."'");
        foreach($reservationDeviceNumInfoList as $k=>$v){
            // 台数を確認し、台数より予約が少なければ予約可能なので対象外
            if($v['count']<$deviceNum){
                foreach($noReservationDateList as $key=>$val){
                    $targetDate = new DateTime($v['start_time']);
                    $repairDate = new DateTime($val['start_time']);
                    if($targetDate == $repairDate){
                        unset($noReservationDateList[$key]);
                    }
                }
            }
        }

        // 休憩時間を予約不可情報に追加
        $restList = $this->_getlist('shop_rest', '*', "admin_id=".$shopId." and rest_ed_date>'".$nowtime."'");
        foreach($restList as $k=>$v){
            $restInfo = array();
            $restInfo['start_time'] = new DateTime($v['rest_st_date']);
            $restInfo['end_time'] = new DateTime($v['rest_ed_date']);
            $noReservationDateList[] = $restInfo;
        }

        // 予約可否チェック
        // 選択された予約時間
        $userTreatmentTime = $pack_item['interval_time'];
        if(!empty($pack_item['treatment_time'])){
            $userTreatmentTime = $pack_item['treatment_time'];
        }
        $userStartDate = new DateTime($time);
        $userEndDate = clone $userStartDate;
        $userEndDate->modify('+'.$userTreatmentTime.' minute');

        // 予約不可時間に該当した場合は予約不可
        foreach($noReservationDateList as $k=>$v){
            if(($v['start_time'] < $userStartDate && $userStartDate < $v['end_time'])
                || ($v['start_time'] < $userEndDate && $userEndDate < $v['end_time'])){
                $this->_return(-1,'予約が入っているため、予約できませんでした。');
            }
        }

        // 予約情報作成
        $item_arr=explode(',',$item_ids);
        $use_status='';
        $mr_num = 0;
        $tm_num = 0;
        for($i=0; $i<count($item_arr); $i++){
            $pack_item_type = $this->_getfield('pack_item','type',['id'=>$item_arr[$i]]);
            if($pack_item_type == 1) $mr_num+=1;
            if($pack_item_type == 2) $tm_num+=1;
            $use_status.='0,';
        }
        $types = '';
        if($mr_num) $types .= "1,";
        if($tm_num) $types .= "2,";

        // トランザクション開始
        $this->db->trans_start();
        // 予約情報登録
        $this->db->insert('reservation',[
            'user_id'=>$user['id'],
            'start_time'=>$time,
            'pack_item_id'=>$item_ids,
            'use_status'=>trim($use_status,','),
            'trade_id'=>$trade['id'],
            'shop_id'=>$trade['adminid'],
            'mr_num'=>$mr_num,
            'tm_num'=>$tm_num,
            'types'=>$types,
            'phone'=>$phone,
            'remark'=>$remark?:"",
            'ctime'=>date('Y-m-d H:i:s')
        ]);
        $reservation_id=$this->db->insert_id();

        // 注文ステータス更新（予約済み（使用待ち））
        $this->db->update('trade',['status'=>2,"reservation_id"=>$reservation_id],['id'=>$trade['id']]);
        // 使用回数更新
        $this->db->set('use_num','use_num+1',false)->where("id in($item_ids)")->update('trade_pack_item');
        // トランザクション終了
        $this->db->trans_complete();
        $this->_return(1,'時間内にご利用ください',['trade_id'=>$trade_id]);
    }

    /**
     * サブスク予約実行
     */
    public function reservation_subsc(){
        // POST
        $trade_id = $this->input->post('trade_id');
        $items = $this->input->post('items');
        $remark = $this->input->post('remark');
        $phone = $this->input->post('phone');

        // パラメータチェック
        if(!$trade_id) $this->_return(-1,'パラメータがありません');
        if(!$phone) $this->_return(-1,'携帯電話番号を入力してください');

        // 購入情報取得
        $trade=$this->_getrow('trade','*',['id'=>$trade_id]);
        if(!$trade) $this->_return(0,'注文が見つかりません');
        if($trade['status'] <= 0) $this->_return(0,'注文状況エラー');
        if($trade['status'] > 2) $this->_return(0,'注文が完了しています');
        $shopId = $trade['adminid'];

        // ユーザチェック
        $user = $this->_get();
        if($trade['user_id'] != $user['id']) $this->_return(0, '不正なユーザです');

        foreach(json_decode($items) as $item) {
            $item_id = $item[0];
            $time = $item[1];

            // 休業日チェック
            $targetDate = new DateTime($time);
            $dayOfWeek = (int)$targetDate->format('w');
            $week = explode(',',$this->_getfield('admin','week',['id'=>$trade['adminid']]));
            if($week[$dayOfWeek]==1) $this->_return(0,'今日は予約できません');
            
            // 予約不可情報取得
            // 商品情報取得
            $pack_item = $this->_getrow(['pack_item as a', ['trade_pack_item as b', " a.id=b.pack_item_id"]], 'a.*', ['b.id'=>$item_id]);

            // 商品から対象デバイスの台数確認
            $mrTypeToDeviceSonTypeList = array(1 => 5, 2 => 1, 3 => 4); // TODO マスタでの紐付けを持つようにすべき
            $mrType = intval($pack_item['mr_type']);
            
            // デバイス数の取得
            $deviceNum = $this->_getfield('shop_device_admin', 'device_count', 'admin_id='.$shopId.' and device_son_type_id='.$mrTypeToDeviceSonTypeList[$mrType]);
            if($deviceNum == 0){
                $this->_return(0,'店舗にデバイスがないため予約できません');
            }

            // 予約状況確認
            $mrTypes = '';
            if($mrType === 1 || $mrType === 3){
                // ハイフボディと高周波は一つの個室にあるため、ボディと高周波はカレンダーを共有
                $mrTypes = '1,3';
            }elseif($mrType === 2){
                $mrTypes = '2';
            }

            // 該当商品の商品詳細ID取得
            $targetPackItemIdList = $this->_getlist(['pack_item as a', ['pack as b', " a.pack_id = b.id"]], 
                            'a.id, a.interval_time, a.treatment_time',
                            'a.mr_type in ('.$mrTypes.') and b.adminid = '.$shopId);
            $targetPackItemIds = '';
            $targetPackItemInfoList = array();
            foreach($targetPackItemIdList as $p){
                if(empty($targetPackItemIds)){
                    $targetPackItemIds = $p['id'];
                }else{
                    $targetPackItemIds .= ','.$p['id'];
                }
                $targetPackItemInfoList[$p['id']] = $p;
            }

            // 購入商品情報取得
            $targetTradePackItemIds = '';
            $targetTradePackItemIdList = $this->_getlist('trade_pack_item', '*', "pack_item_id in (".$targetPackItemIds.")");
            $convPackItemArray = array();
            foreach($targetTradePackItemIdList as $p){
                if(empty($targetTradePackItemIds)){
                    $targetTradePackItemIds = $p['id'];
                }else{
                    $targetTradePackItemIds .= ','.$p['id'];
                }
                $convPackItemArray[$p['id']] = $p['pack_item_id'];
            }

            // 予約状況取得
            $noReservationDateList = array();
            $nowtime = date('Y-m-d H:i:s');
            // reservation の pack_item_id は trade_pack_itemのidのこと
            $reservationInfoList = $this->_getlist('reservation', '*', 
                            " status!=2 and shop_id=".$shopId." and start_time>'".$nowtime."' and pack_item_id in (".$targetTradePackItemIds.")");
            foreach($reservationInfoList as $k=>$v){
                // 予約不可時間帯情報
                $noReservationDateInfo = array();
                // 開始時間と終了時間の算出
                $targetPackItem = $targetPackItemInfoList[$convPackItemArray[$v['pack_item_id']]];
                // 施術時間の取得
                $treatmentTime = $targetPackItem['interval_time'];
                if(!empty($targetPackItem['treatment_time'])){
                    $treatmentTime = $targetPackItem['treatment_time'];
                }

                $startTime = new DateTime($v['start_time']);
                $endTime = clone $startTime;
                $endTime->modify('+'.$treatmentTime.' minute');
                $noReservationDateInfo['start_time'] = $startTime;
                $noReservationDateInfo['end_time'] = $endTime;

                $noReservationDateList[] = $noReservationDateInfo;
            }

            $reservationDeviceNumInfoList = $this->_getlist('reservation',
                    ['count(1) as count,start_time','start_time'],
                    " status!=2 and shop_id=".$shopId." and start_time>'".$nowtime."'");
            foreach($reservationDeviceNumInfoList as $k=>$v){
                // 台数を確認し、台数より予約が少なければ予約可能なので対象外
                if($v['count']<$deviceNum){
                    foreach($noReservationDateList as $key=>$val){
                        $targetDate = new DateTime($v['start_time']);
                        $repairDate = new DateTime($val['start_time']);
                        if($targetDate == $repairDate){
                            unset($noReservationDateList[$key]);
                        }
                    }
                }
            }

            // 休憩時間を予約不可情報に追加
            $restList = $this->_getlist('shop_rest', '*', "admin_id=".$shopId." and rest_ed_date>'".$nowtime."'");
            foreach($restList as $k=>$v){
                $restInfo = array();
                $restInfo['start_time'] = new DateTime($v['rest_st_date']);
                $restInfo['end_time'] = new DateTime($v['rest_ed_date']);
                $noReservationDateList[] = $restInfo;
            }

            // 予約可否チェック
            // 選択された予約時間
            $userTreatmentTime = $pack_item['interval_time'];
            if(!empty($pack_item['treatment_time'])){
                $userTreatmentTime = $pack_item['treatment_time'];
            }
            $userStartDate = new DateTime($time);
            $userEndDate = clone $userStartDate;
            $userEndDate->modify('+'.$userTreatmentTime.' minute');

            // 予約不可時間に該当した場合は予約不可
            foreach($noReservationDateList as $k=>$v){
                if(($v['start_time'] < $userStartDate && $userStartDate < $v['end_time'])
                    || ($v['start_time'] < $userEndDate && $userEndDate < $v['end_time'])){
                    $this->_return(-1,'予約が入っているため、予約できませんでした。');
                }
            }
        }

        // トランザクション開始
        $this->db->trans_start();

        foreach(json_decode($items) as $item) {
            $item_id = $item[0];
            $time = $item[1];

            // 予約状況チェック
            if(strtotime($time)>strtotime('+ 3 month')) $this->_return(0,'3か月以内にのみ予約できます');
            if(strtotime($time)<time()) $this->_return(0,'予約時間は現在の時間より短くすることはできません');
            $check=$this->_getfield('trade_pack_item','id',"id = $item_id and (num-use_num)<=0");
            if($check) $this->_return(0,'予約上限回数に達しました（'.$item_id.'）');
            if(strtotime($time)>strtotime($trade['end_time']))$this->_return(0,'予約時間が注文の有効期限を超えました') ;

            // 予約情報作成
            $use_status = '';
            $mr_num = 0;
            $tm_num = 0;
            $pack_item_type = $this->_getfield('pack_item','type',['id'=>$item_id]);
            if($pack_item_type == 1) $mr_num += 1;
            if($pack_item_type == 2) $tm_num += 1;
            $use_status .= '0';
            $types = '';
            if($mr_num) $types .= "1,";
            if($tm_num) $types .= "2,";

            // 予約情報登録
            $this->db->insert('reservation',[
                'user_id' => $user['id'],
                'start_time' => $time,
                'pack_item_id' => $item_id,
                'use_status' => trim($use_status,','),
                'trade_id' => $trade['id'],
                'shop_id' => $trade['adminid'],
                'mr_num' => $mr_num,
                'tm_num' => $tm_num,
                'types' => $types,
                'phone' => $phone,
                'remark' => $remark ? : "",
                'ctime' => date('Y-m-d H:i:s')
            ]);
            $reservation_id = $this->db->insert_id();
            //注文ステータス更新（予約済み（使用待ち））
            $this->db->update('trade',['status'=>2,"reservation_id"=>$reservation_id],['id'=>$trade['id']]);
            //使用回数更新
            $this->db->set('use_num','use_num+1',false)->where("id in($item_id)")->update('trade_pack_item');
        }

        // トランザクション終了
        $this->db->trans_complete();
        $this->_return(1,'時間内にご利用ください',['trade_id'=>$trade_id]);
    }

    /**
     * 予約ページ
     */
    public function use_reservation_page(){
        $trade_id=$this->input->post('trade_id');
        $user=$this->_get();
        if(!$trade_id) $this->_return(-1,"缺少参数 trade_id");
        $trade=$this->_getrow('trade','*',['id'=>$trade_id]);
        if(!$trade) $this->_return(0,'trade_id 参数错误');
        if($trade['user_id']!=$user['id']) $this->_return(0,'订单只能本人使用');
        $shop=$this->_getrow('admin','nickname,address',['id'=>$trade['adminid']]);
        //获取预约单
        $reservation=$this->_getrow('reservation','*',['id'=>$trade['reservation_id']]);
        if(!$reservation) $this->_return(0,'数据错误');
        $arr_item_id=explode(',',$reservation['pack_item_id']);
        $arr_use_status=explode(',',$reservation['use_status']);
        //生成二维码
        $arr=[];
        for($i=0;$i<count($arr_item_id);$i++){
            $item_id=$this->_getfield('trade_pack_item','pack_item_id',['id'=>$arr_item_id[$i]])?:0;
            $pack_item=$this->_getrow('pack_item','title,type',['id'=>$item_id])?:"";
            $arr[]=['qr'=>base_url("user_api/item_qrcode/".$arr_item_id[$i]."/".$reservation['id']),'status'=>$arr_use_status[$i],'title'=>$pack_item['title'],'type'=>$pack_item['type']];
        }
        $item_ids=$this->_getcol('trade_pack_item','pack_item_id',"id in(".$reservation['pack_item_id'].")")?:[0];
        $item=$this->_getlist('pack_item','title,knife',"id in(".implode(',',$item_ids).")");
        $data=[
            'polling_id'=>$reservation['id'],
            'nickname'=>$shop['nickname']?:"",
            'address'=>$shop['address']?:"",
            'reservation_time'=>$reservation['start_time'],
            'item'=>$item,
            'qr'=>$arr,
            'pay_token'=>$trade['pay_token']
        ];
        $this->_return(1,'获取成功',$data);
    }

    //预约使用页面
    public function use_reservation_subsc_page(){
        $trade_id=$this->input->post('trade_id');
        $user=$this->_get();
        if(!$trade_id) $this->_return(-1,"缺少参数 trade_id");
        $trade=$this->_getrow('trade','*',['id'=>$trade_id]);
        if(!$trade) $this->_return(0,'trade_id 参数错误');
        if($trade['user_id']!=$user['id']) $this->_return(0,'订单只能本人使用');
        $shop=$this->_getrow('admin','nickname,address',['id'=>$trade['adminid']]);
        //获取预约单
        $reservations=$this->_getlist('reservation','*',['trade_id'=>$trade['id'], 'status'=>0]);
        if(!$reservations) $this->_return(0,'数据错误');
        $pollings = [];
        $qrs = [];
        $items = [];
        $times = [];
        foreach($reservations as $reservation) {
            $item_id=$reservation['pack_item_id'];
            $status=$reservation['status'];
            //生成二维码
            $arr=[];
            $pack_item_id=$this->_getfield('trade_pack_item','pack_item_id',['id'=>$item_id])?:0;
            $pack_item=$this->_getrow('pack_item','title,type',['id'=>$pack_item_id])?:"";
            $qr =['qr'=>base_url("user_api/item_qrcode/".$item_id."/".$reservation['id']),'status'=>$status,'title'=>$pack_item['title'],'type'=>$pack_item['type']];
            $qrs[] = $qr;
            $item_id=$this->_getfield('trade_pack_item','pack_item_id',"id = ".$reservation['pack_item_id'])?:0;
            $item=$this->_getrow('pack_item','title,knife, id as pack_item_id',"id in(".$item_id.")");
            $item['polling_id']=$reservation['id'];
            $item['reservation_time']=$reservation['start_time'];
            $item['qr']=$qr;
            array_push($pollings, $reservation['id']);
            array_push($items, $item);
            array_push($times, $reservation['start_time']);

            // array_push($qrs, $arr);
        }
        $data=[
            'polling_ids'=>$pollings,
            'nickname'=>$shop['nickname']?:"",
            'address'=>$shop['address']?:"",
            'reservation_times'=>$times,
            'items'=>$items,
            'qrs'=>$qrs
        ];
        $this->_return(1,'获取成功',$data);
    }
    //获取使用指引
    public function get_user_guide(){
        $type=$this->input->post('type');
        if(!in_array($type,[1,2])) $this->_return(-1,'type 参数错误');
        if($type==1) $data=  str_ireplace('/upload/', base_url() . 'upload/', $this->setting_mdl->get('mr'));
        if($type==2) $data=  str_ireplace('/upload/', base_url() . 'upload/', $this->setting_mdl->get('tm'));
        $this->_return(1,'获取成功',$data);
    }
    //取消预约
    public function cancel_reservation(){
        $trade_id=$this->input->post('trade_id');
        if(!$trade_id ) $this->_return(-1,'缺少参数 trade_id');
        $user=$this->_get();
        $trade=$this->_getrow('trade','*',['id'=>$trade_id]);
        if(!$trade) $this->_return(0,'trade_id 参数错误');
        if($trade['status']!=2) $this->_return(0,'订单状态错误');
        if($trade['user_id']!=$user['id']) $this->_return(0,'不能操作被人的订单');
        //获取预约信息
        $reservation=$this->_getrow('reservation','*',['id'=>$trade['reservation_id']]);
        if(!$reservation) $this->_return(0,'没有找到预约信息');
        if($reservation['status']!=0) $this->_return(0,'预约信息 状态错误');
        $arr_use_status=explode(',',$reservation['use_status']);
        if(in_array(1,$arr_use_status)) $this->_return(0,'已使用不能取消');
        if(strtotime(date('Y-m-d H:i:s',strtotime($reservation['start_time']))) - 10800 < strtotime(date('Y-m-d H:i:s'))){//当天取消的要扣掉使用次数
            $this->_return(-2,'当天不能取消');
        }else{//提前结束 退还使用次数
            $this->db->set('use_num',"use_num-1",false)->where('id in('.$reservation['pack_item_id'].")")->update('trade_pack_item');
            $status=1;
        }
        $trade_arr=['status'=>$status];
        if($status==4) $trade_arr['success_time']=date('Y-m-d H:i:s');
        //修改订单状态
        $this->db->update('trade',$trade_arr,['id'=>$trade['id']]);
        //log_message('error',$this->db->last_query());
        //修改预约单状态
        $this->db->update('reservation',['status'=>2],['id'=>$reservation['id']]);
        $this->_return(1,'取消成功');
    }

    
    //取消预约
    public function cancel_reservation_subsc(){
        $trade_id=$this->input->post('trade_id');
        if(!$trade_id ) $this->_return(-1,'缺少参数 trade_id');
        $reservation_id = $this->input->post('reservation_id');
        if(!$reservation_id ) $this->_return(-1,'缺少参数 reservation_id');
        $user=$this->_get();
        $trade=$this->_getrow('trade','*',['id'=>$trade_id]);
        if(!$trade) $this->_return(0,'trade_id 参数错误');
        // if($trade['status']!=2) $this->_return(0,'订单状态错误');
        if($trade['user_id']!=$user['id']) $this->_return(0,'不能操作被人的订单');
        //获取预约信息
        $reservation=$this->_getrow('reservation','*',['id'=>$reservation_id]);
        if(!$reservation) $this->_return(0,'没有找到预约信息');
        if($reservation['status']!=0) $this->_return(0,'预约信息 状态错误');
        $use_status=$reservation['use_status'];
        if(in_array(1,$use_status)) $this->_return(0,'已使用不能取消');
        //判断是到使用那天之前取消的还是其它时间取消
        // $start_date = date_create($reservation['start_time']);
        // date_add($start_date, date_interval_create_from_date_string("2 hours"));
        // if ($start_date < date_create()) {
        //     $this->_return(-2,'当天不能取消');
        // }
        // $this->_return(strtotime(date('Y-m-d H:i:s',strtotime($reservation['start_time']))) - 7200, strtotime(date('Y-m-d H:i:s')));
        if(strtotime(date('Y-m-d H:i:s',strtotime($reservation['start_time']))) - 10800 < strtotime(date('Y-m-d H:i:s'))){//当天取消的要扣掉使用次数
            $this->_return(-2,'当天不能取消');
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
            }else{
                $status=1;
            }*/
        }else{//提前结束 退还使用次数
            $this->db->set('use_num',"use_num-1",false)->where('id ='.$reservation['pack_item_id'])->update('trade_pack_item');
            $status=1;
        }
        $trade_arr=['status'=>$status];
        if($status==4) $trade_arr['success_time']=date('Y-m-d H:i:s');
        //修改订单状态
        // $this->db->update('trade_pack_item',$trade_arr,['id'=>$trade_pack_item['id']]);
        //log_message('error',$this->db->last_query());
        //修改预约单状态
        $this->db->update('reservation',['status'=>2],['id'=>$reservation['id']]);
        $this->_return(1,'取消成功');
    }


    //已取消页面
    public function cancel_reservation_page(){
        $trade_id=$this->input->post('trade_id');
        if(!$trade_id ) $this->_return(-1,'缺少参数 trade_id');
        $user=$this->_get();
        $trade=$this->_getrow('trade','*',['id'=>$trade_id]);
        if(!$trade) $this->_return(0,'trade_id 参数错误');
        //获取预约信息
        $reservation=$this->_getrow('reservation','*',['id'=>$trade['reservation_id']]);
        $shop=$this->_getrow('admin','id ,nickname,address',['id'=>$trade['adminid']]);
        $item_ids=$this->_getcol('trade_pack_item','pack_item_id',"id in(".$reservation['pack_item_id'].")")?:[0];
        $item=$this->_getlist('pack_item','title,knife',"id in(".implode(',',$item_ids).")");
        $data=[
            'nickname'=>$shop['nickname']?:"",
            'address'=>$shop['address']?:"",
            'reservation_time'=>$reservation['start_time'],
            'item'=>$item
        ];
        $this->_return(1,'获取成功',$data);
    }

    //扫码使用
    public function scan_use(){
        $param=$this->input->post('param');
        if(!$param) $param=$this->input->get('param');
        if(!$param) $this->_return(-1,'缺少参数');
        $arr=explode('|',$param);
        $reservation=$this->_getrow('reservation','*',['id'=>$arr[1]]);
        if(!$reservation) $this->_return(0,'请扫正确的二维码');
        $arr_item_id=explode(',',$reservation['pack_item_id']);
        $arr_use_status=explode(',',$reservation['use_status']);
        $key='';
        for($i=0;$i<count($arr_item_id);$i++){
            if($arr_item_id[$i]==$arr[0]) $key=$i;
        }
        if(!is_numeric($key)) $this->_return(0,'请扫正确的二维码');
        if($arr_use_status[$key]==1) $this->_return(0,'当前二维码已使用，请扫其它二维码');
        if(strtotime(date('Y-m-d',strtotime($reservation['start_time'])))!=strtotime(date('Y-m-d'))) $this->_return(0,'未到预约日期');
        $arr_use_status[$key]=1;//已使用

        if(!in_array(0,$arr_use_status)){
            //判断订单是否已经使用完
            $is_success=$this->_getfield('trade_pack_item','id',"(num-use_num)>0 and trade_id=".$reservation['trade_id']);
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
            }else{//修改订单为待预约 因为还有套餐项目没使用
                $status=1;
            }
            $trade_arr=['status'=>$status];
            if($status==4) $trade_arr['success_time']=date('Y-m-d H:i:s');
            $this->db->update('trade',$trade_arr,['id'=>$trade['id']]);
        }
        //更新使用状态
        $data=['use_status'=>implode(',',$arr_use_status),'status'=>1];
        $this->db->update('reservation',$data,['id'=>$reservation['id']]);
        //获取套餐项目
        $item_id=$this->_getfield('trade_pack_item','pack_item_id',['id'=>$arr_item_id[$key]]);
        $item=$this->_getrow('pack_item','*',['id'=>$item_id]);
        $this->_return(1,'使用成功',$item);
    }

    //轮询获取使用结果
    public function polling(){
        $polling_id=$this->input->post('polling_id');
        if(!$polling_id) $this->_return(1,"缺少参数 polling_id");
        $reservation=$this->_getrow('reservation','*',['id'=>$polling_id]);
        if(!$reservation) $this->_return(0,'参数错误');
        if($reservation['status']==0){
            /*if($reservation['error_msg']){
                //将提示信息清除
                $this->db->update('reservation',['error_msg'=>""],['id'=>$polling_id]);
            }*/
            $this->_return(5,'继续轮询',['error_msg'=>$reservation['error_msg']?:""]);
        } elseif($reservation['status']==2) {
            $this->_return(5,'すでにキャンセルされた予約',['error_msg'=>$reservation['error_msg']?:""]);
        }
        $trade=$this->_getrow('trade','*',['id'=>$reservation['trade_id']]);
        $this->_return(1,'已使用完',['trade_id'=>$reservation['trade_id'],'pack_id'=>$trade['pack_id'],'shop_id'=>$trade['adminid']]);
    }

    //评价页面
    public function evaluate_page(){
        $trade_id=$this->input->post('trade_id');
        if(!$trade_id) $this->_return(-1,'缺少参数 trade_id');
        $shop=$this->_getrow('admin',"id,nickname,thumb,address",['id'=>$this->_getfield('trade','adminid',['id'=>$trade_id])]);
        $shop['thumb']=$shop['thumb']?base_url($shop['thumb']):base_url("images/default_via.jpg");
        $this->_return(1,'获取成功',$shop);
    }

    //评价
    public function evaluate(){
        $trade_id=$this->input->post('trade_id');
        if(!$trade_id) $this->_return(-1,'缺少参数 trade_id');
        $trade=$this->_getrow('trade','id,adminid,status,pack_id',['id'=>$trade_id]);
        if(!$trade) $this->_return(0,'trade_id 参数错误');
        if($trade['status']==3) $this->_return(0,'订单已评价过');
        $user=$this->_get();
        $score=$this->input->post('score');
        $content=$this->input->post('content');
        $imgs = "";
        $video = "";
        $img_urls = [];
        $video_urls = [];
        if(!$score) $this->_return(-1,'请选择评分');
        if($_FILES){
            $img=$this->_uploads();
            foreach($img as $k=>$v){
                if (strpos($k, 'img') !== false) {
                    if(!empty($img_urls))$imgs .= "\n";
                    $imgs.=$v['filename'];
                    array_push($img_urls, base_url($v['filename']));
                } else {
                    if(!empty($imgs))$video .= "\n";
                    $video.=$v['filename'];
                    array_push($video_urls, base_url($v['filename']));
                }
            }
        }
        $this->db->insert('evaluate',[
            'shop_id'=>$trade['adminid']?:0,
            'user_id'=>$user['id'],
            'content'=>$content?:"什么都没说",
            'imgs'=>$imgs?:"",
            'videos'=>$video?:"",
            'pack_id'=>$trade['pack_id'],
            'score'=>$score,
            'ctime'=>date('Y-m-d H:i:s')
        ]);
        //计算一次商家平均评价分
        $score=$this->_getfield('evaluate','AVG(score)',['shop_id'=>$trade['adminid']]);
        //更新商家平均分
        $this->db->update('admin',['score'=>$score],['id'=>$trade['adminid']]);
        //更新订单为已评价过
        $data=['is_evaluate'=>1];
        if($trade['status']==4) $data['status']=3; //如果订单已完成 现在又评价了就改成已评价 最终状态
        $this->db->update('trade',$data,['id'=>$trade['id']]);
        $this->_return(1,'评价成功,感谢您的评价', ['img_urls' => $img_urls, 'video_urls'=> $video_urls]);
    }


    //优惠码二维码
    public function item_qrcode($id=0,$reservation_id=0)
    {
        $get = $this->input->get();
        $url = $id."|".$reservation_id;
        require_once(APPPATH . "libraries/phpqrcode.php");
        $errorCorrectionLevel = "H";
        $matrixPointSize = "8";
        ob_clean();//这个一定要加上，清除缓冲区
        QRcode::png($url, false, $errorCorrectionLevel, $matrixPointSize, 4, false, $get['colors'], $get['qrcodecolors']);
    }

    //验证优惠券
    private function check_coupon($coupon_id, $pay_money)
    {
        $user = $this->_get();
        $coupon = $this->_getrow('user_coupon', '*', ['id' => $coupon_id]);
        if (!$coupon) $this->_return(0, '没有找到优惠券');
        if ($coupon['order_id'] != 0) $this->_return(0, '优惠券已使用');
        if (strtotime($coupon['end_time']) < time()) $this->_return(0, '优惠券已过期');
        if ($coupon['limit_money'] > $pay_money) $this->_return(0, '未到优惠券使用门槛金额');
        if ($coupon['userid'] != $user['id']) $this->_return(0, '优惠券只能本人使用');
        // if ($coupon['adminid'] != 1) {//其它代理商的优惠券
        //     if ($coupon['adminid']!=$shop_id) $this->_return(0, '该优惠券不能在这个商家上使用');
        // }
        return $coupon['money'];
    }

    //我的订单
    public function trade_list(){
        $user=$this->_get(-102);
        $page=$this->input->post('page')?:1;
        $pagesize=$this->input->post('pagesize')?:10;

        $where=" user_id=".$user['id'];
        $status=$this->input->post('status');
        $where.=" and status > 0";
        // if(is_numeric($status)) {
        //     if($status>=0){
        //         $where.=" and status=$status";
        //     }else{
        //         $where.=" and status<0";
        //     }
        // }

        $trades = $this->_getlist('trade', '*', $where);
        $list_array = [];
        foreach ($trades as $trade) {
            if (!isset($trade['subscription_flg'])) {
                if ($trade['status'] == $status) {
                    array_push($list_array, $trade);
                }
            } else {
                $pack = $this->_getrow('pack', 'id', 'id='.$trade['pack_id']);
                $pack_items = $this->_getlist('pack_item', '*', 'pack_id='.$pack['id']);
                $pack_items_count=0;
                foreach($pack_items as $pack_item) {
                    $pack_items_count+=$pack_item['num'];
                }
                $reservation_count = $this->_getcount('reservation', 'trade_id='.$trade['id'].' and status <> 2');
                log_message('error', $pack_items_count);
                log_message('error', $reservation_count);
                if ($status == 1) {
                    if ($pack_items_count > $reservation_count) {
                        array_push($list_array, $trade);
                    }
                } else {
                    if ($pack_items_count >= $reservation_count) {
                        $reservation_count = $this->_getcount('reservation', 'trade_id='.$trade['id'].' and status = 0');
                        if ($reservation_count > 0) {
                            array_push($list_array, $trade);
                        }
                    }
                }
            }
        }
        $list['list'] = $list_array;
        array_slice($list['list'], $page, $pagesize);
        $status_arr=[-2=>"退款成功",-1=>"退款中",0=>"待付款",1=>"待预约",2=>"待使用",3=>"已完成",4=>"待评价"];
        // $list=$this->_getpage('trade',$where,'id asc',$page,$pagesize,"id,adminid,pack_info,pack_id,ctime,pay_money,money,status,end_time,reservation_id, subscription_flg, subscription_type");
        foreach($list['list'] as $k=>&$v){
            $shop=$this->_getrow('admin','nickname,thumb',['id'=>$v['adminid']]);
            $v['shop_nickname']=$shop['nickname']?:"";
            $v['thumb']=$shop['thumb']?base_url($shop['thumb']):"";
            $pack=json_decode($v['pack_info'],1);
            $v['pack_img']=$pack['img']?base_url($pack['img']):"";
            $v['pack_title']=$pack['title']?:"";
            $v['status_name']=$status_arr[$v['status']];
            if(strtotime($v['end_time'])<time() && in_array($v['status'],[1,2]) || $v['status']==5){
                $v['status_name']="已过期";
                $v['status']=5;
            }
            $v['pack_num']=0;
            if($v['status']!=0)$v['pack_num'] =$this->_getfield('pack_item','sum(num)',['pack_id'=>$v['pack_id']])?:0;
            $v['item']=[];
            if($v['status']==0) $v['pay_money']=$v['money'];
            if($v['status']==2){
                $reservation=$this->_getrow('reservation','*',['id'=>$v['reservation_id']]);
                if($reservation){
                    $item_ids=$this->_getcol('trade_pack_item','pack_item_id',"id in(".$reservation['pack_item_id'].")")?:[0];
                    $v['item']=$this->_getlist('pack_item','title,knife',"id in(".implode(',',$item_ids).")");
                }
                // $reservation=$this->_getcols('reservation','*', 'trade_id='.$v['id'].' and status=0');
                // if($reservation){
                //     $item_ids=$this->_getcol('trade_pack_item','pack_item_id',"id in(".implode(', ', $reservation['pack_item_id']).")")?:[0];
                //     $v['item']=$this->_getlist('pack_item','title,knife',"id in(".implode(',',$item_ids).")");
                // }
            }
        }
        unset($v);
        $this->_return(1,'获取成功',$list);
    }

    //删除待支付订单
    public function del_trade(){
        $trade_id=$this->input->post('trade_id');
        if(!$trade_id ) $this->_return(-1,'缺少参数 trade_id');
        $user=$this->_get();
        $trade=$this->_getrow('trade','*',['id'=>$trade_id]);
        if(!$trade) $this->_return(0,'数据错误');
        if($trade['user_id']!=$user['id']) $this->_return(0,'用户不一致');
        if($trade['status']!=0) $this->_return(0,'订单状态错误');
        //删除订单
        $this->db->delete('trade',['id'=>$trade['id']]);
        $this->_return(1,'操作成功');
    }
    //订单支付
    public function pay_trade(){
        $pay_type=$this->input->post('pay_type');
        $coupon_id=$this->input->post('coupon_id')?:0;
        $pay_password=$this->input->post('pay_password');
        if(!in_array($pay_type,[1,2,3,4,5,6])) $this->_return(-1,'请选择支付方式');

        $trade_id=$this->input->post('trade_id');
        if(!$trade_id ) $this->_return(-1,'缺少参数 trade_id');
        $user=$this->_get();
        $trade=$this->_getrow('trade','*',['id'=>$trade_id]);
        if(!$trade) $this->_return(0,'数据错误');
        if($trade['user_id']!=$user['id']) $this->_return(0,'用户不一致');
        if($trade['status']!=0) $this->_return(0,'订单状态错误');
        if(strtotime($trade['end_time'])<time()) $this->_return(0,'订单已过期');
        $coupon_money=0;
        if($coupon_id){
            $coupon_money=$this->check_coupon($trade['adminid'],$coupon_id,$trade['money']);
        }
        $pay_money=max($trade['money']-$coupon_money,0);
        $discount=min($trade['money'],$coupon_money);
        if($pay_type==1) if($pay_money>$user['money']) $this->_return(0,'余额不足 请选择其它支付方式');
        $tradeno=date('YmdHis').mt_rand(10000,99999);
        //更新订单
        $this->db->update('trade',['tradeno'=>$tradeno,'pay_money'=>$pay_money,'discount'=>$discount,'coupon_id'=>$coupon_id],['id'=>$trade['id']]);
        if($pay_money<=0) {//订单余额小于等于0 直接支付成功
            $this->tradeSuccess($trade_id);
            $this->_return(88,'付款成功',['trade_id'=>$trade_id]);
        }
        if($pay_type==1){//余额支付
            //扣除余额
            if(!$user['pay_password']) $this->_return(8,'还未设置支付密码 请先设置支付密码');
            if(!$pay_password) $this->_return(-1,'请输入支付密码');
            if(md5($pay_password)!=$user['pay_password']) $this->_return(0,'支付密码不正确');
            //扣除余额
            $this->db->set('money','money-'.$pay_money,false)->where('id',$user['id'])->update('user');
            $this->tradeSuccess($trade_id);
            $this->_return(88,'付款成功',['trade_id'=>$trade_id]);
        }elseif($pay_type==2){//微信支付
            $pay_money=$this->rmb2ry($pay_money);
            $trade=$this->_getrow('trade','*',['id'=>$trade_id]);
            $this->wx_pay("APP","购买套餐",$tradeno,$pay_money*100,$trade);
        }elseif($pay_type==3){//支付宝支付
            $pay_money=$this->rmb2ry($pay_money);
            $result=$this->alipay($tradeno,$pay_money,"购买套餐",$trade_id,1);
            $this->_return(1,'获取支付参数成功', array('trade_id' => $trade_id, 'payparams' => $result));
        } elseif ($pay_type==4){//line 支付
            //$this->_return(0,'未开发');
           $this->line_pay($tradeno,$pay_money,$this->translate(2,"购买套餐"),$trade_id,1);
        } elseif ($pay_type==5){//Square 支付
          if (!$square_source_id) $this->_return(0,'square_source_id 参数错误');
          $result = $this->square_pay($square_source_id, $pay_money );
          if (!$result->errors) {
            $this->tradeSuccess($trade_id);
            $this->_return(88,'付款成功',['trade_id'=>$trade_id, 'result' => $result]);
          } else {
            $this->_return(-1,'缺少参数', $result->errors);
          }
        } elseif ($pay_type==6){//line 支付
            // $this->tradeSuccess($trade_id);
            $this->_return(88,'付款成功',['trade_id'=>$trade_id]);
            // $result = $this->square_pay($tradeno,$pay_money,$this->translate(2,"购买套餐"),$trade_id,1);
            // $this->_return(1, 'success', $result);
        }
    }
    //申请退款详情
    public function refund_page(){
        $user=$this->_get();
        $trade_id=$this->input->post('trade_id');
        if(!$trade_id) $this->_return(-1,'缺少参数 trade_id');
        $trade=$this->_getrow('trade','id,adminid,pack_id,pack_info,ctime,status,pay_money',['id'=>$trade_id]);
        if(!$trade) $this->_return(0,'数据错误');
        //if(!in_array($trade['status'],[1,-1])) $this->_return(0,'订单状态错误');
        $use_status=0;
        //判断是否使用过
        $is_use=$this->_getrow('trade_pack_item','id',"trade_id=".$trade['id']." and use_num>0");
        if($is_use) $use_status=1;
        $shop=$this->_getrow('admin','nickname,thumb,address,phone',['id'=>$trade['adminid']]);
        $pack=json_decode($trade['pack_info'],true);
        $data=[
            'trade_id'=>$trade['id'],
            'pack_id'=>$trade['pack_id'],
            'shop_id'=>$trade['adminid'],
            'use_status'=>$use_status,
            'shop_name'=>$shop['nickname']?:'',
            'thumb'=>$shop['thumb']?base_url($shop['thumb']):"",
            'shop_address'=>$shop['address']?:"",
            'phone'=>$shop['phone']?:"",
            'img'=>$pack['img']?base_url($pack['img']):"",
            'ctime'=>$trade['ctime'],
            'trade_status'=>$trade['status'],
            'pay_money'=>$trade['pay_money'],
            'pack_title'=>$pack['title'],
            'pack_price'=>$pack['price'],
            'efficacy'=>$pack['efficacy'],
            'position'=>$pack['position'],
            'service_process'=>$pack['service_process']
        ];
        $this->_return(1,'获取成功',$data);
    }

    //获取退款原因
    public function get_refund_cause(){
        $key="fault_type";//日文
        if($this->language==1) $key='fault_type1';//中文
        $this->_return(1,'获取成功',$this->setting_mdl->get('question')[$key]);
    }
    //申请退款
    public function apply_refund(){
        $trade_id=$this->input->post('trade_id');
        $refund_cause=$this->input->post('refund_cause');
        $refund_memo=$this->input->post('refund_memo');

        if(!$trade_id) $this->_return(-1,'缺少参数 trade_id');
        if(!$refund_cause) $this->_return(-1,'请选择退款原因');

        $user=$this->_get();
        $trade=$this->_getrow('trade','*',['id'=>$trade_id]);
        if(!$trade) $this->_return(0,'数据错误');
        if($trade['status']!=1) $this->_return(0,'订单状态错误');

        if($trade['user_id']!=$user['id']) $this->_return(0,'用户不一致');
        //判断是否使用过
        $is_use=$this->_getrow('trade_pack_item','id',"trade_id=".$trade['id']." and use_num>0");
        if($is_use) $this->_return(0,'订单已经消费过 不能申请退款');

        //修改订单状态
        $this->db->update('trade',['status'=>-1,'refund_cause'=>$refund_cause,'refund_memo'=>$refund_memo],['id'=>$trade['id']]);
        $this->_return(1,'申请成功');
    }

    public function favorite()
    {
        $user=$this->_get();
        $shop_id=$this->input->post('shop_id');
        if(!$shop_id) $this->_return(-1,'缺少参数 shop_id');
        $favorites = $this->_getcol('favorite','id',['admin_id'=>$shop_id, 'user_id'=>$user['id']]);
        if (sizeof($favorites) > 0) {
            $this->_return(1,'すでに登録されています。');
        }
        $this->db->insert('favorite',[
            'admin_id'=>$shop_id,
            'user_id'=>$user['id']
        ]);
        $this->_return(1,'申请成功');
    }

    public function remove_favorite()
    {
        $user=$this->_get();
        $shop_id=$this->input->post('shop_id');
        if(!$shop_id) $this->_return(-1,'缺少参数 shop_id');
        $this->db->delete('favorite',['admin_id'=>$shop_id, 'user_id'=>$user['id']]);
        $this->_return(1,'申请成功');
    }

    public function favorite_shop_ids()
    {
        $user=$this->_get();
        $favorites=$this->_getcol('favorite','admin_id as shop_id',['user_id'=>$user['id']]);
        $this->_return(1,'取得成功', $favorites);
    }

    public function favorite_shops()
    {
        $user=$this->_get();
        $favorites=$this->_getcol('favorite','admin_id as shop_id',['user_id'=>$user['id']]);

        if (!$favorites) {
            $this->_return(0, 'nothing', $favorites);
        }
        $lat=$this->input->post('lat');
        $lng=$this->input->post('lng');
        $where="business_status=0 and gid in(".implode(',',$this->_role[2]).") and id in (".implode(',',$favorites).")";
        $list=$this->_getlist('admin','id as shop_id,thumb,nickname,keywords,score,lat,lng,address,truncate(SQRT(POWER('.$lat.' - lat, 2) + POWER('.$lng.' - lng, 2)),2) AS d',$where,'d asc','0,100');
        // $this->_return(1, 'error', $list);
        foreach($list as $k=>$v){
            $keyword=explode(',',$v['keywords']);
            $list[$k]['keywords']='';
            foreach($keyword as $kk=>$vv){
                $list[$k]['keywords'].=$vv." ";
            }
            $list[$k]['d'] = $this->get_distance($lng, $v['lng'], $lat, $v['lat']);
            $list[$k]['thumb'] = $v['thumb']?base_url($v['thumb']):base_url("images/default_via.jpg");
            $pack=$this->_getlist('pack','id,title,price,img,subscription_flg, subscription_type',"adminid=".$v['shop_id']." and validity_time>'".date('Y-m-d H:i:s')."'",'id asc','3');
            foreach($pack as $kk=>$vv){
                if ($pack[$kk]['subscription_flg'] == 1) {
                    $subscription_pack = $this->_getrow('subscription_pack_types','id,title,count,discount',"id=".$pack[$kk]['subscription_type']);
                    // $this->_return(1, 'error', $subscription_pack);
                    if ($subscription_pack) {
                        $pack[$kk]['title'] = $subscription_pack['title'];
                        $pack[$kk]['count'] = $subscription_pack['count'];
                        $pack[$kk]['discount'] = $subscription_pack['discount'];
                    }
                }
                $pack[$kk]['sell_num']=$this->_getfield('trade','count(1)',"pack_id =".$vv['id']." and status >0")?:"0";
                $pack[$kk]['num']=$this->_getfield('pack_item','sum(num)',['pack_id'=>$vv['id']])?:"0";
                $pack[$kk]['img']=base_url($pack[$kk]['img']);
            }
            $list[$k]['pack']=$pack;
        }
        $this->_return(1,'获取成功',['list'=>$list]);
    }

    public function tutorials()
    {
        $videos = $this->_getlist('media', '*');
        foreach($videos as &$video) {
            $video['url'] = base_url($video['url']);
        }
        $this->_return(1,'获取成功',['list'=>$videos] );
    }
}