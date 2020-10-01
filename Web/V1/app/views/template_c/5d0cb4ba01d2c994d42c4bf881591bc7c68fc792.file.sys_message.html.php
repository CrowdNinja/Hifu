<?php /* Smarty version Smarty-3.1.19, created on 2020-06-08 03:32:28
         compiled from "C:\xampp\htdocs\beauty-server\app\views\sys_message.html" */ ?>
<?php /*%%SmartyHeaderCode:2492621825edd952c7c7153-27558630%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5d0cb4ba01d2c994d42c4bf881591bc7c68fc792' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beauty-server\\app\\views\\sys_message.html',
      1 => 1591104997,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2492621825edd952c7c7153-27558630',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'data' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5edd952c80ad79_21941126',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5edd952c80ad79_21941126')) {function content_5edd952c80ad79_21941126($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 
</head>

<body>
<br /><br /><br />
    <table width="400px" cellspacing="0" cellpadding="5" class="border_table_org" align="center" >
        <thead>
        <tr><th></th></tr>
        </thead>
        <tbody>
        <tr>
            <td>
                <div align="center"><br />
                    <div style="color:red;font-weight:bold"><?php echo $_smarty_tpl->tpl_vars['data']->value['msg'];?>
</div>
                    <br />
                    <br />
                    <br />
                    <br />
                    <?php if ($_smarty_tpl->tpl_vars['data']->value['auto']) {?>
                        <script>
                            function redirect($url)
                            {
                                location = $url;
                            }
                            setTimeout("redirect('/admin_system#page<?php echo $_smarty_tpl->tpl_vars['data']->value['goto'];?>
');", <?php echo $_smarty_tpl->tpl_vars['data']->value['pause'];?>
);
                        </script>
                        <a href="/admin_system#page<?php echo $_smarty_tpl->tpl_vars['data']->value['goto'];?>
" style="text-decoration:underline"><?php echo translate('页面正在自动转向，你也可以点此直接跳转');?>
</a>
                        <br />
                        <br />
                        <br />
                        <br />
                    <?php }?>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</body>
</html><?php }} ?>
