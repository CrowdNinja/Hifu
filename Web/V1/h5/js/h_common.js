// 展示弹出层
function showModal(obj){
    $(obj).show();
    $('.mask').fadeIn(300);
}
// 隐藏弹出层
function hideModal(obj){
    $(obj).hide();
    $('.mask').fadeOut(300);
}
// 表单验证
function checkForm(obj,fromId,filter){
    var __options = {formId : fromId};
    var __form = new JForm(__options);
    if ( !__form.checkFormData() ){
       return false;
    }
    if(obj&&obj!==''){
        $(obj).attr('disabled','disabled');   
    }
    return true;
}
// 表单提交
function formSubmit(obj,formId,url,url2){
    $('#'+formId).ajaxSubmit({
        type:'post',
        url:url,
        dataType:'json',
        beforeSubmit:function(){
            if(!checkForm(obj,formId)){
                return false;
            }
            swal({
                background: 'transparent',
                onOpen: function() {
                    swal.showLoading()
                }
            })
        },
        success:function(res){
            swal({
                showConfirmButton: false,
                background: 'transparent',
                timer:5,
                onClose: function() {
                    swal.hideLoading()
                }
            })
            $(obj).removeAttr('disabled'); 
            if(res.code==1){
                swal({type:'success',title:res.msg,showConfirmButton:false,timer:2000}).catch(function(e){console.log(e)});
                if(url2&&url!==''){
                    setTimeout(function(){
                        window.location.href=url2;
                    },1200);
                }
            }else{
                alert(res.msg);
            }
        },
        error:function(res){
            console.log('网络异常,请刷新');
        }
    })
}
// 获取手机验证码
function getCode(obj1,obj2){
    $(obj1).attr('disabled','disabled');
    var phone = $('#'+obj2+' '+'input[name="account"]').val();
    var that = obj1;
    $.ajax({
        type:'post',
        url:'/user_api/sms',
        data:{'account':phone},
        dataType:'json',
        beforeSend:function(){
            if(isNull(phone)){
                swal({type:'error',title:'请输入您的手机号码',showConfirmButton:false,timer:1500}).catch(function(e){console.log(e)});
                $(obj1).removeAttr('disabled');
                return false;
            }else if(!checkMobileAndTel(phone)){
                swal({type:'error',title:'您的手机号码格式有误',showConfirmButton:false,timer:1500}).catch(function(e){console.log(e)});
                $(obj1).removeAttr('disabled');
                return false;
            }
            swal({
                background: 'transparent',
                onOpen: function() {
                    swal.showLoading()
                }
            })


        },
        success:function(res){
            swal({
                showConfirmButton: false,
                background: 'transparent',
                // timer:5,
                onClose: function() {
                    swal.hideLoading()
                }
            })
            $(obj1).removeAttr('disabled');
            if(res.code==1){
                swal({type:'success',title:res.msg,showConfirmButton:false,timer:2000}).catch(function(e){console.log(e)});
                var num = 60;
                $(that).html(num+'s');
                var timer = setInterval(function() {
                    num--;
                    $(that).html(num+' S');
                    if(num==0) {
                        clearInterval(timer);
                        $(that).html("重新发送");
                    }
                }, 1000);
            }else{
                alert(res.msg);
            }
        },
        error:function(res){
            console.log('网络异常,请刷新');
        }
    })
} 

//调用微信JS api 支付
var jsApiParameters = {};
function jsApiCall(url) {
    WeixinJSBridge.invoke(
        'getBrandWCPayRequest',
        jsApiParameters, // 提交的支付信息
        function(res) {
            // alert(JSON.stringify(res))
            if (res.err_msg == 'get_brand_wcpay_request:ok') {
                swal({
                  type: 'success',
                  title: '支付成功',
                  showConfirmButton: false,
                  timer: 1500
                }).catch(function(e){
                    console.log(e);
                })
                setTimeout(function(){
                	location.href=url;
                },1200);
            } else {
                swal({
                  type: 'info',
                  title: '取消支付',
                  showConfirmButton: false,
                  timer: 1500
                }).catch(function(e){
                    console.log(e);
                })
            }
        }
    );
}
//调用微信 支付
function callpay(url) {
    if (typeof WeixinJSBridge == "undefined") {
        if (document.addEventListener) {
            document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
        } else if (document.attachEvent) {
            document.attachEvent('WeixinJSBridgeReady', jsApiCall);
            document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
        }
    } else {
        jsApiCall(url);
    }
}
