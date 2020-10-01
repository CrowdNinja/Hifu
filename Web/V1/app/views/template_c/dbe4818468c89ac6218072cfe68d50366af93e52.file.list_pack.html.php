<?php /* Smarty version Smarty-3.1.19, created on 2020-06-25 08:38:51
         compiled from "C:\xampp\htdocs\beauty-server\app\views\pack\list_pack.html" */ ?>
<?php /*%%SmartyHeaderCode:7117649175edccd957dd267-93105308%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'dbe4818468c89ac6218072cfe68d50366af93e52' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beauty-server\\app\\views\\pack\\list_pack.html',
      1 => 1592900383,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7117649175edccd957dd267-93105308',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5edccd958397d2_26429138',
  'variables' => 
  array (
    'get' => 0,
    'gid' => 0,
    'member_store_id' => 0,
    'get_adminid_account' => 0,
    'pack' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5edccd958397d2_26429138')) {function content_5edccd958397d2_26429138($_smarty_tpl) {?><title><?php echo translate('店舗管理');?>
 - <?php echo translate('メニューリスト');?>
</title>
<div class="page-header">
    <h1>
        <?php echo translate('店舗管理');?>
 <small> <i class="ace-icon fa fa-angle-double-right"></i>  <?php echo translate('メニューリスト');?>

    </small>
    </h1>
</div>
<!-- /.page-header -->


<div class="row">
    <div class="col-xs-12">

        <ul class="nav nav-tabs">
            <li class="active"><a href="/admin_system#page/admin_pack/"><?php echo translate('メニューリスト');?>
</a></li>
        </ul>
        <br />

        <div class="panel panel-success">
            <div class="panel-heading" onclick="$(this).parent().find('.panel-body').toggle()"><i class="glyphicon glyphicon-chevron-down"></i> <?php echo translate('スクリーニング');?>
</div>
            <div class="panel-body" style="display:">

                <div class="form-group form-search form-inline">
                    <label class="control-label"><?php echo translate('店舗選択');?>
</label>
                    <input id="adminid" name="adminid" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['adminid'];?>
" style="width:200px" />

                    <label class="control-label"><?php echo translate('メニュー名');?>
</label>
                    <input class="form-control " name="title" id="title" type="text" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['title'];?>
" placeholder="<?php echo translate('メニュー名');?>
">

                    <button class="btn btn-default btn-sm"><i class="fa fa-search"></i> <?php echo translate('検索する');?>
</button>
                </div>
            </div>

        </div>
        <script>
            $(function(){
                //这里处理搜索key，引用 /style/assets/js/jquery.fn.js
                //注意php代码不需要处理搜索URL参数，分页URL的处理注意本页尾的JS代码
                //$.searchURL = function(url = location.href, sConr = '.form-search', sObj = 'input,select,textarea', sJoin = ','){/**/}
                $('.btn-default').click(function(){
                    var url = $.searchURL( location.href );
                    location.href = url;
                });
                $("#adminid").select2({
                    ajax: {
                        url: "/admin_shop/search",
                        data: function (params) {
                            return {
                                keywords: params
                            };
                        },
                        results:function(data,pageNo){
                            if(data.data.length){
                                data['data'].splice(0, 0, {'id':'', 'text': "<?php echo translate('選択してください');?>
"});
                            }else{
                                data['data'] = [{'id':'', 'text': "<?php echo translate('選択してください');?>
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
            <?php if ($_smarty_tpl->tpl_vars['gid']->value==4) {?>
                <?php if ($_smarty_tpl->tpl_vars['member_store_id']->value) {?>
                    $('#adminid').select2('data', {id:"<?php echo $_smarty_tpl->tpl_vars['member_store_id']->value;?>
", text:"<?php echo $_smarty_tpl->tpl_vars['get_adminid_account']->value;?>
"}).select2('val', ["<?php echo $_smarty_tpl->tpl_vars['member_store_id']->value;?>
"]);
                    $("#adminid").prop("disabled", true);
                <?php }?>
            <?php } else { ?>
                <?php if ($_smarty_tpl->tpl_vars['get']->value['adminid']) {?>
                    $('#adminid').select2('data', {id:"<?php echo $_smarty_tpl->tpl_vars['get']->value['adminid'];?>
", text:"<?php echo $_smarty_tpl->tpl_vars['get_adminid_account']->value;?>
"}).select2('val', ["<?php echo $_smarty_tpl->tpl_vars['get']->value['adminid'];?>
"]);
                <?php }?>
            <?php }?>

            });
        </script>
        <form class="form-horizontal" role="form" id="submitform">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th><?php echo translate('番号');?>
</th>
                    <th><?php echo translate('店舗名');?>
</th>
                    <th><?php echo translate('メニュー名');?>
</th>
                    <th><?php echo translate('メニュー価格');?>
</th>
                    <th><?php echo translate('操作');?>
</th>
                </tr>
                </thead>
                <tbody>
                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['pack']->value['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                <tr class="alert1 success" align="left">
                    <td>
                        <?php if ($_smarty_tpl->tpl_vars['gid']->value==1) {?>
                        <input type="checkbox" name="id[]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" />
                        <?php }?>
                        <?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>

                    </td>
                    <td><?php echo $_smarty_tpl->tpl_vars['v']->value['agent_name'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['v']->value['price'];?>
</td>
                    <td >
                        <?php if (chkcommand('/admin_pack/edit')) {?>
                        <a href="admin_system#page/admin_pack/edit/<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="btn btn-success btn-xs"> <i class="fa fa-edit"></i>  <?php echo translate('変更する');?>
</a>
                        <?php }?>
                        <?php if (chkcommand('/admin_pack/pack_item')) {?>
                        <a href="admin_system#page/admin_pack/pack_item/<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="btn btn-info btn-xs"> <i class="fa fa-list"></i>  <?php echo translate('メニューリスト');?>
</a>
                        <?php }?>
                    </td>
                </tr>
                <?php } ?>

                <tr style="position:fixed; bottom:0; width:100%; background:#fff;z-index:9">
                    <td style="border:none" colspan="12"><input type="checkbox" id="checkall" onclick="var ck = this.checked;$('input[name=&quot;id[]&quot;]').each(function(){this.checked = ck});">
                    <?php if ($_smarty_tpl->tpl_vars['gid']->value==1) {?>
                        <?php if (chkcommand('/admin_pack/delete')) {?>
                        <input id="btnDelete" class="btn btn-lg btn-default" value="<?php echo translate('削除する');?>
" type="button">
                        <?php }?>
                        <?php if (chkcommand('/admin_pack/edit')) {?>
                        <a href="/admin_system#page/admin_pack/edit" class="btn  btn-lg btn-primary">+ <?php echo translate('メニューを追加');?>
</a>
                        <?php }?>
                    <?php }?>
                    </td>
                </tr>

                </tbody>
            </table>
            <table   style="width:100%;" class="listpage"><tr><td ><?php echo translate('合計');?>
 <?php echo $_smarty_tpl->tpl_vars['pack']->value['total'];?>
 <?php echo translate('件');?>
 <?php echo $_smarty_tpl->tpl_vars['pack']->value['pages'];?>
  </td></tr></table>

        </form>
    </div>
</div>


<script type="text/javascript">
    var isbusy = false;
    //这里处理分页搜索key，引用 /style/assets/js/jquery.fn.js
    //注意php代码不需要处理搜索URL参数，分页URL的处理注意本页尾的JS代码
    //$.searchURL = function(url = location.href, sConr = '.form-search', sObj = 'input,select,textarea', sJoin = ','){/**/}
    $(function(){
        $('.listpage').find('a').each(function(){
            var url = $.replaceURL( location.href, 'page', $(this).attr('data-ci-pagination-page') );
            $(this).attr('href', url);
        });
        //YYYY-MM-DD HH:mm:ss
       /* $('.datetimepicker').datetimepicker({
            format: 'YYYY-MM-DD',
            language: 'zh-CN',
            pickDate: true,
            pickTime: true,
            hourStep: 1,
            minuteStep: 15,
            secondStep: 30,
            inputMask: true
        });*/
        laydate.render({
            elem: '#ctime1',
        });
        laydate.render({
            elem: '#ctime2'
        });

        $('#btnDelete').click(function(){
            var ckvals = $.selectCK('input[name="id[]"]');
            if(!ckvals){
                tooltipbox.show("<?php echo translate('请选择要操作的数据');?>
");
                return false;
            }
            tooltipbox.confirm("<?php echo translate('确定永久删除选中的数据');?>
？", function(data){
                tooltipbox.show("<?php echo translate('正在执行操作');?>
");
                $.post('/admin_pack/delete', data, function(res){
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
            }, false, { 'ids': ckvals });
        });
        $('#btnClear').click(function(){
            tooltipbox.confirm("<?php echo translate('确定永久清空所有数据？');?>
", function(data){
                tooltipbox.show("<?php echo translate('正在执行操作');?>
");
                $.post('/admin_pack/clear', { }, function(res){
                    if(res.status == '1'){
                        tooltipbox.show("<?php echo translate('操作执行成功');?>
");
                        location.reload();
                    }else{
                        tooltipbox.show("<?php echo translate('数据或网络错误');?>
");
                    }
                }, 'json').error(function(a, b, c){
                    tooltipbox.show("<?php echo translate('数据或网络错误');?>
");
                });
            });
        });
        $('#sortBtn').click(function(){

            var obj = $('input[name="sort"]');
            var str = '';
            obj.each(function(){
                var val = $(this).val();
                var id = $(this).attr('data-id');
                str += id+':'+val+',';
            });
            $.post('/admin_pack/sort', {'str':str}, function(res){
                if(res == '1'){
                    tooltipbox.show("<?php echo translate('操作执行成功');?>
");
                    location.reload();
                }else{
                    tooltipbox.show("<?php echo translate('操作执行失败');?>
");
                }
            });

        });
    });
</script>
<?php }} ?>
