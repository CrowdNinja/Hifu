<?php /* Smarty version Smarty-3.1.19, created on 2020-06-12 03:40:53
         compiled from "C:\xampp\htdocs\beauty-server\app\views\device\edit_device.html" */ ?>
<?php /*%%SmartyHeaderCode:7667070635ee2dd25c8baa2-79602317%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '25ea99194eb1662097b7ecd926c3d1b5a9a544b0' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beauty-server\\app\\views\\device\\edit_device.html',
      1 => 1591104997,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7667070635ee2dd25c8baa2-79602317',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'row' => 0,
    'page' => 0,
    '_admin' => 0,
    'shop' => 0,
    'v' => 0,
    'device_type' => 0,
    'k' => 0,
    'device_son_type' => 0,
    'device_status' => 0,
    'geocoder_key' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5ee2dd25d20242_94001185',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ee2dd25d20242_94001185')) {function content_5ee2dd25d20242_94001185($_smarty_tpl) {?><title><?php echo translate('设备管理');?>
 - <?php if ($_smarty_tpl->tpl_vars['row']->value['id']) {?><?php echo translate('编辑');?>
<?php } else { ?><?php echo translate('添加');?>
<?php }?><?php echo translate('设备');?>
 </title>
<div class="page-header">
	<h1>
        <?php echo translate('设备管理');?>
 <small> <i class="ace-icon fa fa-angle-double-right"></i> <?php if ($_smarty_tpl->tpl_vars['row']->value['id']) {?><?php echo translate('编辑');?>
<?php } else { ?><?php echo translate('添加');?>
<?php }?><?php echo translate('设备');?>

		</small>
	</h1>
</div>
<!-- /.page-header -->
<script language='javascript' src="/style/assets/js/jquery.dialogBox.js"></script>
<link rel="stylesheet" href="/style/assets/js/jquery.dialogbox.css" />
<script>window.UEDITOR_HOME_URL = '/app/third_party/ueditor1_4_3_3-utf8-php/';</script>
<script type="text/javascript" charset="utf-8" src="/app/third_party/ueditor1_4_3_3-utf8-php/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/app/third_party/ueditor1_4_3_3-utf8-php/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="/app/third_party/ueditor1_4_3_3-utf8-php/lang/zh-cn/zh-cn.js"></script>
<script type="text/plain" id="j_ueditorupload" style="height:5px;display:none;" ></script>
<script type="text/javascript" charset="utf-8" src="/app/third_party/ueditor1_4_3_3-utf8-php/ueditor.upload.js"></script>
<div class="row">
	<div class="col-md-12">
<div class="main">
    <ul class="nav nav-tabs">
        <li><a href="/admin_system#page/admin_device?page=<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
"><?php echo translate('设备列表');?>
</a></li>
        <li class="active"><a href="/admin_system#page/admin_device/edit/<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
"><?php if ($_smarty_tpl->tpl_vars['row']->value['id']) {?><?php echo translate('编辑');?>
<?php } else { ?><?php echo translate('添加');?>
<?php }?><?php echo translate('设备');?>
</a></li>
    </ul>

  <div class="panel panel-default">
        <div class="panel-body table-responsive">

        		<form class="form-horizontal" role="form" id="submitform" action="/admin_device/edit/<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
" method="post" accept-charset="utf-8">
                    <?php if ($_smarty_tpl->tpl_vars['_admin']->value->_role_type<2) {?>
                    <div class="form-group">
                        <label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('代理商');?>
<?php if ($_smarty_tpl->tpl_vars['_admin']->value->_role_type!=0) {?>*<?php }?>:</label>
                        <div class="col-xs-12 col-sm-4">
                            <span class="block">
                                <input id="agent_id" name="agent_id" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['agent_id'];?>
" style="width:100%" <?php if ($_smarty_tpl->tpl_vars['_admin']->value->_role_type!=0) {?>required<?php }?> />
                            </span>
                        </div>
                        <div class="help-block inline"></div>
                    </div>
                    <?php }?>

            <div class="form-group">
		<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('商家');?>
<?php if ($_smarty_tpl->tpl_vars['_admin']->value->_role_type!=0) {?>*<?php }?>:</label>
		<div class="col-xs-12 col-sm-4">
            <select name="adminid" id="adminid" class="form-control">
                <option vlaue="0"> <?php echo translate('请选择');?>
</option>
                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['shop']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" <?php if (strval($_smarty_tpl->tpl_vars['row']->value['adminid'])==$_smarty_tpl->tpl_vars['v']->value['id']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value['nickname'];?>
</option>
                <?php } ?>

            </select>
		</div>
		<div class="help-block inline"></div>
	</div>
<script>
$(function () {
        $("#agent_id").select2({
            ajax: {
                url: "/admin_corp/search",
                data: function (params) {
                    return {
                        keywords: params,
                    };
                },
                results:function(data,pageNo){
                    if(data.data.length){
                        data['data'].splice(0, 0, {'id':'', 'text': "<?php echo translate('请选择');?>
"});
                    }else{
                        data['data'] = [{'id':'', 'text': "<?php echo translate('请选择');?>
"}];
                    }
                    return {
                        results:data.data
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                type: 'post',
                dataType: 'json'
            },
            initSelection: function(elem, cbfunc){
            },
            allowClear: false,
            openOnEnter: false,
            minimumInputLength: 1,
        });
    <?php if ($_smarty_tpl->tpl_vars['row']->value['agent_id']) {?>$('#agent_id').select2('data', {id:"<?php echo $_smarty_tpl->tpl_vars['row']->value['agent_id'];?>
", text:"<?php echo $_smarty_tpl->tpl_vars['row']->value['agent_name'];?>
"}).select2('val', ["<?php echo $_smarty_tpl->tpl_vars['row']->value['agent_id'];?>
"]);<?php }?>
});
</script>

       <div class="form-group">
		<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('设备号');?>
*:</label>
		<div class="col-xs-12 col-sm-4">
			<span class="block">
				<input id="macno" name="macno" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['macno'];?>
" class="form-control input-width" required />
			</span>
		</div>
        <div class="col-xs-12 col-sm-1">
        <a href="javascript:;" class=" check-device btn  btn-primary btn-sm"><?php echo translate('检测重复');?>
</a>
        </div>
		<div class="help-block inline"></div>
	</div>

                    <div class="form-group">
                        <label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('设备类型');?>
:</label>
                        <div class="col-xs-12 col-sm-4">
                            <select name="type" id="type" class="form-control">
                                <option value="0"><?php echo translate('请选择');?>
</option>
                                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['device_type']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" <?php if (strval($_smarty_tpl->tpl_vars['row']->value['type'])==strval($_smarty_tpl->tpl_vars['k']->value)) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</option>
                                <?php } ?>

                            </select>
                        </div>
                        <div class="help-block inline"></div>
                    </div>

                    <div class="form-group">
                        <label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('设备子类型');?>
:</label>
                        <div class="col-xs-12 col-sm-4">
                            <select name="device_son_type_id" id="device_son_type_id" class="form-control">
                                <option value="0"><?php echo translate('请选择');?>
</option>
                                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['device_son_type']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" <?php if (strval($_smarty_tpl->tpl_vars['row']->value['device_son_type_id'])==strval($_smarty_tpl->tpl_vars['v']->value['id'])) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="help-block inline"></div>
                    </div>
                    <div class="form-group">
                        <label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right">波特率:</label>
                        <div class="col-xs-12 col-sm-4">
			<span class="block">
				<input type="text"  value="<?php echo $_smarty_tpl->tpl_vars['row']->value['rate'];?>
"  class="form-control input-width"  readonly/>
			</span>
                        </div>
                        <div class="help-block inline"></div>
                    </div>
    <!--<div class="form-group">
		<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right">价格设置:</label>
		<div class="col-xs-12 col-sm-2">
			<span class="block">
            	单价/小时
				<input id="price_set[price]" type="text" name="price_set[price]" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['price_set']['price'];?>
" class="form-control input-width" />
			</span>
		</div>
        <div class="col-xs-12 col-sm-2">
			<span class="block">
            	免费时长/分钟
				<input id="price_set[free]" type="text" name="price_set[free]" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['price_set']['free'];?>
" class="form-control input-width" />
			</span>
		</div>
		<div class="help-block inline">* 留空为系统统一价格，填写 <b>0</b> 为免费</div>
	</div>-->
                   <!-- <div class="form-group">
                        <label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right">房间号:</label>
                        <div class="col-xs-12 col-sm-4">
			<span class="block">
				<input id="room" type="text" name="room" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['room'];?>
" class="form-control input-width" />
			</span>
                        </div>
                        <div class="help-block inline"></div>
                    </div>-->

			<div class="form-group">
		<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('地址');?>
:</label>
		<div class="col-xs-12 col-sm-4">
			<span class="block">
				<input id="address" type="text" name="address" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['address'];?>
" class="form-control input-width" />
			</span>
		</div>
		<div class="help-block inline"></div>
	</div>
                    <!--<div class="form-group">
                        <label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right">地址坐标*:</label>
                        <div class="col-xs-12 col-sm-2">
                            <span class="block">
                                <input id="lat" type="text" name="lat" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['lat'];?>
" class="form-control input-width"  />
                            </span>
                        </div>
                        <div class="col-xs-12 col-sm-2">
                            <span class="block">
                                <input id="lng" type="text" name="lng" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['lng'];?>
" class="form-control input-width"  />
                            </span>
                        </div>
                        <div class="col-xs-12 col-sm-1">
                            <a href="javascript:;" class="btn-location btn btn-primary btn-sm">获取坐标</a>
                        </div>
                        <div class="col-xs-12 col-sm-1">
                            <div class="pull-right"></div><a href="javascript:;" class="btn-map btn btn-primary btn-sm">地图选择</a>
                        </div>
                        <div class="help-block inline">* 请先填写所在地址</div>
                    </div>-->
                    <div class="form-group">
                        <label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('状态');?>
:</label>
                        <div class="col-xs-12 col-sm-4">
                            <select name="status" id="status" class="form-control">
                                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['device_status']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                                <?php if (is_numeric($_smarty_tpl->tpl_vars['k']->value)) {?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" <?php if (strval($_smarty_tpl->tpl_vars['row']->value['status'])==strval($_smarty_tpl->tpl_vars['k']->value)) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</option>
                                <?php }?>
                                <?php } ?>

                            </select>
                        </div>
                        <div class="help-block inline"></div>
                    </div>

			<div class="form-group">
		<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('备注');?>
:</label>
		<div class="col-xs-12 col-sm-4">
			<span class="block">
				<textarea id="remark" type="text" name="remark"  class="form-control input-width" ><?php echo $_smarty_tpl->tpl_vars['row']->value['remark'];?>
 </textarea>
			</span>
		</div>
		<div class="help-block inline"></div>
	</div>


                    <div class="form-group">
				<div class="col-sm-offset-3 col-sm-9">
					<button type="button" id="saveedit" class="btn  btn-primary btn-lg"><?php echo translate('提交');?>
</button>
				</div>
			</div>
		</form>
        </div>
        </div>
	</div>
    </div>
</div>
<script src="/style/assets/js/x-editable/bootstrap-editable.min.js"></script>
<script src="/style/assets/js/jquery.gritter.min.js"></script>
<script src="/style/assets/js/x-editable/ace-editable.min.js"></script>

<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.3&key=<?php echo $_smarty_tpl->tpl_vars['geocoder_key']->value;?>
&plugin=AMap.Geocoder"></script>
<script type="text/javascript">
var isbusy = false;
function amap_click(map, res){
    console.log(res);
    //map.clearMap();
    $("#lng").val(res.lnglat.lng);
    $("#lat").val(res.lnglat.lat);
}
$(function(){
	$('#submitform').validate({
			errorElement: 'div',
			errorClass: 'help-block',
			focusInvalid: true,
			rules: {
				title: {
					required: true
				}
			}
	});

    $('#agent_id').change(function () {
        var parent_id= $("#agent_id").val();
        var adminid="<?php echo $_smarty_tpl->tpl_vars['row']->value['adminid'];?>
";
        if(parent_id>0){
            $.ajax({
                type:"post",
                url:"/admin_shop/get_corp_shop",
                data:{'parent_id':parent_id},
                dataType: "json",
                success:function(data) {
                    var arr = data.data;
                    var html="<option value='0'  ><?php echo translate('请选择');?>
</option>";
                    var selected='';
                    for(var i=0;i<arr.length;i++){
                        if(arr[i]['id']==adminid){
                            selected='selected="selected"';
                        }else{
                            selected='';
                        }
                        html+='<option value="'+arr[i]['id']+'" '+selected+' >'+arr[i]['text']+'</option>';
                    }
                    $("#adminid").html(html).change();
                },
                error:function(xhr){
                    tooltipbox.alert("<?php echo translate('获取失败');?>
");
                    return false;
                }
            });
        }
    });
    $('#agent_id').change();
    $('.btn-map').click(function(){
        var address = $('#address').val().replace(/ /g, '');
        address = address.replace(/^\s/g, '').replace(' ', '省');
        address = address.replace(' ', '市');
        $(this).prev().dialogBox({
            title:"<?php echo translate('选择坐标');?>
",
            fixTop: -1 * $(window).height() * 0.2,
            autoSize:false,
            hasMask:false,
            hasClose:true,
            width:Math.min(800, $(window).width() * 0.9),
            height:Math.min(600, $(window).height() * 0.9),
            frameborder:'no',
            scrolling:'auto',
            content:'/app/third_party/amap/amap.html?address=' + encodeURI(encodeURI(address)),
            framedisplay:'none',
            iframeload:function(_iframe){
                $('#dialog-box-iframe').show(300);
                $('.dialog-box').dragDiv();
                //setTimeout(function(){ tooltipbox.clear(); }, 5000);
            },
            close:function(){
            },
        });
        return false;
    });
    $('.btn-location').click(function(){
        if(!$('#address').val()){
            tooltipbox.show("<?php echo translate('请先填写地址');?>
");
            return false;
        }
        var map = new AMap.Map("container", {
            resizeEnable: true
        });
        var geocoder = new AMap.Geocoder({
            city: "", //城市，默认：“全国”
            radius: 500 //范围，默认：500
        });
        //地理编码
        geocoder.getLocation($('#address').val(), function(status, result) {
            if (status === 'complete' && result.info === 'OK') {
                //TODO:获得了有效经纬度，可以做一些展示工作
                //比如在获得的经纬度上打上一个Marker
                if(result.geocodes.length > 0){
                    $('#lat').val(result.geocodes[0].location.lat);
                    $('#lng').val(result.geocodes[0].location.lng);
                }
            }else{
                //获取经纬度失败
                tooltipbox.show("<?php echo translate('获取失败，请确认地址正确');?>
");
            }
            //alert($.toJSON(result));
        });
    });

	$('.check-device').click(function(){
		tooltipbox.show("<?php echo translate('正在执行操作');?>
");
		$.post('/admin_device/check', { 'id': "<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
", 'macno': $('#macno').val() }, function(res){
			if(res.status == '0'){
				tooltipbox.alert("<?php echo translate('设备号可使用');?>
");
			}else if(res.status == '-1'){
				tooltipbox.alert("<?php echo translate('数据或网络错误');?>
");
			}else{
				tooltipbox.alert("<?php echo translate('设备号已经存在');?>
");
			}
		}, 'json').error(function(){
			tooltipbox.show("<?php echo translate('数据或网络错误');?>
");
		});
		return false;
	});
	$('#saveedit').click(function(){
		if(!$('#submitform').valid())return false;
		if(isbusy)return false;
		isbusy = true;
		tooltipbox.show("<?php echo translate('正在执行操作');?>
");
		$.post('/admin_device/edit/<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
', $('#submitform').serialize(), function(res){
			if(res.status == '1'){
				tooltipbox.show("<?php echo translate('操作完成');?>
");
				history.back(-1);
			}else if(res.status == '0'){
				tooltipbox.alert(res.msg);
			}else{
				tooltipbox.show("<?php echo translate('数据或网络错误');?>
");
			}
			isbusy = false;
		}, 'json').error(function(a, b, c){
			tooltipbox.show("<?php echo translate('数据或网络错误');?>
");
			isbusy = false;
		});
	});
});
</script> <?php }} ?>
