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
class Admin_coupon extends Admin_Controller {
	/**
	 * 构造函数
	 *
	 * @access  public
	 * @return  void
	 */
	 
	private $coupon_type = array(0 => '优惠券', 1 => '返现券');
	private $user_coupon_status = array(0 => '未使用', 1 => '已使用');
	public function __construct() 
	{
		parent :: __construct();
	}

	public function index() 
	{
		$page = $this->input->get('page');
		$pagesize = $this->input->get('pagesize');
		if(empty($pagesize))$pagesize = 20;
		
		$title = trim($this->input->get('title'));
		$keywords = trim($this->input->get('keywords'));
        $createtime1 = $this->input->get('createtime1');
        $createtime2 = $this->input->get('createtime2');
        $end_time1 = $this->input->get('end_time1');
        $end_time2 = $this->input->get('end_time2');
		$this->assign('get', $this->input->get());
		
		//处理搜索SQL
		$where = ' 1=1 '.$this->_rolesql('','adminid');
		if($title){
            $where .= " and c.title like '%".$title."%'";
		}
		if($keywords){
		    $where .= " and a.nickname like '%".$keywords."%'";
        }

        if(!empty($createtime1)){
            $createtime1 = $createtime1." 00:00:00";
            $where .= " and c.ctime>='".$createtime1."'";

        }
        if(!empty($createtime2)){
            $createtime2 = $createtime2." 23:59:59";
            $where .= " and c.ctime<='".$createtime2."'";
        }
        if(!empty($end_time1)){
            $end_time1 = $end_time1." 00:00:00";
            $where .= " and c.end_time>='".$end_time1."'";
        }
        if(!empty($end_time2)){
            $end_time2 = $end_time2." 23:59:59";
            $where .= " and c.end_time<='".$end_time2."'";
        }
		//注意php代码不需要处理搜索URL参数，分页URL的处理注意本页模板页尾的JS代码
		$coupon = $this->_getpage(array('coupon as c', array('admin as a', 'c.adminid=a.id')), $where, 'c.id desc', $page, $pagesize, 'c.*,a.nickname');
		foreach($coupon['list'] as $k=>&$v){
		    $v['send_num']=$this->_getfield('user_coupon','count(1)',['couponid'=>$v['id']]);
            $v['send']=true;
		    if(strtotime($v['end_time'])<time()){
		        $v['send']=false;
            }
            $v['qrcode'] = base_url('admin_coupon/qrcode/' . $v['id']);
        }
        unset($v);
		$this->assign('coupon', $coupon);
		$this->assign('coupon_type', $this->coupon_type);
		$this->display('coupon/list_coupon.html');
	}

	public function edit($id=0){
		$post = $this->input->post();
        if ( !empty($post['title']) ){
			/*$post['getbegintime'] .= ' 0:0:0';
			$post['getendtime'] .= ' 23:59:59';
			$post['usebegintime'] .= ' 0:0:0';*/
			$post['end_time'] .= ' 23:59:59';
			if($id){
				$this->log_mdl->update('coupon', $post, 'id='.$id.$this->_rolesql('','adminid'));
			}else{
                if(!$post['adminid']) $post['adminid']=1;
                $post['ctime']=date('Y-m-d H:i:s');
				$this->log_mdl->insert('coupon', $post);
			}
			die('{"status":1}');
		}		
		if($id){
			$row = $this->_getrow('coupon', '*', 'id='.$id);
			if($row['adminid'])$row['admin_account'] = $this->_getfield('admin', 'concat(id, ", ", nickname)', 'id='.$row['adminid']);
			$row['end_time']=date('Y-m-d',strtotime($row['end_time']));
			$this->assign('row', $row);
		}
		$this->assign('coupon_type', $this->coupon_type);
		$this->display('coupon/edit_coupon.html');
	}

    //设置赠送状态
    public function set_send_status(){
        $id=$this->input->post('id');
        $status=$this->input->post('status');
        if($id){
            if($status==1){
                $this->log_mdl->update('coupon',['is_send'=>0],'1=1');
            }
            $this->log_mdl->update('coupon',['is_send'=>$status],['id'=>$id]);
            $this->admin_return(1);
        }
        $this->admin_return(0);
    }

