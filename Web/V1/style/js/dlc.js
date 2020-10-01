var Dlc = {
	service : {},
	ui : {},
	model : {},
	router : {},
	config : {},
    animate : {}
};
/**
 * 配置集合
 * @attribute  
 * @type {Number}
 */
Dlc.config = {
	router : {
		/**路由跳转延迟时间
		 * @attribute  router.delay
		 * @type {Number}
		 */
		delay : 1200
	},
	ui : {
		/**提示显示时间
		 * @attribute  ui.delay
		 * @type {Number}
		 */
		delay : 2000
	}
};

/**
 * 路由跳转
 * @param  {string} [url]  地址
 */
Dlc.router.go = function(url) {
	if (!url) {
		return false;
	}
    else if(url == 'refresh'){
        window.location.href = window.location.href;
    }
    else{
        window.location.href = url;
    }
};

/**
 * 路由延时跳转
 * @param  {string} [url]  地址
 * @param  {string} [delay]  延时时间
 */
Dlc.router.delay = function(url, delay) {
	if (!url) {
		return false;
	}
	delay = typeof delay === 'undefined' ? Dlc.config.router.delay : delay;
	return setTimeout(function() {
		Dlc.router.go(url);
	}, delay);
};

/**
 * 提示css
 */
Dlc.ui.css = function() {
	this._css = "ui-tip";
	return this;
};

/**
 * 提示框
 @param  {string} [msg]  消息内容
 * @param  {string} [type] 消息类型
 * @return {string}      渲染后的html
 */
Dlc.ui.css.prototype.tip = function(msg, type) {
	var self = this;
	var typeCss = '';
	switch (type) {
	case '':
	case 'alert':
		break;
	case 'error':
		typeCss = ' ui-tip-error';
		break;
	case 'success':
		typeCss = ' ui-tip-success';
		break;
	case 'info':
		typeCss = ' ui-tip-info';
		break;
	}
	return '<div class="' + self._css + typeCss + '">'
			+ '<button type="button" class="close">&times;</button>' + msg
			+ '</div>';
};

/**
 * 显示提示框
 @param  {string} [msg]  消息内容
 * @param  {string} [type] 消息类型
 * @param  {string} [delay] 延迟时间
 */
Dlc.ui.css.prototype.show = function(msg, type, delay) {
	var self = this;
	var $alert;
	$('.' + self._css).remove();
	$alert = $(self.tip(msg, type)).prependTo("body").fadeIn(200);
	$alert.close = function() {
		$alert.fadeOut(200);
		setTimeout(function() {
			$alert.remove();
		}, 200);
	};
	$alert.find('.close').on('click', function() {
		$alert.close();
	});
	$alert.on('click', function() {
		$alert.close();
	});
	delay = (delay || 0);
	if (delay) {
		setTimeout(function() {
			$alert.close();
		}, delay);
	}
	return $alert;
};
/**
 * 动态更新notice
 * @param count
 * @param supp
 * @param staff
 */
Dlc.ui.css.prototype.notice = function(count, supp, staff){
    var notice_count = $('.notice_count');
    var notice_supp = $('.notice_supp');
    var notice_staff = $('.notice_staff');

    if(!count) {
        notice_count.hide();
    }
    else{
        notice_count.show();
        notice_count.text(count);
    }
    if(supp) {
        notice_supp.text(supp);
        $('#supplier').show();
    }
    else $('#supplier').hide();
    if(staff) {
        notice_staff.text(staff);
        $('#staff').show();
    }
    else $('#staff').hide();

}
 
/**
 * 与服务器交互集合
 */
Dlc.model.service = {};

/**
 * 提交数据处理
 */
Dlc.model.service.post = function(fn) {
	var o = this;
	o.finish = function(response) {
		if(fn)
		{
		  fn(response);
		  return response;
		}
         
		new Dlc.ui.css().show(response.msg, 'success', Dlc.config.ui.delay);
	   Dlc.router.delay(response.redirect);
        if(response.pic){
            $('#img').attr("src",response.pic);
        }
	};

	o.fail = function(response) {
		if(fn)
		{
		  fn(response);
		  return response;
		}
		new Dlc.ui.css().show(response.msg, 'alert', Dlc.config.ui.delay);
		Dlc.router.delay(response.redirect);
	};
	
	
};
/**
 * 提交数据
 *  @param  {string} [url] 提交地址
 *  @param  {string} [data] 提交数据
 */
Dlc.model.service.post.prototype.action = function(url, data) {
	var o = this;
	var defaultsResponse = {
		status : false,
		msg : '',
		redirect : ''
	};
 
 
	return $.ajax({
		type : 'post',
		dataType : 'json',
		url : url,
		data : data,
		success : function(response) {
			if (typeof response === 'object') {
				response = $.extend(defaultsResponse, response);
				//  alert(JSON.stringify(response));
				if (response.status||response.code==1) {
					o.finish(response);
					return;
				} else {
					response = {
						msg : response.msg,
						redirect : response.redirect,
						status : false
					};
				}
				o.fail(response);
				return;
			}
		},
		error : function(XMLHttpRequest, textStatus, errorThrown) {
			 // alert(JSON.stringify(XMLHttpRequest));
			response = {
				msg : '未知错误.',
				status : false
			};
			o.fail(response);
		}
	});
};
/**
 * 提交数据对外接口
 *  @param  {string} [url] 提交地址
 *  @param  {string} [data] 提交数据
 */
Dlc.service.post = function(url, data,fn) {
          
	return new Dlc.model.service.post(fn).action(url, data);
 
};