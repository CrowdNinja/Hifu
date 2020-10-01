<?php /* Smarty version Smarty-3.1.19, created on 2020-05-24 12:23:10
         compiled from "C:\xampp\htdocs\beauty\app\views\user\list_user.html" */ ?>
<?php /*%%SmartyHeaderCode:2353163225eca4b0e63f437-20471956%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '887d7fa20d2befd66719a90c2f46c56ebab194e1' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beauty\\app\\views\\user\\list_user.html',
      1 => 1590283750,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2353163225eca4b0e63f437-20471956',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'get' => 0,
    'user_status' => 0,
    'k' => 0,
    'v' => 0,
    'user_type' => 0,
    'get_userid_account' => 0,
    'user' => 0,
    'page' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5eca4b0e6ac257_34970829',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5eca4b0e6ac257_34970829')) {function content_5eca4b0e6ac257_34970829($_smarty_tpl) {?>
<title><?php echo translate('会员管理');?>
 - <?php echo translate('会员列表');?>
</title>
<div class="page-header">
	<h1>
		<?php echo translate('会员管理');?>
 <small> <i class="ace-icon fa fa-angle-double-right"></i> <?php echo translate('会员列表');?>

		</small>
	</h1>
</div>
<!-- /.page-header -->


<div class="row">
	<div class="col-xs-12">
    
    <ul class="nav nav-tabs">
        <li class="active"><a href="/admin_system#page/admin_user/"><?php echo translate('会员列表');?>
</a></li>
        <!--<li><a href="/admin_system#page/admin_cash/">提现列表</a></li>-->
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
 $_from = $_smarty_tpl->tpl_vars['user_status']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
					<option value="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['get']->value['status']==strval($_smarty_tpl->tpl_vars['k']->value)) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</option>
					<?php } ?>
				</select>
				<!--<label class="control-label">类型</label>
				<select name="type" id="type" class="form-control">
					<option value="">请选择</option>
					<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['user_type']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
					<option value="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['get']->value['type']==strval($_smarty_tpl->tpl_vars['k']->value)) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</option>
					<?php } ?>
				</select>-->
				<br /><br />
                <label class="control-label"><?php echo translate('注册日期');?>
</label>
				<input class="form-control  " name="createtime1" id="createtime1" type="text" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['createtime1'];?>
" placeholder="">
                <label class="control-label"><?php echo translate('至');?>
</label>
				<input class="form-control " name="createtime2" id="createtime2" type="text" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['createtime2'];?>
" placeholder="">

				<button class="btn btn-default btn-sm"><i class="fa fa-search"></i> <?php echo translate('搜索');?>
</button>
				<!--<?php if (chkcommand('/admin_user/export')) {?>
                    <button class="btn btn-success btn-export btn-sm"><i class="fa fa-export"></i> 导出</button>
                    <?php }?>-->
			</div>
       
    </div>
 
    </div>
		<script>
            laydate.render({
                elem: '#createtime1',
            });
            laydate.render({
                elem: '#createtime2',
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
	$('.btn-export').click(function(){
		location.href = $.searchURL(location.href).replace('/admin_system#page/admin_user', '/admin_user/export');
	});	
});
</script>                 
				 
				<form class="form-horizontal" role="form" id="submitform">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th><?php echo translate('ID');?>
</th>
								<th><?php echo translate('账号');?>
</th>
								<th><?php echo translate('昵称');?>
</th>
								<th><?php echo translate('头像');?>
</th>
								<th><?php echo translate('余额');?>
</th>
								<!--<th>用户类型</th>-->
								<th><?php echo translate('注册日期');?>
</th>
								<!--<th>最近登录</th>-->
								<th><?php echo translate('状态');?>
</th>
								<th><?php echo translate('操作');?>
</th>
							</tr>
						</thead>
						<tbody>
							<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['user']->value['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
							<tr class="alert1 success" align="left">
								<td><input type="checkbox" name="id[]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" /> <?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['account'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['nickname'];?>
</td>
								<td><img src="<?php echo $_smarty_tpl->tpl_vars['v']->value['avatar'];?>
" width="40px;" height="40px;" class="img-prefile" style="border-radius: 30px;" ></td>
                               <!-- <td><?php echo $_smarty_tpl->tpl_vars['v']->value['total_momey'];?>
</td>-->
                                 <td><?php echo $_smarty_tpl->tpl_vars['v']->value['money'];?>
 <?php echo translate('元');?>
</td>
                               <!--  <td><?php echo $_smarty_tpl->tpl_vars['user_type']->value[$_smarty_tpl->tpl_vars['v']->value['type']];?>
 </td>-->
								<td><?php echo formattime($_smarty_tpl->tpl_vars['v']->value['createtime']);?>
</td>
								<!--<td><?php echo formattime($_smarty_tpl->tpl_vars['v']->value['lasttime']);?>
</td>-->
								<td><?php echo $_smarty_tpl->tpl_vars['user_status']->value[$_smarty_tpl->tpl_vars['v']->value['status']];?>
</td>
								 <td >
                                 <?php if (chkcommand('/admin_user/edit')) {?>
                                 <a href="admin_system#page/admin_user/edit/<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="btn btn-success btn-xs"><i class="fa fa-edit"></i> <?php echo translate('修改');?>
</a>
                                 <?php }?>
                                 <!--<?php if (chkcommand('/admin_user/user_details')) {?>
								 <a href="admin_system#page/admin_user/user_details/<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
/<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
" class="btn btn-purple btn-xs"><i class="fa fa-money"></i> 消费明细</a>
								 <?php }?>-->
								 <?php if (chkcommand('/admin_trade')) {?>
                                 <a href="admin_system#page/admin_trade?userid=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> <?php echo translate('交易记录');?>
</a>
                                 <?php }?>
									 <?php if (chkcommand('/admin_user/user_address')) {?>
									 <a href="admin_system#page/admin_user/user_address/<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
/<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
" class="btn btn-xs btn-purple"><i class="fa fa-eye"></i> <?php echo translate('收货地址');?>
</a>
									 <?php }?>
								 <!--<?php if (chkcommand('/admin_cash')) {?>-->
                                 <!--<a href="admin_system#page/admin_cash/?userid=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">提现记录</a>-->
                                 <!--<?php }?>--></td>
							</tr>
							<?php } ?>
					<tr style="position:fixed; bottom:0; width:100%; background:#fff;z-index:9">
						<td style="border:none" colspan="12"><input type="checkbox" id="checkall" onclick="var ck = this.checked;$('input[name=&quot;id[]&quot;]').each(function(){this.checked = ck});">
							<?php if (chkcommand('/admin_user/delete')) {?>
							<input id="btnDelete" class="btn btn-lg btn-default" value="<?php echo translate('删除');?>
" type="button">
                            <?php }?>
                            <?php if (chkcommand('/admin_user/clear')) {?>
							<input id="btnClear" class="btn btn-lg btn-default" value="<?php echo translate('清空');?>
" type="button">
                            <?php }?>
                            <!--<?php if (chkcommand('/admin_user/edit')) {?>-->
                            <!--<a href="/admin_system#page/admin_user/edit" class="btn btn-lg btn-primary">+ 添加会员</a>-->
                            <!--<?php }?>-->
						</td>
					</tr>

						</tbody>
					</table>
                     <table   style="width:100%;" class="listpage"><tr><td ><?php echo translate('共');?>
 <?php echo $_smarty_tpl->tpl_vars['user']->value['total'];?>
 <?php echo translate('条记录');?>
 <?php echo $_smarty_tpl->tpl_vars['user']->value['pages'];?>
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
        $('.img-prefile').viewer('destroy').viewer({});
        $('.img-prefile').parent().off('click', '.viewer-canvas').on('click', '.viewer-canvas', function(e){
            var _con = $(this).find('img');
            if(_con && !_con.is(e.target) && _con.has(e.target).length === 0){
                $('.img-prefile').viewer('hide');
            }
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
				$.post('/admin_user/delete', data, function(res){
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
			tooltipbox.confirm("<?php echo translate('确定永久清空所有数据？');?>
", function(data){
				tooltipbox.show("<?php echo translate('正在执行操作');?>
");
				$.post('/admin_user/clear', { }, function(res){
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
		try{
			if((window.opener || window.parent).location.href.indexOf('admin_coupon/give') != -1 ||
				(window.opener || window.parent).location.href.indexOf('admin_corp/add') != -1 ||
                (window.opener || window.parent).location.href.indexOf('admin_user/send_message') != -1 ||
                (window.opener || window.parent).location.href.indexOf('admin_corp/edit') != -1)
				(window.opener || window.parent).iframeLoadNotify(window);
		}catch(e){}
	});
</script>
 
 
<?php }} ?>
