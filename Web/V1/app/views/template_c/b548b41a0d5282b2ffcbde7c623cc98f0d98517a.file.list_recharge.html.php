<?php /* Smarty version Smarty-3.1.19, created on 2020-06-20 07:52:25
         compiled from "C:\xampp\htdocs\beauty-server\app\views\recharge\list_recharge.html" */ ?>
<?php /*%%SmartyHeaderCode:13174795395eeda41906fb32-82359520%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b548b41a0d5282b2ffcbde7c623cc98f0d98517a' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beauty-server\\app\\views\\recharge\\list_recharge.html',
      1 => 1591104997,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13174795395eeda41906fb32-82359520',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'get' => 0,
    'recharge_status' => 0,
    'k' => 0,
    'v' => 0,
    'recharge_paytype' => 0,
    'get_userid_account' => 0,
    'recharge' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5eeda4190c72c1_17333357',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5eeda4190c72c1_17333357')) {function content_5eeda4190c72c1_17333357($_smarty_tpl) {?>
<title><?php echo translate('充值管理');?>
 - <?php echo translate('充值列表');?>
</title>
<div class="page-header">
	<h1>
		<?php echo translate('充值管理');?>
 <small> <i class="ace-icon fa fa-angle-double-right"></i> <?php echo translate('充值列表');?>

		</small>
	</h1>
</div>
<!-- /.page-header -->


<div class="row">
	<div class="col-xs-12">
    
    <ul class="nav nav-tabs">
        <li class="active"><a href="/admin_system#page/admin_recharge/"><?php echo translate('充值列表');?>
</a></li>
        <!--<li><a href="/admin_system#page/admin_foregift/">押金列表</a></li>
        <li><a href="/admin_system#page/admin_cash/">提现列表</a></li>-->
    </ul>
    <br />
    
     <div class="panel panel-success">
    <div class="panel-heading" onclick="$(this).parent().find('.panel-body').toggle()"><i class="glyphicon glyphicon-chevron-down"></i> <?php echo translate('筛选');?>
</div>
    <div class="panel-body" style="display:">

      
            <div class="form-group form-search form-inline">
             
              <label class="control-label"><?php echo translate('选择会员');?>
</label>
                    <input id="userid" name="userid" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['userid'];?>
" style="width:200px" />

				<label class="control-label"><?php echo translate('状态');?>
</label>

				<select name="status" id="status" class="form-control">
					<option value=""><?php echo translate('请选择');?>
</option>
					<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['recharge_status']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
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

				<select name="paytype" id="paytype" class="form-control">
					<option value=""><?php echo translate('请选择');?>
</option>
					<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['recharge_paytype']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
					<option value="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['get']->value['paytype']==strval($_smarty_tpl->tpl_vars['k']->value)) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</option>
					<?php } ?>

				</select>
				<br /><br />
                <label class="control-label"><?php echo translate('充值日期');?>
</label>
                    <input class="form-control " name="createtime1" id="createtime1" type="text" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['createtime1'];?>
" placeholder="">
                <label class="control-label"><?php echo translate('至');?>
</label>
                    <input class="form-control " name="createtime2" id="createtime2" type="text" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['createtime2'];?>
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
								<th><?php echo translate('充值号');?>
</th>
								<th><?php echo translate('会员');?>
</th>
								<th><?php echo translate('金额');?>
</th>
								<th><?php echo translate('赠送');?>
</th>
								<th><?php echo translate('状态');?>
</th>
								<th><?php echo translate('支付方式');?>
</th>
								<th><?php echo translate('时间');?>
</th>
								<!--<th>操作</th>-->
								 
							</tr>
						</thead>
						<tbody>
							<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['recharge']->value['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
							<tr class="alert1 success" align="left">
								<td><input type="checkbox" name="id[]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" /> <?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['rechargeno'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['v']->value['_userid'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['money'];?>
 <?php echo translate('元');?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['redmoney'];?>
 <?php echo translate('元');?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['recharge_status']->value[$_smarty_tpl->tpl_vars['v']->value['status']];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['recharge_paytype']->value[$_smarty_tpl->tpl_vars['v']->value['paytype']];?>
</td>
								<td><?php echo formattime($_smarty_tpl->tpl_vars['v']->value['createtime']);?>
</td>
								<!--<td ><a href="admin_system#page/admin_recharge/edit/<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="btn btn-success btn-xs"><i class="fa fa-edit"></i> 修改</a></td>-->
							</tr>
							<?php } ?>
					<tr style="position:fixed; bottom:0; width:100%; background:#fff;z-index:9">
						<td style="border:none" colspan="12"><input type="checkbox" id="checkall" onclick="var ck = this.checked;$('input[name=&quot;id[]&quot;]').each(function(){this.checked = ck});">
						
							<input id="btnDelete" class="btn btn-lg btn-default" value="<?php echo translate('删除');?>
" type="button">
							<!--<input id="btnClear" class="btn btn-lg btn-default" value="清空" type="button"> -->
                            <!--<a href="/admin_system#page/admin_recharge/edit" class="btn btn-lg btn-primary">+ 添加充值</a>-->
						</td>
					</tr>

						</tbody>
					</table>
                     <table   style="width:100%;" class="listpage"><tr><td ><?php echo translate('共');?>
 <?php echo $_smarty_tpl->tpl_vars['recharge']->value['total'];?>
 <?php echo translate('条记录');?>
 <?php echo $_smarty_tpl->tpl_vars['recharge']->value['pages'];?>
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
				$.post('/admin_recharge/delete', data, function(res){
					if(res.status == '1'){
						tooltipbox.show("<?php echo translate('操作执行成功');?>
");
						location.reload();
					}else{
						tooltipbox.show('数据或网络错误');
					}
				}, 'json').error(function(){
					tooltipbox.show('数据或网络错误');
				});
			}, false, { 'ids': ckvals });
		});

	});
</script>
 
 
<?php }} ?>
