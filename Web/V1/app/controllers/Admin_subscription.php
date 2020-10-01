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
class Admin_subscription extends Admin_Controller
{
    /**
     * 构造函数
     *
     * @access  public
     * @return  void
     */

    private $role_type = array(0 => '系统', 1 => '代理商', 2 => '商家');
    public function __construct()
    {
        parent:: __construct();
        // $this->load->model('subscription_mdl');
        // echo "echo";
        // $this->load->model('');
    }

    public function index()
    {
        $page = $this->input->get('page');
        //$this->assign('page',$page?:1);
        $pagesize = $this->input->get('pagesize');
		if(empty($pagesize))$pagesize = 20;
        $menu_name = $this->input->get('menu_name');
		$this->assign('get', $this->input->get());
		
		//处理搜索SQL
        $where = ' 1=1 '.$this->_rolesql('',"adminid");
        if($menu_name){
            $where.= " and title like '%".$menu_name."%' ";
        }
        $subscription_ids = $this->_getcol('subscription_pack_types', 'id', $where);
        // echo json_encode($subscription_ids);
        $where .= " and subscription_flg = 1";
        if (sizeof($subscription_ids) != 0) {
            $where .= " and subscription_type in (".implode(",", $subscription_ids).")";
        } else {
            $where .= " and subscription_type = -1";
        }
        //注意php代码不需要处理搜索URL参数，分页URL的处理注意本页模板页尾的JS代码
        // echo $where;
		$pack = $this->_getpage('pack', $where, 'id desc', $page,  $pagesize);
        foreach($pack['list'] as $k=>$v){
            $subscription=$this->_getrow('subscription_pack_types','discount, count, title','id='.$v['subscription_type']);
            $shop_name = $this->_getfield('admin', 'nickname', 'id='.$v['adminid']);
            $pack['list'][$k]['discount'] = $subscription['discount'];
            $pack['list'][$k]['count'] = $subscription['count'];
            $pack['list'][$k]['title'] = $subscription['title'];
            $pack['list'][$k]['shop_name']=$shop_name;
        }
		$this->assign('pack', $pack);
        
        $this->display('subsc/index.html');
    }


    public function edit($pack_id=0,$id=0){
        $post = $this->input->post();
        if ( !empty($post) ){
            if($pack_id){
                $subsc_pack = $this->_getfield('pack', 'subscription_type', 'id='.$pack_id);
                // $is_title=$this->_getfield('pack_item','title',"title='".$post['title']."'"." and pack_id=".$pack_id.' and id<>'.$id);
                // if($is_title) $this->admin_return(0,'套餐项目已添加');
                $this->db->update('pack', ['price'=>$post['price'], 'validity_time'=> (($post['validity_time'] && $post['validity_time'] !='')?$post['validity_time']:'9999-12-31'), 'img'=>$post['image_url']], 'id='.$pack_id);
                $this->db->update('subscription_pack_types', ['title'=>$post['title'], 'count' => $post['count'], 'discount'=>$post['discount']], 'id='.$subsc_pack);
            }else{
                $post['ctime']=date('Y-m-d H:i:s');
                $this->db->insert('subscription_pack_types', ['title'=>$post['title'], 'count' => $post['count'], 'discount'=>$post['discount']]);
                $subsc_id = $this->db->insert_id();
                $this->db->insert('pack', ['price'=>$post['price'],'title'=>$post['title'], 'adminid'=>$post['adminid'], 'aid'=>$this->_admin->id, 'validity_time'=> (($post['validity_time'] && $post['validity_time'] !='')?$post['validity_time']:'9999-12-31'), 'subscription_flg'=>1, 'subscription_type'=>$subsc_id, 'img'=>$post['image_url']]);                
                $pack_id = $this->db->insert_id();
            }
            if ($post['pack_item']) {
                $pack_items = $post['pack_item'];
                // echo(json_encode($pack_items));
                foreach($pack_items as $pack_item) {
                  if ($pack_item['id']) {
                      $this->db->update('pack_item', ['title'=> $pack_item['title'], 'text'=>$pack_item['text'], 'pack_id'=>$pack_id, 'num'=>$pack_item['num'], 'knife'=>$pack_item['knife']], 'id='.$pack_item['id']);
                  } else {
                      $this->db->insert('pack_item', ['title'=> $pack_item['title'], 'text'=>$pack_item['text'], 'pack_id'=>$pack_id, 'num'=>$pack_item['num'], 'knife'=>$pack_item['knife']]);
                  }
                }
            }
            
            die('{"status":1}');
        }
        if($id){
            $row = $this->_getrow('pack_item', '*', 'id='.$id);
            $this->assign('row', $row);
        }
        $pack=$this->_getrow('pack','*',['id'=>$pack_id]);
        $subsc_pack = $this->_getrow('subscription_pack_types', '*', 'id = '.$pack['subscription_type']);
        $pack['title'] = $subsc_pack['title'];
        $pack['count'] = $subsc_pack['count'];
        $pack['discount'] = $subsc_pack['discount'];
        $pack['editor_name'] = $this->_getfield('admin', 'nickname', 'id = '.$pack['aid']);
        $pack['img'] = $pack['img']?base_url($pack['img']):'/images/empty.jpg';
        $shop=$this->_getrow('admin','id,keywords',['id'=>$pack['adminid']]);
        $pack_items = $this->_getlist('pack_item', '*', 'pack_id = '.$pack['id']);
        $item_type=$this->item_type;
        if($shop['keywords']){
            $keywords=explode(',',$shop['keywords']);
            if(!in_array('美容刀',$keywords) && !in_array('わたしのハイフ',$keywords)) unset($item_type[1]);
            if(!in_array('脱毛机',$keywords) && !in_array('わたしの脱毛器',$keywords)) unset($item_type[2]);
        }else{
            $item_type=[];
        }
        // $this->assign('keywords',$keywords);
        $this->assign('pack_id',$pack_id);
        $this->assign('pack',$pack);
        $this->assign('item_type',$item_type);
        // $this->assign('mr_type',$this->mr_type);
        $this->assign('pack_items', $pack_items);
        $this->display('subsc/edit.html');
    }

