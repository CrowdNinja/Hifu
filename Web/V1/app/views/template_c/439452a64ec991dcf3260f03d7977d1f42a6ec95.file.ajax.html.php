<?php /* Smarty version Smarty-3.1.19, created on 2020-07-04 17:49:43
         compiled from "C:\xampp\htdocs\beauty-server\app\views\ajax.html" */ ?>
<?php /*%%SmartyHeaderCode:5267668325ed5b6880bfcc1-92640937%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '439452a64ec991dcf3260f03d7977d1f42a6ec95' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beauty-server\\app\\views\\ajax.html',
      1 => 1593877184,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5267668325ed5b6880bfcc1-92640937',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5ed5b6880f3690_69889145',
  'variables' => 
  array (
    '_admin' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ed5b6880f3690_69889145')) {function content_5ed5b6880f3690_69889145($_smarty_tpl) {?><!DOCTYPE html>
<html>
	<head>
	          
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title><?php echo translate('美容仪系统');?>
</title>

		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="/style/assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="/style/assets/css/font-awesome.min.css" />
		<link rel="stylesheet" href="/style/dlc.ui.css" />
		<link rel="stylesheet" href="/style/pfysadmin.css" />

		<!-- text fonts -->
		<link rel="stylesheet" href="/style/assets/css/ace-fonts.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="/style/assets/css/ace.min.css" id="main-ace-style" />

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="/style/assets/css/ace-part2.min.css" />
		<![endif]-->
		<link rel="stylesheet" href="/style/assets/css/ace-skins.min.css" />
		<link rel="stylesheet" href="/style/assets/css/ace-rtl.min.css" />
		<link rel="stylesheet" href="/style/assets/css/style.css" />

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="/style/assets/css/ace-ie.min.css" />
		<![endif]-->

		<!-- ace settings handler -->
		<script src="/style/assets/js/ace-extra.min.js"></script>
		<!-- <script src="/style/assets/css/style.css"></script> -->

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="/style/assets/js/html5shiv.js"></script>
		<script src="/style/assets/js/respond.min.js"></script>
		<![endif]-->
		
		<!-- basic scripts -->


		<script type="text/javascript">
			window.jQuery || document.write("<script src='/style/assets/js/jquery.min.js'>"+"<"+"/script>");
		</script>
        

		<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='/style/assets/js/jquery1x.min.js'>"+"<"+"/script>");
</script>
<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='/style/assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="/style/assets/js/bootstrap.min.js"></script>
        <script src="/style/assets/js/date-time/moment.min.js"></script>
        <script src="/style/assets/js/date-time/bootstrap-datetimepicker.min.js"></script>

		<!-- ace scripts -->
		<script src="/style/assets/js/ace-elements.min.js"></script>
		<script src="/style/assets/js/ace.min.js"></script>
		<script type ="text/javascript" src ="/style/assets/js/jquery.form.js"></script>
		<script type ="text/javascript" src ="/style/js/dlc.js"></script>
		<script type ="text/javascript" src ="/style/assets/js/jquery.validate.js"></script>
        <link rel="stylesheet" href="/style/chosen.css">
 
		<script src="/style/assets/js/chosen.jquery.min.js"></script>

		<!--lay-->
		<script src="/style/assets/js/laydate/laydate.js"></script>
		<script src="/style/assets/js/layer/layer.js"></script>
		<!--end lay-->
		<link rel="stylesheet" href="/style/assets/css/select2.css" />
		<script src="/style/assets/js/select2.min.js"></script>

		<link rel="stylesheet" href="/style/assets/css/lightbox.css" />
		<script type="text/javascript" src="/style/assets/js/lightbox.js"></script>
		<script src="/style/assets/js/bootbox.min.js"></script>

		<script language="javascript" src="/style/assets/js/jquery.fn.js"></script>
		<script language="javascript" src="/style/assets/js/jquery.json.js"></script>
		<script language="javascript" src="/style/assets/js/tooltipbox.js"></script>
  <link rel="stylesheet" href="/style/assets/css/viewer.min.css" />
  <script language="javascript" src="/style/assets/js/viewer.min.js"></script>

		<script language="javascript" src="/style/assets/js/highcharts.js"></script>

	</head>

	<body class="skin-1">
		<!-- #section:basics/navbar.layout -->
		<div id="navbar" class="navbar navbar-default">
			<script type="text/javascript">
			
				try{ace.settings.check('navbar' , 'fixed')}catch(e){}
			</script>

			<div class="navbar-container" id="navbar-container">
				<!-- #section:basics/sidebar.mobile.toggle -->
				<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler">
					<span class="sr-only">Toggle sidebar</span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>
				</button>

				<!-- /section:basics/sidebar.mobile.toggle -->
				<div class="navbar-header pull-left">
					<!-- #section:basics/navbar.layout.brand -->
					<a href="#" class="navbar-brand" style="">
						<small id="logo" class="header_logo">
							<i class="fa fa-leaf" style="content:url(/images/logo1.png);width:45px; height:30px; vertical-align:middle;"> </i>
						</small>
						<span class="header_logo"><i class="fa fa-home pl-5"></i></span>
					</a>

					<!-- /section:basics/navbar.layout.brand -->

					<!-- #section:basics/navbar.toggle -->

					<!-- /section:basics/navbar.toggle -->
				</div>

				<!-- #section:basics/navbar.dropdown -->
				<div class="navbar-buttons navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">
						

						<!-- #section:basics/navbar.user_menu -->
						<li class="light-blue">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<img class="nav-user-photo" src="/style/assets/avatars/user.jpg" alt="Jason's Photo" />
							</a>

							<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<?php if ($_smarty_tpl->tpl_vars['_admin']->value->_role_type==1) {?>
								<!-- <li>
									<a href="admin_system#page/admin_corp/edit/<?php echo $_smarty_tpl->tpl_vars['_admin']->value->id;?>
">
										<i class="ace-icon fa fa-cog"></i>
										<?php echo translate('个人信息');?>

									</a>
								</li> -->
								<?php } elseif ($_smarty_tpl->tpl_vars['_admin']->value->_role_type==2) {?>
								<!-- <li>
									<a href="admin_system#page/admin_shop/edit/<?php echo $_smarty_tpl->tpl_vars['_admin']->value->id;?>
">
										<i class="ace-icon fa fa-cog"></i>
										<?php echo translate('个人信息');?>

									</a>
								</li> -->
								<?php } else { ?>
								<!-- <li>
									<a href="admin_system#page/admin_bguser/edit/<?php echo $_smarty_tpl->tpl_vars['_admin']->value->id;?>
">
										<i class="ace-icon fa fa-cog"></i>
										<?php echo translate('个人信息');?>

									</a>
								</li> -->
								<?php }?>

								<li>
									<a href="admin_system#page/admin_system/password">
										<i class="ace-icon fa fa-user"></i>
										<?php echo translate('修改密码');?>

									</a>
								</li>

								<li class="divider"></li>

								<li>
									<a href="/login/quit">
										<i class="ace-icon fa fa-power-off"></i>
										<?php echo translate('退出');?>

									</a>
								</li>
							</ul>
						</li>

						<!-- /section:basics/navbar.user_menu -->
					</ul>
				</div>

				<!-- /section:basics/navbar.dropdown -->
			</div><!-- /.navbar-container -->
		</div>

		<!-- /section:basics/navbar.layout -->
		<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

			<!-- #section:basics/sidebar -->
			<div id="sidebar" class="sidebar                  responsive">
				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
				</script>

				<div class="sidebar-shortcuts" id="sidebar-shortcuts" style="display:none">
					<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
						<button class="btn btn-success">
							<i class="ace-icon fa fa-signal"></i>
						</button>

						<button class="btn btn-info">
							<i class="ace-icon fa fa-pencil"></i>
						</button>

						<!-- #section:basics/sidebar.layout.shortcuts -->
						<button class="btn btn-warning">
							<i class="ace-icon fa fa-users"></i>
						</button>

						<button class="btn btn-danger">
							<i class="ace-icon fa fa-cogs"></i>
						</button>

						<!-- /section:basics/sidebar.layout.shortcuts-->
					</div>

					<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
						<span class="btn btn-success"></span>

						<span class="btn btn-info"></span>

						<span class="btn btn-warning"></span>

						<span class="btn btn-danger"></span>
					</div>
				</div><!-- /.sidebar-shortcuts -->

			  <ul  id="nav-list" class="nav nav-list">
				</ul><!-- /.nav-list -->


				<!-- #section:basics/sidebar.layout.minimize -->
				<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
					<i class="ace-icon fa fa-angle-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>メニューを感じる
				</div>

				<!-- /section:basics/sidebar.layout.minimize -->
				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
				</script>
			</div>

			<!-- /section:basics/sidebar -->
			<div class="main-content">
				<!-- #section:basics/content.breadcrumbs -->
				<div class="breadcrumbs" id="breadcrumbs">
					<script type="text/javascript">
						try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
					</script>

					<ul class="breadcrumb">
						<li>
							<i class="ace-icon fa fa-home home-icon"></i>
							<a href="#">Home</a>
						</li>
					</ul><!-- /.breadcrumb -->

					<!-- #section:basics/content.searchbox -->
					<div class="nav-search" id="nav-search" style="display:none">
						<form class="form-search">
							<span class="input-icon">
								<input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
								<i class="ace-icon fa fa-search nav-search-icon"></i>
							</span>
						</form>
					</div><!-- /.nav-search -->

					<!-- /section:basics/content.searchbox -->
				</div>

				<!-- /section:basics/content.breadcrumbs -->
				<div class="page-content">
					<!-- #section:settings.box -->
					<div class="ace-settings-container" id="ace-settings-container">
						<!--<div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
							<i class="ace-icon fa fa-cog bigger-150"></i>
						</div>-->

						<div class="ace-settings-box clearfix" id="ace-settings-box">
							<div class="pull-left width-50">
								<!-- #section:settings.skins -->
								<div class="ace-settings-item">
									<div class="pull-left">
										<select id="skin-colorpicker" class="hide">
											<option data-skin="no-skin" value="#438EB9">#438EB9</option>
											<option data-skin="skin-1" value="#15a589" selected>#15a589</option>
											<option data-skin="skin-2" value="#C6487E">#C6487E</option>
											<option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
										</select>
									</div>
									<span>&nbsp; Choose Skin</span>
								</div>

								<!-- /section:settings.skins -->

								<!-- #section:settings.navbar -->
								<div class="ace-settings-item">
									<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-navbar" />
									<label class="lbl" for="ace-settings-navbar"> Fixed Navbar</label>
								</div>

								<!-- /section:settings.navbar -->

								<!-- #section:settings.sidebar -->
								<div class="ace-settings-item">
									<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-sidebar" />
									<label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>
								</div>

								<!-- /section:settings.sidebar -->

								<!-- #section:settings.breadcrumbs -->
								<div class="ace-settings-item">
									<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-breadcrumbs" />
									<label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>
								</div>

								<!-- /section:settings.breadcrumbs -->

								<!-- #section:settings.rtl -->
								<div class="ace-settings-item">
									<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl" />
									<label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
								</div>

								<!-- /section:settings.rtl -->

								<!-- #section:settings.container -->
								<div class="ace-settings-item">
									<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-add-container" />
									<label class="lbl" for="ace-settings-add-container">
										Inside
										<b>.container</b>
									</label>
								</div>

								<!-- /section:settings.container -->
							</div><!-- /.pull-left -->

							<div class="pull-left width-50">
								<!-- #section:basics/sidebar.options -->
								<div class="ace-settings-item">
									<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-hover" />
									<label class="lbl" for="ace-settings-hover"> Submenu on Hover</label>
								</div>

								<div class="ace-settings-item">
									<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-compact" />
									<label class="lbl" for="ace-settings-compact"> Compact Sidebar</label>
								</div>

								<div class="ace-settings-item">
									<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-highlight" />
									<label class="lbl" for="ace-settings-highlight"> Alt. Active Item</label>
								</div>

								<!-- /section:basics/sidebar.options -->
							</div><!-- /.pull-left -->
						</div><!-- /.ace-settings-box -->
					</div><!-- /.ace-settings-container -->

					<!-- /section:settings.box -->
					<div class="page-content-area">
					</div>
				</div><!-- /.page-content -->
			</div><!-- /.main-content -->

			<br /><br /><br /><br /><br />
			<div class="footer" style="display:none">
				<div class="footer-inner">
					<!-- #section:basics/footer -->
					<div class="footer-content text-right">
						<span class="bigger-120">
							 
							&copy; 2019 All rights reserved.
						</span>

						&nbsp; &nbsp;
						 
					</div>

					<!-- /section:basics/footer -->
				</div>
			</div>

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->

		
		<script type="text/javascript">
			//Load content via ajax
					jQuery(function($) {
					  if('enable_ajax_content' in ace) {
						var options = {
						  content_url: function(url) {
							//this is for Ace demo only, you should change it
							//please refer to documentation for more info
					 
							if(!url.match(/^page\//)) return false;
							
							var path = document.location.pathname;
							
							//for Ace HTML demo version, convert ajax.html#page/gallery to > gallery.html and load it
							if(path.match(/admin_system/)) return path.replace(/admin_system/, url.replace(/^page\//, '')) ;
					
							//for Ace PHP demo version convert "page/dashboard" to "?page=dashboard" and load it
							return path + "?" + url.replace(/\//, "=");
						  },
						  //default_url: 'page/index'//default url
						}
						ace.enable_ajax_content($, options)
					  }
					    
					})
		</script>
		<script type="text/javascript">
$(document).ready(function() {
     
        $.ajax({
        type: 'GET',//请求方式
        url: '/admin_system/acl',
        dataType: 'text',
        error: function(xhr) { alert( xhr.responseText ); }, //如果你的url,txt有问题,将会提示
        success: function(data) {
           document.getElementById("nav-list").innerHTML=data;
        }
        })
});
</script>
 
	</body>
</html>
<?php }} ?>
