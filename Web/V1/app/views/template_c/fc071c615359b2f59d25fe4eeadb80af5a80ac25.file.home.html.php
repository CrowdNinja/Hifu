<?php /* Smarty version Smarty-3.1.19, created on 2020-05-29 05:46:00
         compiled from "C:\xampp\htdocs\beauty\app\views\base\home.html" */ ?>
<?php /*%%SmartyHeaderCode:754853045ecb30c42ac642-17975677%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fc071c615359b2f59d25fe4eeadb80af5a80ac25' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beauty\\app\\views\\base\\home.html',
      1 => 1590723957,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '754853045ecb30c42ac642-17975677',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5ecb30c43509e1_22519548',
  'variables' => 
  array (
    'mac_count' => 0,
    'open_status_1' => 0,
    'open_status_2' => 0,
    'order' => 0,
    'refund_count' => 0,
    'mac_count_type1' => 0,
    'mac_count_type2' => 0,
    'open_status_mr' => 0,
    'open_status_mr2' => 0,
    'open_status_tm' => 0,
    'open_status_tm2' => 0,
    'type' => 0,
    'get' => 0,
    'date_type' => 0,
    'list' => 0,
    'v' => 0,
    'data' => 0,
    'date' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ecb30c43509e1_22519548')) {function content_5ecb30c43509e1_22519548($_smarty_tpl) {?><title><?php echo translate('首頁');?>
</title>

<!--<div style="min-width: 100%;height:66px;margin-bottom:30px;">
    <div class="col-sm-5 infobox-container" style="min-width: 50%;height:66px;">

        <div style="float:left;height:66px;background:#629FDC;color:#fff;width:40px;font-size:20px;padding:13px 10px;line-height: 20px; ">
            设备
        </div>

        <a href="admin_system#page/admin_device/" style="text-decoration:none;">
            <div class="infobox infobox-pink" style="float:left;">
                <div class="infobox-icon">
                    <i class="ace-icon fa fa-cog label-purple"></i>
                </div>

                <div class="infobox-data">
                    <span class="infobox-data-number" style="color:#bbb1d6;">设备数量</span>
                    <div class="infobox-content"><b style="color:red;"><?php echo $_smarty_tpl->tpl_vars['mac_count']->value;?>
</b>台</div>
                </div>
            </div>
        </a>

        <a href="admin_system#page/admin_device?open_status=1" style="text-decoration:none;">
            <div class="infobox infobox-pink" style="float:left;">
                <div class="infobox-icon">
                    <i class="ace-icon fa fa-circle-o label-success"></i>
                </div>


                <div class="infobox-data">
                    <span class="infobox-data-number" style="color:#afcca3;">启用设备</span>
                    <div class="infobox-content" ><b style="color:red;"><?php echo $_smarty_tpl->tpl_vars['open_status_1']->value;?>
</b>台</div>
                </div>
            </div>
        </a>

        <a href="admin_system#page/admin_device?open_status=2" style="text-decoration:none;">
            <div class="infobox infobox-red" style="float:left;">
                <div class="infobox-icon">
                    <i class="ace-icon fa fa-circle-o-notch"></i>
                </div>

                <div class="infobox-data">
                    <span class="infobox-data-number">停用设备</span>
                    <div class="infobox-content"><b style="color:red;"><?php echo $_smarty_tpl->tpl_vars['open_status_2']->value;?>
</b>台</div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-sm-5 infobox-container" style="min-width:50%;height:66px;">

        <div style="float:left;height:66px;background:#FFA726;color:#fff;width:40px;font-size:20px;padding:13px 10px;line-height: 20px;">
            订单
        </div>
        <a href="admin_system#page/admin_order/" style="text-decoration:none;">
            <div class="infobox infobox-pink" style="float:left;">
                <div class="infobox-icon">
                    <i class="ace-icon fa fa-jpy label-warning"></i>
                </div>

                <div class="infobox-data">
                    <span class="infobox-data-number" style="color:#FFA726">订单金额</span>
                    <div class="infobox-content"><?php echo $_smarty_tpl->tpl_vars['order']->value['total_money'];?>
元</div>
                </div>
            </div>

        </a>
        <a href="admin_system#page/admin_order?refund=0" style="text-decoration:none;">
            <div class="infobox infobox-pink" style="float:left;">
                <div class="infobox-icon">
                    <i class="ace-icon fa fa-check label-success"></i>
                </div>

                <div class="infobox-data">
                    <span class="infobox-data-number" style="color:#afcca3">订单数量</span>
                    <div class="infobox-content"><?php echo $_smarty_tpl->tpl_vars['order']->value['count'];?>
笔</div>
                </div>
            </div>
        </a>
        <a href="admin_system#page/admin_order?refund=1" style="text-decoration:none;">
            <div class="infobox infobox-red" style="float:left;">
                <div class="infobox-icon">
                    <i class="ace-icon fa fa-times"></i>
                </div>


                <div class="infobox-data">
                    <span class="infobox-data-number">退款订单数量</span>
                    <div class="infobox-content"><?php echo $_smarty_tpl->tpl_vars['refund_count']->value;?>
笔</div>
                </div>
            </div>
        </a>
    </div>
</div>-->
<div class="row" >
  <div class="col-lg-12" >
    <!--<a href="admin_system#page/admin_device/" style="text-decoration:none;">-->
      <div class="infobox infobox-green" style="margin:1px 15px;width: auto;">
        <div class="infobox-icon">
          <i class="ace-icon fa fa-cog label-purple"></i>
        </div>

        <div class="infobox-data">
          <span class="infobox-data-number"><span style="vertical-align: inherit;"><?php echo translate('美容机设备数');?>
</span></span>
          <div class="infobox-content"><span style="vertical-align: inherit;"><?php echo $_smarty_tpl->tpl_vars['mac_count_type1']->value;?>
 <?php echo translate('台');?>
</span></div>
        </div>

        <!--  <div class="stat stat-success"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">8％</font></font></div>-->
      </div>
    <!--</a>-->
    <div class="infobox infobox-green" style="margin:1px 15px;width: auto;">
      <div class="infobox-icon">
        <i class="ace-icon fa fa-cog label-purple"></i>
      </div>

      <div class="infobox-data">
        <span class="infobox-data-number"><span style="vertical-align: inherit;"><?php echo translate('脱毛机设备数');?>
</span></span>
        <div class="infobox-content"><span style="vertical-align: inherit;"><?php echo $_smarty_tpl->tpl_vars['mac_count_type2']->value;?>
 <?php echo translate('台');?>
</span></div>
      </div>

      <!--  <div class="stat stat-success"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">8％</font></font></div>-->
    </div>
    <div class="infobox infobox-blue"  style="margin:1px 15px;width: auto;">
      <div class="infobox-icon">
        <i class="ace-icon fa fa-circle-o label-success"></i>
      </div>

      <div class="infobox-data">
        <span class="infobox-data-number"><span style="vertical-align: inherit;"><?php echo translate('美容机在线数');?>
</span></span>
        <div class="infobox-content"><span style="vertical-align: inherit;"><?php echo $_smarty_tpl->tpl_vars['open_status_mr']->value;?>
 <?php echo translate('台');?>
</span></div>
      </div>

      <!--<div class="badge badge-success"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
          + 32％
      </font></font><i class="ace-icon fa fa-arrow-up"></i>
      </div>-->
    </div>
    <!-- </a>-->

    <!--<a href="admin_system#page/admin_device?_status=2" style="text-decoration:none;">-->
    <div class="infobox infobox-pink"  style="margin:1px 15px;width: auto;">
      <div class="infobox-icon">
        <i class="ace-icon fa fa-circle-o-notch"></i>
      </div>

      <div class="infobox-data">
        <span class="infobox-data-number"><span style="vertical-align: inherit;"><?php echo translate('美容机离线数');?>
</span></span>
        <div class="infobox-content"><span style="vertical-align: inherit;"><?php echo $_smarty_tpl->tpl_vars['open_status_mr2']->value;?>
 <?php echo translate('台');?>
</span></div>
      </div>
      <!-- <div class="stat stat-important"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">4％</font></font></div>-->
    </div>
   <!-- <a href="admin_system#page/admin_device?_status=1" style="text-decoration:none;">-->
      <div class="infobox infobox-blue"  style="margin:1px 15px;width: auto;">
        <div class="infobox-icon">
          <i class="ace-icon fa fa-circle-o label-success"></i>
        </div>

        <div class="infobox-data">
          <span class="infobox-data-number"><span style="vertical-align: inherit;"><?php echo translate('脱毛机在线数');?>
</span></span>
          <div class="infobox-content"><span style="vertical-align: inherit;"><?php echo $_smarty_tpl->tpl_vars['open_status_tm']->value;?>
 <?php echo translate('台');?>
</span></div>
        </div>

        <!--<div class="badge badge-success"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
            + 32％
        </font></font><i class="ace-icon fa fa-arrow-up"></i>
        </div>-->
      </div>
   <!-- </a>-->

    <!--<a href="admin_system#page/admin_device?_status=2" style="text-decoration:none;">-->
      <div class="infobox infobox-pink"  style="margin:1px 15px;width: auto;">
        <div class="infobox-icon">
          <i class="ace-icon fa fa-circle-o-notch"></i>
        </div>

        <div class="infobox-data">
          <span class="infobox-data-number"><span style="vertical-align: inherit;"><?php echo translate('脱毛离线数');?>
</span></span>
          <div class="infobox-content"><span style="vertical-align: inherit;"><?php echo $_smarty_tpl->tpl_vars['open_status_tm2']->value;?>
 <?php echo translate('台');?>
</span></div>
        </div>
        <!-- <div class="stat stat-important"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">4％</font></font></div>-->
      </div>
    <!--</a>-->
   <!-- <a href="admin_system#page/admin_trade/" style="text-decoration:none;">-->
      <div class="infobox infobox-blue"  style="margin:1px 15px;width: auto;">
        <div class="infobox-icon">
          <i class="ace-icon fa fa-jpy label-warning"></i>
        </div>

        <div class="infobox-data">
          <span class="infobox-data-number"><span style="vertical-align: inherit;"><?php echo translate('订单金额');?>
</span></span>
          <div class="infobox-content"><span style="vertical-align: inherit;"><?php echo $_smarty_tpl->tpl_vars['order']->value['total_money'];?>
 <?php echo translate('元');?>
</span></div>
        </div>
      </div>
    <!--</a>-->
    <!--<a href="admin_system#page/admin_trade?status=1" style="text-decoration:none;">-->
      <div class="infobox infobox-green"  style="margin:1px 15px;width: auto;">
        <div class="infobox-icon">
          <i class="ace-icon fa fa-check label-success"></i>
        </div>

        <div class="infobox-data">
          <span class="infobox-data-number"><span style="vertical-align: inherit;"><?php echo translate('订单数量');?>
</span></span>
          <div class="infobox-content"><span style="vertical-align: inherit;"><?php echo $_smarty_tpl->tpl_vars['order']->value['count'];?>
<?php echo translate('笔');?>
</span></div>
        </div>

        <!--<div class="badge badge-success"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
            + 32％
        </font></font><i class="ace-icon fa fa-arrow-up"></i>
        </div>-->
      </div>
   <!-- </a>-->
    <!--<a href="admin_system#page/admin_trade?status=2" style="text-decoration:none;">-->
      <div class="infobox infobox-red"  style="margin:1px 15px;width: auto;">
        <div class="infobox-icon">
          <i class="ace-icon fa fa-times"></i>
        </div>

        <div class="infobox-data">
          <span class="infobox-data-number"><span style="vertical-align: inherit;"><?php echo translate('退款订单数量');?>
</span></span>
          <div class="infobox-content"><span style="vertical-align: inherit;"><?php echo $_smarty_tpl->tpl_vars['refund_count']->value;?>
<?php echo translate('笔');?>
</span></div>
        </div>

        <!--<div class="badge badge-success"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
            + 32％
        </font></font><i class="ace-icon fa fa-arrow-up"></i>
        </div>-->
      </div>
    <!--</a>-->
    <br/>
    <br/>

    <div class="panel panel-success" style="width: 93%;"  >
      <div class="panel-body" style="height: 70px;">
        <div class="form-group form-search form-inline">
          <a href="/admin_system#page/admin_system/home?type=year" class="btn btn-success btn-sm" <?php if ($_smarty_tpl->tpl_vars['type']->value=="year") {?>disabled="disabled" <?php }?>> <?php echo translate('年');?>
 </a>
          <a href="/admin_system#page/admin_system/home?type=month" class="btn btn-success btn-sm" <?php if ($_smarty_tpl->tpl_vars['type']->value=="month") {?>disabled="disabled" <?php }?>> <?php echo translate('月');?>
 </a>
          <a href="/admin_system#page/admin_system/home?type=week" class="btn btn-success btn-sm" <?php if ($_smarty_tpl->tpl_vars['type']->value=="week") {?>disabled="disabled" <?php }?>> <?php echo translate('周');?>
 </a>
          <a href="/admin_system#page/admin_system/home?type=day" class="btn btn-success btn-sm " <?php if ($_smarty_tpl->tpl_vars['type']->value=="day") {?>disabled="disabled" <?php }?> ><?php echo translate('日');?>
  </a>
          <label class="control-label"><?php echo translate('日期');?>
</label>
          <input class="form-control datetimepicker" name="time" id="time" type="text" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['time'];?>
" placeholder="">
          <button class="btn btn-default btn-sm"><i class="fa fa-search"></i> <?php echo translate('搜索');?>
</button>
        </div>
      </div>
    </div>

    <script>
        $(function () {
            //这里处理搜索key，引用 /style/assets/js/jquery.fn.js
            //注意php代码不需要处理搜索URL参数，分页URL的处理注意本页尾的JS代码
            //$.searchURL = function(url = location.href, sConr = '.form-search', sObj = 'input,select,textarea', sJoin = ','){/**/}
            $('.btn-default').click(function () {
                var url = $.searchURL(location.href);
                location.href = url;
            });

            laydate.render({
                elem: '#time',
                type:"<?php echo $_smarty_tpl->tpl_vars['date_type']->value;?>
"
            });
        });
    </script>
    <div id="container_pillar" class="col-xs-12" style="height: 350px;"></div>

    <table class="table table-bordered table-hover">
      <thead>
      <tr>
        <th><?php echo translate('ID');?>
