<?php /* Smarty version Smarty-3.1.19, created on 2020-06-20 03:18:21
         compiled from "C:\xampp\htdocs\beauty-server\app\views\media\index.html" */ ?>
<?php /*%%SmartyHeaderCode:329434415ee0095c971495-76895647%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b12c9319852c830e1a03b31dda7327a91794ddbb' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beauty-server\\app\\views\\media\\index.html',
      1 => 1591874478,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '329434415ee0095c971495-76895647',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5ee0095c9a68e6_82076549',
  'variables' => 
  array (
    'slide_images' => 0,
    'slide_image' => 0,
    'tutorial_videos' => 0,
    'tutorial_video' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ee0095c9a68e6_82076549')) {function content_5ee0095c9a68e6_82076549($_smarty_tpl) {?>
<title><?php echo translate('コンテンツ管理');?>
 - <?php echo translate('コンテンツ管理');?>
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
	    <div class="subsc-image-box" id="slide-images">
			<?php  $_smarty_tpl->tpl_vars['slide_image'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['slide_image']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['slide_images']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['slide_image']->key => $_smarty_tpl->tpl_vars['slide_image']->value) {
$_smarty_tpl->tpl_vars['slide_image']->_loop = true;
?>
			<div class='subsc-image-p'><img src="<?php echo $_smarty_tpl->tpl_vars['slide_image']->value['url'];?>
"><button class="delete-btn" data-id="<?php echo $_smarty_tpl->tpl_vars['slide_image']->value['id'];?>
">-</button></div>
			<?php } ?>
	    </div>
    </div>
	    
    <div class="subsc-image-select-box">
		<p>ファイルをドロップして画像を<br/>アップロード</p>
		<input type="file" name="subsc-image-file" value="ファイルを選択" class="sabsc-image-btn" id="subsc-image-file">
		<label for="subsc-image-file">ファイルを選択</label>
	</div>
    <div class="slide-images">
    	<p>使用方法解説動画管理</p>
	    <div class="subsc-image-box subsc-video-box" id="slide-videos">
			<?php  $_smarty_tpl->tpl_vars['tutorial_video'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tutorial_video']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['tutorial_videos']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['tutorial_video']->key => $_smarty_tpl->tpl_vars['tutorial_video']->value) {
$_smarty_tpl->tpl_vars['tutorial_video']->_loop = true;
?>
				<div class="subsc-image-p">
					<video width="100%" height="100%" controls>
						<source src="<?php echo $_smarty_tpl->tpl_vars['tutorial_video']->value['url'];?>
" type="video/mp4">
						<source src="<?php echo $_smarty_tpl->tpl_vars['tutorial_video']->value['url'];?>
" type="video/ogg">
						Your browser does not support the video tag.
					</video>
					<button data-id="<?php echo $_smarty_tpl->tpl_vars['tutorial_video']->value['id'];?>
" class="delete-btn">-</button>
				</div>
			<?php } ?>
	    </div>
    </div>
	    
    <div class="subsc-image-select-box">
		<p>ファイルをドロップして画像を<br/>アップロード</p>
		<input type="file" name="subsc-video-file" value="ファイルを選択" class="sabsc-video-btn" id="subsc-video-file">
		<label for="subsc-video-file">ファイルを選択</label>
	</div>
</div>

<script type="text/javascript">
	$(document).on('change', '.sabsc-image-btn', async function(event) {
	    var files, image, reader, that;
	    files = event.target.files;
	    image = files[0];
	    reader = new FileReader();
	    that = this;
	    reader.onload = function(file) {
	    //   var img;
	    //   img = new Image();
	    //   img.src = file.target.result;
		//   var div = $("<div class='subsc-image-p'></div>");
		//   div.html(img);
		//   div.append('<button class="delete-btn">-</button>');
		//   $('#slide-images').append(div);
		};		
		reader.readAsDataURL(image);
		
		var result = await uploadMedia(image, 0);
		result = JSON.parse(result);
		if (result.status == 1) {
			var div = $("<div class='subsc-image-p'></div>");
			var img = $("<img src='"+result.url+"'/>");
			div.html(img);
			div.append('<button class="delete-btn" data-id="'+result.id+'"">-</button>');
			$('#slide-images').append(div);
		}
	});
	  
	async function uploadMedia(media, type) {
		const data = new FormData();
		data.append('media', media);
		data.append('type', type);
		return $.ajax({
			type: "POST",
			url: '/admin_media/uploadMedia',
			data: data,
            contentType: false,
            processData: false,
		}).done(
			function(e) {
				return e
			})
	}

	$(document).on('change', '.sabsc-video-btn', async function(event) {
	    var files, video, reader, that;
	    files = event.target.files;
	    video = files[0];
	    reader = new FileReader();
	    that = this;
	    reader.onload = function(file) {
	    //   var img;
	    //   img =  $("<div class='subsc-image-p'></div>");
	    //   img.src = file.target.result;
		//   var div = $('<div class="subsc-image-p"><video width="320" height="240" controls><source src="'+file.target.result+'" type="video/mp4"><source src="<?php echo $_smarty_tpl->tpl_vars['tutorial_video']->value;?>
" type="video/ogg"></video><button class="delete-btn">-</button></div>');
		//   div.html(img);
		//   div.append('<button class="delete-btn">-</button>');
		//   $('#slide-images').append(div);
		};		
		reader.readAsDataURL(video);
		
		var result = await uploadMedia(video, 1);
		result = JSON.parse(result);
		if (result.status == 1) {
			// var div = $("<div class='subsc-image-p'></div>");
			var img = $('<div class="subsc-image-p"><video width="100%" height="100%" controls><source src="'+result.url+'" type="video/mp4"><source src="'+result.url+'" type="video/ogg"></video><button class="delete-btn" data-id="'+result.id+'">-</button></div>');
			// div.html(img);
			// div.append('<button class="delete-btn">-</button>');
			$('#slide-videos').append(img);
		}
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
		var id = $(this).data('id');
		var self = $(this)
		$.ajax({
			type: "POST",
			url: '/admin_media/deleteMedia',
			data: {'id': id},
		}).done(
			function(e) {
				e = JSON.parse(e);
				if (e.status == 1) {
					self.parent().remove()
				}
			}
		)
		// $(this).parent().remove()
	});
</script>
    
 

<?php }} ?>
