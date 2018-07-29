//当点击支付的同时增加cookie
function addLoopCookie() {
    setCookie("loopCookie", 1, "s300");
}

jQuery(document).ready(function ($) {
    if (getCookie('loopCookie') == 1) {
        window.setInterval(checkOrderStatus, 3000);
    }
    $(".software_name").val("易经心水 联系微信 " + getCookie('weixin'));
    //如果url参数包含order_num，则判断已经支付完成
    var order_num = $('#wap_order_num').html();
    if (order_num != '') {
        checkOrderStatus();
    }
});

//进行轮训查询支付状态
function checkOrderStatus() {
    var order_num = $('#wap_order_num').html();
    $.post('/api/wap_check/checkOrderStatus.php', { order_num: order_num }, function (re) {
        if (re == 3) {
            if (getCookie('paid_href') == order_num) {

            } else {
                //把订单存到cookie
                setCookie("order_num", getCookie('order_num') + '-' + order_num, "d365");
                //跳转到姓名列表 30秒消失
                setCookie("paid_href", order_num, "s30");
                window.location.href = 'quming/quminglist.php?order_num=' + order_num;
            }
        } else if (re == 'fail') {
            setCookie("order_num", getCookie('order_num') + '-' + order_num, "d365");
            //alert('支付已完成，请添加客服微信 '+getCookie('weixin')+' 获取姓名详情');return false;
            if (getCookie('paid_alert') == 1) {

            } else {
                alert('支付已完成，请添加客服微信 ' + getCookie('weixin') + ' 获取姓名详情');
                setCookie("paid_alert", 1, "s300");
                return false;
            }
        }
    })
}
$(function () {
    $(window).scroll(function () {
        var hTop = 150;
        var docTop = $(this).scrollTop() - 20;
        if ($('.form-order').length > 0) {
            hTop = $('.form-order').offset().top
        }
        if (docTop >= hTop) {
            $('.btn-pay_bottomFixed').show();
        } else {
            $('.btn-pay_bottomFixed').hide();
        }
    });
    $('.btn-pay_bottomFixed, .infos-unlock').on({
        click: function () {
            $('html, body').animate({
                scrollTop: 0
            }, 500)
        }
    })
});
