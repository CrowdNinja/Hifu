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
class PayNotify extends SM_Controller {
	/**
	 * 构造函数
	 *
	 * @access  public
	 * @return  void
	 */
	 
	public function __construct() 
	{
		parent :: __construct();
		$this->load->model('trade_mdl');
		$this->load->model('finance_mdl');
		$this->load->model('setting_mdl');
    }
    
    public function trigger_subscription()
    {
        $trades = $this->_getlist(['trade', ['pack', 'pack.id=trade.pack_id']], '*', 'pack.subscription_flg=1 and DATE_FORMAT(DATE_ADD(paytime, INTERVAL 1 MONTH), "%Y-%M-%D") = DATE_FORMAT(NOW(), "%Y-%M-%D")');
        
        foreach ($trades as $trade) {
            // echo json_encode($trade);
            $this->db->insert('trade', [
                'tradeno' => date('YmdHis').mt_rand(10000,99999),
                'tran_id' => $trade['tran_id'],
                'agent_id' => $trade['agent_id'],
                'adminid' => $trade['adminid'],
                'user_id' => $trade['user_id'],
                'pack_id' => $trade['pack_id'],
                'pack_info' => $trade['pack_info'],
                'pack_item_info' => $trade['pack_item_info'],
                'money' => $trade['money'],
                'pay_money' => $trade['pay_money'],
                'discount' => $trade['discount'],
                'status' => 0,
                'ctime' => date('Y-m-d H:i:s'),
                'end_time'=>$trade['validity_time'],
                'paytype' => 5, 
                'subscription_flg'=>$trade['subscription_flg'],
                'subscription_type'=>$trade['subscription_type']
            ]);
            $id = $this->db->insert_id();
            if ($trade['paytype'] == 5) {
                $user_card = $this->_getrow('user_card', '*', 'user_id='.$trade['user_id']);
                $result = $this->card_pay($trade['price'], $user_card['square_id']);
                if (!$result->errors) {
                    $this->db->update('trade', ['status'=>'1','paytime'=> date('Y-m-d H:i:s')], 'id='.$id);
                    $this->tradeSuccess($trade, $result);
                } else {
                    echo json_encode($result);
                }
            } else if ($trade['paytype'] = 1) {
                $this->db->update('trade', ['status'=>'1','paytime'=> date('Y-m-d H:i:s')], 'id='.$id);
                $this->tradeSuccess($trade);
            }
        }
    }

