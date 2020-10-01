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
trait Admin_cash_export
{
    public function export()
    {
        $ids = $this->input->post('ids');
        $userid = $this->input->get('userid');
        $status = $this->input->get('status');
        $createtime1 = $this->input->get('createtime1');
        $createtime2 = $this->input->get('createtime2');
        $lasttime1 = $this->input->get('lasttime1');
        $lasttime2 = $this->input->get('lasttime2');

        //处理搜索SQL
        $where = ' 1=1 ';
        if ($ids) {
            $where .= ' and a.id in (' . $ids . ')';
        }
        if (is_numeric($userid)) {
            $where .= ' and b.id=' . $userid;
        }
        if (is_numeric($status)) {
            $where .= " and a.status=$status";
        }
        if (!empty($createtime1)) {
            $createtime1 = formattime($createtime1 . ' 00:00:00');
            $where .= " and a.createtime>=" . $createtime1;
        }
        if (!empty($createtime2)) {
            $createtime2 = formattime($createtime2 . ' 23:59:59');
            $where .= " and a.createtime<=" . $createtime2;
        }
        if (!empty($lasttime1)) {
            $lasttime1 = formattime($lasttime1 . ' 00:00:00');
            $where .= " and a.lasttime>=" . $lasttime1;
        }
        if (!empty($lasttime2)) {
            $lasttime2 = formattime($lasttime2 . ' 23:59:59');
            $where .= " and a.lasttime<=" . $lasttime2;
        }

        //注意php代码不需要处理搜索URL参数，分页URL的处理注意本页模板页尾的JS代码
        $cash = translate($this->_getlist(array('user_cash as a', array('user as b', 'a.user_id=b.id')), 'a.*,b.account', $where, 'a.id desc'));

        $fp = fopen('./temp/cash.csv', 'w');
        //fwrite($fp,chr(0xEF).chr(0xBB).chr(0xBF));
        fputcsv($fp, array(mb_convert_encoding(translate('编号'), 'gbk', 'utf8'),
            mb_convert_encoding(translate('会员'), 'gbk', 'utf8'),
            mb_convert_encoding(translate('金额'), 'gbk', 'utf8'),
            mb_convert_encoding(translate('提现资料'), 'gbk', 'utf8'),
            mb_convert_encoding(translate('处理状态'), 'gbk', 'utf8'),
            mb_convert_encoding(translate('申请时间'), 'gbk', 'utf8'),
            mb_convert_encoding(translate('处理时间'), 'gbk', 'utf8'),
        ));
        foreach ($cash as $v) {
            fputcsv($fp, array(mb_convert_encoding($v['id'] . "\t", 'gbk', 'utf8'),
                    mb_convert_encoding($v['user_id'] . ', ' . $v['nickname'].",".$v['account'] . "\t", 'gbk', 'utf8'),
                    mb_convert_encoding($v['money'] . "\t", 'gbk', 'utf8'),
                    mb_convert_encoding(strip_tags($this->cash_status[$v['status']]) . "\t", 'gbk', 'utf8'),
                    mb_convert_encoding($v['createtime'] . "\t", 'gbk', 'utf8'),
                    mb_convert_encoding($v['lasttime'] . "\t", 'gbk', 'utf8'),
                )
            );
        }
        fclose($fp);
        die('{"status":1, "url":"/temp/cash.csv"}');
    }

