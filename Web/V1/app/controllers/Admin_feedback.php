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
class Admin_feedback extends Admin_Controller {
	/**
	 * 构造函数
	 *
	 * @access  public
	 * @return  void
	 */


	private $status=[1=>'已处理',0=>"未处理"];
	public function __construct()
	{
		parent :: __construct();
	}

	public function index() 
	{
		$page = $this->input->get('page');
		$pagesize = $this->input->get('pagesize');
		if(empty($pagesize))$pagesize = 20;
		$macno=trim($this->input->get('macno'));
		$status=$this->input->get('status');
		$phone=trim($this->input->get('phone'));
        $createtime1 = $this->input->get('ctime1');
        $createtime2 = $this->input->get('ctime2');
		$this->assign('get', $this->input->get());
		
		//处理搜索SQL
		$where = '1=1'.$this->_rolesql('b',$this->_getrolefield());
		if($macno){
		    $where.= " and a.macno like '%".$macno."%'";
        }
        if($phone){
            $where.= " and a.phone like '%".$phone."%'";
        }
        if(is_numeric($status)){
            $where.=" and a.status=$status";
        }
        if(!empty($createtime1)){
            $createtime1 = $createtime1." 00:00:00";
            $where .= " and a.ctime>='".$createtime1."'";
        }

        if(!empty($createtime2)){
            $createtime2 = $createtime2." 23:59:59";
            $where .= " and a.ctime<='".$createtime2."'";
        }
		//注意php代码不需要处理搜索URL参数，分页URL的处理注意本页模板页尾的JS代码
		$list = $this->_getpage(['feedback as a',['device as b',"a.macno=b.macno"]], $where, 'a.id desc', $page, $pagesize,"a.*");
        foreach($list['list'] as $k=>&$v){
            $v['nickname']=$this->_getfield('user','nickname',['id'=>$v['user_id']]);
            $v['tradeno']=$this->_getfield('trade','tradeno',['id'=>$v['trade_id']]);
          /*  $img=[];
            if($v['img']){
                foreach (explode("\n", str_replace("\r", "", $v['img'])) as $kk => $vv) {
                    $img[] = base_url($vv);
                }
                $v['img']=$img;
            }*/
            $v=$this->replace_null_time($v);
        }
        unset($v);
		$this->assign('list', $list);
		$this->assign('status',$this->status);
		$this->display('feedback/list_feedback.html');
	}

	//修改状态
    public function set_status(){
	    $id=$this->input->post('id');
	    if($id){
	        $this->log_mdl->update('feedback',['status'=>1,'last_time'=>date('Y-m-d H:i:s')],['id'=>$id]);
            $this->admin_return(1);
        }
        $this->admin_return(0);
    }

    //删除
    public function delete(){
        $ids=$this->input->post('ids');
        if($ids){
            $this->log_mdl->delete('feedback'," id in($ids)");
        }
        die('{"status":1}');
    }
    //常见问题
    public function faq(){
        $page = $this->input->get('page');
        $pagesize = 20;
        $ctime1 = $this->input->get('ctime1');
        $ctime2 = $this->input->get('ctime2');
        $this->assign('get',$this->input->get());

        $where = '1=1 ';

        if ($ctime1){
            $ctime1 = strtotime($ctime1.'00:00:00');
            $where .= ' and ctime>='.$ctime1;
        }
        if ($ctime2){
            $ctime2 = strtotime($ctime2.'23:59:59');
            $where .= ' and ctime<='.$ctime2;
        }

        $data = $this->_getpage('faq',$where,'id desc',$page,$pagesize,'*,');
        $this->assign('data',$data);
        $this->display('feedback/list_faq.html');

    }
    public function faq_edit($id=0){
        $post = $this->input->post();
        if ( !empty($post) ){
            if($id){
                $this->log_mdl->update('faq', $post, 'id='.$id);
            }else{
                $post['ctime']=time();
                $this->log_mdl->insert('faq', $post);
            }
            die('{"status":1}');
        }
        if($id){
            $row = $this->_getrow('faq', '*', 'id='.$id);
            $this->assign('row', $row);
        }
        $this->display('feedback/edit_faq.html');
    }

    public function hot_keyword(){
	    $page=$this->input->get('page');
	    $keyword=trim($this->input->get('keyword'));
	    $this->assign('get',$this->input->get());
	    $where="1=1";
	    if($keyword) $where.=" and keyword like '%".$keyword."%'";
	    $list=$this->_getpage('hot_keyword',$where,'id desc',$page,50);
	    foreach($list['list'] as $k=>$v){
	        $list['list'][$k]['language_name']="中国";
	        if($v['language']==2)  $list['list'][$k]['language_name']="日本";
        }
	    $this->assign('list',$list);
	    $this->display('feedback/hot_keyword.html');
    }
    //编辑、添加
    public function edit_hot_keyword($id=0){
	    $post=$this->input->post();
	    if($post){
	        if($id){
	            $this->db->update('hot_keyword',$post,['id'=>$id]);
            }else{
	            $this->db->insert('hot_keyword',$post);
            }
            $this->admin_return(1);
        }
        if($id){
            $row=$this->_getrow('hot_keyword','*',['id'=>$id]);
            $this->assign('row',$row);
        }
        $this->display('feedback/edit_hot_keyword.html');
    }
    public function hot_keyword_delete(){
        $ids = $this->input->post('ids');
        if(!empty($ids)){
            $this->log_mdl->delete('hot_keyword',"id in($ids)");
        }
        die('{"status":1}');
    }

    public function faq_delete(){
        $ids = $this->input->post('ids');
        if(!empty($ids)){
            $this->log_mdl->delete('faq',"id in($ids)");
        }
        die('{"status":1}');
    }

}