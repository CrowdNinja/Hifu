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
class Admin_staff extends Admin_Controller
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
        if (empty($pagesize)) $pagesize = 10;
        $corpid = $this->input->get('corpid');
        $adminid = $this->input->get('adminid');
        $name = trim($this->input->get('name'));
        $status = $this->input->get('status');
        $gid = $this->input->get('gid');
        $createtime1 = $this->input->get('createtime1');
        $createtime2 = $this->input->get('createtime2');
        $day = $this->input->get('day');
        $this->assign('get', $this->input->get());

        //处理搜索SQL

        $where = ' 1=1 '.$this->_rolesql('','parent_id');

//        if(is_numeric($day)){
//            $where.= ' and a.off_line_time<unix_timestamp()-'."86400*".$day;
//        }
        //$where.= ' and ctime<unix_timestamp()-'."86400*2";
        if (is_numeric($status)) $where .= " and a.status=$status";

        if($name){
            $where.=" and a.name like '%".$name."%'";
        }
        if($gid){
            $where.=" and b.gid=$gid";
        }
        if (!empty($createtime1)) {
            $createtime1 = formattime($createtime1 . ' 00:00:00');
            $where .= " and a.ctime>=" . $createtime1;
        }
        if (!empty($createtime2)) {
            $createtime2 = formattime($createtime2 . ' 23:59:59');
            $where .= " and a.ctime<=" . $createtime2;
        }
        if (!empty($corpid)) {
            $where .= " and a.parent_id=" . $corpid;
            $this->assign('get_corpid_account', $this->_getfield('admin', 'concat(id, ", ", nickname)', 'id='.$corpid));
        }
        if (!empty($adminid)) {
            $where .= " and a.parent_id=" . $adminid;
            $this->assign('get_adminid_account', $this->_getfield('admin', 'concat(id, ", ", nickname)', 'id='.$adminid));
        }

        $list = $this->_getpage(array('staff as a', array('admin as b', 'a.aid=b.id')), $where, 'id desc', $page,  $pagesize, 'a.*,b.adminname,b.gid');
        foreach ($list['list'] as $k => $v) {
            $agent_name = $this->_getfield('admin', 'nickname', 'id=' . $v['parent_id']);
            $list['list'][$k]['_parent_name']=translate("总平台");
            if ($v['type'] == 1) {//代理商
                $list['list'][$k]['_parent_name'] = translate('代理商').'：' . $agent_name;
            } elseif($v['type']==2) {//商家
                $list['list'][$k]['_parent_name'] =translate('商家').'：' . $agent_name;
            }
            $list['list'][$k]['role_title'] = $this->_getfield('sys_role', 'title', 'id=' . $v['gid']);
        }

        $role_where="type=3".$this->_rolesql('','aid');

        //获取角色
        $g_list = $this->_getlist('sys_role', 'id,title', $role_where);//获取子账号角色，运维或者财务
        $this->assign('g_list', $g_list);
        $this->assign('list', $list);
        $this->assign('aid', $_SESSION['aid']);
        $this->display('staff/list_staff.html');
    }


    public function edit($id = 0)
    {

        $post = $this->input->post();
        if (!empty($post)) {
            if ($id) {
                $staff = $this->_getrow('staff', '*', 'id=' . $id);
                $admin = $this->_getrow('admin', '*', 'id=' . $staff['aid']);
                $is_adminname = $this->_getfield('admin', 'adminname', 'adminname="' . $post['adminname'] . '"' . ' and id<>' . $staff['aid']);
                if ($is_adminname) $this->admin_return(0,'登入账号不能重复');
                if ($admin['password'] != $post['password']) {
                    $admin_data['password'] = md5($post['password']);
                }
                $admin_data['adminname'] = $post['adminname'];
                $admin_data['nickname'] = $post['name'];
                $admin_data['gid'] = $post['gid'];
                $this->log_mdl->update('admin', $admin_data, 'id=' . $staff['aid']);

                $staff_data['name'] = $post['name'];
                $staff_data['remark'] = $post['remark'];
                $this->log_mdl->update('staff', $staff_data, 'id=' . $id);
            } else {
                $is_adminname = $this->_getfield('admin', 'adminname', ['adminname' => $post['adminname']]);
                if ($is_adminname) $this->admin_return(0,'登入账号不能重复');
                $admin_data = [
                    'adminname' => $post['adminname'],
                    'password' => md5($post['password']),
                    'nickname' => $post['name'],
                    'gid' => $post['gid'],
                    'pid' => $post['parent_id']?:1,
                    'status' => 1,
                    'createtime' => time()
                ];
                $aid = $this->log_mdl->insert('admin', $admin_data);
                if ($aid) {
                    $staff_data = [
                        'name' => $post['name'],
                        'aid' => $aid,
                        'type' => $post['type'],
                        'parent_id' =>$post['parent_id']?:1,
                        'remark' => $post['remark'],
                        'ctime' => time()
                    ];
                    $this->log_mdl->insert('staff', $staff_data);
                } else {
                    $this->admin_return(0,'添加失败');
                }
            }
            die('{"status":1}');
        }
        if ($id) {
            $row = $this->_getrow('staff', '*', 'id=' . $id);
            $admin = $this->_getrow('admin', '*', 'id=' . $row['aid']);
            $this->assign('admin', $admin);
            $this->assign('row', $row);
        }
        $role_where="type=3".$this->_rolesql('','aid');

        //获取角色
        $g_list = $this->_getlist('sys_role', 'id,title', $role_where);//获取子账号角色，运维或者财务
        $role_type=$this->role_type;
        foreach($role_type as $k=>$v){
            if($k<$this->_admin->_role_type) unset($role_type[$k]);
        }
        $this->assign('g_list', $g_list);
        $this->assign('role_type',$role_type);
        $this->display('staff/edit_staff.html');
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