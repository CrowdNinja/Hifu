<?php
class Logs extends SM_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('file');
    }
    
    public function l()
    {
    	 
    		 
    		header("Content-Type: text/html; charset=utf-8");
    		//echo 'sms log:'.'<a href="../sms/'.$pwd.'" target=_blank>sms log</a><br/>';
    		//echo 'alipay log'.'<a href="../pay/'.$pwd.'" target=_blank>alipay log</a><br/>';
    		//echo 'alipay log'.'<a href="../umeng/'.$pwd.'" target=_blank>umeng log</a><br/>';
    		$logs = get_filenames(APPPATH.'/logs/');
	    	foreach($logs as $v)
	    	{
	    		echo '<a href="../logs/r/?file='.urlencode($v).'" target=_blank>'.$v.'</a><br/>';
	    	}
    	 
    }
    
    public function r()
    {
    		$file = $this->input->get('file');
    		header("Content-Type: text/html; charset=utf-8");
	    	$string = read_file(APPPATH.'/logs/'.$file);
	    	
	    	echo '<pre>'.$string.'</pre>';

    }
    //删除日志
    public function d(){
        $file = $this->input->get('file');//不传默认删除当天
        if(!$file) $file='log-'.date('Y-m-d').".php";
        @unlink('./app/logs/'.$file);
    }
}