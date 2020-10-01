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
class Admin_pack extends Admin_Controller {
	/**
	 * 构造函数
	 *
	 * @access  public
	 * @return  void
	 */

	private $item_type=[1=>"美容",2=>'脱毛'];
	private $mr_type=[1=>"全身",2=>'脸部'];
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
        $adminid = $this->input->get('adminid');
        $type_id = $this->input->get('type_id');
        $title = $this->input->get('title');
		$createtime1 = $this->input->get('ctime1');
		$createtime2 = $this->input->get('ctime2');
		$this->assign('get', $this->input->get());
		
		// 一覧情報取得SQL
        $where = ' 1=1 '.$this->_rolesql('',"adminid");
        // サブスクのメニューは対象外とする
        $where .= " and subscription_flg IS NULL ";

        if($title){
            $where.= " and title like '%".$title."%' ";
        }

        if(is_numeric($type_id)){
            $where.=" and type_id=$type_id";
        }
        if(is_numeric($adminid)){
            $where .= ' and adminid='.$adminid;
            $this->assign('get_adminid_account', $this->_getfield('admin', 'concat(id, ", ", nickname)', 'id='.$adminid));
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
		$pack = $this->_getpage('pack', $where, 'id desc', $page,  $pagesize);
        foreach($pack['list'] as $k=>$v){
            $pack['list'][$k]['agent_name']=$this->_getfield('admin','nickname','id='.$v['adminid']);
            $pack['list'][$k]['c_name']=$this->_getfield('admin','nickname','id='.$v['aid']);
        }
        $this->assign('pack', $pack);

        // アカウント種別が加盟店の時
        if($_SESSION['gid'] == 4){
            $this->assign('member_store_id', $_SESSION['aid']);
            $this->assign('get_adminid_account', $this->_getfield('admin', 'concat(id, ", ", nickname)', 'id=' . $_SESSION['aid']));
        }
        $this->assign('gid',$_SESSION['gid']);
		$this->display('pack/list_pack.html');
	}


// ajax排序
    public function sort(){

        $str = $this->input->post('str');
        if(!empty($str)){
            $arrList = explode(',', $str);
            $arrList = array_filter($arrList);
            foreach($arrList as $v){
                $arr = array();
                $getArr = explode(':', $v);
                $arr['sort'] = $getArr[1];
                $this->log_mdl->update('pack',array('sort'=>$getArr[1]),array('id'=>$getArr[0]));
            }
            die('1');
        }
        echo 0;
    }

    //套餐项目编辑/添加
    public function item_edit($pack_id=0,$id=0){
        $post = $this->input->post();
        if ( !empty($post) ){
            if($id){
                $is_title=$this->_getfield('pack_item','title',"title='".$post['title']."'"." and pack_id=".$pack_id.' and id<>'.$id);
                if($is_title) $this->admin_return(0,'套餐项目已添加');
                $this->log_mdl->update('pack_item', $post, 'id='.$id);
            }else{
                $is_title=$this->_getfield('pack_item','title',['title'=>$post['title'],'pack_id'=>$pack_id]);
                if($is_title) $this->admin_return(0,'套餐项目已添加');
                $post['ctime']=date('Y-m-d H:i:s');
                $this->log_mdl->insert('pack_item', $post);
            }
            die('{"status":1}');
        }
        if($id){
            $row = $this->_getrow('pack_item', '*', 'id='.$id);
            $this->assign('row', $row);
        }
        $pack=$this->_getrow('pack','*',['id'=>$pack_id]);
        $shop=$this->_getrow('admin','id,keywords',['id'=>$pack['adminid']]);
        $item_type=$this->item_type;
        if($shop['keywords']){
            $keywords=explode(',',$shop['keywords']);
            if(!in_array('美容刀',$keywords) && !in_array('わたしのハイフ',$keywords)) unset($item_type[1]);
            if(!in_array('脱毛机',$keywords) && !in_array('わたしの脱毛器',$keywords)) unset($item_type[2]);
        }else{
            $item_type=[];
        }
        $this->assign('keywords',$keywords);
        $this->assign('pack_id',$pack_id);
        $this->assign('item_type',$item_type);
        $this->assign('mr_type',$this->mr_type);
        $this->display('pack/item_edit.html');
    }
    //套餐项目
    public function pack_item($pack_id=0){
        $item=$this->_getlist('pack_item','*',['pack_id'=>$pack_id]);
        $this->assign('item', $item);
        $this->assign('item_type',$this->item_type);
        $this->assign('mr_type',$this->mr_type);
        $this->assign('pack_id',$pack_id);
        $this->display('pack/pack_item.html');
    }

	public function edit($id=0){
        $post = $this->input->post();
        if($id){
            $row = $this->_getrow('pack', '*', 'id='.$id);
            $item=$this->_getlist('pack_item','*',['pack_id'=>$row['id']]);
            $row=$this->replace_null_time($row);
            $this->assign('row', $row);
            $this->assign('item', $item);
        }
        if ( !empty($post) ){
            if($id){
                $this->log_mdl->update('pack', $post, 'id='.$id);
                //获取当前商家最低套餐的金额
                $min_price=$this->_getfield('pack','price',"adminid=".$row['adminid'],"price asc");
                $this->db->update('admin',['min_price'=>$min_price],"id=".$row['adminid']);
            }else{
                $post['ctime']=date('Y-m-d H:i:s');
                $post['aid']=$_SESSION['aid'];
                $this->log_mdl->insert('pack', $post);
                //获取当前商家最低套餐的金额
                $min_price=$this->_getfield('pack','price',"adminid=".$post['adminid'],"price asc");
                $this->db->update('admin',['min_price'=>$min_price],"id=".$post['adminid']);
                //$id = $this->db->insert_id();
            }
            die('{"status":1}');
        }

        $this->assign('item_type',$this->item_type);
        $this->assign('gid',$_SESSION['gid']);
        $this->display('pack/edit_pack.html');
	}
	
