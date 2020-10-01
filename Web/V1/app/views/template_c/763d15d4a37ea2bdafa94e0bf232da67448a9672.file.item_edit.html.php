<?php /* Smarty version Smarty-3.1.19, created on 2020-06-07 18:03:14
         compiled from "C:\xampp\htdocs\beauty-server\app\views\pack\item_edit.html" */ ?>
<?php /*%%SmartyHeaderCode:11672247355edd0fc2b201c0-80853943%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '763d15d4a37ea2bdafa94e0bf232da67448a9672' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beauty-server\\app\\views\\pack\\item_edit.html',
      1 => 1591104997,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11672247355edd0fc2b201c0-80853943',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'row' => 0,
    'pack_id' => 0,
    'item_type' => 0,
    'k' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5edd0fc2b70020_66514901',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5edd0fc2b70020_66514901')) {function content_5edd0fc2b70020_66514901($_smarty_tpl) {?><title><?php echo translate('商家管理');?>
 - <?php if ($_smarty_tpl->tpl_vars['row']->value['id']) {?><?php echo translate('编辑');?>
<?php } else { ?><?php echo translate('添加');?>
<?php }?><?php echo translate('套餐项目');?>
</title>
<div class="page-header">
    <h1>
        <?php echo translate('商家管理');?>
 <small> <i class="ace-icon fa fa-angle-double-right"></i> <?php if ($_smarty_tpl->tpl_vars['row']->value['id']) {?><?php echo translate('编辑');?>
<?php } else { ?><?php echo translate('添加');?>
<?php }?><?php echo translate('套餐项目');?>

    </small>
    </h1>
</div>
<!-- /.page-header -->

<div class="row">
    <div class="col-md-12">
        <div class="main">
            <ul class="nav nav-tabs">
                <li class="active"><a href="/admin_system#page/admin_pack/item_edit/<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
"><?php if ($_smarty_tpl->tpl_vars['row']->value['id']) {?><?php echo translate('编辑');?>
<?php } else { ?><?php echo translate('添加');?>
<?php }?><?php echo translate('套餐项目');?>
</a></li>
            </ul>

            <div class="panel panel-default">
                <div class="panel-body table-responsive">

                    <form class="form-horizontal" role="form" id="submitform" action="/admin_pack/item_edit/<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
" method="post" accept-charset="utf-8">

                        <input id="pack_id" name="pack_id" value="<?php echo $_smarty_tpl->tpl_vars['pack_id']->value;?>
"  type="hidden"  />

                        <div class="form-group">
                            <label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('项目名称');?>
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
                            <label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('类型');?>
:</label>
                            <div class="col-xs-12 col-sm-4">
                                <select name="type" id="type" class="form-control">
                                    <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['item_type']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
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
                        <div class="form-group mr-type">
                            <label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('美容类型');?>
:</label>
                            <div class="col-xs-12 col-sm-4">
                                <span class="block">
                                    <label> <input type="radio" name="mr_type"  value="1" <?php if ($_smarty_tpl->tpl_vars['row']->value['mr_type']==1) {?>checked="checked" <?php }?>> <?php echo translate('全身');?>

                                        </label> &nbsp;&nbsp;&nbsp;<label> <input type="radio"  name="mr_type" value="2" <?php if ($_smarty_tpl->tpl_vars['row']->value['mr_type']==2) {?>checked="checked" <?php }?>> <?php echo translate('脸部');?>

                                        </label>&nbsp;&nbsp;&nbsp;
                                </span>
                            </div>
                            <div class="help-block inline"></div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('次数');?>
:</label>
                            <div class="col-xs-12 col-sm-4">
                                <span class="block">
                                    <input id="num" name="num" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['num'];?>
" min="1" class="form-control input-width" required />
                                </span>
                            </div>
                            <div class="help-block inline"></div>
                        </div>

                        <div class="form-group">
                            <label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('间隔时间');?>
:</label>
                            <div class="col-xs-12 col-sm-4">
                                <span class="block">
                                    <input id="interval_time" name="interval_time" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['interval_time'];?>
" min="0" class="form-control input-width" required />
                                </span>
                            </div>
                            <div class="help-block inline"><?php echo translate('分钟');?>
</div>
                        </div>

                        <div class="form-group">
                            <label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('多少刀');?>
:</label>
                            <div class="col-xs-12 col-sm-4">
                                <span class="block">
                                    <input id="knife" name="knife" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['knife'];?>
" min="1" class="form-control input-width" required />
                                </span>
                            </div>
                            <div class="help-block inline"></div>
                        </div>

                        <div class="form-group">
                            <label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('服务内容');?>
:</label>
                            <div class="col-xs-12 col-sm-4">
                                    <span class="block">
                                        <textarea id="text" name="text"  class="form-control input-width"  style="height: 128px;" ><?php echo $_smarty_tpl->tpl_vars['row']->value['text'];?>
</textarea>
                                    </span>
                            </div>
                            <div class="help-block inline"></div>
                        </div>

                        <div class="form-group" id="mark">
                            <div class="col-sm-offset-3 col-sm-9">
                                <button type="button" id="saveedit" class="btn  btn-primary btn-lg"><?php echo translate('提交');?>
</button>
                                <a href="javascript:;" id="back" class="btn  btn-pink btn-lg"><i class="fa fa-mail-reply"></i> <?php echo translate('返回');?>
</a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var isbusy = false;

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

        $('#back').click(function(){
            history.back(-1);
        });
        $('#type').change(function(){
            $('.mr-type').hide();
            var type=$("#type option:selected").val();
            if(type==1) $('.mr-type').show();
        });
        $('#saveedit').click(function(){
            if(!$('#submitform').valid())return false;
            if(isbusy)return false;
            isbusy = true;
            tooltipbox.show("<?php echo translate('正在执行操作');?>
");
            $.post('/admin_pack/item_edit/<?php echo $_smarty_tpl->tpl_vars['pack_id']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
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
</script><?php }} ?>
