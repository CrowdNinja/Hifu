<?php /* Smarty version Smarty-3.1.19, created on 2020-06-04 16:22:57
         compiled from "C:\xampp\htdocs\beauty-server\app\views\bguser\list_shop_cash.html" */ ?>
<?php /*%%SmartyHeaderCode:4291802535ed903c1e972c8-61703005%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b5bae5394b84ebf0ac18122d98de8bc6a298b903' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beauty-server\\app\\views\\bguser\\list_shop_cash.html',
      1 => 1591104997,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4291802535ed903c1e972c8-61703005',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'get' => 0,
    'cash_status' => 0,
    'k' => 0,
    'v' => 0,
    'get_adminid_account' => 0,
    'cash' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5ed903c1f1a7f6_48715259',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ed903c1f1a7f6_48715259')) {function content_5ed903c1f1a7f6_48715259($_smarty_tpl) {?>
<title><?php echo translate('商家提现');?>
 - <?php echo translate('提现列表');?>
</title>
<div class="page-header">
	<h1>
		<?php echo translate('商家提现');?>
 <small> <i class="ace-icon fa fa-angle-double-right"></i> <?php echo translate('提现列表');?>

		</small>
	</h1>
</div>
<!-- /.page-header -->


<div class="row">
	<div class="col-xs-12">
    
    <ul class="nav nav-tabs">
        <li class="active"><a href="/admin_system#page/admin_cash/shop"><?php echo translate('商家提现');?>
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
                    
                    <label class="control-label"><?php echo translate('状态');?>
</label>
                   
               
                    <select name="status" id="status" class="form-control">
                 	<option value=""><?php echo translate('请选择');?>
</option>
               	<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['cash_status']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>                 
                		<option value="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['get']->value['status']==strval($_smarty_tpl->tpl_vars['k']->value)) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</option>
                	<?php } ?>
                    
                </select>   
                
                 <br /><br />
                <label class="control-label"><?php echo translate('申请日期');?>
</label>
                    <input class="form-control " name="createtime1" id="createtime1" type="text" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['createtime1'];?>
" placeholder="">
                <label class="control-label"><?php echo translate('至');?>
</label>
                    <input class="form-control " name="createtime2" id="createtime2" type="text" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['createtime2'];?>
" placeholder="">
                    
                 <br /><br />
                <label class="control-label"><?php echo translate('处理日期');?>
</label>
                    <input class="form-control " name="lasttime1" id="lasttime1" type="text" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['lasttime1'];?>
" placeholder="">
                <label class="control-label"><?php echo translate('至');?>
</label>
                    <input class="form-control " name="lasttime2" id="lasttime2" type="text" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['lasttime2'];?>
" placeholder="">
                
                    <button class="btn btn-default btn-sm"><i class="fa fa-search"></i> <?php echo translate('搜索');?>
</button>
                    <?php if (chkcommand('/admin_cash/shop_export')) {?>
                    <input id="btnExport" class="btn btn-primary btn-sm" value="<?php echo translate('导出');?>
" type="button">
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
            laydate.render({
                elem: '#lasttime1',
            });
            laydate.render({
                elem: '#lasttime2'
            });

		</script>
<script>
$(function(){
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
								<!--<th>提现编号</th>-->
								<th><?php echo translate('商家');?>
</th>
								<th><?php echo translate('金额');?>
</th>
								<th><?php echo translate('开户行');?>
</th>
								<th><?php echo translate('银行卡号');?>
</th>
								<th><?php echo translate('开户人姓名');?>
</th>
							<!--	<th>到账微信用户</th>-->
								<th><?php echo translate('状态');?>
</th>
								<th><?php echo translate('申请时间');?>
</th>
								<th><?php echo translate('处理时间');?>
</th>
								<th><?php echo translate('操作');?>
</th>
								 
							</tr>
						</thead>
						<tbody>
							<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cash']->value['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
							<tr class="alert1 success" align="left">
								<td><input type="checkbox" name="id[]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" /> <?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['adminid'];?>
, <?php echo $_smarty_tpl->tpl_vars['v']->value['account'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['money'];?>
 <?php echo translate('元');?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['bank_info']['bank_name'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['bank_info']['bank_card'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['bank_info']['name'];?>
</td>
							<!--	<td><?php echo $_smarty_tpl->tpl_vars['v']->value['nickname'];?>
</td>-->
								<td><?php echo $_smarty_tpl->tpl_vars['cash_status']->value[$_smarty_tpl->tpl_vars['v']->value['status']];?>
 <?php if ($_smarty_tpl->tpl_vars['v']->value['status']==2) {?><br/> <?php echo translate('拒绝原因');?>
：<?php echo $_smarty_tpl->tpl_vars['v']->value['fail'];?>
<?php }?></td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['createtime'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['lasttime'];?>
</td>
								<td>
									<?php if (chkcommand('/admin_cash/audit')) {?>
									<?php if ($_smarty_tpl->tpl_vars['v']->value['status']==0) {?>
									<a href="javascript:;" data-id="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" data-status="1" data-msg="<?php echo translate('确定通过审核？');?>
" class="btn btn-xs btn-success audit"><i class="fa fa-check"></i> <?php echo translate('通过');?>
</a>
									<a href="javascript:;" data-id="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" data-status="2" data-msg="<?php echo translate('确定拒绝审核？');?>
" class="btn btn-xs btn-danger reject"><i class="fa fa-times"></i> <?php echo translate('拒绝');?>
</a>
									<?php }?>
									<?php if ($_smarty_tpl->tpl_vars['v']->value['status']==1) {?>
									<a href="javascript:;" data-id="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" data-status="3"  data-msg="<?php echo translate('确定打款？');?>
" class="btn btn-xs btn-pink audit"><i class="fa fa-rmb"></i> <?php echo translate('打款');?>
</a>
									<?php }?>
									<?php }?>
								</td>
							</tr>
							<?php } ?>
					<tr style="position:fixed; bottom:0; width:100%; background:#fff;z-index:9">
						<td style="border:none" colspan="12"><input type="checkbox" id="checkall" onclick="var ck = this.checked;$('input[name=&quot;id[]&quot;]').each(function(){this.checked = ck});">
							<?php if (chkcommand('/admin_cash/shop_delete')) {?>
                            <input id="btnDelete" class="btn btn-lg btn-default" value="<?php echo translate('删除');?>
" type="button">
                            <?php }?>

						</td>
					</tr>

						</tbody>
					</table>
                     <table   style="width:100%;" class="listpage"><tr><td ><?php echo translate('共');?>
 <?php echo $_smarty_tpl->tpl_vars['cash']->value['total'];?>
 <?php echo translate('条记录');?>
 <?php echo $_smarty_tpl->tpl_vars['cash']->value['pages'];?>
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
        $(".reject").click(function () {
            var id = $(this).data('id');
            layer.prompt({title: "<?php echo translate('拒绝原因');?>
", formType: 2,content:'<div><textarea name="txt_remark" id="remark" style="width:200px;height:80px;" placeholder="<?php echo translate("拒绝原因");?>
"></textarea></div>',
                yes: function (index, layero) {
                    var reject_cause = $('#remark').val();
                    if (!reject_cause) {
                        tooltipbox.show("<?php echo translate('请输入拒绝原因');?>
");
                        return false
                    }
                    $.post("/admin_cash/audit", {reject_cause: reject_cause, id: id, status: 2}, function (re) {
                        if (re.status == 1) {
                            tooltipbox.show("<?php echo translate('操作执行成功');?>
");
                        } else {
                            tooltipbox.show("<?php echo translate('操作执行失败');?>
");
                        }
                        layer.close(index);
                        location.reload();
                    }, 'json');
                }
            });
        });
        $('.audit').click(function(){
            var id = $(this).data('id');
            var status = $(this).data('status');
            var msg=$(this).data('msg');

            tooltipbox.confirm(msg, function(data){
                tooltipbox.show("<?php echo translate('正在执行操作');?>
");
                $.post('/admin_cash/audit', data, function(res){
                    if(res.status == '1'){
                        tooltipbox.show("<?php echo translate('操作执行成功');?>
");
                        location.reload();
                    }else{
                        tooltipbox.show(res.msg);
                    }
                }, 'json').error(function(){
                    tooltipbox.show("<?php echo translate('数据或网络错误');?>
");
                });
            }, false, { 'id': id,'status':status });
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
				$.post('/admin_cash/shop_delete', data, function(res){
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
			tooltipbox.confirm("<?php echo translate('正在执行操作');?>
", function(data){
				tooltipbox.show("<?php echo translate('正在执行操作');?>
");
				$.post('/admin_cash/shop_clear', { }, function(res){
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
		$('#btnExport').click(function(){
			tooltipbox.show("<?php echo translate('正在执行操作');?>
");
			var ckvals = $.selectCK('input[name="id[]"]');
			var url = $.searchURL( '/admin_cash/shop_export' );
			$.post(url, { 'ids': ckvals ? ckvals : '' }, function(res){
				if(res.status == '1'){
					tooltipbox.show("<?php echo translate('正在下载文件');?>
");
					$.download(res.url);
				}else{
					tooltipbox.show("<?php echo translate('数据或网络错误');?>
");
				}
			}, 'json').error(function(){
				tooltipbox.show("<?php echo translate('数据或网络错误');?>
");
			});
			
			return false;
		});
	});
</script>
 
 
<?php }} ?>
