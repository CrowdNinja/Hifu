<?php /* Smarty version Smarty-3.1.19, created on 2020-06-08 09:33:03
         compiled from "C:\xampp\htdocs\beauty-server\app\views\coupon\edit_coupon.html" */ ?>
<?php /*%%SmartyHeaderCode:20404576995eddb3e2297e68-91842087%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '45cb9455181b5b8e99543a2e957f52d60f2aa068' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beauty-server\\app\\views\\coupon\\edit_coupon.html',
      1 => 1591592960,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20404576995eddb3e2297e68-91842087',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5eddb3e22ed793_93830128',
  'variables' => 
  array (
    'row' => 0,
    '_admin' => 0,
    'coupon_type' => 0,
    'k' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5eddb3e22ed793_93830128')) {function content_5eddb3e22ed793_93830128($_smarty_tpl) {?><title><?php echo translate('优惠券管理');?>
 - <?php if ($_smarty_tpl->tpl_vars['row']->value['id']) {?><?php echo translate('编辑');?>
<?php } else { ?><?php echo translate('添加');?>
<?php }?><?php echo translate('优惠券');?>
 </title>
<div class="page-header">
	<h1>
		<?php echo translate('优惠券管理');?>
 <small> <i class="ace-icon fa fa-angle-double-right"></i> <?php if ($_smarty_tpl->tpl_vars['row']->value['id']) {?><?php echo translate('编辑');?>
<?php } else { ?><?php echo translate('添加');?>
<?php }?><?php echo translate('优惠券');?>

		</small>
	</h1>
</div>
<!-- /.page-header -->
	<script>window.UEDITOR_HOME_URL = '/app/third_party/ueditor1_4_3_3-utf8-php/';</script>
    <script type="text/javascript" charset="utf-8" src="/app/third_party/ueditor1_4_3_3-utf8-php/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/app/third_party/ueditor1_4_3_3-utf8-php/ueditor.all.min.js"> </script>
    <script type="text/javascript" charset="utf-8" src="/app/third_party/ueditor1_4_3_3-utf8-php/lang/zh-cn/zh-cn.js"></script>
	<script type="text/plain" id="j_ueditorupload" style="height:5px;display:none;" ></script>
    <script type="text/javascript" charset="utf-8" src="/app/third_party/ueditor1_4_3_3-utf8-php/ueditor.upload.js"></script>

<div class="row">
	<div class="col-md-12">
<div class="main">
    <ul class="nav nav-tabs">
        <li><a href="/admin_system#page/admin_coupon/"><?php echo translate('优惠券列表');?>
</a></li>
        <li class="active"><a href="/admin_system#page/admin_coupon/edit/<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
"><?php if ($_smarty_tpl->tpl_vars['row']->value['id']) {?><?php echo translate('编辑');?>
<?php } else { ?><?php echo translate('添加');?>
<?php }?><?php echo translate('优惠券');?>
</a></li>
    </ul>

  <div class="panel panel-default">
        <div class="panel-body table-responsive">
        
        		<form class="form-horizontal" role="form" id="submitform" action="/admin_coupon/edit/<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
" method="post" accept-charset="utf-8">
					<?php if (!$_smarty_tpl->tpl_vars['row']->value['id']) {?>
					<div class="form-group">
						<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('商家');?>
:</label>
						<div class="col-xs-12 col-sm-4">
							<span class="block">
								<input id="adminid" name="adminid" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['adminid'];?>
" style="width:100%" />
							</span>
						</div>
						<div class="help-block inline"></div>
					</div>
<script>

$(function () {
    $("#adminid").select2({
		ajax: {
			url: "/admin_shop/search",
			data: function (params) {
				return { 
					keywords: params,
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

});
</script>    
			<?php } else { ?>
            	<input type="hidden" value="<?php if ($_smarty_tpl->tpl_vars['row']->value['adminid']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['adminid'];?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['_admin']->value->id;?>
<?php }?>" name="adminid" />
			<?php }?>
            
            <div class="form-group">
		<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('标题');?>
*:</label>
		<div class="col-xs-12 col-sm-4">
			<span class="block">
				<input id="title" name="title" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['title'];?>
" class="form-control input-width" required />
			</span>
		</div>
		<div class="help-block inline"></div>
	</div>
    
    	
        <!--<div class="form-group">-->
		<!--<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right">类型:</label>-->
		<!--<div class="col-xs-12 col-sm-5">-->
			<!--<span class="block">-->
            	<!--<select name="type" id="type" class="form-control">-->
               		<!--<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['coupon_type']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>                 -->
                		<!--<option value="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" <?php if (strval($_smarty_tpl->tpl_vars['row']->value['type'])==strval($_smarty_tpl->tpl_vars['k']->value)) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</option>-->
                	<!--<?php } ?>-->
                    <!---->
                <!--</select> -->
			<!--</span>-->
		<!--</div>-->
		<!--<div class="help-block inline"></div>-->
	<!--</div>-->


            
			<div class="form-group">
		<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('优惠金额');?>
*（<?php echo translate('元');?>
）:</label>
		<div class="col-xs-12 col-sm-4">
			<span class="block">
				<input id="money" type="text" name="money" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['money'];?>
" min="0" class="form-control input-width" required />
			</span>
		</div>
		<!--<div class="col-xs-12 col-sm-1">
			<span class="block">
            	<select name="percen" id="percen" class="form-control">
                		<option value="0" <?php if (strval($_smarty_tpl->tpl_vars['row']->value['percen'])==strval(0)) {?>selected<?php }?>>元</option>
                		<option value="1" <?php if (strval($_smarty_tpl->tpl_vars['row']->value['percen'])==strval(1)) {?>selected<?php }?>>%</option>
                </select> 
			</span>
		</div>-->
		<div class="help-block inline"></div>
	</div>

      
		<!--	<div class="form-group">
		<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right">领取押金:</label>
		<div class="col-xs-12 col-sm-5">
			<span class="block">
				<input id="foregift" type="text" name="foregift" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['foregift'];?>
" class="form-control input-width" disabled />
			</span>
		</div>
		<div class="help-block inline">* 不填写或0为免费领取</div>
	</div>-->
       
	<div class="form-group">
		<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('使用限额');?>
（<?php echo translate('元');?>
）:</label>
		<div class="col-xs-12 col-sm-4">
			<span class="block">
				<input id="limit_money" type="text" name="limit_money" min="0" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['limit_money'];?>
" class="form-control input-width" />
			</span>
		</div>
		<div class="help-block inline" style="color:red;">*<?php echo translate('满 ? 元才可用此券，填写0或留空不限制');?>
 </div>
	</div>
     
	<div class="form-group">
		<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('扫码可领次数');?>
:</label>
		<div class="col-xs-12 col-sm-4">
			<span class="block">
				<input id="amount" type="text" name="amount" min="0" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['amount'];?>
" class="form-control input-width"  />
			</span>
		</div>
		<div class="help-block inline" style="color:red;">* <?php echo translate('该值设置为0时不能扫描领取优惠券');?>
 </div>
	</div>
	<div class="form-group">
		<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('用户限领次数');?>
:</label>
		<div class="col-xs-12 col-sm-4">
			<span class="block">
				<input id="limit" type="text" name="limit" min="0" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['limit'];?>
" class="form-control input-width" />
			</span>
		</div>
		<div class="help-block inline" style="color:red;">* <?php echo translate('该值设置为0时不能扫描领取优惠券(用户扫码最大领取数量)');?>
</div>
	</div>
    
    <!--<div class="form-group">
		<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right">领取期限*:</label>
		<div class="col-xs-12 col-sm-2">
			<span class="block">
				<input id="getbegintime" type="text" name="getbegintime" value="<?php echo formattime($_smarty_tpl->tpl_vars['row']->value['getbegintime'],'Y-m-d','');?>
" class="form-control input-width datetimepicker-date" required />
			</span>
		</div>
		<div class="col-xs-12 col-sm-1">
			<span class="block">
				-
			</span>
		</div>
		<div class="col-xs-12 col-sm-2">
			<span class="block">
				<input id="getendtime" type="text" name="getendtime" value="<?php echo formattime($_smarty_tpl->tpl_vars['row']->value['getendtime'],'Y-m-d','');?>
" class="form-control input-width datetimepicker-date" required />
			</span>
		</div>
		<div class="help-block inline"></div>
	</div>-->
    
    <div class="form-group">
		<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('到期时间');?>
*:</label>
		<div class="col-xs-12 col-sm-4">
			<span class="block">
				<input id="end_time" type="text" name="end_time" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['end_time'];?>
" class="form-control input-width " required />
			</span>
		</div>
		<div class="help-block inline"></div>
	</div>
    
    
             
			<div class="form-group">
		<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('描述');?>
:</label>
		<div class="col-xs-12 col-sm-4">
			<span class="block">
				<textarea id="desc" name="desc" maxlength="20" class="form-control input-width"><?php echo $_smarty_tpl->tpl_vars['row']->value['desc'];?>
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
	</div>
    </div>
</div>
<script>
    laydate.render({
        elem: '#end_time',
    });

</script>
<script type="text/javascript">
var isbusy = false;
$(function(){
	// var ue = UE.getEditor('editor', { autoFloatEnabled:false });
	// ue.ready(function(){
	// 	ue.setContent($('#text').val(), false);
	// });
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
        pickTime: true,
        hourStep: 1,
        minuteStep: 15,
        secondStep: 30,
        inputMask: true
	});
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
	$('#saveedit').click(function(){
		if(!$('#submitform').valid())return false;
		if(isbusy)return false;
		isbusy = true;
		tooltipbox.show("<?php echo translate('正在执行操作');?>
");
		//$('#text').val(ue.getContent());
		$.post('/admin_coupon/edit/<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
', $('#submitform').serialize(), function(res){
			if(res.status == '1'){
				tooltipbox.show("<?php echo translate('操作完成');?>
");
				location.href = '/admin_system#page/admin_coupon/';
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