    public function card_pay($price, $source_id)
    {
        $theurl = 'https://connect.squareupsandbox.com/v2/payments';
        // EAAAEBQM6GYMefnPhIMlggB-KmhCDxECmvOnmQ7FCcs5gyi9Pm2fEla1DLeFx92J  
        // EAAAES2su0hIYPdVoX6AjhCjSh2BC9jCLfvPOyO2piCHYUCbJmCT1jsEXgzSG_4_      
        $ch = curl_init($theurl);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST'); // -X
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json', ]); // -H
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']); // -H
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer EAAAEBQM6GYMefnPhIMlggB-KmhCDxECmvOnmQ7FCcs5gyi9Pm2fEla1DLeFx92J',  'Content-Type: application/json']); // -H
        // curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0); // -0
        curl_setopt( $ch, CURLOPT_POSTFIELDS, '{
            "idempotency_key": "'.uniqid().'",
            "autocomplete": true,
            "amount_money": {
              "amount": '.$price.',
              "currency": "JPY"
            },
            "source_id": "'.$source_id.'"
            }
        }' );
        try {
            $result = curl_exec($ch);
            curl_close($ch);
            return json_decode($result);
        } catch (Exception $e){
            curl_close($ch);
            return $e;
        }
    }
	
	private function xml2array($xml) {  
        $array = array();  
        $tmp = null; 
        try{  
            $tmp = @simplexml_load_string($xml);  
        }catch(Exception $e1){}  
        if(!$tmp){
            try{
				$tmp = @simplexml_load_string(htmlspecialchars_decode($xml));  				
			}catch(Exception $e2){}
        }
        if(!$tmp)return $array;
        $tmp = (array)$tmp;
        if($tmp && is_array($tmp)){  
            foreach ( $tmp as $k => $v) {  
                $array[$k] = (string) $v;  
            }  
        }  
        return $array;  
    }  
	
    private function get_back_data() {  
        $xml = file_get_contents("php://input");  
        return $this->xml2array($xml);  
    }
    
    public function square_pay()
    {
        $merchant_id = $_POST['merchant_id'];
        $type = $_POST['type'];
        if ($type == 'payment.created') {
            
        }
    }
	//line 订单支付
    public function line_pay(){
        $tradeno = mb_strlen(trim(isset($_GET['tradeno']) ?: "")) == 0 ? "" : trim($_GET['tradeno']);
        // transactionId 來自之前 Reserve API 請求的回應
        $transactionId = mb_strlen(trim(isset($_GET['transactionId']) ?: "")) == 0 ? "" : trim($_GET['transactionId']);
        log_message('error',json_encode($_GET));
        // 引用 Line/LinePay PHP Library
        $this->load->config('line_config');
        include('./app/libraries/LinePay.php');
        $apiEndpoint = $this->config->item("url");  // https://api-pay.line.me/v2/payments/{{transactionId}}/confirm
        $channelId = $this->config->item("channelId");  // 通路ID
        $channelSecret = $this->config->item("channelSecret");   // 通路密鑰

        // 建立 Line\LinePay 物件
        $LinePay = new Line\LinePay($apiEndpoint, $channelId, $channelSecret);
        //$order = $this->Data_helper_model->get_charging_pwd($oid);
        $order = $this->_getrow("trade", '*',['tradeno'=>$tradeno]);

        // 建立 confirm API 所需要的參數
        $params = [
            "amount"   => (int)$order['pay_money'],
            "currency" => "JPY",
        ];


        // 發送 confirm 請求，confirm() 回傳的結果為 Associative Array 格式
        $result = $LinePay->confirm($transactionId, $params);

        if ($result['returnCode'] == '0000') {
            // Reserve 請求成功!
            $res=$this->tradeSuccess($order,$result,$transactionId);
            redirect(base_url('/h5/html/pay.html?trade_id='.$order['id']."&status=1"));
            /*if ($res) {
                redirect(base_url('Buy/success/') . $oid, 'refresh');
            } else {
                $data['refresh'] = base_url('Buy/pay_success_line?oid=' . $oid);
                $this->load->view("Buy/wait", $data);
            }*/
        } else {
            redirect(base_url('/h5/html/pay.html?trade_id='.$order['id']."&status=2"));
            //echo "信息有誤".($result?json_encode($result):"");
            exit;
        }
    }

    //line 充值支付
    public function line_pay_r(){
        $tradeno = mb_strlen(trim(isset($_GET['tradeno']) ?: "")) == 0 ? "" : trim($_GET['tradeno']);
        // transactionId 來自之前 Reserve API 請求的回應
        $transactionId = mb_strlen(trim(isset($_GET['transactionId']) ?: "")) == 0 ? "" : trim($_GET['transactionId']);
        // 引用 Line/LinePay PHP Library
        $this->load->config('line_config');
        include('./app/libraries/LinePay.php');
        $apiEndpoint = $this->config->item("url");  // https://api-pay.line.me/v2/payments/{{transactionId}}/confirm
        $channelId = $this->config->item("channelId");  // 通路ID
        $channelSecret = $this->config->item("channelSecret");   // 通路密鑰

        // 建立 Line\LinePay 物件
        $LinePay = new Line\LinePay($apiEndpoint, $channelId, $channelSecret);
        //$order = $this->Data_helper_model->get_charging_pwd($oid);
        $order=$this->_getrow('recharge','*',['rechargeno'=>$tradeno]);

        // 建立 confirm API 所需要的參數
        $params = [
            "amount"   => (int)$order['money'],
            "currency" => "JPY",
        ];

        // 發送 confirm 請求，confirm() 回傳的結果為 Associative Array 格式
        $result = $LinePay->confirm($transactionId, $params);

        if ($result['returnCode'] == '0000') {
            // Reserve 請求成功!
            $this->recharge_success($order,$result,1);
             redirect(base_url('/h5/html/pay.html?recharge=1&status=1'));
            /*if ($res) {
                redirect(base_url('Buy/success/') . $oid, 'refresh');
            } else {
                $data['refresh'] = base_url('Buy/pay_success_line?oid=' . $oid);
                $this->load->view("Buy/wait", $data);
            }*/
        } else {
            //echo "信息有誤".($result?json_encode($result):"");
            redirect(base_url('/h5/html/pay.html?recharge=1&status=2'));
            exit;
        }
    }
    //订单支付
	public function wxpay(){
		$result = $this->get_back_data();
		$trade_type = $result['trade_type'];
		if(empty($trade_type))$trade_type = 'JSAPP';
		
		$this->load->config('wx_config');
		$conf_appid = $this->config->item($trade_type.'_appid');
		if($result['appid'] && $conf_appid != $result['appid'])$trade_type = $trade_type == 'JSAPP' ? 'JSAPP' : 'JSAPI';//根据appid判断是微信还是小程序支付
		
		$wxconfig['appid']=$this->config->item($trade_type.'_appid');
		$wxconfig['mch_id']=$this->config->item($trade_type.'_mch_id');
		$wxconfig['apikey']=$this->config->item($trade_type.'_apikey');
		$wxconfig['appsecret']=$this->config->item($trade_type.'_appsecret');
		$wxconfig['sslcertPath']=$this->config->item('sslcertPath');
		$wxconfig['sslkeyPath']=$this->config->item('sslkeyPath');
		//由于此类库构造函数需要传参，我们初始化类库就传参数给他吧
		$this->load->library('CI_Wechatpay',$wxconfig);
        
        //存储微信的回调
        $result = $this->ci_wechatpay->get_back_data();
         
        //验证签名，并回应微信。
        //对后台通知交互时，如果微信收到商户的应答不是成功或超时，微信认为通知失败，
        //微信会通过一定的策略（如30分钟共8次）定期重新发起通知，
        //尽可能提高通知的成功率，但微信不保证通知最终能成功。
        if(!$result){
			$this->ci_wechatpay->response_back('FAIL', '签名失败');
        }else{
			$this->ci_wechatpay->response_back('SUCCESS');
        }
         
        //==商户根据实际情况设置相应的处理流程，此处仅作举例=======
         
        if($result)
        {
            if ($result["return_code"] == "FAIL") {
                //此处应该更新一下订单状态，商户自行增删操作
                //log_result($log_name,"【通信出错】:\n".$xml."\n");
            }
            elseif($result["result_code"] == "FAIL"){
                //此处应该更新一下订单状态，商户自行增删操作
                //log_result($log_name,"【业务出错】:\n".$xml."\n");
            }
            else{
                //此处应该更新一下订单状态，商户自行增删操作
                //log_result($log_name,"【支付成功】:\n".$xml."\n");
				//$this->order(1, $result, $trade_type);
                $trade=$this->_getrow('trade','*',['tradeno'=>$result["out_trade_no"]]);
                $this->tradeSuccess($trade,$result,$result['transaction_id']);
            }
             
            //商户自行增加处理流程,
            //例如：更新订单状态
            //例如：数据库操作
            //例如：推送支付完成信息
        }
	}
    //订单交易完成操作
    private function tradeSuccess($trade=[],$result=[],$transaction_id=0){
        if(!$trade) return false;
        if($trade['status']!=0) return false;
        $time=date('Y-m-d H:i:s');
        $data=['status'=>1,'paytime'=>$time,"tran_id"=>$transaction_id,'paydata'=>json_encode($result)];
        //修改订单状态
        $this->db->update('trade',$data,['id'=>$trade['id']]);
        if($trade['coupon_id']) $this->db->update('user_coupon',['usetime'=>$time,'order_id'=>$trade['id']],['id'=>$trade['coupon_id']]);//处理优惠券
        //生成订单套餐项目
        $arr=json_decode($trade['pack_item_info'],1);
        foreach($arr as $k=>$v){
            $this->db->insert('trade_pack_item',[
                'trade_id'=>$trade['id'],
                'pack_item_id'=>$v['id'],
                'item_name'=>$v['title'],
                'num'=>$v['num'],
                'knife'=>$v['knife']
            ]);
        }
        return true;
    }




    //余额充值微信支付回调
    public function recharge(){
        $result = $this->get_back_data();
        $trade_type = $result['trade_type'];
        if(empty($trade_type))$trade_type = 'JSAPI';

        $this->load->config('wx_config');
        $conf_appid = $this->config->item($trade_type.'_appid');
        if($result['appid'] && $conf_appid != $result['appid'])$trade_type = $trade_type == 'JSAPI' ? 'JSAPP' : 'JSAPI';//根据appid判断是微信还是小程序支付

        $wxconfig['appid']=$this->config->item($trade_type.'_appid');
        $wxconfig['mch_id']=$this->config->item($trade_type.'_mch_id');
        $wxconfig['apikey']=$this->config->item($trade_type.'_apikey');
        $wxconfig['appsecret']=$this->config->item($trade_type.'_appsecret');
        $wxconfig['sslcertPath']=$this->config->item('sslcertPath');
        $wxconfig['sslkeyPath']=$this->config->item('sslkeyPath');
        //由于此类库构造函数需要传参，我们初始化类库就传参数给他吧
        $this->load->library('CI_Wechatpay',$wxconfig);

        //存储微信的回调
        $result = $this->ci_wechatpay->get_back_data();

        //验证签名，并回应微信。
        //对后台通知交互时，如果微信收到商户的应答不是成功或超时，微信认为通知失败，
        //微信会通过一定的策略（如30分钟共8次）定期重新发起通知，
        //尽可能提高通知的成功率，但微信不保证通知最终能成功。
        if(!$result){
            $this->ci_wechatpay->response_back('FAIL', '签名失败');
        }else{
            $this->ci_wechatpay->response_back('SUCCESS');
        }

        //==商户根据实际情况设置相应的处理流程，此处仅作举例=======

        if($result)
        {
            if ($result["return_code"] == "FAIL") {
                //此处应该更新一下订单状态，商户自行增删操作
                //log_result($log_name,"【通信出错】:\n".$xml."\n");
            }
            elseif($result["result_code"] == "FAIL"){
                //此处应该更新一下订单状态，商户自行增删操作
                //log_result($log_name,"【业务出错】:\n".$xml."\n");
            }
            else{
                //此处应该更新一下订单状态，商户自行增删操作
                //log_result($log_name,"【支付成功】:\n".$xml."\n");
                //支付成功操作
                $order=$this->_getrow('recharge','*',['rechargeno'=>$result["out_trade_no"]]);
                $this->recharge_success($order,$result);
            }

            //商户自行增加处理流程,
            //例如：更新订单状态
            //例如：数据库操作
            //例如：推送支付完成信息
        }
    }
    //充值完成
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
            $this->db->update('user',['money'=>$user['money']+(($order['money']+$order['redmoney'])*$setting['exchange'])],'id='.$order['userid']);
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
    }

    //支付宝订单支付
    public function alipay(){
        //log_message("error",json_encode($_POST));
        $this->load->config('ali_config');
        $this->load->library('CI_Aliaop');
        $alipay_config = array(
            'app_id' => $this->config->item('al_appid'),
            'alipay_public_key' => $this->config->item('al_PublicKey'),
            'merchant_private_key' => $this->config->item('al_PrivateKey'),
            'sign_type'=>'RSA2'
        );
        $arr=$_POST;
        $aop = $this->ci_aliaop;
        $aop->alipayrsaPublicKey = $alipay_config['alipay_public_key'];
        $result = $aop->rsaCheckV2($arr, $alipay_config['alipay_public_key'], 'RSA2');
        /* 实际验证过程建议商户添加以下校验。
        1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
        2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
        3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
        4、验证app_id是否为该商户本身。
        */
        //if($result) {//验证成功
        if(true) {//跳过验证
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //请在这里加上商户的业务逻辑程序代

            //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——

            //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表

            //商户订单号
            $out_trade_no = $_POST['out_trade_no'];

            //支付宝交易号
            $trade_no = $_POST['trade_no'];

            //交易状态
            $trade_status = $_POST['trade_status'];

            if($_POST['trade_status'] == 'TRADE_FINISHED') {

                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
                //如果有做过处理，不执行商户的业务程序

                //注意：
                //退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知
            }
            else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
                //如果有做过处理，不执行商户的业务程序
                //注意：
                //付款完成后，支付宝系统发送该交易状态通知
                //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
                $trade=$this->_getrow('trade','*',['tradeno'=>$out_trade_no]);
                $this->tradeSuccess($trade,$_POST,$trade_no);
            }
            echo "success";   //请不要修改或删除

        }else {
            //验证失败
            echo "fail";  //请不要修改或删除

        }
    }

    //支付宝充值
    public function recharge_alipay(){
        //log_message("error",json_encode($_POST));
        $this->load->config('ali_config');
        $this->load->library('CI_Aliaop');
        $alipay_config = array(
            'app_id' => $this->config->item('al_appid'),
            'alipay_public_key' => $this->config->item('al_PublicKey'),
            'merchant_private_key' => $this->config->item('al_PrivateKey'),
            'sign_type'=>'RSA2'
        );
        $arr=$_POST;
        $aop = $this->ci_aliaop;
        $aop->alipayrsaPublicKey = $alipay_config['alipay_public_key'];
        $result = $aop->rsaCheckV2($arr, $alipay_config['alipay_public_key'], 'RSA2');
        /* 实际验证过程建议商户添加以下校验。
        1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
        2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
        3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
        4、验证app_id是否为该商户本身。
        */
        //if($result) {//验证成功
        if(true) {//跳过验证
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //请在这里加上商户的业务逻辑程序代

            //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——

            //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表

            //商户订单号
            $out_trade_no = $_POST['out_trade_no'];

            //支付宝交易号
            $trade_no = $_POST['trade_no'];

            //交易状态
            $trade_status = $_POST['trade_status'];

            if($_POST['trade_status'] == 'TRADE_FINISHED') {

                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
                //如果有做过处理，不执行商户的业务程序

                //注意：
                //退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知
            }
            else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
                //如果有做过处理，不执行商户的业务程序
                //注意：
                //付款完成后，支付宝系统发送该交易状态通知
                //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
                $order=$this->_getrow('recharge','*',['rechargeno'=>$out_trade_no]);
                $this->recharge_success($order,$_POST);
            }
            echo "success";   //请不要修改或删除

        }else {
            //验证失败
            echo "fail";  //请不要修改或删除

        }
    }

    public function ret_url(){
        $macno=$this->input->get("macno");
        $order_id=$this->input->get("order_id");
        $type=$this->input->get('type');
        //log_message("error",$macno.":".$order_id);
        if($type==1){//订单支付
            redirect(base_url("/h5/html/using.html?order_id=$order_id"));
        }  elseif($type==3){//取衣支付
            redirect(base_url("/h5/html/door_status.html?order_id=$order_id"));
        }elseif($type==4){
            redirect(base_url("/h5/html/reservation_success.html?order_id=$order_id"));
        }

    }
}