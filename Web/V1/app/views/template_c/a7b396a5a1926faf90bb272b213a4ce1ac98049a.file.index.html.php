<?php /* Smarty version Smarty-3.1.19, created on 2020-06-22 10:40:11
         compiled from "C:\xampp\htdocs\beauty-server\app\views\subsc\index.html" */ ?>
<?php /*%%SmartyHeaderCode:13418417945edcc6ee981a76-54749521%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a7b396a5a1926faf90bb272b213a4ce1ac98049a' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beauty-server\\app\\views\\subsc\\index.html',
      1 => 1592815207,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13418417945edcc6ee981a76-54749521',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5edcc6ee9d7328_32838102',
  'variables' => 
  array (
    'page' => 0,
    'get' => 0,
    'pack' => 0,
    'v' => 0,
    'list' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5edcc6ee9d7328_32838102')) {function content_5edcc6ee9d7328_32838102($_smarty_tpl) {?><title><?php echo translate('サブスク管理');?>
 - <?php echo translate('メニューの管理');?>

</title>
<!--<div class="page-header">-->
<!--<h1>-->
<!--员工管理 <small><i class="ace-icon fa fa-angle-double-right"></i> 员工列表-->
<!--</small>-->
<!--</h1>-->
<!--</div>-->
<!-- /.page-header -->
<script language='javascript' src="/style/assets/js/jquery.dialogBox.js"></script>
<link rel="stylesheet" href="/style/assets/js/jquery.dialogbox.css" />
<div class="row">
	<div class="col-xs-12">
		<h3>サブスクメニューの管理</h3>
		<!--    <ul class="nav nav-tabs"><li class="active"><a href="/admin_system#page/admin_staff/<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
"><?php echo translate('员工列表');?>
</a></li></ul> -->
		<br />
		<a href="/admin_system#page/admin_subscription/edit/" class="btn btn-complete mb-5">サブスクメニュー追加</a>
		<div class="panel panel-success">
			<div class="panel-heading" onclick="$(this).parent().find('.panel-body').toggle()">
				<i class="glyphicon glyphicon-chevron-down"></i><?php echo translate('筛选');?>

			</div>
			<div class="panel-body" style="display:">
				<div class="form-group form-search form-inline">
					<label class="control-label">メニュー名</label>
					<input  class="form-control" id="menu_name" name="menu_name" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['menu_name'];?>
" style="width:120px" />
							<button class="btn btn-default btn-sm">
								<i class="fa fa-search"></i><?php echo translate('搜索');?>

							</button>
							<!--<button id="importBtn" class="btn btn-sm btn-primary"><i class="fa fa-download"></i> 下载二维码</button>-->
						</div>
					</div>
				</div>
				<script>

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
    });
  </script>
				<form class="form-horizontal" role="form" id="submitform" method="post" action="/admin_subscription/edit" enctype="multipart/form-data">
					<table class="table table-hover table-striped">
						<thead>
							<tr>
								<th><?php echo translate('序号');?>

								</th>
								<th><?php echo translate('套餐名称');?>

								</th>
								<th><?php echo translate('価格');?>

								</th>
								<th><?php echo translate('お得金額');?>

								</th>
								<th><?php echo translate('商家');?>

								</th>
								</th>
								<th><?php echo translate('到期时间');?>

								</th>
								<th><?php echo translate('创建时间');?>

								</th>
								<th><?php echo translate('操作');?>

								</th>
							</tr>
						</thead>
						<tbody><?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['pack']->value['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
							<tr class="alert1" align="left">
								<td>
									<input type="checkbox" name="id[]" value="
										<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" /><?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>

									</td>
									<td><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>

									</td>
									<td><?php echo $_smarty_tpl->tpl_vars['v']->value['price'];?>

									</td>
									<td>
										<b><?php echo $_smarty_tpl->tpl_vars['v']->value['discount'];?>

										</b>
									</td>
									<td>
										<b><?php echo $_smarty_tpl->tpl_vars['v']->value['shop_name'];?>

										</b>
									</td>
									<td><?php echo $_smarty_tpl->tpl_vars['v']->value['validity_time'];?>

									</td>
									<td><?php echo $_smarty_tpl->tpl_vars['v']->value['ctime'];?>

									</td>
									<td ><?php if (chkcommand('/admin_pack/edit')) {?>
										<a href="admin_system#page/admin_subscription/edit/<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="btn btn-success btn-xs">
											<i class="fa fa-edit"></i><?php echo translate('修改');?>

										</a><?php }?>
									</td>
								</tr><?php } ?>
								<tr>
									<td style="border:none" colspan="12">
										<input type="checkbox" id="checkall" onclick="var ck = this.checked;$('input[name=&quot;id[]&quot;]').each(function(){this.checked = ck});"><?php if (chkcommand('/admin_staff/delete')) {?>
											<input id="btnDelete" class="btn btn-default" value="<?php echo translate('删除');?>
" type="button"><?php }?>
												<!--<input id="btnClear" class="btn btn-default" value="清空" type="button">--><?php if (chkcommand('/admin_staff/edit')) {?>
												<a href="/admin_system#page/admin_subscription/edit/" class="btn btn-complete">サブスクメニューを新規追加</a><?php }?>
											</td>
										</tr>
									</tbody>
								</table>
								<!--  <table   style="width:100%;" class="listpage"><tr><td ><?php echo translate('共');?>
<?php echo $_smarty_tpl->tpl_vars['list']->value['total'];?>
<?php echo translate('条记录');?>
<?php echo $_smarty_tpl->tpl_vars['list']->value['pages'];?>
</td></tr></table> -->
							</form>
						</div>
					</div>
				</div>
				<script src="/style/js/jquery.dialogBox.js"></script>
				<div id="dialog-box-mask" style="height: 400px; display: none;"></div>
				<div class="getinfo-box"></div>
				<script type="text/javascript">
          var isbusy = false;
          $(function(){
            $('.listpage').find('a').each(function(){
                var url = $.replaceURL( location.href, 'page', $(this).attr('data-ci-pagination-page') );
                $(this).attr('href', url);
            });
            $('#btnDelete').click(function(){
              var ckvals = $.selectCK('input[name="id[]"]');
              if(!ckvals){
                tooltipbox.show("<?php echo translate('请选择要操作的数据');?>
");
                return false;
              }
              tooltipbox.confirm("サブスクメニューを削除します<br/><span class='alert-red'>＊この作業は取り消せません</span>", function(data){
                tooltipbox.show("<?php echo translate('正在执行操作');?>
");
                $.post('/admin_subscription/delete', data, function(res){
                  if(res.status == '1'){
                    tooltipbox.show("<?php echo translate('操作执行成功');?>
");
                    location.reload();
                  }else{
                    tooltipbox.show("<?php echo translate('数据或网络错误');?>
");
                  }
                }, 'json').error(function(){
                  tooltipbox.show("<?php echo translate('数据或网络错误');?>
");
                });
              }, false, { 'ids': ckvals });
            });
            $('#btnClear').click(function(){
              tooltipbox.confirm('确定永久清空所有数据？', function(data){
                tooltipbox.show("<?php echo translate('正在执行操作');?>
");
                $.post('/admin_staff/clear', { }, function(res){
                  if(res.status == '1'){
                    tooltipbox.show("<?php echo translate('操作执行成功');?>
");
                    location.reload();
                  }else{
                    tooltipbox.show("<?php echo translate('数据或网络错误');?>
");
                  }
                }, 'json').error(function(a, b, c){
                  tooltipbox.show("<?php echo translate('数据或网络错误');?>
");
                });
              });
            });
          });

				</script>
				<script>
    laydate.render({
        elem: '#createtime1',
    });
    laydate.render({
        elem: '#createtime2'
    });
</script>
<?php }} ?>
