<?php /* Smarty version Smarty-3.1.19, created on 2020-06-12 07:54:20
         compiled from "C:\xampp\htdocs\beauty-server\app\views\trade\list_reservation_details.html" */ ?>
<?php /*%%SmartyHeaderCode:2172333975ee3188cb8ee47-40392434%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0cdbc283dd5affe455aa34748269d0e95f1fed94' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beauty-server\\app\\views\\trade\\list_reservation_details.html',
      1 => 1591104997,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2172333975ee3188cb8ee47-40392434',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'p' => 0,
    'shop_id' => 0,
    'type' => 0,
    'get' => 0,
    'get_userid_account' => 0,
    'get_user_recmdid_account' => 0,
    'get_admin_recmdid_account' => 0,
    'get_adminid_account' => 0,
    'get_tradeid_tradeno' => 0,
    'list' => 0,
    'v' => 0,
    'vv' => 0,
    'reservation_status' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5ee3188cbf87e0_03041094',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ee3188cbf87e0_03041094')) {function content_5ee3188cbf87e0_03041094($_smarty_tpl) {?><title><?php echo translate('运营管理');?>
 - <?php echo translate('预约详情列表');?>
</title>
<div class="page-header">
	<h1>
		<?php echo translate('运营管理');?>
 <small> <i class="ace-icon fa fa-angle-double-right"></i> <?php echo translate('预约详情列表');?>

		</small>
	</h1>
</div>
<!-- /.page-header -->


<div class="row">
	<div class="col-xs-12">
    
    <ul class="nav nav-tabs">
		<li ><a href="/admin_system#page/admin_trade/reservation?page=<?php echo $_smarty_tpl->tpl_vars['p']->value;?>
"><?php echo translate('预约列表');?>
</a></li>
        <li class="active"><a href="/admin_system#page/admin_trade/reservation_details/<?php echo $_smarty_tpl->tpl_vars['shop_id']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['p']->value;?>
"><?php echo translate('预约详情列表');?>
</a></li>
    </ul>
    <br />

    
     <div class="panel panel-success">
    <div class="panel-heading" onclick="$(this).parent().find('.panel-body').toggle()"><i class="glyphicon glyphicon-chevron-down"></i> <?php echo translate('筛选');?>
</div>
    <div class="panel-body" style="display:">

      
            <div class="form-group form-search form-inline">


               <label class="control-label"><?php echo translate('订单号');?>
</label>
				<input id="tradeid" name="tradeid" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['tradeid'];?>
" style="width:200px" />

              <label class="control-label"><?php echo translate('选择商家');?>
</label>
				<input id="adminid" name="adminid" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['adminid'];?>
" style="width:200px" />
                    

              <label class="control-label"><?php echo translate('消费会员');?>
</label>
				<input id="user_id" name="user_id" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['user_id'];?>
" style="width:200px" />


                <label class="control-label"><?php echo translate('预约日期');?>
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
    //$("#userid,#user_recmdid,#admin_recmdid").select2({
    $("#user_id").select2({
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
	<?php if ($_smarty_tpl->tpl_vars['get']->value['user_id']) {?>$('#user_id').select2('data', {id:"<?php echo $_smarty_tpl->tpl_vars['get']->value['user_id'];?>
", text:"<?php echo $_smarty_tpl->tpl_vars['get_userid_account']->value;?>
"}).select2('val', ["<?php echo $_smarty_tpl->tpl_vars['get']->value['user_id'];?>
"]);<?php }?>
	//<?php if ($_smarty_tpl->tpl_vars['get']->value['user_recmdid']) {?>$('#user_recmdid').select2('data', {id:"<?php echo $_smarty_tpl->tpl_vars['get']->value['user_recmdid'];?>
", text:"<?php echo $_smarty_tpl->tpl_vars['get_user_recmdid_account']->value;?>
"}).select2('val', ["<?php echo $_smarty_tpl->tpl_vars['get']->value['user_recmdid'];?>
"]);<?php }?>
	//<?php if ($_smarty_tpl->tpl_vars['get']->value['admin_recmdid']) {?>$('#admin_recmdid').select2('data', {id:"<?php echo $_smarty_tpl->tpl_vars['get']->value['admin_recmdid'];?>
", text:"<?php echo $_smarty_tpl->tpl_vars['get_admin_recmdid_account']->value;?>
"}).select2('val', ["<?php echo $_smarty_tpl->tpl_vars['get']->value['admin_recmdid'];?>
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

});
</script>                 
				 
				<form class="form-horizontal" role="form" id="submitform">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th><?php echo translate('序号');?>
</th>
								<th><?php echo translate('商家名称');?>
</th>
								<th><?php echo translate('订单号');?>
</th>
								<th><?php echo translate('预约会员');?>
</th>
								<th><?php echo translate('联系电话');?>
</th>
								<th><?php echo translate('预约套餐信息');?>
</th>
								<th><?php echo translate('预约时间');?>
</th>
								<th><?php echo translate('状态');?>
</th>
								<th><?php echo translate('操作');?>
</th>
							</tr>
						</thead>
						<tbody>
							<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
							<tr class="alert1 success" align="left">
								<td><input type="checkbox" name="id[]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" /> <?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</td>
                                <td ><?php echo $_smarty_tpl->tpl_vars['v']->value['shop_name'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['trade']['tradeno'];?>
</td>
								<td> <img src="<?php echo $_smarty_tpl->tpl_vars['v']->value['user']['avatar'];?>
" alt=""  style="border-radius: 30px;" width="30" height="30" class="img-prefile"/> <?php echo $_smarty_tpl->tpl_vars['v']->value['user']['nickname'];?>
 <?php echo $_smarty_tpl->tpl_vars['v']->value['user']['account'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['phone'];?>
</td>
								<td>
									<?php  $_smarty_tpl->tpl_vars['vv'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vv']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['v']->value['item_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vv']->key => $_smarty_tpl->tpl_vars['vv']->value) {
$_smarty_tpl->tpl_vars['vv']->_loop = true;
?>
									<span style="color:#99999c;"><?php echo translate('套餐项目名称');?>
：</span> <b><?php echo $_smarty_tpl->tpl_vars['vv']->value['title'];?>
</b>   <span style="color:#99999c;"><?php echo translate('消费状态');?>
</span>：<b><?php echo $_smarty_tpl->tpl_vars['vv']->value['status'];?>
</b>  <span style="color:#99999c;"><?php echo translate('二维码');?>
</span>：<img src="<?php echo $_smarty_tpl->tpl_vars['vv']->value['qr'];?>
" width="25" alt="" height="25" class="img-prefile"> <br/>

									<?php } ?>
								</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['start_time'];?>
</td>

                                <td><?php echo $_smarty_tpl->tpl_vars['reservation_status']->value[$_smarty_tpl->tpl_vars['v']->value['status']];?>
</td>
								<td >
                                <!-- <?php if (chkcommand('/admin_trade/reservation_edit')) {?>
                                 <a href="admin_system#page/admin_trade/reservation_edit/<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="btn btn-info btn-xs"> <i class="fa fa-eye"></i> 详情</a>
                                 <?php }?>-->
									<?php if (chkcommand('/admin_trade/cancel_reservation')) {?>
									<?php if ($_smarty_tpl->tpl_vars['v']->value['status']==0) {?>
									<a href="javascript:;" data-id="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="btn btn-danger btn-xs cancel_reservation"> <i class="fa fa-times"></i> <?php echo translate('取消');?>
</a>
									<?php }?>
									<?php }?>
                                </td>
							</tr>
							<?php } ?>
					<tr style="position:fixed; bottom:0; width:100%; background:#fff;z-index:9">
						<td style="border:none" colspan="12"><input type="checkbox" id="checkall" onclick="var ck = this.checked;$('input[name=&quot;id[]&quot;]').each(function(){this.checked = ck});">
							<?php if (chkcommand('/admin_trade/reservation_delete')) {?>
							<input id="btnDelete" class="btn btn-lg btn-default" value="<?php echo translate('删除');?>
" type="button">
                            <?php }?>
						</td>
					</tr>

						</tbody>
					</table>
                     <table   style="width:100%;" class="listpage"><tr><td ><?php echo translate('共');?>
 <?php echo $_smarty_tpl->tpl_vars['list']->value['total'];?>
 <?php echo translate('条记录');?>
 <?php echo $_smarty_tpl->tpl_vars['list']->value['pages'];?>
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
        $('.img-prefile').viewer('destroy').viewer({});
        $('.img-prefile').parent().off('click', '.viewer-canvas').on('click', '.viewer-canvas', function(e){
            var _con = $(this).find('img');
            if(_con && !_con.is(e.target) && _con.has(e.target).length === 0){
                $('.img-prefile').viewer('hide');
            }
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
        $('.cancel_reservation').click(function(){
            var id = $(this).data('id');

            tooltipbox.confirm("<?php echo translate('确定要取消？');?>
", function(data){
                tooltipbox.show("<?php echo translate('正在执行操作');?>
");
                $.post('/admin_trade/cancel_reservation', data, function(res){
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
            }, false, { 'id': id });
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
				$.post('/admin_trade/reservation_delete', data, function(res){
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

	});
</script>
 
 
<?php }} ?>
