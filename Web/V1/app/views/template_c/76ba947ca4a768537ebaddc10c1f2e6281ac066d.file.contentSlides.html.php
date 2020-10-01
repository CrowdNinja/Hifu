<?php /* Smarty version Smarty-3.1.19, created on 2020-06-07 16:50:17
         compiled from "C:\xampp\htdocs\beauty-server\app\views\staff\contentSlides.html" */ ?>
<?php /*%%SmartyHeaderCode:15751481405edcfea9261103-12770985%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '76ba947ca4a768537ebaddc10c1f2e6281ac066d' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beauty-server\\app\\views\\staff\\contentSlides.html',
      1 => 1591541006,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15751481405edcfea9261103-12770985',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5edcfea92899d1_19072336',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5edcfea92899d1_19072336')) {function content_5edcfea92899d1_19072336($_smarty_tpl) {?>
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
