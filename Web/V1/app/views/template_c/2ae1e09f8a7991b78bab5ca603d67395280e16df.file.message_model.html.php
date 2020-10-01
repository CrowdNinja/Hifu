<?php /* Smarty version Smarty-3.1.19, created on 2020-06-07 16:18:06
         compiled from "C:\xampp\htdocs\beauty-server\app\views\user\message_model.html" */ ?>
<?php /*%%SmartyHeaderCode:15193872525edcf71e933578-13126451%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2ae1e09f8a7991b78bab5ca603d67395280e16df' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beauty-server\\app\\views\\user\\message_model.html',
      1 => 1591104997,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15193872525edcf71e933578-13126451',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'get' => 0,
    'user_age' => 0,
    'k' => 0,
    'v' => 0,
    'get_userid_account' => 0,
    'list' => 0,
    'page' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5edcf71e986817_81883762',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5edcf71e986817_81883762')) {function content_5edcf71e986817_81883762($_smarty_tpl) {?>
<title><?php echo translate('会员管理');?>
 - <?php echo translate('消息列表');?>
</title>
<!--<div class="page-header">-->
	<!--<h1>-->
		<!--会员管理 <small> <i class="ace-icon fa fa-angle-double-right"></i> 会员列表-->
		<!--</small>-->
	<!--</h1>-->
<!--</div>-->
<!-- /.page-header -->


<div class="row">
	<div class="col-xs-12">
    
    <ul class="nav nav-tabs">
        <li class="active"><a href="/admin_system#page/admin_user/message_model/"><?php echo translate('消息列表');?>
</a></li>
        <!--<li><a href="/admin_system#page/admin_recharge/">充值列表</a></li>-->
        <!--<li><a href="/admin_system#page/admin_foregift/">押金列表</a></li>-->
        <!--<li><a href="/admin_system#page/admin_cash/">提现列表</a></li>-->
    </ul>
    <br />

		<div class="panel panel-success">
			<div class="panel-heading" onclick="$(this).parent().find('.panel-body').toggle()"><i class="glyphicon glyphicon-chevron-down"></i> <?php echo translate('筛选');?>
</div>
			<div class="panel-body" style="display:">

            <div class="form-group form-search form-inline">
				<label class="control-label"><?php echo translate('标题');?>
</label>
				<input id="title" class="form-control" name="title" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['title'];?>
" />
				<!--<label class="control-label">选择年龄</label>-->
                <!--<select class="form-control" id="age" name="age">-->
                	<!--<option value="">&#45;&#45;&#45;&#45;请选择&#45;&#45;&#45;&#45;</option>-->
                	<!--<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['user_age']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>-->
                	<!--<option value=<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
 <?php if ($_smarty_tpl->tpl_vars['get']->value['age']==$_smarty_tpl->tpl_vars['k']->value) {?>selected<?php }?> ><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</option>-->
                	<!--<?php } ?>-->
                <!--</select>-->
               <!-- <label class="control-label">是否阅读</label>
                <select class="form-control" id="is_read" name="is_read">
                	<option value="">&#45;&#45;请选择&#45;&#45;</option>
                	<option value="0"  <?php if ($_smarty_tpl->tpl_vars['get']->value['is_read']=='0') {?>selected<?php }?>> 未阅读</option>
                	<option value="1" <?php if ($_smarty_tpl->tpl_vars['get']->value['is_read']=='1') {?>selected<?php }?>> 已阅读</option>

                </select>-->


                <label class="control-label"><?php echo translate('创建日期');?>
</label>
                    <input class="form-control datetimepicker" name="createtime1" id="createtime1" type="text" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['createtime1'];?>
" placeholder="">
                <label class="control-label"><?php echo translate('至');?>
</label>
                    <input class="form-control datetimepicker" name="createtime2" id="createtime2" type="text" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['createtime2'];?>
" placeholder="">
              
                    <button class="btn btn-default btn-sm"><i class="fa fa-search"></i> <?php echo translate('搜索');?>
</button>
            </div>
       
		    </div>
		 
		</div>
		<script>
            $(function () {
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
								<th><?php echo translate('标题');?>
</th>
								<!--<th width="200">内容</th>-->
								<th><?php echo translate('图片');?>
</th>
							<!--	<th>是否阅读</th>-->
								<th><?php echo translate('创建时间');?>
</th>
								<th><?php echo translate('操作');?>
</th>
								 
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
							<tr class="alert1 success" align="left">
								<td><input type="checkbox" name="id[]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" /><?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</td>
								<!--<td><?php echo $_smarty_tpl->tpl_vars['v']->value['content'];?>
</td>-->
								<td><img src="<?php echo $_smarty_tpl->tpl_vars['v']->value['img'];?>
" alt="" width="30" height="30" class="img-prefile"/></td>
								<!--<td><?php if ($_smarty_tpl->tpl_vars['v']->value['is_read']==1) {?>已阅读<?php } else { ?>未阅读<?php }?></td>-->
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['ctime'];?>
</td>
								<td>
									<?php if (chkcommand('/admin_user/message_model_details')) {?>
									<a href="admin_system#page/admin_user/message_model_details/<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="btn btn-info btn-xs" ><i class="fa fa-info"></i><?php echo translate('详情');?>
</a>
									<?php }?>
									<?php if (chkcommand('/admin_user/message')) {?>
									<a href="admin_system#page/admin_user/message/<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
/<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
" class="btn btn-pink btn-xs" ><i class="fa fa-list"></i> <?php echo translate('已发送会员');?>
</a>
									<?php }?>
								</td>

							</tr>
							<?php } ?>
					<tr style="position:fixed; bottom:0; width:100%; background:#fff;z-index:9">
						<td style="border:none" colspan="12"><input type="checkbox" id="checkall" onclick="var ck = this.checked;$('input[name=&quot;id[]&quot;]').each(function(){this.checked = ck});">
							<?php if (chkcommand('/admin_user/message_delete')) {?>
							<input id="btnDelete" class="btn btn-default  btn-lg" value="<?php echo translate('删除');?>
" type="button">
							<?php }?>
							<?php if (chkcommand('/admin_user/send_message')) {?>
                            <a href="/admin_system#page/admin_user/send_message" class="btn  btn-primary btn-lg">+ <?php echo translate('发送信息');?>
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

	  laydate.render({
            elem: '#createtime1',
        });
        laydate.render({
            elem: '#createtime2'
        });
        $('.img-prefile').viewer('destroy').viewer({});
        $('.img-prefile').parent().off('click', '.viewer-canvas').on('click', '.viewer-canvas', function(e){
            var _con = $(this).find('img');
            if(_con && !_con.is(e.target) && _con.has(e.target).length === 0){
                $('.img-prefile').viewer('hide');
            }
        });
        $('.back').click(function(){
            history.back(-1);
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
				$.post('/admin_user/message_delete', data, function(res){
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
