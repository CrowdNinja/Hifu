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
class Admin_shop extends Admin_Controller
{
    /**
     * 构造函数
     *
     * @access  public
     * @return  void
     */
    private $qs_pid = '';
    private $week=['周日','周一','周二','周三','周四','周五','周六',];
    public function __construct()
    {
        parent::__construct();
        $this->load->model('shoptree_mdl');
        $this->load->model('admin_mdl');
        $this->load->model('setting_mdl');
    }

    public function index()
    {

        $where = " gid in (" . implode(",", $this->_role[2]) . ")" . $this->_rolesql('', 'id');

        $page = $this->input->get('page');
        $pagesize = $this->input->get('pagesize');
        if (empty($pagesize)) $pagesize = 20;
        $adminid = $this->input->get('adminid');
        $corpid = $this->input->get('corpid');
        $investor_id = $this->input->get('investor_id');
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
        if ($investor_id) {
            $where .= " and investor_id=$investor_id";
        }
        if (is_numeric($corpid)) {
            $where .= ' and corpid=' . $corpid;
            $this->assign('get_corpid_account', $this->_getfield('admin', 'concat(id, ", ", nickname)', 'id=' . $corpid));
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
            $v->_corpid = $v->corpid ? $this->_getfield('admin', 'concat(id, ", ", nickname)', "id='" . $v->corpid . "'") : '';
            //$v->_money = $this->admin_mdl->cash_money($v->id);
            if (!is_numeric($v->percen)) $v->percen = $config_setting['shop']['percen'];
            if ($v->investor_id) {
                $v->investor_nickname = $this->_getfield('admin', 'nickname', ['id' => $v->investor_id]);
            }
        }
        unset($v);
        $this->assign("data", $admins);
        $this->assign('config_setting', $config_setting);
        $this->assign('japan_city', $this->_getlist('japan_city', '*', '', 'id desc'));
        $this->assign('p', $page ?: 1);

        // アカウント種別が加盟店の時
        if($_SESSION['gid'] == 4){
            $this->assign('member_store_id', $_SESSION['aid']);
            $this->assign('get_adminid_account', $this->_getfield('admin', 'concat(id, ", ", nickname)', 'id=' . $_SESSION['aid']));
        }
        $this->assign('gid', $_SESSION['gid']);

        $this->display('shop/list_shop.html');
    }

    public function orderby()
    {
        $orderby = $this->input->post('orderby');
        foreach ($orderby as $k => $v) {
            $this->db->where('id=' . $k . $this->_rolesql('', 'id'))->update('admin', array('orderby' => $v));
        }
        echo json_encode(array('status' => 1));
    }

