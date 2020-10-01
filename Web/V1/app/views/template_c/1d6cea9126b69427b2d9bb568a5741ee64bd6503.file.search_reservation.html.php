<?php /* Smarty version Smarty-3.1.19, created on 2020-07-02 12:06:22
         compiled from "C:\xampp\htdocs\beauty-server\app\views\reservation\search_reservation.html" */ ?>
<?php /*%%SmartyHeaderCode:19418975985ef957b0807786-17482116%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1d6cea9126b69427b2d9bb568a5741ee64bd6503' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beauty-server\\app\\views\\reservation\\search_reservation.html',
      1 => 1593684350,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19418975985ef957b0807786-17482116',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5ef957b0842bf8_75506868',
  'variables' => 
  array (
    'list' => 0,
    'floor' => 0,
    'shop' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ef957b0842bf8_75506868')) {function content_5ef957b0842bf8_75506868($_smarty_tpl) {?>
<title>予約管理 - 予約管理</title>
<div class="page-header">
	<h1>
		予約管理 <small> <i class="ace-icon fa fa-angle-double-right"></i> 予約管理
		</small>
  </h1>
  <div id="app">
    検索結果
  </div>
<!-- /.page-header -->
<!-- <script src="https://cdn.jsdelivr.net/npm/gantt-schedule-timeline-calendar"></script> -->
<script language='javascript' src="/style/assets/js/jquery.dialogBox.js"></script>
<link rel="stylesheet" href="/style/assets/js/jquery.dialogbox.css" />
<link rel="stylesheet" href="/style/assets/css/timeline.css" />
<link rel="stylesheet" href="/style/assets/css/style.css" />
<link rel="stylesheet" href="/style/assets/css/jquery.stackbox.min.css" />

<script>
  $(function(){
    //这里处理搜索key，引用 /style/assets/js/jquery.fn.js
    //注意php代码不需要处理搜索URL参数，分页URL的处理注意本页尾的JS代码
    //$.searchURL = function(url = location.href, sConr = '.form-search', sObj = 'input,select,textarea', sJoin = ','){/**/}
    $('.btn-search').click(function(){
      var url = $.searchURL( location.href );
      location.href = url;
    });
  });
  
  laydate.render({
    elem: '#start_time',
    type: 'datetime',
    format: 'yyyy-MM-dd HH:mm'
  });
  laydate.render({
      elem: '#end_time',
    type: 'datetime',
    format: 'yyyy-MM-dd HH:mm'
  });
  </script>
<div>
</div>
<div class="chart-container">
  <div class="datetime-selector">
    <button id="prevDate" class="date-btn">
      〈
    </button>
    <div id="date">
      <span class="year_date"></span>年<span class="month_date"></span>月<span class="day_date"></span>日
    </div>
    <button id="nextDate" class="date-btn">
      〉
    </button>
  </div>
  <div id="app">
    <div class="search_container">
      <div class="">
        <table>
          <tbody>
            <?php  $_smarty_tpl->tpl_vars['floor'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['floor']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['floor']->key => $_smarty_tpl->tpl_vars['floor']->value) {
$_smarty_tpl->tpl_vars['floor']->_loop = true;
?>
            <tr>
              <?php  $_smarty_tpl->tpl_vars['shop'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['shop']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['floor']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['shop']->key => $_smarty_tpl->tpl_vars['shop']->value) {
$_smarty_tpl->tpl_vars['shop']->_loop = true;
?>
              <td>
                <div class="time_header">
                  <?php echo date("Y年m月d日 H:i",strtotime($_smarty_tpl->tpl_vars['shop']->value['start_time']));?>

                </div>
              </td>
              <?php } ?>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <div class="panel">
        <div class="panel-header">
          <div >検索状況</div>
        </div>
        <div class="panel-body">
          
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<div id="my-content">
<!-- <div class="stackbox"> -->
  <div class="stackbox-body px-2">
    <div class="panel panel-default reserv-dialog">
      <div class="title text-center panel-heading"></div>
      <div class="panel-body">
        <!-- <p class="prev_date"></p> -->
        <p class="date"></p>
        <p class="name"></p>
        <p class="trade_type"></p>
        <p class="remark"></p>
        <input type="hidden" id="reservation_id"/>
      </div>
      <div class="panel-footer">
        <div class="modal_btn_wrapper">
          <button class="btn bg-gray modal_btn dialog-box-close" id="cancel" data-close-stackbox="true">削除</button>
          <button class="btn btn-info modal_btn" id="trigger1">編集</button>
          <button class="btn btn-info modal_btn" style="display: none;" id="trigger2">編集完了</button>
          <button class="btn btn-yellow modal_btn cash_edit" style="display: none;" id="cash_edit">現金支払い編集</button>
        </div>
      </div>
    </div>
  </div>
</div><?php }} ?>
