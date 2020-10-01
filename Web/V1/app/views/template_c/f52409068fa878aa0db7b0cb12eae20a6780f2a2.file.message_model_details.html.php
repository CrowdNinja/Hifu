<?php /* Smarty version Smarty-3.1.19, created on 2020-06-07 16:18:10
         compiled from "C:\xampp\htdocs\beauty-server\app\views\user\message_model_details.html" */ ?>
<?php /*%%SmartyHeaderCode:7028114965edcf722819bf7-80678222%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f52409068fa878aa0db7b0cb12eae20a6780f2a2' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beauty-server\\app\\views\\user\\message_model_details.html',
      1 => 1591104997,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7028114965edcf722819bf7-80678222',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'row' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5edcf72284a128_80888025',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5edcf72284a128_80888025')) {function content_5edcf72284a128_80888025($_smarty_tpl) {?><!-- /.page-header -->

<div class="row">
	<div class="col-md-12">
<div class="main">
    <ul class="nav nav-tabs">
        <li><a href="javascript:;" class="back"><?php echo translate('消息列表');?>
</a></li>
        <li class="active"><a href="/admin_system#page/admin_user/message_model"><?php echo translate('消息详情');?>
</a></li>
    </ul>

  <div class="panel panel-default">
        <div class="panel-body table-responsive">

        		<form class="form-horizontal" role="form" id="submitform" action="/admin_user/message_model/<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
" method="post" accept-charset="utf-8">

                    <div class="form-group">
                        <label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('图片');?>
:</label>
                        <div class="col-xs-12 col-sm-4">
                            <span class="block">
                                            <div class="upfile_imgthumb">
                                                <img src="<?php echo $_smarty_tpl->tpl_vars['row']->value['img'];?>
"    class="img-prefile">
                                            </div>
                            </span>
                        </div>
                        <div class="help-block inline"></div>
                    </div>
                    <div class="form-group">
                        <label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('标题');?>
:</label>
                        <div class="col-xs-12 col-sm-4">
                            <span class="block">
                                <input type="text" name="title" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['title'];?>
" class="form-control input-width" />
                            </span>
                        </div>
                        <div class="help-block inline"></div>
                    </div>

                    <div class="form-group">
                        <label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('内容');?>
:</label>
                        <div class="col-xs-12 col-sm-4">
			<span class="block">
				<textarea id="content" type="text" name="content"  style="height: 150px;" class="form-control input-width" ><?php echo $_smarty_tpl->tpl_vars['row']->value['content'];?>
 </textarea>
			</span>
                        </div>
                        <div class="help-block inline"></div>
                    </div>


                    <div class="form-group">
				<div class="col-sm-offset-3 col-sm-9">
					<button type="button"  class=" back btn  btn-primary btn-lg"><?php echo translate('返回');?>
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

$(function(){
	$('.back').click(function(){
        history.back(-1);
	});
    $('.img-prefile').viewer('destroy').viewer({});
    $('.img-prefile').parent().off('click', '.viewer-canvas').on('click', '.viewer-canvas', function(e){
        var _con = $(this).find('img');
        if(_con && !_con.is(e.target) && _con.has(e.target).length === 0){
            $('.img-prefile').viewer('hide');
        }
    });
});
</script> <?php }} ?>
