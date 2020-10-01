//jquery插件
//author LAEL http://www.baigu365.com
(function($){
		//获取光标位置
		$.fn.getpos = function(){
			var thisDom = $(this).get(0);
			var index = 0; 
			if (document.selection) {// IE Support 
				thisDom.focus(); 
				var Sel = document.selection.createRange(); 
				if (thisDom.nodeName === 'TEXTAREA') {//textarea 
					var Sel2 = Sel.duplicate(); 
					Sel2.moveToElementText(thisDom); 
					var index = -1; 
					while (Sel2.inRange(Sel)) { 
						Sel2.moveStart('character'); 
						index++; 
					}; 
				} else if (thisDom.nodeName === 'INPUT') {// input 
					Sel.moveStart('character', -thisDom.value.length); 
					index = Sel.text.length; 
				} 
			} else if (thisDom.selectionStart || thisDom.selectionStart == '0') { // Firefox support 
				index = thisDom.selectionStart; 
			} 
			return (index); 
		}
		//设置光标位置
		$.fn.setpos = function(posindex){
			
			var thisDom = $(this).get(0);
			if (document.selection) {// IE Support
				var r = thisDom.createTextRange(); 
				r.collapse(true); 
				r.moveStart('character',posindex); 
				r.select(); 
			}else{
				thisDom.selectionStart = posindex;
				thisDom.selectionEnd = posindex;
			}
	   }
		//选择文本
	   $.fn.selecttext = function(start,len){
			var thisDom = $(this).get(0);
			if (document.selection) {// IE Support
				var r = thisDom.createTextRange(); 
				r.collapse(true); 
				r.moveStart('character',start); 
				r.moveEnd('character',len); 
				r.select(); 
			}else{
				thisDom.selectionStart = start;
				thisDom.selectionEnd = start+len;
			}
	   }
		//在光标位置插入一段文本
	   $.fn.insertforpos = function(text){
			var valstr = $(this).val();
			var pos = $(this).getpos();
			if(valstr.length >= pos){
				var prestr = valstr.substring(0,pos);
				var sufstr = valstr.substring(pos);
				$(this).val(prestr+text+sufstr);
			}
	   }
		/*
		* 删除光标前面(-)或者后面(+)的n个字符  123*45678
		*/
        $.fn.delforpos = function(n){
            var pos = $(this).getpos();
			if(pos == 0)return;
            var valstr = $(this).val();
            //大于0则删除后面，小于0则删除前面
            $(this).val(n > 0 ? valstr.slice(0, pos) + valstr.slice(pos + n) : valstr.slice(0, pos - -1 * n) + valstr.slice(pos));
        }
		
		//$.inArray区分类型
		//$.findarray不区分
		$.findarray = function(v, arr, p){
			if(typeof(arr) == 'string')arr = arr.split(p || ',');
			for(var i = 0; i < arr.length; i ++){
				if(v == arr[i])return i;
			}
			return -1;
		}
		//$.unique顺序可能不同
		//$.uniquearray不改变顺序
		$.uniquearray = function(arr, down){
			var temp = [];
			if(down){
				for(var i = arr.length - 1; i >=0; i --){
					if($.findarray(arr[i], temp) == -1)temp.push(arr[i]);
				}
				var _temp = [];
				for(var i = temp.length - 1; i >=0; i --){
					_temp.push(temp[i]);
				}
				temp = _temp;
			}else{
				for(var i = 0; i < arr.length; i ++){
					if($.findarray(arr[i], temp) == -1)temp.push(arr[i]);
				}
			}
			return temp;
		}
		//删除值
		$.fn.deletearray = function(v, p){
			p = p || ',';
			var varstr = $(this).val();
			if(varstr == '')return;
			var vararr = varstr.split(p);
			if($.findarray(v, vararr) == -1)return;
			var temp = [];
			for(var i = 0; i < vararr.length; i ++){
				if(vararr[i] != v)temp.push(vararr[i]);
			}
			if(temp.length == 0){
				$(this).val('');
				return;
			}
			temp = $.uniquearray(temp);
			$(this).val(temp.join(p));
		}
		//v值，p分隔符，d如果存在是否删除
		$.fn.appendarray = function(v, p, d, n){
			n = n || true;
			if(n && v == '')return;
			p = p || ',';
			var varstr = $(this).val();
			if(varstr == ''){
				$(this).val(v);
				return true;
			}
			var vararr = varstr.split(p);
			if($.findarray(v, vararr) != -1){
				if(d)$(this).deletearray(v, p);
				return;
			}
			vararr.push(v);
			vararr = $.uniquearray(vararr);
			$(this).val(vararr.join(p));
			return true;
		}
		//o原值,v新值，p分隔符，d如果存在是否删除
		$.fn.replacearray = function(o, v, p, d, n){
			n = n || true;
			if(n && v == '')return;
			p = p || ',';
			var varstr = $(this).val();
			if(varstr == ''){
				$(this).val(v);
				return true;
			}
			var vararr = varstr.split(p);
			if($.findarray(v, vararr) != -1){
				if(d)$(this).deletearray(v, p);
				return;
			}
			var idx = $.findarray(o, vararr);
			if(idx != -1){
				vararr[idx] = v;
				vararr = $.uniquearray(vararr);
				$(this).val(vararr.join(p));
				return true;
			}
			vararr.push(v);
			vararr = $.uniquearray(vararr);
			$(this).val(vararr.join(p));
			return true;
		}
		$.isarray = function(value){
			if (value instanceof Array ||
				(!(value instanceof Object) &&
					(Object.prototype.toString.call((value)) == '[object Array]') ||
					typeof value.length == 'number' &&
					typeof value.splice != 'undefined' &&
					typeof value.propertyIsEnumerable != 'undefined' &&
					!value.propertyIsEnumerable('splice'))) {
				return true;
			}
			return false;
		}
		$.fileext = function(file){
			var filename = file.replace(/.*(\/|\\)/, "");  
			return (/[.]/.exec(filename)) ? /[^.]+$/.exec(filename.toLowerCase()) : '';
		}
		$.filename = function(file){			 
    		return file.replace(/^.*\/([^\/\?]*).*$/, '$1'); 
		}
		//alert($.replaceURL('http://*.com?a=1&catid=2&b=3', 'catid', '99'));
		//alert($.replaceURL('http://*.com?a=1/catid=2/b=3', 'catid', '99'));
		//alert($.replaceURL('http://*.com/a=1/catid=2/b=3', 'catid', '99'));
		//alert($.replaceURL('http://*.com/a/1/catid/2/b/3', 'catid', '99'));
		$.replaceURL = function(url, name, val, fmt){
			url = url || location.href;
			//URL格式分隔符
			fmt = fmt || '?|&|=';
			if(!$.isarray(fmt))fmt = fmt.split('|');			
			
			//判断替换
			//判断替换
			var reg = new RegExp("(\\/)" + name + "=([^\\/=]*)(\\/|$)", "gi");
			url = url.replace(reg, val ? '$1' + name + '=' + val + '$3' : '$1');
			url = url.replace(/^(.*?)(\/)$/gi, '$1');
			
			var reg = new RegExp("(\\/)" + name + "\\/([^\\/=]*)(\\/|$)", "gi");
			url = url.replace(reg, val ? '$1' + name + '/' + val + '$3' : '$1');
			url = url.replace(/^(.*?)(\/)$/gi, '$1');			
			
			var reg = new RegExp("(\\?|&)" + name + "=([^&=]*)(&|$)", "gi");
			url = url.replace(reg, val ? '$1' + name + '=' + val + '$3' : '$1');
			url = url.replace(/^(.*?)(\?|&)$/gi, '$1');
			
			var reg = new RegExp("(\\?)" + name + "=([^\\/=]*)(\\/|$)", "gi");
			url = url.replace(reg, val ? '$1' + name + '=' + val + '$3' : '$1');
			url = url.replace(/^(.*?)(\/)$/gi, '$1');
			
			//判断新增
			if(val){
				if(url.indexOf(fmt[0]) == -1){
					if(url.indexOf(fmt[0] + name + fmt[2]) == -1 && url.indexOf(fmt[1] + name + fmt[2]) == -1){
						url += fmt[0] + name + fmt[2] + val;
					}
				}else{
					if(url.indexOf(fmt[0] + name + fmt[2]) == -1 && url.indexOf(fmt[1] + name + fmt[2]) == -1){
						url += fmt[1] + name + fmt[2] + val;
					}
				}
			}
			
			return url;
		}
		//url = location.href
		//sConr 包含搜索条件外部classname
		//sObj 搜索条件元素类型等
		//sJoin checkbox/select多选连接符
		//nParam 不要拼接location.href原来的GET参数
		//nkey 要排除的key
		$.searchURL = function(url, sConr, sObj, sJoin, nParam, nkey){
			url = url || location.href;
			sConr = sConr || '.form-search';
			sObj = sObj || 'input,select,textarea';
			sJoin = sJoin || ',';
			nkey = nkey || ['page'];
			//处理URL中的数据
			if(!nParam){
				var params = $.getUrlParams();
				for(var i in params){
					if($.findarray(i, nkey) != -1)continue;
					url = $.replaceURL(url, i, encodeURIComponent(params[i]));
				}
			}
			//处理搜索
			$(sConr).find(sObj).each(function(){
				if($(this).attr('type') == 'checkbox'){
					var ckvals = [];
					$(sConr + ' #' + $(this).attr('id')).each(function(){
						if($(this).is(':checked'))ckvals.push($(this).val());
					});
					if(ckvals.length > 0){
						url = $.replaceURL(url, $(this).attr('id'), encodeURIComponent(ckvals.join(sJoin)));
					}else{
						url = $.replaceURL(url, $(this).attr('id'));
					}
				}else{
					var objval = $(this).val();
					if($.isArray(objval))objval = objval.join(sJoin);
					url = $.replaceURL(url, $(this).attr('id'), encodeURIComponent(objval));
				}
			});
			return url;
		}
		//checkbox选中值
		$.selectCK = function(sck, sjoin){
			var ckvals = [];
			$(sck).each(function(){
				if($(this).is(':checked'))ckvals.push($(this).val());
			});
			if(!ckvals.length)return false;
			return ckvals.join(sjoin);	
		}
		$.sclip = function(str, s, l, x){
			x = x || '...';
			if(str.length <= l)return str;//不用截取
			var t = str.substring(s, l);
			if(t == str)return t;
			if(str.indexOf(t) !== 0)t = x + t;//有截前面
			if(str.indexOf(t) + t.length == str.length)return t;//后面没有截
			return t + x;
		}
		$.download = function(url, data, method){
			// 获取url和data
			if (url) {
				// 把参数组装成 form的  input
				var inputs = '';
				if(data){
					for(var k in data){
						inputs += '<input type="hidden" name="' + k + '" value="' + data[k] + '" />';
					};
				}
				// request发送请求
				$('<form action="' + url + '" method="' + (method || 'get') + '">' + inputs + '</form>').appendTo('body').submit().remove();
			}
    	}
		$.number = function(num, def){
			def = def || 0;
			if(typeof(num) == 'undefined')return def;
			num = Number(num);
			if(isNaN(num))num = def;
			return num * 1;
		}
		//支持同名表单自动转数组
		$.fn.serializeArrs = function()    
		{    
		   var o = {};    
		   var a = this.serializeArray(); 
		   $.each(a, function() {    

			       if (typeof(o[this.name]) != 'undefined') {//存在同名表单转为数组
					   var temp = o[this.name];
					   o[this.name] = [];
					   if($.isarray(temp)){
						   for(var i in temp)
						   	   o[this.name].push(temp[i]);
					   } else {
						   o[this.name].push(temp);
					   }
					   o[this.name].push(this.value || '');
				   } else {
				   	   o[this.name] = this.value || '';    
				   }
   
		   });
		   return o;    
		}
		$.getObjectURL = function (file) {
			var url = null;
			if (window.createObjectURL != undefined) {
				url = window.createObjectURL(file)
			} else if (window.URL != undefined) {
				url = window.URL.createObjectURL(file)
			} else if (window.webkitURL != undefined) {
				url = window.webkitURL.createObjectURL(file)
			}
			return url
		}
		$.getUrlParam = function (name, explode, url) {
			var param = window.location.search.substr(1);
			if(url){
				if(explode){
					param = url.substr(url.indexOf(explode) + 1);	
				}else{
					param = url.substr(url.indexOf('?') + 1);	
				}
			}else{
				if(explode){
					param = window.location.href.substr(window.location.href.indexOf(explode) + 1);	
				}
			}
			var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
			var r = param.match(reg);
			if (r != null) return unescape(r[2]); return '';
		}
		$.getUrlParams = function (url){
			var args = new Object();
			url = url || location.href;
			var pos = url.indexOf('?');
			var query = url.substring(pos + 1);
			query = query.replace(/&amp;/ig, '#amp;', query)
			var pairs = query.split("&");
			for (var i = 0; i < pairs.length; i++) {
				var pos = pairs[i].indexOf('=');
				if (pos == -1) continue;
				var argname = pairs[i].substring(0, pos);
				var value = pairs[i].substring(pos + 1);
				value = value.replace(/#amp;/ig, '&amp;', value);
				args[argname] = unescape(value)
			}
			return args
		}
		//图片预览
		$.fn.extend({
			uploadPreview: function (opts) {
				var _self = this,
					_this = $(this);
				opts = jQuery.extend({
					Img: "#ImgPr",
					Width: 100,
					Height: 100,
					ImgType: ["gif", "jpeg", "jpg", "bmp", "png"],
					Callback: function () {}
				}, opts || {});
				_self.getObjectURL = function (file) {
					var url = null;
					if (window.createObjectURL != undefined) {
						url = window.createObjectURL(file)
					} else if (window.URL != undefined) {
						url = window.URL.createObjectURL(file)
					} else if (window.webkitURL != undefined) {
						url = window.webkitURL.createObjectURL(file)
					}
					return url
				};
				_this.change(function () {
					if (this.value) {
						if (!RegExp("\.(" + opts.ImgType.join("|") + ")$", "i").test(this.value.toLowerCase())) {
							alert("文件类型必须是：" + opts.ImgType.join("，"));
							this.value = "";
							return false
						}
						if (/msie/.test(navigator.userAgent.toLowerCase())) {
							try {
								$(opts.Img).attr('src', _self.getObjectURL(this.files[0]))
							} catch (e) {
								var src = "";
								var obj = $(opts.Img);
								var div = obj.parent("div")[0];
								_self.select();
								if (top != self) {
									window.parent.document.body.focus()
								} else {
									_self.blur()
								}
								src = document.selection.createRange().text;
								document.selection.empty();
								obj.hide();
								obj.parent("div").css({
									'filter': 'progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale)',
									'width': opts.Width + 'px',
									'height': opts.Height + 'px'
								});
								div.filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = src
							}
						} else {
							$(opts.Img).attr('src', _self.getObjectURL(this.files[0]))
						}
						$(opts.Img).parent().show();	
						opts.Callback()
					}else{
						$(opts.Img).parent().hide();	
					}
				})
			},
			dragDiv: function() {
				dragPanelMove($(this), $(this));				
				function dragPanelMove(downDiv,moveDiv){
					$(downDiv).mousedown(function (e) {
							var isMove = true;
							var div_x = e.clientX;
							var div_y = e.clientY;
							var div_l = parseInt($(moveDiv).css('left'));
							var div_t = parseInt($(moveDiv).css('top'));
							$(document).mousemove(function (e) {
								if (isMove) {
									var obj = $(moveDiv);
									obj.css({"left":div_l + e.clientX - div_x, "top":div_t + e.clientY - div_y});
									e.preventDefault();
									e.stopPropagation();
								}
							}).mouseup(
								function () {
								isMove = false;
							});
					});
		
				}
			}
		});		
})($);