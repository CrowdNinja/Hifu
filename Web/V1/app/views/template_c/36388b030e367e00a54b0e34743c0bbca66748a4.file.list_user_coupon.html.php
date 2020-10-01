<?php /* Smarty version Smarty-3.1.19, created on 2020-06-08 06:34:28
         compiled from "C:\xampp\htdocs\beauty-server\app\views\coupon\list_user_coupon.html" */ ?>
<?php /*%%SmartyHeaderCode:18342989845eddbfd43c1ff7-56797089%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '36388b030e367e00a54b0e34743c0bbca66748a4' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beauty-server\\app\\views\\coupon\\list_user_coupon.html',
      1 => 1591104997,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18342989845eddbfd43c1ff7-56797089',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'get' => 0,
    'get_userid_account' => 0,
    'get_adminid_account' => 0,
    'get_couponid_title' => 0,
    'coupon' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5eddbfd441ee46_30163517',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5eddbfd441ee46_30163517')) {function content_5eddbfd441ee46_30163517($_smarty_tpl) {?>
<title><?php echo translate('优惠券管理');?>
 - <?php echo translate('领取记录');?>
</title>
<div class="page-header">
	<h1>
		<?php echo translate('优惠券管理');?>
 <small> <i class="ace-icon fa fa-angle-double-right"></i> <?php echo translate('领取记录');?>

		</small>
	</h1>
</div>
<!-- /.page-header -->


<div class="row">
	<div class="col-xs-12">
    
    <ul class="nav nav-tabs">
        <li><a href="/admin_system#page/admin_coupon/"><?php echo translate('优惠券列表');?>
</a></li>
        <li><a href="/admin_system#page/admin_coupon/give"><?php echo translate('发放优惠券');?>
</a></li>
        <li class="active"><a href="/admin_system#page/admin_coupon/user_coupon"><?php echo translate('领取记录');?>
</a></li>
    </ul>
    <br />
    
     <div class="panel panel-success">
    <div class="panel-heading" onclick="$(this).parent().find('.panel-body').toggle()"><i class="glyphicon glyphicon-chevron-down"></i> <?php echo translate('筛选');?>
</div>
    <div class="panel-body" style="display:">

      
            <div class="form-group form-search form-inline">
              <!--<label class="control-label">选择商家</label>-->
				<!--<input id="adminid" name="adminid" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['adminid'];?>
" style="width:200px" />-->
                    
              <label class="control-label"><?php echo translate('领取会员');?>
</label>
				<input id="userid" name="userid" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['userid'];?>
" style="width:200px" />

				
              <label class="control-label"><?php echo translate('优惠券');?>
</label>
				<input id="couponid" name="couponid" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['couponid'];?>
" style="width:200px" />
				    <br><br>          


                <label class="control-label"><?php echo translate('领取日期');?>
</label>
                    <input class="form-control " name="createtime1" id="createtime1" type="text" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['createtime1'];?>
" placeholder="">
                <label class="control-label"><?php echo translate('至');?>
</label>
                    <input class="form-control " name="createtime2" id="createtime2" type="text" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['createtime2'];?>
" placeholder="">
				
                <br><br>
                <label class="control-label"><?php echo translate('使用日期');?>
</label>
                    <input class="form-control " name="usetime1" id="usetime1" type="text" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['usetime1'];?>
" placeholder="">
                <label class="control-label"><?php echo translate('至');?>
</label>
                    <input class="form-control " name="usetime2" id="usetime2" type="text" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['usetime2'];?>
" placeholder="">
              
                    <button class="btn btn-default btn-sm"><i class="fa fa-search"></i> <?php echo translate('搜索');?>
</button>
            </div>
       
    </div>
 
    </div>
		<script>
            laydate.render({
                elem: '#createtime1',
            });
            laydate.render({
                elem: '#createtime2'
            });
            laydate.render({
                elem: '#usetime1',
            });
            laydate.render({
                elem: '#usetime2'
            });

		</script>
		<script>
$(function () {
    $("#userid").select2({
		ajax: {
			url: "/admin_user/search",
			data: function (params) {
				return { 
					keywords: params
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
	<?php if ($_smarty_tpl->tpl_vars['get']->value['userid']) {?>$('#userid').select2('data', {id:"<?php echo $_smarty_tpl->tpl_vars['get']->value['userid'];?>
", text:"<?php echo $_smarty_tpl->tpl_vars['get_userid_account']->value;?>
"}).select2('val', ["<?php echo $_smarty_tpl->tpl_vars['get']->value['userid'];?>
"]);<?php }?>
    
	$("#adminid").select2({
		ajax: {
			url: "/admin_shop/search",
			data: function (params) {
				return { 
					keywords: params
				};
			},
			results:function(data,pageNo){
				if(data.data.length){
					data['data'].splice(0, 0, {'id':'0', 'text': "<?php echo translate('通用');?>
"});
					data['data'].splice(0, 0, {'id':'', 'text': "<?php echo translate('请选择');?>
"});
				}else{
					data['data'] = [{'id':'', 'text': "<?php echo translate('请选择');?>
"}, {'0':'', 'text': "<?php echo translate('通用');?>
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
	<?php if (is_numeric($_smarty_tpl->tpl_vars['get']->value['adminid'])) {?>$('#adminid').select2('data', {id:"<?php echo $_smarty_tpl->tpl_vars['get']->value['adminid'];?>
", text:"<?php echo $_smarty_tpl->tpl_vars['get_adminid_account']->value;?>
"}).select2('val', ["<?php echo $_smarty_tpl->tpl_vars['get']->value['adminid'];?>
"]);<?php }?>
	
    $("#couponid").select2({
		ajax: {
			url: "/admin_coupon/search",
			data: function (params) {
				return { 
					keywords: params
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
	<?php if ($_smarty_tpl->tpl_vars['get']->value['couponid']) {?>$('#couponid').select2('data', {id:"<?php echo $_smarty_tpl->tpl_vars['get']->value['couponid'];?>
", text:"<?php echo $_smarty_tpl->tpl_vars['get_couponid_title']->value;?>
"}).select2('val', ["<?php echo $_smarty_tpl->tpl_vars['get']->value['couponid'];?>
"]);<?php }?>
});
</script> 
				
<script>
$(function(){
	//这里处理搜索key，引用 /style/assets/js/jquery.fn.js
	//注意php代码不需要处理搜索URL参数，分页URL的处理注意本页尾的JS代码
	//$.searchURL = function(url = location.href, sConr = '.form-search', sObj = 'input,select,textarea', sJoin = ','){/**/}
	$('.btn-default').click(function(){
		var url = $.searchURL( location.href );
		location.href = url;
	});
});
</script>                 
				 
				 
				<form class="form-horizontal" role="form" id="submitform">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th></th>
								<th><?php echo translate('领取会员');?>
