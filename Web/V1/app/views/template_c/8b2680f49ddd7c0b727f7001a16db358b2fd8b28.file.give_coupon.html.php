<?php /* Smarty version Smarty-3.1.19, created on 2020-06-08 06:34:24
         compiled from "C:\xampp\htdocs\beauty-server\app\views\coupon\give_coupon.html" */ ?>
<?php /*%%SmartyHeaderCode:6899251795eddbfd0d87424-44296645%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8b2680f49ddd7c0b727f7001a16db358b2fd8b28' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beauty-server\\app\\views\\coupon\\give_coupon.html',
      1 => 1591104997,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6899251795eddbfd0d87424-44296645',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'get' => 0,
    'get_couponid_title' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5eddbfd0dc58c0_16593684',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5eddbfd0dc58c0_16593684')) {function content_5eddbfd0dc58c0_16593684($_smarty_tpl) {?><title><?php echo translate('优惠券管理');?>
 - <?php echo translate('发放优惠券');?>
</title>
<div class="page-header">
	<h1>
		<?php echo translate('优惠券管理');?>
 <small> <i class="ace-icon fa fa-angle-double-right"></i> <?php echo translate('发放优惠券');?>

		</small>
	</h1>
</div>
<!-- /.page-header -->
<script language='javascript' src="/style/assets/js/jquery.dialogBox.js"></script>
<link rel="stylesheet" href="/style/assets/js/jquery.dialogbox.css" />
<script language='javascript' src="/style/assets/js/bootstrap-tag.min.js"></script>
<style>
.tags {width:100%;}
.tagcss {width:100%; min-height:34px;/* height:35px; overflow:hidden; padding:3px;*/}
</style>
<div class="row">
	<div class="col-md-12">
<div class="main">
    <ul class="nav nav-tabs">
        <li><a href="/admin_system#page/admin_coupon/"><?php echo translate('优惠券列表');?>
</a></li>
        <li class="active"><a href="/admin_system#page/admin_coupon/give"><?php echo translate('发放优惠券');?>
</a></li>
        <li><a href="/admin_system#page/admin_coupon/user_coupon"><?php echo translate('领取记录');?>
</a></li>
    </ul>
    <br />

  <div class="panel panel-default">
        <div class="panel-body table-responsive">
        
        		<form class="form-horizontal" role="form" id="submitform" enctype="multipart/form-data" action="/admin_coupon/give" method="post" accept-charset="utf-8">
			
          
           <div class="form-group">
		<label class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('选择优惠券');?>
:</label>
		<div class="col-xs-12 col-sm-5">
			<input type="text" id="couponid" name="couponid" value="{$get.couponid}" style="width:100%" />
		</div>		
		<div class="help-block inline"></div>
	</div>
       
    
    <div class="form-group">
		<label class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('选择会员');?>
:</label>
		<div class="col-xs-12 col-sm-4">
			<input type="text" name="touserids" class="form-control input-width" />
		</div>
		<div class="col-xs-12 col-sm-1">
            <div></div>
            <a href="javascript:;" class="dialogBox select-account btn  btn-primary btn-sm"><?php echo translate('选择');?>
</a>
		</div>
		<div class="help-block inline">* <?php echo translate('不选择为所有会员');?>
</div>
	</div>
    
    
    
