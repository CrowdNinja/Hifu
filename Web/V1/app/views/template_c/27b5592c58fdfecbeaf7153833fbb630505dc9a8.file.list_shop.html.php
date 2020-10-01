<?php /* Smarty version Smarty-3.1.19, created on 2020-06-04 16:27:24
         compiled from "C:\xampp\htdocs\beauty-server\app\views\stats\list_shop.html" */ ?>
<?php /*%%SmartyHeaderCode:21274565345ed904cce27614-06948749%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '27b5592c58fdfecbeaf7153833fbb630505dc9a8' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beauty-server\\app\\views\\stats\\list_shop.html',
      1 => 1591104997,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21274565345ed904cce27614-06948749',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'get' => 0,
    'get_adminid_account' => 0,
    'stats' => 0,
    'v' => 0,
    'stats_all' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5ed904cce966a0_19985709',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ed904cce966a0_19985709')) {function content_5ed904cce966a0_19985709($_smarty_tpl) {?>
<title><?php echo translate('营业报表');?>
 - <?php echo translate('商家统计');?>
</title>
<div class="page-header">
	<h1>
        <?php echo translate('营业报表');?>
 <small> <i class="ace-icon fa fa-angle-double-right"></i> <?php echo translate('商家统计');?>

		</small>
	</h1>
</div>
<!-- /.page-header -->


<div class="row">
	<div class="col-xs-12">
    
    <ul class="nav nav-tabs">
        <li class="active"><a href="/admin_system#page/admin_stats/shop"><?php echo translate('商家统计');?>
</a></li>
    </ul>
    <br />
    
     <div class="panel panel-success">
    <div class="panel-heading" onclick="$(this).parent().find('.panel-body').toggle()"><i class="glyphicon glyphicon-chevron-down"></i> <?php echo translate('筛选');?>
</div>
    <div class="panel-body" style="display:">

      
            <div class="form-group form-search form-inline">

            <label class="control-label"><?php echo translate('选择商家');?>
</label>
				<input id="adminid" name="adminid" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['adminid'];?>
" style="width:200px" />



                <label class="control-label"><?php echo translate('交易日期');?>
</label>
                    <input class="form-control " name="createtime1" id="createtime1" type="text" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['createtime1'];?>
" placeholder="">
                <label class="control-label"><?php echo translate('至');?>
</label>
                    <input class="form-control " name="createtime2" id="createtime2" type="text" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['createtime2'];?>
" placeholder="">
                
              
                    <button class="btn btn-default btn-sm"><i class="fa fa-search"></i> <?php echo translate('搜索');?>
</button>
                    <?php if (chkcommand('/admin_stats/shop_export')) {?>
                    <button class="btn btn-success btn-export btn-sm"><i class="fa fa-export"></i> <?php echo translate('导出');?>
</button>
                    <?php }?>
            </div>
       
    </div>
 
    </div>
        <script>
            laydate.render({
                elem: '#createtime1',
            });
            laydate.render({
                elem: '#createtime2'
            });

        </script>
<script>
$(function () {

    //$("#userid,#user_recmdid,#admin_recmdid").select2({
	$("#adminid").select2({
		ajax: {
			url: "/admin_shop/search",
			data: function (params) {
				return { 
					keywords: params
				};
			},
			results:function(data,pageNo){
				if(data.data.length){
					data['data'].splice(0, 0, {'id':'', 'text': "<?php echo translate('请选择');?>
"});
				}else{
					data['data'] = [{'id':'', 'text': "<?php echo translate('请选择');?>
"}];
				}
				return {
					results:data.data	
				};
			},
			processResults: function (data) {
				return { 
					results: data
				};
			},
			type: 'post',
			dataType: 'json'
		},	
		initSelection: function(elem, cbfunc){
		},
		allowClear: false,
		openOnEnter: false,
		minimumInputLength: 1,
	});
	<?php if ($_smarty_tpl->tpl_vars['get']->value['adminid']) {?>$('#adminid').select2('data', {id:"<?php echo $_smarty_tpl->tpl_vars['get']->value['adminid'];?>
", text:"<?php echo $_smarty_tpl->tpl_vars['get_adminid_account']->value;?>
"}).select2('val', ["<?php echo $_smarty_tpl->tpl_vars['get']->value['adminid'];?>
"]);<?php }?>


});
</script> 
				
<script>
$(function(){
	//这里处理搜索key，引用 /style/assets/js/jquery.fn.js
	//注意php代码不需要处理搜索URL参数，分页URL的处理注意本页尾的JS代码
	//$.searchURL = function(url = location.href, sConr = '.form-search', sObj = 'input,select,textarea', sJoin = ','){/**/}
	$('.btn-default').click(function(){
		var url = $.searchURL( location.href );
		location.href = url;
	});
	$('.btn-export').click(function(){
		location.href = $.searchURL(location.href).replace('/admin_system#page/admin_stats', '/admin_stats/shop_export');
	});	
});
</script>                 
				 
				<form class="form-horizontal" role="form" id="submitform">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
                                <th><?php echo translate('商家名称');?>