    /**
     * 加盟店編集
     */
    public function edit($id = 0)
    {
        //if($id==1)
        //{
        //	$this->_message('admin不可以更改', '/admin_shop/', TRUE);
        //	exit;
        //}
        if ($this->_validate_user_form() == FALSE) {
            $data = $this->admin_mdl->get_admin_by_id("id=$id");
            if ($data->user_id) $data->userid_account = $this->_getfield('user', 'if(account=nickname,concat(id, ", ", account),concat(id, ", ", account, ", ", nickname))', "id=" . $data->user_id);
            if ($data->corpid) $data->corpid_account = $this->_getfield('admin', 'concat(id, ", ", nickname)', "id=" . $data->corpid);
            // $data->_money = $this->admin_mdl->cash_money($data->id);
            //$data->qrcode = urlencode(base_url('h5/html/pay.html?adminid='.$data->id));
            if($data->hours) {
                $arr=explode('-',$data->hours);
                $data->hours=$arr[0];
                $data->hours1=$arr[1];
            }
            $this->load->model('role_mdl');
            $roles = $this->role_mdl->get_all_role("id in (" . implode(",", $this->_role[2]) . ")");
            $data->keywords = explode(',', $data->keywords);
            $this->assign('_week',explode(',',$data->week));
            $this->assign('data', $data);
            $this->assign('roles', $roles);
            $this->assign('week',$this->week);
            $this->assign('geocoder_key', $this->config->item('geocoder_key'));
            $this->assign('config_setting', $this->setting_mdl->get('config'));
            $this->assign('japan_city', $this->_getlist('japan_city', '*', '', 'id desc'));
            $this->assign('item', $this->_getlist('item', '*', "id <3"));
            $this->assign('phone_area_code',$this->_getlist('phone_area_code','mobile_prefix,country','1=1'));
            $this->assign('gid', $_SESSION['gid']);
            $this->display('shop/edit_shop.html');
        } else {
            $data = $this->_get_form_data(TRUE);
            if (!$this->admin_mdl->chk_admin($id, $data['adminname'])) $this->admin_return(0,'账号已存在');
            if ($this->_admin->_role_type == 0) {
                $data['money'] = $this->input->post('money');// $this->admin_mdl->new_money($id, floatval($this->input->post('money')));
            } else {
                unset($data['money']);
            }
            if ($data['percen'] < 0) $data['percen'] = 0;
            if ($data['percen'] > 100) $data['percen'] = 100;
            $result = $this->admin_mdl->edit_admin_by_id("id=$id" . $this->_rolesql('', 'id'), $data);
            $this->admin_mdl->fixcorp($id, $data['corpid']);

            if (chkcommand('/admin_shop')) {
                $this->_message(translate('修改成功'), '/admin_shop/', TRUE);
            } else {
                $this->_message(translate('修改成功'), '/admin_shop/edit/' . $id, TRUE);
            }
        }
    }

    public function delete()
    {
        //$count = $this->_getcount('admin', "pid=$id");
        //if($count){
        //	$this->_message('请先删除下级.', '/admin_shop/'.$this->qs_pid, TRUE);
        //	exit;
        //}
        $id=$this->input->post('id');
        if ($id) {
            $result = $this->admin_mdl->del_user("id=$id");
            if ($result) {
                $this->admin_mdl->fixpath($id);
                $this->log_mdl->delete('coupon', "adminid=$id");
                $this->log_mdl->delete('user_coupon', "adminid=$id");
                $this->admin_return(1);
            }
        }
        $this->admin_return(0,'操作员不允许删除');
    }

    public function save($id = 0)
    {
        $data = $this->_get_form_data(TRUE);
        if (!$this->admin_mdl->chk_admin($id, $data['adminname'])) $this->admin_return(0,'账号已存在');
        if ($this->_admin->_role_type == 0) {
            $data['money'] = $this->input->post('money');// $this->admin_mdl->new_money($id, floatval($this->input->post('money')));
        } else {
            unset($data['money']);
        }
        if ($data['percen'] < 0) $data['percen'] = 0;
        if ($data['percen'] > 100) $data['percen'] = 100;
        if (!$data['password']) {
            unset($data['password']);
        } else {
            $data['pass'] = $data['password'];
            $data['password'] = md5($data['password']);
        }
        $post=$this->input->post();
        $week=[0,0,0,0,0,0,0];
        for($i=0;$i<7;$i++){
            if(isset($post['week'.$i])) $week[$i]=1;
        }
        $data['week']=implode(',',$week);

        $this->log_mdl->update('admin', $data, "id=$id");
        /* $this->admin_mdl->edit_admin_by_id("id=$id",$data);*/
        $this->admin_mdl->fixcorp($id, $data['corpid']);
        if (chkcommand('/admin_shop')) {
            die('{"msg":"' . translate("修改成功"). '","redirect":"admin_system#page/admin_shop/' . $this->qs_pid . '"}');
        } else {
            die('{"msg":"' . translate("修改成功"). '"}');
        }
    }

    public function save_pwd()
    {
        $id = $this->input->post('pk');
        $name = $this->input->post('name');
        $value = $this->input->post('value');
        $this->admin_mdl->edit_admin_by_id("id=$id" . $this->_rolesql('', 'id'), array($name => $value));
        die('{"msg":"' . translate("修改成功"). '"}');
    }

