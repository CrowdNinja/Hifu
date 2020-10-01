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
class Admin_backup extends Admin_Controller
{
    /**
     * 构造函数
     *
     * @access  public
     * @return  void
     */

    public function __construct()
    {
        parent:: __construct();
    }


    public function index()
    {
		$files = scandir(APPPATH.'../backup/');
		$temp = array();
		foreach($files as $v){
			if($v == '.' || $v == '..')continue;
			$temp[] = $v;
		}
		$this->assign('path', '/backup/');
        $this->assign('files', $temp);
        $this->display('bguser/list_backup.html');
    }
	
	public function backup(){
		set_time_limit(0);
		$file_name = APPPATH.'../backup/'.date('YmdHis').'.zip'; 
		
		$this->load->dbutil();
		$this->load->helper('file');
		$prefs = array(
                'tables'      => array(),  // 包含了需备份的表名的数组.
                'ignore'      => array(),           // 备份时需要被忽略的表
                'format'      => 'zip',             // gzip, zip, txt
                'filename'    => '',    // 文件名 - 如果选择了ZIP压缩,此项就是必需的
                'add_drop'    => true,              // 是否要在备份文件中添加 DROP TABLE 语句
                'add_insert'  => true,              // 是否要在备份文件中添加 INSERT 语句
                'newline'     => "\n"               // 备份文件中的换行符
              ); 
		$backup = $this->dbutil->backup($prefs);
		
		$fp = @fopen($file_name, "w+");
		@fwrite($fp, $backup);
		@fclose($fp);
		echo '{"status":1}';
	}

    public function delete()
    {
        $ids = $this->input->post('ids');
        if (!empty($ids)) {
			$ids = explode(',', $ids);
            foreach($ids as $v)@unlink(APPPATH.'../backup/'.$v);
        }
        die('{"status":1}');
    }
}