    //优惠码二维码
    public function qrcode($id=0)
    {
        $get = $this->input->get();
        $url = $id;
        require_once(APPPATH . "libraries/phpqrcode.php");
        $errorCorrectionLevel = "H";
        $matrixPointSize = "8";
        ob_clean();//这个一定要加上，清除缓冲区
        QRcode::png($url, false, $errorCorrectionLevel, $matrixPointSize, 4, false, $get['colors'], $get['qrcodecolors']);
    }

    private function qrcode1($id=0, $text='')
    {
        $type='string';
        $get = $this->input->get();
        $url =$id;
        require_once(APPPATH."libraries/phpqrcode.php");
        $errorCorrectionLevel = "H";
        $matrixPointSize = "8";
        ob_clean();//这个一定要加上，清除缓冲区
        if ($type == 'string') {
            ob_start();
        }
        QRcode::png($url, false, $errorCorrectionLevel, $matrixPointSize, 4, false, $get['colors'], $get['qrcodecolors']);
        if ($type == 'string') {
            $image = ob_get_contents();
            ob_end_clean();

            if ($text) {
                $im = imagecreatefromstring($image);
                $width = imagesx($im);
                $height = imagesy($im);
                $newimg = imagecreatetruecolor($width, $height + 20);
//                $newbg = imagecolorallocatealpha($newimg, 0, 0, 0, 127);
//                imagealphablending($newimg, false);
//                imagefill($newimg, 0, 0, $newbg);
                imagefill($newimg, 0, 0, imagecolorallocate($newimg, 255, 255, 255));//白色背景
                imagecopyresampled($newimg, $im, 0, 0, 0, 0, $width, $height, $width, $height);
                $fontfile = BASEPATH . 'fonts/texb.ttf';
                $fontinfo = imagettfbbox(18, 0, $fontfile, $text);
                $fontwidth = abs($fontinfo[4] - $fontinfo[0]);
                //$fontheight = abs($fontinfo[5] - $fontinfo[1]);
                imagefttext($newimg, 18, 0, floor(($width - $fontwidth) / 2), $height, imagecolorallocate($newimg, 0, 0, 0), $fontfile, $text);
                imagesavealpha($newimg, true);
                ob_start();
                imagepng($newimg);
                $image = ob_get_contents();
                ob_end_clean();
            }

            return $image;
        }
    }
    //导出优惠券二维码
    public function export()
    {
        set_time_limit(0);
        $ids = $this->input->post('ids');
        $coupon = $this->_getlist('coupon','*','id in ('.$ids.')');
        $zip = new ZipArchive();
        $filename = './temp/qr.zip';
        if ($zip->open($filename, file_exists($filename)?ZipArchive::OVERWRITE:ZipArchive::CREATE) === TRUE) {
            foreach ($coupon as $k => $v) {
                $zip->addFromString($v['id'] . '.png', $this->qrcode1($v['id'],$v['id']));
            }
            $zip->close();

        }
        echo json_encode(array('status' => 1, 'url' => '/temp/qr.zip'));
    }
	public function delete(){
		$ids = $this->input->post('ids');
		if(!empty($ids)){
			$this->log_mdl->delete('coupon',"id in($ids) ".$this->_rolesql('','adminid'));
            $this->log_mdl->delete('user_coupon',"couponid in($ids)");
		}
		die('{"status":1}');	
	}
	
	public function clear(){
		$this->log_mdl->delete('coupon', ' 1=1 '.$this->_rolesql('','adminid'));
		die('{"status":1}');	
	}
	
	public function give(){
		$post = $this->input->post();
		if($post['couponid']){
			$coupon = $this->_getrow('coupon', '*', ['id'=>$post['couponid']]);
			if(!$coupon)$this->admin_return(0,'优惠券无法领取');
			if(strtotime($coupon['end_time'])<time())$this->admin_return(0,'优惠券已经过期');
			//if($coupon['amount'] && $coupon['gettotal'] >= $coupon['amount'])die('{"status":0,"msg":"活动券已经领完了"}');
			$touserids = array_filter(explode(',', $post['touserids']));
			if(!$touserids)$touserids = $this->_getcol('user', 'id', '1=1');
			foreach($touserids as $v){
				/*if($coupon['amount'] && $coupon['gettotal'] >= $coupon['amount'])die('{"status":0,"msg":"活动券已经领完了"}');
				$mytotal = (int)$this->_getcount('user_coupon', 'userid='.$v.' and couponid='.$post['couponid']);
				if($coupon['limit'] && $mytotal >= $coupon['limit'])continue*/;
				$data=[
				    'couponid'=>$coupon['id'],
                    'userid'=>$v,
                    'title'=>$coupon['title'],
                    'desc'=>$coupon['desc'],
                    'money'=>$coupon['money'],
                    'end_time'=>$coupon['end_time'],
                    'ctime'=>date("Y-m-d H:i:s"),
                    'limit_money'=>$coupon['limit_money'],
                    'adminid'=>$coupon['adminid']
                ];
				$this->log_mdl->insert('user_coupon', $data);
			}
            $this->admin_return(1,'优惠券发放完成');
		}
		
		$get = $this->input->get();
		if($get['couponid']){
			$this->assign('get', $get);
			$this->assign('get_couponid_title', $this->_getfield('coupon', 'concat(id, ", ", title) as `text`', "id=".$get['couponid']));
		}
		$this->display('coupon/give_coupon.html');
	}
	
