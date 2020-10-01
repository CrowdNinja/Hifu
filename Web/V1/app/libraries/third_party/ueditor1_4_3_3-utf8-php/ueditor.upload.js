	//author LAEL
    //实例化编辑器
    var o_ueditorupload = UE.getEditor('j_ueditorupload', {
    	autoHeightEnabled: false
    });
    o_ueditorupload.ready(function() {    
		o_ueditorupload.hide(); //隐藏编辑器
		
		//监听图片上传
		o_ueditorupload.addListener('beforeInsertImage', function(t, arg) {
			//alert('这是图片地址：' + arg[0].src);
			if(upfile_multi == '0'){
				$(upfile_target).val(arg[0].src); 
				$(upfile_target).next().find('img').attr('src', arg[0].src);
			}else{
				if(upfile_conr){
					var is_upfile_uplink = false;
					if($(upfile_target).next().is('textarea') && $(upfile_target).next().css('display') == 'none')is_upfile_uplink = true;		
					for(var i in arg){
						if($(upfile_target).appendarray(arg[i].src, "\n")){
							var html = upfile_imgthumb;
							html = html.replace(/#upfile_uplink/gi, is_upfile_uplink ? upfile_uplink : '');
							html = html.replace(/#src/gi, arg[i].src);
							if(typeof upfile_target == 'string'){
								html = html.replace(/#target/gi, upfile_target);
							}else{
								html = html.replace(/ data-target="#target"/gi, '');
							}
							html = html.replace(/#multi/gi, upfile_multi);
							$(upfile_conr).append(html);
							if(is_upfile_uplink){
								$(upfile_target).next().val($(upfile_target).next().val() + "\n");
							}
						}
					}
					upfileEvent();
				}else if(upfile_btn){
					var oldsrc = $(upfile_btn).data('src') || $(upfile_btn).attr('src');
					if(oldsrc && $(upfile_target).replacearray(oldsrc, arg[0].src, "\n")){
						$(upfile_btn).parents('.upfile_imgthumb').eq(0).find('.upfile_imgcaption a').data('src', arg[0].src);
						$(upfile_btn).parents('.upfile_imgthumb').eq(0).find('img').attr('src', arg[0].src);
					}
				}
			}
		});
		
		/* 文件上传监听 ueditor1_4_3_3-utf8-php\dialogs\attachment\attachment.js editor.fireEvent('afterUpfile', list);
		 */
		o_ueditorupload.addListener('afterUpfile', function(t, arg) {
			if(upfile_multi == '0'){
				$(upfile_target).val(arg[0].url); 
				$(upfile_target).next().find('.upfile_link').html('<a href="' + arg[0].url + '" target="_blank">' + arg[0].url + '</a>');
			}else{
				if(upfile_conr){			
					for(var i in arg){ 
						if($(upfile_target).appendarray(arg[i].url, "\n")){
							var html = upfile_filediv;
							html = html.replace(/#src/gi, arg[i].url);
							if(typeof upfile_target == 'string'){
								html = html.replace(/#target/gi, upfile_target);
							}else{
								html = html.replace(/ data-target="#target"/gi, '');
							}
							html = html.replace(/#multi/gi, upfile_multi);
							$(upfile_conr).append(html);
						}
					}
					upfileEvent();
				}else if(upfile_btn){
					var oldsrc = $(upfile_btn).data('src');
					if(oldsrc && $(upfile_target).replacearray(oldsrc, arg[0].url, "\n")){
						$(upfile_btn).data('src', arg[0].url);
						$(upfile_btn).prev().html(arg[0].url);
					}
				}
			}
		});
    });
    
    //弹出图片上传的对话框    
    function upImage() {
    	var myImage = o_ueditorupload.getDialog("insertimage");
    	myImage.open();
    }
    //弹出文件上传的对话框    
    function upFiles() {
    	var myFiles = o_ueditorupload.getDialog("attachment");
    	myFiles.open();
    }
	var upfile_btn = null;
	var upfile_type = 'imgthumb';//filediv
	var upfile_conr = '';
	var upfile_target = '';
	var upfile_multi = '0';
	var upfile_uplink = '<input type="text" class="input-uplink" value="" data-target="#target" placeholder="图片链接" />';
	var upfile_imgthumb = '<div class="upfile_imgthumb">\
<img src="#src" data-default="/style/xin_inselimg.png" class="btn-prefile" data-target="#target" data-multi="#multi">\
<div class="upfile_imgcaption">\
#upfile_uplink\
<a href="javascript:;" data-src="#src" data-target="#target" data-multi="#multi" class="btn btn-primary btn-xs btn-upfile">上传</a> \
<a href="javascript:;" data-src="#src" data-target="#target" data-multi="#multi" class="btn btn-default btn-xs btn-upremove">删除</a>\
</div>\
</div>';
	var upfile_filediv = '<div class="upfile_filediv">\
<div class="upfile_filecaption">\
<span class="upfile_link"><a href="#src" target="_blank">#src</a></span>\
<a href="javascript:;" data-type="filediv" data-src="#src" data-target="#target" data-multi="#multi" class="btn btn-primary btn-xs btn-upfile">上传</a> \
<a href="javascript:;" data-type="filediv" data-src="#src" data-target="#target" data-multi="#multi" class="btn btn-default btn-xs btn-upremove">删除</a>\
</div>\
</div>';
	$(function(){
		upfileEvent();
	});
	function upfileEvent(){
		$('.btn-prefile').unbind('click').click(function(){
			//window.open($(this).attr('src'));
		});
		$('.btn-upfile').unbind('click').click(function(){
			upfile_btn = this;
			upfile_type = $(this).data('type') ? $(this).data('type') : 'imgthumb';
			upfile_conr = $(this).data('conr');
			upfile_target = $(this).data('target') || $(this).parents('.form-group').eq(0).find('input[type=hidden]').eq(0);
			if($(upfile_target).length < 1)upfile_target = $(this).parents('.form-group').eq(0).find('textarea:hidden').eq(0);
			upfile_multi = $(this).data('multi') || 0; 
			upfile_type == 'imgthumb' ? upImage() : upFiles();
		});
		$('.btn-upremove').unbind('click').click(function(){
			upfile_target = $(this).data('target') || $(this).parents('.form-group').eq(0).find('input[type=hidden]').eq(0);
			if($(upfile_target).length < 1)upfile_target = $(this).parents('.form-group').eq(0).find('textarea:hidden').eq(0);  
			upfile_type = $(this).data('type') ? $(this).data('type') : 'imgthumb';  
			if($(this).data('multi') == '1'){
				if(upfile_type == 'imgthumb'){
					try{
						var uplink_target = $(upfile_target).next();
						var uplink_arr = $(uplink_target).val().split("\n");
						var uplink_index = $(this).parents('.form-group').eq(0).find('.btn-upremove').index($(this));
						uplink_arr.splice(uplink_index, 1);
						$(uplink_target).val(uplink_arr.join("\n"));
					}catch(e){}
				}
				$(upfile_target).deletearray($(this).data('src'), "\n");
				$(this).parents('.upfile_' + upfile_type).eq(0).remove();
			}else{
				$(upfile_target).val('');
				if(upfile_type == 'imgthumb')$(this).parent().parent().find('img').attr('src', $(this).parent().parent().find('img').data('default'));
				if(upfile_type == 'filediv')$(this).parent().find('.upfile_link').html('');
			}
		});
		$('.input-uplink').unbind('change').change(function(){
			upfile_target = $(this).data('target') || $(this).parents('.form-group').eq(0).find('input[type=hidden]').eq(0);
			if($(upfile_target).length < 1)upfile_target = $(this).parents('.form-group').eq(0).find('textarea:hidden').eq(0);
			var uplink_target = $(upfile_target).next();
			var uplink_arr = $(uplink_target).val().split("\n");
			var uplink_index = $(this).parents('.form-group').eq(0).find('.input-uplink').index($(this));
			for(var i = uplink_arr.length; i <= uplink_index; i ++){
				uplink_arr.push('');
			}
			uplink_arr[uplink_index] = $(this).val();
			$(uplink_target).val(uplink_arr.join("\n"));
		});
		$('.btn-prefile').viewer('destroy').viewer({});
		$('.upfile_imgthumb').off('click', '.viewer-canvas').on('click', '.viewer-canvas', function(e){
			var _con = $(this).find('img');
			if(_con && !_con.is(e.target) && _con.has(e.target).length === 0){
				$('.btn-prefile').viewer('hide');
			}
		});
	}
