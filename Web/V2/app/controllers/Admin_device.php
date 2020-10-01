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
class Admin_device extends Admin_Controller {
	/**
	 * 构造函数
	 *
	 * @access  public
	 * @return  void
	 */
	 
	private $device_status = array("on_line" => '<b style="color:green;">在线</b>', "off_line" => '<b style="color:red;">离线</b>',0=>"<b style='color:green;'>空闲</b>",1=>"<b style='color:goldenrod;'>使用中</b>",2=>"<b style='color:red;'>异常</b>");
	private $device_type=[1=>'美容机',2=>"脱毛机"];
	private $rate=[1=>9600,2=>76800];
	public function __construct()
	{
		parent :: __construct();
		$this->load->model('setting_mdl');
	}

	public function index() 
	{
		$page = $this->input->get('page');
		$pagesize = $this->input->get('pagesize');
		if(empty($pagesize))$pagesize = 20;
		
		$keywords = trim($this->input->get('keywords'));
		$address = trim($this->input->get('address'));
		$room = trim($this->input->get('room'));
		$status = $this->input->get('status');
		$type = $this->input->get('type');
		$device_son_type_id = $this->input->get('device_son_type_id');
		$_status = $this->input->get('_status');
		$corpid = $this->input->get('corpid');
		$adminid = $this->input->get('adminid');
		$this->assign('get', $this->input->get());
		
		//处理搜索SQL

        $where = '1=1'.$this->_rolesql('',$this->_getrolefield());
		if($keywords){
			$where .= " and macno like '%$keywords%'";	
		}
        if($address){
            $where .= " and address like '%$address%'";
        }
        if($device_son_type_id) $where.=' and device_son_type_id='.$device_son_type_id;
        if($room){
            $where .= " and room like '%$room%'";
        }
        if(is_numeric($status)){
            $where.=" and status=$status";
        }
        if($status=='on_line') $where.=" and beat_time>'".date('Y-m-d H:i:s')."'";
        if($status=='off_line') $where.=" and beat_time<'".date('Y-m-d H:i:s')."'";

        if(is_numeric($type)){
            $where.=" and type=$type";
        }
		if(is_numeric($corpid)){
			$corp_adminid = $this->_corpaids($corpid);
			if(!$corp_adminid)$corp_adminid = '0';
			$where .= " and adminid in (".$corp_adminid.")";	
			$this->assign('get_corpid_account', $this->_getfield('admin', 'concat(id, ", ", nickname)', 'id='.$corpid));
		}
		if(is_numeric($adminid)){
			$where .= " and adminid=$adminid";	
			$this->assign('get_adminid_account', $this->_getfield('admin', 'concat(id, ", ", nickname)', 'id='.$adminid));
		}
		if($_status){
		    if($_status==1){
		        $where.=" and beat_time>'".date('Y-m-d H:i:s')."'";
            }else{
                $where.=" and beat_time<'".date('Y-m-d H:i:s')."'";
            }
        }

		//注意php代码不需要处理搜索URL参数，分页URL的处理注意本页模板页尾的JS代码
		$device = $this->_getpage('device', $where, 'id desc', $page, $pagesize);
        if($_SESSION['language']==1){//中文
            $fields="chinese_name as name";
        }else{//日文
            $fields="japanese_name as name";
        }
		foreach($device['list'] as &$v){
            $v['_adminid'] = $this->_getfield('admin', 'concat(id, " ,", nickname)', 'id='.$v['adminid']);
            $v['_corpid'] = $this->_getfield('admin', 'concat(id, " ,", nickname)', 'id='.$v['agent_id']);
			if(strtotime($v['beat_time'])>time()){
			    $v['_status']=$this->device_status["on_line"];
            }else{
			    $v['_status']=$this->device_status["off_line"];
            }
            $v=$this->replace_null_time($v);
			$v['device_son_type_name']=$this->_getfield('device_son_type',$fields,['id'=>$v['device_son_type_id']])?:"";
		}
		unset($v);

        $device_son_type=$this->_getlist('device_son_type',"id,".$fields,'1=1');
        $this->assign('device_son_type',$device_son_type);
		$this->assign('device', $device);
		$this->assign('device_status', $this->device_status);
		$this->assign('device_type', $this->device_type);
		$this->assign('page', $page);
		$this->display('device/list_device.html');
	}


