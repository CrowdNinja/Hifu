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
class Line_mdl extends DLC_Model
{
	private $channelId = '1653697461';
	private $channelSecret = 'eb6f624487376a973166bc210cf5f521';
	private $url = "https://sandbox-api-pay.line.me";//'https://api-pay.line.me';//
	private $requestUri = "/v3/payments/request";

	private $confirmUrl = "";//确认付款回调url
	private $cancelUrl = "";//取消付款回调url
	/**
     * 构造函数
     *
     * @access  public
     * @return  void
     */
	public function __construct()
	{
		parent::__construct();
	}

    /**
     * @param $orderId 订单号
     * @param $amount
     * @param string $currency
     * @param string $title
     * @param string $confirmUrl 确认付款回调url
     * @param string $cancelUrl 取消付款回调url
     */
	public function getRequest($orderId,$amount,$currency="JPY",$title="",$confirmUrl='',$cancelUrl=''){
        $this->load->config('line_config');
        $channelId = $this->config->item("channelId");  // 通路ID
        $channelSecret = $this->config->item("channelSecret");   // 通路密鑰
	    // 引用 Line/LinePay PHP Library
		include('./app/libraries/LinePay.php');
		$apiEndpoint = $this->config->item("url");  // 

		// 建立 Line\LinePay 物件
		$LinePay = new Line\LinePay($apiEndpoint, $this->channelId, $this->channelSecret);

		// 建立訂單資訊作為 POST 的參數
		$params = [
		    "productName" => "わたしのハイフ",//訂單名稱，例如：商品XXX..等三項
		    "productImageUrl" => "https://xxxxmasc13.png",//商品圖片 URL，顯示於付款畫面上的影像
		    "amount" => (int)$amount,//付款金額
		    "currency" => "JPY",//付款貨幣 (ISO 4217)，例如 TWD、JPY、USD
		    "confirmUrl" => $confirmUrl,//買家在 LINE Pay 選擇付款方式並輸入密碼後，被重新導向到商家的 URL
		    "orderId" => $orderId . time(),//商家與該筆付款請求對應的訂單編號（這是商家自行管理的唯一編號）
		    //"confirmUrlType"  => "...",//
		];

		// 發送 reserve 請求，reserve() 回傳的結果為 Associative Array 格式
		$result = $LinePay->reserve($params);
		return $result;
		if ($result['returnCode'] == '0000') {
		    return $result;
		} else {
		    return "信息有誤".($result?json_encode($result):"");
		}
		// $data = ["amount"=>$amount,"currency"=>$currency,"orderId"=>$orderId];
		// $products[] = ["name"=>$title,"quantity"=>1,"price"=>$amount];
		// $data["packages"][] = ["id"=>1,"amount"=>$amount,"name"=>"myBeautyApp","products"=>$products];
		// $data['redirectUrls'] = ["confirmUrl"=>$confirmUrl,"cancelUrl"=>$cancelUrl,"confirmUrlType"=>"SERVER"];
		// $ret = $this->getReturn($this->requestUri,$data);
		// echo json_encode($ret);
		// return $ret;
	}
	//统一请求入口
	private function getReturn($uri,$post){
		$nonce = time();
		$signature = base64_encode(hash_hmac('sha256', $this->secretKey.$uri.json_encode($post).$nonce, $this->secretKey));
		$header = ["Content-Type:application/json","X-LINE-ChannelId:{$this->channelId}","X-LINE-Authorization-Nonce:$nonce","X-LINE-Authorization:$signature"];
		return post_url($this->requestUri.$uri,$post,$header);
	}
}
