<?php /* Smarty version Smarty-3.1.19, created on 2020-06-07 08:47:34
         compiled from "C:\xampp\htdocs\beauty-server\app\views\bguser\list_role.html" */ ?>
<?php /*%%SmartyHeaderCode:915007905edc8d86993256-46558690%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bd6b9e7695e9f2bef95963d88f4fb7a177313365' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beauty-server\\app\\views\\bguser\\list_role.html',
      1 => 1591104997,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '915007905edc8d86993256-46558690',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'values' => 0,
    'v' => 0,
    'role_type' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5edc8d869d1e74_95472091',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5edc8d869d1e74_95472091')) {function content_5edc8d869d1e74_95472091($_smarty_tpl) {?>
<title><?php echo translate('系統設置');?>
 - <?php echo translate('角色列表');?>
</title>
<div class="page-header">
	<h1>
		<?php echo translate('系統設置');?>
 <small> <i class="ace-icon fa fa-angle-double-right"></i> <?php echo translate('角色列表');?>

		</small>
	</h1>
</div>
<!-- /.page-header -->

<div class="row">
	<div class="col-xs-12">
				 
				<form class="form-horizontal" role="form" id="submitform">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th><?php echo translate('编号');?>
</th>
								<th><?php echo translate('名称');?>
</th>
								<th><?php echo translate('类型');?>
</th>
								<th><?php echo translate('创建人');?>
</th>
								<th><?php echo translate('备注');?>
</th>
								<th><?php echo translate('权限');?>
</th>
								<th style="width:12%"><?php echo translate('操作');?>
</th>
								 
							</tr>
						</thead>
						<tbody>
							<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['values']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
							<tr class="alert1" align="left">
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['role_type']->value[$_smarty_tpl->tpl_vars['v']->value['type']];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['aid'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['memo'];?>
</td>
								<td><a href="admin_system#page/admin_command/edit_role_command/<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"><?php echo translate('权限');?>
</a></td>
								 
								<td ><a href="admin_system#page/admin_role/edit/<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"><?php echo translate('编辑');?>
</a> <?php if ($_smarty_tpl->tpl_vars['v']->value['id']>5) {?> | <a class="confirm_delete" href="/admin_role/del/<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"><?php echo translate('删除');?>
</a> <?php }?> </td>
							</tr>
							<?php } ?>

						</tbody>
					</table>
					<div class="col-sm-offset-5 col-sm-7">
						<a href="/admin_system#page/admin_role/add" id="saveedit"
							class="btn  btn-primary btn-lg"><?php echo translate('添加');?>
</a>
					</div>
				</form>
			</div>
		</div>

 
	<script type="text/javascript">
	 
 
	$('a.confirm_delete').click(function(){
		return confirm("<?php echo translate('是否要删除所选数据？');?>
");
	});
</script>
 
 
<?php }} ?>