</th>
                                <th><?php echo translate('营业金额');?>
</th>
                                <th><?php echo translate('实收金额');?>
</th>
                                <th><?php echo translate('优惠金额');?>
</th>
                                <th><?php echo translate('line支付金额');?>
</th>
                                <th><?php echo translate('支付宝支付金额');?>
</th>
                                <th><?php echo translate('微信支付金额');?>
</th>
                                <th><?php echo translate('余额支付金额');?>
</th>
                                <th><?php echo translate('退款金额');?>
</th>
                                <th><?php echo translate('订单数量');?>
</th>
							</tr>
						</thead>
						<tbody>
							<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['stats']->value['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
							<tr class="alert1" align="left">
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['admin_name'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['total_money'];?>
 <?php echo translate('元');?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['sum_total'];?>
 <?php echo translate('元');?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['v']->value['total_discount'];?>
 <?php echo translate('元');?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['v']->value['line_money'];?>
 <?php echo translate('元');?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['ali_money'];?>
 <?php echo translate('元');?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['wx_money'];?>
 <?php echo translate('元');?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['balance_money'];?>
 <?php echo translate('元');?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['refund_money'];?>
 <?php echo translate('元');?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['count'];?>
 <?php echo translate('笔');?>
</td>
							</tr>
							<?php } ?>
                            
                            <tr class="success" align="left">
								<td><b><?php echo translate('总计');?>
</b></td>
                                <td><?php echo formatnumber($_smarty_tpl->tpl_vars['stats_all']->value['total_money'],2);?>
 <?php echo translate('元');?>
</td>
                                <td><?php echo formatnumber($_smarty_tpl->tpl_vars['stats_all']->value['sum_total'],2);?>
 <?php echo translate('元');?>
</td>
                                <td><?php echo formatnumber($_smarty_tpl->tpl_vars['stats_all']->value['total_discount'],2);?>
 <?php echo translate('元');?>
</td>
                                <td><?php echo formatnumber($_smarty_tpl->tpl_vars['stats_all']->value['line_money'],2);?>
 <?php echo translate('元');?>
</td>
                                <td><?php echo formatnumber($_smarty_tpl->tpl_vars['stats_all']->value['ali_money'],2);?>
 <?php echo translate('元');?>
</td>
                                <td><?php echo formatnumber($_smarty_tpl->tpl_vars['stats_all']->value['wx_money'],2);?>
 <?php echo translate('元');?>
td>
                                <td><?php echo formatnumber($_smarty_tpl->tpl_vars['stats_all']->value['balance_money'],2);?>
 <?php echo translate('元');?>
</td>
                                <td><?php echo formatnumber($_smarty_tpl->tpl_vars['stats_all']->value['refund_money'],2);?>
 <?php echo translate('元');?>
</td>
                                <td><?php echo formatnumber($_smarty_tpl->tpl_vars['stats_all']->value['count'],0);?>
 <?php echo translate('笔');?>
</td>
                            </tr>
                            
						</tbody>
					</table>
                     <table   style="width:100%;" class="listpage"><tr><td ><?php echo translate('共');?>
 <?php echo $_smarty_tpl->tpl_vars['stats']->value['total'];?>
 <?php echo translate('条记录');?>
 <?php echo $_smarty_tpl->tpl_vars['stats']->value['pages'];?>
  </td></tr></table>
					
				</form>
                </div>
			</div>
		</div>
<script>
$(function(){
	$('.listpage').find('a').each(function(){
		var url = $.replaceURL( location.href, 'page', $(this).attr('data-ci-pagination-page') );
		$(this).attr('href', url);
	});
	//YYYY-MM-DD HH:mm:ss
	$('.datetimepicker').datetimepicker({
		format: 'YYYY-MM-DD',
		language: 'zh-CN',
		pickDate: true,
		pickTime: true,
		hourStep: 1,
		minuteStep: 15,
		secondStep: 30,
		inputMask: true
	});	
	$('#btnExport').click(function(){
		tooltipbox.show("<?php echo translate('正在导出数据');?>
");
		var url = $.searchURL( '/admin_stats/export' );
		$.get(url, { }, function(res){
			if(res.status == 1){
				tooltipbox.show("<?php echo translate('正在下载文件');?>
");
				$.download(res.url);
			}else{
				tooltipbox.show("<?php echo translate('数据或网络错误');?>
");
			}
		}, 'json').error(function(){
			tooltipbox.show("<?php echo translate('数据或网络错误');?>
");
		});
	});
});
</script><?php }} ?>
