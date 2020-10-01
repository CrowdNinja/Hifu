<?php /* Smarty version Smarty-3.1.19, created on 2020-05-24 12:22:59
         compiled from "C:\xampp\htdocs\beauty\app\views\device\list_device.html" */ ?>
<?php /*%%SmartyHeaderCode:1540063505eca4b0327aaa6-14914015%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9d08493585e33a45995737b215645a3ea9f4b6e8' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beauty\\app\\views\\device\\list_device.html',
      1 => 1590283766,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1540063505eca4b0327aaa6-14914015',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'get' => 0,
    'device_status' => 0,
    'k' => 0,
    'v' => 0,
    'device_type' => 0,
    'device_son_type' => 0,
    'get_corpid_account' => 0,
    'get_adminid_account' => 0,
    'device' => 0,
    'page' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5eca4b03310ae5_59456676',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5eca4b03310ae5_59456676')) {function content_5eca4b03310ae5_59456676($_smarty_tpl) {?>
<title><?php echo translate('设备管理');?>
 - <?php echo translate('设备列表');?>
</title>
<div class="page-header">
	<h1>
		<?php echo translate('设备管理');?>
 <small> <i class="ace-icon fa fa-angle-double-right"></i> <?php echo translate('设备列表');?>

	</small>
	</h1>
</div>
<!-- /.page-header -->

<script language='javascript' src="/style/assets/js/jquery.dialogBox.js"></script>
<link rel="stylesheet" href="/style/assets/js/jquery.dialogbox.css" />
<link rel="stylesheet" href="/style/common.css" />
<div class="row">
	<div class="col-xs-12">

		<ul class="nav nav-tabs">
			<li class=" <?php if (!$_smarty_tpl->tpl_vars['get']->value['type']) {?>active<?php }?>" ><a href="/admin_system#page/admin_device"><?php echo translate('设备列表');?>
</a></li>
			<li class=" <?php if ($_smarty_tpl->tpl_vars['get']->value['type']==1) {?> active <?php }?>" ><a href="/admin_system#page/admin_device?type=1"><?php echo translate('美容机');?>
</a></li>
			<li class="  <?php if ($_smarty_tpl->tpl_vars['get']->value['type']==2) {?> active <?php }?>" ><a href="/admin_system#page/admin_device?type=2"><?php echo translate('脱毛机');?>
</a></li>
		</ul>
		<br />



		<div class="panel panel-success">
			<div class="panel-heading" onclick="$(this).parent().find('.panel-body').toggle()"><i class="glyphicon glyphicon-chevron-down"></i> <?php echo translate('筛选');?>
</div>
			<div class="panel-body" style="display:">

				<div class="form-group form-search form-inline">
					<label class="control-label"><?php echo translate('设备号');?>
</label>
					<input class="form-control" name="keywords" id="keywords" type="text" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['keywords'];?>
" placeholder="">
					<label class="control-label"><?php echo translate('地址');?>
</label>
					<input class="form-control" name="address" id="address" type="text" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['address'];?>
" placeholder="">
					<label class="control-label"><?php echo translate('状态');?>
</label>
                    <select name="status" id="status" class="form-control">
                        <option value=""><?php echo translate('请选择');?>
</option>
                        <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['device_status']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                        <option value="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['get']->value['status']==strval($_smarty_tpl->tpl_vars['k']->value)) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</option>
                        <?php } ?>
                    </select>
					<label class="control-label"><?php echo translate('设备类型');?>
</label>
					<select name="type" id="type" class="form-control">
						<option value=""><?php echo translate('请选择');?>
</option>
						<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['device_type']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
						<option value="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['get']->value['type']==strval($_smarty_tpl->tpl_vars['k']->value)) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</option>
						<?php } ?>
					</select>
					<label class="control-label"><?php echo translate('设备子类型');?>
</label>
					<select name="device_son_type_id" id="device_son_type_id" class="form-control">
						<option value=""><?php echo translate('请选择');?>
</option>
						<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['device_son_type']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
						<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['get']->value['device_son_type_id']==strval($_smarty_tpl->tpl_vars['v']->value['id'])) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</option>
						<?php } ?>
					</select>
					<label class="control-label"><?php echo translate('选择代理商');?>
</label>
					<input id="corpid" name="corpid" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['corpid'];?>
" style="width:200px" />

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
            $(function(){
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
                                data['data'].splice(0, 0, {'id':'', 'text':"<?php echo translate('请选择');?>
" });
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

                        //这里处理搜索key，引用 /style/assets/js/jquery.fn.js
                        //注意php代码不需要处理搜索URL参数，分页URL的处理注意本页尾的JS代码
                        //$.searchURL = function(url = location.href, sConr = '.form-search', sObj = 'input,select,textarea', sJoin = ','){/**/}
                        $('.btn-default').click(function(){
                            var url = $.searchURL( location.href );
                            location.href = url;
                        });
                    });
		</script>

		<form class="form-horizontal" role="form" id="submitform" method="post" action="/admin_device/import" enctype="multipart/form-data">
			<table class="table table-bordered table-hover table-list">
				<thead>
				<tr>
					<th></th>
					<th><?php echo translate('代理商');?>
