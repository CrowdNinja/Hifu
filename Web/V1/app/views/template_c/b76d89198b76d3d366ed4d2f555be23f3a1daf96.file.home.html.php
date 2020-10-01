<?php /* Smarty version Smarty-3.1.19, created on 2020-06-24 02:34:41
         compiled from "C:\xampp\htdocs\beauty-server\app\views\base\home.html" */ ?>
<?php /*%%SmartyHeaderCode:16343038915ed5b68a673be3-92310209%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b76d89198b76d3d366ed4d2f555be23f3a1daf96' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beauty-server\\app\\views\\base\\home.html',
      1 => 1592911955,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16343038915ed5b68a673be3-92310209',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5ed5b68a6cf624_81297619',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ed5b68a6cf624_81297619')) {function content_5ed5b68a6cf624_81297619($_smarty_tpl) {?><title><?php echo translate('首頁');?>
</title>

<script>
  setTimeout("redirect()", 1);
  function redirect(){
    location.href='/admin_system#page/admin_reservation';
  }
</script>
<?php }} ?>
