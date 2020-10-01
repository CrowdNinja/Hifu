<?php /* Smarty version Smarty-3.1.19, created on 2020-06-29 13:25:02
         compiled from "C:\xampp\htdocs\beauty-server\app\views\bguser\edit_setting.html" */ ?>
<?php /*%%SmartyHeaderCode:10249920125ef9cf8e253d49-59010078%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '601221a23c2828cadd0cffdfebbd293b43959d22' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beauty-server\\app\\views\\bguser\\edit_setting.html',
      1 => 1592793966,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10249920125ef9cf8e253d49-59010078',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'row' => 0,
    'k' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5ef9cf8e308a89_64031800',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ef9cf8e308a89_64031800')) {function content_5ef9cf8e308a89_64031800($_smarty_tpl) {?><title><?php echo translate('系統設置');?>
-<?php echo translate('编辑设置');?>
 </title>
<div class="page-header">
	<h1>
		<?php echo translate('系統設置');?>
 <small> <i class="ace-icon fa fa-angle-double-right"></i> <?php echo translate('编辑设置');?>

		</small>
	</h1>
</div>
<!-- /.page-header -->
	<script>window.UEDITOR_HOME_URL = '/app/third_party/ueditor1_4_3_3-utf8-php/';</script>
    <script type="text/javascript" charset="utf-8" src="/app/third_party/ueditor1_4_3_3-utf8-php/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/app/third_party/ueditor1_4_3_3-utf8-php/ueditor.all.min.js"> </script>
    <script type="text/javascript" charset="utf-8" src="/app/third_party/ueditor1_4_3_3-utf8-php/lang/en/en.js"></script>
	<script type="text/plain" id="j_ueditorupload" style="height:5px;display:none;" ></script>
    <script type="text/javascript" charset="utf-8" src="/app/third_party/ueditor1_4_3_3-utf8-php/ueditor.upload.js"></script>

<div class="row">
	<div class="col-md-12">
<div class="main">
    <ul class="nav nav-tabs">
        <li><a href="/admin_system#page/admin_setting/"><?php echo translate('系統設置');?>
</a></li>
        <li class="active"><a href="/admin_system#page/admin_setting/edit/<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
"><?php echo translate('编辑设置');?>
</a></li>
    </ul>

  <div class="panel panel-default">
        <div class="panel-body table-responsive">
        
        		<form class="form-horizontal" role="form" id="submitform" enctype="multipart/form-data" action="/admin_setting/edit/<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
" data-action="/admin_setting/edit/<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
" method="post" accept-charset="utf-8">
			
            <div class="form-group">
		<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('标题');?>
*:</label>
		<div class="col-xs-12 col-sm-2">
			<span class="block">
				<?php echo $_smarty_tpl->tpl_vars['row']->value['title'];?>

			</span>
		</div>
		<div class="help-block inline"></div>
	</div>
    
         	
    <div class="form-group">
		<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('变量名');?>
:</label>
		<div class="col-xs-12 col-sm-2">
			<span class="block">
            	<?php echo $_smarty_tpl->tpl_vars['row']->value['key'];?>

			</span>
		</div>
		<div class="help-block inline"></div>
	</div>


		<?php if ($_smarty_tpl->tpl_vars['row']->value['key']=='question') {?>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('退款原因');?>
:</label>
						<div class="col-xs-12 col-sm-9">

							<div>
								<table class="table table-bordered table-hover">
									<thead>
									<tr>
										<th><?php echo translate('日文');?>
</th>
										<th><?php echo translate('中文');?>
</th>
										<th></th>
									</tr>
									</thead>
									<tbody>
									<?php if (count($_smarty_tpl->tpl_vars['row']->value['val']['fault_type'])) {?>
									<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['row']->value['val']['fault_type']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
									<tr class="row-table">
										<td class="col-table"><input id="val[fault_type][]" placeholder="" type="text" name="val[fault_type][]" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['val']['fault_type'][$_smarty_tpl->tpl_vars['k']->value];?>
" class="form-control input-width" /></td>
										<td class="col-table"><input id="val[fault_type1][]" placeholder="" type="text" name="val[fault_type1][]" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['val']['fault_type1'][$_smarty_tpl->tpl_vars['k']->value];?>
" class="form-control input-width" /></td>
										<td><a href="javascript:;" onClick="addItem(this)" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-plus"></i></a>
											<a href="javascript:;" onClick="deleteItem(this)" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-minus"></i></a>
										</td>
									</tr>

									<?php } ?>
									<?php } else { ?>
									<tr class="row-table">
										<td class="col-table"><input id="val[fault_type][]" placeholder="" type="text" name="val[fault_type][]" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['val']['fault_type'][$_smarty_tpl->tpl_vars['k']->value];?>
" class="form-control input-width" /></td>
										<td class="col-table"><input id="val[fault_type1][]" placeholder="" type="text" name="val[fault_type1][]" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['val']['fault_type1'][$_smarty_tpl->tpl_vars['k']->value];?>
" class="form-control input-width" /></td>
										<td><a href="javascript:;" onClick="addItem(this)" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-plus"></i></a>
											<a href="javascript:;" onClick="deleteItem(this)" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-minus"></i></a>
										</td>
									</tr>
									<?php }?>
									</tbody>
								</table>
							</div>

						</div>
					</div>
        <?php }?>

        
          <?php if ($_smarty_tpl->tpl_vars['row']->value['key']=='setting') {?>


 <div class="panel panel-info">
        <div class="panel-heading">
            其它设置
        </div>
    </div>
					<div class="form-group">
						<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('logo');?>
</label>
						<input type="hidden" name="val[logo]" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['val']['logo'];?>
" />
						<div class="col-xs-12 col-sm-5">
							<div class="upfile_imgthumb">
								<img src="<?php if ($_smarty_tpl->tpl_vars['row']->value['val']['logo']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['val']['logo'];?>
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

					<div class="form-group">
						<label class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('轮播图');?>
:</label>
						<textarea name="val[img]" style="display:none"><?php echo $_smarty_tpl->tpl_vars['row']->value['val']['img'];?>
</textarea>
						<div class="col-xs-12 col-sm-5">
                        <span class="block">
                            <div class="thumb1">
                            <?php if ($_smarty_tpl->tpl_vars['row']->value['val']['img']) {?>
                                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = explode("\n",str_replace("\r",'',$_smarty_tpl->tpl_vars['row']->value['val']['img'])); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                                <div class="upfile_imgthumb">
                                    <img src="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" data-default="/style/xin_inselimgs.png" class="btn-upfile" data-multi="1">
                                <div class="upfile_imgcaption">
                                    <a href="javascript:;" data-src="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
"   data-multi="1" class="btn btn-primary btn-xs btn-upfile"><?php echo translate('上传');?>
</a>
                                    <a href="javascript:;" data-src="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" data-multi="1" class="btn btn-default btn-xs btn-upremove"><?php echo translate('删除');?>
</a>
                                </div>
                                </div>
                                <?php } ?>
                            <?php }?>
                            </div>
                            <a href="javascipt:;" class="btn btn-upfile btn-primary btn-sm" style="width:121px" data-multi="1" data-conr=".thumb1">+ <?php echo translate('上传图片');?>
</a>
                        </span>
						</div>
						<div class="help-block inline"></div>
					</div>

					<div class="form-group">
						<label class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('人民币转日元汇率');?>
:</label>
						<div class="col-xs-12 col-sm-2">
			<span class="block">
            	<input type="text" id="val[exchange]" name="val[exchange]" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['val']['exchange'];?>
" class="form-control input-width" />
			</span>
						</div>
						<div class="help-block inline"><?php echo translate('一元人民币等于多少日元');?>
</div>
					</div>
					<!--<div class="form-group">
						<label class="col-xs-12 col-sm-3 control-label no-padding-right">客服电话:</label>
						<div class="col-xs-12 col-sm-2">
			<span class="block">
            	<input type="text" id="val[tel]" name="val[tel]" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['val']['tel'];?>
" class="form-control input-width" />
			</span>
						</div>
						<div class="help-block inline"></div>
					</div>-->
        
   	<?php }?>
   
        <?php if ($_smarty_tpl->tpl_vars['row']->value['key']=='config') {?>


 <div class="panel panel-info">
        <div class="panel-heading">
            分成设置
        </div>
    </div>   
    
    <div class="form-group">
		<label class="col-xs-12 col-sm-3 control-label no-padding-right">分成方式:</label>
		<div class="col-xs-12 col-sm-2">
			<span class="block">
            	<select id="val[percen][type]" name="val[percen][type]" class="form-control input-width">
                	<option value="0" <?php if (!$_smarty_tpl->tpl_vars['row']->value['val']['percen']['type']) {?>selected<?php }?> >按交易额</option>
                    <option value="1" <?php if ($_smarty_tpl->tpl_vars['row']->value['val']['percen']['type']==1) {?>selected<?php }?> >代理优先</option>
                    <option value="2" <?php if ($_smarty_tpl->tpl_vars['row']->value['val']['percen']['type']==2) {?>selected<?php }?> >商家优先</option>
                    <option value="3" <?php if ($_smarty_tpl->tpl_vars['row']->value['val']['percen']['type']==3) {?>selected<?php }?> >代理分成</option>
                </select>
			</span>
		</div>
        <div class="help-block inline">* “按交易额”时都按交易总额分成；
        <br />“代理或商家优先”时，先按比例优先分成，剩余部分再继续分成；
        <br />“代理分成”时，先按比例分成给代理，代理部分再分成给商家；
        <br />仅选择“代理分成”时，才允许独立给代理/商家设置不同分成。</div>
	</div>
    
    <div class="form-group">
		<label class="col-xs-12 col-sm-3 control-label no-padding-right">允许代理设置商家分成:</label>
		<div class="col-xs-12 col-sm-2">
			<span class="block">
            	<select id="val[corp][shop]" name="val[corp][shop]" class="form-control input-width">
                	<option value="0" <?php if (!$_smarty_tpl->tpl_vars['row']->value['val']['corp']['shop']) {?>selected<?php }?> >否</option>
                    <option value="1" <?php if ($_smarty_tpl->tpl_vars['row']->value['val']['corp']['shop']==1) {?>selected<?php }?> >是</option>
                </select>
			</span>
		</div>
        <div class="help-block inline">* 仅分成方式选择“代理分成”时，才生效，代理需有商家列表/编辑/保存权限。</div>
	</div>

	<div class="form-group">
		<label class="col-xs-12 col-sm-3 control-label no-padding-right">代理商分成:</label>
		<div class="col-xs-12 col-sm-2">
			<span class="block">
            	<input type="text" id="val[corp][percen]" name="val[corp][percen]" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['val']['corp']['percen'];?>
" class="form-control input-width" />
			</span>
		</div>
        <div class="help-block inline">%</div>
	</div>
    
    <div class="form-group">
		<label class="col-xs-12 col-sm-3 control-label no-padding-right">商家分成:</label>
		<div class="col-xs-12 col-sm-2">
			<span class="block">
            	<input type="text" id="val[shop][percen]" name="val[shop][percen]" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['val']['shop']['percen'];?>
" class="form-control input-width" />
			</span>
		</div>
        <div class="help-block inline">%</div>
	</div>
           
     <!--  <div class="form-group">
		<label class="col-xs-12 col-sm-3 control-label no-padding-right">商家推荐分成:</label>
		<div class="col-xs-12 col-sm-2">
			<span class="block">
            	<input type="text" id="val[shop][recmdpercen]" name="val[shop][recmdpercen]" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['val']['shop']['recmdpercen'];?>
" class="form-control input-width" />
			</span>
		</div>
        <div class="help-block inline">%</div>
	</div>
             
    <div class="form-group">
		<label class="col-xs-12 col-sm-3 control-label no-padding-right">会员推荐分成:</label>
		<div class="col-xs-12 col-sm-2">
			<span class="block">
            	<input type="text" id="val[user][recmdpercen]" name="val[user][recmdpercen]" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['val']['user']['recmdpercen'];?>
" class="form-control input-width" />
			</span>
		</div>
        <div class="help-block inline">%</div>
	</div>-->
    
    <div class="form-group">
		<label class="col-xs-12 col-sm-3 control-label no-padding-right">示例:</label>
		<div class="col-xs-12 col-sm-9">
			<span class="block config_demo" style="font-size:18px">
            	
			</span>
		</div>
    </div>

<script>
$(function(){
	$('input,select').change(function(){
		var html = '总交易额：100.00元<br>';
		var type = $('[id="val[percen][type]"]').val();
		var corp = $('[id="val[corp][percen]"]').val();
		var shop = $('[id="val[shop][percen]"]').val();
		var corp_money = 0;
		var shop_money = 0;
		var corp_exp = '';
		var shop_exp = '';
		switch(type){
			case '0':
				corp_money = (corp * 1).toFixed(2);
				shop_money = (shop * 1).toFixed(2);
				corp_exp = '100.00 * ' + corp + '% = ';
				shop_exp = '100.00 * ' + shop + '% = ';
				break;
			case '1':
				corp_money = (corp * 1).toFixed(2);
				shop_money = ((100 - corp) * shop / 100).toFixed(2);
				corp_exp = '100.00 * ' + corp + '% = ';
				shop_exp = '((100.00 - (100.00 * ' + corp + '%)) * ' + shop + '%) = ';
				break;
			case '2':
				shop_money = (shop * 1).toFixed(2);
				corp_money = ((100 - shop) * corp / 100).toFixed(2);
				shop_exp = '100.00 * ' + shop + '% = ';
				corp_exp = '((100.00 - (100.00 * ' + shop + '%)) * ' + corp + '%) = ';
				break;
			case '3':
				corp_money = (corp * 1).toFixed(2);
				shop_money = (corp * shop / 100).toFixed(2);
				corp_exp = '100.00 * ' + corp + '% = ';
				shop_exp = '(100.00 * ' + corp + '%) * ' + shop + '% = ';
				break;
		}
		html += '代理分成：' + corp_exp + corp_money + '元<br/>';
		html += '商家分成：' + shop_exp + shop_money + '元<br/>';
		$('.config_demo').html(html);
	});
	$('input,select').change();
});
</script>    
        
        <?php }?>
        
        <?php if ($_smarty_tpl->tpl_vars['row']->value['key']=='recharge') {?>
					<!--<div class="form-group">
						<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right">最低充值金额（元）:</label>
						<div class="col-xs-12 col-sm-4">
                    <span class="block">
                        <input id="val[min_recharge_money]" type="text" name="val[min_recharge_money]" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['val']['min_recharge_money'];?>
" class="form-control input-width" />
                    </span>
						</div>
					</div>-->
        <div class="form-group">
		<label class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('套餐');?>
:</label>
		<div class="col-xs-12 col-sm-9">

<div>
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th><?php echo translate('充值金额');?>
 (<?php echo translate('元');?>
)</th>
								<th><?php echo translate('赠送金额');?>
 (<?php echo translate('元');?>
)</th>
                                <th></th>
							</tr>
						</thead>
						<tbody>   
                        <?php if (count($_smarty_tpl->tpl_vars['row']->value['val']['money'])) {?>
                        	<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['row']->value['val']['money']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                        	<tr class="row-table"> 
      <td class="col-table"><input id="val[money][]" min="1" placeholder="" type="text" name="val[money][]" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['val']['money'][$_smarty_tpl->tpl_vars['k']->value];?>
" class="form-control input-width" /></td>
      <td class="col-table"><input id="val[redmoney][]" min="1" placeholder="" type="text" name="val[redmoney][]" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['val']['redmoney'][$_smarty_tpl->tpl_vars['k']->value];?>
" class="form-control input-width" /></td>
      <td><span class="input-group-btn"><a href="javascript:;" onClick="addItem(this)" class="btn"><i class="glyphicon glyphicon-plus"></i></a></span>
      <span class="input-group-btn"><a href="javascript:;" onClick="deleteItem(this)" class="btn"><i class="glyphicon glyphicon-minus"></i></a></span>
      </td>
    						</tr>
                            <?php } ?>
                          <?php } else { ?> 
                          <tr class="row-table"> 
      <td class="col-table"><input id="val[money][]" placeholder="" min="1" type="text" name="val[money][]" value="" class="form-control input-width" /></td>
      <td class="col-table"><input id="val[redmoney][]" placeholder="" min="1" type="text" name="val[redmoney][]" value="" class="form-control input-width" /></td>
      <td><span class="input-group-btn"><a href="javascript:;" onClick="addItem(this)" class="btn"><i class="glyphicon glyphicon-plus"></i></a></span>
      <span class="input-group-btn"><a href="javascript:;" onClick="deleteItem(this)" class="btn"><i class="glyphicon glyphicon-minus"></i></a></span>
      </td>
    						</tr> 
                        <?php }?>
    				   </tbody>
                    </table>
</div>    
        
        </div>
        </div>
        
        <?php }?>
					<?php if ($_smarty_tpl->tpl_vars['row']->value['key']=='about') {?>
					<div class="form-group">
						<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('logo');?>
</label>
						<input type="hidden" name="val[logo]" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['val']['logo'];?>
" />
						<div class="col-xs-12 col-sm-5">
							<div class="upfile_imgthumb">
								<img src="<?php if ($_smarty_tpl->tpl_vars['row']->value['val']['logo']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['val']['logo'];?>
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
				
					<div class="form-group">
						<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('联系电话');?>
:</label>
						<div class="col-xs-12 col-sm-5">
                    <span class="block">
                        <input id="val[phone]" type="text" name="val[phone]" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['val']['phone'];?>
" class="form-control input-width" />
                    </span>
						</div>
					</div>

					<div class="form-group">
						<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('客服热线');?>
:</label>
						<div class="col-xs-12 col-sm-5">
                    <span class="block">
                        <input id="val[kf]" type="text" name="val[kf]" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['val']['kf'];?>
" class="form-control input-width" />
                    </span>
						</div>
					</div>

					<div class="form-group">
						<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('公司名称');?>
:</label>
						<div class="col-xs-12 col-sm-5">
                    <span class="block">
                        <input id="val[company_name]" type="text" name="val[company_name]" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['val']['company_name'];?>
" class="form-control input-width" />
                    </span>
						</div>
					</div>
					<div class="form-group">
						<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('公司英文名称');?>
:</label>
						<div class="col-xs-12 col-sm-5">
                    <span class="block">
                        <input id="val[english]" type="text" name="val[english]" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['val']['english'];?>
" class="form-control input-width" />
                    </span>
						</div>
					</div>
					<?php }?>
					<?php if ($_smarty_tpl->tpl_vars['row']->value['key']=='mr') {?>
					<div class="form-group">
						<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('图片');?>
</label>
						<input type="hidden" name="val[img]" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['val']['img'];?>
" />
						<div class="col-xs-12 col-sm-5">
							<div class="upfile_imgthumb">
								<img src="<?php if ($_smarty_tpl->tpl_vars['row']->value['val']['img']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['val']['img'];?>
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
					<?php }?>
					<?php if ($_smarty_tpl->tpl_vars['row']->value['key']=='tm') {?>
					<div class="form-group">
						<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('图片');?>
</label>
						<input type="hidden" name="val[img]" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['val']['img'];?>
" />
						<div class="col-xs-12 col-sm-5">
							<div class="upfile_imgthumb">
								<img src="<?php if ($_smarty_tpl->tpl_vars['row']->value['val']['img']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['val']['img'];?>
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
					<?php }?>
        <?php if ($_smarty_tpl->tpl_vars['row']->value['key']=='help'||$_smarty_tpl->tpl_vars['row']->value['key']=='contact'||$_smarty_tpl->tpl_vars['row']->value['key']=='service'||$_smarty_tpl->tpl_vars['row']->value['key']=='rent'||$_smarty_tpl->tpl_vars['row']->value['key']=='prompt'||$_smarty_tpl->tpl_vars['row']->value['key']=='mr'||$_smarty_tpl->tpl_vars['row']->value['key']=='tm') {?>
        
        <?php if ($_smarty_tpl->tpl_vars['row']->value['key']=='contact') {?>
                <div class="form-group">
                <label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('手机');?>
:</label>
                <div class="col-xs-12 col-sm-5">
                    <span class="block">
                        <input id="val[mobile]" type="text" name="val[mobile]" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['val']['mobile'];?>
" class="form-control input-width" />
                    </span>
                </div>
            </div>
        <?php }?>

        <div class="form-group">
		<label class="col-xs-12 col-sm-3 control-label no-padding-right"><?php echo translate('内容');?>
:</label>
		<div class="col-xs-12 col-sm-5">
			<span class="block">
            	<script id="editor" type="text/plain" style="width:620px;height:300px;"></script>
				<textarea id="val[text]" name="val[text]" style="display:none"><?php echo $_smarty_tpl->tpl_vars['row']->value['val']['text'];?>
</textarea>
			</span>
		</div>
	</div>
        
        <?php }?>
        
     
     <?php if ($_smarty_tpl->tpl_vars['row']->value['key']=='weixin_share') {?>
     

    
     <div class="form-group">
		<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right">标题:</label>
		<div class="col-xs-12 col-sm-5">
			<span class="block">
				<input id="val[default][title]" type="text" name="val[default][title]" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['val']['default']['title'];?>
" class="form-control input-width" />
			</span>
		</div>
		<div class="help-block inline">* 支持变量会员昵称 {$nickname}</div>
	</div>
    
    <div class="form-group">
		<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right">描述:</label>
		<div class="col-xs-12 col-sm-5">
			<span class="block">
				<input id="val[default][desc]" type="text" name="val[default][desc]" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['val']['default']['desc'];?>
" class="form-control input-width" />
			</span>
		</div>
		<div class="help-block inline">* 支持变量会员昵称 {$nickname}</div>
	</div>
    
			<div class="form-group">
				<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right">图片:</label>
    			<input type="hidden" name="val[default][thumb]" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['val']['default']['thumb'];?>
" />
				<div class="col-xs-12 col-sm-5">
                	<div class="upfile_imgthumb">
                        <img src="<?php if ($_smarty_tpl->tpl_vars['row']->value['val']['default']['thumb']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['val']['default']['thumb'];?>
<?php } else { ?>/style/xin_inselimg.png<?php }?>" data-default="/style/xin_inselimg.png" class="btn-prefile">
                        <div class="upfile_imgcaption">
                                <a href="javascript:;" class="btn btn-primary btn-xs btn-upfile">上传</a> 
                                <a href="javascript:;" class="btn btn-default btn-xs btn-upremove">删除</a>
                        </div>
                    </div>
				</div>
				<div class="help-block inline"></div>
			</div>
     
     
        <?php }?>
     
     
     <?php if ($_smarty_tpl->tpl_vars['row']->value['key']=='weixin_subscribe') {?>
     
       
    
     <div class="form-group">
		<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right">标题:</label>
		<div class="col-xs-12 col-sm-5">
			<span class="block">
				<input id="val[default][title]" type="text" name="val[default][title]" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['val']['default']['title'];?>
" class="form-control input-width" />
			</span>
		</div>
		<div class="help-block inline"></div>
	</div>
    
    <div class="form-group">
		<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right">描述:</label>
		<div class="col-xs-12 col-sm-5">
			<span class="block">
				<input id="val[default][desc]" type="text" name="val[default][desc]" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['val']['default']['desc'];?>
" class="form-control input-width" />
			</span>
		</div>
		<div class="help-block inline"></div>
	</div>
    
    <div class="form-group">
		<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right">链接:</label>
		<div class="col-xs-12 col-sm-5">
			<span class="block">
				<input id="val[default][url]" type="text" name="val[default][url]" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['val']['default']['url'];?>
" class="form-control input-width" />
			</span>
		</div>
		<div class="help-block inline"></div>
	</div>
    
			<div class="form-group">
				<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right">图片:</label>
    			<input type="hidden" name="val[default][thumb]" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['val']['default']['thumb'];?>
" />
				<div class="col-xs-12 col-sm-5">
                	<div class="upfile_imgthumb">
                        <img src="<?php if ($_smarty_tpl->tpl_vars['row']->value['val']['default']['thumb']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['val']['default']['thumb'];?>
<?php } else { ?>/style/xin_inselimg.png<?php }?>" data-default="/style/xin_inselimg.png" class="btn-prefile">
                        <div class="upfile_imgcaption">
                                <a href="javascript:;" class="btn btn-primary btn-xs btn-upfile">上传</a> 
                                <a href="javascript:;" class="btn btn-default btn-xs btn-upremove">删除</a>
                        </div>
                    </div>
				</div>
				<div class="help-block inline"></div>
			</div>
     
          
        <?php }?>
     
     
     <?php if ($_smarty_tpl->tpl_vars['row']->value['key']=='banner') {?>

                 
			<div class="form-group">
		<label for="title" class="col-xs-12 col-sm-3 control-label no-padding-right">上传图片:</label>
		<textarea name="val[0]" style="display:none"><?php echo $_smarty_tpl->tpl_vars['row']->value['val'][0];?>
</textarea>
		<textarea name="val[1]" style="display:none"><?php echo $_smarty_tpl->tpl_vars['row']->value['val'][1];?>
</textarea>
		<div class="col-xs-12 col-sm-5">
			<span class="block">
                <div class="banner">
                <?php if (count($_smarty_tpl->tpl_vars['row']->value['val'][0])) {?>
                	<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = explode("\n",str_replace("\r",'',$_smarty_tpl->tpl_vars['row']->value['val'][0])); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                    <?php if ($_smarty_tpl->tpl_vars['v']->value) {?>
<div class="upfile_imgthumb">
<img src="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" data-default="/style/xin_inselimg.png" class="btn-prefile" data-multi="1">
<div class="upfile_imgcaption">
<input type="text" class="input-uplink" value="<?php echo getarr4key($_smarty_tpl->tpl_vars['row']->value['val'][1],$_smarty_tpl->tpl_vars['k']->value,"\r\n");?>
" placeholder="图片链接" />
<a href="javascript:;" data-src="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" data-multi="1" class="btn btn-primary btn-xs btn-upfile">上传</a>
<a href="javascript:;" data-src="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" data-multi="1" class="btn btn-default btn-xs btn-upremove">删除</a>
</div>


</div>					<?php }?>
                    <?php } ?>
                    <?php }?>
                </div>
                <a href="javascipt:;" class="btn btn-upfile btn-primary btn-sm" style="width:121px" data-multi="1" data-conr=".banner">+ 上传图片</a>
			</span>
		</div>
		<div class="help-block inline"></div>
	</div>

     <?php }?>
     
			 
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
function addItem(obj)
{
    var $inputgroup = $(obj).closest('.row-table');
	var $inputgroup_clone = $inputgroup.clone();
    $inputgroup.after($inputgroup_clone).next('.row-table').find('input').val('');
}

function deleteItem(obj)
{
    if($(obj).closest('.row-table').parent().find('i.glyphicon-minus').size() <= 1) return;
    $(obj).closest('.row-table').remove();
}
$(function(){
	if($('#editor').length > 0){
		var ue = UE.getEditor('editor');
		ue.ready(function() {
			this.setContent($('#editor').next().val());
		})
	}
	
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
		if(isbusy)return false;
		isbusy = true;
		tooltipbox.show("<?php echo translate('正在执行操作');?>
");
		if($('#editor').length > 0){
			$('#editor').next().val(ue.getContent());	
		}
		$.post('/admin_setting/edit/<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
', $('#submitform').serialize(), function(res){
			if(res.status == '1'){
				tooltipbox.show("<?php echo translate('操作完成');?>
");
				location.href = '/admin_system#page/admin_setting/';
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
