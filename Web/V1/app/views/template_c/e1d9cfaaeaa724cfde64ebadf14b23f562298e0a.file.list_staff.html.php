<?php /* Smarty version Smarty-3.1.19, created on 2020-06-07 20:21:33
         compiled from "C:\xampp\htdocs\beauty-server\app\views\new_admins\list_staff.html" */ ?>
<?php /*%%SmartyHeaderCode:5226386925edd302db5a176-03964584%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e1d9cfaaeaa724cfde64ebadf14b23f562298e0a' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beauty-server\\app\\views\\new_admins\\list_staff.html',
      1 => 1591455464,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5226386925edd302db5a176-03964584',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5edd302db831d8_68323646',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5edd302db831d8_68323646')) {function content_5edd302db831d8_68323646($_smarty_tpl) {?>
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
	    		<div class="subsc-item-content-type">
	    			<div>
	    				<p>メニュー</p>
	    				<input type="text" name="" placeholder="最上級小顔、リフトアップ、しわケア！">
	    			</div>
	    			<div>
	    				<p>予約番号</p>
	    				<p>CFDM7H</p>
	    			</div>
	    		</div>
	    		<div class="subsc-item-content-type">
	    			<div>
	    				<p>お得金額<span class="small-label">メニューを変更すると更新されます</span></p>
	    				<p>¥10,000</p>
	    			</div>
	    			<div>
	    				<p>予約デバイス<span class="small-label">メニューを変更すると更新されます</span></p>
	    				<p>わたしのハイフ。</p>
	    			</div>
	    		</div>
	    		<div class="subsc-item-content-type">
	    			<div>
	    				<p>開始時間</p>
	    				<input type="text" name="" placeholder="2020年5月30日（土）13：00">
	    			</div>
	    			<div>
	    				<p>終了時間</p>
	    				<input type="text" name="" placeholder="2020年5月30日（土）16：00">
	    			</div>
	    		</div>
	    	</div>
	    </div>

	    <div class="subsc-adds">
	    	<button id="add-subsc-menu">情報を更新する</button>
	    	<div id="created-tiem">
	    		<p>購入日</p>
	    		<p>2020年5月30日23:59</p>
	    	</div>
	    	<button class="payment-btn-cancel">キャンセルする</button>
	    	<button class="payment-btn">支払いを確定する</button>
	    </div>
    </div>
</div>

<script type="text/javascript">
	$(document).on('change', '.sabsc-image-btn', function(event) {
    var files, image, reader, that;
    files = event.target.files;
    image = files[0];
    reader = new FileReader();
    that = this;
    reader.onload = function(file) {
      var img;
      img = new Image();
      img.src = file.target.result;
      $('.subsc-image-p').html(img);
    };
    reader.readAsDataURL(image);
  });

	$('#add-subsc-menu').click(function(){
		$(this).parent().before('<div class="subsc-item">	    	<div class="subsc-item-surround"><span>1</span></div>	    	<div class="subsc-item-content">	    		<div class="subsc-item-content-textarea">	    			<div>	    				<p>含まれるメニュー名</p>	    				<input type="text" name="" placeholder="最上級小顔、リフトアップ、しわケア！">	    			</div>	    		</div>	    		<div class="subsc-item-content-textarea">	    			<div>		    			<p>メニューの説明</p>		    			<textarea>最新ハイフマシンでフェイシャル4000ショット×ウエストスリムプラン4000ショットのセットプラン♪7480円→6480円※他部位組み合わせOK最新ハイフマシンでフェイシャル4000ショット×ウエストスリムプラン4000ショットのセットプラン♪7480円→6480円　※他部位組み合わせOK</textarea>		    		</div>	    		</div>	    		<div class="subsc-item-content-type">	    			<div>	    				<p>使用できる回数</p>	    				<input type="text" name="" placeholder="2回">	    			</div>	    			<div>	    				<p>1ショットあたりの金額</p>	    				<input type="text" name="" placeholder="¥10,000">	    			</div>	    		</div>	    	</div>	    	<div class="subsc-item-surround"><button class="delete-btn">-</button></div>	    </div>')
	});
</script>
    
 

<?php }} ?>
