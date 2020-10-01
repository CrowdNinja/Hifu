$(function(){
	function categorys_path(child, dataVal, selecteds){
		for(var i in child){
			if($.findarray(child[i][dataVal], selecteds) != -1){
				if(typeof child[i]['child'] == 'undefined')return (child[i]['path'] + '').split(',');
				var temp = categorys_path(child[i]['child'], dataVal, selecteds);
				if(temp.length == 0)return (child[i]['path'] + '').split(',');
				return temp;
			}
			if(typeof child[i]['child'] != 'undefined'){
				var temp = categorys_path(child[i]['child'], dataVal, selecteds);
				if(temp.length > 0)return temp;
			}
		}
		return [];
	}
	function categorys_data(res, key, block, path){
		var path = (path + '').split(',');
		var result = [res[path[0]][key]];
		if(typeof res[path[0]]['child'] != 'undefined'){
			var temp = res[path[0]]['child'];
			for(i = 1; i < path.length; i ++){
				result.push(temp[path[i]][key]);
				if(typeof temp[path[i]]['child'] != 'undefined'){
					temp = temp[path[i]]['child'];
				}else{
					break;
				}
			}
		}
		if(block === '')return result[result.length - 1];
		return result.join(block);
	}
	$('.categorys-selector .categorys-text').click(function(){
		var that = $(this);
		var dataList = that.parent().attr('data-datalist');
		var dataVal = that.parent().attr('data-dataval');
		var dataView = that.parent().attr('data-dataview');
		var dataBlock = that.parent().attr('data-datablock');
		var viewBlock = that.parent().attr('data-viewblock');
		if(typeof viewBlock == 'undefined')viewBlock = dataBlock;
		var selectedField = that.parent().attr('data-field');
		var selectedMultiple = that.parent().attr('data-multiple');
		var selected = $('#' + selectedField).val();
		var res = eval(dataList);
		var res = res.parent;
		var child = [res];
		
		//console.log(res);
		var last = false;
		var categorysHtml = '<div class="categorys-content"><div class="categorys-stock"><div><ul class="tab">';
		if(dataBlock === ''){
			var selecteds = selected.split(',');
		}else{
			var selecteds = selected.replace(new RegExp(dataBlock, 'g'), ',').split(',');
		}		
		var temp = $.trim(that.attr('data-last'));
		if(!temp && selecteds.length > 0)temp = selecteds[selecteds.length - 1];
		if($.inArray(temp, selecteds) != -1){
			selecteds = [temp];
		}else{
			selecteds = [];
		}
		
		var path = categorys_path(res, dataVal, selecteds);
		if(path.length > 0){
			selecteds = [res[path[0]][dataVal]];
			if(typeof res[path[0]]['child'] != 'undefined'){
				var temp = res[path[0]]['child'];
				child.push(temp);
				for(i = 1; i < path.length; i ++){
					selecteds.push(temp[path[i]][dataVal]);
					if(typeof temp[path[i]]['child'] != 'undefined'){
						var temp = temp[path[i]]['child'];
						child.push(temp);
					}
				}
			}
		}

		for(var i in child){
			var curr = i == child.length - 1 ? ' class="curr"' : '';
			var tabTitle = '请选择';
			for(var j in child[i]){
				if($.findarray(child[i][j][dataVal], selecteds) != -1)tabTitle = child[i][j][dataView];
			}
			var tabWidth = (90 / child.length);
			categorysHtml += '<li' + curr + ' style="width:' + tabWidth + '%;max-width:33%;"><a href="javascript:;"><em>' + tabTitle + '</em><i></i></a></li>';
		}		
		categorysHtml += '</ul><div class="stock-line"></div></div>';

		if(child){			
			for(var i in child){		
				var display = child.length <= 1 || i == child.length -1 ? '' : ' style="display:none"';									
				categorysHtml += '<div class="stock_categores_item" ' + display + '><ul class="categorys-list">';
				for(var j in child[i]){
					var aHover = '';
					if(selectedMultiple != '1' && $.findarray(child[i][j][dataVal], selecteds) != -1)aHover = 'hover';
					categorysHtml += '<li><a href="javascript:;" class="' + aHover + '" title="' + child[i][j][dataView] + '" alt="' + child[i][j][dataView] + '" data-val="' + categorys_data(res, dataVal, dataBlock, child[i][j]['path']) + '" data-view="' + categorys_data(res, dataView, viewBlock, child[i][j]['path']) + '">' + child[i][j][dataView] + '</a></li>';
				}
				categorysHtml += '</ul></div>';
			}
		}
		categorysHtml += '</div></div>';				
		
		that.parent().find('.categorys-content').remove();
		that.parent().append(categorysHtml);
		that.parent().find('.categorys-content').show();
		that.parent().find('.categorys-close').show();
		that.parent().find('.categorys-close').unbind('click').click(function(){
			$(this).parent().find('.categorys-content').remove();
			$(this).hide();
		});

		return false;
	});
	$('.categorys-selector').on('click', '.tab li', function(){
		var index = $(this).index();
		$('.categorys-stock li').removeClass('curr');
		$('.categorys-stock li').eq(index).addClass('curr');
		$('.stock_categores_item').hide();
		$('.stock_categores_item').eq(index).show();
	});
	$('.categorys-selector .categorys-text').on('click', 'i[data-val]', function(e){
		var categorysSelector = $(this).parents('.categorys-selector');
		var selectedField = categorysSelector.attr('data-field');
		$('#' + selectedField).val($(this).attr('data-val'));
		categorysSelector.find('.categorys-text').html($(this).attr('data-view') + ' <div></div><b></b>');
		e.preventDefault();
		e.stopPropagation();
	});
	$('.categorys-selector').on('click', 'a[data-val]', function(){
		var categorysSelector = $(this).parents('.categorys-selector');
		var selectedField = categorysSelector.attr('data-field');
		var selectedMultiple = categorysSelector.attr('data-multiple');
		var dataClear = $.trim(categorysSelector.attr('data-clear'));

		if(selectedMultiple == '1'){
			var selectedIsNew = true;
			var selectedId = $(this).attr('data-val');
			var selectedIds = $('#' + selectedField).val().split(',');
			var newselectedIds = [];
			for(var i in selectedIds){
				if(selectedId == selectedIds[i]){
					selectedIsNew = false;
				}else{
					if(selectedIds[i])newselectedIds.push(selectedIds[i]);
				}
			}
			if(selectedIsNew){
				newselectedIds.push(selectedId);
				$('#' + selectedField).val(newselectedIds == '' ? '' : newselectedIds.join(','));
				$('.categorys-multiple').append('<div class="categorys_item" data-field="' + selectedField + '" data-val="' + selectedId + '">' + $(this).attr('data-view') + ' <i></i> </div>\r\n');
			}
		}else{
			$('#' + selectedField).val($(this).attr('data-val'));
			categorysSelector.find('.categorys-text').html($(this).attr('data-view') + (dataClear ? ' <i data-val="" data-view="' + dataClear + '"></i>' : '') + ' <div></div><b></b>');
		}
		categorysSelector.find('.categorys-text').attr('data-last', $(this).attr('data-val'));
		categorysSelector.find('.categorys-text').click();
        if($(this).attr('data-val').length >3){
            $('.categorys-content').remove();
            $('.categorys-close').hide();
        }
	});
	$('.categorys-multiple').on('click', '.categorys_item', function(){
		var selectedField = $(this).attr('data-field');
		var selectedId = $(this).attr('data-val');
		var selectedIds = $('#' + selectedField).val().split(',');
		var newselectedIds = [];
		for(var i in selectedIds){
			if(selectedId != selectedIds[i])newselectedIds.push(selectedIds[i]);
		}
		$('#' + selectedField).val(newselectedIds == '' ? '' : newselectedIds.join(','));
		$(this).remove();
	});
	//点击空白处关闭对话框
	$(document).mouseup(function(e){
		var _con = $('.categorys-selector');//设置目标区域
		if(_con){
			if(!_con.is(e.target) && _con.has(e.target).length === 0){
				$('.categorys-content').remove();
				$('.categorys-close').hide();
			}
		}
	});
});