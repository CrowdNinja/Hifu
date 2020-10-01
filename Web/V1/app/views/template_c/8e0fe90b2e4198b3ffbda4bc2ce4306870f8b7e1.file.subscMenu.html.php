<?php /* Smarty version Smarty-3.1.19, created on 2020-06-07 17:52:31
         compiled from "C:\xampp\htdocs\beauty-server\app\views\staff\subscMenu.html" */ ?>
<?php /*%%SmartyHeaderCode:506431405edd0d3fc01af0-40098827%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8e0fe90b2e4198b3ffbda4bc2ce4306870f8b7e1' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beauty-server\\app\\views\\staff\\subscMenu.html',
      1 => 1591541006,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '506431405edd0d3fc01af0-40098827',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5edd0d3fc309e7_97758257',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5edd0d3fc309e7_97758257')) {function content_5edd0d3fc309e7_97758257($_smarty_tpl) {?>
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
    <h3>サブスクメニューの新規追加</h3>
    <div class="subsc-image-box">
    	<div class="subsc-image">
    		<p>メイン画像</p>
    		<p class="subsc-image-p"><img src=""><button class="delete-btn">-</button></p>
    	</div>
    	<div class="subsc-image-select-box">
    		<p>ファイルをドロップして画像を<br/>アップロード</p>
    		<input type="file" name="subsc-image-file" value="ファイルを選択" class="sabsc-image-btn" id="subsc-image-file">
    		<label for="subsc-image-file">ファイルを選択</label>
    	</div>
    </div>
    <div class="subsc-menu">
    	<div class="subsc-name">
	    	<p>サブスクメニュー名</p>
	    	<input type="text" name="subsc-name" class="text-input" placeholder="サブスクメニュー名を入力してください">
	    	<div class="subsc-item-content-type">
	    		<div>
    				<p>価格</p>
    				<input type="text" name="" placeholder="¥10,000">
    			</div>
    			<div>
    				<p>店舗名</p>
    				<input type="text" name="" placeholder="店舗名">
    			</div>
    		</div>
    		<div class="subsc-item-content-type">
    			<div>
    				<p>お得金額</p>
    				<input type="text" name="" placeholder="¥35,520 OFF">
    			</div>
    			<div>
    				<p>作成者</p>
    				<input type="text" name="" placeholder="作成者の名前">
    			</div>
    		</div>
    		<div class="subsc-item-content-type">
    			<div>
    				<p>有効期限<span>未入力の場合削除するまで有効になります</span></p>
    				<input type="text" name="" placeholder="2020年5月30日23:59">
    			</div>
    		</div>
	    </div>
	    <div class="subsc-item">
	    	<div class="subsc-item-surround"><span>1</span></div>
	    	<div class="subsc-item-content">
	    		<div class="subsc-item-content-textarea">
	    			<div>
	    				<p>含まれるメニュー名</p>
	    				<input type="text" name="" placeholder="最上級小顔、リフトアップ、しわケア！">
	    			</div>
	    		</div>
	    		<div class="subsc-item-content-textarea">
	    			<div>
		    			<p>メニューの説明</p>
		    			<textarea>最新ハイフマシンでフェイシャル4000ショット×ウエストスリムプラン4000ショットのセットプラン♪7480円→6480円※他部位組み合わせOK最新ハイフマシンでフェイシャル4000ショット×ウエストスリムプラン4000ショットのセットプラン♪7480円→6480円　※他部位組み合わせOK</textarea>
		    		</div>
	    		</div>
	    		<div class="subsc-item-content-type">
	    			<div>
	    				<p>使用できる回数</p>
	    				<input type="text" name="" placeholder="2回">
	    			</div>
	    			<div>
	    				<p>1ショットあたりの金額</p>
	    				<input type="text" name="" placeholder="¥10,000">
	    			</div>
	    		</div>
	    	</div>
	    	<div class="subsc-item-surround"><button class="delete-btn">-</button></div>
	    </div>
	    <div class="subsc-adds">
	    	<button id="add-subsc-menu">サブスクに含まれるメニューを追加する</button>
	    	<div id="created-tiem">
	    		<p>作成時間</p>
	    		<p>2020年5月30日23:59</p>
	    	</div>
	    	<button id="add-new-menu">新規メニューを登録する</button>
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
