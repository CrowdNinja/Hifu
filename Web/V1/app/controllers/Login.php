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

class Login extends SM_Controller
{
    /**
     * 构造函数
     *
     * @access  public
     * @return \Login
     */
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
	//	$this->output->enable_profiler(TRUE);
		/*
		$this->settings->load('backend');
		$this->load->switch_theme(setting('backend_theme'));
		*/
	}
	
	public function test()
	{
		echo 'here';
	}
	
	// ------------------------------------------------------------------------

    /**
     * 默认入口
     *
     * @access  public
     * @return  void
     */	
	public function index()
	{
		if ($this->_admin->id)
		{
			redirect('/admin_system#page/admin_system/home');
		}
		else
		{
			//$img_code=site_url('captcha_code');
            //$this->assign('imgCode',$img_code);
			$this->display('login.html');
		}
	}
	
	// ------------------------------------------------------------------------

    /**
     * 退出
     *
     * @access  public
     * @return  void
     */	

	public function quit()
	{
        $this->db->insert('oper_log',[
            'aid'=>$_SESSION['aid']?:"",
            'adminname'=>$_SESSION['adminname']?:"",
            'type'=>"loginout",
            'memo'=>'退出登入 ',
            'ip'=>$this->input->ip_address(),
            'ctime'=>time()
        ]);
		$this->session->sess_destroy();
		redirect('/login');
	}

	//设置语言
    public function set_language(){
	    $_SESSION['language']=$_POST['type'];
        $msg['msg'] = translate('操作成功');
	    echo json_encode($msg);
    }
	// ------------------------------------------------------------------------

    /**
     * 用户登录验证
     *
     * @access  public
     * @return  void
     */	
	public function do_post()
	{
		
		 
		$this->load->library('form_validation');
		//$_POST['user']
		 
		$username = $this->input->post('userName', TRUE);
		$password = $this->input->post('password', TRUE);
		$language = $this->input->post('language',TRUE)?:2;
		//$username = 'admin';
		//$password = 'ff123456';
		$msg['status'] =FALSE;
		if(!$this->form_validation->required($username))
		{
		  $msg['msg'] = translate('请输入账号');
		  die(json_encode($msg));
		   
		}
		if(!$this->form_validation->required($password))
		{
		  $msg['msg'] = translate('请输入密码');
		  die(json_encode($msg));
		   
		}
		
		if ($username AND $password)
		{
			 
			$admin = $this->admin_mdl->get_full_admin_by_username($username);
			
			 
			if ($admin)
			{
                 
				if ($admin->password == md5($password))
				{
				
					if ($admin->status == 1)
					{
						$session_items = array('aid' => $admin->id, 'gid' =>$admin->gid, 'adminname' =>$admin->adminname,'language'=>$language);
						 
						$this->session->set_userdata($session_items);
						//print_r($this->_admin->gid);
						//exit;
                        $this->db->insert('oper_log',[
                            'aid'=>$admin->id,
                            'adminname'=>$admin->adminname,
                            'type'=>"login",
                            'memo'=>'登入 ',
                            'ip'=>$this->input->ip_address(),
                            'ctime'=>time()
                        ]);
						 
						$msg['status'] =TRUE;
						$msg['msg'] = translate('登录成功');
						$msg['redirect']='/admin_system#page/admin_system/home';
					}
				   else
				   {
				   	  $msg['msg'] = translate('帐号不可用,请联系管理员');
					   
				   }
				}
				else
				{
					$msg['msg'] = translate('帐号或密码错误');
				}
				 
			}
			else
			{
				$msg['msg'] = translate('帐号不可用,请联系管理员');
			}
		}
		else
		{
			$msg['msg'] =translate('请正确填写帐号及密码') ;
		}
		 
		echo json_encode($msg);
	   
		//redirect(setting('backend_access_point') . '/login');
		 
	}

	// ------------------------------------------------------------------------
	
}
/* End of file login.php */