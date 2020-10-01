<?php /* Smarty version Smarty-3.1.19, created on 2020-06-22 10:33:06
         compiled from "C:\xampp\htdocs\beauty-server\app\views\subsc\edit.html" */ ?>
<?php /*%%SmartyHeaderCode:13138420905edd1041dae418-19011946%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '24f6dd6725fe39918cf358c4cf26be57d19c76a1' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beauty-server\\app\\views\\subsc\\edit.html',
      1 => 1592793966,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13138420905edd1041dae418-19011946',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5edd1041de42d7_38678482',
  'variables' => 
  array (
    'pack' => 0,
    'pack_items' => 0,
    'index' => 0,
    'pack_item' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5edd1041de42d7_38678482')) {function content_5edd1041de42d7_38678482($_smarty_tpl) {?>
<title><?php echo translate('サブスク管理');?>
 - <?php echo translate('サブスクメニューの新規追加');?>
</title>

<script>window.UEDITOR_HOME_URL = '/app/third_party/ueditor1_4_3_3-utf8-php/';</script>
    <script type="text/javascript" charset="utf-8" src="/app/third_party/ueditor1_4_3_3-utf8-php/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/app/third_party/ueditor1_4_3_3-utf8-php/ueditor.all.min.js"> </script>
    <!--<script type="text/javascript" charset="utf-8" src="/app/third_party/ueditor1_4_3_3-utf8-php/lang/en/en.js"></script>-->
    <script type="text/javascript" charset="utf-8" src="/app/third_party/ueditor1_4_3_3-utf8-php/lang/en/en.js"></script>
	<script type="text/plain" id="j_ueditorupload" style="height:5px;display:none;" ></script>
    <script type="text/javascript" charset="utf-8" src="/app/third_party/ueditor1_4_3_3-utf8-php/ueditor.upload.js"></script>
	<script type="text/javascript" src="/style/js/cnarealist.js"></script>    
	<script type="text/javascript" src="/style/js/categorys/categorys.js"></script>    
    <link rel="stylesheet" href="/style/js/categorys/categorys.css" />
<script language='javascript' src="/style/assets/js/jquery.dialogBox.js"></script>
<link rel="stylesheet" href="/style/assets/js/jquery.dialogbox.css" />

<div class="row">
	<div class="col-xs-12">
    <h3>サブスクメニューの新規追加</h3>
    <form class="form-horizontal" role="form" id="submitform" action="/admin_subscription/edit/<?php echo $_smarty_tpl->tpl_vars['pack']->value['id'];?>
" method="post" accept-charset="utf-8">
        <div class="subsc-image-box">
            <input type="hidden" name="thumb" value="<?php echo $_smarty_tpl->tpl_vars['pack']->value->image;?>
" />
            <!-- <div class="upfile_imgthumb">
                <img src="<?php if ($_smarty_tpl->tpl_vars['pack']->value->image) {?><?php echo $_smarty_tpl->tpl_vars['pack']->value->image;?>
<?php } else { ?>/style/xin_inselimg.png<?php }?>" data-default="/style/xin_inselimg.png" class="btn-upfile">
                <div class="upfile_imgcaption">
                    <a href="javascript:;" class="btn btn-primary btn-xs btn-upfile"><?php echo translate('上传');?>
</a>
                    <a href="javascript:;" class="btn btn-default btn-xs btn-upremove"><?php echo translate('删除');?>
</a>
                </div>
            </div> -->
            <div class="subsc-image">
                <p>メイン画像</p>
                <p class="subsc-image-p"><img id="pack_image" name="pack_img" src="<?php echo $_smarty_tpl->tpl_vars['pack']->value['img'];?>
"><a class="delete-btn">-</a></p>
                <input type="hidden" name="image_url" id="pack_image_url" value="<?php echo $_smarty_tpl->tpl_vars['pack']->value['img'];?>
" />
            </div>
            <div class="subsc-image-select-box">
                <p>ファイルをドロップして画像を<br/>アップロード</p>
                <input type="file" name="image" value="ファイルを選択" class="sabsc-image-btn" id="subsc-image-file">
                <label for="subsc-image-file">ファイルを選択</label>
            </div>
        </div>
        <div class="subsc-menu">
            <div class="subsc-name">
                <p>サブスクメニュー名</p>
                <input type="text" name="title" class="text-input" placeholder="" value="<?php echo $_smarty_tpl->tpl_vars['pack']->value['title'];?>
">
                <div class="subsc-item-content-type">
                    <div>
                        <p>価格</p>
                        <input type="text" name="price" placeholder="" value="<?php echo $_smarty_tpl->tpl_vars['pack']->value['price'];?>
">
                    </div>
                    <?php if (!$_smarty_tpl->tpl_vars['pack']->value['adminid']) {?>
                    <div>
                        <p>店舗名</p>
                        <input id="adminid" name="adminid" value="<?php echo $_smarty_tpl->tpl_vars['pack']->value['adminid'];?>
" style="width:100%" />
                        <div class="help-block inline"></div>
                    </div>
                    <?php } else { ?>
                    <input type="hidden" name="pack_id" placeholder="" value="<?php echo $_smarty_tpl->tpl_vars['pack']->value['price'];?>
">
                    <?php }?>
                </div>
                <div class="subsc-item-content-type">
                    <div>
                        <p>お得金額</p>
                        <input type="text" name="discount" placeholder="" value="<?php echo $_smarty_tpl->tpl_vars['pack']->value['discount'];?>
">
                    </div>
                    <div>
                        <p>有効期限<span>未入力の場合削除するまで有効になります</span></p>
                        <input type="text" name="validity_time" placeholder="" value="<?php echo $_smarty_tpl->tpl_vars['pack']->value['validity_time'];?>
">
                    </div>
                </div>
                <div class="subsc-item-content-type">
                    <div>
                        <p>回数</p>
                        <input type="text" name="" placeholder="" value="<?php echo $_smarty_tpl->tpl_vars['pack']->value['count'];?>
">
                    </div>
                </div>
            </div>
            <?php  $_smarty_tpl->tpl_vars['pack_item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['pack_item']->_loop = false;
 $_smarty_tpl->tpl_vars['index'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['pack_items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['pack_item']->key => $_smarty_tpl->tpl_vars['pack_item']->value) {
$_smarty_tpl->tpl_vars['pack_item']->_loop = true;
 $_smarty_tpl->tpl_vars['index']->value = $_smarty_tpl->tpl_vars['pack_item']->key;
?>
            <div class="subsc-item">
                <input type="hidden" name="pack_item[<?php echo $_smarty_tpl->tpl_vars['index']->value;?>
][id]" placeholder="" value="<?php echo $_smarty_tpl->tpl_vars['pack_item']->value['id'];?>
">
                <div class="subsc-item-surround"><span><?php echo $_smarty_tpl->tpl_vars['index']->value+1;?>
</span></div>
                <div class="subsc-item-content">
                    <div class="subsc-item-content-textarea">
                        <div>
                            <p>含まれるメニュー名</p>
                            <input type="text" name="pack_item[<?php echo $_smarty_tpl->tpl_vars['index']->value;?>
][title]" placeholder="" value="<?php echo $_smarty_tpl->tpl_vars['pack_item']->value['title'];?>
">
                        </div>
                    </div>
                    <div class="subsc-item-content-textarea">
                        <div>
                            <p>メニューの説明</p>
                            <textarea name="pack_item[<?php echo $_smarty_tpl->tpl_vars['index']->value;?>
][text]"><?php echo $_smarty_tpl->tpl_vars['pack_item']->value['text'];?>
</textarea>
                        </div>
                    </div>
                    <div class="subsc-item-content-type">
                        <div>
                            <p>使用できる回数</p>
                            <input type="text" name="pack_item[<?php echo $_smarty_tpl->tpl_vars['index']->value;?>
][num]" placeholder="" value="<?php echo $_smarty_tpl->tpl_vars['pack_item']->value['num'];?>
">
                        </div>
                        <div>
                            <p>ショット数</p>
                            <input type="text" name="pack_item[<?php echo $_smarty_tpl->tpl_vars['index']->value;?>
][knife]" placeholder="" value="<?php echo $_smarty_tpl->tpl_vars['pack_item']->value['knife'];?>
">
                        </div>
                    </div>
                </div>
                <div class="subsc-item-surround"><a class="delete-btn">-</a></div>
            </div>
            <?php } ?>
            <div class="subsc-adds">
                <a class="btn" id="add-subsc-menu">サブスクに含まれるメニューを追加する</a>
                <div id="created-tiem">
                    <p>作成時間</p>
                    <p></p>
                </div>
                <button type="button" class="btn btn-complete pull-right" id="saveedit"><?php if ($_smarty_tpl->tpl_vars['pack']->value['id']) {?>新規メニューを登録する<?php } else { ?>メニューを保存する<?php }?></button>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    var count = <?php echo sizeof($_smarty_tpl->tpl_vars['pack_items']->value);?>
;
    // var image = undefined;
	$(document).on('change', '.sabsc-image-btn', async function(event) {
        var files, image, reader, that;
        files = event.target.files;
        var imageType = /image.*/;
        image = files[0];
        if (!image.type.match(imageType)) return;
        reader = new FileReader();
        that = this;
        reader.onload = function(file) {
            var img;
            img = new Image();
            img.src = file.target.result;
            $('.subsc-image-p').html(img);
            
            // image = img;
        };
        reader.readAsDataURL(image);
		var result = await uploadMedia(image);
        result = JSON.parse(result)
		if (result.status == 1) {
            console.log(result.url)
            $("#pack_image").attr('src', result.url);
            $("#pack_image_url").val(result.location)
		}
    });

    
	async function uploadMedia(media) {
		const data = new FormData();
		data.append('media', media);
		return $.ajax({
			type: "POST",
			url: '/admin_subscription/uploadMedia',
			data: data,
            contentType: false,
            processData: false,
		}).done(
			function(e) {
                console.log(e)
				return e
			})
	}

	$('#add-subsc-menu').click(function(){
        $(this).parent().before('<div class="subsc-item"><div class="subsc-item-surround"><span></span></div><div class="subsc-item-content"><div class="subsc-item-content-textarea"><div><p>含まれるメニュー名</p><input type="text" name="pack_item['+count+'][title]" placeholder="" value=""></div></div><div class="subsc-item-content-textarea"><div><p>メニューの説明</p><textarea name="pack_item['+count+'][text]"></textarea></div></div><div class="subsc-item-content-type"><div><p>使用できる回数</p><input type="text" name="pack_item['+count+'][num]" placeholder="" value=""></div><div><p>ショット数</p><input type="text" name="pack_item['+count+'][knife]" placeholder="" value=""></div></div></div><div class="subsc-item-surround"><a class="delete-btn">-</a></div></div>')
        count++;
    });
</script>
<script>

    $(function () {
        
        var isbusy = false;
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

        $('#saveedit').click(function(){
            if(!$('#submitform').valid())return false;
            if(isbusy)return false;
            isbusy = true;
            tooltipbox.show("<?php echo translate('正在执行操作');?>
");
            //$('#text').val(ue.getContent());
            $.post('/admin_subscription/edit/<?php echo $_smarty_tpl->tpl_vars['pack']->value["id"];?>
', $('#submitform').serialize(), function(res){
                if(res.status == '1'){
                    tooltipbox.show("<?php echo translate('操作完成');?>
");
                    location.href = '/admin_system#page/admin_subscription/';
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
    </script>
    
 

<?php }} ?>