	public function delete(){
		$ids = $this->input->post('ids');
		if(!empty($ids)){
			//$this->db->where_in('id', explode(',', $ids));
			$this->log_mdl->delete('pack',"id in($ids)");
			$this->log_mdl->delete("pack_item","pack_id in($ids)");
		}
		die('{"status":1}');	
	}
	//删除套餐项目
    public function item_delete(){
	    $id=$this->input->post('id');
	    if($id){
	        $this->log_mdl->delete('pack_item',"id=$id");
        }
        $this->admin_return(1);
    }
	
	public function clear(){
		$this->log_mdl->delete('pack', ' 1=1 ');
		$this->log_mdl->delete('pack_item', ' 1=1 ');
		die('{"status":1}');
	}

	public function checkrecharge(){
		$id = $this->input->post('id');
		$rechargeno = $this->input->post('rechargeno');
		if(!empty($rechargeno)){
			$where = "rechargeno='".$rechargeno."'";
			if(!empty($id))$where .= " and id<>".$id;
			$count = $this->_getcount('recharge', $where);
			die('{"status":"'.$count.'"}');
		}
		die('{"status":"-1"}');
	}
	
	public function searchaccount(){
		$keywords = $this->input->post('keywords');
		if(!empty($keywords)){
			$where = "(account like '%".$keywords."%' or name like '%".$keywords."%' or card like '%".$keywords."%')";
			$result = $this->_getlist('user', 'id, account as `text`', $where);
			die('{"status":-1, "data":'.json_encode($result).'}');
		}
		die('{"status":-1, "data":[]}');
	}

	//批量添加套餐
    public function batch_pack(){
	    $ids=$this->input->post('ids');
	    if($ids){
            $adminid=$this->input->post('adminid');
	        $pack_list=$this->_getlist('pack','*',"id in($ids)");
	        $status=false;
	        foreach($pack_list as $k=>$v){
	            $pack_id=0;
	            $pack_item=$this->_getlist('pack_item','*',['pack_id'=>$v['id']]);
	            unset($v['id'],$v['ctime']);
	            //判断重复
	            $v['adminid']=$adminid;
                $check_pack=$this->_getfield('pack','id',$v);
                if($check_pack){
                    $status=true;
                    continue;
                }
	            $v['ctime']=date('Y-m-d H:i:s');
	            $pack_id=$this->log_mdl->insert('pack',$v);
	            if($pack_item){
	                foreach($pack_item as $key=>$value){
	                    unset($value['id']);
	                    $value['ctime']=date('Y-m-d H:i:s');
	                    $value['pack_id']=$pack_id;
	                    $this->log_mdl->insert('pack_item',$value);
                    }
                }
            }
            if($status) $this->admin_return(0,translate('操作成功！已过滤重复数据'));
            $this->admin_return(1);
        }
        $adminid=$this->input->get('adminid');
        $shop_id=$this->input->get('shop_id');
        $type_id = $this->input->get('type_id');
        $title = $this->input->get('title');
        $createtime1 = $this->input->get('ctime1');
        $createtime2 = $this->input->get('ctime2');
        $this->assign('get', $this->input->get());

        //处理搜索SQL
        $where = ' adminid!='.$adminid;

        if($title){
            $where.= " and a.title like '%".$title."%' ";
        }

        if(is_numeric($type_id)){
            $where.=" and a.type_id=$type_id";
        }
        if(is_numeric($shop_id)){
            $where .= ' and a.adminid='.$shop_id;
            $this->assign('get_adminid_account', $this->_getfield('admin', 'concat(id, ", ", nickname)', 'id='.$shop_id));
        }
        if(!empty($createtime1)){
            $createtime1 = $createtime1." 00:00:00";
            $where .= " and a.ctime>='".$createtime1."'";
        }

        if(!empty($createtime2)){
            $createtime2 = $createtime2." 23:59:59";
            $where .= " and a.ctime<='".$createtime2."'";
        }
        $shop=$this->_getrow('admin','id,keywords',['id'=>$adminid]);
        $shop_type='0';
        if($shop['keywords']){
            $keywords=explode(',',$shop['keywords']);
            if(in_array('美容刀',$keywords) || in_array('わたしのハイフ',$keywords)) $shop_type='1,';
            if(in_array('脱毛机',$keywords) || in_array('わたしの脱毛器',$keywords)) $shop_type.='2';
        }
        $shop_type=trim($shop_type,',');
        $where.=" and b.type in($shop_type)";
	    $list=$this->_getlist(['pack as a',['pack_item as b',"b.pack_id=a.id"]],['a.*','a.id'],$where);
        foreach($list as $k=>$v){
            $list[$k]['agent_name']=$this->_getfield('admin','nickname','id='.$v['adminid']);
            $list[$k]['c_name']=$this->_getfield('admin','nickname','id='.$v['aid']);
        }
	    $this->assign('list',$list);
	    $this->assign('adminid',$adminid);
	    $this->display('pack/batch_pack.html');
    }


}