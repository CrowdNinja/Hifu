<?php /* Smarty version Smarty-3.1.19, created on 2020-05-29 03:58:15
         compiled from "C:\xampp\htdocs\beauty\app\views\device\device_son_type.html" */ ?>
<?php /*%%SmartyHeaderCode:19351582305ed06c370988d4-47797197%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4137810c6f98c4cca7ca7062e5b5d0b9f46ae559' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beauty\\app\\views\\device\\device_son_type.html',
      1 => 1590283767,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19351582305ed06c370988d4-47797197',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'get' => 0,
    'get_corpid_account' => 0,
    'get_adminid_account' => 0,
    'list' => 0,
    'v' => 0,
    'page' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5ed06c37167a46_34898120',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ed06c37167a46_34898120')) {function content_5ed06c37167a46_34898120($_smarty_tpl) {?>
<title><?php echo translate('设备管理');?>
 - <?php echo translate('设备子类型列表');?>
</title>
<div class="page-header">
	<h1>
		<?php echo translate('设备管理');?>
 <small> <i class="ace-icon fa fa-angle-double-right"></i> <?php echo translate('设备子类型列表');?>

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
			<li class=" active" ><a href="javascript:;"><?php echo translate('设备子类型列表');?>
</a></li>

		</ul>
		<br />



		<div class="panel panel-success">
			<div class="panel-heading" onclick="$(this).parent().find('.panel-body').toggle()"><i class="glyphicon glyphicon-chevron-down"></i> <?php echo translate('筛选');?>
</div>
			<div class="panel-body" style="display:">

				<div class="form-group form-search form-inline">
					<label class="control-label"><?php echo translate('名称');?>
</label>
					<input class="form-control" name="name" id="name" type="text" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['name'];?>
" placeholder="">

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
					<th><?php echo translate('日文名');?>
</th>
					<th><?php echo translate('中文名');?>
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
					<td><?php echo $_smarty_tpl->tpl_vars['v']->value['japanese_name'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['v']->value['chinese_name'];?>
</td>
					<td >
						<?php if (chkcommand('/admin_device/edit_device_son_type')) {?>
						<a href="admin_system#page/admin_device/edit_device_son_type/<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
/" class="btn btn-success btn-xs"> <i class="fa fa-edit"></i> <?php echo translate('修改');?>
</a> |
						<?php }?>
					</td>
				</tr>
				<?php } ?>
				<tr style="position:fixed; bottom:0; width:100%; background:#fff;z-index:9">
					<td style="border:none" colspan="9"><input type="checkbox" id="checkall" onclick="var ck = this.checked;$(':checkbox').each(function(){this.checked = ck});">
						<?php if (chkcommand('/admin_device/delete_device_son_type')) {?>
						<input id="btnDelete" class="btn btn-lg btn-default" value="<?php echo translate('删除');?>
" type="button">
						<?php }?>

						<?php if (chkcommand('/admin_device/edit_device_son_type')) {?>
						<a href="/admin_system#page/admin_device/edit_device_son_type/0/<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
" class="btn btn-lg btn-primary">+ <?php echo translate('添加类型');?>
</a>
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
                $.post('/admin_device/delete_device_son_type', data, function(res){
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

    });
</script>


<?php }} ?>