    public function add()
    {
        if (!$this->_validate_user_form()) {
            $this->load->model('role_mdl');
            $roles = $this->role_mdl->get_all_role("id in (" . implode(",", $this->_role[2]) . ")");

            $this->assign('roles', $roles);
            if ($this->_admin->_role_type == 1) {
                $corp = $this->_getrow('admin', '*', ['id' => $_SESSION['aid']]);
                $this->assign('corpid', $_SESSION['aid']);
                $this->assign('corp', $corp);
            }
            $this->assign('week',$this->week);
            $this->assign('geocoder_key', $this->config->item('geocoder_key'));
            $this->assign('config_setting', $this->setting_mdl->get('config'));
            $this->assign('japan_city', $this->_getlist('japan_city', '*', '', 'id desc'));
            $this->assign('item', $this->_getlist('item', '*', "id <3"));
            $this->assign('phone_area_code',$this->_getlist('phone_area_code','mobile_prefix,country','1=1'));
            $this->display('shop/add_shop.html');
        } else {
            $data = $this->_get_form_data();
            if (!$this->admin_mdl->chk_admin(0, $data['adminname'])) die('{"msg":"' . translate("账号已存在"). '"}');
            if ($this->_admin->_role_type != 0) unset($data['money']);
            if ($data['percen'] < 0) $data['percen'] = 0;
            if ($data['percen'] > 100) $data['percen'] = 100;
            $this->admin_mdl->add_admin($data);
            $this->_message(translate("新增成功"), "/admin_shop/" . $this->qs_pid, TRUE);
        }
    }