	public function edit($id=0,$page=1){
		$post = $this->input->post();
        if($id){
            $row = $this->_getrow('device', '*', 'id='.$id.$this->_rolesql('',$this->_getrolefield()));
            $row['adminid_account'] = $this->_getfield('admin', 'concat(id, " ,", nickname)', 'id='.$row['adminid']);
            $row['agent_name'] = $this->_getfield('admin', 'concat(id, " ,", nickname)', 'id='.$row['agent_id']);
            $row= $this->replace_null_time($row);
            $this->assign('row', $row);
        }
        if ( !empty($post['macno']) ){
			$count = $this->_getcount('device', ($id ? "id<>$id and " : "") . "macno='".$post['macno']."'");
			if($count) $this->admin_return(0,'设备号重复');
            if($post['adminid']){
                $parent=$this->_getrow('admin','corpid',['id'=>$post['adminid']]);
                $post['agent_id']=$parent['corpid'];
            }
            if($post['type']!=0){//1美容 2脱毛
                $rate=$this->rate[$post['type']];
            }
			if($id){
				$this->log_mdl->update('device', $post, 'id='.$id.$this->_rolesql('',$this->_getrolefield()));
				if(($row['type']==0 || $row['type']!=$post['type']) && $post['type']!=0){
                    $res=$this->_setParam($post['macno'],$rate,$post['type']);//设置成功保存波特率
                    if($res['data']['result']==0 && $res['code']==1 && isset($res['data'])) $this->db->update('device',['rate'=>$res['data']['rate']?:0],['id'=>$id]);
                }
			}else{
			    $post['createtime']=date('Y-m-d H:i:s');
				$id=$this->log_mdl->insert('device', $post);//9600
				if($post['type']!=0) {
				    $res=$this->_setParam($post['macno'],$rate,$post['type']);
				    if($res['data']['result']==0 && $res['code']==1 && isset($res['data'])) $this->db->update('device',['rate'=>$res['data']['rate']?:0],['id'=>$id]);
                }
			}
			$this->admin_return(1);
		}		
		if($id){
			$row = $this->_getrow('device', '*', 'id='.$id.$this->_rolesql('',$this->_getrolefield()));
			$row['adminid_account'] = $this->_getfield('admin', 'concat(id, " ,", nickname)', 'id='.$row['adminid']);
			$row['agent_name'] = $this->_getfield('admin', 'concat(id, " ,", nickname)', 'id='.$row['agent_id']);
			$row= $this->replace_null_time($row);
			$this->assign('row', $row);
		}
        $shop_where = "  gid in (".implode(",", $this->_role[2]).")".$this->_rolesql('a', 'id');
		$shop=$this->_getlist('admin as a', 'a.id, concat(a.id, ", ", a.nickname) as nickname', $shop_where, 'a.id desc');
		if($_SESSION['language']==1){//中文
            $fields="id,chinese_name as name";
        }else{//日文
            $fields="id,japanese_name as name";
        }
		$device_son_type=$this->_getlist('device_son_type',$fields,'1=1');
		$this->assign('device_son_type',$device_son_type);
		$this->assign('shop',$shop);
        $this->assign('geocoder_key', $this->config->item('geocoder_key'));
		$this->assign('device_status', $this->device_status);
        $this->assign('device_type', $this->device_type);

        $this->assign('page',$page);
		$this->display('device/edit_device.html');
	}


	public function delete(){
		$ids = $this->input->post('ids');
		if(!empty($ids)){
			$this->log_mdl->delete('device',"id in($ids)".$this->_rolesql('',$this->_getrolefield()));
		}
		$this->admin_return(1);
	}
	
	public function clear(){
		$this->log_mdl->delete('device', '1=1'.$this->_rolesql('',$this->_getrolefield()));
        $this->admin_return(1);
	}

