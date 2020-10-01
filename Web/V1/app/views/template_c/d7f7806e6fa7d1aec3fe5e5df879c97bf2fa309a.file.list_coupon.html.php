<?php /* Smarty version Smarty-3.1.19, created on 2020-06-08 05:37:23
         compiled from "C:\xampp\htdocs\beauty-server\app\views\coupon\list_coupon.html" */ ?>
<?php /*%%SmartyHeaderCode:2305792725eddb273df1478-10425500%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd7f7806e6fa7d1aec3fe5e5df879c97bf2fa309a' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beauty-server\\app\\views\\coupon\\list_coupon.html',
      1 => 1591104997,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2305792725eddb273df1478-10425500',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'get' => 0,
    'coupon' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5eddb273e594c7_38003040',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5eddb273e594c7_38003040')) {function content_5eddb273e594c7_38003040($_smarty_tpl) {?>
<title><?php echo translate('优惠券管理');?>
 - <?php echo translate('优惠券列表');?>
</title>
<div class="page-header">
	<h1>
		<?php echo translate('优惠券管理');?>
 <small> <i class="ace-icon fa fa-angle-double-right"></i> <?php echo translate('优惠券列表');?>

		</small>
	</h1>
</div>
<!-- /.page-header -->


<div class="row">
	<div class="col-xs-12">
    
    <ul class="nav nav-tabs">
        <li class="active"><a href="/admin_system#page/admin_coupon/"><?php echo translate('优惠券列表');?>
</a></li>
        <li><a href="/admin_system#page/admin_coupon/give"><?php echo translate('发放优惠券');?>
</a></li>
        <li><a href="/admin_system#page/admin_coupon/user_coupon"><?php echo translate('领取记录');?>
</a></li>
    </ul>
    <br />

    
     <div class="panel panel-success">
    <div class="panel-heading" onclick="$(this).parent().find('.panel-body').toggle()"><i class="glyphicon glyphicon-chevron-down"></i> <?php echo translate('筛选');?>
</div>
    <div class="panel-body" style="display:">

      
            <div class="form-group form-search form-inline">


				<label class="control-label"><?php echo translate('创建日期');?>
</label>
				<input class="form-control " name="createtime1" id="createtime1" type="text" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['createtime1'];?>
" placeholder="">
				<label class="control-label"><?php echo translate('至');?>
</label>
				<input class="form-control " name="createtime2" id="createtime2" type="text" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['createtime2'];?>
" placeholder="">
				<label class="control-label"><?php echo translate('标题');?>
</label>

				<input class="form-control" name="title" id="title" type="text" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['title'];?>
" placeholder="<?php echo translate('标题');?>
">
				<br/>
				<br/>
				<label class="control-label"><?php echo translate('到期日期');?>
</label>
				<input class="form-control " name="end_time1" id="end_time1" type="text" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['end_time1'];?>
" placeholder="">
				<label class="control-label"><?php echo translate('至');?>
</label>
				<input class="form-control " name="end_time2" id="end_time2" type="text" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['end_time2'];?>
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
                elem: '#end_time1',
            });
            laydate.render({
                elem: '#end_time2'
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
								<th> <?php echo translate('标题');?>
</th>
								<th> <?php echo translate('二维码');?>
</th>
								<th><?php echo translate('发放商家');?>
</th>
								<th><?php echo translate('优惠金额');?>
</th>
								<th><?php echo translate('使用限额');?>
</th>
                                <!--<th>领取押金</th>-->
								<th><?php echo translate('已发放数量');?>
</th>
								<th><?php echo translate('到期时间');?>
</th>
								<th><?php echo translate('创建时间');?>
</th>
								<th><?php echo translate('操作');?>
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
								<td><input type="checkbox" name="id[]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" /> <?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</td>
								<td>
									<img src="<?php echo $_smarty_tpl->tpl_vars['v']->value['qrcode'];?>
" width="25px" class="img-prefile" >
								</td>
								<td><?php if ($_smarty_tpl->tpl_vars['v']->value['adminid']!=1) {?><?php echo $_smarty_tpl->tpl_vars['v']->value['nickname'];?>
—<?php echo $_smarty_tpl->tpl_vars['v']->value['adminid'];?>
<?php } else { ?><span style="color:#999"><?php echo translate('通用');?>
</span><?php }?></td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['money'];?>
 <?php echo translate('元');?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['limit_money'];?>
 <?php echo translate('元');?>
</td>
                                <!--<td><?php echo $_smarty_tpl->tpl_vars['v']->value['foregift'];?>
</td>-->

								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['send_num'];?>
</td>
								<td> <?php echo $_smarty_tpl->tpl_vars['v']->value['end_time'];?>
</td>
								<td> <?php echo $_smarty_tpl->tpl_vars['v']->value['ctime'];?>
</td>
								 <td >
									 <?php if (chkcommand('/admin_coupon/edit')) {?><a href="admin_system#page/admin_coupon/edit/<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="btn btn-success btn-xs"> <i class=" fa fa-edit"></i><?php echo translate('修改');?>
</a><?php }?>
                                 |

                                 <?php if (chkcommand('/admin_coupon/give')) {?> <?php if ($_smarty_tpl->tpl_vars['v']->value['send']) {?><a href="admin_system#page/admin_coupon/give/?couponid=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="btn btn-purple btn-xs"> <i class="fa fa-send"></i><?php echo translate('发放');?>
</a><?php }?><?php }?>
                                 | 
                                 <?php if (chkcommand('/admin_coupon/user_coupon')) {?><a href="admin_system#page/admin_coupon/user_coupon?couponid=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="btn btn-primary btn-xs"> <i class="fa fa-list"></i><?php echo translate('领取记录');?>
</a><?php }?>
									 <?php if (chkcommand('/admin_coupon/set_send_status')) {?><?php if ($_smarty_tpl->tpl_vars['v']->value['is_send']==0) {?><a href="javascript:;" class="btn btn-warning btn-xs set_send_status" data-id="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" data-send="1">  <i class="fa fa-wrench"></i><?php echo translate('发放新用户优惠券');?>
</a><?php } else { ?><a href="javascript:;" class="btn btn-danger btn-xs set_send_status" data-id="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" data-send="0"> <i class="fa fa-times"></i><?php echo translate('取消新用户优惠券');?>
</a><?php }?><?php }?>
								 </td>
							</tr>
							<?php } ?>
					<tr style="position:fixed; bottom:0; width:100%; background:#fff;z-index:9">
						<td style="border:none" colspan="9"><input type="checkbox" id="checkall" onclick="var ck = this.checked;$(':checkbox').each(function(){this.checked = ck});">
						
                        	<?php if (chkcommand('/admin_coupon/delete')) {?>
							<input id="btnDelete" class="btn btn-lg btn-default" value="<?php echo translate('删除');?>
" type="button">
                            <?php }?>
                            <?php if (chkcommand('/admin_coupon/clear')) {?>
							<input id="btnClear" class="btn btn-lg btn-default" value="<?php echo translate('清空');?>
" type="button">
                            <?php }?>
                            <?php if (chkcommand('/admin_coupon/edit')) {?>
                            <a href="/admin_system#page/admin_coupon/edit" class="btn btn-lg btn-primary">+ <?php echo translate('添加优惠券');?>
</a>
                            <?php }?>
							<?php if (chkcommand('/admin_coupon/export')) {?>
							<a href="javascript:;" id="btnExport" class="btn  btn-purple btn-lg"><i class="fa fa-download"></i> <?php echo translate('下载二维码');?>
</a>
							<?php }?>
						</td>
					</tr>

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
        $('.set_send_status').click(function(){
            var id = $(this).data('id');
            var status = $(this).data('send');

            tooltipbox.confirm("<?php echo translate('确定操作？');?>
", function(data){
                tooltipbox.show("<?php echo translate('正在执行操作');?>
");
                $.post('/admin_coupon/set_send_status', data, function(res){
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
            }, false, { 'id': id,"status":status });
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
				$.post('/admin_coupon/delete', data, function(res){
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
				$.post('/admin_coupon/clear', { }, function(res){
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
        //下载优惠券二维码
        $('#btnExport').click(function(){
            var ckvals = $.selectCK('input[name="id[]"]');
            if(!ckvals){
                tooltipbox.show("<?php echo translate('请选择要操作的数据');?>
");
                return false;
            }
            tooltipbox.loading("<?php echo translate('正在导出数据');?>
");
            var url = '/admin_coupon/export';
            $.post(url, { 'ids': ckvals }, function(res){
                if(res.status == 1){
                    if(res.status == '1'){
                        tooltipbox.show("<?php echo translate('正在下载文件');?>
");
                        $.download(res.url);
                    }else{
                        tooltipbox.show("<?php echo translate('数据或网络错误');?>
");
                    }
                }else{
                    tooltipbox.show("<?php echo translate('数据或网络错误');?>
");
                }
            }, 'json').error(function(){
                tooltipbox.show("<?php echo translate('数据或网络错误');?>
");
            });
        });
	});
</script>
 
 
<?php }} ?>
