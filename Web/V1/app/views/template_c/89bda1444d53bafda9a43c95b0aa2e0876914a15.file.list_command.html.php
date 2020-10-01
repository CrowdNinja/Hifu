<?php /* Smarty version Smarty-3.1.19, created on 2020-06-07 08:41:20
         compiled from "C:\xampp\htdocs\beauty-server\app\views\bguser\list_command.html" */ ?>
<?php /*%%SmartyHeaderCode:6850388615edc8c103a0715-27248779%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '89bda1444d53bafda9a43c95b0aa2e0876914a15' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beauty-server\\app\\views\\bguser\\list_command.html',
      1 => 1591104997,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6850388615edc8c103a0715-27248779',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'tree' => 0,
    'menus' => 0,
    'v' => 0,
    'parentId' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5edc8c103e2269_32533862',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5edc8c103e2269_32533862')) {function content_5edc8c103e2269_32533862($_smarty_tpl) {?> 
<style type="text/css">
.tree {
	min-height: 20px;
	padding: 19px;
	margin-bottom: 20px;
	background-color: #fbfbfb;
	border: 1px solid #999;
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
	-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
	-moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
	box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05)
}

.tree li {
	list-style-type: none;
	margin: 0;
	padding: 10px 5px 0 25px;
	position: relative
}

.tree li::before,.tree li::after {
	left: -20px;
	position: absolute;
	right: auto
}

.tree li::before {
	border-left: 1px solid #999;
	bottom: 50px;
	height: 100%;
	top: 0;
	width: 1px
}

.tree li::after {
	border-top: 1px solid #999;
	height: 20px;
	top: 25px;
	width: 25px
}

.tree li span {
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	border: 1px solid #999;
	border-radius: 5px;
	display: inline-block;
	padding: 3px 8px;
	text-decoration: none
}

.tree li.parent_li>span {
	cursor: pointer
}

.tree>ul>li::before,.tree>ul>li::after {
	border: 0
}

.tree li:last-child::before {
	height: 30px
}

.tree li.parent_li>span:hover,.tree li.parent_li>span:hover+ul li span {
	background: #eee;
	border: 1px solid #94a0b4;
	color: #000
}
</style>
 
 
		
<title><?php echo translate('系統設置');?>
 - <?php echo translate('权限列表');?>
 </title>
<div class="page-header">
	<h1>
		<?php echo translate('系統設置');?>
 <small> <i class="ace-icon fa fa-angle-double-right"></i> <?php echo translate('权限列表');?>

		</small>
	</h1>
</div>
<!-- /.page-header -->

<div class="row">
	<div class="col-xs-12">
			<div class="col-md-4">
				<div class="tree well"><?php echo $_smarty_tpl->tpl_vars['tree']->value;?>
</div>
			</div>
			<div class="col-md-8">
				<form class="form-horizontal" role="form" id="submitform">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th><?php echo translate('编号');?>
</th>
								<th><?php echo translate('名称');?>
</th>
								<th><?php echo translate('父节点');?>
</th>
								<th><?php echo translate('菜单');?>
</th>
								<th><?php echo translate('排序');?>
</th>
								<th><?php echo translate('URL');?>
</th>
								<th><?php echo translate('操作');?>
</th>
							</tr>
						</thead>
						<tbody>
							<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['menus']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
							<tr class="alert1" align="left">
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['parent_id'];?>
</td>
								<td><?php if ($_smarty_tpl->tpl_vars['v']->value['ismenu']==1) {?><?php echo translate('是');?>
<?php }?>
								<?php if ($_smarty_tpl->tpl_vars['v']->value['ismenu']==0) {?><?php echo translate('否');?>
<?php }?></td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['sort_order'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['link_page'];?>
</td>
								<td><a href="admin_system#page/admin_command/edit/<?php echo $_smarty_tpl->tpl_vars['parentId']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"><?php echo translate('编辑');?>
</a> | <a class="confirm_delete" href="/admin_command/del/<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"><?php echo translate('删除');?>
</a></td>
							</tr>
							<?php } ?>

						</tbody>
					</table>
					<div class="col-sm-offset-5 col-sm-7">
						<a href="admin_system#page/admin_command/edit/<?php echo $_smarty_tpl->tpl_vars['parentId']->value;?>
" id="saveedit"
							class="btn  btn-primary btn-lg"><?php echo translate('添加');?>
</a>
					</div>
				</form>
			</div>
		</div>
	</div>
  
	<script type="text/javascript">
	$(function () {
  $('.tree li:has(ul)').addClass('parent_li').find(' > span').attr('title', 'Collapse this branch');
  $('.tree li.parent_li > span').on('click', function (e) {
    var children = $(this).parent('li.parent_li').find(' > ul > li');
    if (children.is(":visible")) {
      children.hide('fast');
      $(this).attr('title', 'Expand this branch').find(' > i').addClass('icon-plus-sign').removeClass('icon-minus-sign');
    } else {
      children.show('fast');
      $(this).attr('title', 'Collapse this branch').find(' > i').addClass('icon-minus-sign').removeClass('icon-plus-sign');
    }
    e.stopPropagation();
  });
});

 
	$('a.confirm_delete').click(function(){
		return confirm("<?php echo translate('是否要删除所选数据?');?>
");
	});
</script>
	 
 <?php }} ?>
