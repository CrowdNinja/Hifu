/*
// 意动推广 版权所有
// http://www.ydtuiguang.com/
// @author : lael
// blog : http://hi.baidu.com/lael80
// all right reserved.
*/
var dateutils = function(){}
/*
d : 日期字符串
ff : (d : 日期字符串)原格式/未知为false
tf : 新格式

f、ff、tf : 格式化字符串,由以下结构组成（具体参考php日期格式字符，但仅支持以下所列） 
			要直接显示以下字符，请用 \\ 转义，如：Y\\Y\\e\\ar-m-d H\\Houri:s
//
Y 	4 位数字完整表示的年份 	例如：1999 或 2003
y 	2 位数字表示的年份 	例如：99 或 03
//
n 	数字表示的月份，没有前导零 	1 到 12
m 	数字表示的月份，有前导零 	01 到 12
e	（非php定义，自定义的）中文月份 一月 到 十二月
M 	三个字母缩写表示的月份 	Jan 到 Dec
F 	月份，完整的文本格式，例如 January 或者 March 	January 到 December
//
j 	月份中的第几天，没有前导零 	1 到 31
d 	月份中的第几天，有前导零的 2 位数字 	01 到 31
//
g 	小时，12 小时格式，没有前导零 	1 到 12
G 	小时，24 小时格式，没有前导零 	0 到 23
h 	小时，12 小时格式，有前导零 	01 到 12
H 	小时，24 小时格式，有前导零 	00 到 23
//
i 	有前导零的分钟数 	00 到 59
//
s 	秒数，有前导零 	00 到 59
//
x	（非php定义，自定义的）中文上下午
a 	小写的上午和下午值 	am 或 pm
A 	大写的上午和下午值 	AM 或 PM
//
D 	星期中的第几天，文本表示，3 个字母 	Mon 到 Sun
l	（“L”的小写字母） 星期几，完整的文本格式 Sunday 到 Saturday
k	（非php定义，自定义的）中文星期 星期日 到 星期六
w 	星期中的第几天，数字表示 	0（表示星期天）到 6（表示星期六）
u   Unix Timestamp
//
*/
/*
<script language="javascript" src="{$CFG[skinpath]}javascript/dateutils.js"></script>
<script language="javascript">
	var _dateutils = new dateutils();
	alert(_dateutils.format('2001-12-23 星期日 21:11:10', 'Y-m-d H:i:s', 'Y-m-d H:i:s'));
</script> 
*/
dateutils.prototype.format = function(d, ff, tf){
	var wk = [['星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'], 
			 ['Sun', 'Mon', 'Tur', 'Wed', 'Thu', 'Fri', 'Sat'],
			 ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']]; 
	var mh = [['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
			 ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
			 ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']]; 	

	var c = this.newdate(d, ff);
	var o = {
				'Y' : c.getFullYear(),
				'y' : c.getYear(),
				'n' : c.getMonth() + 1,
				'm' : this.fatstr(c.getMonth() + 1, 2, '0'),
				'e' : mh[0][c.getMonth()],
				'M' : mh[1][c.getMonth()],
				'F' : mh[2][c.getMonth()],
				'j' : c.getDate(),
				'd' : this.fatstr(c.getDate(), 2, '0'),
				'g' : (c.getHours() > 12 ? c.getHours() - 12 : c.getHours()),
				'h' : this.fatstr(c.getHours() > 12 ? c.getHours() - 12 : c.getHours(), 2, '0'),
				'G' : c.getHours(),
				'H' : this.fatstr(c.getHours(), 2, '0'),
				'i' : this.fatstr(c.getMinutes(), 2, '0'),
				's' : this.fatstr(c.getSeconds(), 2, '0'),
				'x' : (c.getHours() >= 0 && c.getHours() < 12 ? '上午' : '下午'),
				'a' : (c.getHours() >= 0 && c.getHours() < 12 ? 'am' : 'pm'),
				'A' : (c.getHours() >= 0 && c.getHours() < 12 ? 'AM' : 'PM'),
				'k' : wk[0][c.getDay()],
				'D' : wk[1][c.getDay()],
				'l' : wk[2][c.getDay()],
				'w' : c.getDay(),
				'u' : Math.round(c.getTime() / 1000)
			};
	if(!tf)tf = 'Y-m-d H:i:s';
	var r = this.formatregexp(tf);
	var m = this.stripformat(tf).match(r);
	if(!m)return this.stripformat(tf);
	var n = r.substr(1, r.length - 2);
	for(var i = 1; i < m.length; i ++){
		n = n.replace('(' + m[i] + ')', o[m[i]]);
	}
	return this.stripregexp(n);
}
dateutils.prototype.validator = function(d, f){
	return this.format(d, f, f) == d;
}
dateutils.prototype.newdate = function(d, f){
	try{if(d.getFullYear())return d;}catch(e){}
	if(!isNaN(d) && (d+'').length == 10){
		d = new Date(parseInt(d) * 1000).toLocaleString();//UNIX时间
	}
	var n = ['', '', '', '', '', ''];
	if(f){
		var _d = d.match(this.dateregexp(f));
		var _f = this.stripformat(f).match(this.formatregexp(f));
		if(_d && _f){
			var mh = [['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
					 ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
					 ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']];
			var aA = 0;
			var gh = false;
			var GH = false;
			for(var i = 0; i < _f.length; i ++){
				if(_f[i] == 'y')n[0] = '20' + _d[i];
				if(_f[i] == 'Y')n[0] = _d[i];
				if(_f[i] == 'e' || _f[i] == 'M' || _f[i] == 'F' || _f[i] == 'n' || _f[i] == 'm'){
					var _n = this.inarray(_d[i], mh[0]);
					if(_n == -1)_n = this.inarray(_d[i], mh[1]);
					if(_n == -1)_n = this.inarray(_d[i], mh[2]);
					n[1] = _n == -1 ? _d[i] * 1 - 1 : _n;
				}
				if(_f[i] == 'j' || _f[i] == 'd')n[2] = _d[i];
				if(_f[i] == 'g' || _f[i] == 'h'){gh = true; n[3] = _d[i];}
				if(_f[i] == 'G' || _f[i] == 'H'){GH = true; n[3] = _d[i];}
				if(_f[i] == 'a' || _f[i] == 'A'){
					if(_d[i] == 'am' || _d[i] == 'AM'){
						aA = 0;
					}else{
						aA = 12;
					}
				}
				if(_f[i] == 'x'){
					if(_d[i] == '上午' || _d[i] == '下午'){
						aA = 0;
					}else{
						aA = 12;
					}
				}
				if(_f[i] == 'i')n[4] = _d[i];
				if(_f[i] == 's')n[5] = _d[i];
			}
			if(GH === false && gh)n[3] = n[3] * 1 + aA;//上下午调整
		}
	}
	var _d = new Date(d);
	if(isNaN(_d))_d = new Date(this.rpdate(d));
	if(isNaN(_d))_d = new Date();
	
	if(!/\d{4}/.test(n[0]))n[0] = _d.getFullYear();
	if(!/(0*[0-9]|1[0-1])/.test(n[1]))n[1] = _d.getMonth();
	if(!/(0*[1-9]|[1-2][0-9]|30|31)/.test(n[2]))n[2] = _d.getDate();
	if(!/([0-1]*[0-9]|20|21|22|23)/.test(n[3]))n[3] = _d.getHours();
	if(!/([0-5]*[0-9])/.test(n[4]))n[4] = _d.getMinutes();
	if(!/([0-5]*[0-9])/.test(n[5]))n[5] = _d.getSeconds();
	return (new Date(n[0], n[1], n[2], n[3], n[4], n[5]));
}
dateutils.prototype.rpdate = function(d){
	if(!d)return '';
	return d.replace(/上午|am|AM/g, '')
			.replace(/下午|pm|PM/g, '')
			.replace(/星期日|Sunday/gi, 'Sun')
			.replace(/星期一|Monday/gi, 'Mon')
			.replace(/星期二|Tuesday/gi, 'Tur')
			.replace(/星期三|Wednesday/gi, 'Wed')
			.replace(/星期四|Thursday/gi, 'Thu')
			.replace(/星期五|Friday/gi, 'Fri')
			.replace(/星期六|Saturday/gi, 'Sat')
			.replace(/一月|January/gi, 'Jan')
			.replace(/二月|February/gi, 'Feb')
			.replace(/三月|March/gi, 'Mar')
			.replace(/四月|April/gi, 'Apr')
			.replace(/五月|May/gi, 'May')
			.replace(/六月|June/gi, 'Jun')
			.replace(/七月|July/gi, 'Jul')
			.replace(/八月|August/gi, 'Aug')
			.replace(/九月|September/gi, 'Sep')
			.replace(/十月|October/gi, 'Oct')
			.replace(/十一月|November/gi, 'Nov')
			.replace(/十二月|December/gi, 'Dec')
			.replace(/-|年|月/g, '/')
			.replace(/时|分/g, ':')
			.replace(/日|秒/g, ' ')						
			.replace(/\s+/g, ' ');
}
//将格式字符串转成正则表达式
dateutils.prototype.formatregexp = function(f){
	if(!f)return '';
	var _f = f.replace(/([\\\.\+\*\?\[\^\]\$\(\)\{\}\=\!<>\|\:])/g, '\\$1');
	_f = _f.replace(/(Y|y|n|m|e|M|F|j|d|g|h|G|H|i|s|x|a|A|k|D|l|w|u)/g, '($1)');
	_f = _f.replace(/\\\\\((Y|y|n|m|e|M|F|j|d|g|h|G|H|i|s|x|a|A|k|D|l|w|u)\)/g, '$1');//取消已经转义的格式字符
	return '^' + _f + '$';
}
dateutils.prototype.dateregexp = function(f){
	var _f = this.formatregexp(f);
	return _f.replace(/(\()(Y|y|n|m|e|M|F|j|d|g|h|G|H|i|s|x|a|A|k|D|l|w|u)(\))/g, '$1.+$3');
}
//删除多余转义字符
dateutils.prototype.stripformat = function(f){
	if(!f)return '';
	return f.replace(/\\(Y|y|n|m|e|M|F|j|d|g|h|G|H|i|s|x|a|A|k|D|l|w|u)/g, '$1');
}
//取消正则成普通字符串
dateutils.prototype.stripregexp = function(r){
	if(!r)return '';
	return r.replace(/\\([\\\.\+\*\?\[\^\]\$\(\)\{\}\=\!<>\|\:])/g, '$1');
}
dateutils.prototype.addslashes = function(s){
	return s.replace(/\\/g, '\\\\');
}
dateutils.prototype.stripslashes = function(s){
	return s.replace(/\\\\/g, '\\');
}
dateutils.prototype.fatstr = function(s, l, f){
	s = s.toString();
	try{
		if(s.length == l)return s;
	}catch(e){
		s = '';
	}
	var t = s.length;
	for(var i = 0; i < l - t; i ++){
		s = f + s;
	}
	return s;
}
dateutils.prototype.inarray = function(v, arr){
	for(var i = 0; i < arr.length; i ++){
		if(v.toLowerCase() == arr[i].toLowerCase())return i;
	}
	return -1;
}