    public function save_add()
    {
        $data = $this->_get_form_data();
        if (!$this->admin_mdl->chk_admin(0, $data['adminname'])) die('{"msg":"' . translate("账号已存在"). '"}');
        if ($this->_admin->_role_type != 0) unset($data['money']);

        if ($data['percen'] < 0) $data['percen'] = 0;
        if ($data['percen'] > 100) $data['percen'] = 100;

        if ($this->_admin->_role_type != 0) {
            if ($this->_admin->_role_type == 1) {
                $data['corpid'] = $_SESSION['aid'];
            }
        }
        $post=$this->input->post();
        $week=[0,0,0,0,0,0,0];
        for($i=0;$i<7;$i++){
            if(isset($post['week'.$i])) $week[$i]=1;
        }
        $data['week']=implode(',',$week);
        $data['pass'] = $data['password'];
        $data['password'] = md5($data['password']);
        $this->log_mdl->insert('admin', $data);
        //$this->admin_mdl->add_admin($data);
        die('{"msg":"' . translate("账号已存在"). '","redirect":"admin_system#page/admin_shop/' . $this->qs_pid . '"}');

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
        $data['corpid'] = $this->input->post('corpid', TRUE);
        if ($data['corpid']) {
            $parent = $this->_getrow('admin', '*', ['id' => $data['corpid']]);
            if ($parent) {
                $data['path'] = $parent['path'] ? $parent['path'] . ',' . $parent['id'] : $parent['id'];
            }
        }
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
        $data['mobile_prefix'] = $this->input->post('mobile_prefix', TRUE);
        $data['mobile'] = $this->input->post('mobile', TRUE);
        $data['percen'] = $this->input->post('percen', TRUE);
        $data['thumb'] = $this->input->post('thumb', TRUE);
        $data['cash_fee'] = $this->input->post('cash_fee', TRUE);
        $data['city_type'] = $this->input->post('city_type', TRUE);
        if ($data['city_type'] == 1) {
            $data['area'] = $this->input->post('area', TRUE);
        } else {
            $data['area'] = $this->input->post('area1', TRUE);
        }
        $data['address'] = $this->input->post('address', TRUE);
        $data['lat'] = $this->input->post('lat', TRUE);
        $data['lng'] = $this->input->post('lng', TRUE);
        $data['orderby'] = $this->input->post('orderby', TRUE);
        $data['pictures'] = $this->input->post('pictures', TRUE);
        $data['text'] = $this->input->post('editorValue', TRUE);
        $data['keywords'] = implode(',', $this->input->post('keywords', TRUE)?:[]);
        $data['license'] = $this->input->post('license', TRUE);
        $data['cardpic'] = $this->input->post('cardpic', TRUE);
        $data['recmdid'] = $this->input->post('recmdid', TRUE);
        $data['user_id'] = $this->input->post('user_id', TRUE);
        $data['bank_name'] = $this->input->post('bank_name', TRUE);
        $data['bank_card'] = $this->input->post('bank_card', TRUE);
        $data['compellation'] = $this->input->post('compellation', TRUE);
        $data['hours']=$this->input->post('hours', TRUE);
        $data['business_status']=$this->input->post('business_status', TRUE);
        $hours1=$this->input->post('hours1', TRUE);
        if($hours1) $data['hours'].="-".$hours1;
        // 曜日別営業時間
        $data['mon_st_hours'] = $this->input->post('mon_st_hours', TRUE);
        $data['mon_ed_hours'] = $this->input->post('mon_ed_hours', TRUE);
        $data['tue_st_hours'] = $this->input->post('tue_st_hours', TRUE);
        $data['tue_ed_hours'] = $this->input->post('tue_ed_hours', TRUE);
        $data['wed_st_hours'] = $this->input->post('wed_st_hours', TRUE);
        $data['wed_ed_hours'] = $this->input->post('wed_ed_hours', TRUE);
        $data['thu_st_hours'] = $this->input->post('thu_st_hours', TRUE);
        $data['thu_ed_hours'] = $this->input->post('thu_ed_hours', TRUE);
        $data['fri_st_hours'] = $this->input->post('fri_st_hours', TRUE);
        $data['fri_ed_hours'] = $this->input->post('fri_ed_hours', TRUE);
        $data['sat_st_hours'] = $this->input->post('sat_st_hours', TRUE);
        $data['sat_ed_hours'] = $this->input->post('sat_ed_hours', TRUE);
        $data['sun_st_hours'] = $this->input->post('sun_st_hours', TRUE);
        $data['sun_ed_hours'] = $this->input->post('sun_ed_hours', TRUE);

        $data = array_filter($data, create_function('$a', 'return !is_null($a);'));
        return $data;
    }


    //商家提现
    public function cash()
    {
        $id = $this->input->get('id') ?: $this->input->post('id');
        $post = $this->input->post();
        $agent = $this->_getrow('admin', '*', 'id=' . $id);
        if ($post) {
            if (!$post['money']) die('<script>alert("' . translate("请输入提现金额") . '");top.location.reload();</script>');
            if ($agent['money'] < $post['money']) die('<script>alert("' . translate("余额不足！") . '");top.location.reload();</script>');
            if (!preg_match("/^[1-9]\d*$/", $post['money'])) {
                die('<script>alert("' . translate("提现金额不能有小数！") . '");top.location.reload();</script>');
            }
            //生成提现申请记录
            $res = $this->log_mdl->insert('admin_cash', [
                'type' => 2,
                'adminid' => $id,
                'money' => $post['money'],
                'createtime' => date('Y-m-d H:i:s'),
                'bankdata' => json_encode(['bank_card' => $post['bank_card'], 'bank_name' => $post['bank_name'], 'name' => $post['name']]),
            ]);
            //扣除余额
            $this->log_mdl->update('admin', ['money' => $agent['money'] - $post['money']], ['id' => $id]);
            die('<script>alert("' . translate("申请提现成功！") . '");top.location.reload();</script>');
        }
        $this->assign('agent', $agent);
        $this->assign('id', $id);
        $this->display("shop/shop_cash.html");
    }

