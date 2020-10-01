<?php /* Smarty version Smarty-3.1.19, created on 2020-06-23 17:43:26
         compiled from "C:\xampp\htdocs\beauty-server\app\views\trade\pay_cash.html" */ ?>
<?php /*%%SmartyHeaderCode:2310241755ee31b65177144-12706684%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1858d3d98eb65c947fdadaf0bed2e25faf2e0718' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beauty-server\\app\\views\\trade\\pay_cash.html',
      1 => 1592815298,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2310241755ee31b65177144-12706684',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5ee31b651c8b58_85340041',
  'variables' => 
  array (
    'page' => 0,
    'get' => 0,
    'get_corpid_account' => 0,
    'get_adminid_account' => 0,
    'trade' => 0,
    'v' => 0,
    'vv' => 0,
    'type' => 0,
    'key' => 0,
    'list' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ee31b651c8b58_85340041')) {function content_5ee31b651c8b58_85340041($_smarty_tpl) {?>
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
    <h3>現金支払の管理</h3>
 <!--    <ul class="nav nav-tabs">
        <li class="active"><a href="/admin_system#page/admin_staff/<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
"><?php echo translate('员工列表');?>
</a></li>
    </ul> -->
    <br />

		<div class="panel panel-success">
			<div class="panel-heading" onclick="$(this).parent().find('.panel-body').toggle()"><i class="glyphicon glyphicon-chevron-down"></i> <?php echo translate('筛选');?>
</div>
			<div class="panel-body" style="display:">

            <div class="form-group form-search form-inline">

				<label class="control-label">予約番号</label>
				<input  class="form-control" id="pay_token" name="pay_token" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['pay_token'];?>
" style="width:120px" />
				<label class="control-label">メニュー名</label>
				<input  class="form-control" id="pack_title" name="pack_title" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['pack_title'];?>
" style="width:120px" />
				<label class="control-label">予約者名</label>
				<input  class="form-control" id="user_name" name="user_name" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['user_name'];?>
" style="width:120px" />
        <label class="control-label">デバイス</label>
        <select class="form-control" id="device" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['device'];?>
" style="width: 120px;" >
          <option value="-1">
            全て
          </option>
          <option value="1">
            わたしのハイフ
          </option>
          <option value="2">
            脱毛
          </option>
        </select>
                <button class="btn btn-default btn-search btn-sm"><i class="fa fa-search"></i> <?php echo translate('搜索');?>
</button>
				<!--<button id="importBtn" class="btn btn-sm btn-primary"><i class="fa fa-download"></i> 下载二维码</button>-->
            </div>

    </div>

    </div>
<script>
$(function () {
    $('.agent_id').chosen();
    $('.seller_id').chosen();
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
	$('.btn-search').click(function(){
		var url = $.searchURL( location.href );
		location.href = url;
	});
});
</script>

		<form class="form-horizontal" role="form" id="submitform" method="post" action="/admin_device/import" enctype="multipart/form-data">
      <table class="table table-hover table-striped">
        <thead>
          <tr>
						<th><?php echo translate('序号');?>
</th>
						<th><?php echo translate('メニュー名');?>
</th>
						<th><?php echo translate('予約番号');?>
</th>
						<th><?php echo translate('価格');?>
</th>
						<th><?php echo translate('予約者名');?>
</th>
						<th><?php echo translate('予約時間');?>
</th>
						<th><?php echo translate('予約デバイス');?>
</th>
						<th><?php echo translate('編集');?>
</th>
          </tr>
        </thead>
        <tbody>
					<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['trade']->value['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
          <tr class="alert1" align="left">
            <td><input type="checkbox" name="id[]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" /> <?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</td>
						<td><?php echo $_smarty_tpl->tpl_vars['v']->value['pack']['title'];?>
</td>
						<td><?php echo $_smarty_tpl->tpl_vars['v']->value['pay_token'];?>
</td>
						<td><?php echo $_smarty_tpl->tpl_vars['v']->value['pack']['price'];?>
</td>
						<td><?php echo $_smarty_tpl->tpl_vars['v']->value['_userid']['nickname'];?>
</td>
						<td>
							<?php  $_smarty_tpl->tpl_vars['vv'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vv']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['v']->value['reservations']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vv']->key => $_smarty_tpl->tpl_vars['vv']->value) {
$_smarty_tpl->tpl_vars['vv']->_loop = true;
?>
								<?php echo $_smarty_tpl->tpl_vars['vv']->value['start_time'];?>
<br>
							<?php } ?>
						</td>
						<td>
							<?php  $_smarty_tpl->tpl_vars['vv'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vv']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['v']->value['reservations']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vv']->key => $_smarty_tpl->tpl_vars['vv']->value) {
$_smarty_tpl->tpl_vars['vv']->_loop = true;
?>
								<?php  $_smarty_tpl->tpl_vars['type'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['type']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['vv']->value['types']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['type']->key => $_smarty_tpl->tpl_vars['type']->value) {
$_smarty_tpl->tpl_vars['type']->_loop = true;
?>
									<?php echo translate($_smarty_tpl->tpl_vars['type']->value);?>

								<?php } ?>
							<?php } ?>
						</td>
						<td >
							<a href="admin_system#page/admin_trade/edit_cash/<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="btn btn-success btn-xs btn_edit"> <?php echo translate('編集');?>
</a>
							<a class="btn btn-danger btn-xs btn_pay" id="pay" data-id="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"> <?php echo translate('支払い完了');?>
</a>
							<a class="btn btn-primary btn-xs btn_cancel btnDelete" id="" data-id="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"> <?php echo translate('キャンセル・削除');?>
</a>
						</td>
          </tr>
          <?php } ?>
          <tr>
            <td style="border:none" colspan="12"><input type="checkbox" id="checkall" onclick="var ck = this.checked;$('input[name=&quot;id[]&quot;]').each(function(){this.checked = ck});">

              <input class="btn btn-default btnDelete" value="<?php echo translate('删除');?>
" type="button">

              <!--<input id="btnClear" class="btn btn-default" value="清空" type="button">-->

              <a class="btn btn-complete btn_pay"><i class="fa fa-plus-square-o"></i> 支払い完了</a>

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
   var trades = <?php echo json_encode($_smarty_tpl->tpl_vars['trade']->value['list']);?>

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

    $('.btn_pay').click(function() {
      var index = $(this).data('id');
      var ckvals = $.selectCK('input[name="id[]"]');
      if (isNaN(index) && !ckvals) {
				tooltipbox.show("<?php echo translate('请选择要操作的数据');?>
");
				return false;
      }
			tooltipbox.confirm("現金支払いをします", function(data){
        var ids;
        if (ckvals) {
          ids = ckvals
        } else {
          ids = trades[index]['pay_token'];
        }
				tooltipbox.show("<?php echo translate('正在执行操作');?>
");
          $.ajax({
            type: 'POST',
            data: {
              'ids': ids,
            },
            url: '/admin_trade/pay_money',
            error: function(xhr) { alert( xhr.responseText ); }, //如果你的url,txt有问题,将会提示
            success: function(data) {
              window.location.reload()
            }
          })
			}, false, { 'ids': ckvals });
        
    })

		$('.btnDelete').click(function(){
      var index = $(this).data('id');
      console.log(index)
			var ckvals = $.selectCK('input[name="id[]"]');
			if(isNaN(index) && !ckvals){
				tooltipbox.show("<?php echo translate('请选择要操作的数据');?>
");
				return false;
			}
      var ids;
      if (ckvals) {
        ids = ckvals
      } else {
        ids = trades[index]['id'];
      }
			tooltipbox.confirm("現金支払いを削除します<br/>"+(!ckvals?"<span>予約番号："+trades[index]['pay_token']+"</span><br/><span>の支払い削除します</span><br/>":"")+"<span class='alert-red'>＊この作業は取り消せません</span>", function(data){
				tooltipbox.show("<?php echo translate('正在执行操作');?>
");
          $.ajax({
            type: 'POST',
            data: {
              'ids': ids,
            },
            url: '/admin_trade/delete_trades',
            error: function(xhr) { alert( xhr.responseText ); }, //如果你的url,txt有问题,将会提示
            success: function(data) {
              window.location.reload()
            }
          })
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
