<?php /* Smarty version Smarty-3.1.19, created on 2020-06-07 16:44:20
         compiled from "C:\xampp\htdocs\beauty-server\app\views\staff\termRegist.html" */ ?>
<?php /*%%SmartyHeaderCode:21235308215edcfd44b99fc2-61248232%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '97250c91d110c630761bed88febae1822ce7c3e0' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beauty-server\\app\\views\\staff\\termRegist.html',
      1 => 1591541006,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21235308215edcfd44b99fc2-61248232',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5edcfd44bdf524_99535202',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5edcfd44bdf524_99535202')) {function content_5edcfd44bdf524_99535202($_smarty_tpl) {?>
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
    <h3>サブスク約款の新規追加</h3>
    <div class="subsc-menu" id="term">
    	<div class="subsc-name">
	    	<p>約款のタイトル</p>
	    	<input type="text" name="term-title" class="text-input" placeholder="約款のタイトルを入力してください">
	    </div>
    	<div class="subsc-item-content">
    		<div class="subsc-item-content-textarea">
    			<div>
	    			<p>約款の内容文</p>
	    			<textarea>約款の内容文を入力してください</textarea>
	    		</div>
    		</div>
    		<div class="subsc-item-content-textarea">
    			<div>
	    			<p>適応するメニューを選択</p>
	    			<input type="text" name="term-select-menu" class="text-input" placeholder="検索">
	    		</div>
    		</div>
    		<div class="term-search-result">
				<ul class="term-search-items">
					<li>メニュー名メニュー名メニュー名メニュー名メニュー名メニュー名</li>
					<li>メニュー名メニュー名メニュー名メニュー名メニュー名メニュー名</li>
					<li>メニュー名メニュー名メニュー名メニュー名メニュー名メニュー名</li>
					<li>メニュー名メニュー名メニュー名メニュー名メニュー名メニュー名</li>
					<li>メニュー名メニュー名メニュー名メニュー名メニュー名メニュー名</li>
					<li>メニュー名メニュー名メニュー名メニュー名メニュー名メニュー名</li>
				</ul>
    			<ul class="term-search-selected-items">
					<li>メニュー名メニュー名メニュー名メニュー名メニュー名メニュー名<button class="delete-btn">-</button></li>
					<li>メニュー名メニュー名メニュー名メニュー名メニュー名メニュー名<button class="delete-btn">-</button></li>
					<li>メニュー名メニュー名メニュー名メニュー名メニュー名メニュー名<button class="delete-btn">-</button></li>
					<li>メニュー名メニュー名メニュー名メニュー名メニュー名メニュー名<button class="delete-btn">-</button></li>
					<li>メニュー名メニュー名メニュー名メニュー名メニュー名メニュー名<button class="delete-btn">-</button></li>
					<li>メニュー名メニュー名メニュー名メニュー名メニュー名メニュー名<button class="delete-btn">-</button></li>
				</ul>
    		</div>
    	</div>
	    <div class="subsc-adds">
	    	<button id="add-new-menu">新規約款を登録する</button>
	    	<div id="created-tiem">
	    		<p>作成時間</p>
	    		<p>2020年5月30日23:59</p>
	    	</div>
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

	$('.term-search-items li').click(function(){
		$('.term-search-selected-items').append('<li>'+ $(this).text() + '<button class="delete-btn">-</button>' +'</li>')
	});
	$('.term-search-selected-items li').hover(function () {
          $('button', this).show()
       }, 
		
       function () {
          $('button', this).hide()
       });
	$('.term-search-selected-items li button').click(function(){
		$(this).parent().remove();
	});

</script>
    
 

<?php }} ?>
