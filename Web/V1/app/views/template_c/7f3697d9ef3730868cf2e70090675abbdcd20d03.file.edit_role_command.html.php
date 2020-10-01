<?php /* Smarty version Smarty-3.1.19, created on 2020-06-14 05:47:41
         compiled from "C:\xampp\htdocs\beauty-server\app\views\bguser\edit_role_command.html" */ ?>
<?php /*%%SmartyHeaderCode:14771493435ee59ddd2b1159-00442990%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7f3697d9ef3730868cf2e70090675abbdcd20d03' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beauty-server\\app\\views\\bguser\\edit_role_command.html',
      1 => 1591104997,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14771493435ee59ddd2b1159-00442990',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'data' => 0,
    'id' => 0,
    'tree' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5ee59ddd2dd1b6_68707977',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ee59ddd2dd1b6_68707977')) {function content_5ee59ddd2dd1b6_68707977($_smarty_tpl) {?>
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

<title>系统设置 - 权限编辑</title>
<div class="page-header">
	<h1>
		系统设置 <small> <i class="ace-icon fa fa-angle-double-right"></i> 权限编辑
        <i class="ace-icon fa fa-angle-double-right"></i>  <?php echo $_smarty_tpl->tpl_vars['data']->value->title;?>

		</small>
	</h1>
</div>
<!-- /.page-header -->
<div class="row">
	<div class="col-xs-12">
		<form class="form-horizontal" role="form" id="submitform" action="/admin_command/edit_role_command/<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" method="post" accept-charset="utf-8">

			<input type="hidden" name="roleId" id="roleId" value="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
">
			<div class="row">
				<div class="col-md-12">
					<div class="tree well"><?php echo $_smarty_tpl->tpl_vars['tree']->value;?>
</div>
				</div>
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" id="saveedit" class="btn  btn-primary btn-lg">提交</button>
				</div>
			</div>
		</form>
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
		return confirm('是否要删除所选用户？');	
	});
</script>

<?php }} ?>
