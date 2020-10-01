<?php
trait User_api_pay{
    /**微信支付
     * @param $trade_type //类型 JSAPI JSAPP 等
     * @param $body
     * @param $out_trade_no
     * @param $total_fee
     * @param $order
     * @param int $type
     */
	public function wx_pay($trade_type,$body,$out_trade_no,$total_fee,$order,$type=1){
        // 调用微信扫码支付接口配置信息
        $this->load->config('wx_config');

        $wxconfig['appid']=$this->config->item($trade_type.'_appid');
        $wxconfig['mch_id']=$this->config->item($trade_type.'_mch_id');
        $wxconfig['apikey']=$this->config->item($trade_type.'_apikey');
        $wxconfig['appsecret']=$this->config->item($trade_type.'_appsecret');
        $wxconfig['sslcertPath']=$this->config->item('sslcertPath');
        $wxconfig['sslkeyPath']=$this->config->item('sslkeyPath');
        //由于此类库构造函数需要传参，我们初始化类库就传参数给他吧
        $this->load->library('CI_Wechatpay',$wxconfig);
        $row=$this->_get();
        $openid=$row['weixin_openid'];
        $product_id=$order['id'];
        $proopenid=$row['weixin_proopenid'];
        if($type==1){//订单支付
            $notify_url = base_url("paynotify/wxpay");
        }elseif($type==2){//充值
            $notify_url = base_url("paynotify/recharge");
        }
        //$total_fee=1;//测试
        if($trade_type == 'NATIVE'){
            $result = $this->ci_wechatpay->getCodeUrl($body,$out_trade_no,$total_fee,$notify_url,$product_id);
        }elseif($trade_type == 'JSAPI'){
            $result = $this->ci_wechatpay->getPrepayId($body,$out_trade_no,$total_fee,$notify_url,$openid);
            $result = $this->ci_wechatpay->get_package($result);
        }elseif($trade_type == 'JSAPP'){
            $result = $this->ci_wechatpay->getPrepayId($body,$out_trade_no,$total_fee,$notify_url,$proopenid);
            $result = $this->ci_wechatpay->get_package($result);
        }else{
            $result = $this->ci_wechatpay->getAppPrePayId($body,$out_trade_no,$total_fee,$notify_url);
            $result = array('prepayid' => $result, 'package' => $this->ci_wechatpay->get_app_package($result));
        }
        $result = array('success' => $result, 'error' => $this->ci_wechatpay->error);

        $this->_return(1, '获取支付参数成功', array('trade_id' => $order['id'], 'wx_payparams' => $result['success']['package'],'error'=>$result['error']?:""));
    }

    public function alipay($out_trade_no, $total_fee, $subject, $order_id = 0, $type=1)
    {
        //实例化具体API对应的request类,类名称和接口名称对应,当前调用接口名称：alipay.trade.app.pay
        $this->load->config('ali_config');
        require_once(APPPATH."libraries/Alipay/AopSdk.php");
        $aop = new AopClient ();
        $aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
        $aop->appId = $this->config->item('al_appid');
        $aop->rsaPrivateKey = $this->config->item('al_PrivateKey');
        $aop->alipayrsaPublicKey = $this->config->item('al_PublicKey');
        $aop->format = 'json';
        $aop->postCharset = 'UTF-8';
        $aop->apiVersion = '1.0';
        $aop->signType = 'RSA2';
        $request = new AlipayTradeAppPayRequest();
        //SDK已经封装掉了公共参数，这里只需要传入业务参数
        $datas['body'] = '订单' . $out_trade_no;
        $datas['subject'] = $subject;
        $datas['out_trade_no'] = $out_trade_no;
        $datas['timeout_express'] = "30m";
        $datas['total_amount'] = $total_fee;
        $datas['product_code'] = 'QUICK_MSECURITY_PAY';
        $bizcontent = json_encode($datas);
        if($type==1){//套餐支付
            $request->setNotifyUrl(base_url("paynotify/alipay/"));
        }elseif($type==2){//余额充值
            $request->setNotifyUrl(base_url("paynotify/recharge_alipay/"));
        }
        $request->setBizContent($bizcontent);
        //这里和普通的接口调用不同，使用的是sdkExecute
        $response = $aop->sdkExecute($request);
        //htmlspecialchars是为了输出到页面时防止被浏览器将关键参数html转义，实际打印到日志以及http传输不会有这个问题
        //就是orderString 可以直接给客户端请求，无需再做处理。
        //$this->_return($row['id'], htmlspecialchars($response));
        return $response;
    }