<script>
$(function(){
	$("#couponid").select2({
		ajax: {
			url: "/admin_coupon/search",
			data: function (params) {
				return { 
					keywords: params
				};
			},
			results:function(data,pageNo){
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
	<?php if ($_smarty_tpl->tpl_vars['get']->value['couponid']) {?>$('#couponid').select2('data', {id:"<?php echo $_smarty_tpl->tpl_vars['get']->value['couponid'];?>
", text:"<?php echo $_smarty_tpl->tpl_vars['get_couponid_title']->value;?>
"}).select2('val', ["<?php echo $_smarty_tpl->tpl_vars['get']->value['couponid'];?>
"]);<?php }?>
});
</script>       
			 
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
var iframeWindow = null;
var xz="<?php echo translate('选择');?>
";
function iframeLoadNotify(_iframe){
	iframeWindow = _iframe;
	$('#dialog-box-iframe').show(300);
	$(iframeWindow.document).find('.navbar,.sidebar,.footer,.breadcrumbs,.page-header,.ace-settings-container,.nav-tabs').hide();
	$(iframeWindow.document).find('#submitform table:eq(0) tr:last .btn').hide();
	$(iframeWindow.document).find('#submitform table:eq(0) tr:not(:last)').find('th:last,td:last').hide();
	var selectBtn = $('<a href="javascript:;" class="btn btn-primary"> +'+ xz+ '</a>');
	selectBtn.appendTo($(iframeWindow.document).find('#submitform table:eq(0) tr:last td').eq(0));
	selectBtn.click(function(){
		var ckvals = iframeWindow.$.selectCK('input[name="id[]"]');
		if(!ckvals){
			tooltipbox.show("<?php echo translate('请选择要操作的数据');?>
");
			return false;
		}
		ckvals = ckvals.split(',');
		for(var i in ckvals){
			var title = ckvals[i];
			title = $(iframeWindow.document).find('#submitform table:eq(0) input[name="id[]"][value="' + ckvals[i] + '"]').parent().next().text();
			$('input[name=touserids]').data('tag').add(ckvals[i], title);
		}
		$('.dialog-box-close').click();
		tooltipbox.show("<?php echo translate('已完成选择所选数据');?>
");
	});
	tooltipbox.clear();
}
$('.dialogBox').click(function(){
	tooltipbox.show("<?php echo translate('加载中');?>
", null, 999999999);
	$(this).prev().dialogBox({
		title:"<?php echo translate('选择');?>
",
		fixTop: -1 * $(window).height() * 0.2,
		autoSize:false,
		hasMask:true,
		hasClose:true,
		width:Math.min(1000, $(window).width() * 0.9),
		height:Math.min(1200, $(window).height() * 0.9),
		frameborder:'no',
		scrolling:'auto',
		content:'/admin_system#page/admin_user',
		framedisplay:'none',
		iframeload:function(_iframe){
			//setTimeout(function(){ tooltipbox.clear(); }, 5000);
		},
		close:function(){
			//恢复
			$(iframeWindow.document).find('.navbar,.sidebar,.footer,.breadcrumbs,.page-header,.ace-settings-container,.nav-tabs').show();
			$(iframeWindow.document).find('#submitform table:eq(0) tr:last .btn').show();
			$(iframeWindow.document).find('#submitform table:eq(0) tr:not(:last)').find('th:last,td:last').show();
			$(iframeWindow.document).find('#submitform table:eq(0) tr:last td').eq(0).find('a:last').remove();
			tooltipbox.clear();
		},
	});
	return false;
});

var isbusy = false;
$(function(){	
	$('input[name=touserids]').tag({
		'tagcss': 'tagcss'
	});
	$('.tagcss input').hide();//不允许录入
	
	$('#submitform').validate({
			errorElement: 'div',
			errorClass: 'help-block',
			focusInvalid: true,
			rules: {
				//title: {
					//required: true
				//}
			}
	});
	$('#saveedit').click(function(){
		if(!$('#submitform').valid())return false;
		if(isbusy)return false;
		isbusy = true;
		tooltipbox.show("<?php echo translate('正在执行操作');?>
", null, 999999999);
        $.post("/admin_coupon/give", $('#submitform').serialize(), function(res){
			if(res.status == '1'){
				tooltipbox.show(res.msg ? res.msg : "<?php echo translate('操作完成');?>
");
				location.href = '/admin_system#page/admin_coupon/user_coupon';
			}else{
				tooltipbox.show(res.msg ? res.msg : "<?php echo translate('数据或网络错误');?>
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