</th>
        <th><?php echo translate('订单编号');?>
</th>
       <!-- <th><?php echo translate('设备编号');?>
</th>-->
        <th><?php echo translate('订单金额');?>
 </th>
        <th><?php echo translate('优惠金额');?>
 </th>
        <th><?php echo translate('实付金额');?>
 </th>
        <th><?php echo translate('支付方式');?>
 </th>
        <th><?php echo translate('创建时间');?>
 </th>

      </tr>
      </thead>
      <tbody>
      <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>

      <tr class="success" align="left">
        <td><?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</td>
        <td><a href="admin_system#page/admin_trade?tradeno=<?php echo $_smarty_tpl->tpl_vars['v']->value['tradeno'];?>
" style="text-decoration:none;"><?php echo $_smarty_tpl->tpl_vars['v']->value['tradeno'];?>
</a></td>
       <!-- <td><?php echo $_smarty_tpl->tpl_vars['v']->value['macno'];?>
</td>-->
        <td><b style="color:red;"><?php echo $_smarty_tpl->tpl_vars['v']->value['money'];?>
</b> <?php echo translate('元');?>
</td>
        <td><span style="color: #999999;"><?php echo $_smarty_tpl->tpl_vars['v']->value['discount'];?>
 </span><?php echo translate('元');?>