	public function check(){
		$id = $this->input->post('id');
		$macno = $this->input->post('macno');
		if(!empty($macno)){
			$where = "macno='".$macno."'";
			if(!empty($id))$where .= " and id<>".$id;
			$count = $this->_getcount('device', $where);
            $this->admin_return($count);
		}
        $this->admin_return('-1');
	}
	//设备子类型管理
    public function device_son_type(){
	    $page=$this->input->get('page');
	    $name=trim($this->input->get('name'));
	    $this->assign('get',$this->input->get());
	    $where='1=1';
	    if($name) $where.=" and (chinese_name like'%".$name."%' or japanese_name like'%".$name."%')";
	    $list=$this->_getpage('device_son_type',$where,'id desc',$page,20);
	    $this->assign('list',$list);
	    $this->display('device/device_son_type.html');
    }
    public function delete_device_son_type(){
        $ids = $this->input->post('ids');
        if(!empty($ids)){
            $this->log_mdl->delete('device_son_type',"id in($ids)");
        }
        $this->admin_return(1);
    }
    //编辑修改子类型
    public function edit_device_son_type($id=0){
	    $post=$this->input->post();
	    if($post){
	        if($id){
	            $this->db->update('device_son_type',$post,['id'=>$id]);
            }else{
	            $post['ctime']=date('Y-m-d H:i:s');
	            $this->db->insert('device_son_type',$post);
            }
            $this->admin_return(1);
        }
        if($id){
            $row=$this->_getrow('device_son_type','*',['id'=>$id]);
        }
        $this->assign('row',$row);
        $this->display('device/edit_device_son_type.html');
    }
    //设置设备子类型
    public function set_device_son_type(){
        $ids=$this->input->get('ids');
        $post=$this->input->post();
        if(!$ids) $ids=$post['ids'];
        if($post){
            $list=$this->_getlist('device','id,macno',"id in($ids)");

            foreach($list as $k=>$v){
                $this->db->update('device',['device_son_type_id'=>$post['device_son_type_id']],['id'=>$v['id']]);
            }
            $this->admin_return(1);

        }
        if($_SESSION['language']==1){//中文
            $fields="id,chinese_name as name";
        }else{//日文
            $fields="id,japanese_name as name";
        }
        $device_son_type=$this->_getlist('device_son_type',$fields,'1=1');
        $this->assign('device_son_type',$device_son_type);
        $this->assign('ids',$ids);
        $this->display('device/set_device_son_type.html');
    }
	//设置参数
    public function set_device(){
	    $ids=$this->input->get('ids');
	    $post=$this->input->post();
	    if(!$ids) $ids=$post['ids'];
	    if($post){
	        $list=$this->_getlist('device','id,macno',"id in($ids)");
            if($post['type']!=0){//1美容 2脱毛
                $rate=$this->rate[$post['type']];
            }
	        foreach($list as $k=>$v){
                if($post['apn']){
                    $res3=$this->_setAPN($v['macno'],$post['apn']);
                    if($res3['code']==1 && isset($res3['data']) && $res3['data']['result']==0){
                        $this->db->update('device',['apn'=>$post['apn']],['id'=>$v['id']]);
                    }
                }
                if($post['username']){
                    $res=$this->_setUserName($v['macno'],$post['username']);
                    if($res['code']==1 && isset($res['data']) &&  $res['data']['result']==0){
                        $this->db->update('device',['username'=>$post['username']],['id'=>$v['id']]);
                    }
                }
                if($post['password']){
                    $res2=$this->_setPassword($v['macno'],$post['password']);
                    if($res2['code']==1 && isset($res2['data']) && $res2['data']['result']==0){
                        $this->db->update('device',['password'=>$post['password']],['id'=>$v['id']]);
                    }
                }
                if($post['type']!=0) {
                    $res=$this->_setParam($v['macno'],$rate,$post['type']);
                    if($res['data']['result']==0 && $res['code']==1 && isset($res['data'])) $this->db->update('device',['rate'=>$res['data']['rate']?:0],['id'=>$v['id']]);
                }

            }
            $this->admin_return(1);

        }
        $device=$this->_getrow('device','macno',"id in($ids)",'id desc');
	    $row=[];
        $row['apn']=$this->_getAPN($device['macno'])['data']['value'];
        $row['username']=$this->_getUserName($device['macno'])['data']['value'];
        $row['password']=$this->_getPassword($device['macno'])['data']['value'];
        if($device['macno']){
            $res=$this->_getParam($device['macno']);
            if($res['code']==1 && isset($res['data']) && $res['data']['result']==0){
                $row['rate']=$res['data']['rate'];
            }
        }

        $this->assign('ids',$ids);
        $this->assign('row',$row);
        $this->assign('device_type', $this->device_type);
        $this->assign('rate', $this->rate);
	    $this->display('device/set_device.html');
    }

