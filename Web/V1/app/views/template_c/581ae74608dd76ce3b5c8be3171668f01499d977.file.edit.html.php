<?php /* Smarty version Smarty-3.1.19, created on 2020-06-19 11:49:09
         compiled from "C:\xampp\htdocs\beauty-server\app\views\agreements\edit.html" */ ?>
<?php /*%%SmartyHeaderCode:16920724335ede44409062d3-61188768%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '581ae74608dd76ce3b5c8be3171668f01499d977' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beauty-server\\app\\views\\agreements\\edit.html',
      1 => 1592560145,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16920724335ede44409062d3-61188768',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5ede44409306f0_12349498',
  'variables' => 
  array (
    'agreement' => 0,
    'ctime' => 0,
    'agreements' => 0,
    'agreement_id' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ede44409306f0_12349498')) {function content_5ede44409306f0_12349498($_smarty_tpl) {?>
<title><?php echo translate('サブスクメニュー管理');?>
 - <?php echo translate('サブスク約款追加');?>
</title>
<!--<div class="page-header">-->
	<!--<h1>-->
		<!--员工管理 <small> <i class="ace-icon fa fa-angle-double-right"></i> 员工列表-->
		<!--</small>-->
	<!--</h1>-->
<!--</div>-->
<!-- /.page-header -->

<script language='javascript' src="/style/assets/js/jquery.dialogBox.js"></script>
<link rel="stylesheet" href="/style/assets/js/jquery.dialogbox.css" />

<div class="row">
	<div class="col-xs-12">
    <h3>サブスク約款の新規追加</h3>
    <div class="subsc-menu" id="term">
        <form class="form-horizontal" role="form" id="submitform" accept-charset="utf-8">
            <div class="subsc-item">
                <div class="subsc-item-content">
                    <div class="subsc-item-content-textarea">
                        <div>
                            <p>約款のタイトル</p>
                            <input type="text" name="agreement[title]" placeholder="" value="<?php echo $_smarty_tpl->tpl_vars['agreement']->value['title'];?>
">
                        </div>
                    </div>
                    <div class="subsc-item-content-textarea">
                        <div>
                            <p>約款の内容</p>
                            <textarea name="agreement[content]"><?php echo $_smarty_tpl->tpl_vars['agreement']->value['content'];?>
</textarea>
                        </div>
                    </div>
                </div>
                <div class="subsc-item-surround"><button class="delete-btn">-</button></div>
            </div>
            <div class="subsc-adds">
                <button id="saveedit">新規約款を登録する</button>
                <div id="created-tiem">
                    <!-- <p>作成時間</p> -->
                    <!-- <p><?php echo $_smarty_tpl->tpl_vars['ctime']->value;?>
</p> -->
                </div>
            </div>
            
        </form>
    </div>
</div>

<script type="text/javascript">
	$(document).on('change', '.sabsc-image-btn', function(event) {
	    var files, image, reader, that;
	    files = event.target.files;
	    image = files[0];
	    reader = new FileReader();
	    that = this;
	    reader.onload = function(file) {
	      var img;
	      img = new Image();
	      img.src = file.target.result;
	      $('.subsc-image-p').html(img);
	    };
	    reader.readAsDataURL(image);
    });
    
    $(function () {
        var count=<?php echo sizeof($_smarty_tpl->tpl_vars['agreements']->value);?>

        $('#add-subsc-menu').click(function(){
            $(this).parent().before('<div class="subsc-item"><div class="subsc-item-surround"><span></span></div><div class="subsc-item-content"><div class="subsc-item-content-textarea"><div><p>約款のタイトル</p><input type="text" name="agreement['+count+'][title]" placeholder="" value=""></div></div><div class="subsc-item-content-textarea"><div><p></p><textarea name="agreement['+count+'][content]"></textarea></div></div></div><div class="subsc-item-surround"><button class="delete-btn">-</button></div></div>')
            count++;
        });
        var isbusy = false;
        $("#term-select-menu").select2({
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
                    // data
                    console.log(data)
                    $('.term-search-items').html('')
                    data['data'].forEach(item => {
                        $('.term-search-items').append('<li>'+item.text+'</li>');
                    })
                    // return {
                    //     results:[]	
                    // };
                },
                processResults: function (data) { 
                    
                    // data.data.foreach(item => {
                    //     $('#term-search-items').append('<li>'+item.id+','+item.text+'</li>');
                    // })
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

        $('#saveedit').click(function(e){
            e.preventDefault();
            if(!$('#submitform').valid())return false;
            if(isbusy)return false;
            isbusy = true;
            tooltipbox.show("<?php echo translate('正在执行操作');?>
");
            //$('#text').val(ue.getContent());
            $.post('/admin_agreement/edit/<?php echo $_smarty_tpl->tpl_vars['agreement_id']->value;?>
', $('#submitform').serialize(), function(res){
                if(res.status == '1'){
                    tooltipbox.show("<?php echo translate('操作完成');?>
");
                    location.href = '/admin_system#page/admin_agreement/';
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

	$(document).on('click', '.term-search-items li', function(){
		$('.term-search-selected-items').append('<li>'+ $(this).text() + '<button class="delete-btn">-</button>' +'</li>')
	});
	$(document).on('hover', '.term-search-selected-items li', function () {
          $('button', this).show()
       }, 
		
       function () {
          $('button', this).hide()
       });
	$('.term-search-selected-items li button').click(function(){
		$(this).parent().remove();
	});

</script>
    
 

<?php }} ?>