</th>
								<th><?php echo translate('发放商家');?>
</th>
								<th><?php echo translate('优惠券标题');?>
</th>
								<th><?php echo translate('优惠金额');?>
</th>
								<th><?php echo translate('领取时间');?>
</th>
								<th><?php echo translate('使用时间');?>
</th>
							</tr>
						</thead>
						<tbody>
							<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['coupon']->value['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
							<tr class="alert1 success" align="left">
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['user_account'];?>
</td>
								<td><?php if ($_smarty_tpl->tpl_vars['v']->value['adminid']!=1) {?><?php echo $_smarty_tpl->tpl_vars['v']->value['nickname'];?>
<?php } else { ?><span style="color:#999"><?php echo translate('通用');?>
</span><?php }?></td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['money'];?>
 <?php echo translate('元');?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['ctime'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['usetime'];?>
</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
                     <table   style="width:100%;" class="listpage"><tr><td ><?php echo translate('共');?>
 <?php echo $_smarty_tpl->tpl_vars['coupon']->value['total'];?>
 <?php echo translate('条记录');?>
 <?php echo $_smarty_tpl->tpl_vars['coupon']->value['pages'];?>
  </td></tr></table>
					
				</form>
                </div>
			</div>
		</div>

 
	<script type="text/javascript">
 	var isbusy = false;
	//这里处理分页搜索key，引用 /style/assets/js/jquery.fn.js
	//注意php代码不需要处理搜索URL参数，分页URL的处理注意本页尾的JS代码
	//$.searchURL = function(url = location.href, sConr = '.form-search', sObj = 'input,select,textarea', sJoin = ','){/**/}
	$(function(){
		$('.listpage').find('a').each(function(){
			var url = $.replaceURL( location.href, 'page', $(this).attr('data-ci-pagination-page') );
			$(this).attr('href', url);
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
	});
</script><?php }} ?>
