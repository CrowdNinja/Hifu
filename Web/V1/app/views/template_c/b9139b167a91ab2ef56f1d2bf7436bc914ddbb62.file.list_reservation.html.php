<?php /* Smarty version Smarty-3.1.19, created on 2020-07-02 21:10:42
         compiled from "C:\xampp\htdocs\beauty-server\app\views\reservation\list_reservation.html" */ ?>
<?php /*%%SmartyHeaderCode:5421613835ee2adf5674cf2-05422736%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b9139b167a91ab2ef56f1d2bf7436bc914ddbb62' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beauty-server\\app\\views\\reservation\\list_reservation.html',
      1 => 1593701167,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5421613835ee2adf5674cf2-05422736',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5ee2adf56cd608_67370267',
  'variables' => 
  array (
    'aid' => 0,
    'get' => 0,
    'max_row' => 0,
    'list' => 0,
    'rows' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ee2adf56cd608_67370267')) {function content_5ee2adf56cd608_67370267($_smarty_tpl) {?>
<title>予約管理 - 予約管理</title>
<div class="page-header">
	<h1>
		予約管理 <small> <i class="ace-icon fa fa-angle-double-right"></i> 予約管理
		</small>
  </h1>
  <div class="panel panel-success">
    <div class="panel-heading" onclick="$(this).parent().find('.panel-body').toggle()"><i class="glyphicon glyphicon-chevron-down"></i> <?php echo translate('筛选');?>
</div>
      <div class="panel-body search_bar" style="display:">
        <form action="/admin_system#page/admin_reservation/search" method="POST">
          <div class="form-group form-search form-inline ">
            <?php if ($_smarty_tpl->tpl_vars['aid']->value==1) {?>
            <label class="control-label">店舗名</label>
            <input  class="form-control" id="shop_name" name="shop_name" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['shop_name'];?>
" style="width:120px" />
            <?php }?>
            <label class="control-label">メニュー名</label>
            <input  class="form-control" id="pack_title" name="pack_title" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['pack_title'];?>
" style="width:120px" />
            <label class="control-label">予約時間</label>
            <input  class="form-control" id="start_time" name="start_time" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['start_time'];?>
" style="width:140px" />
            <label class="control-label">から</label>
            <input  class="form-control" id="end_time" name="end_time" value="<?php echo $_smarty_tpl->tpl_vars['get']->value['end_time'];?>
" style="width:140px" />
            
            <button class="btn btn-default btn-search btn-sm"><i class="fa fa-search"></i> <?php echo translate('搜索');?>
</button>
      <!--<button id="importBtn" class="btn btn-sm btn-primary"><i class="fa fa-download"></i> 下载二维码</button>-->
        </div>
      </form>
    </div>

  </div>
<!-- /.page-header -->
<!-- <script src="https://cdn.jsdelivr.net/npm/gantt-schedule-timeline-calendar"></script> -->
<script language='javascript' src="/style/assets/js/jquery.dialogBox.js"></script>
<link rel="stylesheet" href="/style/assets/js/jquery.dialogbox.css" />
<link rel="stylesheet" href="/style/assets/css/timeline.css" />
<link rel="stylesheet" href="/style/assets/css/style.css" />
<link rel="stylesheet" href="/style/assets/css/jquery.stackbox.min.css" />

<script>
  $(function(){
    //这里处理搜索key，引用 /style/assets/js/jquery.fn.js
    //注意php代码不需要处理搜索URL参数，分页URL的处理注意本页尾的JS代码
    //$.searchURL = function(url = location.href, sConr = '.form-search', sObj = 'input,select,textarea', sJoin = ','){/**/}
    // $('.btn-search').click(function(){
    //   var url = $.searchURL( location.href );
    //   location.href = url;
    // });
  });
  
  laydate.render({
    elem: '#start_time',
    type: 'datetime',
    format: 'yyyy-MM-dd HH:mm'
  });
  laydate.render({
      elem: '#end_time',
    type: 'datetime',
    format: 'yyyy-MM-dd HH:mm'
  });
  </script>
<div>
  <!-- <input type="range" min="0" max="100" value="100" id="percent" />
  <input type="range" min="10" max="22" value="15" id="zoom" /> -->
</div>
<div class="chart-container">
  <div class="datetime-selector">
    <button id="prevDate" class="date-btn">
      〈
    </button>
    <div id="date">
      <span class="year_date"></span>年<span class="month_date"></span>月<span class="day_date"></span>日
    </div>
    <button id="nextDate" class="date-btn">
      〉
    </button>
  </div>
  <div id="app"></div>
</div>
</div>

