<?php /* Smarty version Smarty-3.1.19, created on 2020-06-24 09:35:56
         compiled from "C:\xampp\htdocs\beauty-server\app\views\bguser\edit_bguser.html" */ ?>
<?php /*%%SmartyHeaderCode:21332520965ef3025ce7c6a0-48656804%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7547804d62ae2b81b5c02d8b2eb24c108ae1bacc' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beauty-server\\app\\views\\bguser\\edit_bguser.html',
      1 => 1591104997,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21332520965ef3025ce7c6a0-48656804',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'data' => 0,
    'roles' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5ef3025cec0e68_84403552',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ef3025cec0e68_84403552')) {function content_5ef3025cec0e68_84403552($_smarty_tpl) {?><title><?php echo translate('系统设置');?>
 - <?php echo translate('操作员编辑');?>
 </title>
<div class="row">
	<div class="col-md-12">
		<form class="form-horizontal" method="post" role="form" id="submitform"  >
			<div class="form-group">
				<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('用户名');?>
:</label>
				<div class="col-xs-12 col-sm-4">
					<span class="block">
						<input id="adminname" type="text" name="adminname" value="<?php echo $_smarty_tpl->tpl_vars['data']->value->adminname;?>
" class="form-control input-width" autocomplete="new-password"  maxlength="100" required />
					</span>
				</div>
                <!--<div class="col-xs-12 col-sm-1">
        <a href="javascript:;" class=" check-adminname btn  btn-primary btn-sm">检测重复</a>
        </div>-->
				<div class="help-block inline"></div>
			</div>
            
            <div class="form-group">
				<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('呢称');?>
*:</label>
				<div class="col-xs-12 col-sm-5">
					<span class="block">
						<input id="nickname" type="text" name="nickname" value="<?php echo $_smarty_tpl->tpl_vars['data']->value->nickname;?>
" class="form-control input-width" required />
					</span>
				</div>
				<div class="help-block inline"></div>
			</div>

			<div class="form-group">
				<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('密码');?>
:</label>
				<div class="col-xs-12 col-sm-5">
					<span class="block" style="padding-top: 6px;"> <a href="#" id="password"><?php echo translate('修改密码');?>
 </a></span>
				</div>
				<div class="help-block inline"></div>
			</div>

			<div class="form-group">
				<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('所属角色');?>
:</label>
				<div class="col-xs-12 col-sm-5">
					<span class="block"  >
						<select name="gid" class="form-control input-width">
							<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['roles']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
							<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"  <?php if ($_smarty_tpl->tpl_vars['v']->value['id']==$_smarty_tpl->tpl_vars['data']->value->gid) {?>selected <?php }?> ><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</option>
							<?php } ?>
						</select> </span>
				</div>
				<div class="help-block inline"></div>
			</div>

			<div class="form-group">
				<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('状态');?>
:</label>
				<div class="col-xs-12 col-sm-5">
					<span class="block"  > <label>
							<input type="radio" name="status" value="1" <?php if ($_smarty_tpl->tpl_vars['data']->value->status==1) {?>
							checked="checked" <?php }?> > <?php echo translate('启用');?>
 </label> &nbsp;&nbsp;&nbsp;<label>
							<input type="radio" name="status" value="0" <?php if ($_smarty_tpl->tpl_vars['data']->value->status==0) {?>
							checked="checked" <?php }?> ><?php echo translate('冻结');?>
 </label> </span>
				</div>
				<div class="help-block inline"></div>
			</div>
            
            
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-9">
					<button type="button" id="saveedit" class="btn  btn-primary btn-lg">
						提交
					</button>
				</div>
			</div>
		</form>
	</div>
</div>
<script src="/style/assets/js/x-editable/bootstrap-editable.min.js"></script>
<script src="/style/assets/js/jquery.gritter.min.js"></script>
<script src="/style/assets/js/x-editable/ace-editable.min.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$('#password').editable({
				type: 'text',
				pk: <?php echo $_smarty_tpl->tpl_vars['data']->value->id;?>
,
				url: '/admin_bguser/save_pwd',
				title:"<?php echo translate('修改密码');?>
" ,
				value: '',
				success: function(response, newValue) {
				var json = eval('(' + response + ')');
				if (json.code == 0)
				return json.msg;
				},
				validate: function(value) {
				if ($.trim(value) == '') {
				return "<?php echo translate('密码为空，不修改.');?>
";
				}
				if($.trim(value).length<4)
					{
					return "<?php echo translate('密码必须大于4位.');?>
";
					}
				
				}
		});
		$('.check-adminname').click(function(){
			tooltipbox.show("<?php echo translate('正在执行操作');?>
");
			$.post('/admin_bguser/check', { 'id': "<?php echo $_smarty_tpl->tpl_vars['data']->value->id;?>
", 'adminname': $('#adminname').val() }, function(res){
				if(res.status == '0'){
					tooltipbox.alert('账号可用');
				}else if(res.status == '-1'){
					tooltipbox.alert('未提交数据');
				}else{
					tooltipbox.alert('账号已经存在');	
				}
			}, 'json').error(function(){
				tooltipbox.show("<?php echo translate('数据或网络错误');?>
");
			});
		});

		$("#saveedit").click(function() {
			//if ($('#submitform').valid()) {
				Dlc.service.post("/admin_bguser/save/<?php echo $_smarty_tpl->tpl_vars['data']->value->id;?>
", $("#submitform").serialize());
				return false;
				//$('#submitform').submit();
			//}
		});
	}); 
</script>
<?php }} ?>
