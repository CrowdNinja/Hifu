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
class Admin_agreement extends Admin_Controller
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
    }

    public function index()
    {
        $page = $this->input->get('page');
        //$this->assign('page',$page?:1);
        $pagesize = $this->input->get('pagesize');
		if(empty($pagesize))$pagesize = 20;
        $menu_name = $this->input->get('menu_name');
		$this->assign('get', $this->input->get());

        $agreements = $this->_getpage('subscription_privacy_contents', '', 'id desc', $page,  $pagesize);
        $this->assign('agreements', $agreements);
        $this->display('agreements/index.html');
    }

    public function edit($agreement_id=0){
        $post = $this->input->post('agreement');
        // echo json_encode($post);
        if ($post) {
            if ($agreement_id == 0) {
                $this->db->insert('subscription_privacy_contents', ['title' => $post['title'], 'content' => $post['content']]);
                $agreement_id = $this->db->insert_id();
            } else {
                $this->db->update('subscription_privacy_contents', ['title'=>$post['title'], 'content'=>$post['content']], 'id='.$agreement_id);
            }
            // echo json_encode($post);

            die('{"status":1}');
        }
        if ($agreement_id)
        $agreement = $this->_getrow('subscription_privacy_contents', '*', 'id='.$agreement_id);
        $this->assign('agreement_id', $agreement_id);
        $this->assign('agreement', $agreement);
        $this->display('agreements/edit.html');
    }

    //获取角色账号
    public function get_parent(){
        $type=$this->input->post('type');
        if($type){
            $list=$this->_getlist('admin','id,nickname',"gid in(".implode(',',$this->_role[$type]).")".$this->_rolesql('','id'));
            $this->admin_return(1,'获取成功',['list'=>$list,'role_name'=>$this->role_type[$type]]);
        }
        $this->admin_return(0);
    }

    //获取总平台创建的角色
    public function get_admin_role(){
        $list=$this->_getlist('sys_role','id,title','aid=1');
        die(json_encode(['data'=>$list]));
    }
    //删除
    public function delete()
    {
        $ids = $this->input->post('ids');
        $aids = $this->_getfield('staff', 'group_concat(aid) as aids', "id in($ids)");
        //删除
        $res = $this->log_mdl->delete('staff', "id in($ids)");
        if ($res) {
            //删除管理员账号
            $this->log_mdl->delete('admin', "id in($aids)");
        }
        die('{"status":1}');
    }


}