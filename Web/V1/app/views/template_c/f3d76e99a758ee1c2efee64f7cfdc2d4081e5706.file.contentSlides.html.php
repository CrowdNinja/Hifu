<?php /* Smarty version Smarty-3.1.19, created on 2020-06-07 20:20:12
         compiled from "C:\xampp\htdocs\beauty-server\app\views\new_admins\contentSlides.html" */ ?>
<?php /*%%SmartyHeaderCode:10097932635edd2fdca05ad7-47717222%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f3d76e99a758ee1c2efee64f7cfdc2d4081e5706' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beauty-server\\app\\views\\new_admins\\contentSlides.html',
      1 => 1591446628,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10097932635edd2fdca05ad7-47717222',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5edd2fdca30919_48356250',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5edd2fdca30919_48356250')) {function content_5edd2fdca30919_48356250($_smarty_tpl) {?>
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

<div class="row" id="contents">
	<div class="col-xs-12">
    <h3>コンテンツ管理</h3>
    <div class="slide-images">
    	<p>スライダー画像</p>
	    <div class="subsc-image-box">
	    	<div class="subsc-image-p"><img src=""><button class="delete-btn">-</button></div>
	    	<div class="subsc-image-p"><img src=""><button class="delete-btn">-</button></div>
	    	<div class="subsc-image-p"><img src=""><button class="delete-btn">-</button></div>
	    </div>
    </div>
	    
    <div class="subsc-image-select-box">
		<p>ファイルをドロップして画像を<br/>アップロード</p>
		<input type="file" name="subsc-image-file" value="ファイルを選択" class="sabsc-image-btn" id="subsc-image-file">
		<label for="subsc-image-file">ファイルを選択</label>
	</div>
    <div class="slide-images" id="slide-videos">
    	<p>使用方法解説動画管理</p>
	    <div class="subsc-image-box">
	    	<div class="subsc-image-p"><img src=""><button class="delete-btn">-</button></div>
	    	<div class="subsc-image-p"><img src=""><button class="delete-btn">-</button></div>
	    	<div class="subsc-image-p"><img src=""><button class="delete-btn">-</button></div>
	    </div>
    </div>
	    
    <div class="subsc-image-select-box">
		<p>ファイルをドロップして画像を<br/>アップロード</p>
		<input type="file" name="subsc-video-file" value="ファイルを選択" class="sabsc-image-btn" id="subsc-video-file">
		<label for="subsc-video-file">ファイルを選択</label>
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

	$('.subsc-image-p').hover(function() {
		$('.delete-btn', this).show()
	});
	$('.subsc-image-p').mouseout(function() {
		$('.delete-btn', this).hide()
	});
	$('.delete-btn').hover(function() {
		$(this).show()
	});
	$('.delete-btn').mouseout(function() {
		$(this).hide()
	});
	$('.delete-btn').click(function(){
		$(this).parent().remove()
	});
</script>
    
 

<?php }} ?>