	public function search(){
		$keywords = $this->input->post('keywords');
		if(!empty($keywords)){
			$where = "(id='".$keywords."' or title like '%".$keywords."%')".$this->_rolesql('','adminid');
			$result = $this->_getlist('coupon', 'id, concat(id, ", ", title) as `text`', $where, 'id desc');
			die('{"status":-1, "data":'.json_encode($result).'}');
		}
		die('{"status":-1, "data":[]}');
	}

	public function user_coupon(){
		$page = $this->input->get('page');
		$pagesize = $this->input->get('pagesize');
		if(empty($pagesize))$pagesize = 20;

		$userid = $this->input->get('userid');
		$adminid = $this->input->get('adminid');
		$couponid = $this->input->get('couponid');
		$createtime1 = $this->input->get('createtime1');
		$createtime2 = $this->input->get('createtime2');
		$usetime1 = $this->input->get('usetime1');
		$usetime2 = $this->input->get('usetime2');
		$type = $this->input->get('type');
		$status = $this->input->get('status');
		$this->assign('get', $this->input->get());
		
		//处理搜索SQL
		$where = ' 1=1 '.$this->_rolesql('c');
		if(is_numeric($userid)){
			$where .= ' and c.userid='.$userid;
			$this->assign('get_userid_account', $this->_getfield('user', 'if(account=nickname,concat(id, ", ", account),concat(id, ", ", account, ", ", nickname))', 'id='.$userid));
		}
		if(is_numeric($adminid)){
			$where .= ' and c.adminid='.$adminid;
			$this->assign('get_adminid_account', $adminid ? $this->_getfield('admin', 'concat(id, ", ", nickname)', 'id='.$adminid) : '通用');
		}
		if(is_numeric($couponid)){
			$where .= ' and c.couponid='.$couponid;
			$this->assign('get_couponid_title', $this->_getfield('coupon', 'concat(id, ", ", title)', 'id='.$couponid));
		}
		if(is_numeric($type)){
			$where .= ' and c.type='.$type;
		}
		if(is_numeric($status)){
			$where .= ' and c.status='.$status;
		}
		if(!empty($createtime1)){
			$createtime1 .= ' 00:00:00';
			$where .= " and c.ctime>='".$createtime1."'";
		}
		if(!empty($createtime2)){
			$createtime2 .= ' 23:59:59';
			$where .= " and c.ctime<='".$createtime2."'";
		}
		if(!empty($usetime1)){
			$usetime1 .= ' 00:00:00';
			$where .= " and c.usetime>='".$usetime1."'";
		}
		if(!empty($usetime2)){
			$usetime2 .=' 23:59:59';
			$where .= " and c.usetime<='".$usetime2."'";
		}
		
		$coupon = $this->_getpage(array('user_coupon as c', array('admin as a', 'c.adminid=a.id')), $where, 'c.id desc', $page, $pagesize, 'c.*,a.nickname');
		foreach($coupon['list'] as &$v){
			$v['user_account'] = $this->_getfield('user', 'if(account=nickname,concat(id, ", ", account),concat(id, ", ", account, ", ", nickname))', 'id='.$v['userid']);
			$v=$this->replace_null_time($v);
		}
		unset($v);
		$this->assign('coupon', $coupon);		
		$this->assign('coupon_type', $this->coupon_type);
		$this->assign('user_coupon_status', $this->user_coupon_status);
		$this->display('coupon/list_user_coupon.html');
	}
}