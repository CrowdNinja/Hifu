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
class Admin_oper_log extends Admin_Controller
{
    /**
     * 构造函数
     *
     * @access  public
     * @return  void
     */


    private $log_type=['C'=>'添加',"U"=>"修改","D"=>'删除',"login"=>"登入",'loginout'=>"退出登入"];
    public function __construct()
    {
        parent:: __construct();
    }

    public function index()
    {
        $page = $this->input->get('page');
        $pagesize = $this->input->get('pagesize');
        $adminname=trim($this->input->get('adminname'));
        $type=$this->input->get('type');
        $table=trim($this->input->get('table'));
        $createtime1 = $this->input->get('createtime1');
        $createtime2 = $this->input->get('createtime2');
        if (empty($pagesize)) $pagesize = 20;
        $this->assign('get',$this->input->get());
        $this->assign('p',$page?:1);

        $where="1=1";
        if (!empty($createtime1)) {
            $createtime1 = formattime($createtime1 . ' 00:00:00');
            $where .= " and ctime>=" . $createtime1;
        }
        if (!empty($createtime2)) {
            $createtime2 = formattime($createtime2 . ' 23:59:59');
            $where .= " and ctime<=" . $createtime2;
        }
        if($adminname){
            $where.=" and adminname like '%".$adminname."%'";
        }
        if($type){
            $where.=" and type='$type'";
        }
        if($table){
            $where.=" and table like '%".$table."%'";
        }
        $list = $this->_getpage("oper_log", $where, 'id desc', $page, $pagesize );
        foreach($list['list'] as $k=>$v){
            $list['list'][$k]['_type']=$this->log_type[$v['type']];
            if(strlen($v['memo'])>30)  $list['list'][$k]['memo']=substr($v['memo'],0,30)."...";

        }
        $this->assign('log_type',$this->log_type);
        $this->assign('list', $list);
        $this->display('oper/list_oper_log.html');
    }

    //详情
    public function details($id=0,$page=1){
        $row=$this->_getrow('oper_log','*',['id'=>$id]);
        $row['_type']=$this->log_type[$row['type']];
        if($row['memo']){
            if(in_array($row['type'],['U','C'])){
                $memo=explode(',',$row['memo']);
                $text='';
                foreach($memo as $k=>$v){
                    $arr=explode('->',$v);
                    $text.="<b>".$arr[0]." <span style='color:red;'>-></span> ".$arr[1].' </b><br>';
                }
                $row['memo']=$text;
            }
        }
        $this->assign('row', $row);
        $this->assign('p',$page);
        $this->display('oper/details.html');
    }


    //删除
    public function delete()
    {
        $ids = $this->input->post('ids');
        $this->db->delete('oper_log',"id in($ids)");
        die('{"status":1}');
    }


}