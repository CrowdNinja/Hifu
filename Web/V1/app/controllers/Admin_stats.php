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
class Admin_stats extends Admin_Controller
{
    /**
     * 构造函数
     *
     * @access  public
     * @return  void
     */


    public function __construct()
    {
        parent:: __construct();
        $this->load->model('setting_mdl');
    }

    public function index()
    {
        $page = $this->input->get('page');
        $pagesize = $this->input->get('pagesize');
        if (empty($pagesize)) $pagesize = 20;

        $corpid = $this->input->get('corpid');
        $createtime1 = $this->input->get('createtime1');
        $createtime2 = $this->input->get('createtime2');

        $this->assign('get', $this->input->get());
        $where = ' status!=0 and  agent_id!=0' . $this->_rolesql('', $this->_getrolefield());
        //处理搜索SQL

        if (is_numeric($corpid)) {
            $where .= ' and agent_id=' . $corpid;
            $this->assign('get_corpid_account', $this->_getfield('admin', 'concat(id, ", ", nickname)', 'id=' . $corpid));
        }

        if (!empty($createtime1)) {
            $createtime1 = $createtime1 . " 00:00:00";
            $where .= " and ctime>='" . $createtime1 . "'";
        }

        if (!empty($createtime2)) {
            $createtime2 = $createtime2 . " 23:59:59";
            $where .= " and ctime<='" . $createtime2 . "'";
        }


        //注意php代码不需要处理搜索URL参数，分页URL的处理注意本页模板页尾的JS代码
        $stats = $this->_getpage('trade', $where, 'id desc', $page, $pagesize,
            array(
                "sum(case when status>0 then pay_money else 0 end) as sum_total,
											    sum( case when status>0 then money else 0 end) as total_money,
												sum(case when status>0 then discount else 0 end) as total_discount,
												sum(case when paytype=2 and status>0 then pay_money else 0 end) as wx_money,
												sum(case when paytype=3 and status>0 then pay_money else 0 end) as ali_money,
												sum(case when paytype=1 and status>0 then pay_money else 0 end) as balance_money,
												sum(case when paytype=4 and status>0 then pay_money else 0 end) as line_money,
												sum(case when  status=-2 then pay_money else 0 end) as refund_money,
												sum(1) as count,agent_id",
                "agent_id"
            ));

        foreach ($stats['list'] as $k => &$v) {
            $v['agent_name'] = $this->_getfield('admin', 'nickname', ['id' => $v['agent_id']]);
        }
        unset($v);
        $stats_all = $this->_getrow('trade', "
												sum(case when status>0 then pay_money else 0 end) as sum_total,
											    sum( case when status>0 then money else 0 end) as total_money,
												sum(case when status>0 then discount else 0 end) as total_discount,
												sum(case when paytype=2 and status>0 then pay_money else 0 end) as wx_money,
												sum(case when paytype=3 and status>0 then pay_money else 0 end) as ali_money,
												sum(case when paytype=1 and status>0 then pay_money else 0 end) as balance_money,
												sum(case when paytype=4 and status>0 then pay_money else 0 end) as line_money,
												sum(case when  status=-2 then pay_money else 0 end) as refund_money,
												sum(1) as count", $where, 'id desc');

        $this->assign('stats', $stats);
        $this->assign('stats_all', $stats_all);
        $this->display('stats/list_stats.html');
    }

    public function shop()
    {
        $page = $this->input->get('page');
        $pagesize = $this->input->get('pagesize');
        if (empty($pagesize)) $pagesize = 20;

        $adminid = $this->input->get('adminid');
        $createtime1 = $this->input->get('createtime1');
        $createtime2 = $this->input->get('createtime2');

        $this->assign('get', $this->input->get());
        $where = ' status!=0 and adminid!=0';
        //处理搜索SQL

        $where .= $this->_rolesql('', $this->_getrolefield());

        if (is_numeric($adminid)) {
            $where .= ' and adminid=' . $adminid;
            $this->assign('get_adminid_account', $this->_getfield('admin', 'concat(id, ", ", nickname)', 'id=' . $adminid));
        }

        if (!empty($createtime1)) {
            $createtime1 = $createtime1 . " 00:00:00";
            $where .= " and ctime>='" . $createtime1 . "'";
        }

        if (!empty($createtime2)) {
            $createtime2 = $createtime2 . " 23:59:59";
            $where .= " and ctime<='" . $createtime2 . "'";
        }


        //注意php代码不需要处理搜索URL参数，分页URL的处理注意本页模板页尾的JS代码
        $stats = $this->_getpage('trade', $where, 'id desc', $page, $pagesize,
            array(
                "sum(case when status>0 then money else 0 end) as total_money,
                sum(case when paytype=5 and status>0 then pay_money else 0 end) as credit_money,
                sum(case when paytype=4 and status>0 then pay_money else 0 end) as line_money,
                sum(case when paytype=1 and status>0 then pay_money else 0 end) as balance_money,
                sum(case when paytype=6 and status>0 then pay_money else 0 end) as cash_money,
                sum(1) as count,adminid",
                "adminid"
            ));

        foreach ($stats['list'] as $k => &$v) {
            $v['admin_name'] = $this->_getfield('admin', 'nickname', ['id' => $v['adminid']]);
            $v['royalty'] = $this->_getfield('admin', 'percen', ['id' => $v['adminid']]);
        }
        unset($v);
        $stats_all = $this->_getrow('trade', 
                "sum(case when status>0 then money else 0 end) as total_money,
                sum(case when paytype=5 and status>0 then pay_money else 0 end) as credit_money,
                sum(case when paytype=4 and status>0 then pay_money else 0 end) as line_money,
                sum(case when paytype=1 and status>0 then pay_money else 0 end) as balance_money,
                sum(case when paytype=6 and status>0 then pay_money else 0 end) as cash_money,
                sum(1) as count", $where, 'id desc');

        // アカウント種別が加盟店の時
        if($_SESSION['gid'] == 4){
            $this->assign('member_store_id', $_SESSION['aid']);
            $this->assign('get_adminid_account', $this->_getfield('admin', 'concat(id, ", ", nickname)', 'id=' . $_SESSION['aid']));
        }
        $this->assign('gid',$_SESSION['gid']);
        $this->assign('stats', $stats);
        $this->assign('stats_all', $stats_all);
        $this->display('stats/list_shop.html');
    }

    public function device()
    {
        $page = $this->input->get('page');
        $pagesize = $this->input->get('pagesize');
        if (empty($pagesize)) $pagesize = 20;

        $macno = trim($this->input->get('macno'));
        $createtime1 = $this->input->get('createtime1');
        $createtime2 = $this->input->get('createtime2');

        $this->assign('get', $this->input->get());
        $where = ' status!=0 ';
        //处理搜索SQL

        $where .= $this->_rolesql('', $this->_getrolefield());


        if ($macno) {
            $where .= ' and macno like "%' . $macno . '%"';
        }

        if (!empty($createtime1)) {
            $createtime1 = $createtime1 . " 00:00:00";
            $where .= " and ctime>='" . $createtime1 . "'";
        }

        if (!empty($createtime2)) {
            $createtime2 = $createtime2 . " 23:59:59";
            $where .= " and ctime<='" . $createtime2 . "'";
        }


        //注意php代码不需要处理搜索URL参数，分页URL的处理注意本页模板页尾的JS代码
        $stats = $this->_getpage('trade', $where, 'id desc', $page, $pagesize,
            array(
                "sum(case when status>0 then pay_money else 0 end) as sum_total,
											    sum( case when status>0 then money else 0 end) as total_money,
												sum(case when status>0 then discount else 0 end) as total_discount,
												sum(case when paytype=2 and status>0 then pay_money else 0 end) as wx_money,
												sum(case when paytype=3 and status>0 then pay_money else 0 end) as ali_money,
												sum(case when paytype=1 and status>0 then pay_money else 0 end) as balance_money,
												sum(case when paytype=4 and status>0 then pay_money else 0 end) as line_money,
												sum(case when  status=-2 then pay_money else 0 end) as refund_money,
												sum(1) as count,macno",
                "macno"
            ));

        $stats_all = $this->_getrow('trade', "
												sum(case when status>0 then pay_money else 0 end) as sum_total,
											    sum( case when status>0 then money else 0 end) as total_money,
												sum(case when status>0 then discount else 0 end) as total_discount,
												sum(case when paytype=2 and status>0 then pay_money else 0 end) as wx_money,
												sum(case when paytype=3 and status>0 then pay_money else 0 end) as ali_money,
												sum(case when paytype=1 and status>0 then pay_money else 0 end) as balance_money,
												sum(case when paytype=4 and status>0 then pay_money else 0 end) as line_money,
												sum(case when  status=-2 then pay_money else 0 end) as refund_money,
												sum(1) as count", $where, 'id desc');

        $this->assign('stats', $stats);
        $this->assign('stats_all', $stats_all);
        $this->display('stats/list_device.html');
    }

    public function export()
    {
        $corpid = $this->input->get('corpid');
        $createtime1 = $this->input->get('createtime1');
        $createtime2 = $this->input->get('createtime2');

        $where = ' status!=0 and agent_id!=0' . $this->_rolesql('', $this->_getrolefield());;
        //处理搜索SQL
        if (is_numeric($corpid)) {
            $where .= ' and agent_id=' . $corpid;
        }

        if (!empty($createtime1)) {
            $createtime1 = $createtime1 . " 00:00:00";
            $where .= " and ctime>='" . $createtime1 . "'";
        }

        if (!empty($createtime2)) {
            $createtime2 = $createtime2 . " 23:59:59";
            $where .= " and ctime<='" . $createtime2 . "'";
        }

        //注意php代码不需要处理搜索URL参数，分页URL的处理注意本页模板页尾的JS代码
        $stats = translate($this->_getlist('trade', array(
            "sum(case when status>0 then pay_money else 0 end) as sum_total,
											    sum( case when status>0 then money else 0 end) as total_money,
												sum(case when status>0 then discount else 0 end) as total_discount,
												sum(case when paytype=2 and status>0 then pay_money else 0 end) as wx_money,
												sum(case when paytype=3 and status>0 then pay_money else 0 end) as ali_money,
												sum(case when paytype=1 and status>0 then pay_money else 0 end) as balance_money,
												sum(case when paytype=4 and status>0 then pay_money else 0 end) as line_money,
												sum(case when  status=-2 then pay_money else 0 end) as refund_money,
            sum(1) as count,agent_id",
            "agent_id"
        ), $where, 'id desc'));

        $filename = './temp/agent_stats.csv';
        $fp = fopen($filename, 'w');
        //fwrite($fp,chr(0xEF).chr(0xBB).chr(0xBF));
        fputcsv($fp, array(mb_convert_encoding(translate('代理商名称'), 'gbk', 'utf8'),
            mb_convert_encoding(translate('营业金额'), 'gbk', 'utf8'),
            mb_convert_encoding(translate('实收金额'), 'gbk', 'utf8'),
            mb_convert_encoding(translate('优惠金额'), 'gbk', 'utf8'),
            mb_convert_encoding(translate('line支付金额'), 'gbk', 'utf8'),
            mb_convert_encoding(translate('支付宝支付金额'), 'gbk', 'utf8'),
            mb_convert_encoding(translate('微信支付金额'), 'gbk', 'utf8'),
            mb_convert_encoding(translate('余额支付金额'), 'gbk', 'utf8'),
            mb_convert_encoding(translate('退款金额'), 'gbk', 'utf8'),
            mb_convert_encoding(translate('订单数量'), 'gbk', 'utf8'),
        ));
        foreach ($stats as $v) {
            $v['agent_name'] = $this->_getfield('admin', 'nickname', ['id' => $v['agent_id']]);
            fputcsv($fp, array(mb_convert_encoding($v['agent_name'] . "\t", 'gbk', 'utf8'),
                    mb_convert_encoding($v['total_money'], 'gbk', 'utf8'),
                    mb_convert_encoding($v['sum_total'], 'gbk', 'utf8'),
                    mb_convert_encoding($v['total_discount'], 'gbk', 'utf8'),

                    //mb_convert_encoding($v['sum_admin_recmd_money']."\t", 'gbk', 'utf8'),
                    //mb_convert_encoding($v['sum_user_recmd_money']."\t", 'gbk', 'utf8'),
                    mb_convert_encoding($v['line_money'], 'gbk', 'utf8'),
                    mb_convert_encoding($v['ali_money'], 'gbk', 'utf8'),
                    mb_convert_encoding($v['wx_money'], 'gbk', 'utf8'),
                    mb_convert_encoding($v['balance_money'], 'gbk', 'utf8'),
                    mb_convert_encoding($v['refund_money'], 'gbk', 'utf8'),
                    mb_convert_encoding($v['count'], 'gbk', 'utf8'),
                )
            );
        }
        fputcsv($fp, array(mb_convert_encoding(translate('总计'), 'gbk', 'utf8'),
                mb_convert_encoding(formatnumber(arraysum($stats, 'total_money'), 2) . "\t", 'gbk', 'utf8'),
                mb_convert_encoding(formatnumber(arraysum($stats, 'sum_total'), 2) . "\t", 'gbk', 'utf8'),
                mb_convert_encoding(formatnumber(arraysum($stats, 'total_discount'), 2) . "\t", 'gbk', 'utf8'),
                //mb_convert_encoding(formatnumber(arraysum($stats, 'sum_admin_recmd_money'), 2)."\t", 'gbk', 'utf8'),
                //mb_convert_encoding(formatnumber(arraysum($stats, 'sum_user_recmd_money'), 2)."\t", 'gbk', 'utf8'),
                mb_convert_encoding(formatnumber(arraysum($stats, 'line_money'), 2) . "\t", 'gbk', 'utf8'),
                mb_convert_encoding(formatnumber(arraysum($stats, 'ali_money'), 2) . "\t", 'gbk', 'utf8'),
                mb_convert_encoding(formatnumber(arraysum($stats, 'wx_money'), 2) . "\t", 'gbk', 'utf8'),
                mb_convert_encoding(formatnumber(arraysum($stats, 'balance_money'), 2) . "\t", 'gbk', 'utf8'),
                mb_convert_encoding(formatnumber(arraysum($stats, 'refund_money'), 2) . "\t", 'gbk', 'utf8'),
                mb_convert_encoding(formatnumber(arraysum($stats, 'count'), 0) . "\t", 'gbk', 'utf8'),
            )
        );

        fclose($fp);
        $fileinfo = pathinfo($filename);
        header('Content-type: application/x-' . $fileinfo['extension']);
        header('Content-Disposition: attachment; filename=' . $fileinfo['basename']);
        header('Content-Length: ' . filesize($filename));
        readfile($filename);
        exit();
    }

    public function shop_export()
    {
        $adminid = $this->input->get('adminid');
        $createtime1 = $this->input->get('createtime1');
        $createtime2 = $this->input->get('createtime2');

        $where = ' status!=0 and adminid!=0';
        //处理搜索SQL

        $where .= $this->_rolesql('', $this->_getrolefield());


        if (is_numeric($adminid)) {
            $where .= ' and adminid=' . $adminid;
            $this->assign('get_adminid_account', $this->_getfield('admin', 'concat(id, ", ", nickname)', 'id=' . $adminid));
        }

        if (!empty($createtime1)) {
            $createtime1 = $createtime1 . " 00:00:00";
            $where .= " and ctime>='" . $createtime1 . "'";
        }

        if (!empty($createtime2)) {
            $createtime2 = $createtime2 . " 23:59:59";
            $where .= " and ctime<='" . $createtime2 . "'";
        }

        //注意php代码不需要处理搜索URL参数，分页URL的处理注意本页模板页尾的JS代码
        $stats = translate($this->_getlist('trade', array(
            "sum(case when status>0 then pay_money else 0 end) as sum_total,
											    sum( case when status>0 then money else 0 end) as total_money,
												sum(case when status>0 then discount else 0 end) as total_discount,
												sum(case when paytype=2 and status>0 then pay_money else 0 end) as wx_money,
												sum(case when paytype=3 and status>0 then pay_money else 0 end) as ali_money,
												sum(case when paytype=1 and status>0 then pay_money else 0 end) as balance_money,
												sum(case when paytype=4 and status>0 then pay_money else 0 end) as line_money,
												sum(case when  status=-2 then pay_money else 0 end) as refund_money,
            sum(1) as count,adminid",
            "adminid"
        ), $where, 'id desc'));

        $filename = './temp/shop_stats.csv';
        $fp = fopen($filename, 'w');
        //fwrite($fp,chr(0xEF).chr(0xBB).chr(0xBF));
        fputcsv($fp, array(mb_convert_encoding(translate('商家名称'), 'gbk', 'utf8'),
            mb_convert_encoding(translate('营业金额'), 'gbk', 'utf8'),
            mb_convert_encoding(translate('实收金额'), 'gbk', 'utf8'),
            mb_convert_encoding(translate('优惠金额'), 'gbk', 'utf8'),
            mb_convert_encoding(translate('line支付金额'), 'gbk', 'utf8'),
            mb_convert_encoding(translate('支付宝支付金额'), 'gbk', 'utf8'),
            mb_convert_encoding(translate('微信支付金额'), 'gbk', 'utf8'),
            mb_convert_encoding(translate('余额支付金额'), 'gbk', 'utf8'),
            mb_convert_encoding(translate('退款金额'), 'gbk', 'utf8'),
            mb_convert_encoding(translate('订单数量'), 'gbk', 'utf8'),
        ));
        foreach ($stats as $v) {
            $v['admin_name'] = $this->_getfield('admin', 'nickname', ['id' => $v['adminid']]);
            fputcsv($fp, array(mb_convert_encoding($v['admin_name'] . "\t", 'gbk', 'utf8'),
                    mb_convert_encoding($v['total_money'], 'gbk', 'utf8'),
                    mb_convert_encoding($v['sum_total'], 'gbk', 'utf8'),
                    mb_convert_encoding($v['total_discount'], 'gbk', 'utf8'),

                    //mb_convert_encoding($v['sum_admin_recmd_money']."\t", 'gbk', 'utf8'),
                    //mb_convert_encoding($v['sum_user_recmd_money']."\t", 'gbk', 'utf8'),
                    mb_convert_encoding($v['line_money'], 'gbk', 'utf8'),
                    mb_convert_encoding($v['ali_money'], 'gbk', 'utf8'),
                    mb_convert_encoding($v['wx_money'], 'gbk', 'utf8'),
                    mb_convert_encoding($v['balance_money'], 'gbk', 'utf8'),
                    mb_convert_encoding($v['refund_money'], 'gbk', 'utf8'),
                    mb_convert_encoding($v['count'], 'gbk', 'utf8'),
                )
            );
        }
        fputcsv($fp, array(mb_convert_encoding(translate('总计'), 'gbk', 'utf8'),
                mb_convert_encoding(formatnumber(arraysum($stats, 'total_money'), 2) . "\t", 'gbk', 'utf8'),
                mb_convert_encoding(formatnumber(arraysum($stats, 'sum_total'), 2) . "\t", 'gbk', 'utf8'),
                mb_convert_encoding(formatnumber(arraysum($stats, 'total_discount'), 2) . "\t", 'gbk', 'utf8'),
                //mb_convert_encoding(formatnumber(arraysum($stats, 'sum_admin_recmd_money'), 2)."\t", 'gbk', 'utf8'),
                //mb_convert_encoding(formatnumber(arraysum($stats, 'sum_user_recmd_money'), 2)."\t", 'gbk', 'utf8'),
                mb_convert_encoding(formatnumber(arraysum($stats, 'line_money'), 2) . "\t", 'gbk', 'utf8'),
                mb_convert_encoding(formatnumber(arraysum($stats, 'ali_money'), 2) . "\t", 'gbk', 'utf8'),
                mb_convert_encoding(formatnumber(arraysum($stats, 'wx_money'), 2) . "\t", 'gbk', 'utf8'),
                mb_convert_encoding(formatnumber(arraysum($stats, 'balance_money'), 2) . "\t", 'gbk', 'utf8'),

                mb_convert_encoding(formatnumber(arraysum($stats, 'refund_money'), 2) . "\t", 'gbk', 'utf8'),
                mb_convert_encoding(formatnumber(arraysum($stats, 'count'), 0) . "\t", 'gbk', 'utf8'),
            )
        );

        fclose($fp);
        $fileinfo = pathinfo($filename);
        header('Content-type: application/x-' . $fileinfo['extension']);
        header('Content-Disposition: attachment; filename=' . $fileinfo['basename']);
        header('Content-Length: ' . filesize($filename));
        readfile($filename);
        exit();
    }

    public function device_export()
    {
        $macno = trim($this->input->get('macno'));
        $createtime1 = $this->input->get('createtime1');
        $createtime2 = $this->input->get('createtime2');

        $where = ' status>0 ';
        //处理搜索SQL

        $where .= $this->_rolesql('', $this->_getrolefield());


        if ($macno) {
            $where .= ' and macno like "%' . $macno . '%"';
        }

        if (!empty($createtime1)) {
            $createtime1 = $createtime1 . " 00:00:00";
            $where .= " and ctime>='" . $createtime1 . "'";
        }

        if (!empty($createtime2)) {
            $createtime2 = $createtime2 . " 23:59:59";
            $where .= " and ctime<='" . $createtime2 . "'";
        }


        //注意php代码不需要处理搜索URL参数，分页URL的处理注意本页模板页尾的JS代码
        $stats = $this->_getlist('trade', array(
            "sum(pay_money) as sum_total,
            sum(money) as total_money,
            sum(discount) as total_discount,
            sum(case when paytype=2 then pay_money else 0 end) as wx_money,
            sum(case when paytype=3 then pay_money else 0 end) as ali_money,
            sum(1) as count,macno",
            "macno"
        ), $where, 'id desc');

        $filename = './temp/device_stats.csv';
        $fp = fopen($filename, 'w');
        //fwrite($fp,chr(0xEF).chr(0xBB).chr(0xBF));
        fputcsv($fp, array(mb_convert_encoding('设备编号', 'gbk', 'utf8'),
            mb_convert_encoding('营业金额', 'gbk', 'utf8'),
            mb_convert_encoding('实收金额', 'gbk', 'utf8'),
            mb_convert_encoding('优惠金额', 'gbk', 'utf8'),
            mb_convert_encoding('支付宝支付金额', 'gbk', 'utf8'),
            mb_convert_encoding('微信支付金额', 'gbk', 'utf8'),
            mb_convert_encoding('订单数量', 'gbk', 'utf8'),
        ));
        foreach ($stats as $v) {
            fputcsv($fp, array(mb_convert_encoding($v['macno'] . "\t", 'gbk', 'utf8'),
                    mb_convert_encoding($v['total_money'], 'gbk', 'utf8'),
                    mb_convert_encoding($v['sum_total'], 'gbk', 'utf8'),
                    mb_convert_encoding($v['total_discount'], 'gbk', 'utf8'),

                    //mb_convert_encoding($v['sum_admin_recmd_money']."\t", 'gbk', 'utf8'),
                    //mb_convert_encoding($v['sum_user_recmd_money']."\t", 'gbk', 'utf8'),

                    mb_convert_encoding($v['ali_money'], 'gbk', 'utf8'),
                    mb_convert_encoding($v['wx_money'], 'gbk', 'utf8'),
                    mb_convert_encoding($v['count'], 'gbk', 'utf8'),
                )
            );
        }
        fputcsv($fp, array(mb_convert_encoding('总计', 'gbk', 'utf8'),
                mb_convert_encoding(formatnumber(arraysum($stats, 'total_money'), 2) . "\t", 'gbk', 'utf8'),
                mb_convert_encoding(formatnumber(arraysum($stats, 'sum_total'), 2) . "\t", 'gbk', 'utf8'),
                mb_convert_encoding(formatnumber(arraysum($stats, 'total_discount'), 2) . "\t", 'gbk', 'utf8'),
                //mb_convert_encoding(formatnumber(arraysum($stats, 'sum_admin_recmd_money'), 2)."\t", 'gbk', 'utf8'),
                //mb_convert_encoding(formatnumber(arraysum($stats, 'sum_user_recmd_money'), 2)."\t", 'gbk', 'utf8'),
                mb_convert_encoding(formatnumber(arraysum($stats, 'ali_money'), 2) . "\t", 'gbk', 'utf8'),
                mb_convert_encoding(formatnumber(arraysum($stats, 'wx_money'), 2) . "\t", 'gbk', 'utf8'),
                mb_convert_encoding(formatnumber(arraysum($stats, 'count'), 0) . "\t", 'gbk', 'utf8'),
            )
        );

        fclose($fp);
        $fileinfo = pathinfo($filename);
        header('Content-type: application/x-' . $fileinfo['extension']);
        header('Content-Disposition: attachment; filename=' . $fileinfo['basename']);
        header('Content-Length: ' . filesize($filename));
        readfile($filename);
        exit();
    }

}