    public function corp_export()
    {
        $ids = $this->input->post('ids');
        $adminid = $this->input->get('adminid');
        $status = $this->input->get('status');
        $createtime1 = $this->input->get('createtime1');
        $createtime2 = $this->input->get('createtime2');
        $lasttime1 = $this->input->get('lasttime1');
        $lasttime2 = $this->input->get('lasttime2');

        //处理搜索SQL
        $where = ' a.type=1 ' . $this->_rolesql('b', 'id');
        if ($ids) {
            $where .= ' and a.id in (' . $ids . ')';
        }
        if (is_numeric($adminid)) {
            $where .= ' and b.id=' . $adminid;
        }
        if (is_numeric($status)) {
            $where .= " and a.status=$status";
        }
        if (!empty($createtime1)) {
            $createtime1 = formattime($createtime1 . ' 00:00:00');
            $where .= " and a.createtime>=" . $createtime1;
        }
        if (!empty($createtime2)) {
            $createtime2 = formattime($createtime2 . ' 23:59:59');
            $where .= " and a.createtime<=" . $createtime2;
        }
        if (!empty($lasttime1)) {
            $lasttime1 = formattime($lasttime1 . ' 00:00:00');
            $where .= " and a.lasttime>=" . $lasttime1;
        }
        if (!empty($lasttime2)) {
            $lasttime2 = formattime($lasttime2 . ' 23:59:59');
            $where .= " and a.lasttime<=" . $lasttime2;
        }

        //注意php代码不需要处理搜索URL参数，分页URL的处理注意本页模板页尾的JS代码
        $cash = translate($this->_getlist(array('admin_cash as a', array('admin as b', 'a.adminid=b.id')), 'a.*,b.nickname as account', $where, 'a.id desc'));

        $fp = fopen('./temp/cash.csv', 'w');
        //fwrite($fp,chr(0xEF).chr(0xBB).chr(0xBF));
        fputcsv($fp, array(mb_convert_encoding(translate('编号'), 'gbk', 'utf8'),
            mb_convert_encoding(translate('代理商名称'), 'gbk', 'utf8'),
            mb_convert_encoding(translate('提现金额'), 'gbk', 'utf8'),
            mb_convert_encoding(translate('开户行'), 'gbk', 'utf8'),
            mb_convert_encoding(translate('银行卡号'), 'gbk', 'utf8'),
            mb_convert_encoding(translate('开户人姓名'), 'gbk', 'utf8'),
           /* mb_convert_encoding('到账微信用户', 'gbk', 'utf8'),*/
            mb_convert_encoding(translate('处理状态'), 'gbk', 'utf8'),
            mb_convert_encoding(translate('申请时间'), 'gbk', 'utf8'),
            mb_convert_encoding(translate('处理时间'), 'gbk', 'utf8'),
        ));
        foreach ($cash as $v) {
            $v['bank_info'] = json_decode($v['bankdata'], 1);
            //if($v['user_id']) $v['nickname']=$this->_getfield('user','nickname',['id'=>$v['user_id']]);
            $v=$this->replace_null_time($v);
            fputcsv($fp, array(mb_convert_encoding($v['id'] . "\t", 'gbk', 'utf8'),
                    mb_convert_encoding($v['adminid'] . ', ' . $v['account'] . "\t", 'gbk', 'utf8'),
                    mb_convert_encoding($v['money'], 'gbk', 'utf8'),
                    mb_convert_encoding($v['bank_info']['bank_name'] . "\t", 'gbk', 'utf8'),
                    mb_convert_encoding($v['bank_info']['bank_card'] . "\t", 'gbk', 'utf8'),
                    mb_convert_encoding($v['bank_info']['name'] . "\t", 'gbk', 'utf8'),
                   /* mb_convert_encoding($v['nickname'] . "\t", 'gbk', 'utf8'),*/
                    mb_convert_encoding(strip_tags($this->cash_status[$v['status']]) . "\t", 'gbk', 'utf8'),
                    mb_convert_encoding($v['createtime'] . "\t", 'gbk', 'utf8'),
                    mb_convert_encoding($v['lasttime'] . "\t", 'gbk', 'utf8'),
                )
            );
        }
        fclose($fp);
        die('{"status":1, "url":"/temp/cash.csv"}');
    }