</th>
					<th><?php echo translate('商家');?>
</th>
					<th><?php echo translate('设备号');?>
</th>
					<th><?php echo translate('设备类型');?>
</th>
					<th><?php echo translate('在线状态');?>
</th>
					<th><?php echo translate('使用状态');?>
</th>
					<th><?php echo translate('设备地址');?>
</th>
					<th><?php echo translate('备注');?>
</th>
					<th><?php echo translate('心跳时间');?>
</th>
					<th><?php echo translate('上次离线时间');?>
</th>
					<th><?php echo translate('开机状态');?>
</th>
					<th><?php echo translate('错误码');?>
</th>
					<th><?php echo translate('已设置参数');?>
</th>
					<th><?php echo translate('操作');?>
</th>
				</tr>
				</thead>
				<tbody>
				<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['device']->value['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
				<tr class="alert1 success" align="left">
					<td><input type="checkbox" name="id[]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" /> <?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</td>
					<td><?php if ($_smarty_tpl->tpl_vars['v']->value['_corpid']) {?><b><?php echo $_smarty_tpl->tpl_vars['v']->value['_corpid'];?>
</b><?php } else { ?><span style="color:#999"><?php echo translate('没有代理商');?>
</span><?php }?></td>
					<td><?php if ($_smarty_tpl->tpl_vars['v']->value['_adminid']) {?><b><?php echo $_smarty_tpl->tpl_vars['v']->value['_adminid'];?>
</b><?php } else { ?><span style="color:#999"><?php echo translate('没有商家');?>
</span><?php }?></td>
					<td><?php echo $_smarty_tpl->tpl_vars['v']->value['macno'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['device_type']->value[$_smarty_tpl->tpl_vars['v']->value['type']];?>
- <?php echo $_smarty_tpl->tpl_vars['v']->value['device_son_type_name'];?>
 </td>
					<td><?php echo $_smarty_tpl->tpl_vars['v']->value['_status'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['device_status']->value[$_smarty_tpl->tpl_vars['v']->value['status']];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['v']->value['address'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['v']->value['remark'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['v']->value['beat_time'];?>
</td>
					<td style="color:red;"><?php echo $_smarty_tpl->tpl_vars['v']->value['off_line_time'];?>
</td>
					<td><?php if ($_smarty_tpl->tpl_vars['v']->value['isClosed']==1) {?> <?php echo translate('关机');?>
<?php } else { ?> <?php echo translate('开机');?>
<?php }?></td>
					<td><?php echo $_smarty_tpl->tpl_vars['v']->value['error'];?>
</td>
					<td>
						<?php echo translate('APN');?>
 :<?php echo $_smarty_tpl->tpl_vars['v']->value['apn'];?>
<br/>
						<?php echo translate('用户名');?>
 :<?php echo $_smarty_tpl->tpl_vars['v']->value['username'];?>
 <br/>
						<?php echo translate('密码');?>
 :<?php echo $_smarty_tpl->tpl_vars['v']->value['password'];?>

					</td>
					<td >
						<?php if (chkcommand('/admin_device/edit')) {?>
						<a href="admin_system#page/admin_device/edit/<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
/<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
" class="btn btn-success btn-xs"> <i class="fa fa-edit"></i> <?php echo translate('修改');?>
</a> |
						<?php }?>
					</td>
				</tr>
				<?php } ?>
				<tr style="position:fixed; bottom:0; width:100%; background:#fff;z-index:9">
					<td style="border:none" colspan="9"><input type="checkbox" id="checkall" onclick="var ck = this.checked;$(':checkbox').each(function(){this.checked = ck});">
						<?php if (chkcommand('/admin_device/delete')) {?>
						<input id="btnDelete" class="btn btn-lg btn-default" value="<?php echo translate('删除');?>
" type="button">
						<?php }?>
						<?php if (chkcommand('/admin_device/clear')) {?>
						<input id="btnClear" class="btn btn-lg btn-default" value="<?php echo translate('清空');?>
" type="button">
						<?php }?>

						<?php if (chkcommand('/admin_device/edit')) {?>
						<a href="/admin_system#page/admin_device/edit/0/<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
" class="btn btn-lg btn-primary">+ <?php echo translate('添加设备');?>
</a>
						<?php }?>
						<?php if (chkcommand('/admin_device/set_device')) {?>
						<a href="javascript:;" class="btn btn-lg btn-warning set_device">+ <?php echo translate('批量设置设备');?>
</a>
						<?php }?>
						<?php if (chkcommand('/admin_device/import')) {?>
						<a href="javascript:;" id="downloadExcel" class="btn btn-lg btn-purple"><i class="fa fa-download"></i><?php echo translate('下载导入摸板');?>
</a>
						<a href="javascript:;" id="import" class="btn btn-lg btn-info" style="cursor: pointer;" ><i class="fa fa-plus-circle"></i> <?php echo translate('批量导入设备');?>

							<input type="file" name="import" style="position:absolute;width:100%;height:100%;top:0;left:0;margin:0;padding:0;opacity:0;cursor: pointer;" >
						</a>
						<?php }?>
						<?php if (chkcommand('/admin_device/set_device_son_type')) {?>
						<a href="javascript:;" class="btn btn-lg btn-success set_device_son_type">+ <?php echo translate('批量设置设备子类型');?>
</a>
						<?php }?>
					</td>
				</tr>

				</tbody>
			</table>
			<table   style="width:100%;" class="listpage"><tr><td ><?php echo translate('共');?>
 <?php echo $_smarty_tpl->tpl_vars['device']->value['total'];?>
 <?php echo translate('条记录');?>
 <?php echo $_smarty_tpl->tpl_vars['device']->value['pages'];?>
  </td></tr></table>

		</form>
	</div>
</div>

<script type="text/javascript">
    var isbusy = false;
    //这里处理分页搜索key，引用 /style/assets/js/jquery.fn.js
    //注意php代码不需要处理搜索URL参数，分页URL的处理注意本页尾的JS代码
    //$.searchURL = function(url = location.href, sConr = '.form-search', sObj = 'input,select,textarea', sJoin = ','){/**/}
    function isPositiveInteger(s){//是否为正整数
        var re = /^[0-9]+$/ ;
        return re.test(s)
    }
    $(function(){
        $('.img-prefile').viewer('destroy').viewer({});
        $('.img-prefile').parent().off('click', '.viewer-canvas').on('click', '.viewer-canvas', function(e){
            var _con = $(this).find('img');
            if(_con && !_con.is(e.target) && _con.has(e.target).length === 0){
                $('.img-prefile').viewer('hide');
            }
        });
        $(".open_device").click(function () {
            var macno = $(this).data('macno');
            layer.prompt({title: '开启时长（分钟）', formType: 2}, function(text, index){
                if(!isPositiveInteger(text)){
                    tooltipbox.show("请输入正确时间");
                    return false
                }
                $.post("/admin_device/open",{minute:text,macno:macno},function(re){
                    layer.close(index);
                    if(re){
                        tooltipbox.show("<?php echo translate('操作执行成功');?>
");
                        location.reload();
                    }else{
                        tooltipbox.show('操作执行失败');
                        location.reload();
                    }
                });
            },'json');
        });
        //设置设备
        $('.set_device').click(function () {
            var ckvals = $.selectCK('input[name="id[]"]');
            if(!ckvals){
                tooltipbox.show("<?php echo translate('请选择要操作的数据');?>
");
                return false;
            }
            var url = 'admin_device/set_device/?ids='+ckvals;
            layer.open({
                type: 2,
                title: "<?php echo translate('设置设备参数');?>
",
                shadeClose: true, //不显示关闭按钮
                shade: 0.3,
                area: ['830px', '500px'],
                content: [url, 'no'], //iframe的url，no代表不显示滚动条
            });
        });
        //设置设备子类型
        $('.set_device_son_type').click(function () {
            var ckvals = $.selectCK('input[name="id[]"]');
            if(!ckvals){
                tooltipbox.show("<?php echo translate('请选择要操作的数据');?>
");
                return false;
            }
            var url = 'admin_device/set_device_son_type/?ids='+ckvals;
            layer.open({
                type: 2,
                title: "<?php echo translate('设置设备子类型');?>
",
                shadeClose: true, //不显示关闭按钮
                shade: 0.3,
                area: ['830px', '300px'],
                content: [url, 'no'], //iframe的url，no代表不显示滚动条
            });
        });
        $("#import").change(function(){
            $("#submitform").submit();
        });
        $('.listpage').find('a').each(function(){
            var url = $.replaceURL( location.href, 'page', $(this).attr('data-ci-pagination-page') );
            $(this).attr('href', url);
        });
        $('#downloadExcel').click(function(){
            $.download("./macno_import.xlsx");
            return false;
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
                $.post('/admin_device/delete', data, function(res){
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
                $.post('/admin_device/clear', { }, function(res){
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
        $('.btnDlQrcode').click(function(){
            var ckvals = $.selectCK('input[name="id[]"]');
            var type=$(this).data('type');
            if(!ckvals)ckvals = '';
            tooltipbox.loading("<?php echo translate('正在导出数据');?>
");
            var url = '/admin_device/dlqrcode';
            $.post(url, { 'ids': ckvals,'type':type }, function(res){
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
