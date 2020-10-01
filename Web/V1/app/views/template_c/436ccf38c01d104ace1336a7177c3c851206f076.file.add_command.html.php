<?php /* Smarty version Smarty-3.1.19, created on 2020-06-07 08:47:05
         compiled from "C:\xampp\htdocs\beauty-server\app\views\bguser\add_command.html" */ ?>
<?php /*%%SmartyHeaderCode:17750288145edc8d69ec7db6-99836594%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '436ccf38c01d104ace1336a7177c3c851206f076' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beauty-server\\app\\views\\bguser\\add_command.html',
      1 => 1591104997,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17750288145edc8d69ec7db6-99836594',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'parentId' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5edc8d69ef8a31_21026224',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5edc8d69ef8a31_21026224')) {function content_5edc8d69ef8a31_21026224($_smarty_tpl) {?>
<title><?php echo translate('系統設置');?>
 - <?php echo translate('权限添加');?>
 </title>
<div class="page-header">
	<h1>
		<?php echo translate('系統設置');?>
 <small> <i class="ace-icon fa fa-angle-double-right"></i> <?php echo translate('权限添加');?>

		</small>
	</h1>
</div>
<!-- /.page-header -->
<div class="row">
	<div class="col-xs-12">
		<form class="form-horizontal" role="form" id="submitform" accept-charset="utf-8">
			<input type="hidden" name="parentId" id="parentId" value="<?php echo $_smarty_tpl->tpl_vars['parentId']->value;?>
">
			<div class="form-group">
				<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('名称');?>
:</label>
				<div class="col-xs-12 col-sm-5">
					<span class="block"> <input type="text" id="title" name="title" class="width-100" />
					</span>
				</div>
				<div class="help-block inline">*</div>
			</div>
           
           <?php if ($_smarty_tpl->tpl_vars['parentId']->value==0) {?>
           <div class="form-group">
				<label for="icon" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('图标');?>
css:</label>

				<div class="col-xs-12 col-sm-5">
					<span class="block"> <input type="text" id="icon" name="icon" class="width-100" />
					</span>
				</div>
				 
			</div>
			<?php }?>
			
			<div class="form-group">
				<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('菜单');?>
:</label>

				<div class="col-xs-12 col-sm-5">
					<span class="block"> <select name="ismenu" class="form-control input-width">
							<option value="0" selected="selected"><?php echo translate('否');?>
</option>
							<option value="1"><?php echo translate('是');?>
</option>
					</select>
					</span>
				</div>
				<div class="help-block inline">*</div>
			</div>
			
			<div class="form-group">
				<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('排序');?>
:</label>

				<div class="col-xs-12 col-sm-5">
					<span class="block"> <input type="text" id="sortOrder" name="sortOrder" class="width-100" />
					</span>
				</div>

			</div>
          

			<div class="form-group">
				<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right">URL:</label>

				<div class="col-xs-12 col-sm-5">
					<span class="block"> <input type="text" id="linkPage" name="linkPage" class="width-100" />
					</span>
				</div>
			</div>

			<div class="clearfix form-actions">
				<div class="col-md-offset-3 col-md-9">
					<button class="btn btn-primary btn-lg" type="button" id="saveedit"><?php echo translate('提交');?>
</button>
				</div>
			</div>


		</form>

	</div>
</div>

<script type="text/javascript">
$('#submitform').validate({
			errorElement: 'div',
			errorClass: 'help-block',
			focusInvalid: false,
			rules: {
			title: {
					required: true
				}
			  }
			});
			
    $(document).ready(function () {
		$("#saveedit").click(function () {
		if($('#submitform').valid()){
		  Dlc.service.post("/admin_command/save/", $("#submitform").serialize());
		     return false;
		     }
				});
	});
  </script>

<?php }} ?>