	public function search(){
		$keywords = $this->input->post('keywords');
		if(!empty($keywords)){
			$where = "(id='".$keywords."' or macno like '%".$keywords."%')".$this->_rolesql('',$this->_getrolefield());
			$result = $this->_getlist('device', 'id, concat(id, ", ", macno) as `text`', $where, 'id desc');
			$this->admin_return(-1,'',json_encode($result));
		}
        $this->admin_return(-1);
	}


    public function dlqrcode()
    {
		set_time_limit(0);
		$ids = $this->input->post('ids');
		$type=$this->input->post('type');
		$where = '1=1'.$this->_rolesql('',$this->_getrolefield());
		if($ids)$where .= ' and id in ('.$ids.')';
        $device = $this->_getlist('device','*',$where);
        $zip = new ZipArchive();
        $filename = './temp/qr.zip';
        if ($zip->open($filename, file_exists($filename)?ZipArchive::OVERWRITE:ZipArchive::CREATE) === TRUE) {
            foreach ($device as $k => $v) {
				$qrcode = $this->_dlqrcode($v['macno'], $v['macno'],'string',$type);
				$zip->addFromString($v['macno'].'.png', $qrcode);
            }
            $zip->close();
        }
        echo json_encode(array('status' => 1, 'url' => '/temp/qr.zip'));
    }

	private function _dlqrcode($macno, $text = '', $type = 'string',$is_wx=1){
        $url = concaturl('http://weixin.qq.com/r/lTnx6VLEFQ9qrRaK92yH?macno='.$macno);
        if($is_wx==2)$url = concaturl('https://qr.alipay.com/ppx06089sziltbo1eprev9a?macno='.$macno);
		require_once(APPPATH."libraries/phpqrcode.php");
		$errorCorrectionLevel = "L";
		$matrixPointSize = "8";
		ob_clean();//这个一定要加上，清除缓冲区
		if($type == 'string'){
			ob_start();
		}
		QRcode::png($url, false, $errorCorrectionLevel, $matrixPointSize, 4, false);
		if($type == 'string'){
			$image = ob_get_contents();
			ob_end_clean();
			
			if($text){
				$im = imagecreatefromstring($image);
				$width = imagesx($im);
				$height = imagesy($im);
				$newimg = imagecreatetruecolor($width, $height + 20);
				//$newbg = imagecolorallocatealpha($newimg, 0, 0, 0, 127);
				//imagealphablending($newimg, false);
				//imagefill($newimg, 0, 0, $newbg);
				imagefill($newimg, 0, 0, imagecolorallocate($newimg, 255, 255, 255));//白色背景
				imagecopyresampled($newimg, $im, 0, 0, 0, 0, $width, $height, $width, $height);
				$fontfile = BASEPATH.'fonts/texb.ttf';
				$fontinfo = imagettfbbox(14, 0, $fontfile, $text);
				$fontwidth = abs($fontinfo[4] - $fontinfo[0]);
				//$fontheight = abs($fontinfo[5] - $fontinfo[1]);
				imagefttext($newimg, 14, 0, floor(($width - $fontwidth) / 2), $height, imagecolorallocate($newimg, 0, 0, 0), $fontfile, $text);
				imagesavealpha($newimg, true);
				ob_start();
				imagepng($newimg);
				$image = ob_get_contents();
				ob_end_clean();
			}
			return $image;
		}
	}

