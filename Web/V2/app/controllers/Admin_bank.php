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
class Admin_bank extends Admin_Controller {
	/**
	 * 构造函数
	 *
	 * @access  public
	 * @return  void
	 */
	 

	public function __construct() 
	{
		parent :: __construct();
	}

	public function index() 
	{
		$page = $this->input->get('page');
		$pagesize = $this->input->get('pagesize');
		if(empty($pagesize))$pagesize = 20;
		$bank_name=trim($this->input->get('bank_name'));
		$this->assign('get', $this->input->get());
		
		//处理搜索SQL
		$where = '1=1';
		if($bank_name){
		    $where.= " and bank_name like '%".$bank_name."%'";
        }
		//注意php代码不需要处理搜索URL参数，分页URL的处理注意本页模板页尾的JS代码
		$list = $this->_getpage('bank', $where, 'id asc', $page, $pagesize);

		$this->assign('list', $list);
		$this->display('bank/list_bank.html');
	}

	public function edit($id=0){
		$post = $this->input->post();
        if ( $post){
            $data=$post;
            $is_bank=$this->_getrow('bank','id,bank_name',($id ? "id<>$id and " : "") . "bank_name='".$post['bank_name']."'");
            if($is_bank) die('{"status":0,"msg":"该银行已添加"}');
			if($id){
				$this->db->update('bank', $data, 'id='.$id);
			}else{
				$this->db->insert('bank', $data);
			}
			die('{"status":1}');
		}		
		if($id){
			$row = $this->_getrow('bank', '*', 'id='.$id);
			$this->assign('row', $row);
		}
		$this->display('bank/edit_bank.html');
	}

	//商家银行卡列表
    public function shop_bank(){
        $page = $this->input->get('page');
        $pagesize = $this->input->get('pagesize');
        if(empty($pagesize))$pagesize = 20;
        $adminid=trim($this->input->get('adminid'));
        $corp_id=trim($this->input->get('corp_id'));
        $bank_card=trim($this->input->get('bank_card'));
        $name=trim($this->input->get('name'));
        $this->assign('get', $this->input->get());

        //处理搜索SQL
        $where = '1=1';
        if($_SESSION['gid']!=1){
            $where.=" and adminid=".$_SESSION['aid'];
        }
        if($adminid){
            $where.=" and adminid=".$adminid;
            $this->assign('get_adminid_account', $this->_getfield('admin', 'concat(id, ", ", nickname)', 'id='.$adminid));
        }
        if($corp_id){
            $where.=" and adminid=".$corp_id;
            $this->assign('get_corp_account', $this->_getfield('admin', 'concat(id, ", ", nickname)', 'id='.$corp_id));
        }
        if($bank_card){
            $where.=" and bank_card like '%".$bank_card."%'";
        }
        if($name){
            $where.=" and name like '%".$name."%'";
        }
        //注意php代码不需要处理搜索URL参数，分页URL的处理注意本页模板页尾的JS代码
        $list = $this->_getpage('admin_bank', $where, 'id asc', $page, $pagesize);
        foreach($list['list'] as $k=>&$v){
            $v['_nickname']=$this->_getfield('admin', 'concat(id, " ,", nickname)', 'id='.$v['adminid']);
            $v['bank']=$this->_getfield('bank','bank_name',['id'=>$v['bank_id']]);
        }
        unset($v);
        $this->assign('list', $list);
        $this->assign('gid',$_SESSION['gid']);
        $this->display('bank/list_shop_bank.html');
    }

    public function shop_bank_edit($id=0)
    {
        $post = $this->input->post();
        if ($post) {
            $data = $post;
            $is_bank = $this->_getrow('admin_bank', 'id,bank_card', ($id ? "id<>$id and " : "") . "bank_card='" . $post['bank_card'] . "'");
            if ($is_bank) die('{"status":0,"msg":"该银行卡已添加"}');
            if ($id) {
                $this->db->update('admin_bank', $data, 'id=' . $id);
            } else {
                $data['ctime']=time();
                if(!$data['adminid']) $data['adminid']=$_SESSION['aid'];
                $this->db->insert('admin_bank', $data);
            }
            die('{"status":1}');
        }
        if ($id) {
            $row = $this->_getrow('admin_bank', '*', 'id=' . $id);
            $row['adminid_account']=$this->_getfield('admin', 'concat(id, " ,", nickname)', 'id='.$row['adminid']);
            $row['bank_name']=$this->_getfield('bank', 'concat(id, " ,", bank_name)', 'id='.$row['bank_id']);
            $this->assign('row', $row);
        }
        $this->display('bank/shop_bank_edit.html');

    }
    public function shop_bank_delete(){
	    $ids=$this->input->post('ids');
	    if($ids){
	        $this->db->delete('admin_bank'," id in($ids)");
        }
        die('{"status":1}');
    }

    public function search(){
        $keywords = $this->input->post('keywords');
        if(!empty($keywords)){
            $where = "(id='".$keywords."' or bank_name like '%".$keywords."%' or bank_code like '%".$keywords."%') ";
            $result = $this->_getlist('bank', 'id, concat(id, ", ", bank_name) as `text`', $where, 'id asc');
            die('{"status":-1, "data":'.json_encode($result).'}');
        }
        die('{"status":-1, "data":[]}');
    }

}