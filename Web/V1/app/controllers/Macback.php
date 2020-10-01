<?php if ( ! defined('IN_DLC')) exit('No direct script access allowed');
 
/**
 * 用户登录/退出控制器
 *
 * @package      management
 * @subpackage  Controllers
 * @category    Controllers
 * @author       
 * @link         
 */

class Macback extends SM_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
        $this->load->model('trade_mdl');
	}
	public function beat(){
	    $post=$this->input->post();
	    if($post['macno']){
            //$post["status"]//设备状态:0【设备空闲状态】;1【设备使用状态】;2【设备异常状态】
            //$post["macType"]//设备类型
            //$post["isClosed"]//设备开机状态:0开机，1关机
            //$post["usedTimes"]//使用次数
            //$post["error"]//错误码
            //log_message('error',json_encode($_POST));
	        $device=$this->_getrow('device','*',['macno'=>$post['macno']]);
            $data=array("status"=>$post['status'],"beat_time"=>date("Y-m-d H:i:s",time()+100),'isClosed'=>$post["isClosed"],'usedTimes'=>$post['usedTimes'],'error'=>$post['error']);
            if($post['macType']) $data['type']=$post['macType'];
            if(strtotime($device['beat_time'])<time()){
               $data['off_line_time']=$device['beat_time'];
            }
            $this->db->update("device",$data,array("macno"=>$post['macno']));

        }
    }
    //二维码主动上报
    public function qrcode(){
        $post = $this->input->post();
        /*
        $post['ctime']//时间 整型
        $post['index']//序号
        $post['qrcode']//二维码内容
        */
        log_message('error','二维码主动上报'.json_encode($post));
        //测试用二维码
        if(strrpos(trim($post['qrcode'],"\r\n"),"test@")!== false ){
            $num=100;
            $arr_num=explode('@',trim($post['qrcode'],"\r\n"));
            if(is_numeric($arr_num[1])&& $arr_num[1]>0) $num=$arr_num[1];
            $res=$this->_macRun($post['macno'],time(),$num);
            log_message('error',"二维码测试 ".$post['macno']."刀数：".$num);
            die('SUCCESS');
        }
        $device=$this->_getrow('device','*',['macno'=>$post['macno']]);
        if($device){
            $arr=explode('|',trim($post['qrcode'],"\r\n"));
            $reservation=$this->_getrow('reservation','*',['id'=>$arr[1]]);
            if(!$reservation) return false;
            $arr_item_id=explode(',',$reservation['pack_item_id']);
            $arr_use_status=explode(',',$reservation['use_status']);
            $key='';
            for($i=0;$i<count($arr_item_id);$i++){
                if($arr_item_id[$i]==$arr[0]) $key=$i;
            }
            if(!is_numeric($key)){
                $this->db->update('reservation',['error_msg'=>"请扫正确的二维码"],['id'=>$reservation['id']]);
                return false;
            }
            if($arr_use_status[$key]==1){
                $this->db->update('reservation',['error_msg'=>"当前二维码已使用，请扫其它二维码"],['id'=>$reservation['id']]);
                return false;//已使用
            }
            if(strtotime(date('Y-m-d',strtotime($reservation['start_time'])))!=strtotime(date('Y-m-d'))){
                $this->db->update('reservation',['error_msg'=>"未到预约日期"],['id'=>$reservation['id']]);
                return false;
            }

            if($device['status']==1){
                $this->db->update('reservation',['error_msg'=>"设备正在使用，请稍候"],['id'=>$reservation['id']]);
                return false;
            }
            if(strtotime($device['beat_time']) <time()){
                $this->db->update('reservation',['error_msg'=>"设备已离线"],['id'=>$reservation['id']]);
                return false;
            }

            //获取套餐项目
            $trade_pack_item=$this->_getrow('trade_pack_item','pack_item_id,trade_id',['id'=>$arr_item_id[$key]]);
            $item=$this->_getrow('pack_item','*',['id'=>$trade_pack_item['pack_item_id']]);
            if($item['type']!=$device['type']) {
                $this->db->update('reservation',['error_msg'=>"套餐与设备不匹配"],['id'=>$reservation['id']]);
                return false;
            }
            $trade=$this->_getrow('trade','*',['id'=>$trade_pack_item['trade_id']]);
            if(!in_array($device['adminid'],[$trade['adminid'],$trade['agent_id']])){ //|| !in_array($device['agent_id'],[$trade['adminid'],$trade['agent_id']])){
                $this->db->update('reservation',['error_msg'=>"订单的商家与设备的商家不匹配"],['id'=>$reservation['id']]);
                return false;
            }
            //TODO 开设备
            $res=$this->_macRun($post['macno'],time(),$item['knife']);
            if($res['code']==1 && isset($res['data']) && $res['data']['status']==0 ){
                //更新设备离线时间
                $this->db->update('device',["beat_time"=>date("Y-m-d H:i:s",time()+100)],['id'=>$device['id']]);
                $arr_use_status[$key]=1;//已使用
                if(!in_array(0,$arr_use_status)){
                    //判断订单是否已经使用完
                    $is_success=$this->_getfield('trade_pack_item','id',"(num-use_num)>0 and trade_id=".$reservation['trade_id']);
                    $trade=$this->_getrow('trade','*',['id'=>$reservation['trade_id']]);
                    if(!$is_success){//订单已经使用完这个时候开始分成
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
                $data=['use_status'=>implode(',',$arr_use_status),'status'=>1,'error_msg'=>''];
                $this->db->update('reservation',$data,['id'=>$reservation['id']]);
                die('SUCCESS');
            }
            $this->db->update('reservation',['error_msg'=>"设备开启失败"],['id'=>$reservation['id']]);
        }

        die('FAIL');
    }
    //定时任务
    public function timed_task(){
	    log_message('error','凌晨定时任务');
	    $trade=$this->_getlist('trade',"*","status in(1,2) and end_time <='".date('Y-m-d H:i:s')."'");
	    if($trade){
	        foreach($trade as $k=>$v){
	            $this->db->update('trade',['status'=>5],['id'=>$v['id']]);
                //TODO 分成
                $this->trade_mdl->divide_into($v['id']);
            }
        }
        $day_time=date('Y-m-d',strtotime("-1 day"));
	    //获取5天前待评价的订单
        $trade_list=$this->_getlist('trade','*',"status=4 and success_time<'".date('Y-m-d',strtotime("-5 day"))."'" );
        if($trade_list){
            foreach($trade_list as $k=>$v){
                //修改订单为已完成
                $this->db->update('trade',['status'=>3],['id'=>$v['id']]);
            }
        }
       /* $time=date('His');
	    if($time=="000000"){//凌晨*/
	        //获取前一天已预约未使用的预约单

            log_message('error','凌晨定时任务时间:'.$day_time);
            $s_time=$day_time." 00:00:00";
            $e_time=$day_time." 23:59:59";
            $where="status=0 and start_time between '".$s_time."' and '".$e_time."'";
            $list=$this->_getlist('reservation','*',$where);
            if($list){
                foreach($list as $k=>$v){
                    //修改状态
                    $this->db->update('reservation',['status'=>1,"use_status"=>str_replace('0','1',$v['use_status'])],['id'=>$v['id']]);
                    //判断订单是否已经使用完
                    $is_success=$this->_getfield('trade_pack_item','id',"(num-use_num)>0 and trade_id=".$v['trade_id']);
                    if(!$is_success){//订单已经使用完这个时候开始分成
                        $trade=$this->_getrow('trade','*',['id'=>$v['trade_id']]);
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
                    //修改订单状态
                    $this->db->update('trade',$trade_arr,['id'=>$v['trade_id']]);
                }
            }

       /* }*/
        die('success');
    }


}
/* End of file login.php */