</td>
        <td><b style="color:red;"><?php echo $_smarty_tpl->tpl_vars['v']->value['pay_money'];?>
</b> <?php echo translate('元');?>
</td>
        <td><?php if ($_smarty_tpl->tpl_vars['v']->value['paytype']==1) {?><b style="color:brown"><?php echo translate('余额');?>
</b> <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['paytype']==2) {?> <b style="color:green;"><?php echo translate('微信');?>
</b><?php } elseif ($_smarty_tpl->tpl_vars['v']->value['paytype']==3) {?><b style="color:#629FDC"><?php echo translate('支付宝');?>
</b><?php } else { ?>line <?php }?></td>
        <td><?php echo $_smarty_tpl->tpl_vars['v']->value['ctime'];?>
</td>
      </tr>

      <?php } ?>
      </tbody>
    </table>
  </div>
</div>



<input type="hidden" value="<?php echo htmlspecialchars(json_encode($_smarty_tpl->tpl_vars['data']->value));?>
" id="data"/>
<input type="hidden" value="<?php echo htmlspecialchars(json_encode($_smarty_tpl->tpl_vars['date']->value));?>
" id="date"/>
<script>
    $(function () {
        var data =JSON.parse($("#data").val() || '{}');
        var date=JSON.parse($("#date").val() || '{}');
        var y_title="<?php echo translate('订单金额');?>
 (<?php echo translate('元');?>
)"  ;
        $('#container_pillar').highcharts({
            /*chart: {
                type: 'column'
            },*/
            title: {
                text: ''
            },

            xAxis: {
                categories: date
            },
            yAxis: {
                min: 0,
                title: {
                    text: y_title
                }
            },

            colors: ['#c76060', '#FF9655', '#33CC33', '#3333FF', '#660066', '#64E572', '#FF6666',
                '#FFF263', '#6AF9C4'],

            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle'
            },
            dataLabels: {
                enabled: true,
                rotation: -90,
                color: '#FFFFFF',
                align: 'right',
                format: '{point.y:.1f}', // one decimal
                y: 10, // 10 pixels down from the top
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            },
            series: data

        });
    });
</script>
<!--<script src="app/third_party/ueditor1_4_3_3-utf8-php/third-party/highcharts/highcharts.js" type="text/javascript"></script>-->
<?php }} ?>