    public function line_pay($orderId,$amount,$title="",$order_id=0,$type=1){
        if($type==1){//套餐支付
            $url=base_url("paynotify/line_pay?tradeno=".$orderId);
        }elseif($type==2){//余额充值
            $url=base_url("paynotify/line_pay_r?tradeno=".$orderId);
        }
        $this->load->model('line_mdl');
        $res=$this->line_mdl->getRequest($orderId,$amount,'JPY',$title,$url,'');
        $res['trade_id']=$order_id;
        $this->_return(1,'获取支付参数成功',$res);
    }

    public function getUniqueKey()
    {
        $key = uniqid();
        return $key;
    }

    public function create_square_customer_id($user)
    {
        $this->load->config('square_config');
        $url = $this->config->item('url').$this->config->item('sq_customer_url');
        $ch = curl_init($url);
        $token = $this->config->item("sandbox_token");
        // $token = $this->config->item("production_token");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST'); // -X
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization:'.$token, 'Accept:application/json','Square-version:2020-04-22', 'Content-Type:application/json' ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, '{
            "idempotency_key":"'.$this->getUniqueKey().'",
            "birthday":"'.date('Y-m-d').'",
            "company_name":"company_name",
            "email_address":"customer@square.com",
            "family_name":"family_name",
            "given_name":"'.$user['nickname'].'"
        }' );
        try {
          $result = curl_exec($ch);
          log_message('error', $result);
          $value = json_decode($result);
          $customer_id = $value->customer->id;
          curl_close($ch);
          return $customer_id;
        } catch (Exception $e){
          curl_close($ch);
          return $e;
        }
    }

    public function create_square_card($customer_id, $source_id)
    {
        $this->load->config('square_config');
        $url = $this->config->item('url').$this->config->item('sq_customer_url')."/".$customer_id."/cards";
        $ch = curl_init($url);
        $token = $this->config->item("sandbox_token");
        // $token = $this->config->item("production_token");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST'); // -X
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization:'.$token, 'Accept:application/json','Square-version:2020-04-22', 'Content-Type:application/json' ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, '{
            "card_nonce":"'.$source_id.'"
        }' );
        try {
            $result = curl_exec($ch);
            log_message('error', $result);
            $value = json_decode($result);
            $card_id = $value->card->id;
            if (!$card_id) {
              $this->_return(-1, 'card error', $result);
            }
            curl_close($ch);
            return $card_id;
        } catch (Exception $e){
            curl_close($ch);
            return $e;
        } 
    }

    public function square_pay($source_id, $price, $square_customer_id="", $pay_type=1)
    {
        $this->load->config('square_config');
        $key = $this->getUniqueKey();
        $customer_id  = $square_customer_id?(',"customer_id":"'.$square_customer_id.'"'):(",'':''");
        // $token = $this->config->item("production_token");
        $token = $this->config->item("sandbox_token");
        // $theurl = 'https://connect.squareupsandbox.com/v2/payments';
        // $theurl = 'https://connect.squareup.com/v2/payments';
        // sandbox EAAAEKntozkhL6XrKiB6WHidMl5y9bJerIET_b8FRzotLHv9wLCPErKaRsfGSz4j
        // production EAAAEJY58a2YjhUUBOtlfewxhnKwVc-CiinI0ohoPEh5CcBoHqVZjFS4bpFCJ50O
        $url = $this->config->item('url').$this->config->item('sq_payment_url');
        log_message('error', $url);
        log_message('error', $source_id);
        log_message('error', $key);
        log_message('error', $price);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST'); // -X
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization:'.$token, 'Accept:application/json','Square-version:2020-04-22', 'Content-Type:application/json' ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, '{
            "idempotency_key":"'.$key.'",
            "amount_money":{
              "amount":'.$price.',
              "currency":"JPY"
            },
            "source_id":"'.$source_id.'"'.$customer_id.'
        }' );
        try {
            $result = curl_exec($ch);
            log_message('error', $result);
            $value = json_decode($result);
            // array_push($result, ['key' => $key]);
            $value->key = $key;
            curl_close($ch);

            if($value->errors){
              $errors = $value->errors;
              foreach($errors as $error){
                if($error->code){
                  $errorCode = $error->code;
                  log_message('error', 'errorCode:'.$errorCode);
                  // ブラウザ決済に非対応の場合、user_cardレコードを削除
                  if(strcmp($errorCode, 'MANUALLY_ENTERED_PAYMENT_NOT_SUPPORTED') == 0){
                    $this->db->delete('user_card', "square_id='".$source_id."'");
                  }
                }
              }
            }

            return $value;
        } catch (Exception $e){
            curl_close($ch);
            log_message('success', $e);
            $e['key'] = $key;
            return $e;
        }
    }

