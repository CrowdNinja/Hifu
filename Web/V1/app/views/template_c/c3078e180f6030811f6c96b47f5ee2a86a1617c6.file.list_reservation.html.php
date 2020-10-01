<?php /* Smarty version Smarty-3.1.19, created on 2020-05-29 09:34:43
         compiled from "C:\xampp\htdocs\beauty\app\views\trade\list_reservation.html" */ ?>
<?php /*%%SmartyHeaderCode:7983751395ed0bb13ae7d56-13558478%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c3078e180f6030811f6c96b47f5ee2a86a1617c6' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beauty\\app\\views\\trade\\list_reservation.html',
      1 => 1590283746,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7983751395ed0bb13ae7d56-13558478',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'get' => 0,
    'get_adminid_account' => 0,
    'list' => 0,
    'v' => 0,
    'page' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5ed0bb13b3ec25_16620821',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ed0bb13b3ec25_16620821')) {function content_5ed0bb13b3ec25_16620821($_smarty_tpl) {?><title><?php echo translate('运营管理');?>
 - <?php echo translate('预约列表');?>
</title>
<div class="page-header">
	<h1>
		<?php echo translate('运营管理');?>
 <small> <i class="ace-icon fa fa-angle-double-right"></i> <?php echo translate('预约列表');?>

		</small>
	</h1>
</div>
<!-- /.page-header -->


<div class="row">
	<div class="col-xs-12">
    
    <ul class="nav nav-tabs">
        <li class="active"><a href="/admin_system#page/admin_trade/reservation"><?php echo translate('预约列表');?>
</a></li>
    </ul>
    <br />

    
     <div class="panel panel-success">
    <div class="panel-heading" onclick="$(this).parent().find('.panel-body').toggle()"><i class="glyphicon glyphicon-chevron-down"></i> <?php echo translate('筛选');?>
</div>
    <div class="panel-body" style="display:">

      
            <div class="form-group form-search form-inline">

              <label class="control-label"><?php echo translate('选择商家');?>
</label>
				<input id="adminid" name="adminid" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['adminid'];?>
" style="width:200px" />

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
								<th><?php echo translate('美容仪今日预约次数');?>
</th>
								<th><?php echo translate('脱毛机今日预约次数');?>
</th>
								<th><?php echo translate('美容仪预约详情');?>
</th>
								<th><?php echo translate('脱毛机预约详情');?>
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
								<td><input type="checkbox" name="id[]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['shop_id'];?>
" /> <?php echo $_smarty_tpl->tpl_vars['v']->value['shop_id'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['shop_name'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['mr_num'];?>
 <?php echo translate('次');?>
</td>
								<td ><?php echo $_smarty_tpl->tpl_vars['v']->value['tm_num'];?>
 <?php echo translate('次');?>
</td>
								<td >
									<?php if (chkcommand('/admin_trade/reservation_details')) {?>
									<a href="admin_system#page/admin_trade/reservation_details/<?php echo $_smarty_tpl->tpl_vars['v']->value['shop_id'];?>
/1/<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
" class="btn btn-info btn-xs"> <i class="fa fa-eye"></i> <?php echo translate('详情');?>
</a>
									<?php }?>
								</td>
								<td >
									<?php if (chkcommand('/admin_trade/reservation_details')) {?>
									<a href="admin_system#page/admin_trade/reservation_details/<?php echo $_smarty_tpl->tpl_vars['v']->value['shop_id'];?>
/2/<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
" class="btn btn-info btn-xs"> <i class="fa fa-eye"></i> <?php echo translate('详情');?>
</a>
									<?php }?>
								</td>
							</tr>
							<?php } ?>
					<!--<tr style="position:fixed; bottom:0; width:100%; background:#fff;z-index:9">
						<td style="border:none" colspan="12"><input type="checkbox" id="checkall" onclick="var ck = this.checked;$('input[name=&quot;id[]&quot;]').each(function(){this.checked = ck});">
							<?php if (chkcommand('/admin_trade/reservation_delete')) {?>
							<input id="btnDelete" class="btn btn-lg btn-default" value="删除" type="button">
                            <?php }?>
						</td>
					</tr>-->

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
