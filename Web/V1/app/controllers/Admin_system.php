<?php  if ( ! defined('IN_DLC')) exit('No direct script access allowed');
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

// ------------------------------------------------------------------------

/**
 *  系统相关控制器
 *
 * @package     
 * @subpackage  Controllers
 * @category    Controllers
 * @author       
 * @link         
 */
class Admin_System extends Admin_Controller
{
	/**
     * 构造函数
     *
     * @access  public
     * @return  void
     */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('command_mdl');
	    //$this->output->enable_profiler(TRUE);
	}
	
 
	
	/**
     * 后台默认首页
     *
     * @access  public
     * @return  void
     */
	public function index()
	{
		$this->display('ajax.html');		 
	}
	
	public function acl()
	{
		 
		 $gid = $this->_admin->gid;
		 
		/* $this->load->helper('file');
		 $string = read_file('app/views/acl/left_menus_'.$gid.'.txt');*/
        $this->role_menu = '';
        $this->_get_parent_role_menus($gid,0);
		 echo $this->role_menu;
	}
    private function _get_parent_role_menus($role_id=0,$parent_id=0)
    {
        $roles = $this->command_mdl->get_role_command_by_role_id($role_id,$parent_id);
        // echo json_encode($roles);
        foreach ($roles as $v)
        {
            if($this->command_mdl->count_role_command_by_role_id($role_id,$v['command_id'])>0)
            {
                $this->role_menu .='<li class=""><a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="/images/'.$v['icon_css'].'" class="sidebar-icon"/><span class="menu-text"> '.translate($v['title']).' </span></a><b class="arrow"></b><ul class="submenu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">';
                $this->_get_child_role_menus($role_id,$v['command_id']);
                $this->role_menu .='</ul></li>';
            } else {
                $this->role_menu .= '<li class=""><a data-url="page'.$v['link_page'].'" href="admin_system#page'.$v['link_page'].'"><img src="/images/'.$v['icon_css'].'" class="sidebar-icon"/><span class="menu-text"> '.translate($v['title']).' </span></a><b class="arrow"></b></li>';
            }

        }

    }
    private function _get_child_role_menus($role_id=0,$parent_id=0)
    {

        $roles = $this->command_mdl->get_role_command_by_role_id($role_id,$parent_id);
        foreach ($roles as $v)
        {
            $this->role_menu .= '<li class=""><a data-url="page'.$v['link_page'].'" href="admin_system#page'.$v['link_page'].'"><i class="menu-icon fa fa-caret-right"></i> '.translate($v['title']).' </a><b class="arrow"></b></li>';

        }


    }
	public function main()
	{
		$this->display('main.html');
	}
	
	// ------------------------------------------------------------------------
	
	/**
     * 用户修改密码表单页入口
     *
     * @access  public
     * @return  void
     */
	public function password()
	{
		$this->display('bguser/change_pwd.html');
	}
	
	// ------------------------------------------------------------------------
	
	/**
     * 用户修改密码表单页呈现/处理函数 
     *
     * @access  public
     * @return  void
     */
	public function password_save()
	{
		 
		$this->load->library('form_validation');
        $data = $this->_get_form_data();
		$msg['status'] =FALSE;
	    
	    
	    if(!$this->form_validation->required($data['oldpasswd']))
		{
		  $msg['msg'] = '旧密码必填.';
		  echo json_encode($msg);
		  return;
		}
		if(!$this->form_validation->required($data['passwd'])||!$this->form_validation->min_length($data['passwd'],5))
		{
		  $msg['msg'] = '新密码密填且长度至少5位.';
		  
		  echo json_encode($msg);
		  return;
		}
		////if(!$this->form_validation->required($data['repasswd'])||!$this->form_validation->matches($data['passwd'], 'repasswd'))
		//{
		//  $msg['msg'] = '请重新密码必填且两次新密码须一致.';
		//  echo json_encode($msg);
		//  return;
		//}
		$this->load->model('admin_mdl');
        $old_pass = md5(trim($data['oldpasswd']));
		$stored = $this->admin_mdl->get_admin_by_id($this->_admin->id);
		 
		if ($stored AND $old_pass == $stored->password)
		{
		    $this->admin_mdl->update_admin_password();
			$msg['status'] =TRUE;
			$msg['msg'] = '密码修改成功.';
			$msg['redirect']='admin_system#page/admin_system/password/';
		}
		else
		{
		   $msg['msg'] = '密码修改失败.'; 
		 }
	    echo json_encode($msg);		
	}
	
	// ------------------------------------------------------------------------
	
	 
	/**
     * 更新缓存表单页
     *
     * @access  public
     * @return  void
     */
	public function cache()
	{
		$this->_check_permit();
		$this->_template('sys_cache');
	}
	
	// ------------------------------------------------------------------------
	
	/**
     * 更新缓存处理函数 
     *
     * @access  public
     * @return  void
     */
	public function _cache_post()
	{
		$this->_check_permit();
		$cache = $this->input->post('cache');
		if ($cache AND is_array($cache))
		{
			update_cache($cache);
		}
		$this->_message("缓存更新成功！", '', TRUE);	
	}
	
	/* 获取表单数据
	*
	* @access  private
	* @param   bool
	* @return  array
	*/
	private function _get_form_data($edit = FALSE)
	{
		 
		$data['oldpasswd'] = $this->input->post('oldpasswd', TRUE);
		$data['passwd'] = $this->input->post('passwd', TRUE);
		$data['repasswd'] = $this->input->post('repasswd', TRUE);
		return $data;
	}
	// ------------------------------------------------------------------------
    public function home()
    {
        //折线图
        $count=[];
        $balance_money=[];//余额支付金额
        $wx_money=[];//微信支付金额
        $total_money=[];//总订单金额
        $date=[];
        $type=$this->input->get('type')?:"year";
        $time=$this->input->get('time');
        $this->assign('get',$this->input->get());
        $chart_where=$this->_rolesql('',$this->_getrolefield());
        $device_where=$this->_rolesql('',$this->_getrolefield());
        $date_type=$type;
        if($type=="day"){//天
            if($time){
                $sDay=strtotime(date($time.'00:00:00'));
                $eDay=strtotime(date($time.'23:59:59'));
            }else{
                $sDay=$this->_gettime('sToday');
                $eDay=$this->_gettime('eToday');
            }
            $fields=array('HOUR(ctime) as title,count(*) as total,
             sum(case when paytype=4 then pay_money else 0 end) as line_money,
            sum(case when paytype=3 then pay_money else 0 end) as ali_money,
            sum(case when paytype=1 then pay_money else 0 end) as balance_money,
            sum(pay_money) as total_money,
            sum(case when paytype=2 then pay_money else 0 end) as wx_money','HOUR(ctime)');
            $arrSet = range(1, 24);
            $text = '时';
            $date_type='date';
        }elseif($type=="week"){//周
            if($time){
                $sDay=mktime(0, 0, 0, date('m',strtotime($time)), date('d',strtotime($time)) - date('w',strtotime($time)) + 1, date('Y',strtotime($time)));
                $eDay=mktime(23, 59, 59, date('m',strtotime($time)), date('d',strtotime($time)) - date('w',strtotime($time)) + 7, date('Y',strtotime($time)));
            }else{
                $sDay=$this->_gettime('sWeek');
                $eDay=$this->_gettime('eWeek');
            }

            $fields=array('DAY(ctime) as title,count(*) as total,
             sum(case when paytype=4 then pay_money else 0 end) as line_money,
            sum(case when paytype=3 then pay_money else 0 end) as ali_money,
            sum(case when paytype=1 then pay_money else 0 end) as balance_money,
            sum(pay_money) as total_money,
            sum(case when paytype=2 then pay_money else 0 end) as wx_money','DAY(ctime)');
            $sDate = date('d', $sDay);
            $eDate = date('d', $eDay);
            // 跨月
            if ($eDate < $sDate) {
                $arr = range($sDate, date('t'));
                $arr1 = range(1, $eDate);
                $arrSet = array_merge($arr, $arr1);
            } else {
                $arrSet = range($sDate, $eDate);
            }
            $text = '日';
            $date_type='date';
        }elseif($type=="month"){//月
            if($time){
                $sDay=mktime(0, 0, 0, date('m',strtotime($time)), 1, date('Y',strtotime($time)));
                $eDay=mktime(23, 59, 59, date('m',strtotime($time)), date('t',strtotime($time)), date('Y',strtotime($time)));
                $arrSet=range(1,date('t',strtotime($time)));
            }else{
                $sDay=$this->_gettime('sMonth');
                $eDay=$this->_gettime('eMonth');
                $arrSet=range(1,date('t'));
            }
            $fields=array('DAY(ctime) as title,count(*) as total,
            sum(case when paytype=4 then pay_money else 0 end) as line_money,
            sum(case when paytype=3 then pay_money else 0 end) as ali_money,
            sum(case when paytype=1 then pay_money else 0 end) as balance_money,
            sum(pay_money) as total_money,
            sum(case when paytype=2 then pay_money else 0 end) as wx_money','DAY(ctime)');
            $text = '日';
        }else{//年
            if($time){
                $sDay=strtotime(date($time.'-01-01 00:00:00'));
                $eDay=strtotime(date($time.'-12-30 23:59:59'));
            }else{
                $sDay=$this->_gettime('sYear');
                $eDay=$this->_gettime('eYear');
            }
            $fields=array('MONTH(ctime) as title,count(*) as total,
             sum(case when paytype=4 then pay_money else 0 end) as line_money,
            sum(case when paytype=3 then pay_money else 0 end) as ali_money,
            sum(case when paytype=1 then pay_money else 0 end) as balance_money,
            sum(pay_money) as total_money,
            sum(case when paytype=2 then pay_money else 0 end) as wx_money','MONTH(ctime)');
            $arrSet=range(1,date(12));
            $text = '月';
        }
        $where = ' status>0 and ctime >= "'.date('Y-m-d H:i:s',$sDay).'" and ctime<= "' .date('Y-m-d H:i:s',$eDay).'"'.$chart_where;
        $dayList = $this->_getlist('trade', $fields, $where);
        foreach ($arrSet as $k=>$v){
            $getArr[$k]=array('title'=>$v.$text, 'total'=>'0');
            $date[]=$v.$text;
            $arr[$k]=0;
            $t[$k]=0;
            $wx[$k]=0;
            $ali[$k]=0;
            $balance[$k]=0;
            $line[$k]=0;
            foreach ($dayList as $key=>$value){
                if ($v==$value['title']){
                    $arr[$k]=(int)$value['total'];
                    $t[$k]=(int)$value['total_money'];
                    $wx[$k]=(int)$value['wx_money'];
                    $ali[$k]=(int)$value['ali_money'];
                    $balance[$k]=(int)$value['balance_money'];
                    $line[$k]=(int)$value['line_money'];
                }
            }
            $count[]=$arr[$k];
            $total_money[]=$t[$k];
            $wx_money[]=$wx[$k];
            $ali_money[]=$ali[$k];
            $balance_money[]=$balance[$k];
            $line_money[]=$line[$k];
        }
        //数据重组
        $data=[
            ['name'=>'订单数量','data'=>$count],
            ['name'=>'总订单金额','data'=>$total_money],
            ['name'=>'微信支付金额','data'=>$wx_money],
            ['name'=>'支付宝支付金额','data'=>$ali_money],
            ['name'=>'余额支付金额','data'=>$balance_money],
            ['name'=>'line支付金额','data'=>$line_money],
        ];
        $this->assign('data',$data);
        $this->assign('date',$date);
        $this->assign('type',$type);
        $this->assign('date_type',$date_type);
        //设备数量统计
        $mac_count_type1=$this->_getfield('device','count(1)'," type =1".$device_where);
        $mac_count_type2=$this->_getfield('device','count(1)'," type =2".$device_where);
        $this->assign('mac_count_type1',$mac_count_type1);
        $this->assign('mac_count_type2',$mac_count_type2);
        //在线设备数量统计
        $open_status_mr=$this->_getfield('device',"count(1)"," type=1 and beat_time>'".date('Y-m-d H:i:s')."'".$device_where);
        $open_status_tm=$this->_getfield('device',"count(1)"," type=2 and beat_time>'".date('Y-m-d H:i:s')."'".$device_where);
        $this->assign('open_status_mr',$open_status_mr);
        $this->assign('open_status_tm',$open_status_tm);
        $open_status_mr2=max($mac_count_type1-$open_status_mr,0);
        $open_status_tm2=max($mac_count_type2-$open_status_tm,0);
        $this->assign('open_status_mr2',$open_status_mr2);
        $this->assign('open_status_tm2',$open_status_tm2);

        //订单金额
        $order=$this->_getrow('trade','sum(pay_money) as total_money,count(1) as count',"status>0".$chart_where)?:"0.00";
        //退款订单
        $refund_count=$this->_getfield('trade',"count(1)",'status=-2'.$chart_where);
        //最近10条订单记录
        $list=$this->_getlist('trade','*',$where,'id desc',[0,10]);
        $this->assign('list',$list);
        $this->assign('order',$order);
        $this->assign('refund_count',$refund_count);
        $this->display('base/home.html');
    }
	
    public function _get_highcharts_data($sDay, $eDay, $type, $adminid, $gid)
    {
		$field = 'pay_money';
		if(in_array($gid, $this->_role[0])){
			$where = 'status=1 and createtime >= ' . $sDay . ' and createtime <= ' . $eDay;
		}else{
			if(in_array($gid, $this->_role[1])){
				$field = 'corp_money';
				$where = 'status=1 and createtime >= ' . $sDay . ' and createtime <= ' . $eDay . " and admin_corpid=$adminid";
			}else{
				$field = 'admin_money';
				$where = 'status=1 and createtime >= ' . $sDay . ' and createtime <= ' . $eDay . " and adminid=$adminid";
			}
		}
        if ($type == 'day') {
            $fields = array('HOUR(FROM_UNIXTIME(createtime)) as title,SUM('.$field.') as sum_money,count(*) as total', 'HOUR(FROM_UNIXTIME(createtime))');
            $arrSet = range(1, 24);
            $text = '时';
        } else if ($type == 'month') {
            $fields = array('DAY(FROM_UNIXTIME(createtime)) as title,SUM('.$field.') as sum_money,count(*) as total', 'DAY(FROM_UNIXTIME(createtime))');
            $arrSet = range(1, date('t'));
            $text = '日';
        } else if ($type == 'pmonth') {
            $fields = array('DAY(FROM_UNIXTIME(createtime)) as title,SUM('.$field.') as sum_money,count(*) as total', 'DAY(FROM_UNIXTIME(createtime))');
            $arrSet = range(1, date('t', strtotime('-1 month')));
            $text = '日';
        }
        $dayList = $this->_getlist('trade', $fields, $where);
        foreach ($arrSet as $k => $v) {
            $getArr[$k] = array('title' => $v . $text, 'money' => '0', 'total' => '0');
            foreach ($dayList as $key => $value) {
                if ($v == $value['title']) $getArr[$k] = array('title' => $v . $text, 'money' => $value['sum_money'], 'total' => $value['total']);
            }
        }
        return $getArr;
    }
	
	public function ueditor(){
		if(PHP_SESSION_ACTIVE != session_status()) {
            session_start();
        }
		$_SESSION['aid'] = $this->_admin->id;
		include APPPATH.'third_party/ueditor1_4_3_3-utf8-php/php/controller.php';
	}
    public function _gettime($date)
    {
        switch ($date) {
            case 'sToday': //本日开始时间
                return mktime(0, 0, 0, date('m'), date('d'), date('Y'));
                break;
            case 'eToday': //本日结束时间
                return mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')) - 1;
                break;
            case 'sYesterday': //昨日开始时间
                return mktime(0, 0, 0, date('m'), date('d') - 1, date('Y'));
                break;
            case 'eYesterday': //昨日结束时间
                return mktime(0, 0, 0, date('m'), date('d'), date('Y')) - 1;
                break;
            case 'sWeek': //本周开始时间
                return mktime(0, 0, 0, date('m'), date('d') - date('w') + 1, date('Y'));
                break;
            case 'eWeek': //本周结束时间
                return mktime(23, 59, 59, date('m'), date('d') - date('w') + 7, date('Y'));
                break;
            case 'spWeek': //上周开始时间
                return mktime(0, 0, 0, date('m'), date('d') - date('w') + 1 - 7, date('Y'));
                break;
            case 'epWeek': //上周结束时间
                return mktime(23, 59, 59, date('m'), date('d') - date('w') + 7 - 7, date('Y'));
                break;
            case 'sMonth': //本月开始时间
                return mktime(0, 0, 0, date('m'), 1, date('Y'));
                break;
            case 'eMonth': //本月结束时间
                return mktime(23, 59, 59, date('m'), date('t'), date('Y'));
                break;
            case 'spMonth': //上月开始时间
                return mktime(0, 0, 0, date('m') - 1, 1, date('Y'));
                break;
            case 'epMonth': //上月结束时间
                return strtotime(date('Y-m-t 23:59:59', strtotime('-1 month')));
                break;

            case 'sYear': //今年开始时间
                return strtotime(date('Y-01-01 00:00:00'));
                break;
            case 'eYear': //今年结束时间
                return strtotime(date('Y-12-30 23:59:59'));
                break;
            case 'spYear': //去年开始时间
                return strtotime(date('Y-01-01 00:00:00', strtotime('-1 year')));
                break;
            case 'epYear': //去年结束时间
                return strtotime(date('Y-12-30 23:59:59', strtotime('-1 year')));
                break;

        }
    }
}

/* End of file admin_syestem.php */
/* Location: ./admin/controllers/admin_syestem.php */