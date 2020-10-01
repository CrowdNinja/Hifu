<?php /* Smarty version Smarty-3.1.19, created on 2020-06-07 17:57:16
         compiled from "C:\xampp\htdocs\beauty-server\app\views\pack\edit_pack.html" */ ?>
<?php /*%%SmartyHeaderCode:488480055edd0e5c636944-24586296%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '31497a60aac57d4697457589e20b099b9346f48b' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beauty-server\\app\\views\\pack\\edit_pack.html',
      1 => 1591104997,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '488480055edd0e5c636944-24586296',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'row' => 0,
    'item' => 0,
    'v' => 0,
    'item_type' => 0,
    'geocoder_key' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5edd0e5c6a2f66_94376192',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5edd0e5c6a2f66_94376192')) {function content_5edd0e5c6a2f66_94376192($_smarty_tpl) {?><title><?php echo translate('商家管理');?>
 - <?php if ($_smarty_tpl->tpl_vars['row']->value['id']) {?><?php echo translate('编辑');?>
<?php } else { ?><?php echo translate('添加');?>
<?php }?><?php echo translate('套餐');?>
 </title>
<div class="page-header">
    <h1>
        <?php echo translate('商家管理');?>
 <small> <i class="ace-icon fa fa-angle-double-right"></i> <?php if ($_smarty_tpl->tpl_vars['row']->value['id']) {?><?php echo translate('编辑');?>
<?php } else { ?><?php echo translate('添加');?>
<?php }?><?php echo translate('套餐');?>

    </small>
    </h1>
</div>
<!-- /.page-header -->
<script>window.UEDITOR_HOME_URL = '/app/third_party/ueditor1_4_3_3-utf8-php/';</script>
<script type="text/javascript" charset="utf-8" src="/app/third_party/ueditor1_4_3_3-utf8-php/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/app/third_party/ueditor1_4_3_3-utf8-php/ueditor.all.min.js"> </script>
<!--<script type="text/javascript" charset="utf-8" src="/app/third_party/ueditor1_4_3_3-utf8-php/lang/zh-cn/zh-cn.js"></script>-->
<script type="text/javascript" charset="utf-8" src="/app/third_party/ueditor1_4_3_3-utf8-php/lang/en/en.js"></script>
<script type="text/plain" id="j_ueditorupload" style="height:5px;display:none;" ></script>
<script type="text/javascript" charset="utf-8" src="/app/third_party/ueditor1_4_3_3-utf8-php/ueditor.upload.js"></script>

<div class="row">
    <div class="col-md-12">
        <div class="main">
            <ul class="nav nav-tabs">
                <li><a href="/admin_system#page/admin_pack"><?php echo translate('套餐列表');?>
</a></li>
                <li class="active"><a href="/admin_system#page/admin_pack/edit/<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
"><?php if ($_smarty_tpl->tpl_vars['row']->value['id']) {?><?php echo translate('编辑');?>
<?php } else { ?><?php echo translate('添加');?>
<?php }?><?php echo translate('套餐');?>
</a></li>
            </ul>

            <div class="panel panel-default">
                <div class="panel-body table-responsive">

                    <form class="form-horizontal" role="form" id="submitform" action="/admin_pack/edit/<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
" method="post" accept-charset="utf-8">

                        <div class="form-group">
                            <label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('图片');?>
</label>
                            <input type="hidden" name="img" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['img'];?>
" />
                            <div class="col-xs-12 col-sm-5">
                                <div class="upfile_imgthumb">
                                    <img src="<?php if ($_smarty_tpl->tpl_vars['row']->value['img']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['img'];?>
<?php } else { ?>/style/xin_inselimg.png<?php }?>" data-default="/style/xin_inselimg.png" class="btn-upfile">
                                    <div class="upfile_imgcaption">
                                        <a href="javascript:;" class="btn btn-primary btn-xs btn-upfile"><?php echo translate('上传');?>
</a>
                                        <a href="javascript:;" class="btn btn-default btn-xs btn-upremove"><?php echo translate('删除');?>
</a>
                                    </div>
                                </div>
                            </div>
                            <div class="help-block inline"></div>
                        </div>

                        <?php if (!$_smarty_tpl->tpl_vars['row']->value['id']) {?>
                        <div class="form-group">
                            <label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('商家');?>
*:</label>
                            <div class="col-xs-12 col-sm-4">
                            <span class="block">
                                <input id="adminid" name="adminid" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['adminid'];?>
" style="width:100%" required />
                            </span>
                            </div>
                            <div class="help-block inline"></div>
                        </div>
                        <?php }?>


                        <div class="form-group">
                            <label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('套餐标题');?>
:</label>
                                <div class="col-xs-12 col-sm-4">
                                    <span class="block">
                                        <input id="title" name="title" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['title'];?>
" class="form-control input-width" required />
                                    </span>
                                </div>
                            <div class="help-block inline"></div>
                        </div>


                        <div class="form-group">
                            <label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('套餐价格');?>
:</label>
                                <div class="col-xs-12 col-sm-4">
                                    <span class="block">
                                        <input id="price" name="price" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['price'];?>
" min="0" class="form-control input-width" required />
                                    </span>
                                </div>
                            <div class="help-block inline"></div>
                        </div>

                        <div class="form-group">
                            <label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('有效期');?>
:</label>
                            <div class="col-xs-12 col-sm-4">
                                    <span class="block">
                                        <input id="validity_time" name="validity_time" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['validity_time'];?>
"  class="form-control input-width"  />
                                    </span>
                            </div>
                            <div class="help-block inline"></div>
                        </div>

                     <!--   <div class="form-group">
                            <label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('使用人数');?>
:</label>
                            <div class="col-xs-12 col-sm-4">
                                    <span class="block">
                                        <input id="number" name="number" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['number'];?>
" min="1" class="form-control input-width"  />
                                    </span>
                            </div>
                            <div class="help-block inline"></div>
                        </div>-->

                        <div class="form-group">
                            <label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('预约信息');?>
:</label>
                            <div class="col-xs-12 col-sm-4">
                                    <span class="block">
                                        <textarea id="reservation_info" name="reservation_info"  class="form-control input-width"  style="height: 128px;"><?php echo $_smarty_tpl->tpl_vars['row']->value['reservation_info'];?>
</textarea>
                                    </span>
                            </div>
                            <div class="help-block inline"></div>
                        </div>

                        <div class="form-group">
                            <label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('服务功效');?>
:</label>
                            <div class="col-xs-12 col-sm-4">
                                    <span class="block">
                                        <textarea id="efficacy" name="efficacy"  class="form-control input-width"  style="height: 128px;"><?php echo $_smarty_tpl->tpl_vars['row']->value['efficacy'];?>
</textarea>
                                    </span>
                            </div>
                            <div class="help-block inline"></div>
                        </div>

                        <div class="form-group">
                            <label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('部位');?>
:</label>
                            <div class="col-xs-12 col-sm-4">
                                    <span class="block">
                                        <textarea id="position" name="position"  class="form-control input-width"  style="height: 128px;"><?php echo $_smarty_tpl->tpl_vars['row']->value['position'];?>
</textarea>
                                    </span>
                            </div>
                            <div class="help-block inline"></div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('服务流程');?>
:</label>
                            <div class="col-xs-12 col-sm-4">
                                    <span class="block">
                                        <textarea id="service_process" name="service_process"  class="form-control input-width"  style="height: 128px;"><?php echo $_smarty_tpl->tpl_vars['row']->value['service_process'];?>
</textarea>
                                    </span>
                            </div>
                            <div class="help-block inline"></div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('备注');?>
:</label>
                                <div class="col-xs-12 col-sm-4">
                                    <span class="block">
                                        <textarea id="remark" name="remark"  class="form-control input-width"  ><?php echo $_smarty_tpl->tpl_vars['row']->value['remark'];?>
</textarea>
                                    </span>
                                </div>
                            <div class="help-block inline"></div>
                        </div>
                        <div class="form-group" id="mark">
                            <div class="col-sm-offset-3 col-sm-9">
                                <button type="button" id="saveedit" class="btn  btn-primary btn-lg"><?php echo translate('提交');?>
</button>
                            </div>
                        </div>
                        <?php if (false) {?>
                        <div class="form-group" >
                            <div class="col-sm-offset-0 col-sm-9">
                               <a href="admin_system#page/admin_pack/item_edit/<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
" class="btn btn-success btn-xs"> + <?php echo translate('添加套餐项目');?>
</a>
                            </div>
                        </div>
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th><?php echo translate('项目名称');?>
</th>
                                <th><?php echo translate('类型');?>
</th>
                                <th><?php echo translate('次数');?>
</th>
                                <th><?php echo translate('每次多少刀');?>
</th>
                                <th width="1000px"><?php echo translate('服务内容');?>
</th>
                                <th><?php echo translate('创建时间');?>
</th>
                                <th><?php echo translate('操作');?>
</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['item']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                            <tr class="alert1 success" align="left">
                                <td><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['item_type']->value[$_smarty_tpl->tpl_vars['v']->value['type']];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['v']->value['num'];?>
 <?php echo translate('次');?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['v']->value['knife'];?>
 <?php echo translate('刀');?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['v']->value['text'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['v']->value['ctime'];?>
</td>
                                <td >
                                    <?php if (chkcommand('/admin_pack/item_edit')) {?>
                                    <a href="admin_system#page/admin_pack/item_edit/<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
/<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="btn btn-success btn-xs"> <i class="fa fa-edit"></i>  <?php echo translate('修改');?>
</a>
                                    <?php }?>
                                    <?php if (chkcommand('/admin_pack/item_delete')) {?>
                                    <a href="javascript:;" class="btn btn-danger btn-xs delete" data-id="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"> <i class="fa fa-times"></i> <?php echo translate('删除');?>
 </a>
                                    <?php }?>
                                </td>
                            </tr>
                            <?php } ?>

                            </tbody>
                        </table>
                        <?php }?>


                    </form>

                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=<?php echo $_smarty_tpl->tpl_vars['geocoder_key']->value;?>
&plugin=AMap.Geocoder"></script>
<script type="text/javascript">
    var isbusy = false;

    $(function(){
        laydate.render({
            elem: '#validity_time',
        });
        $('.delete').click(function(){
            var id=$(this).data('id');

            tooltipbox.confirm("<?php echo translate('确定永久删除？');?>
", function(data){
                tooltipbox.show('正在执行操作...');
                $.post('/admin_pack/item_delete', data, function(res){
                    if(res.status == '1'){
                        tooltipbox.show("<?php echo translate('操作执行成功');?>
");
                        location.reload();
                    }else{
                        tooltipbox.show("<?php echo translate('数据或网络错误');?>
");
                    }
                }, 'json').error(function(){
                    tooltipbox.show("<?php echo translate('数据或网络错误');?>
");
                });
            }, false, { 'id': id });
        });
        $("#adminid").select2({
            ajax: {
                url: "/admin_shop/search",
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
    <?php if ($_smarty_tpl->tpl_vars['row']->value['adminid']) {?>$('#adminid').select2('data', {id:"<?php echo $_smarty_tpl->tpl_vars['row']->value['adminid'];?>
", text:"<?php echo $_smarty_tpl->tpl_vars['row']->value['shop_name'];?>
"}).select2('val', ["<?php echo $_smarty_tpl->tpl_vars['row']->value['adminid'];?>
"]);<?php }?>

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

        $('#saveedit').click(function(){
            if(!$('#submitform').valid())return false;
            if(isbusy)return false;
            isbusy = true;
            tooltipbox.show("<?php echo translate('正在执行操作？');?>
");
            $.post('/admin_pack/edit/<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
', $('#submitform').serialize(), function(res){
                if(res.status == '1'){
                    tooltipbox.show("<?php echo translate('操作完成');?>
");
                    location.href = '/admin_system#page/admin_pack/';
                }else if(res.status == '0'){
                    tooltipbox.alert(res.msg);
                }else{
                    tooltipbox.show(res);
                }
                isbusy = false;
            }, 'json').error(function(a, b, c){
                tooltipbox.show("<?php echo translate('数据或网络错误');?>
");
                isbusy = false;
            });
        });
    });
</script><?php }} ?>
