<?php

trait User_api_wxsite
{

    /******微信公众号自定义菜单********/

    //获取ticket
    public function getTicket()
    {
        $this->load->config('wx_config');
        $wxconfig['appid'] = $this->config->item('JSAPI_appid');
        $wxconfig['appsecret'] =  $this->config->item('JSAPI_appsecret');
        $str = file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $wxconfig['appid'] . '&secret=' . $wxconfig['appsecret']);
        $arr = json_decode($str, true);
        $str1 = file_get_contents('https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=' . $arr['access_token'] . '&type=jsapi');
        $array = json_decode($str1);
        $array->appid=$this->config->item('JSAPI_appid');
        $array->appsecret=$this->config->item('JSAPI_appsecret');
        // echo $str1;
        $this->_return(1,'获取成功', $array);
    }

    // 首页
    public function index()
    {
        redirect(base_url("h5/html/index.html"));
    }

    // 个人中心
    public function center()
    {
        redirect(base_url("h5/html/center.html"));
    }

    // 我的订单
    public function user_order()
    {
        redirect(base_url("h5/html/my_order.html"));
    }

    // 商家登入
    public function seller_login()
    {

        redirect(base_url("h5/html/shop_login.html"));
    }
    // 合作申请
    public function user_join()
    {
        redirect(base_url("h5/html/join.html"));
    }

    //关于我们
    public function wx_about()
    {
        redirect(base_url("h5/html/y_about.html "));
    }



    /*********end********/



}