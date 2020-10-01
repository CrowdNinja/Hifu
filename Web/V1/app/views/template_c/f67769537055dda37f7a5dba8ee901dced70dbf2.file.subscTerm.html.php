<?php /* Smarty version Smarty-3.1.19, created on 2020-06-07 16:49:33
         compiled from "C:\xampp\htdocs\beauty-server\app\views\staff\subscTerm.html" */ ?>
<?php /*%%SmartyHeaderCode:20461656445edcfe7d6be706-74149093%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f67769537055dda37f7a5dba8ee901dced70dbf2' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beauty-server\\app\\views\\staff\\subscTerm.html',
      1 => 1591541006,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20461656445edcfe7d6be706-74149093',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'page' => 0,
    'aid' => 0,
    'get' => 0,
    'get_corpid_account' => 0,
    'get_adminid_account' => 0,
    'list' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5edcfe7d707459_78193709',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5edcfe7d707459_78193709')) {function content_5edcfe7d707459_78193709($_smarty_tpl) {?>
<title><?php echo translate('员工管理');?>
 - <?php echo translate('员工列表');?>
</title>
<!--<div class="page-header">-->
	<!--<h1>-->
		<!--员工管理 <small> <i class="ace-icon fa fa-angle-double-right"></i> 员工列表-->
		<!--</small>-->
	<!--</h1>-->
<!--</div>-->
<!-- /.page-header -->

<script language='javascript' src="/style/assets/js/jquery.dialogBox.js"></script>
<link rel="stylesheet" href="/style/assets/js/jquery.dialogbox.css" />

<div class="row">
	<div class="col-xs-12">
    <h3>サブスク約款の管理</h3>
 <!--    <ul class="nav nav-tabs">
        <li class="active"><a href="/admin_system#page/admin_staff/<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
"><?php echo translate('员工列表');?>
</a></li>
    </ul> -->
    <br />
    <a href="/admin_system#page/admin_staff/edit/" class="btn btn-complete">予約を新規追加</a>


		<div class="panel panel-success">
			<div class="panel-heading" onclick="$(this).parent().find('.panel-body').toggle()"><i class="glyphicon glyphicon-chevron-down"></i> <?php echo translate('筛选');?>
</div>
			<div class="panel-body" style="display:">

            <div class="form-group form-search form-inline">


			<?php if ($_smarty_tpl->tpl_vars['aid']->value==1) {?>
				<label class="control-label">約款名</label>
				<input  class="form-control" id="name" name="name" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['name'];?>
" style="width:120px" />
				<label class="control-label">適応するメニュー名</label>
				<input  class="form-control" id="name" name="name" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['name'];?>
" style="width:120px" />
				<?php }?>
                <button class="btn btn-default btn-sm"><i class="fa fa-search"></i> <?php echo translate('搜索');?>
</button>
				<!--<button id="importBtn" class="btn btn-sm btn-primary"><i class="fa fa-download"></i> 下载二维码</button>-->
            </div>

    </div>

    </div>
<script>
$(function () {
    $('.agent_id').chosen();
    $('.seller_id').chosen();

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

		<form class="form-horizontal" role="form" id="submitform" method="post" action="/admin_device/import" enctype="multipart/form-data">
					<table class="table table-hover table-striped">
						<thead>
							<tr>
								<th></th>
								<th>約款名</th>
								<th>適応するメニューリスト</th>
								<th>編集</th>
							</tr>
						</thead>
						<tbody>
							<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['list']->value['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
							<tr class="alert1" align="left">
								<td><input type="checkbox" name="id[]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" /> <?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</td>
								<!--<td><?php echo $_smarty_tpl->tpl_vars['v']->value['price'];?>
</td>-->
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['adminname'];?>
</td>

								<td align="justify" >
									<?php if (chkcommand('/admin_staff/edit')) {?>
									<a href="admin_system#page/admin_staff/edit/<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="btn btn-success btn-xs"> <i class="fa fa-edit"></i>修改</a>
									<?php }?>
								</td>
							</tr>
							<?php } ?>
					<tr>
						<td style="border:none" colspan="12"><input type="checkbox" id="checkall" onclick="var ck = this.checked;$('input[name=&quot;id[]&quot;]').each(function(){this.checked = ck});">
							<?php if (chkcommand('/admin_staff/delete')) {?>
							<input id="btnDelete" class="btn btn-default" value="<?php echo translate('删除');?>
" type="button">
							<?php }?>
							<!--<input id="btnClear" class="btn btn-default" value="清空" type="button">-->
							<?php if (chkcommand('/admin_staff/edit')) {?>
                            <a href="/admin_system#page/admin_staff/edit/" class="btn btn-complete">予約を新規追加</a>
							<?php }?>
						</td>
					</tr>

						</tbody>
					</table>
                    <!--  <table   style="width:100%;" class="listpage"><tr><td ><?php echo translate('共');?>
 <?php echo $_smarty_tpl->tpl_vars['list']->value['total'];?>
 <?php echo translate('条记录');?>
 <?php echo $_smarty_tpl->tpl_vars['list']->value['pages'];?>
  </td></tr></table> -->
					
				</form>
                </div>
			</div>
		</div>

<script src="/style/js/jquery.dialogBox.js"></script>
<div id="dialog-box-mask" style="height: 400px; display: none;"></div>
<div class="getinfo-box"></div>
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
		/*$('.datetimepicker').datetimepicker({
			format: 'YYYY-MM-DD',
			language: 'zh-CN',
			pickDate: true,
			pickTime: true,
			hourStep: 1,
			minuteStep: 15,
			secondStep: 30,
			inputMask: true
		});*/


		$('#btnDelete').click(function(){
			var ckvals = $.selectCK('input[name="id[]"]');
			if(!ckvals){
				tooltipbox.show("<?php echo translate('请选择要操作的数据');?>
");
				return false;
			}
			tooltipbox.confirm("現金支払いを削除します<br/><span>予約番号：CFDM7H</span><br/><span>の支払い削除します</span><br/><span class='alert-red'>＊この作業は取り消せません</span>", function(data){
				tooltipbox.show("<?php echo translate('正在执行操作');?>
");
				$.post('/admin_staff/delete', data, function(res){
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
				$.post('/admin_staff/clear', { }, function(res){
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

<script>
    laydate.render({
        elem: '#createtime1',
    });
    laydate.render({
        elem: '#createtime2'
    });
</script>
<?php }} ?>