    //余额充值
    public function recharge(){
	    $user=$this->_get();
	    $extra=$this->input->post('extra');
      $pay_type=$this->input->post('pay_type');
      $square_source_id = $this->input->post('source_id');
        // $this->_return(0,'square_source_id 参数错误');
      if(!in_array($pay_type,[2,3,4,5])) $this->_return(-1,"请选择支付方式");
      
	    $money=$this->input->post('money');
	    if(!is_numeric($extra) && !$money) $this->_return(0,'请选择充值套餐或者输入充值金额');
        $recharge=$this->setting_mdl->get('recharge');
        $min_recharge_money=$recharge['min_recharge_money'];
        unset($recharge['min_recharge_money']);
        $pay_money=0;
        $recharge_money=0;
	    if($money){
	        //if($money<$min_recharge_money) $this->_return(0,'充值金额不能小于'.$min_recharge_money." 元");
	        $pay_money=$money;
        }else{
          $recharge_arr=array_col2row($recharge);
          $pay_money=$recharge_arr[$extra]['money'];
          $recharge_money=$recharge_arr[$extra]['redmoney'];
        }
        if($pay_money<0) $this->_return(0,'充值金额不能小于0');
        if(!$pay_money) $this->_return(0,'充值金额不能为空');
        //生成订单
        $recharge_no = "R".date('YmdHis').rand(10000,99999);
        $data=[
            'userid'=>$user['id'],
            'money'=>$pay_money,
            'redmoney'=>$recharge_money,
            'rechargeno'=>$recharge_no,
            'paytype'=>$pay_type,
            //'tradetype'=>"JSAPP",
            'createtime'=>time(),
            // 'current_money' => $user['money']
        ];
	    $this->db->insert('recharge',$data);
      $data['id']=$this->db->insert_id();
      $data['current_money']=$user['money'];
      
	    if($pay_type==2){
          //微信支付
          $this->wx_pay('APP','余额充值',$data['rechargeno'],$pay_money * 100,$data,2);
      }elseif($pay_type==3){//支付宝支付
        $result=$this->alipay($data['rechargeno'],$pay_money,"余额充值",$data['id'],2);
        $this->_return(1,'获取支付参数成功', array('trade_id' => $data['id'], 'payparams' => $result));
      } elseif ($pay_type == 4){//line支付
        //$this->_return(0,'未开发');
          if($pay_money<1) $this->_return(0,'充值金额不能小于1');
          $this->line_pay($data['rechargeno'],$pay_money,$this->translate(2,"余额充值"),$data['id'],2);
      } elseif ($pay_type == 5) { //Square Credit
        $card = $this->_getrow('user_card', '*', 'user_id='.$user['id']);
        if (!$card) {
          $customer_id = $this->create_square_customer_id($user);
          $card_id = $this->create_square_card($customer_id, $square_source_id);
          // $key = $this->getUniqueKey();
          $this->db->insert('user_card', ['user_id' => $user['id'], 'square_id'=>$card_id, 'square_customer_id'=>$customer_id]);
          $result = $this->square_pay($card_id, $pay_money, $customer_id );
          if (!$result->errors) {
            $order=$this->_getrow('recharge','*',['rechargeno'=>$recharge_no]);
            $this->recharge_success($order,$result);
            $user = $this->_get();
            $this->_return(88,'付款成功',['trade_id'=>$data['id'], 'result' => $result, 'current_money'=>$user['money'], 'square_customer_id'=>$customer_id]);
          } else {
            $this->_return(-1,'缺少参数-1', $result);
          }
          $this->_return(-1,'缺少参数-2', $result);
        } else {
          $result = $this->square_pay($card['square_id'] , $pay_money, $card['square_customer_id']);
          if (!$result->errors) {
            $order=$this->_getrow('recharge','*',['rechargeno'=>$recharge_no]);
            $this->recharge_success($order,$result);
            $user = $this->_get();
            $this->_return(88,'付款成功',['trade_id'=>$data['id'], 'result' => $result, 'current_money'=>$user['money']]);
          } else {
            $this->_return(-1,'缺少参数-3', $result->errors);
          }
        }

        $result = $this->square_pay($square_source_id, $pay_money);
        if (!$result->errors) {
          $order=$this->_getrow('recharge','*',['rechargeno'=>$recharge_no]);
          $this->recharge_success($order,$result);
          $user = $this->_get();
          $this->_return(88,'付款成功',['trade_id'=>$data['id'], 'result' => $result, 'current_money'=>$user['money']]);
        } else {
          $this->_return(-1,'缺少参数', $result->errors);
        }
      } elseif ($pay_type == 6) {
        
      }

    }
    private function recharge_success($order=[],$result=[],$type=0){
      if(!$order) return false;
      if($order['status']!=0) return true;

      //修改状态
      $this->db->update('recharge',['paytime'=>time(),'status'=>1,'paydata'=>json_encode($result)],['id'=>$order['id']]);
      //增加用户余额
      $user=$this->_getrow('user','*',['id'=>$order['userid']]);
      $setting=$this->setting_mdl->get('setting');
      if($type){//日元支付 
        $this->db->update('user',['money'=>$user['money']+(($order['money']+$order['redmoney']))],'id='.$order['userid']);
      }else{
        $this->db->update('user',['money'=>$user['money']+(($order['money']+$order['redmoney']))],'id='.$order['userid']);
        // *$setting['exchange']
      }
      
      $time=date('Y-m-d H:i:s');
      //资金明细
      $data=[
          'type'=>1,
          'title'=>'充值余额',
          'user_id'=>$order['userid'],
          'order_no'=>$order['rechargeno'],
          'money'=>$order['money'],
          'user_money'=>$order['money']+$user['money']+$order['redmoney'],
          'ctime'=>$time,
          'desc'=>($order['redmoney']>0)?"充值赠送：".$order['redmoney'].'元':"充值"
      ];
      $this->db->insert('finance',$data);
      return ;
  }