    //获取代理商商家
    public function get_corp_shop()
    {
        $parent_id = $this->input->post('parent_id');
        if ($parent_id) {
            $where = " corpid=$parent_id  and  gid in (" . implode(",", $this->_role[2]) . ")" . $this->_rolesql('a', 'id');
            $result = $this->_getlist('admin as a', 'a.id, concat(a.id, ", ", a.nickname) as `text`', $where, 'a.id desc');
            $this->admin_return(1, '获取成功', $result);
        }
        $this->admin_return(0);
    }

    public function search()
    {
        $keywords = $this->input->post('keywords');
        if (!empty($keywords)) {
            $where = "(a.id='" . $keywords . "' or concat(a.nickname,a.phone,a.mobile,a.adminname,a.address,a.name) like '%" . $keywords . "%') and gid in (" . implode(",", $this->_role[2]) . ")" . $this->_rolesql('a', 'id');
            $result = $this->_getlist('admin as a', 'a.id, concat(a.id, ", ", a.nickname) as `text`', $where, 'a.id desc');
            die('{"status":-1, "data":' . json_encode($result) . '}');
        }
        die('{"status":-1, "data":[]}');
    }
    //商家评论列表
    public function shop_evaluate(){
        $page = $this->input->get('page');
        $pagesize = $this->input->get('pagesize');
        if(empty($pagesize))$pagesize = 20;

        $keywords = trim($this->input->get('keywords'));
        $address = trim($this->input->get('address'));
        $adminid = $this->input->get('adminid');
        $createtime1 = $this->input->get('ctime1');
        $createtime2 = $this->input->get('ctime2');
        $this->assign('get', $this->input->get());

        //处理搜索SQL

        $where = "1=1".$this->_rolesql('','shop_id');
        if($keywords){
            $where .= " and macno like '%$keywords%'";
        }
        if($address){
            $where .= " and address like '%$address%'";
        }
        if(is_numeric($adminid)){
            $where .= " and shop_id=$adminid";
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
        $list = $this->_getpage('evaluate', $where, 'id desc', $page, $pagesize,['shop_id,ctime','shop_id']);

        foreach($list['list'] as &$v){
            $v['shop']=$this->_getrow('admin','id,nickname,score',['id'=>$v['shop_id']]);
        }
        unset($v);
        $this->assign('list', $list);
        $this->assign('page', $page?:1);

        // アカウント種別が加盟店の時
        if($_SESSION['gid'] == 4){
            $this->assign('member_store_id', $_SESSION['aid']);
            $this->assign('get_adminid_account', $this->_getfield('admin', 'concat(id, ", ", nickname)', 'id=' . $_SESSION['aid']));
        }
        $this->assign('gid', $_SESSION['gid']);
        $this->display('shop/list_shop_evaluate.html');
    }

    /**
     * 評価リスト詳細
     */
    public function evaluate($shop_id=0,$p=1)
    {
        $page = $this->input->get('page');
        $pagesize = $this->input->get('pagesize');
        if(empty($pagesize))$pagesize = 20;

        $keywords = trim($this->input->get('keywords'));
        $address = trim($this->input->get('address'));
        $adminid = $this->input->get('adminid');
        $user_id=$this->input->get('user_id');
        $createtime1 = $this->input->get('ctime1');
        $createtime2 = $this->input->get('ctime2');
        $this->assign('get', $this->input->get());

        //处理搜索SQL

        $where = "shop_id=$shop_id";

        if($keywords){
            $where .= " and macno like '%$keywords%'";
        }
        if($address){
            $where .= " and address like '%$address%'";
        }
        if(is_numeric($user_id)){
            $where .= ' and user_id='.$user_id;
            $this->assign('get_userid_account', $this->_getfield('user', 'if(account=nickname,concat(id, ", ", account),concat(id, ", ", account, ", ", nickname))', 'id='.$user_id));
        }
        if(is_numeric($adminid)){
            $where .= " and shop_id=$adminid";
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
        $list = $this->_getpage('evaluate', $where, 'id desc', $page, $pagesize);


        foreach($list['list'] as &$v){
            $v['user']=$this->_getrow('user','*',['id'=>$v['user_id']]);
            //$v['shop_name']=$this->_getfield('admin','nickname',['id'=>$v['shop_id']]);
            /*$img=[];
            if($v['imgs']){
                foreach (explode("\n", str_replace("\r", "", $v['imgs'])) as $kk => $vv) {
                    $img[] = base_url($vv);
                }
            }
            $v['img']=$img;*/
        }
        unset($v);
        $this->assign('list', $list);
        $this->assign('p', $p);
        $this->assign('gid', $_SESSION['gid']);
        $this->display('shop/list_evaluate.html');
    }
    //详情
    public function evaluate_info($id=0){
        $row=$this->_getrow('evaluate','*',['id'=>$id]);
        $row['user']=$this->_getrow('user','*',['id'=>$row['user_id']]);
        $row['shop_name']=$this->_getfield('admin','nickname',['id'=>$row['shop_id']]);

        $this->assign('row', $row);
        $this->display('shop/evaluate.html');
    }

    //删除评价
    public function evaluate_delete(){
        $ids=$this->input->post('ids');
        if($ids){
            $this->log_mdl->delete('evaluate',"id in($ids)");
        }
        $this->admin_return(1);
    }

    /**
     * 予約不可時間設定一覧表示
     */
    public function shop_rest()
    {
        $page = $this->input->get('page');
		$pagesize = $this->input->get('pagesize');
        if(empty($pagesize))$pagesize = 20;
        
        // get parameter
		$adminid = $this->input->get('adminid');
        $this->assign('get', $this->input->get());

        // アカウント種別が加盟店の時
        if($_SESSION['gid'] == 4){
            $adminid = $_SESSION['aid'];
        }
        
        $where = '1=1';
        if(is_numeric($adminid)){
			$where .= " and admin_id=$adminid";	
			$this->assign('get_adminid_account', $this->_getfield('admin', 'concat(id, ", ", nickname)', 'id='.$adminid));
		}

        // 予約不可時間情報取得
        $shopRest = $this->_getpage('shop_rest', $where, 'id desc', $page, $pagesize);

		foreach($shopRest['list'] as &$v){
            $v['shop_name'] = $this->_getfield('admin', 'nickname', 'id='.$v['admin_id']);
		}
		unset($v);

        // アカウント種別が加盟店の時
        if($_SESSION['gid'] == 4){
            $this->assign('member_store_id', $_SESSION['aid']);
            $this->assign('get_adminid_account', $this->_getfield('admin', 'concat(id, ", ", nickname)', 'id=' . $_SESSION['aid']));
        }
        $this->assign('gid', $_SESSION['gid']);

        $this->assign('shopRest', $shopRest);
		$this->assign('page', $page);
        $this->display('shop/list_shop_rest.html');
    }

    /**
     * 予約不可時間設定一覧用店舗名検索
     */
    public function shop_rest_search()
    {
        $keywords = $this->input->post('keywords');
        if (!empty($keywords)) {
            $where = "(a.id='" . $keywords . "' or concat(a.nickname,a.phone,a.mobile,a.adminname,a.address,a.name) like '%" . $keywords . "%') and gid in (" . implode(",", $this->_role[2]) . ")" . $this->_rolesql('a', 'id');
            $result = $this->_getlist('admin as a', 'a.id, concat(a.id, ", ", a.nickname) as `text`', $where, 'a.id desc');
            die('{"status":-1, "data":' . json_encode($result) . '}');
        }
        die('{"status":-1, "data":[]}');
    }

    /**
     * 予約不可時間設定編集
     */
    public function edit_shop_rest($id=0, $page=1)
    {
        $post = $this->input->post();

        // 確定時の処理
        if(!empty($post)){
            $data = array();
            $data['admin_id'] = $post['adminid'];
            $data['rest_st_date'] = $post['rest_date'].' '.$post['rest_st_hours'];
            $data['rest_ed_date'] = $post['rest_date'].' '.$post['rest_ed_hours'];
            if(!empty($id)){
                $this->log_mdl->update('shop_rest', $data, 'id='.$id);
            }else{
                $this->log_mdl->insert('shop_rest', $data);
            }
			$this->admin_return(1);
        }

        // 編集時のデータ参照
        if($id){
            $row = $this->_getrow('shop_rest', '*', 'id='.$id);
            $restStartDate = new DateTime($row['rest_st_date']);
            $restEndDate = new DateTime($row['rest_ed_date']);
            $row['rest_date'] = $restStartDate->format('Y-m-d');
            $row['rest_st_hours'] = $restStartDate->format('H:i');
            $row['rest_ed_hours'] = $restEndDate->format('H:i');
            $this->assign('row', $row);
        }

        $session_admin_id = $_SESSION['aid'];
        $shop_where = "";
        if($_SESSION['gid'] == 4){
            $shop_where = " a.id = ".$session_admin_id;
        }
		$shop = $this->_getlist('admin as a', 'a.id, concat(a.id, ", ", a.nickname) as nickname', $shop_where, 'a.id desc');
		$this->assign('shop',$shop);

        $this->display('shop/edit_shop_rest.html');
    }

    /**
     * 予約不可時間設定情報削除
     */
    public function delete_shop_rest()
    {
        $ids = $this->input->post('ids');
        if ($ids) {
            $this->log_mdl->delete('shop_rest', "id in($ids)");
        }
        $this->admin_return(1);
    }

    /**
     * お知らせ一覧
     */
    public function notice_list()
    {
        $page = $this->input->get('page');
		$pagesize = $this->input->get('pagesize');
        if(empty($pagesize))$pagesize = 5;
        
        // アカウント種別が加盟店の時
        if($_SESSION['gid'] == 4){
            $adminid = $_SESSION['aid'];
            // 表示するページが1ページの時
            if(empty($page) || $page == 1){
                // 既読情報取得
                $readInfo = $this->_getrow('notice_read', '*', 'admin_id='.$adminid);
                // 登録データ作成
                $nowDate = new DateTime();
                $data = array();
                $data['read_date'] = $nowDate->format('Y-m-d H:i:s');
                // 既読情報の追加／更新
                if($readInfo){
                    $this->log_mdl->update('notice_read', $data, 'admin_id='.$adminid);
                }else{
                    $data['admin_id'] = $adminid;
                    $this->log_mdl->insert('notice_read', $data);
                }
            }
        }

        // 検索条件なし
        $where = '1=1';

        // お知らせ情報取得
        $noticeInfo = $this->_getpage('notice_info', $where, 'id desc', $page, $pagesize);

        $this->assign('gid', $_SESSION['gid']);
        $this->assign('noticeInfo', $noticeInfo);
		$this->assign('page', $page);
        $this->display('shop/list_notice.html');
    }

    /**
     * お知らせ情報編集
     */
    public function edit_notice($id=0, $page=1)
    {
        $post = $this->input->post();

        // 確定時の処理
        if(!empty($post)){
            $data = array();
            // 登録データ作成
            $nowDate = new DateTime();
            $data['content'] = $post['content'];
            $data['regist_date'] = $nowDate->format('Y-m-d H:i:s');
            if(!empty($id)){
                $this->log_mdl->update('notice_info', $data, 'id='.$id);
            }else{
                $this->log_mdl->insert('notice_info', $data);
            }
			$this->admin_return(1);
        }

        // 編集時のデータ参照
        if($id){
            $row = $this->_getrow('notice_info', '*', 'id='.$id);
            $this->assign('row', $row);
        }

        $this->display('shop/edit_notice.html');
    }

    /**
     * お知らせ情報削除
     */
    public function delete_notice()
    {
        $ids = $this->input->post('ids');
        if ($ids) {
            try{
                $this->log_mdl->delete('notice_info', "id in($ids)");
            }catch(Exception $e){
                $this->admin_return(0, 'データ削除時にエラーが発生しました。');
            }
        }
        $this->admin_return(1);
    }

}