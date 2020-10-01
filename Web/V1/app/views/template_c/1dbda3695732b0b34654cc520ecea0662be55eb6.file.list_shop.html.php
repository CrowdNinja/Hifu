<?php /* Smarty version Smarty-3.1.19, created on 2020-06-25 08:35:16
         compiled from "C:\xampp\htdocs\beauty-server\app\views\shop\list_shop.html" */ ?>
<?php /*%%SmartyHeaderCode:5328220125ed90413691b45-86331545%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1dbda3695732b0b34654cc520ecea0662be55eb6' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beauty-server\\app\\views\\shop\\list_shop.html',
      1 => 1592793966,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5328220125ed90413691b45-86331545',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5ed90413780a02_04826670',
  'variables' => 
  array (
    'parent' => 0,
    'get' => 0,
    'gid' => 0,
    'member_store_id' => 0,
    'get_adminid_account' => 0,
    'get_recmdid_account' => 0,
    'get_userid_account' => 0,
    'data' => 0,
    'qs_pid' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ed90413780a02_04826670')) {function content_5ed90413780a02_04826670($_smarty_tpl) {?><title><?php echo translate('商家管理');?>
 - <?php echo translate('商家列表');?>
</title>
<div class="page-header">
	<h1>
		<?php echo translate('商家管理');?>
 <small> <i class="ace-icon fa fa-angle-double-right"></i> <?php echo translate('商家列表');?>
 </small>
        <?php if ($_smarty_tpl->tpl_vars['parent']->value['id']) {?>
         <small> <i class="ace-icon fa fa-angle-double-right"></i> <?php echo $_smarty_tpl->tpl_vars['parent']->value['_strpath'];?>
 </small>        
        <?php }?>
		
	</h1>
</div>
<!-- /.page-header --> 

	<script type="text/javascript" src="/style/js/cnarealist.js"></script>    
	<script type="text/javascript" src="/style/js/categorys/categorys.js"></script>    
    <link rel="stylesheet" href="/style/js/categorys/categorys.css" />
<style>
	.dialog-box{
		font: normal 12px '\5FAE\8F6F\96C5\9ED1';
		height: auto;
		position: fixed;
		top: 30%;
		left: 50%;
		z-index: 99999;
		display: none;
	}

	.show{
		display: block;
	}
	.normal{
		background: #fff;
	}
	.correct{
		border-top: 4px solid #66be8c;
		background: #f8fffb;
	}
	.error{
		border-top: 4px solid #f5694b;
		background: #fff8f7;
	}

	.dialog-box-container{
		position: relative;
		margin: 0 auto;
		border-radius: 5px;
		box-shadow: 0 0 10px #bbb;
	}
	.dialog-box-title{
		height: 36px;
		line-height: 36px;
		padding: 8px 15px 0;
	}
	.dialog-box-title h3{
		font-size: 14px;
		font-weight: bold;
		margin: 0;
		float: left;
	}
	.dialog-box-close{
		font-size: 24px;
		margin-left: 20px;
		font-weight: normal;
		float: right;
		cursor: pointer;
		display: inline-block;
		float: right;
	}
	.dialog-box-close:hover{
		color: #f5694b;
	}
	.dialog-box-content{
		font-family: 'Microsoft YaHei';
		padding: 20px;
		line-height: 24px;
		margin: 0;
	}
	.dialog-btn{
		height:30px;
		padding: 0 20px 20px;
		text-align: center;
	}
	.dialog-btn span{
		width: 90px;
		height: 30px;
		line-height: 30px;
		text-align: center;
		display: inline-block;
		border-radius: 3px;
		margin: 0 10px;
		cursor: pointer;
	}
	.dialog-btn-cancel{
		background: #ddd;
	}
	.dialog-btn-cancel:hover{
		background: #d6d6d6;
	}
	.dialog-btn-confirm{
		color: #fff;
		background: #66be8c;
	}
	.dialog-btn-confirm:hover{
		background: #58B781;
	}

	#dialog-box-mask{
		/*position: absolute;*/
		position:fixed;/*LAEL*/
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		z-index: 99998;
		opacity: .3;
		filter: alpha(opacity=30);
		background: #000;
		display: none;
		-webkit-transition: all 0.3s;
		-moz-transition: all 0.3s;
		transition: all 0.3s;
	}

	#dialog-box-iframe body{
		margin: 0;
		padding: 0;
		border: 0;
	}
	/* effect */

	/* effect-fade */
	.effect-fade .dialog-box-container{
		-webkit-transform: scale(0.6);
		-ms-transform: scale(0.6);
		transform: scale(0.6);
		opacity: 0;
		transition: all .3s;
	}
	.show.effect-fade .dialog-box-container{
		-webkit-transform: scale(1);
		-ms-transform: scale(1);
		transform: scale(1);
		opacity: 1;
	}

	/* effect-newspaper */
	.effect-newspaper .dialog-box-container{
		-webkit-transform: scale(0) rotate(720deg);
		-ms-transform: scale(0) rotate(720deg);
		transform: scale(0) rotate(720deg);
		opacity: 0;
		-webkit-transition: all 0.3s;
		transition: all 0.3s;
	}
	.show.effect-newspaper .dialog-box-container{
		-webkit-transform: scale(1) rotate(0deg);
		-ms-transform: scale(1) rotate(0deg);
		transform: scale(1) rotate(0deg);
		opacity: 1;
	}

	/* effect-fall */
	.effect-fall{
		-webkit-perspective: 1300px;
		perspective: 1300px;
	}
	.effect-fall .dialog-box-container{
		-webkit-transform-style: preserve-3d;
		transform-style: preserve-3d;
		-webkit-transform: translateZ(600px) rotateX(20deg);
		-ms-transform: translateZ(600px) rotateX(20deg);
		transform: translateZ(600px) rotateX(20deg);
		opacity: 0;
	}
	.show.effect-fall .dialog-box-container{
		-webkit-transition: all 0.3s ease-in;
		transition: all 0.3s ease-in;
		-webkit-transform: translateZ(0px) rotateX(0deg);
		-ms-transform: translateZ(0px) rotateX(0deg);
		transform: translateZ(0px) rotateX(0deg);
		opacity: 1;
	}

	/* effect-scaled */
	.effect-scaled .dialog-box-container{
		-webkit-transform: scale(2);
		-ms-transform: scale(2);
		transform: scale(2);
		opacity: 0;
		-webkit-transition: all 0.3s;
		transition: all 0.3s;
	}
	.show.effect-scaled .dialog-box-container{
		-webkit-transform: scale(1);
		-ms-transform: scale(1);
		transform: scale(1);
		opacity: 1;
	}

	/* effect-flip-horizontal */
	.effect-flip-horizontal{
		-webkit-perspective: 1300px;
		-moz-perspective: 1300px;
		perspective: 1300px;
	}
	.effect-flip-horizontal .dialog-box-container{
		-webkit-transform-style: preserve-3d;
		transform-style: preserve-3d;
		-webkit-transform: rotateY(-70deg);
		-ms-transform: rotateY(-70deg);
		transform: rotateY(-70deg);
		-webkit-transition: all 0.3s;
		transition: all 0.3s;
		opacity: 0;
	}
	.show.effect-flip-horizontal .dialog-box-container{
		-webkit-transform: rotateY(0deg);
		-ms-transform: rotateY(0deg);
		transform: rotateY(0deg);
		opacity: 1;
	}

	/* effect-flip-vertical */
	.effect-flip-vertical{
		-webkit-perspective: 1300px;
		-moz-perspective: 1300px;
		perspective: 1300px;
	}
	.effect-flip-vertical .dialog-box-container{
		-webkit-transform-style: preserve-3d;
		transform-style: preserve-3d;
		-webkit-transform: rotateX(-70deg);
		-ms-transform: rotateX(-70deg);
		transform: rotateX(-70deg);
		-webkit-transition: all 0.3s;
		transition: all 0.3s;
		opacity: 0;
	}
	.show.effect-flip-vertical .dialog-box-container{
		-webkit-transform: rotateX(0deg);
		-ms-transform: rotateX(0deg);
		transform: rotateX(0deg);
		opacity: 1;
	}

	/* effect-sign */
	.effect-sign{
		-webkit-perspective: 1300px;
		perspective: 1300px;
	}
	.effect-sign .dialog-box-container{
		-webkit-transform-style: preserve-3d;
		transform-style: preserve-3d;
		-webkit-transform: rotateX(-60deg);
		-ms-transform: rotateX(-60deg);
		transform: rotateX(-60deg);
		-webkit-transform-origin: 50% 0;
		transform-origin: 50% 0;
		opacity: 0;
		-webkit-transition: all 0.3s;
		transition: all 0.3s;
	}
	.show.effect-sign .dialog-box-container{
		-webkit-transform: rotateX(0deg);
		-ms-transform: rotateX(0deg);
		transform: rotateX(0deg);
		opacity: 1;
	}
	/*td {
        word-break: keep-all;
        white-space: nowrap;
    }*/
