<?php /* Smarty version Smarty-3.1.19, created on 2020-06-07 08:47:48
         compiled from "C:\xampp\htdocs\beauty-server\app\views\bguser\list_setting.html" */ ?>
<?php /*%%SmartyHeaderCode:7212136125edc8d9459cc66-47583395%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5b91beb2e479996098f0c501cc9d73e25814d62e' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beauty-server\\app\\views\\bguser\\list_setting.html',
      1 => 1591104997,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7212136125edc8d9459cc66-47583395',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'list' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5edc8d945cfa30_39021762',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5edc8d945cfa30_39021762')) {function content_5edc8d945cfa30_39021762($_smarty_tpl) {?>
<title><?php echo translate('系統設置');?>
 - <?php echo translate('系統設置');?>
 </title>
<div class="page-header">
	<h1>
		<?php echo translate('系統設置');?>
  <small> <i class="ace-icon fa fa-angle-double-right"></i> <?php echo translate('系統設置');?>

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
								<th><?php echo translate('标题');?>
 </th>
								<th><?php echo translate('变量名');?>
 </th>
								<!--<th>数据</th>-->
								<th><?php echo translate('操作');?>
 </th>
								 
							</tr>
						</thead>
						<tbody>
							<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
							<tr class="alert1" align="left">
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['key'];?>
</td>
								<!--<td><?php echo substr(strip_tags($_smarty_tpl->tpl_vars['v']->value['val']),0,25);?>
...</td>-->
								 <td ><a href="admin_system#page/admin_setting/edit/<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"><?php echo translate('修改');?>
</a></td>
							</tr>
							<?php } ?>

						</tbody>
					</table>
					
				</form>
                </div>
			</div>
		</div>
<?php }} ?>
