<?php /* Smarty version Smarty-3.1.19, created on 2020-06-23 17:43:28
         compiled from "C:\xampp\htdocs\beauty-server\app\views\trade\edit_cash.html" */ ?>
<?php /*%%SmartyHeaderCode:10987780495ee31f989a2631-96320563%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7a76e7aa7af35e24a7bc9e42427b494d42fb2476' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beauty-server\\app\\views\\trade\\edit_cash.html',
      1 => 1592793957,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10987780495ee31f989a2631-96320563',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5ee31f989cceb2_77700483',
  'variables' => 
  array (
    'cash' => 0,
    'pack' => 0,
    'reservations' => 0,
    'reservation' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ee31f989cceb2_77700483')) {function content_5ee31f989cceb2_77700483($_smarty_tpl) {?>
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
    <h3>現金支払の編集</h3>
    <div class="subsc-menu" id="paymentEdit">
	    <div class="subsc-item">
	    	<div class="subsc-item-content">
					<form class="form-horizontal" role="form" id="submitform" method="post" action="/admin_trade" enctype="multipart/form-data">
						<div class="subsc-item-content-type">
							<div>
								<p>メニュー</p>
								<p><?php echo $_smarty_tpl->tpl_vars['cash']->value['pay_token'];?>
</p>
								<!-- <input type="text" name="packid" id="packid" placeholder="" class="w-100" value=""> -->
							</div>
							<div>
								<p>予約番号</p>
								<p><?php echo $_smarty_tpl->tpl_vars['cash']->value['pay_token'];?>
</p>
							</div>
						</div>
						<div class="subsc-item-content-type">
							<div>
								<p>お得金額<span class="small-label">メニューを変更すると更新されます</span></p>
								<p id="price">¥<?php echo $_smarty_tpl->tpl_vars['pack']->value['price'];?>
</p>
							</div>
							<div>
								<p>予約デバイス<span class="small-label">メニューを変更すると更新されます</span></p>
								<p id="price">
									<?php if (sizeof($_smarty_tpl->tpl_vars['reservations']->value)>0) {?>
										<?php  $_smarty_tpl->tpl_vars['reservation'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['reservation']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['reservations']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['reservation']->key => $_smarty_tpl->tpl_vars['reservation']->value) {
$_smarty_tpl->tpl_vars['reservation']->_loop = true;
?>
											<?php if ($_smarty_tpl->tpl_vars['reservation']->value['types']=='1,') {?>
												わたしのハイフ
											<?php } elseif ($_smarty_tpl->tpl_vars['reservation']->value['types']=='2,') {?>
												脱毛
											<?php }?>
										<?php } ?>
									<?php } else { ?>
									まだ予約はされていません。
									<?php }?>
								</p>
							</div>
						</div>
						<div class="subsc-item-content-type">
							<div>
								<p>開始時間<span class="small-label">メニューを変更すると更新されます</span></p>
								<?php if (sizeof($_smarty_tpl->tpl_vars['reservations']->value)>0) {?>
								<?php  $_smarty_tpl->tpl_vars['reservation'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['reservation']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['reservations']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['reservation']->key => $_smarty_tpl->tpl_vars['reservation']->value) {
$_smarty_tpl->tpl_vars['reservation']->_loop = true;
?>
									<?php if ($_smarty_tpl->tpl_vars['reservation']->value['types']=='1,') {?>
										わたしのハイフ
									<?php } elseif ($_smarty_tpl->tpl_vars['reservation']->value['types']=='2,') {?>
										脱毛
									<?php }?>
								<?php } ?>
								<?php } else { ?>
									まだ予約はされていません。
								<?php }?>
							</div>
							<div>
								<p>終了時間<span class="small-label">メニューを変更すると更新されます</span></p>
								<?php if (sizeof($_smarty_tpl->tpl_vars['reservations']->value)>0) {?>
									<?php  $_smarty_tpl->tpl_vars['reservation'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['reservation']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['reservations']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['reservation']->key => $_smarty_tpl->tpl_vars['reservation']->value) {
$_smarty_tpl->tpl_vars['reservation']->_loop = true;
?>
										<?php if ($_smarty_tpl->tpl_vars['reservation']->value['types']=='1,') {?>
											わたしのハイフ
										<?php } elseif ($_smarty_tpl->tpl_vars['reservation']->value['types']=='2,') {?>
											脱毛
										<?php }?>
									<?php } ?>
								<?php } else { ?>
									まだ予約はされていません。
								<?php }?>
							</div>
						</div>
					</form>
	    	</div>
	    </div>

	    <div class="subsc-adds">
	    	<a id="change-menu" href="/admin_system#page/admin_reservation/" class="btn">情報を更新する</a>
	    	<div id="created-tiem">
	    		<p>購入日</p>
	    		<p><?php echo $_smarty_tpl->tpl_vars['cash']->value['ctime'];?>
</p>
	    	</div>
	    	<a class="payment-btn btn btn-info" id="btn_pay">支払いを確定する</a>
				<!-- <a class="payment-btn-cancel btn-danger btn" id="btnDelete">キャンセルする</a> -->
	    	<a class="payment-btn-cancel btn-danger btn" href="/admin_system#page/admin_trade/trade_money">キャンセルする</a>
				
	    </div>
    </div>
</div>

<script type="text/javascript">
	
	var cash = <?php echo json_encode($_smarty_tpl->tpl_vars['cash']->value);?>


	$('#packid').on('blur', function (e) {
		console.log('error')
		var price = $(this).data('price');
		$('#price').html('￥'+price);

	});
	$('#packid').on('change', function (e) {
		var formData = $('#submitform').serialize();
		console.log(formData.split('=')[1])
		$.ajax( {
			url: '/admin_trade/edit_cash/'+cash['id'],
			data: {pack_id: formData.split('=')[1]},
			type: "POST",
			success:function(data) {
				var data = JSON.parse(data);
				$("#price").html("￥"+data.pack.price)

			},
			error:function(xhr){
				tooltipbox.alert("<?php echo translate('获取失败');?>
");
				return false;
			}
		});
		// window.location.href = '/admin_system#page/admin_trade/edit_cash/'+formData.split('=')[1];
	});

  $("#packid").select2({
		ajax: {
			url: "/admin_trade/search_pack",
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
        console.log(data.data)
				return {
					results:data.data	
				};
			},
			templateResult: formatRepo,
      templateSelection: function (data, container) {
        // Add custom attributes to the <option> tag for the selected option
          console.log(data)
        $(data.element).attr('data-custom-attribute', data.id);
        $('#price').html(data.price)
        return data.text;
      },
			processResults: function (data) {
        console.log(data)
        $('#price').html(data.price);
				return { 
					results: 'data'
				};
			},
			type: 'post',
			dataType: 'json'
		},	
		initSelection: function(elem, cbfunc){
			// console.log(cb)
		},
		allowClear: false,
		openOnEnter: false,
		minimumInputLength: 1,
	});
	function formatRepo(repo) {
		console.log(repo)
		return '';
	}
	<?php if ($_smarty_tpl->tpl_vars['pack']->value) {?>$('#packid').select2('data', {id:"<?php echo $_smarty_tpl->tpl_vars['pack']->value['id'];?>
", text:"<?php echo $_smarty_tpl->tpl_vars['pack']->value['title'];?>
", price: "<?php echo $_smarty_tpl->tpl_vars['pack']->value['price'];?>
"}).select2('val', ["<?php echo $_smarty_tpl->tpl_vars['pack']->value['title'];?>
"]);<?php }?>
	
	$('#btnDelete').click(function(){
		tooltipbox.confirm("現金支払いを削除します<br/><span>予約番号：<?php echo $_smarty_tpl->tpl_vars['cash']->value['pay_token'];?>
</span><br/><span>の支払い削除します</span><br/><span class='alert-red'>＊この作業は取り消せません</span>", function(data){
			tooltipbox.show("<?php echo translate('正在执行操作');?>
");
			$.ajax({
				type: 'POST',
				data: {
					'ids': cash['id'],
				},
				url: '/admin_trade/reservation_delete',
				error: function(xhr) { alert( xhr.responseText ); }, //如果你的url,txt有问题,将会提示
				success: function(data) {
					window.location.href="/admin_system#page/admin_trade/trade_money"
				}
			})
		}, false);
	});
	$('#btn_pay').click(function() {
		var ckvals = $.selectCK('input[name="id[]"]');
		var index = $(this).data('id');
		tooltipbox.confirm("現金支払いします<br/><span>予約番号："+cash['pay_token']+"</span><br/><span>の支払いを確定します</span>", function(data){
			tooltipbox.show("<?php echo translate('正在执行操作');?>
");
				$.ajax({
					type: 'POST',
					data: {
						'id': cash['id'],
					},
					url: '/admin_trade/pay_money',
					error: function(xhr) { alert( xhr.responseText ); }, //如果你的url,txt有问题,将会提示
					success: function(data) {
						window.location.href="/admin_system#page/admin_trade/pay_cash"
					}
				})
		}, false);
			
	})

</script>
    
 

<?php }} ?>
