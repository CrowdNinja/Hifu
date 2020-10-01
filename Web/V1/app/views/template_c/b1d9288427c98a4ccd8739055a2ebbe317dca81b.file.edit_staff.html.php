<?php /* Smarty version Smarty-3.1.19, created on 2020-06-07 17:16:07
         compiled from "C:\xampp\htdocs\beauty-server\app\views\staff\edit_staff.html" */ ?>
<?php /*%%SmartyHeaderCode:10746814105edd04b7baaa19-46560683%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b1d9288427c98a4ccd8739055a2ebbe317dca81b' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beauty-server\\app\\views\\staff\\edit_staff.html',
      1 => 1591104997,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10746814105edd04b7baaa19-46560683',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'row' => 0,
    'role_type' => 0,
    'k' => 0,
    'v' => 0,
    'g_list' => 0,
    'admin' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5edd04b7c040b5_89030233',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5edd04b7c040b5_89030233')) {function content_5edd04b7c040b5_89030233($_smarty_tpl) {?><title><?php echo translate('员工管理');?>
 - <?php if ($_smarty_tpl->tpl_vars['row']->value['id']) {?><?php echo translate('编辑');?>
<?php } else { ?><?php echo translate('添加');?>
<?php }?><?php echo translate('员工');?>
 </title>
<!--<div class="page-header">-->
<!--<h1>-->
<!--员工管理-->
<!--<small><i class="ace-icon fa fa-angle-double-right"></i> <?php if ($_smarty_tpl->tpl_vars['row']->value['id']) {?>编辑<?php } else { ?>添加<?php }?>员工-->
<!--</small>-->
<!--</h1>-->
<!--</div>-->
<!-- /.page-header -->
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
                <li><a href="/admin_system#page/admin_staff/"><?php echo translate('员工列表');?>
</a></li>
                <li class="active"><a
                        href="/admin_system#page/admin_staff/edit/<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
"><?php if ($_smarty_tpl->tpl_vars['row']->value['id']) {?><?php echo translate('编辑');?>
<?php } else { ?><?php echo translate('添加');?>
<?php }?><?php echo translate('员工');?>
</a>
                </li>
            </ul>

            <div class="panel panel-default">
                <div class="panel-body table-responsive">

                    <form class="form-horizontal" role="form" id="submitform" action="/admin_staff/edit/<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
"
                          method="post" accept-charset="utf-8">


                        <?php if (!$_smarty_tpl->tpl_vars['row']->value['id']) {?>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('选择类型');?>
*:</label>
                            <div class="col-xs-12 col-sm-5">
                <span class="block">
            	<select name="type" id="type" class="form-control input-width" >
                   <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['role_type']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
					<option value="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
"  ><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</option>
                    <?php } ?>
				</select>
			</span>
                            </div>
                            <div class="help-block inline"></div>
                        </div>

                        <div class="form-group div1">
                            <label class="col-xs-12 col-sm-3 control-label no-padding-right" id="role_name">:</label>
                            <div class="col-xs-12 col-sm-5">
                <span class="block">
            	<select name="parent_id" id="parent_id" class="form-control input-width" >

				</select>
			</span>
                            </div>
                            <div class="help-block inline"></div>
                        </div>

                        <?php }?>


                        <div class="form-group">
                            <label class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('选择角色');?>
*:</label>
                            <div class="col-xs-12 col-sm-5">
                <span class="block">
            	<select name="gid" id="gid" class="form-control input-width" required>
					<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['g_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
					<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['admin']->value['gid']==$_smarty_tpl->tpl_vars['v']->value['id']) {?>selected="selected"<?php }?> ><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</option>
                    <?php } ?>
				</select>
			</span>
                            </div>
                            <div class="help-block inline"></div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('登入账号');?>
*：</label>
                            <div class="col-xs-12 col-sm-5">
                    <span class="block">
                        <input id="adminname" type="text" name="adminname" value="<?php echo $_smarty_tpl->tpl_vars['admin']->value['adminname'];?>
"
                               class="form-control input-width" required/>
                    </span>
                            </div>
                            <div class="help-block inline"></div>
                        </div>

                        <div class="form-group">
                            <label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('登入密码');?>
*：</label>
                            <div class="col-xs-12 col-sm-5">
                    <span class="block">
                        <input id="password" type="password" name="password" value="<?php echo $_smarty_tpl->tpl_vars['admin']->value['password'];?>
"
                               class="form-control input-width" required/>
                    </span>
                            </div>
                            <div class="help-block inline"></div>
                        </div>
                        <?php if (!$_smarty_tpl->tpl_vars['row']->value['id']) {?>
                        <div class="form-group">
                            <label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('重复密码');?>
*：</label>
                            <div class="col-xs-12 col-sm-5">
                    <span class="block">
                        <input id="password1" type="password" name="password" value="<?php echo $_smarty_tpl->tpl_vars['admin']->value['password'];?>
"
                               class="form-control input-width" required/>
                    </span>
                            </div>
                            <div class="help-block inline"></div>
                        </div>
                        <?php }?>



                        <div class="form-group">
                            <label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('员工姓名');?>
*：</label>
                            <div class="col-xs-12 col-sm-5">
                    <span class="block">
                        <input id="name" type="text" name="name" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
"
                               class="form-control input-width" required/>
                    </span>
                            </div>
                            <div class="help-block inline"></div>
                        </div>


                        <div class="form-group">
                            <label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('备注');?>
:</label>
                            <div class="col-xs-12 col-sm-5">
                    <span class="block">
                        <input id="remark" type="text" name="remark" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['remark'];?>
"
                               class="form-control input-width"/>
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

<script type="text/javascript">
    var isbusy = false;
    $(function () {
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
        $('#type').change(function(){
            var type= $("#type option:selected").val();
            $('.div1').hide();
            if(type>0){
                $('.div1').show();
                $.ajax({
                    type:"post",
                    url:"/admin_staff/get_parent",
                    data:{'type':type},
                    dataType: "json",
                    success:function(data) {
                        var arr = data.data.list;
                        var html='<option value="0"  >'+"<?php echo translate('请选择');?>
"+'</option>';
                        var selected='';
                        for(var i=0;i<arr.length;i++){
                            selected='';
                            html+='<option value="'+arr[i]['id']+' " '+selected+' >'+arr[i]['nickname']+'</option>';
                        }
                        $("#parent_id").html(html).change();
                        $('#role_name').text(data.data.role_name)
                    },
                    error:function(xhr){
                        tooltipbox.alert("<?php echo translate('获取失败');?>
");
                        return false;
                    }
                });
            }

        });
        $('#type').change();

        //YYYY-MM-DD HH:mm:ss
        $('.datetimepicker-date').datetimepicker({
            format: 'YYYY-MM-DD',
            language: 'zh-CN',
            pickDate: true,
            pickTime: false,
            hourStep: 1,
            minuteStep: 15,
            secondStep: 30,
            inputMask: true
        });
        //YYYY-MM-DD HH:mm:ss
        $('.datetimepicker').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            language: 'zh-CN',
            pickDate: true,
            pickTime: true,
            hourStep: 1,
            minuteStep: 15,
            secondStep: 30,
            inputMask: true
        });

        $('#saveedit').click(function () {
            if (!$('#submitform').valid()) return false;
            if (isbusy) return false;
            var staff_id="<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
";
            if(!staff_id){
                if($('#password').val()!=$('#password1').val())
                {
                    alert("<?php echo translate('两次输入的密码不一致');?>
");
                    return false;
                }
            }

            isbusy = true;
            tooltipbox.show("<?php echo translate('正在执行操作');?>
");
            $.post('/admin_staff/edit/<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
', $('#submitform').serialize(), function (res) {
                if (res.status == '1') {
                    tooltipbox.show("<?php echo translate('操作完成');?>
");
                    location.href = "/admin_system#page/admin_staff/";
                } else if (res.status == '0') {
                    tooltipbox.alert(res.msg);
                } else {
                    tooltipbox.show("<?php echo translate('数据或网络错误');?>
");
                }
                isbusy = false;
            }, 'json').error(function (a, b, c) {
                tooltipbox.show("<?php echo translate('数据或网络错误');?>
");
                isbusy = false;
            });
        });

    });
</script> <?php }} ?>