    public function upload_image()
    {
        $config = array(
            'upload_path' => "upload/subsc_images/",
            'allowed_types' => "gif|jpg|png|jpeg|pdf",
            'overwrite' => TRUE,
            'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
            'max_height' => "768",
            'max_width' => "1024"
            );
        $this->load->library('upload', $config);
        if($this->upload->do_upload())
        {
            $data = array('upload_data' => $this->upload->data('base64'));
            die(json_encode($data));
        }
        else {
            $error = array('error' => $this->upload->display_errors());
            // $this->load->view('custom_view', $error);
            die(json_encode($error));
        }
    }

    
    //删除
    public function delete()
    {
        $ids = $this->input->post('ids');
        $subscription_types = $this->_getfield('pack', 'group_concat(subscription_type)', "id in($ids)");
        //删除
        $res = $this->log_mdl->delete('pack', "id in($ids)");
        if ($res) {
            //删除管理员账号
            $this->log_mdl->delete('subscription_pack_types', "id in($subscription_types)");
        }
        die('{"status":1}');
    }
            
        // $post = $this->input->post();
        // $image = explode(',', $post['base64']);
        // $img = base64_decode($image[1]);
        // $time = date('YmdHis').mt_rand(10000,99999);
        // $filepath = '/upload/subsc_images/'.$time.'.jpg';
        // file_put_contents($filepath, $img);
        // die( $time);
        // die('{"status":1}');
    // }

    //获取角色账号
    public function get_parent(){
        $type=$this->input->post('type');
        if($type){
            $list=$this->_getlist('admin','id,nickname',"gid in(".implode(',',$this->_role[$type]).")".$this->_rolesql('','id'));
            $this->admin_return(1,'获取成功',['list'=>$list,'role_name'=>$this->role_type[$type]]);
        }
        $this->admin_return(0);
    }

    public function uploadMedia()
    {
      $filename = $_FILES['media']['name'];     
      
      $uploadOk = 1;
      $mediaFileType = pathinfo($filename,PATHINFO_EXTENSION);
      $time = date('YmdHis');
      $location = "upload/subsc_images/".$time.".".$mediaFileType;
      $path = "upload/subsc_images/";
      /* Valid Extensions */
      $valid_extensions = array("jpg","jpeg","png");
      /* Check file extension */
      if( !in_array(strtolower($mediaFileType),$valid_extensions) ) {
        $uploadOk = 0;
      }
      if($uploadOk == 0){
          die('{"status":-1}');
      }else{
      /* Upload file */
      // echo $_FILES['image']['tmp_name'];
        if(move_uploaded_file($_FILES['media']['tmp_name'],$location)){
            // $this->db->insert('media', ['url'=>$location]);
            // $media_id = $this->db->insert_id();
            $result = ['status' => 1, 'url' => base_url($location), 'location'=>$location];
            die(json_encode($result));
        }else{
            die('{"status":0}');
        }
      }
    }

    //获取总平台创建的角色
    public function get_admin_role(){
        $list=$this->_getlist('sys_role','id,title','aid=1');
        die(json_encode(['data'=>$list]));
    }
}