    public function device_pack($macno='', $pages=1)
    {

        $page = $this->input->get('page');
        $aid = $this->input->get('aid');
        $p = $this->input->get('p');
        $ps = $this->input->get('ps');
        //$row = $this->_getpage(array('device_pack as a', array('pack as b', 'a.pack_id=b.id'), array('device as c', 'a.macno=c.macno')), $where, 'a.id desc', $page,  10, 'a.macno,a.pack_id,b.title,b.price,b.minute');
        $device=$this->_getrow('device','*',['macno'=>$macno]);
        if($device['adminid']){
            $pack_where="adminid=".$device['adminid'];
            $row = $this->_getpage("pack", $pack_where, 'id desc', $page, 10, '*');
        }
        if(!$row['list']){
            $pack_where="adminid=".$device['agent_id'];
            $row = $this->_getpage("pack", $pack_where, 'id desc', $page, 10, '*');
        }
        $this->assign('row', $row);
        $this->assign('macno', $macno);
        $this->assign('pages', $pages);
        $this->assign('aid', $aid);
        $this->assign('p', $p);
        $this->assign('ps', $ps);
        $this->display('device/device_pack.html');
    }
    //设置设备套餐
    public function edit_device_pack($macno='')
    {
        //$macno = $this->input->get('macno');
        // 获取未绑定代理的全部设备 --------
        // 1. 获取绑定套餐的设备
        $arrSetList = array();
        $page = $this->input->get('page');
        $arrSetList = $this->_getlist('device_pack', 'macno,pack_id', 'macno="' . $macno . '"');
        // 2. 获取全部套餐
        $arrGetList = $this->_getlist('pack', 'id,title', '1=1'.$this->_rolesql('','adminid'));
        //log_message("error",$this->db->last_query());

        // 3. 遍历去掉已绑定套餐的设备
        foreach ($arrGetList as $k => $v) {
            foreach ($arrSetList as $k1 => $v1) {
                if ($v['id'] == $v1['pack_id'])
                    unset($arrGetList[$k]);
            }
        }

        // 获取当前设备绑定的套餐
        //$arrExitList = $this->_getlist('ads_lib', 'id,title'," id in (select ads_id from device_advertise where macno='".$macno."')");
        $arrExitList = $this->_getlist(array('pack as a', array('device_pack as b', 'a.id=b.pack_id')), 'a.id,a.title', "b.macno='" . $macno . "'");

        $this->assign('arrGetList', $arrGetList); // 未绑定套餐的设备列表
        $this->assign('arrExitList', $arrExitList); // 已绑定该套餐的设备列表
        $this->assign("macno", $macno);
        $this->assign("page", $page);
        $this->display('device/edit_device_pack.html');
    }