    public function shop_export()
    {
        $ids = $this->input->post('ids');
        $adminid = $this->input->get('adminid');
        $status = $this->input->get('status');
        $createtime1 = $this->input->get('createtime1');
        $createtime2 = $this->input->get('createtime2');
        $lasttime1 = $this->input->get('lasttime1');
        $lasttime2 = $this->input->get('lasttime2');

        //处理搜索SQL
        $where = ' a.type=2 ' . $this->_rolesql('b', 'id');
        if ($ids) {
            $where .= ' and a.id in (' . $ids . ')';
        }
        if (is_numeric($adminid)) {
            $where .= ' and b.id=' . $adminid;
        }
        if (is_numeric($status)) {
            $where .= " and a.status=$status";
        }
        if (!empty($createtime1)) {
            $createtime1 = formattime($createtime1 . ' 00:00:00');
            $where .= " and a.createtime>=" . $createtime1;
        }
        if (!empty($createtime2)) {
            $createtime2 = formattime($createtime2 . ' 23:59:59');
            $where .= " and a.createtime<=" . $createtime2;
        }
        if (!empty($lasttime1)) {
            $lasttime1 = formattime($lasttime1 . ' 00:00:00');
            $where .= " and a.lasttime>=" . $lasttime1;
        }
        if (!empty($lasttime2)) {
            $lasttime2 = formattime($lasttime2 . ' 23:59:59');
            $where .= " and a.lasttime<=" . $lasttime2;
        }

        //注意php代码不需要处理搜索URL参数，分页URL的处理注意本页模板页尾的JS代码
        $cash = translate($this->_getlist(array('admin_cash as a', array('admin as b', 'a.adminid=b.id')), 'a.*,b.nickname as account', $where, 'a.id desc'));

        $fp = fopen('./temp/cash.csv', 'w');
        //fwrite($fp,chr(0xEF).chr(0xBB).chr(0xBF));
        fputcsv($fp, array(mb_convert_encoding(translate('编号'), 'gbk', 'utf8'),
            mb_convert_encoding(translate('商家'), 'gbk', 'utf8'),
            mb_convert_encoding(translate('提现金额'), 'gbk', 'utf8'),
            mb_convert_encoding(translate('开户行'), 'gbk', 'utf8'),
            mb_convert_encoding(translate('银行卡号'), 'gbk', 'utf8'),
            mb_convert_encoding(translate('开户人姓名'), 'gbk', 'utf8'),
           /* mb_convert_encoding('到账微信用户', 'gbk', 'utf8'),*/
            mb_convert_encoding(translate('处理状态'), 'gbk', 'utf8'),
            mb_convert_encoding(translate('申请时间'), 'gbk', 'utf8'),
            mb_convert_encoding(translate('处理时间'), 'gbk', 'utf8'),
        ));
        foreach ($cash as $v) {
            $v['bank_info'] = json_decode($v['bankdata'], 1);
            //if($v['user_id']) $v['nickname']=$this->_getfield('user','nickname',['id'=>$v['user_id']]);
            $v=$this->replace_null_time($v);
            fputcsv($fp, array(mb_convert_encoding($v['id'] . "\t", 'gbk', 'utf8'),
                    mb_convert_encoding($v['adminid'] . ', ' . $v['account'] . "\t", 'gbk', 'utf8'),
                    mb_convert_encoding($v['money'], 'gbk', 'utf8'),
                    mb_convert_encoding($v['bank_info']['bank_name'] . "\t", 'gbk', 'utf8'),
                    mb_convert_encoding($v['bank_info']['bank_card'] . "\t", 'gbk', 'utf8'),
                    mb_convert_encoding($v['bank_info']['name'] . "\t", 'gbk', 'utf8'),
                   /* mb_convert_encoding($v['nickname'] . "\t", 'gbk', 'utf8'),*/
                    mb_convert_encoding(strip_tags($this->cash_status[$v['status']]) . "\t", 'gbk', 'utf8'),
                    mb_convert_encoding($v['createtime'] . "\t", 'gbk', 'utf8'),
                    mb_convert_encoding($v['lasttime'] . "\t", 'gbk', 'utf8'),
                )
            );
        }
        fclose($fp);
        die('{"status":1, "url":"/temp/cash.csv"}');
    }
}