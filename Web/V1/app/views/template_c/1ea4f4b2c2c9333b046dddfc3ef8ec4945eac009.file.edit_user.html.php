<?php /* Smarty version Smarty-3.1.19, created on 2020-06-05 11:10:19
         compiled from "C:\xampp\htdocs\beauty-server\app\views\user\edit_user.html" */ ?>
<?php /*%%SmartyHeaderCode:2522402345eda0bfb05c330-44814681%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1ea4f4b2c2c9333b046dddfc3ef8ec4945eac009' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beauty-server\\app\\views\\user\\edit_user.html',
      1 => 1591104997,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2522402345eda0bfb05c330-44814681',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'row' => 0,
    'user_status' => 0,
    'k' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5eda0bfb0bc7c6_67267527',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5eda0bfb0bc7c6_67267527')) {function content_5eda0bfb0bc7c6_67267527($_smarty_tpl) {?><title><?php echo translate('会员管理');?>
 - <?php if ($_smarty_tpl->tpl_vars['row']->value['id']) {?><?php echo translate('编辑');?>
<?php } else { ?><?php echo translate('添加');?>
<?php }?><?php echo translate('会员');?>
 </title>
<div class="page-header">
	<h1>
		<?php echo translate('会员管理');?>
 <small> <i class="ace-icon fa fa-angle-double-right"></i> <?php if ($_smarty_tpl->tpl_vars['row']->value['id']) {?><?php echo translate('编辑');?>
<?php } else { ?><?php echo translate('添加');?>
<?php }?><?php echo translate('会员');?>

		</small>
	</h1>
</div>
<!-- /.page-header -->
	<script>window.UEDITOR_HOME_URL = '/app/third_party/ueditor1_4_3_3-utf8-php/';</script>
    <script type="text/javascript" charset="utf-8" src="/app/third_party/ueditor1_4_3_3-utf8-php/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/app/third_party/ueditor1_4_3_3-utf8-php/ueditor.all.min.js"> </script>
<!--<script type="text/javascript" charset="utf-8" src="/app/third_party/ueditor1_4_3_3-utf8-php/lang/zh-cn/zh-cn.js"></script>-->
<script type="text/javascript" charset="utf-8" src="/app/third_party/ueditor1_4_3_3-utf8-php/lang/en/en.js"></script>
	<script type="text/plain" id="j_ueditorupload" style="height:5px;display:none;" ></script>
    <script type="text/javascript" charset="utf-8" src="/app/third_party/ueditor1_4_3_3-utf8-php/ueditor.upload.js"></script>

<div class="row">
	<div class="col-md-12">
<div class="main">
    <ul class="nav nav-tabs">
        <li><a href="/admin_system#page/admin_user/"><?php echo translate('会员列表');?>
</a></li>
        <li class="active"><a href="/admin_system#page/admin_user/edit/<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
"><?php if ($_smarty_tpl->tpl_vars['row']->value['id']) {?><?php echo translate('编辑');?>
<?php } else { ?><?php echo translate('添加');?>
<?php }?><?php echo translate('会员');?>
</a></li>
    </ul>

  <div class="panel panel-default">
        <div class="panel-body table-responsive">
        
        		<form class="form-horizontal" role="form" id="submitform" action="/admin_user/edit/<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
" method="post" accept-charset="utf-8">
             
            <div class="form-group">
		<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('手机号');?>
:</label>
		<div class="col-xs-12 col-sm-4">
			<span class="block">
				<input id="account" name="account" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['account'];?>
" class="form-control input-width" autocomplete="new-password"  />
			</span>
		</div>
        <div class="col-xs-12 col-sm-1">
        <a href="javascript:;" class=" check-account btn  btn-primary btn-sm"><?php echo translate('检测重复');?>
</a>
        </div>
		<div class="help-block inline">* <?php echo translate('必须是手机号码');?>
</div>
	</div>
    
    <div class="form-group">
		<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('密码');?>
:</label>
		<div class="col-xs-12 col-sm-4">
			<span class="block">
				<input id="password" type="password" name="password" value=""  class="form-control input-width" autocomplete="new-password" autocomplete="off" />
			</span>
		</div>
		<div class="help-block inline">* <?php echo translate('留空不修改密码');?>
  <?php if (chkcommand('/admin_user/eye_password')) {?><i class="fa fa-eye" id="eye_password" data-text="<?php echo $_smarty_tpl->tpl_vars['row']->value['password1'];?>
"></i><?php }?></div>
	</div>

					<div class="form-group">
						<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('支付密码');?>
:</label>
						<div class="col-xs-12 col-sm-4">
			<span class="block">
				<input id="pay_password" type="password" name="pay_password" maxlength="6" value="" class="form-control input-width" autocomplete="new-password" autocomplete="off" />
			</span>
						</div>
						<div class="help-block inline">* <?php echo translate('留空不修改密码');?>
 <?php if (chkcommand('/admin_user/eye_password')) {?><i class="fa fa-eye" id="eye_pay_password" data-text="<?php echo $_smarty_tpl->tpl_vars['row']->value['pay_password1'];?>
"></i> <?php }?></div>
					</div>
    
      <!---->
			<div class="form-group">
		<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('余额');?>
:</label>
		<div class="col-xs-12 col-sm-1">
			<span class="block">
				<input id="money" type="text" name="money" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['money'];?>
" class="form-control input-width" />
			</span>
		</div>
        <!--<label for="title" class="col-xs-12 col-sm-1 control-label no-padding-right">收益金额（元）:</label>
		<div class="col-xs-12 col-sm-1">
			<span class="block">
				<input id="redmoney" type="text" name="redmoney" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['redmoney'];?>
" class="form-control input-width" />
			</span>
		</div>-->
        </div>
        
       	<div class="form-group">
		<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('昵称');?>
:</label>
		<div class="col-xs-12 col-sm-4">
			<span class="block">
				<input id="nickname" type="text" name="nickname" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['nickname'];?>
" class="form-control input-width" required />
			</span>
		</div>
		<div class="help-block inline"></div>
	</div>
    
              
     <div class="form-group">
		<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('性别');?>
:</label>
		<div class="col-xs-12 col-sm-4">
			<span class="block">
				<input id="sex" type="radio" name="sex" value="1" <?php if (!$_smarty_tpl->tpl_vars['row']->value['sex']||$_smarty_tpl->tpl_vars['row']->value['sex']=='1') {?>checked<?php }?> /><?php echo translate('男');?>

				<input id="sex" type="radio" name="sex" value="2" <?php if ($_smarty_tpl->tpl_vars['row']->value['sex']=='2') {?>checked<?php }?> /><?php echo translate('女');?>

			</span>
		</div>
		<div class="help-block inline"></div>
	</div>
                   
    <!--<div class="form-group">
		<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right">生日:</label>
		<div class="col-xs-12 col-sm-4">
			<span class="block">
				<input id="birthday" type="text" name="birthday" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['birthday'];?>
" class="form-control input-width datetimepicker-date" />
			</span>
		</div>
		<div class="help-block inline"></div>
	</div>

    <div class="form-group">
		<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right">年龄:</label>
		<div class="col-xs-12 col-sm-4">
			<span class="block">
				<input id="age" type="text" name="age" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['age'];?>
" class="form-control input-width" />
			</span>
		</div>
		<div class="help-block inline"></div>
	</div>
          -->

    <div class="form-group">
		<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('地址');?>
:</label>
		<div class="col-xs-12 col-sm-4">
			<span class="block">
				<input id="address" type="text" name="address" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['address'];?>
" class="form-control input-width" />
			</span>
		</div>
		<div class="help-block inline"></div>
	</div>

     
     <div class="form-group">
				<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('头像');?>
</label>
    			<input type="hidden" name="avatar" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['avatar'];?>
" />
				<div class="col-xs-12 col-sm-4">
                	<div class="upfile_imgthumb">
                        <img src="<?php if ($_smarty_tpl->tpl_vars['row']->value['avatar']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['avatar'];?>
<?php } else { ?>/style/xin_inselimg.png<?php }?>" data-default="/style/xin_inselimg.png" class="btn-prefile">
                        <div class="upfile_imgcaption">
                                <a href="javascript:;" class="btn btn-primary btn-xs btn-upfile"><?php echo translate('上传');?>
</a>
                                <a href="javascript:;" class="btn btn-default btn-xs btn-upremove"><?php echo translate('删除');?>
</a>
                        </div>
                    </div>
				</div>
				<div class="help-block inline"></div>
			</div>
                   
      
    <!--<div class="form-group">
		<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('注册日期');?>
:</label>
		<div class="col-xs-12 col-sm-4">
			<span class="block">
				<input id="createtime" type="text" name="createtime" value="<?php echo formattime($_smarty_tpl->tpl_vars['row']->value['createtime'],'Y-m-d H:i:s',formattime(time()));?>
" class="form-control input-width datetimepicker" />
			</span>
		</div>
		<div class="help-block inline"></div>
	</div>-->
    
              
    <!--<div class="form-group">
		<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right">注册IP:</label>
		<div class="col-xs-12 col-sm-5">
			<span class="block">
				<input id="regip" type="text" name="regip" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['regip'];?>
" class="form-control input-width" />
			</span>
		</div>
		<div class="help-block inline"></div>
	</div>-->
      
    <!--<div class="form-group">
		<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right">最近登录时间:</label>
		<div class="col-xs-12 col-sm-4">
			<span class="block">
				<input id="lasttime" type="text" name="lasttime" value="<?php echo formattime($_smarty_tpl->tpl_vars['row']->value['lasttime'],'Y-m-d H:i:s',formattime(time()));?>
" class="form-control input-width datetimepicker" />
			</span>
		</div>
		<div class="help-block inline"></div>
	</div>-->
    
              
  <!--  <div class="form-group">
		<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right">最近登录IP:</label>
		<div class="col-xs-12 col-sm-5">
			<span class="block">
				<input id="lastip" type="text" name="lastip" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['lastip'];?>
" class="form-control input-width" />
			</span>
		</div>
		<div class="help-block inline"></div>
	</div>-->
    
              
   <!-- <div class="form-group">
		<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right">登录次数:</label>
		<div class="col-xs-12 col-sm-4">
			<span class="block">
				<input id="logincount" type="text" name="logincount" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['logincount'];?>
" class="form-control input-width" />
			</span>
		</div>
		<div class="help-block inline"></div>
	</div>-->
    
    <div class="form-group">
		<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('系统备注');?>
:</label>
		<div class="col-xs-12 col-sm-4">
			<span class="block">
				<textarea id="memo" type="text" name="memo" class="form-control input-width"><?php echo $_smarty_tpl->tpl_vars['row']->value['memo'];?>
</textarea>
			</span>
		</div>
		<div class="help-block inline"></div>
	</div>
	
    
    <div class="form-group">
		<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('状态');?>
:</label>
		<div class="col-xs-12 col-sm-4">
			<span class="block">
            	<select name="status" id="status" class="form-control">
               		<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['user_status']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>                 
                		<option value="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" <?php if (strval($_smarty_tpl->tpl_vars['row']->value['status'])==strval($_smarty_tpl->tpl_vars['k']->value)) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</option>
                	<?php } ?>
                    
                </select> 
			</span>
		</div>
		<div class="help-block inline"></div>
	</div>
    
   			 
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-9">
					<button type="button" id="saveedit" class="btn  btn-primary btn-lg"><?php echo translate('提交');?>
</button>
				</div>
			</div>
		</form>
        </div>
        </div>
	</div>
    </div>
</div>


<script type="text/javascript">
var isbusy = false;

$(function(){
	$('#submitform').validate({
			errorElement: 'div',
			errorClass: 'help-block',
			focusInvalid: true,
			rules: {
				title: {
					required: true
				}
			}
	});
	//YYYY-MM-DD HH:mm:ss
	$('.datetimepicker-date').datetimepicker({
		format: 'YYYY-MM-DD',
        language: 'zh-CN',
        pickDate: true,
        pickTime: false,
        hourStep: 1,
        minuteStep: 15,
        secondStep: 30,
        inputMask: true
	});
	//YYYY-MM-DD HH:mm:ss
	$('.datetimepicker').datetimepicker({
		format: 'YYYY-MM-DD HH:mm:ss',
        language: 'zh-CN',
        pickDate: true,
        pickTime: true,
        hourStep: 1,
        minuteStep: 15,
        secondStep: 30,
        inputMask: true
	});
	$('.check-account').click(function(){
		tooltipbox.show("<?php echo translate('正在执行操作');?>
");
		$.post('/admin_user/check', { 'id': "<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
", 'account': $('#account').val() }, function(res){
			if(res.status == '0'){
				tooltipbox.alert("<?php echo translate('账号可用');?>
");
			}else if(res.status == '-1'){
				tooltipbox.alert("<?php echo translate('未提交数据');?>
");
			}else{
				tooltipbox.alert("<?php echo translate('账号已经存在');?>
");
			}
		}, 'json').error(function(){
			tooltipbox.show("<?php echo translate('数据或网络错误');?>
");
		});
		return false;
	});
	$('#eye_password').click(function(){
	    layer.msg($(this).data('text'),'',5000);
	});
    $('#eye_pay_password').click(function(){
        layer.msg($(this).data('text'),'',5000);
    });
	$('#saveedit').click(function(){
		if(!$('#submitform').valid())return false;
		if(isbusy)return false;
		password=$('#password').val();
		if(password && password.length<8){
            tooltipbox.alert("<?php echo translate('登入密码长度不能小于8位');?>
");
            return false;
        }
		isbusy = true;
		tooltipbox.show("<?php echo translate('正在执行操作');?>
");
		$.post('/admin_user/edit/<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
', $('#submitform').serialize(), function(res){
			if(res.status == '1'){
				tooltipbox.show("<?php echo translate('操作完成');?>
");
				location.href = '/admin_system#page/admin_user/';
			}else if(res.status == '0'){
				tooltipbox.alert("<?php echo translate('相同记录已经存在');?>
");
			}else{
				tooltipbox.show("<?php echo translate('数据或网络错误');?>
");
			}
			isbusy = false;
		}, 'json').error(function(a, b, c){
			tooltipbox.show("<?php echo translate('数据或网络错误');?>
");
			isbusy = false;
		});
	});
});
</script> <?php }} ?>