</style>
<div class="row">
	<div class="col-xs-12">
    
    <ul class="nav nav-tabs">
        <li class="active"><a href="/admin_system#page/admin_shop/"><?php echo translate('加盟店リスト');?>
</a></li>
    </ul>
    <br />


	<div class="panel panel-success">
    <div class="panel-heading" onclick="$(this).parent().find('.panel-body').toggle()"><i class="glyphicon glyphicon-chevron-down"></i> <?php echo translate('スクリーニング');?>
</div>
    <div class="panel-body" style="display:">

      
            <div class="form-group form-search form-inline">
				<label class="control-label"><?php echo translate('店舗選択');?>
</label>
				<input id="adminid" name="adminid" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['adminid'];?>
" style="width:200px" />

				<button class="btn btn-default btn-sm"><i class="fa fa-search"></i> <?php echo translate('検索する');?>
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

	<?php if ($_smarty_tpl->tpl_vars['gid']->value==4) {?>
		<?php if ($_smarty_tpl->tpl_vars['member_store_id']->value) {?>
			$('#adminid').select2('data', {id:"<?php echo $_smarty_tpl->tpl_vars['member_store_id']->value;?>
", text:"<?php echo $_smarty_tpl->tpl_vars['get_adminid_account']->value;?>
"}).select2('val', ["<?php echo $_smarty_tpl->tpl_vars['member_store_id']->value;?>
"]);
			$("#adminid").prop("disabled", true);
		<?php }?>
	<?php } else { ?>
		<?php if ($_smarty_tpl->tpl_vars['get']->value['adminid']) {?>
			$('#adminid').select2('data', {id:"<?php echo $_smarty_tpl->tpl_vars['get']->value['adminid'];?>
", text:"<?php echo $_smarty_tpl->tpl_vars['get_adminid_account']->value;?>
"}).select2('val', ["<?php echo $_smarty_tpl->tpl_vars['get']->value['adminid'];?>
"]);
		<?php }?>
	<?php }?>

	$("#recmdid,#userid").select2({
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
	<?php if ($_smarty_tpl->tpl_vars['get']->value['recmdid']) {?>$('#recmdid').select2('data', {id:"<?php echo $_smarty_tpl->tpl_vars['get']->value['recmdid'];?>
", text:"<?php echo $_smarty_tpl->tpl_vars['get_recmdid_account']->value;?>
"}).select2('val', ["<?php echo $_smarty_tpl->tpl_vars['get']->value['recmdid'];?>
"]);<?php }?>
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
});
</script>                 
				 
				<form class="form-horizontal" role="form" id="submitform">
	           <table class="table table-bordered table-hover">
			<thead>
          <tr>
            <th><?php echo translate('店舗名');?>
</th>
            <th><?php echo translate('住所');?>
</th>
            <th><?php echo translate('本部手数料');?>
</th>
            <th><?php echo translate('連絡先');?>
</th>
            <th><?php echo translate('ステータス');?>
</th>
            <th><?php echo translate('操作');?>
</th>
          </tr>
        </thead> 
					<tbody>
					<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['values'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['values']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['values']['name'] = 'values';
$_smarty_tpl->tpl_vars['smarty']->value['section']['values']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['data']->value->list) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['values']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['values']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['values']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['values']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['values']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['values']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['values']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['values']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['values']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['values']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['values']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['values']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['values']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['values']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['values']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['values']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['values']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['values']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['values']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['values']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['values']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['values']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['values']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['values']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['values']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['values']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['values']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['values']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['values']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['values']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['values']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['values']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['values']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['values']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['values']['total']);
?>
					<tr class="alert1 success" align="left">
						<td>
							<?php echo $_smarty_tpl->tpl_vars['data']->value->list[$_smarty_tpl->getVariable('smarty')->value['section']['values']['index']]->nickname;?>

						</td>
						<td>
							<?php echo $_smarty_tpl->tpl_vars['data']->value->list[$_smarty_tpl->getVariable('smarty')->value['section']['values']['index']]->area;?>

						</td>
                        <td>
							<?php echo $_smarty_tpl->tpl_vars['data']->value->list[$_smarty_tpl->getVariable('smarty')->value['section']['values']['index']]->percen;?>
 %
						</td>
                        <td>
							<?php echo $_smarty_tpl->tpl_vars['data']->value->list[$_smarty_tpl->getVariable('smarty')->value['section']['values']['index']]->name;?>
 <?php echo $_smarty_tpl->tpl_vars['data']->value->list[$_smarty_tpl->getVariable('smarty')->value['section']['values']['index']]->phone;?>

						</td>
						<td>
							<?php if ($_smarty_tpl->tpl_vars['data']->value->list[$_smarty_tpl->getVariable('smarty')->value['section']['values']['index']]->status==1) {?><b style="color:green;"><?php echo translate('使用可能');?>
</b><?php } elseif ($_smarty_tpl->tpl_vars['data']->value->list[$_smarty_tpl->getVariable('smarty')->value['section']['values']['index']]->status==0) {?><b style="color:red;"><?php echo translate('禁用');?>
</b><?php }?>
						</td>
						<td>
							<?php if (chkcommand('/admin_shop/edit')) {?>
                            <a href="/admin_system#page/admin_shop/edit/<?php echo $_smarty_tpl->tpl_vars['data']->value->list[$_smarty_tpl->getVariable('smarty')->value['section']['values']['index']]->id;?>
<?php echo $_smarty_tpl->tpl_vars['qs_pid']->value;?>
" class="btn btn-success btn-xs"><i class="fa fa-edit"></i> <?php echo translate('編集');?>
</a>
                            <?php }?>
						</td> 
					</tr>
				<?php endfor; endif; ?>
				
                <tr style="position:fixed; bottom:0; width:100%; background:#fff;z-index:9">
						<td style="border:none" colspan="12">
							<?php if ($_smarty_tpl->tpl_vars['gid']->value==1) {?>
								<?php if (chkcommand('/admin_shop/add')) {?>
								<a  href="/admin_system#page/admin_shop/add<?php echo $_smarty_tpl->tpl_vars['qs_pid']->value;?>
" class="btn  btn-primary btn-lg"><?php echo translate('追加する');?>
</a>
								<?php }?>
							<?php }?>
                                        
						</td>
					</tr>

						</tbody>
					</table>
                     <table   style="width:100%;" class="listpage"><tr><td ><?php echo translate('合計');?>
 <?php echo $_smarty_tpl->tpl_vars['data']->value->total;?>
 <?php echo translate('件');?>
 <?php echo $_smarty_tpl->tpl_vars['data']->value->pages;?>
  </td></tr></table>
					
				</form>
                </div>
			</div>
		</div>

<script src="/style/js/jquery.dialogBox.js"></script>

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
        $('.cash').click(function () {
            var id=$(this).data('id');
            var url = 'admin_shop/cash/?id='+id;
            $('.getinfo-box').prev().dialogBox({
                title: "<?php echo translate('出金申請ですか');?>
",
                fixTop: -240,
                autoSize: true,
                hasMask: true,
                hasClose: true,
                scrolling: 'auto',
                content: '<iframe src="'+url+'" frameborder="0" scrolling="no" style="width:450px;height:450px"></iframe>',

            });
        });
        $('.btnDelete').click(function(){
            var id = $(this).data('id');
            tooltipbox.confirm("<?php echo translate('このデータを削除してもよろしいですか？');?>
", function(data){
                tooltipbox.show("<?php echo translate('操作を実行する');?>
");
                $.post('/admin_shop/delete', data, function(res){
                    if(res.status == '1'){
                        tooltipbox.show("<?php echo translate('操作が正常に実行されました');?>
");
                        location.reload();
                    }else{
                        tooltipbox.show("<?php echo translate('データまたはネットワークエラー');?>
");
                    }
                }, 'json').error(function(){
                    tooltipbox.show("<?php echo translate('データまたはネットワークエラー');?>
");
                });
            }, false, { 'id': id });
        });
		$('#btnOrderBy').click(function(){
				tooltipbox.show("<?php echo translate('操作を実行する');?>
");
				$.post('/admin_shop/orderby<?php echo $_smarty_tpl->tpl_vars['qs_pid']->value;?>
', $('#submitform').serializeArray(), function(res){
					if(res.status == '1'){
						tooltipbox.show("<?php echo translate('操作が正常に実行されました');?>
");
						location.reload();
					}else{
						tooltipbox.show("<?php echo translate('データまたはネットワークエラー');?>
");
					}
				}, 'json').error(function(){
					tooltipbox.show("<?php echo translate('データまたはネットワークエラー');?>
");
				});
		});
	});
</script>
 
<?php }} ?>
