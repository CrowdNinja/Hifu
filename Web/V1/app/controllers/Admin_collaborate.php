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
class Admin_collaborate extends Admin_Controller {
	/**
	 * 构造函数
	 *
	 * @access  public
	 * @return  void
	 */

	private $type=[1=>'代理商',2=>"商家"];
	private $status=[1=>'已联系',0=>"未联系"];
	public function __construct()
	{
		parent :: __construct();
	}

	public function index() 
	{
		$page = $this->input->get('page');
		$pagesize = $this->input->get('pagesize');
		if(empty($pagesize))$pagesize = 20;
		$name=trim($this->input->get('name'));
		$status=$this->input->get('status');
		$phone=trim($this->input->get('phone'));
        $createtime1 = $this->input->get('ctime1');
        $createtime2 = $this->input->get('ctime2');
		$this->assign('get', $this->input->get());
		
		//处理搜索SQL
		$where = '1=1';
		if($name){
		    $where.= " and name like '%".$name."%'";
        }
        if($phone){
            $where.= " and phone like '%".$phone."%'";
        }
        if(is_numeric($status)){
            $where.=" and status=$status";
        }
        if(!empty($createtime1)){
            $createtime1 = $createtime1." 00:00:00";
            $where .= " and ctime>='".$createtime1."'";
        }

        if(!empty($createtime2)){
            $createtime2 = $createtime2." 23:59:59";
            $where .= " and ctime<='".$createtime2."'";
        }
		//注意php代码不需要处理搜索URL参数，分页URL的处理注意本页模板页尾的JS代码
		$list = $this->_getpage('collaborate', $where, 'id desc', $page, $pagesize);

		$this->assign('list', $list);
		$this->assign('type',$this->type);
		$this->display('collaborate/list_collaborate.html');
	}

	//修改状态
    public function set_status(){
	    $id=$this->input->post('id');
	    if($id){
	        $this->log_mdl->update('collaborate',['status'=>1],['id'=>$id]);
            $this->admin_return(1);
        }
        $this->admin_return(0);
    }

    public function export()
    {
        $name=trim($this->input->get('name'));
        $status=$this->input->get('status');
        $phone=trim($this->input->get('phone'));
        $createtime1 = $this->input->get('ctime1');
        $createtime2 = $this->input->get('ctime2');
        $ids = $this->input->post('ids');

        //处理搜索SQL
        $where = '1=1';
        if($name){
            $where.= " and name like '%".$name."%'";
        }
        if($phone){
            $where.= " and phone like '%".$phone."%'";
        }
        if(is_numeric($status)){
            $where.=" and status=$status";
        }
        if(!empty($createtime1)){
            $createtime1 = $createtime1." 00:00:00";
            $where .= " and ctime>='".$createtime1."'";
        }

        if(!empty($createtime2)){
            $createtime2 = $createtime2." 23:59:59";
            $where .= " and ctime<='".$createtime2."'";
        }
        if($ids){
            $where.=" and id in($ids)";
        }

        //注意php代码不需要处理搜索URL参数，分页URL的处理注意本页模板页尾的JS代码
        $cash = $this->_getlist('collaborate', '*', $where, 'id desc');

        $fp = fopen('./temp/collaborate.csv', 'w');
        //fwrite($fp,chr(0xEF).chr(0xBB).chr(0xBF));
        fputcsv($fp, array(mb_convert_encoding('序号', 'gbk', 'utf8'),
          /*  mb_convert_encoding('类型', 'gbk', 'utf8'),*/
            mb_convert_encoding('申请人姓名', 'gbk', 'utf8'),
            mb_convert_encoding('联系电话', 'gbk', 'utf8'),
            mb_convert_encoding('公司名称', 'gbk', 'utf8'),
            mb_convert_encoding('邮箱', 'gbk', 'utf8'),
            mb_convert_encoding('城市', 'gbk', 'utf8'),
            mb_convert_encoding('申请时间', 'gbk', 'utf8'),
            mb_convert_encoding('状态', 'gbk', 'utf8'),
        ));
        foreach ($cash as $v) {
            if($v['user_id']) $v['nickname']=$this->_getfield('user','nickname',['id'=>$v['user_id']]);
            $v=$this->replace_null_time($v);
            fputcsv($fp, array(mb_convert_encoding($v['id'] . "\t", 'gbk', 'utf8'),
                   /* mb_convert_encoding($this->type[$v['type']]  ."\t", 'gbk', 'utf8'),*/
                    mb_convert_encoding(  $v['name'] . "\t", 'gbk', 'utf8'),
                    mb_convert_encoding($v['phone'], 'gbk', 'utf8'),
                    mb_convert_encoding($v['company_name'] . "\t", 'gbk', 'utf8'),
                    mb_convert_encoding($v['mail'] . "\t", 'gbk', 'utf8'),
                    mb_convert_encoding($v['city']. "\t", 'gbk', 'utf8'),
                    mb_convert_encoding($v['ctime'] . "\t", 'gbk', 'utf8'),
                    mb_convert_encoding($this->status[$v['status']] . "\t", 'gbk', 'utf8'),
                )
            );
        }
        fclose($fp);
        die('{"status":1, "url":"/temp/collaborate.csv"}');
    }
    //删除
    public function delete(){
        $ids=$this->input->post('ids');
        if($ids){
            $this->log_mdl->delete('collaborate'," id in($ids)");
        }
        die('{"status":1}');
    }


}