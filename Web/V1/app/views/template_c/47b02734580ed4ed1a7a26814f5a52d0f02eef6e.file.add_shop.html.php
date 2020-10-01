<?php /* Smarty version Smarty-3.1.19, created on 2020-06-08 09:33:23
         compiled from "C:\xampp\htdocs\beauty-server\app\views\shop\add_shop.html" */ ?>
<?php /*%%SmartyHeaderCode:15597789925edde9c3cda323-06780827%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '47b02734580ed4ed1a7a26814f5a52d0f02eef6e' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beauty-server\\app\\views\\shop\\add_shop.html',
      1 => 1591104997,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15597789925edde9c3cda323-06780827',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'data' => 0,
    'roles' => 0,
    'v' => 0,
    'week' => 0,
    'k' => 0,
    '_admin' => 0,
    'item' => 0,
    'phone_area_code' => 0,
    'japan_city' => 0,
    'geocoder_key' => 0,
    'qs_pid' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5edde9c3d70ca9_75582013',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5edde9c3d70ca9_75582013')) {function content_5edde9c3d70ca9_75582013($_smarty_tpl) {?><title><?php echo translate('商家管理');?>
 - <?php echo translate('添加商家');?>
 </title>
<div class="page-header">
	<h1>
		<?php echo translate('商家管理');?>
 <small> <i class="ace-icon fa fa-angle-double-right"></i> <?php echo translate('添加商家');?>

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
	<script type="text/javascript" src="/style/js/cnarealist.js"></script>    
	<script type="text/javascript" src="/style/js/categorys/categorys.js"></script>    
    <link rel="stylesheet" href="/style/js/categorys/categorys.css" />
<script language='javascript' src="/style/assets/js/jquery.dialogBox.js"></script>
<link rel="stylesheet" href="/style/assets/js/jquery.dialogbox.css" />

<div class="row">
	<div class="col-md-12">
<div class="main">
    <ul class="nav nav-tabs">
    	<?php if (chkcommand('/admin_shop')) {?>
        <li><a href="/admin_system#page/admin_shop/"><?php echo translate('添加商家');?>
</a></li>
        <?php }?>
        <li class="active"><a href="/admin_system#page/admin_shop/add/<?php echo $_smarty_tpl->tpl_vars['data']->value->id;?>
"><?php echo translate('添加商家');?>
</a></li>
    </ul>
    
  <div class="panel panel-default">
        <div class="panel-body table-responsive">

		<form class="form-horizontal" method="post" role="form" id="submitform"  >

            <div class="panel panel-info">
        <div class="panel-heading">
            <?php echo translate('账号信息');?>

        </div>
    </div>   
    
			<div class="form-group">
		<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('用户名');?>
*:</label>
		<div class="col-xs-12 col-sm-4">
			<span class="block">
				<input id="adminname" type="text" name="adminname" class="form-control input-width" autocomplete="new-password"  maxlength="100" required />
			</span>
		</div>
        <!--<div class="col-xs-12 col-sm-1">
        <a href="javascript:;" class=" check-adminname btn  btn-primary btn-sm"><?php echo translate('检测重复');?>
</a>
        </div>-->
		<div class="help-block inline"></div>
	</div>
	
			<div class="form-group">
		<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('密码');?>
*:</label>
		<div class="col-xs-12 col-sm-5">
			<span class="block">
				<input id="password" type="password" name="password" class="form-control input-width" autocomplete="new-password" maxlength="100"  required/>
			</span>
		</div>
		<div class="help-block inline"></div>
	</div>
			 <div class="form-group">
		<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('重复密码');?>
*:</label>
		<div class="col-xs-12 col-sm-5">
			<span class="block">
				<input id="repasswd" type="password" name="repasswd" class="form-control input-width" autocomplete="new-password" maxlength="100"  required/>
			</span>
		</div>
		<div class="help-block inline"></div>
	</div>
    
    
     <div class="form-group">
		<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('所属角色');?>
*:</label>
		<div class="col-xs-12 col-sm-5">
			<span class="block">
				<select name="gid" class="form-control input-width">
                           <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['roles']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
						<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" ><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</option>
					  <?php } ?>
					</select> 
			</span>
		</div>
		<div class="help-block inline"></div>
	</div>
			 
		


			 <div class="form-group">
		<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('状态');?>
:</label>
		<div class="col-xs-12 col-sm-5">
			<span class="block">
				<label> <input type="radio" name="status" value="1" checked="checked"> <?php echo translate('正常');?>

					</label> &nbsp;&nbsp;&nbsp;<label> <input type="radio" name="status" value="0"><?php echo translate('禁用');?>

					</label>&nbsp;&nbsp;&nbsp;<!--<label> <input type="radio" name="status" value="2">已禁用-->
					<!--</label>-->
			</span>
		</div>
		<div class="help-block inline"><?php echo translate('禁用将不能登入');?>
</div>
	</div>
			<div class="form-group">
				<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('营业状态');?>
:</label>
				<div class="col-xs-12 col-sm-5">
			<span class="block">

					 &nbsp;&nbsp;&nbsp;<label> <input type="radio" name="business_status"  checked="checked" value="0"><?php echo translate('营业');?>
</label>
				<label> <input type="radio" name="business_status" value="1" > <?php echo translate('关闭');?>
</label>
					&nbsp;&nbsp;&nbsp;<!--<label> <input type="radio" name="status" value="2">已禁用-->
				<!--</label>-->
			</span>
				</div>
				<div class="help-block inline"><?php echo translate('关闭APP将不显示该商家');?>
</div>
			</div>
			<div class="form-group">
				<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('不可预约时间');?>
:</label>
				<div class="col-xs-12 col-sm-5">
					<span class="block">
						<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['week']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
						<input type="checkbox" name="week<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" value="1"  <?php if ($_smarty_tpl->tpl_vars['data']->value->week[$_smarty_tpl->tpl_vars['k']->value]==1) {?>checked="checked"<?php }?> /><?php echo $_smarty_tpl->tpl_vars['v']->value;?>

						<?php } ?>
					</span>
				</div>
				<div class="help-block inline"></div>
			</div>
             <!--<div class="form-group">
				<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right">绑定会员:</label>
				<div class="col-xs-12 col-sm-5">
					<span class="block">
						<input id="userid" type="text" data-bindmobile="1" name="userid" value="<?php echo $_smarty_tpl->tpl_vars['data']->value->userid;?>
" style="width:100%" />
					</span>
				</div>
				<div class="help-block inline">* 必须绑定手机号码</div>
			</div>
            
        	<div class="form-group">
                <label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right">入驻推荐会员:</label>
                <div class="col-xs-12 col-sm-5">
                    <span class="block">
                        <input id="recmdid" name="recmdid" value="<?php echo $_smarty_tpl->tpl_vars['data']->value->recmdid;?>
" style="width:100%" />
                    </span>
                </div>
                <div class="help-block inline"></div>
            </div>-->

        <div class="form-group select_agent">
                <label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('所属代理商');?>
:</label>
                <div class="col-xs-12 col-sm-5">
                    <span class="block">
                        <input id="corpid" name="corpid" value="<?php echo $_smarty_tpl->tpl_vars['data']->value->corpid;?>
" style="width:100%"  />
                    </span>
                </div>
                <div class="help-block inline"></div>
            </div>



             <?php if ($_smarty_tpl->tpl_vars['_admin']->value->_role_type==0) {?>
            <div class="form-group">
				<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('账户余额');?>
:</label>
				<div class="col-xs-12 col-sm-5">
					<span class="block">
						<input id="money" type="text" name="money" value="0" min="0" class="form-control input-width" />
					</span>
				</div>
				<div class="help-block inline"></div>
			</div>
            <?php }?>
            

            <div class="form-group">
				<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('分成比例');?>
<b style="color:red;">%</b>:</label>
				<div class="col-xs-12 col-sm-5">
					<span class="block">
						<input id="percen" type="text" name="percen" value="<?php echo $_smarty_tpl->tpl_vars['data']->value->percen;?>
" max="100" min="0" class="form-control input-width" />
					</span>
				</div>
				<div class="help-block inline"><b id="limit-percen"></b> </div>
			</div>

			<!--<?php if ($_smarty_tpl->tpl_vars['_admin']->value->_role_type==0) {?>
			<div class="form-group">
				<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right">提现手续费比例<b style="color:red;">%</b>:</label>
				<div class="col-xs-12 col-sm-5">
					<span class="block">
						<input id="cash_fee" type="text" name="cash_fee" value="<?php echo $_smarty_tpl->tpl_vars['data']->value->cash_fee;?>
" class="form-control input-width"  />
					</span>
				</div>
				<div class="help-block inline" style="color:red;"> 例如：比例1% 提现100元 手续费收1元，填0或者空视为不收取提现手续费</div>
			</div>
			<?php }?>-->
			<div class="form-group">
				<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right" ><?php echo translate('营业开始时间');?>
:</label>
				<div class="col-xs-12 col-sm-2">
					<span class="block input-icon input-icon-right">
						<input id="hours" type="text" name="hours" value="<?php echo $_smarty_tpl->tpl_vars['data']->value->hours;?>
" class="form-control input-width"   required/>
					  <i class="ace-icon fa fa-clock-o green"></i>
					</span>
				</div>
				<label for="title" class="col-xs-12 col-sm-1 control-label no-padding-right" style="white-space: nowrap;"><?php echo translate('营业结束时间');?>
:</label>
				<div class="col-xs-12 col-sm-2">
					<span class="block input-icon input-icon-right">
						<input id="hours1" type="text" name="hours1" value="<?php echo $_smarty_tpl->tpl_vars['data']->value->hours1;?>
" class="form-control input-width"  required/>
                        <i class="ace-icon fa fa-clock-o green"></i>
					</span>
				</div>

				<div class="help-block inline"></div>
			</div>

			<div class="form-group">
				<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('logo');?>
</label>
				<input type="hidden" name="thumb" value="<?php echo $_smarty_tpl->tpl_vars['data']->value->thumb;?>
" />
				<div class="col-xs-12 col-sm-5">
					<div class="upfile_imgthumb">
						<img src="<?php if ($_smarty_tpl->tpl_vars['data']->value->thumb) {?><?php echo $_smarty_tpl->tpl_vars['data']->value->thumb;?>
<?php } else { ?>/style/xin_inselimg.png<?php }?>" data-default="/style/xin_inselimg.png" class="btn-upfile">
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
            <div class="form-group">
				<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('商家名称');?>
*:</label>
				<div class="col-xs-12 col-sm-5">
					<span class="block">
						<input id="nickname" type="text" name="nickname" value="<?php echo $_smarty_tpl->tpl_vars['data']->value->nickname;?>
" class="form-control input-width"  required/>
					</span>
				</div>
				<div class="help-block inline"></div>
			</div>
			<div class="form-group">
				<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('商家类型');?>
*:</label>
				<div class="col-xs-12 col-sm-5">
					<span class="block">
						<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['item']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
						<input type="checkbox" name="keywords[]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
"   /><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>

						<?php } ?>
					</span>
				</div>
				<div class="help-block inline"></div>
			</div>


			<div class="form-group">
				<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('联系人');?>
:</label>
				<div class="col-xs-12 col-sm-5">
					<span class="block">
						<input id="name" type="text" name="name" value="" class="form-control input-width"  />
					</span>
				</div>
				<div class="help-block inline"></div>
			</div>


			<div class="form-group">
				<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('手机地区号');?>
:</label>
				<div class="col-xs-12 col-sm-2">
					<select name="mobile_prefix" id="mobile_prefix" class="form-control">
						<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['phone_area_code']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
						<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['mobile_prefix'];?>
" <?php if ($_smarty_tpl->tpl_vars['data']->value->mobile_prefix==strval($_smarty_tpl->tpl_vars['v']->value['mobile_prefix'])) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value['country'];?>
 (<?php echo $_smarty_tpl->tpl_vars['v']->value['mobile_prefix'];?>
)</option>
						<?php } ?>
					</select>
				</div>
				<label for="title" class="col-xs-12 col-sm-1 control-label no-padding-right"><?php echo translate('手机号码');?>
:</label>
				<div class="col-xs-12 col-sm-2">
					<span class="block">
						<input id="phone" type="number" name="phone" value="<?php echo $_smarty_tpl->tpl_vars['data']->value->phone;?>
" class="form-control input-width"  />
					</span>
				</div>
				<div class="help-block inline"></div>
			</div>



			<!--<div class="form-group select_agent">
				<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right">绑定微信提现用户:</label>
				<div class="col-xs-12 col-sm-5">
                    <span class="block">
                        <input id="user_id" name="user_id" value="<?php echo $_smarty_tpl->tpl_vars['data']->value->user_id;?>
" style="width:100%"  />
                    </span>
				</div>
				<div class="help-block inline"></div>
			</div>-->



			<div class="form-group">
				<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('城市类型');?>
:</label>
				<div class="col-xs-12 col-sm-5">
			<span class="block">
				<label> <input type="radio" name="city_type" class="city_type" value="1" checked="checked"> <?php echo translate('中国');?>

					</label> &nbsp;&nbsp;&nbsp;<label> <input type="radio" class="city_type" name="city_type" value="2"><?php echo translate('日本');?>

					</label>&nbsp;&nbsp;&nbsp;<!--<label> <input type="radio" name="status" value="2">已禁用-->
				<!--</label>-->
			</span>
				</div>
				<div class="help-block inline"></div>
			</div>

            <div class="form-group area1">
                <label class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('城市');?>
:</label>
                <div class="col-xs-12 col-sm-5">
                    <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['data']->value->area;?>
" id="area" name="area" />
                    <span class="block">
                        <div class="categorys-selector" data-datalist="cnAreaList" data-dataval="name" data-dataview="name" data-datablock=" " data-field="area">
                        <div class="categorys-text"><?php if ($_smarty_tpl->tpl_vars['data']->value->area) {?>	<?php echo $_smarty_tpl->tpl_vars['data']->value->area;?>
 <?php } else { ?> <?php echo translate('请选择');?>
 <?php }?><div></div><b></b></div>
                        <div class="categorys-close"></div>
                        </div>               
                    </span>
                </div>
                <div class="help-block inline"></div>
            </div>

			<div class="form-group area2">
				<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('城市');?>
:</label>
				<div class="col-xs-12 col-sm-5">
					<span class="block">
						 <select name="area1" id="area1" class="form-control input-width" >
                                            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['japan_city']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                                            <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
" <?php if ($_smarty_tpl->tpl_vars['data']->value->area==$_smarty_tpl->tpl_vars['v']->value['name']) {?>selected="selected"<?php }?> > <?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</option>
							 <?php } ?>
                                        </select>
					</span>
				</div>
				<div class="help-block inline"></div>
			</div>
           <div class="form-group">
				<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('详细地址');?>
:</label>
				<div class="col-xs-12 col-sm-5">
					<span class="block">
						<input id="address" type="text" name="address" value="<?php echo $_smarty_tpl->tpl_vars['data']->value->address;?>
" class="form-control input-width"  required/>
					</span>
				</div>
				<div class="help-block inline"></div>
			</div>
            
            <div class="form-group">
				<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('地址坐标');?>
:</label>
				<div class="col-xs-12 col-sm-2">
					<span class="block">
						<input id="lat" type="text" name="lat" value="" class="form-control input-width" required />
					</span>
				</div>
				<div class="col-xs-12 col-sm-2">
					<span class="block">
						<input id="lng" type="text" name="lng" value="" class="form-control input-width"  required/>
					</span>
				</div>
                <div class="col-xs-12 col-sm-1">
                    <a href="javascript:;" class="btn-location btn btn-primary btn-sm"><?php echo translate('获取坐标');?>
</a>
                </div>
                <div class="col-xs-12 col-sm-1">
                    <div class="pull-right"></div><a href="javascript:;" class="btn-map btn btn-primary btn-sm"><?php echo translate('地图选择');?>
</a>
                </div>
				<div class="help-block inline">* <?php echo translate('请先填写所在地址');?>
</div>
			</div>

    
    <!--<div class="form-group">
    	<label class="col-xs-12 col-sm-3 control-label no-padding-right">证件图:</label>
    	<div class="col-xs-12 col-sm-2">
			<div class="form-group">
    			<input type="hidden" name="license" value="<?php echo $_smarty_tpl->tpl_vars['data']->value->license;?>
" />
				<div class="col-xs-12 col-sm-5">
                    <label>执照</label>
                	<div class="upfile_imgthumb">
                        <img src="<?php if ($_smarty_tpl->tpl_vars['data']->value->license) {?><?php echo $_smarty_tpl->tpl_vars['data']->value->license;?>
<?php } else { ?>/style/xin_inselimg.png<?php }?>" data-default="/style/xin_inselimg.png" class="btn-prefile">
                        <div class="upfile_imgcaption">
                                <a href="javascript:;" class="btn btn-primary btn-xs btn-upfile">上传</a> 
                                <a href="javascript:;" class="btn btn-default btn-xs btn-upremove">删除</a>
                        </div>
                    </div>
				</div>
				<div class="help-block inline"></div>
			</div>
        </div>
        
        <div class="col-xs-12 col-sm-2">
    	 <div class="form-group">				
    			<input type="hidden" name="cardpic" value="<?php echo $_smarty_tpl->tpl_vars['data']->value->cardpic;?>
" />
				<div class="col-xs-12 col-sm-5">
                	<label>身份证</label>
                	<div class="upfile_imgthumb">
                        <img src="<?php if ($_smarty_tpl->tpl_vars['data']->value->cardpic) {?><?php echo $_smarty_tpl->tpl_vars['data']->value->cardpic;?>
<?php } else { ?>/style/xin_inselimg.png<?php }?>" data-default="/style/xin_inselimg.png" class="btn-prefile">
                        <div class="upfile_imgcaption">
                                <a href="javascript:;" class="btn btn-primary btn-xs btn-upfile">上传</a> 
                                <a href="javascript:;" class="btn btn-default btn-xs btn-upremove">删除</a>
                        </div>
                    </div>
				</div>
				<div class="help-block inline"></div>
			</div>
        </div>
    	
    </div>-->
			<div class="form-group">
				<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('开户人姓名');?>
:</label>
				<div class="col-xs-12 col-sm-5">
					<span class="block">
						<input id="compellation" type="text" name="compellation" value="<?php echo $_smarty_tpl->tpl_vars['data']->value->compellation;?>
" class="form-control input-width"  />
					</span>
				</div>
				<div class="help-block inline"></div>
			</div>

			<div class="form-group">
				<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('开户银行名称');?>
:</label>
				<div class="col-xs-12 col-sm-5">
					<span class="block">
						<input id="bank_name" type="text" name="bank_name" value="<?php echo $_smarty_tpl->tpl_vars['data']->value->bank_name;?>
" class="form-control input-width"  />
					</span>
				</div>
				<div class="help-block inline"></div>
			</div>

			<div class="form-group">
				<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('银行卡号');?>
:</label>
				<div class="col-xs-12 col-sm-5">
						<span class="block">
							<input id="bank_card" type="number" name="bank_card" value="<?php echo $_smarty_tpl->tpl_vars['data']->value->bank_card;?>
" class="form-control input-width"  />
						</span>
				</div>
				<div class="help-block inline"></div>
			</div>

			<div class="form-group">
				<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('备注描述');?>
:</label>
				<div class="col-xs-12 col-sm-5">
					<span class="block">
						<input id="desc" type="text" name="desc" value="<?php echo $_smarty_tpl->tpl_vars['data']->value->desc;?>
" class="form-control input-width"  />
					</span>
				</div>
				<div class="help-block inline"></div>
			</div>
     <!--<div class="form-group">
				<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('排序');?>
:</label>
				<div class="col-xs-12 col-sm-5">
					<span class="block">
						<input id="orderby" type="text" name="orderby" value="<?php echo $_smarty_tpl->tpl_vars['data']->value->orderby;?>
" class="form-control input-width"  />
					</span>
				</div>
				<div class="help-block inline"></div>
			</div>-->
            

   <!-- <div class="panel panel-info">
        <div class="panel-heading">
            商家资料
        </div>
    </div> -->


            
            <!--<div class="form-group">-->
				<!--<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right">客服电话:</label>-->
				<!--<div class="col-xs-12 col-sm-5">-->
					<!--<span class="block">-->
						<!--<input id="phone" type="text" name="phone" value="<?php echo $_smarty_tpl->tpl_vars['data']->value->phone;?>
" class="form-control input-width"  />-->
					<!--</span>-->
				<!--</div>-->
				<!--<div class="help-block inline"></div>-->
			<!--</div>-->
            
 <!--<div class="form-group">
		<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right">图片:</label>
        <textarea name="pictures" style="display:none"><?php echo $_smarty_tpl->tpl_vars['data']->value->pictures;?>
</textarea>
		<div class="col-xs-12 col-sm-5">
			<span class="block">
                <div class="pictures">
                <?php if ($_smarty_tpl->tpl_vars['data']->value->pictures) {?>
<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = explode("\n",str_replace("\r",'',$_smarty_tpl->tpl_vars['data']->value->pictures)); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
<div class="upfile_imgthumb">
<img src="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" data-default="/style/xin_inselimg.png" class="btn-prefile" data-multi="1">
<div class="upfile_imgcaption">
<a href="javascript:;" data-src="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" data-multi="1" class="btn btn-primary btn-xs btn-upfile">上传</a>
<a href="javascript:;" data-src="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" data-multi="1" class="btn btn-default btn-xs btn-upremove">删除</a>
</div>
</div>
                    <?php } ?>
                    <?php }?>
                </div>
                <a href="javascipt:;" class="btn btn-upfile btn-primary btn-sm" style="width:121px" data-multi="1" data-conr=".pictures">+ 上传图片</a>
			</span>
		</div>
		<div class="help-block inline"></div>
	</div>


		<div class="form-group">
				<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right">关键词:</label>
				<div class="col-xs-12 col-sm-5">
					<span class="block">
						<input id="keywords" type="text" name="keywords" value="<?php echo $_smarty_tpl->tpl_vars['data']->value->keywords;?>
" class="form-control input-width"  />
					</span>
				</div>
				<div class="help-block inline"></div>
			</div>-->
            
		<div class="form-group">
		<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('品牌介绍');?>
:</label>
		<div class="col-xs-12 col-sm-5">
			<span class="block">
				<script id="editor" type="text/plain" style="width:620px;height:300px;"></script>
				<textarea id="text" name="text" style="display:none"><?php echo $_smarty_tpl->tpl_vars['data']->value->text;?>
</textarea>
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

<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.3&key=<?php echo $_smarty_tpl->tpl_vars['geocoder_key']->value;?>
&plugin=AMap.Geocoder"></script>

<script>
$(function () {
    $("#recmdid,#user_id").select2({
		ajax: {
			url: "/admin_user/search",
			data: function (params) {
				return { 
					keywords: params,
					bindmobile: $.trim($(this).data('bindmobile'))
				};
			},
			results:function(data,pageNo){
				if(data.data.length)data['data'].splice(0, 0, {'id':0, 'text': "<?php echo translate('请选择');?>
"});
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
	<?php if ($_smarty_tpl->tpl_vars['data']->value->recmdid) {?>$('#recmdid').select2('data', {id:"<?php echo $_smarty_tpl->tpl_vars['data']->value->recmdid;?>
", text:"<?php echo $_smarty_tpl->tpl_vars['data']->value->recmdid_account;?>
"}).select2('val', ["<?php echo $_smarty_tpl->tpl_vars['data']->value->recmdid;?>
"]);<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['data']->value->user_id) {?>$('#user_id').select2('data', {id:"<?php echo $_smarty_tpl->tpl_vars['data']->value->user_id;?>
", text:"<?php echo $_smarty_tpl->tpl_vars['data']->value->userid_account;?>
"}).select2('val', ["<?php echo $_smarty_tpl->tpl_vars['data']->value->user_id;?>
"]);<?php }?>


    $("#corpid").select2({
		ajax: {
			url: "/admin_corp/search",
			data: function (params) {
				return { 
					keywords: params
				};
			},
			results:function(data,pageNo){
				if(data.data.length)data['data'].splice(0, 0, {'id':0, 'text': "<?php echo translate('请选择');?>
"});
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
	<?php if ($_smarty_tpl->tpl_vars['data']->value->corpid) {?>$('#corpid').select2('data', {id:"<?php echo $_smarty_tpl->tpl_vars['data']->value->corpid;?>
", text:"<?php echo $_smarty_tpl->tpl_vars['data']->value->corpid_account;?>
"}).select2('val', ["<?php echo $_smarty_tpl->tpl_vars['data']->value->corpid;?>
"]);<?php }?>

            $('.city_type').change(function(){
                var city_type=$("input[name='city_type']:checked").val();;
                $(".area1").hide();
                $(".area2").hide();
                if(city_type==2){
                    $(".area2").show();
				}else {
                    $(".area1").show();
                }
            });
            $('.city_type').change();


});
</script>                        
<script type="text/javascript">
	var limitpercen=100;
	function limittxt(id){
        if(id==0) return true;
        $.post('/admin_corp/get_percen', { 'id': id }, function(res){
            var percen='' ;
            percen="<span> "+"<?php echo translate('最大设置');?>
"+res.data+" %</span>";
            $("#limit-percen").html(percen).change();
            limitpercen=parseFloat(res.data);
            return true;
        }, 'json').error(function(){
            tooltipbox.show("<?php echo translate('数据或网络错误');?>
");
        });
    }
function amap_click(map, res){
	console.log(res);
	//map.clearMap();
	$("#lng").val(res.lnglat.lng);
	$("#lat").val(res.lnglat.lat);
}
    function  formatminutes(date) {
        var aa = $(".laydate-time-list li ol")[1];
        var showtime = $($(".laydate-time-list li ol")[1]).find("li");
        for (var i = 0; i < showtime.length; i++) {
            var t00 = showtime[i].innerText;
            if (t00 != "00" && t00 != "20" && t00 != "30" && t00 != "40" && t00 != "50") {
                showtime[i].remove()
            }
        }
        $($(".laydate-time-list li ol")[2]).find("li").remove();  //清空秒

    }

$(document).ready(function() {
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
    laydate.render({
        elem: '#hours1',
        type: 'time'
        ,format: 'HH:mm'
        ,btns: ['clear', 'confirm']
        ,ready: formatminutes

    });
    laydate.render({
        elem: '#hours',
        type: 'time'
        ,format: 'HH:mm'
        ,btns: ['clear', 'confirm']
        ,ready: formatminutes
    });
    $('#corpid').change(function () {
        var corpid= $("#corpid").val();//代理商id
        if(corpid) limittxt(corpid);
    });
    $('.btn-map').click(function(){
			var address = $('#area').val() + ' ' + $('#address').val().replace(/ /g, '');
			address = address.replace(/^\s/g, '').replace(' ', '省');
			address = address.replace(' ', '市');
			$(this).prev().dialogBox({
				title:"<?php echo translate('选择坐标');?>
",
				fixTop: -1 * $(window).height() * 0.2,
				autoSize:false,
				hasMask:false,
				hasClose:true,
				width:Math.min(800, $(window).width() * 0.9),
				height:Math.min(600, $(window).height() * 0.9),
				frameborder:'no',
				scrolling:'auto',
				content:'/app/third_party/ueditor1_4_3_3-utf8-php/dialogs/map/map.html?address=' + encodeURI(encodeURI(address)),
				framedisplay:'none',
				iframeload:function(_iframe){
					$('#dialog-box-iframe').show(300);
					$('.dialog-box').dragDiv();
					//setTimeout(function(){ tooltipbox.clear(); }, 5000);
				},
				close:function(){					
				},
			});
			return false;	
		});
		var ue = UE.getEditor('editor', { autoFloatEnabled:false });
		ue.ready(function(){
			ue.setContent($('#text').val(), false);
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
		$('#submitform').validate({
				errorElement : 'div',
				errorClass : 'help-block',
				focusInvalid : false,
				rules : {
				}
		});
		$('.check-adminname').click(function(){
			tooltipbox.show("<?php echo translate('正在执行操作');?>
");
			$.post('/admin_bguser/check', { 'id': "<?php echo $_smarty_tpl->tpl_vars['data']->value->id;?>
", 'adminname': $('#adminname').val() }, function(res){
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
				tooltipbox.show("<?php echo translate('没有权限');?>
");
			});
		});
		$("#saveedit").click(function() {
			 if ($('#submitform').valid()) {
			 	if($('#password').val()!=$('#repasswd').val())
			 	{
			 		alert("<?php echo translate('两次输入的密码不一致');?>
");
			 		return false;
			 	}
                 if($("#percen").val()>limitpercen){
                     tooltipbox.alert("<?php echo translate('分成比例不能超过最大设置比例');?>
"+limitpercen+"%");
                     return false;
                 }
                 if($('#hours').val() >$('#hours1').val()){
                     tooltipbox.alert("<?php echo translate('结束营业时间不能小于开始营业时间');?>
");
                     return false;
                 }


				//$('#text').val(ue.getContent());
				Dlc.service.post("/admin_shop/save_add/<?php echo $_smarty_tpl->tpl_vars['qs_pid']->value;?>
", $("#submitform").serialize());
				return false;
				//$('#submitform').submit();
			 }
		});
}); 
$('.btn-location').click(function(){
	if(!$('#area').val() || !$('#address').val()){
		tooltipbox.show("<?php echo translate('请先选择城市与填写详细地址');?>
");
		return false;
	}
    var map = new AMap.Map("container", {
        resizeEnable: true
    });
    var geocoder = new AMap.Geocoder({
            city: "", //城市，默认：“全国”
            radius: 500 //范围，默认：500
    });
	//地理编码
	geocoder.getLocation($('#area').val().replace(/ /g, '') + $('#address').val(), function(status, result) {
		if (status === 'complete' && result.info === 'OK') {
			//TODO:获得了有效经纬度，可以做一些展示工作
			//比如在获得的经纬度上打上一个Marker
			if(result.geocodes.length > 0){
				$('#lat').val(result.geocodes[0].location.lat);
				$('#lng').val(result.geocodes[0].location.lng);
			}
		}else{
			//获取经纬度失败
			tooltipbox.show("<?php echo translate('获取失败，请确认地址正确');?>
");
		}
		//alert($.toJSON(result));
	});
});
</script>
 <?php }} ?>