<div id="my-content">
<!-- <div class="stackbox"> -->
  <div class="stackbox-body px-2">
    <div class="panel panel-default reserv-dialog">
      <div class="title text-center panel-heading"></div>
      <div class="panel-body">
        <!-- <p class="prev_date"></p> -->
        <p class="date"></p>
        <p class="name"></p>
        <p class="trade_type"></p>
        <p class="remark"></p>
        <input type="hidden" id="reservation_id"/>
      </div>
      <div class="panel-footer">
        <div class="modal_btn_wrapper">
          <button class="btn bg-gray modal_btn dialog-box-close" id="cancel" data-close-stackbox="true">削除</button>
          <button class="btn btn-info modal_btn" id="trigger1">編集</button>
          <button class="btn btn-info modal_btn" style="display: none;" id="trigger2">編集完了</button>
          <button class="btn btn-yellow modal_btn cash_edit" style="display: none;" id="cash_edit">現金支払い編集</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- </div> -->

<script src="/style/assets/js/jquery.stackbox.min.js"></script>
<script src="/style/assets/js/timeline/ItemMovement.plugin.js"></script>
<script src="/style/assets/js/timeline/Selection.plugin.js"></script>
<script src="/style/assets/js/timeline/CalendarScroll.plugin.js"></script>
<script src="/style/assets/js/timeline/WeekendHighlight.plugin.js"></script>
<script src="/style/assets/js/timeline/index.umd.js?12345"></script>
<script>
  // $('#trigger').on('click', function() {
  // });

</script>
<script>
  const iterations =<?php echo $_smarty_tpl->tpl_vars['max_row']->value;?>