    // 设置设备套餐
    public function get_mac_list($macno='')
    {
        $data = $this->input->post();

        // 删除这台设备的所有套餐
        $this->db->delete('device_pack', 'macno="' . $macno . '"');
        // 添加新的绑定设备
        if (is_array($data) && !empty($data)) {
            foreach ($data['wareA'] as $k => $v) {
                $getData = array();
                $getData['macno'] = $macno;
                $getData['pack_id'] = $v;
                $this->db->insert('device_pack', $getData);
            }
        }
        $url = $data['url'];
        //$macno=$macno.'?aid='.$data['aid'].'&p='.$data['page'].'&identity='.$data['identity'];
        //"/admin_system#page/admin_device/device_pack/<{$macno}>?aid=<{$aid}>&p=<{$page}>&identity=<{$identity}>"
        echo '<script>alert("绑定套餐成功");location.href="' . $url . '";</script>';
    }
    //批量设置套餐
    public function package_list()
    {
        $device_ids = $this->input->get('device_ids');
        $page = $this->input->get('page');
        $pagesize = $this->input->get('pagesize');
        if (empty($pagesize)) $pagesize = 20;

        $createtime1 = $this->input->get('createtime1');
        $createtime2 = $this->input->get('createtime2');
        $this->assign('get', $this->input->get());

        //处理搜索SQL
        $where = ' 1=1 '.$this->_rolesql('','adminid');


        if (!empty($createtime1)) {
            $createtime1 = formattime($createtime1 . ' 00:00:00');
            $where .= " and createtime>=" . $createtime1;
        }
        if (!empty($createtime2)) {
            $createtime2 = formattime($createtime2 . ' 23:59:59');
            $where .= " and createtime<=" . $createtime2;
        }

        //注意php代码不需要处理搜索URL参数，分页URL的处理注意本页模板页尾的JS代码
        $pack = $this->_getpage('pack_type', $where, 'id desc', $page,  $pagesize);
        foreach ($pack['list'] as $k => $v) {
            if ($v['aid'] != 1) {
                $pack['list'][$k]['agent_name'] = $this->_getfield('admin', 'nickname', 'id=' . $v['adminid']);
            } else {
                $pack['list'][$k]['agent_name'] = "总后台";
            }

            $pack['list'][$k]['pack_num'] = $this->_getfield('pack', 'count(1)', ['type_id' => $v['id']]);
        }
        $p = $this->input->get('p');
        $this->assign('p', $p ?: 1);
        $this->assign('pack', $pack);
        $this->assign('device_ids', $device_ids);
        $this->display('device/list_pack.html');
    }
    //提交套餐
    public function device_package()
    {
        $device_ids = $this->input->post('device_ids');
        $pack_ids = $this->input->post('pack_ids');
        //获取设备号
        $macnos = $this->_getfield('device', 'GROUP_CONCAT(macno) as macno', "id in ($device_ids)");
        //获取套餐id
        $pack_ids = $this->_getfield('pack', 'GROUP_CONCAT(id) as ids', "type_id in($pack_ids)");
        if (!$pack_ids) die('{"status":0,"msg":"该套餐分类没有套餐！"}');

        //删除设备套餐
        $this->db->delete('device_pack', "macno in('$macnos')");

        $arr_pack = explode(',', $pack_ids);
        //插入套餐表
        $arr_device = explode(',', $macnos);
        foreach ($arr_pack as $k => $v) {
            foreach ($arr_device as $kk => $vv) {
                $data = [
                    'macno' => $vv,
                    'pack_id' => $v
                ];
                $this->db->insert('device_pack', $data);
            }
        }
        die('{"status":1}');

    }
    //导入设备
    public function import()
    {
        $excelfile = $_FILES['import']['tmp_name'];
        include_once APPPATH . 'libraries/PHPExcel/PHPExcel.php';
        $reader = new PHPExcel_Reader_Excel2007();
        if (!$reader->canRead($excelfile)) {
            $reader = new PHPExcel_Reader_Excel5();
            if (!$reader->canRead($excelfile)) {
                echo '<script>alert("' . translate("文件格式错误") . '");location.href="/admin_system#page/admin_device/"</script>';
                exit;
            }
        }

        $excel = $reader->load($excelfile);
        $sheet = $excel->getActiveSheet();
        $highestRow = $sheet->getHighestRow();
        if ($highestRow < 2) {
            echo '<script>alert("' . translate("文件不包含数据或数据与存在") . '");location.href="/admin_system#page/admin_device/"</script>';
            exit;
        }
        $highestColumn = $sheet->getHighestColumn();
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
        $data = array();
        for ($row = 2; $row <= $highestRow; $row++) {
            $cell = $sheet->getCellByColumnAndRow(13, $row);
            $value = $cell->getValue();
            $p_value = PHPExcel_Shared_Date::ExcelToPHP($value);

           /* $data=[
                'chinese'=>$sheet->getCellByColumnAndRow(0, $row)->getValue(),
                'japanese'=>$sheet->getCellByColumnAndRow(1, $row)->getValue(),
            ];
            $check=$this->_getfield('language',"id",['chinese'=>$data['chinese']]);
            if(!$check){
                $this->db->insert('language',$data);
            }else{
                $this->db->update('language',['japanese'=>$data['japanese']],['id'=>$check]);
            }*/

            $data[$row] = array(
                'macno' => $sheet->getCellByColumnAndRow(0, $row)->getValue(), //设备号
                'agent_id' => $sheet->getCellByColumnAndRow(1, $row)->getValue()?:0, //代理商id
                'adminid' => $sheet->getCellByColumnAndRow(2, $row)->getValue()?:0, //商户id
                'address' => $sheet->getCellByColumnAndRow(3, $row)->getValue()?:"", //地址
                'createtime' => date('Y-m-d H:i:s'),
            );

            foreach ($data as $k => $v){
                foreach ($data[$k] as $kk => $vv) {
                    if (empty($vv)) unset($data[$k][$kk]);
                    if ($kk == 'macno') {
                        if ($this->_getrow('device', '*', 'macno="' . $vv . '"')) unset($data[$k]);
                    }
                }
            }
            if (count($data)){
                $this->db->insert('device', $data[$row]);
            }
        }

        if (count($data)) {
            unset($data);
            echo '<script>alert("' . translate("数据导入成功") . '");location.href="/admin_system#page/admin_device/"</script>';
            exit;
        }
        echo '<script>alert("' . translate("文件不包含数据或数据与存在") . '");location.href="/admin_system#page/admin_device/"</script>';
        exit;
    }


