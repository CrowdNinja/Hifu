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
class Admin_setting extends Admin_Controller {
	/**
	 * 构造函数
	 *
	 * @access  public
	 * @return  void
	 */
	private $prefix = 'setting_';
	public function __construct() 
	{
		parent :: __construct();
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file', 'key_prefix' => ''));
	}

	public function index() 
	{
		$list = $this->_getlist('setting', '*', 'status=1', 'orderby asc');
		$this->assign('list', $list);
		$this->display('bguser/list_setting.html');
	}
	
	public function edit($id=0){
		$row = $this->_getrow('setting', '*', "id=$id", "orderby asc, id asc");
		if(empty($row)){
			$this->_message('系统设置数据不存在', '/admin_setting/', true);
			exit;
		}
		$val = $this->input->post('val');
		if(!empty($val)){
			$data = array('val' => json_encode($val));
			$this->db->update('setting', $data, "id=$id");
			//更新缓存
			$row['val'] = $data['val'];
			$this->cache->save($this->prefix.$row['key'], $row, 0);
			
			die('{"status":1}');				
		}
		$row['val'] = json_decode($row['val'], true);
		$this->assign('row', $row);
		$this->display('bguser/edit_setting.html');
	}	
	
	/*
	public function upload($objname = 'avatar', $upfile = '_avatar'){
        $config['upload_path']      = './upload/';
        $config['allowed_types']    = '*';
        $config['max_size']     = 0;
        $config['max_width']        = 0;
        $config['max_height']       = 0;

		$filename = explode(" ", microtime());
		$filename[0] = $filename[0] * 10000000;
		$config['file_name'] = $filename[0] + $filename[1];

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload($upfile))
        {
            echo '<script>(window.opener || window.parent).callback_file_upload("", "", "'.$this->upload->display_errors().'");</script>';
        }
        else
        {
			$data = array('upload_data' => $this->upload->data());
			echo '<script>(window.opener || window.parent).callback_file_upload("'.$objname.'", "/upload/'.$data['upload_data']['file_name'].'");</script>';
        }
	}
	*/
}