;
  const pallete = [
    '#00d9c6',
    '#173a42',
    '#00a698',
    '#0b84e6',
    '#f18b08',
    '#d95516',
    '#F1892D',
    '#E3724B',
    '#AE7C5B',
    '#6C7A89',
    '#758586',
    '#707070'
  ];
  let datetime = GSTC.api.date("<?php echo $_smarty_tpl->tpl_vars['get']->value['start_time'];?>
").format('YYYY-MM-DD')
  const types = <?php echo json_encode($_smarty_tpl->tpl_vars['list']->value);?>
;
  const _rows = <?php echo json_encode($_smarty_tpl->tpl_vars['rows']->value);?>

  console.log(types)
  console.log(_rows)
  const rows = {};
  var item_index = 0;
  for (let i = 0; i < _rows.length; i++) {
    const reservation = _rows[i]
    const id = item_index.toString();
    rows[id] = {
      id: item_index,
      label: reservation.shop_name,
      progress: 50,
      parentId: undefined,
      isHTML: true,
      expanded: true,
      height: 100,
    };
    item_index++;
  }
  var items = {};
  var item_index = 0;
  for (let i = 0; i < types.length; i++) {
    
    var type = types[i];
    type.forEach((reservation, index)=> {
      var start_time_day = GSTC.api
        .date(reservation.start_time)
        .format('YYYY年MM月DD日')
      var start_time_str = GSTC.api
        .date(reservation.start_time)
        .format('HH:mm')
      var end_time_str = GSTC.api
        .date(reservation.start_time)
        .add(reservation.interval_time != 0? reservation.interval_time: 30, 'minutes')
        .format('HH:mm')
      items[item_index] = {
        id: item_index,
        label: '<div class="device_type_item" style="background-color: '+pallete[parseInt(reservation.device_type_id) + 2]+'">'+reservation.device_type + '</div><div class="time">'+start_time_str+'~'+end_time_str + ' '+'</div><div class="nickname">'+reservation.user_name+'</div><div class="pack_item_name">'+reservation.pack_item_name+'</div>',
        semi_label: ' </div><div class="nickname">'+reservation.user_name+'</div><div class="pack_item_name">'+reservation.pack_item_name+'</div>',
        device_type_label: '<div class="device_type_item" style="background-color: '+pallete[parseInt(reservation.device_type_id) + 2]+'">'+reservation.device_type + '</div>',
        isHTML: true,
        progress: 50,
        time: {
          start: GSTC.api
            .date(reservation.start_time)
            .valueOf(),
          end: GSTC.api
            .date(reservation.start_time)
            .add(reservation.interval_time != 0? reservation.interval_time: 30, 'minutes')
            .valueOf()
        },
        title: reservation.pack_item_name,
        user_name: reservation.user_name,
        reservation_id: reservation.id,
        trade_type: reservation.paytype,
        remark: reservation.remark?reservation.remark: 'なし',
        start_time_day: start_time_day,
        start_time_str: start_time_str,
        end_time_str: end_time_str,
        initial_time_day: start_time_day,
        initial_start_str: start_time_str,
        initial_end_str: end_time_str,
        device_type: reservation.device_type,
        cash_id: reservation.cash_id,
        initial_start_time: GSTC.api
            .date(reservation.start_time)
            .valueOf(),
        initial_end_time: GSTC.api
            .date(reservation.start_time)
            .add(2, 'hour')
            .valueOf(),
        rowId: reservation.row,
        style: { background: reservation.is_subscription == 1?pallete[1]:pallete[0], lineHeight: 1.5 }
      };
      item_index ++;
    })
  }
  const columns = {
    percent: 100,
    resizer: {
      inRealTime: true
    },
    data: {
      label: {
        id: 'label',
        data: 'label',
        expander: false,
        // isHTML: true,
        width: 230,
        minWidth: 100,
        header: {
          content: '店舗名'
        }
      }
    }
  };

  class ResizingItemClass {
    update(element, data) {
      
    }
  }
  
  function clickAction(element, data) {
    // function mouseOut(event) {
    //   $('.stackbox-body').hide()
    // }
    function onClick(event) {
      $('.stackbox-body').show()
      event.preventDefault()
      $('#reservation_id').val(data.item.reservation_id)
      $('#my-content .remark').html(data.item.remark)
      $('#my-content .title').html(data.item.title + data.item.reservation_id)
      $('#my-content .date').html(data.item.start_time_day+ ' ' + data.item.start_time_str + '~'+data.item.end_time_str)
      $('#my-content .name').html(data.item.user_name)
      $('#my-content .device_type').html(data.item.device_type)
      $('#my-content .trade_type').html(data.item.trade_type)
      if (data.item.cash_id) {
        $('#my-content .cash_edit').show()
      } else {
        $('#my-content .cash_edit').hide()
      }
      $('#cancel').click(function(e) {
        data.item.start_time_day = data.item.initial_time_day
        data.item.start_time_str = data.item.initial_start_str
        data.item.end_time_str = data.item.initial_end_str
        data.item.time.start = data.item.initial_start_time
        data.item.time.end = data.item.initial_end_time
      })
      $('#cash_edit').click(function() {
        window.location.href = '/admin_system#page/admin_trade/edit_cash/'+data.item.cash_id
      })
      $('#trigger1').click(function() {
        $('p.remark').html('<input class="remark_edit" value="'+data.item.remark+'" />');
        $('#trigger2').show();
        $(this).hide()
      })
      $('#trigger2').click(function(e) {
        e.preventDefault()
        data.item.remark = $('.remark_edit').val();
        $.ajax({
          type: 'post',
          data: {
            'reservation_id': $('#reservation_id').val(),
            'remark': data.item.remark,
            'start_time': GSTC.api
              .date(data.item.time.start)
              .format('YYYY-MM-DD HH:mm')
          },
          url: "/admin_reservation/change",
          success: function(res) {
            tooltipbox.show('成功しました。');
            $('p.remark').html(data.item.remark);
            $('#trigger1').show();
            $('#trigger2').hide()
          },
          error: function() {
            tooltipbox.show('失敗しました。');
            return false;
          }
        });
      })
      $(this).stackbox({
        closeButton: false,
        position: 'bottom',
        animOpen: 'tada slow',
        content: '#my-content'
      }); 
    }
    
    // $('.dialog-box-close') 

    element.addEventListener('click', onClick);
    element.addEventListener('mouseover', onClick)
    return {
      update(element, newData) {
        data = newData; // data from parent scope updated
      },
    };
  }
  $('#detail_modal').click(function() {
    alert('error')
  })
  let selectionApi;
  function setMinutes15(time) {
    var date = new Date(time);
    var minutes = date.getMinutes();
    minutes = Math.round(minutes / 15) * 15;
    date.setMinutes(minutes);
    date.setSeconds(0)
    return date.getTime()
  }
  const config = {
    plugins: [
      ItemMovement({
        moveable: true,
        resizeable: true,
        collisionDetection: false,
        snapStart(time, diff, item) {
          var changed_time =  GSTC.api
            .date(setMinutes15(time))
            .add(setMinutes15(diff), 'milliseconds').startOf('milliseconds');
          changed_time_str = changed_time
            .valueOf();
          // item.time.start = changed_time_str
          item.start_time_day = changed_time
            .format('YYYY年MM月DD日')
          item.start_time_str = changed_time
            .format('HH:mm')
          return changed_time_str
        },
        // snap item end time to end of the day
        snapEnd(time, diff, item) {
          var changed_time =  GSTC.api
            .date(time)
            .add(setMinutes15(diff), 'milliseconds').startOf('milliseconds');
          changed_time_str = changed_time
            .valueOf();
          // item.time.end = changed_time_str
          item.end_time_str = changed_time
            .format('HH:mm')
          item.label = item.device_type_label+'<div class="time">'+item.start_time_str+'~'+item.end_time_str+item.semi_label
          item.end_time_day = changed_time_str
          return changed_time_str
        }
      }),
      Selection({
        items: true,
        rows: false,
        grid: true, // select only grid cells
        rectStyle: { opacity: '0.0' }, // hide selecting rectangle
        // if there is an item in the current selected cell - do not select that cell
        canSelect(type, currentlySelecting) {
          if (type === 'chart-timeline-grid-row-block') {
            // check if there is any item that lives inside current cell
            return currentlySelecting.filter(selected => {
              if (!selected.row.canSelect) return false;
              for (const item of selected.row._internal.items) {
                if (
                  (item.time.start >= selected.time.leftGlobal && item.time.start <= selected.time.rightGlobal) ||
                  (item.time.end >= selected.time.leftGlobal && item.time.end <= selected.time.rightGlobal) ||
                  (item.time.start <= selected.time.leftGlobal && item.time.end >= selected.time.rightGlobal)
                ) {
                  return false;
                }
              }
              return true;
            });
          }
          return currentlySelecting;
        },
        canDeselect(type, currently, all) {
          if (type === 'chart-timeline-grid-row-blocks') {
            // if we are selecting we can clear previous selection by returning [] else if
            // we are not selecting but something is already selected let it be selected - currently
            return all.selecting['chart-timeline-grid-row-blocks'].length ? [] : currently;
          }
          return [];
        },
        selecting(data, type) {
        },
        deselecting(data, type) {
        },
        selected(data, type) {
        },
        deselected(data, type) {
        }
      }),
      CalendarScroll({ speed: 2 }),
      WeekendHighlight()
    ],
    list: {
      rows,
      columns
    },
    chart: {
      items,
      time: {
        period: 'hours',
        zoom: 12,
        from: GSTC.api.date().format('YYYY-MM-DD HH:mm'),
        to: GSTC.api.date().format('YYYY-MM-DD HH:mm'),
        // leftGlobal: GSTC.api.date().format('YYYY-MM-DD') + ' 09:00'
      }
    },
    classNames: {},
    actions: {
      'chart-timeline-items-row-item': [clickAction],
    },
    height: <?php echo sizeof($_smarty_tpl->tpl_vars['rows']->value)+1;?>
 * 100 + 20,
    scroll: {
      left: 990,
      percent: {
        left: 30
      }
    }
  };

 

  let GSTCState = (window.state = GSTC.api.stateFromConfig(config));
  GSTCState.subscribe('config.plugin.ItemMovement', itemMovement => {
    if (!itemMovement || !itemMovement.item) return;
    state.update(`config.chart.items.${itemMovement.item.id}.isResizing`, itemMovement.item.resizing);
  });
   
  selectDate()
  function selectDate(direction = 0) {
    var date_format = GSTC.api.date(datetime).add(direction, 'day');
    datetime = date_format.format('YYYY-MM-DD')
    $('.year_date').html(date_format.format('YYYY'))
    $('.month_date').html(date_format.format('M'))
    $('.day_date').html(date_format.format('D'))
    // $('#date').html(date_format.format('YYYY年MM月DD日'))
    state.update(`config.chart.time.from`,datetime );
    state.update(`config.chart.time.to`,datetime );
  }

  $('#prevDate').click(function() {
    var date_format = GSTC.api.date(datetime).add(-1, 'day');
    datetime = date_format.format('YYYY-MM-DD')
    window.location.href = '/admin_system#page/admin_reservation?start_time='+(datetime+' 00:00')
  })
  $('#nextDate').click(function() {
    var date_format = GSTC.api.date(datetime).add(1, 'day');
    datetime = date_format.format('YYYY-MM-DD')
    window.location.href = '/admin_system#page/admin_reservation?start_time='+(datetime+' 00:00')
  })

  const gstc = GSTC({
    element: document.getElementById('app'),
    state: GSTCState
  });
  window.gstc = gstc; // debug

  function destroy() {
    gstc.app.destroy();
  }
  $(document).ready(function() {
    setTimeout(function(){ $('.gantt-schedule-timeline-calendar__horizontal-scroll').scrollLeft(7030) }, 300);
  })
  
  $(document).on('click', '.detail', function(e) {
    e.preventDefault()
    alert($(this).data('rsv_id'))
  })
</script><?php }} ?>