    /**
     * 予約管理用機器設定一覧表示
     */
    public function list_reserve_device()
    {
        $page = $this->input->get('page');
		$pagesize = $this->input->get('pagesize');
        if(empty($pagesize))$pagesize = 20;
        
        // get parameter
		$adminid = $this->input->get('adminid');
        $this->assign('get', $this->input->get());
        
        $where = '1=1';
        if(is_numeric($adminid)){
			$where .= " and admin_id=$adminid";	
			$this->assign('get_adminid_account', $this->_getfield('admin', 'concat(id, ", ", nickname)', 'id='.$adminid));
		}

        // 設備名取得
        $deviceSonTypeArray = $this->_getlist('device_son_type', '*', '', 'id asc');
        $deviceSonTypeList = array();
        $language = $_SESSION['language']? : 2;
        $nameKey = 'japanese_name';
        if($language == 1){ // 中国語
            $nameKey = 'chinese_name';
        }
        foreach($deviceSonTypeArray as $k=>$v){
            $deviceSonTypeList[$v['id']] = $v[$nameKey];
        }

        $shopDeviceAdmin = $this->_getpage(array('shop_device_admin as a', array('admin as b', 'a.admin_id=b.id')), $where, 'id desc', $page, $pagesize, array('*', 'a.admin_id'));

        // 店舗機器管理情報取得
        $shopDeviceArray = $this->_getlist('shop_device_admin', '*', $where, 'admin_id asc, device_son_type_id asc');

        // 一覧表示用配列作成
        $shopDeviceList = array();
        $shopDeviceInfo = array();
        $adminId = null;
        foreach($shopDeviceArray as $k=>$v){
            if(empty($adminId) || $adminId != $v['admin_id']){
                if(!empty($shopDeviceInfo)){
                    $shopDeviceList[] = $shopDeviceInfo;
                    $shopDeviceInfo = array();
                }
                $adminId = $v['admin_id'];
                $shopDeviceInfo['admin_id'] = $adminId;
                $shopDeviceInfo['shop_name'] = $this->_getfield('admin', 'nickname', 'id='.$adminId);
                $shopDeviceInfo[$v['device_son_type_id']] = $v['device_count'];
            }else{
                $shopDeviceInfo[$v['device_son_type_id']] = $v['device_count'];
            }
        }
        if(!empty($shopDeviceInfo)){
            $shopDeviceList[] = $shopDeviceInfo;
        }

        if(empty($page)){
            $page = 1;
        }
        $start_no = ($page - 1) * $pagesize; // 配列の何番目から取得すればよいか
 
        $shopDeviceList = array_slice($shopDeviceList, $start_no, $pagesize, true);

        $this->assign('shopDeviceAdmin', $shopDeviceAdmin);
        $this->assign('deviceSonTypeList', $deviceSonTypeList);
        $this->assign('shopDeviceList', $shopDeviceList);

        // アカウント種別が加盟店の時
        if($_SESSION['gid'] == 4){
            $this->assign('member_store_id', $_SESSION['aid']);
            $this->assign('get_adminid_account', $this->_getfield('admin', 'concat(id, ", ", nickname)', 'id=' . $_SESSION['aid']));
        }
        $this->assign('gid', $_SESSION['gid']);

        $this->display('device/list_reserve_device.html');
    }

    /**
     * 予約管理用機器設定一覧用店舗名検索
     */
    public function reserve_device_shop_search()
    {
        $keywords = $this->input->post('keywords');
        if (!empty($keywords)) {
            $where = "(a.id='" . $keywords . "' or concat(a.nickname,a.phone,a.mobile,a.adminname,a.address,a.name) like '%" . $keywords . "%') and gid in (" . implode(",", $this->_role[2]) . ")" . $this->_rolesql('a', 'id');
            $result = $this->_getlist('admin as a', 'a.id, concat(a.id, ", ", a.nickname) as `text`', $where, 'a.id desc');
            die('{"status":-1, "data":' . json_encode($result) . '}');
        }
        die('{"status":-1, "data":[]}');
    }

