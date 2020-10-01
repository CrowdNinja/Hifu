<?php /* Smarty version Smarty-3.1.19, created on 2020-05-29 03:58:19
         compiled from "C:\xampp\htdocs\beauty\app\views\trade\list_trade.html" */ ?>
<?php /*%%SmartyHeaderCode:2394866935ed06c3be3a2d9-90700548%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e8a4106406bfe790c6eecd386d7f09f576913221' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beauty\\app\\views\\trade\\list_trade.html',
      1 => 1590283745,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2394866935ed06c3be3a2d9-90700548',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'get' => 0,
    'trade_status' => 0,
    'k' => 0,
    'v' => 0,
    'trade_paytype' => 0,
    'get_userid_account' => 0,
    'get_user_recmdid_account' => 0,
    'get_admin_recmdid_account' => 0,
    'get_corpid_account' => 0,
    'get_adminid_account' => 0,
    'get_tradeid_tradeno' => 0,
    'trade' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5ed06c3bef1ab0_09469507',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ed06c3bef1ab0_09469507')) {function content_5ed06c3bef1ab0_09469507($_smarty_tpl) {?><title><?php echo translate('交易管理');?>
 - <?php echo translate('交易列表');?>
</title>
<div class="page-header">
	<h1>
		 <?php echo translate('交易管理');?>
<small> <i class="ace-icon fa fa-angle-double-right"></i>  <?php echo translate('交易列表');?>

		</small>
	</h1>
</div>
<!-- /.page-header -->


<div class="row">
	<div class="col-xs-12">
    
    <ul class="nav nav-tabs">
        <li class="active"><a href="/admin_system#page/admin_trade/"><?php echo translate('交易列表');?>
</a></li>
    </ul>
    <br />

    
     <div class="panel panel-success">
    <div class="panel-heading" onclick="$(this).parent().find('.panel-body').toggle()"><i class="glyphicon glyphicon-chevron-down"></i> <?php echo translate('筛选');?>
</div>
    <div class="panel-body" style="display:">

      
            <div class="form-group form-search form-inline">


               <label class="control-label"> <?php echo translate('订单号');?>
</label>
				<input id="tradeid" name="tradeid" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['tradeid'];?>
" style="width:200px" />

            
            <label class="control-label"><?php echo translate('选择代理商');?>
</label>
				<input id="corpid" name="corpid" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['corpid'];?>
" style="width:200px" />
                
              <label class="control-label"><?php echo translate('选择商家');?>
</label>
				<input id="adminid" name="adminid" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['adminid'];?>
" style="width:200px" />

              <label class="control-label"><?php echo translate('消费会员');?>
</label>
				<input id="userid" name="userid" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['userid'];?>
" style="width:200px" />

				<!--<br /><br />

              <label class="control-label">商家推荐人</label>
				<input id="admin_recmdid" name="admin_recmdid" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['admin_recmdid'];?>
" style="width:200px" />
                    
              <label class="control-label">会员推荐人</label>
				<input id="user_recmdid" name="user_recmdid" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['user_recmdid'];?>
" style="width:200px" />
				-->
                
                
               
				<label class="control-label"><?php echo translate('状态');?>
</label>
				<select name="status" id="status">
					<option value=""><?php echo translate('全部');?>
</option>
					<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['trade_status']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
					<option value="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['get']->value['status']==strval($_smarty_tpl->tpl_vars['k']->value)) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</option>
                    <?php } ?>
				</select>

				<label class="control-label"><?php echo translate('支付方式');?>
</label>
				<select name="paytype" id="paytype">
					<option value=""><?php echo translate('全部');?>
</option>
					<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['trade_paytype']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
					<option value="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['get']->value['paytype']==strval($_smarty_tpl->tpl_vars['k']->value)) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</option>
					<?php } ?>
				</select>
				<br/><br/>
                <label class="control-label"><?php echo translate('交易日期');?>
</label>
                    <input class="form-control " name="createtime1" id="createtime1" type="text" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['createtime1'];?>
" placeholder="">
                <label class="control-label"><?php echo translate('至');?>
</label>
                    <input class="form-control " name="createtime2" id="createtime2" type="text" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['createtime2'];?>
" placeholder="">
				
              
                    <button class="btn btn-default btn-sm"><i class="fa fa-search"></i> <?php echo translate('搜索');?>
</button>
                    <?php if (chkcommand('/admin_trade/export')) {?>
                    <button class="btn btn-success btn-export btn-sm"><i class="fa fa-export"></i> <?php echo translate('导出');?>
</button>
                    <?php }?>
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

        </script>
<script>
$(function () {
    //$("#userid,#user_recmdid,#admin_recmdid").select2({
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
	//<?php if ($_smarty_tpl->tpl_vars['get']->value['user_recmdid']) {?>$('#user_recmdid').select2('data', {id:"<?php echo $_smarty_tpl->tpl_vars['get']->value['user_recmdid'];?>
", text:"<?php echo $_smarty_tpl->tpl_vars['get_user_recmdid_account']->value;?>
"}).select2('val', ["<?php echo $_smarty_tpl->tpl_vars['get']->value['user_recmdid'];?>
"]);<?php }?>
	//<?php if ($_smarty_tpl->tpl_vars['get']->value['admin_recmdid']) {?>$('#admin_recmdid').select2('data', {id:"<?php echo $_smarty_tpl->tpl_vars['get']->value['admin_recmdid'];?>
", text:"<?php echo $_smarty_tpl->tpl_vars['get_admin_recmdid_account']->value;?>
"}).select2('val', ["<?php echo $_smarty_tpl->tpl_vars['get']->value['admin_recmdid'];?>
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
	<?php if ($_smarty_tpl->tpl_vars['get']->value['corpid']) {?>$('#corpid').select2('data', {id:"<?php echo $_smarty_tpl->tpl_vars['get']->value['corpid'];?>
", text:"<?php echo $_smarty_tpl->tpl_vars['get_corpid_account']->value;?>
"}).select2('val', ["<?php echo $_smarty_tpl->tpl_vars['get']->value['corpid'];?>
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
	<?php if ($_smarty_tpl->tpl_vars['get']->value['adminid']) {?>$('#adminid').select2('data', {id:"<?php echo $_smarty_tpl->tpl_vars['get']->value['adminid'];?>
", text:"<?php echo $_smarty_tpl->tpl_vars['get_adminid_account']->value;?>
"}).select2('val', ["<?php echo $_smarty_tpl->tpl_vars['get']->value['adminid'];?>
"]);<?php }?>
	
	
	$("#tradeid").select2({
		ajax: {
			url: "/admin_trade/search",
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
	<?php if ($_smarty_tpl->tpl_vars['get']->value['tradeid']) {?>$('#tradeid').select2('data', {id:"<?php echo $_smarty_tpl->tpl_vars['get']->value['tradeid'];?>
", text:"<?php echo $_smarty_tpl->tpl_vars['get_tradeid_tradeno']->value;?>
"}).select2('val', ["<?php echo $_smarty_tpl->tpl_vars['get']->value['tradeid'];?>
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
	$('.btn-export').click(function(){
		location.href = $.searchURL(location.href).replace('/admin_system#page/admin_trade', '/admin_trade/export');
	});	
});
</script>                 
				 
				<form class="form-horizontal" role="form" id="submitform">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th><?php echo translate('序号');?>
</th>
								<th><?php echo translate('交易号');?>
</th>
								<th><?php echo translate('代理名称');?>
</th>
								<th><?php echo translate('商家名称');?>
</th>
								<th><?php echo translate('消费会员');?>
</th>
								<th><?php echo translate('套餐信息');?>
</th>
								<th><?php echo translate('支付信息');?>
</th>
								<th><?php echo translate('交易状态');?>
</th>
								<th><?php echo translate('支付方式');?>
</th>
								<th><?php echo translate('创建时间');?>
</th>
								<th><?php echo translate('支付时间');?>
</th>
								<th><?php echo translate('操作');?>
</th>
								 
							</tr>
						</thead>
						<tbody>
							<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['trade']->value['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
							<tr class="alert1 success" align="left">
								<td><input type="checkbox" name="id[]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" /> <?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['tradeno'];?>
</td>
                                <td style="color:brown;"><?php echo $_smarty_tpl->tpl_vars['v']->value['agent_name'];?>
</td>
                                <td style="color:brown;"><?php echo $_smarty_tpl->tpl_vars['v']->value['_adminid'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['v']->value['_userid'];?>
</td>
                                <td >
									<?php echo translate('套餐名称');?>
：<b ><?php echo $_smarty_tpl->tpl_vars['v']->value['pack']['title'];?>
</b> <br />
									<?php echo translate('套餐金额');?>
：<b style="color:red;"><?php echo $_smarty_tpl->tpl_vars['v']->value['pack']['price'];?>
</b> <?php echo translate('元');?>
<br />
                                </td>
                                <td >
									<?php echo translate('订单金额');?>
：<b style="color:red;"><?php echo $_smarty_tpl->tpl_vars['v']->value['money'];?>
</b> <?php echo translate('元');?>
<br />
									<?php echo translate('优惠金额');?>
：<b style="color:red;"><?php echo $_smarty_tpl->tpl_vars['v']->value['discount'];?>
</b> <?php echo translate('元');?>
<br />
									<?php echo translate('实付金额');?>
：<b style="color:red;"><?php echo $_smarty_tpl->tpl_vars['v']->value['pay_money'];?>
</b> <?php echo translate('元');?>
<br />
                                </td>
                                <td><?php echo $_smarty_tpl->tpl_vars['trade_status']->value[$_smarty_tpl->tpl_vars['v']->value['status']];?>
</td>
                                <td><?php if ($_smarty_tpl->tpl_vars['v']->value['status']==0) {?><span style="color:#999;"><?php echo translate('未支付');?>
</span><?php } else { ?><?php echo $_smarty_tpl->tpl_vars['trade_paytype']->value[$_smarty_tpl->tpl_vars['v']->value['paytype']];?>
<?php }?></td>
                                <td ><?php echo $_smarty_tpl->tpl_vars['v']->value['ctime'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['v']->value['paytime'];?>
</td>
								<td >
                                 <?php if (chkcommand('/admin_trade/edit')) {?>
                                 <a href="admin_system#page/admin_trade/edit/<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
/<?php echo $_smarty_tpl->tpl_vars['get']->value['page'];?>
" class="btn btn-info btn-xs"> <i class="fa fa-eye"></i> <?php echo translate('详情');?>
</a>
                                 <?php }?>
									<?php if (chkcommand('/admin_trade/reservation')) {?>
									<a href="admin_system#page/admin_trade/reservation?trade_id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="btn btn-success btn-xs"> <i class="fa fa-eye"></i> <?php echo translate('预约信息');?>
</a>
									<?php }?>
                                </td>
							</tr>
							<?php } ?>
					<tr style="position:fixed; bottom:0; width:100%; background:#fff;z-index:9">
						<td style="border:none" colspan="12"><input type="checkbox" id="checkall" onclick="var ck = this.checked;$('input[name=&quot;id[]&quot;]').each(function(){this.checked = ck});">
							<?php if (chkcommand('/admin_trade/delete')) {?>
							<input id="btnDelete" class="btn btn-lg btn-default" value="<?php echo translate('删除');?>
" type="button">
                            <?php }?>
                            <!--<?php if (chkcommand('/admin_trade/clear')) {?>
							<input id="btnClear" class="btn btn-lg btn-default" value="清空" type="button"> 
                            <?php }?>
                            <?php if (chkcommand('/admin_trade/edit')) {?>
                            <a href="/admin_system#page/admin_trade/edit" class="btn btn-lg btn-primary">+ 添加交易</a>
                            <?php }?>-->
						</td>
					</tr>

						</tbody>
					</table>
                     <table   style="width:100%;" class="listpage"><tr><td ><?php echo translate('共');?>
 <?php echo $_smarty_tpl->tpl_vars['trade']->value['total'];?>
 <?php echo translate('条记录');?>
 <?php echo $_smarty_tpl->tpl_vars['trade']->value['pages'];?>
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
		$('#btnDelete').click(function(){
			var ckvals = $.selectCK('input[name="id[]"]');
			if(!ckvals){
				tooltipbox.show("<?php echo translate('请选择要操作的数据');?>
");
				return false;
			}
			tooltipbox.confirm("<?php echo translate('确定永久删除选中的数据');?>
？", function(data){
				tooltipbox.show("<?php echo translate('正在执行操作');?>
");
				$.post('/admin_trade/delete', data, function(res){
					if(res.status == '1'){
						tooltipbox.show("<?php echo translate('操作执行成功');?>
");
						location.reload();
					}else{
						tooltipbox.show("<?php echo translate('数据或网络错误');?>
");
					}
				}, 'json').error(function(){
					tooltipbox.show("<?php echo translate('数据或网络错误');?>
");
				});
			}, false, { 'ids': ckvals });
		});
		$('#btnClear').click(function(){
			tooltipbox.confirm('确定永久清空所有数据？', function(data){
				tooltipbox.show("<?php echo translate('正在执行操作');?>
");
				$.post('/admin_trade/clear', { }, function(res){
					if(res.status == '1'){
						tooltipbox.show("<?php echo translate('操作执行成功');?>
");
						location.reload();
					}else{
						tooltipbox.show("<?php echo translate('数据或网络错误');?>
");
					}
				}, 'json').error(function(a, b, c){
					tooltipbox.show("<?php echo translate('数据或网络错误');?>
");
				});
			});
		});
	});
</script>
 
 
<?php }} ?>
