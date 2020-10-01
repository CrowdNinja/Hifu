<?php if (!defined('IN_DLC')) exit('No direct script access allowed');

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
class Admin_corp extends Admin_Controller
{
    /**
     * 构造函数
     *
     * @access  public
     * @return  void
     */
    private $qs_pid = '';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('corptree_mdl');
        $this->load->model('admin_mdl');
        $this->load->model('setting_mdl');
    }

    public function index()
    {
        $where = " gid in (".implode(",", $this->_role[1]).")".$this->_rolesql('', 'id');
        $page = $this->input->get('page');
        $pagesize = $this->input->get('pagesize');
        if (empty($pagesize)) $pagesize = 20;
        $adminid = $this->input->get('adminid');
        $recmdid = $this->input->get('recmdid');
        $userid = $this->input->get('userid');
        $status = $this->input->get('status');
        $createtime1 = $this->input->get('createtime1');
        $createtime2 = $this->input->get('createtime2');
        $area = $this->input->get('area');
        $city = $this->input->get('city');
        $this->assign('get', $this->input->get());

        //处理搜索SQL
        if (is_numeric($status)) {
            $where .= " and status=$status";
        }

        if (is_numeric($adminid)) {
            $where .= ' and id=' . $adminid;
            $this->assign('get_adminid_account', $this->_getfield('admin', 'concat(id, ", ", nickname)', 'id=' . $adminid));
        }
        if (is_numeric($recmdid)) {
            $where .= ' and recmdid=' . $recmdid;
            $this->assign('get_recmdid_account', $this->_getfield('user', 'if(account=nickname,concat(id, ", ", account),concat(id, ", ", account, ", ", nickname))', 'id=' . $recmdid));
        }
        if (is_numeric($userid)) {
            $where .= ' and userid=' . $userid;
            $this->assign('get_userid_account', $this->_getfield('user', 'if(account=nickname,concat(id, ", ", account),concat(id, ", ", account, ", ", nickname))', 'id=' . $userid));
        }
        if (!empty($createtime1)) {
            $createtime1 = formattime($createtime1 . ' 00:00:00');
            $where .= " and createtime>=" . $createtime1;
        }
        if (!empty($createtime2)) {
            $createtime2 = formattime($createtime2 . ' 23:59:59');
            $where .= " and createtime<=" . $createtime2;
        }
        if ($area) {
            $where .= " and area='$area'";
        }
        if ($city) {
            $where .= " and area='$city'";
        }

        $config_setting = $this->setting_mdl->get('config');
        //注意php代码不需要处理搜索URL参数，分页URL的处理注意本页模板页尾的JS代码
        $admins = json_decode(json_encode($this->_getpage('admin', $where, 'orderby asc,id desc', $page, $pagesize)));
        foreach ($admins->list as &$v) {
            $v->_gid = $this->_getfield('sys_role', 'title', 'id=' . $v->gid);
            $v->parent_name="/";
            $v-> flg = str_repeat('✪',$v->level);
            if($v->pid )$v->parent_name=$this->_getfield('admin','nickname','id='.$v->pid);
        }
        unset($v);
        $this->assign("data", $admins);
        $this->assign('config_setting', $config_setting);
        $this->assign('japan_city', $this->_getlist('japan_city', '*', '', 'id desc'));
        $this->assign('p',$page?:1);
        $this->display('corp/list_corp.html');
    }

    public function orderby()
    {
        $orderby = $this->input->post('orderby');
        foreach ($orderby as $k => $v) {
            $this->db->where('id=' . $k . $this->_rolesql('', 'id'))->update('admin', array('orderby' => $v));
        }
        echo json_encode(array('status' => 1));
    }


    public function edit($id=0)
    {
        //if($id==1)
        //{
        //	$this->_message('admin不可以更改', '/admin_corp/', TRUE);
        //	exit;
        //}
        if ($this->_validate_user_form() == FALSE) {
            $data = $this->admin_mdl->get_admin_by_id("id=$id" . $this->_rolesql('', 'id'));
            if ($data->recmdid) $data->recmdid_account = $this->_getfield('user', 'if(account=nickname,concat(id, ", ", account),concat(id, ", ", account, ", ", nickname))', "id=" . $data->recmdid);
            if ($data->user_id) $data->userid_account = $this->_getfield('user', 'if(account=nickname,concat(id, ", ", account),concat(id, ", ", account, ", ", nickname))', "id=" . $data->user_id);
            $data->_money = $this->admin_mdl->cash_money($data->id);
            $data->qrcode = urlencode(base_url('h5/html/pay.html?adminid=' . $data->id));
            $this->load->model('role_mdl');
            $roles = $this->role_mdl->get_all_role("id in (" . implode(",", $this->_role[1]) . ")");
            $this->assign('data', $data);
            $this->assign('roles', $roles);
            $this->assign('geocoder_key', $this->config->item('geocoder_key'));
            $this->assign('config_setting', $this->setting_mdl->get('config'));
            $this->assign('phone_area_code',$this->_getlist('phone_area_code','mobile_prefix,country','1=1'));
            $this->display('corp/edit_corp.html');
        } else {
            $data = $this->_get_form_data(TRUE);
            if (!$this->admin_mdl->chk_admin($id, $data['adminname'])) die('{"msg":"账号已存在"}');
            if ($this->_admin->_role_type == 0) {
                $data['money'] = $this->input->post('money');// $this->admin_mdl->new_money($id, floatval($this->input->post('money')));
            } else {
                unset($data['money']);
            }
            if ($data['percen'] < 0) $data['percen'] = 0;
            if ($data['percen'] > 100) $data['percen'] = 100;
            $result = $this->admin_mdl->edit_admin_by_id("id=$id" . $this->_rolesql('', 'id'), $data);
            die('{"status":1}');
        }
    }



    public function delete()
    {
        //$count = $this->_getcount('admin', "pid=$id");
        //if($count){
        //	$this->_message('请先删除下级.', '/admin_corp/'.$this->qs_pid, TRUE);
        //	exit;
        //}
        $id=$this->input->post('id');
        if ($id) {
            $result = $this->admin_mdl->del_user("id=$id" );
            if ($result) {
                $this->admin_mdl->fixpath($id);
                $this->log_mdl->delete('coupon', "adminid=$id");
                $this->log_mdl->delete('user_coupon', "adminid=$id");
                $this->admin_return(1);
            }
        }
        $this->admin_return(0,'操作员不允许删除');
    }

    public function save($id=0)
    {
        $data = $this->_get_form_data(TRUE);
        if (!$this->admin_mdl->chk_admin($id, $data['adminname'])) $this->admin_return(0,'账号已存在');
        if ($this->_admin->_role_type == 0) {
            $data['money'] = $this->input->post('money');// $this->admin_mdl->new_money($id, floatval($this->input->post('money')));
        } else {
            unset($data['money']);
        }
        $agent=$this->_getrow('admin','*',['id'=>$id]);

        if($data['percen']>$agent['percen']){//如果增加了代理商的分成比例 需要判断总分成比例有没有超过100%
            $agent_shop=$this->_getlist('admin','*'," gid in (".implode(",", $this->_role[2]).") and corpid=".$agent['id']);
            $error_shop=[];
            if($agent_shop){
                foreach($agent_shop as $k=>$v){
                    if(($data['percen']+$v['percen'])>100){
                        $error_shop=$v;
                        break;
                    }
                }
            }
            if($error_shop){
                $msg=translate("分成比例总和不能超出100%，请先修改商家：").$error_shop['nickname'].',id :'.$error_shop['id'].translate('的分成比例');
                die(json_encode(['status'=>0,'msg'=>$msg]));
            }
        }
        if ($data['percen'] < 0) $data['percen'] = 0;
        if ($data['percen'] > 100) $data['percen'] = 100;
        if(!$data['password']){
            unset($data['password']);
        }else{
            $data['pass']=$data['password'];
            $data['password']=md5($data['password']);
        }
        //$this->admin_mdl->edit_admin_by_id("id=$id".$this->_rolesql('', 'id') , $data);
        $this->log_mdl->update('admin',$data,"id=$id".$this->_rolesql('', 'id'));
        die('{"status":1}');
    }

    public function save_pwd()
    {
        $id = $this->input->post('pk');
        $name = $this->input->post('name');
        $value = $this->input->post('value');
        $this->admin_mdl->edit_admin_by_id("id=$id" . $this->_rolesql('', 'id'), array($name => $value));
        die('{"msg":"修改成功"}');
    }

    public function add()
    {
        if (!$this->_validate_user_form()) {
            $this->load->model('role_mdl');
            $roles = $this->role_mdl->get_all_role("id in (" . implode(",", $this->_role[1]) . ")");
            $this->assign('roles', $roles);
            $this->assign('geocoder_key', $this->config->item('geocoder_key'));
            $this->assign('config_setting', $this->setting_mdl->get('config'));
            $this->assign('phone_area_code',$this->_getlist('phone_area_code','mobile_prefix,country','1=1'));
            $this->display('corp/add_corp.html');
        } else {
            $data = $this->_get_form_data();
            if (!$this->admin_mdl->chk_admin(0, $data['adminname'])) $this->admin_return(0,'账号已存在');
            if ($this->_admin->_role_type != 0) unset($data['money']);
            $config_setting = $this->setting_mdl->get('config');
            if ($this->_admin->_role_type == 0 && $config_setting['percen']['type'] == 3) {
                if (!is_numeric($data['percen'])) $data['percen'] = null;
            } else {
                unset($data['percen']);
            }
            $this->admin_mdl->add_admin($data);
            $this->_message(translate("新增成功"), "/admin_corp/" . $this->qs_pid, TRUE);
        }
    }

    public function save_add()
    {
        //if ($this->_validate_user_form()){
        $data = $this->_get_form_data();
        if (!$this->admin_mdl->chk_admin(0, $data['adminname'])) $this->admin_return(0,'账号已存在');
        if ($this->_admin->_role_type != 0) unset($data['money']);
        $data['level']=1;
        $data['pass']=$data['password'];
        $data['password'] = md5($data['password']);
        $this->log_mdl->insert('admin',$data);
        die('{"msg":"' . translate("新增成功"). '","redirect":"admin_system#page/admin_corp/"}');

    }
    public function add_subordinate($parent_id=0){
        $post=$this->input->post();
        if (!$post) {
            $this->load->model('role_mdl');
            $roles = $this->role_mdl->get_all_role("id in (" . implode(",", $this->_role[1]) . ")");
            $this->assign('roles', $roles);
            $this->assign('geocoder_key', $this->config->item('geocoder_key'));
            $this->assign('config_setting', $this->setting_mdl->get('config'));
            $this->assign('parent_id',$parent_id);
            $this->display('corp/add_subordinate.html');
        }else{
            $data = $this->_get_form_data();
            if (!$this->admin_mdl->chk_admin(0, $data['adminname'])) die('{"msg":"账号已存在"}');
            if ($this->_admin->_role_type != 0) unset($data['money']);
            $parent=$this->_getrow('admin','*',['id'=>$parent_id]);
            $data['level']=$parent['level']+1;
            $data['pid']=$parent['id'];
            $data['path']=$parent['path']?$parent['path'].','.$parent['id']:$parent['id'];
            $this->admin_mdl->add_admin($data);
            die('{"msg":"' . translate("新增成功"). '","redirect":"admin_system#page/admin_corp/"}');
        }

    }

    private function _validate_user_form($edit = FALSE)
    {
        $this->load->library('form_validation');
        if (!$edit) {
            $this->form_validation->set_rules('adminName', '用户名', 'trim|required|min_length[3]|max_length[16]');
        }
        $this->form_validation->set_rules('password', '密码', 'trim|required|min_length[6]|max_length[16]');
        $this->form_validation->set_rules('repasswd', '重复用户密码', 'trim|required|min_length[6]|max_length[16]|matches[password]');
        if ($this->form_validation->run() == FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /* 获取表单数据
    *
    * @access  private
    * @param   bool
    * @return  array
    */
    private function _get_form_data($edit = FALSE)
    {
        //if(!$edit)
        //{
        $data['adminname'] = $this->input->post('adminname', TRUE);
        //}
        $data['password'] = $this->input->post('password', TRUE);
        if (!$edit) {
            $data['createtime'] = time();
        }
        $data['gid'] = $this->input->post('gid', TRUE);
        $data['status'] = $this->input->post('status', TRUE);
        $data['nickname'] = $this->input->post('nickname', TRUE);
        $data['desc'] = $this->input->post('desc', TRUE);
        $data['name'] = $this->input->post('name', TRUE);
        $data['phone'] = $this->input->post('phone', TRUE);
        $data['mobile'] = $this->input->post('mobile', TRUE);
        $data['mobile_prefix'] = $this->input->post('mobile_prefix', TRUE);
        $data['percen'] = $this->input->post('percen', TRUE);
        $data['cash_fee'] = $this->input->post('cash_fee', TRUE);
        $data['area'] = $this->input->post('area', TRUE);
        $data['address'] = $this->input->post('address', TRUE);
        $data['lat'] = $this->input->post('lat', TRUE);
        $data['lng'] = $this->input->post('lng', TRUE);
        $data['orderby'] = $this->input->post('orderby', TRUE);
        $data['pictures'] = $this->input->post('pictures', TRUE);
        $data['text'] = $this->input->post('text', TRUE);
        $data['keywords'] = $this->input->post('keywords', TRUE);
        $data['license'] = $this->input->post('license', TRUE);
        $data['cardpic'] = $this->input->post('cardpic', TRUE);
        $data['recmdid'] = $this->input->post('recmdid', TRUE);
        $data['user_id'] = $this->input->post('user_id', TRUE);
        $data['default'] = $this->input->post('default', TRUE);
        $data['bank_name'] = $this->input->post('bank_name', TRUE);
        $data['bank_card'] = $this->input->post('bank_card', TRUE);
        $data['compellation'] = $this->input->post('compellation', TRUE);
        $data['mangerids'] = implode(',', array_filter(array_map('intval', explode(',', str_replace('，', ',', $this->input->post('mangerids', TRUE))))));
        $data = array_filter($data, create_function('$a', 'return !is_null($a);'));
        return $data;
    }

    //代理商提现
    public function cash()
    {
        $id = $this->input->get('id')?:$this->input->post('id');
        $post = $this->input->post();
        $agent = $this->_getrow('admin', '*', 'id=' . $id);
        if ($post) {
            if(!$post['money']) die('<script>alert("' . translate("请输入提现金额") . '");top.location.reload();</script>');
            if($agent['money']<$post['money'])  die('<script>alert("' . translate("余额不足！") . '");top.location.reload();</script>');
            if(!preg_match("/^[1-9]\d*$/",$post['money'])){
                die('<script>alert("' . translate("提现金额不能有小数！") . '");top.location.reload();</script>');
            }
            //生成提现申请记录
            $res=$this->log_mdl->insert('admin_cash',[
                'type'=>1,
                'adminid'=>$id,
                'money'=>$post['money'],
                'createtime'=>date('Y-m-d H:i:s'),
                'bankdata'=>json_encode(['bank_card'=>$post['bank_card'],'bank_name'=>$post['bank_name'],'name'=>$post['name']]),
            ]);
            //扣除余额
            $this->log_mdl->update('admin',['money'=>$agent['money']-$post['money']],['id'=>$id]);
            die('<script>alert("' . translate("申请提现成功！") . '");top.location.reload();</script>');
        }
        $this->assign('agent', $agent);
        $this->assign('id', $id);
        $this->display("corp/agent_cash.html");
    }

    //获取代理商的分成比例
    public function get_percen(){
        $id=$this->input->post('id');
        if($id){
            $percen=$this->_getfield('admin','percen',['id'=>$id])?:0;
            $this->admin_return(1,'获取成功',100-$percen);
        }
        $this->admin_return(0,'获取失败');
    }
    public function search()
    {
        $keywords = $this->input->post('keywords');
        if (!empty($keywords)) {
            if($this->_admin->_role_type==3){
                $where = "(a.id='" . $keywords . "' or concat(a.nickname,a.phone,a.mobile,a.adminname,a.address,a.name) like '%" . $keywords . "%') and gid in (" . implode(",", $this->_role[1]) . ")" ." and a.investor_id=".$_SESSION['aid'];
            }else{
                $where = "(a.id='" . $keywords . "' or concat(a.nickname,a.phone,a.mobile,a.adminname,a.address,a.name) like '%" . $keywords . "%') and gid in (" . implode(",", $this->_role[1]) . ")" . $this->_rolesql('a', 'id');
            }
            $result = $this->_getlist('admin as a', 'a.id, concat(a.id, ", ", a.nickname) as `text`', $where, 'a.id desc');
            die('{"status":-1, "data":' . json_encode($result) . '}');
        }
        die('{"status":-1, "data":[]}');
    }
}