    /**
     * 予約管理用機器設定一覧検索
     */
    public function reservation_device_search()
    {
        $keywords = $this->input->post('keywords');
        if (!empty($keywords)) {
            // 設備名取得
            $deviceSonTypeArray = $this->_getlist('device_son_type', '*', '', 'id asc');
            $deviceSonTypeList = array();
            $language = $_SESSION['language']? : 2;
            $nameKey = 'japanese_name';
            if($language == 1){ // 中国語
                $nameKey = 'chinese_name';
            }
            foreach($deviceSonTypeArray as $k=>$v){
                $deviceSonTypeList[$v['id']] = $v[$nameKey];
            }

            // 店舗機器管理情報取得
            $where = "(a.id='" . $keywords . "' or concat(a.nickname,a.phone,a.mobile,a.adminname,a.address,a.name) like '%" . $keywords . "%') and gid in (" . implode(",", $this->_role[2]) . ")" . $this->_rolesql('a', 'id');
            $adminArray = $this->_getlist('admin as a', 'a.id, concat(a.id, ", ", a.nickname) as `text`', $where, 'a.id desc');
            $adminIds = "";
            foreach($adminArray as $admin){
                if(empty($adminIds)){
                    $adminIds = $admin['id'];
                }else{
                    $adminIds .= ','.$admin['id'];
                }
            }

            $shopDeviceArray = $this->_getlist('shop_device_admin', '*', 'admin_id in ('.$adminIds.')', 'admin_id asc, device_son_type_id asc');

            // 一覧表示用配列作成
            $shopDeviceList = array();
            $shopDeviceInfo = array();
            $adminId = null;
            foreach($shopDeviceArray as $k=>$v){
                if(empty($adminId) || $adminId != $v['admin_id']){
                    if(!empty($shopDeviceInfo)){
                        $shopDeviceList[] = $shopDeviceInfo;
                        $shopDeviceInfo = array();
                    }
                    $adminId = $v['admin_id'];
                    $shopDeviceInfo['admin_id'] = $adminId;
                    $shopDeviceInfo['shop_name'] = $this->_getfield('admin', 'nickname', 'id='.$adminId);
                    $shopDeviceInfo[$v['device_son_type_id']] = $v['device_count'];
                }else{
                    $shopDeviceInfo[$v['device_son_type_id']] = $v['device_count'];
                }
            }
            if(!empty($shopDeviceInfo)){
                $shopDeviceList[] = $shopDeviceInfo;
            }
            die('{"status":-1, "data":' . json_encode($shopDeviceList) . '}');
        }
        die('{"status":-1, "data":[]}');
    }

    /**
     * 予約管理用機器設定編集
     */
    public function edit_reserve_device($id=0, $page=1)
    {
        $post = $this->input->post();

        // 設備名取得
        $deviceSonTypeArray = $this->_getlist('device_son_type', '*', '', 'id asc');
        $deviceSonTypeList = array();
        $language = $_SESSION['language']? : 2;
        $nameKey = 'japanese_name';
        if($language == 1){ // 中国語
            $nameKey = 'chinese_name';
        }
        foreach($deviceSonTypeArray as $k=>$v){
            $deviceSonTypeList[$v['id']] = $v[$nameKey];
        }

        // 確定時の処理
        if(!empty($post)){
            foreach($deviceSonTypeList as $deviceId=>$deviceName){
                $data = array();
                $data['device_count'] = 0;
                if(!empty($post['device_'.$deviceId])){
                    $data['device_count'] = $post['device_'.$deviceId];
                }
                if(!empty($id)){
                    $this->log_mdl->update('shop_device_admin', $data, 'admin_id='.$id.' and device_son_type_id='.$deviceId);
                }else{
                    $data['device_son_type_id'] = $deviceId;
                    $data['admin_id'] = $post['adminid'];
                    $this->log_mdl->insert('shop_device_admin', $data);
                }
            }
			$this->admin_return(1);
        }

        // 編集時のデータ参照
        if($id){
            // 店舗機器管理情報取得
            $shopDeviceArray = $this->_getlist('shop_device_admin', '*', 'admin_id='.$id, 'admin_id asc, device_son_type_id asc');

            // 一覧表示用配列作成
            $shopDeviceInfo = array();
            $adminId = null;
            foreach($shopDeviceArray as $k=>$v){
                $adminId = $v['admin_id'];
                $shopDeviceInfo['admin_id'] = $adminId;
                $shopDeviceInfo['shop_name'] = $this->_getfield('admin', 'nickname', 'id=' . $v['admin_id']);
                $shopDeviceInfo[$v['device_son_type_id']] = $v['device_count'];
            }
            $this->assign('row', $shopDeviceInfo);
		}

        $session_admin_id = $_SESSION['aid'];
        $shop_where = "";
        if($_SESSION['gid'] == 4){
            $shop_where = " a.id = ".$session_admin_id;
        }
		$shop = $this->_getlist('admin as a', 'a.id, concat(a.id, ", ", a.nickname) as nickname', $shop_where, 'a.id desc');

        $this->assign('deviceSonTypeList', $deviceSonTypeList);
		$this->assign('shop',$shop);

        $this->display('device/edit_reserve_device.html');
    }

}