	//消费明细(余额充值)
	public function finance(){
		$row = $this->_get();
		$page = $this->input->post('page')?:1;
		$pagesize = $this->input->post('pagesize');
		if(empty($pagesize))$pagesize = 10;

		//处理搜索SQL
		$where = 'user_id='.$row['id']." and type=1";

		$result = $this->_getpage('finance', $where, 'id desc', $page, $pagesize, 'id,title,ctime,type,money');

		$this->_return(1, '获取数据成功', $result);
	}
	//明细详情
    public function finance_details(){
	    $id=$this->input->post('id');
	    if(empty($id)) $this->_return(-1,'缺少参数 id');
	    $finance=$this->_getrow('finance','*',['id'=>$id]);
	    if(empty($finance)) $this->_return(0,'数据错误');

        $data=[
            'title'=>$finance['title'],
            'money'=>$finance['money'],
            'type'=>$finance['type'],
            'type_name'=>"",
            'ctime'=>'',
            'order_no'=>$finance['order_no'],
            'user_money'=>$finance['user_money'],
            'remark'=>$finance['desc'],
            'start_time'=>0,
            'end_time'=>0,
            'use_time'=>'',
        ];
        if($finance['type']==0){//租用
            $trade=$this->_getrow('trade','*',['tradeno'=>$finance['order_no']]);
            $data['start_time']=$trade['begintime'];
            $data['end_time']=$trade['endtime'];
            $data['use_time']=$this->calculate_time($trade['begintime'],$trade['endtime']);
        }else{//充值
            $data['type_name']='充值';
            $data['ctime']=$finance['ctime'];
        }
        $this->_return(1,'获取成功',$data);
    }

}