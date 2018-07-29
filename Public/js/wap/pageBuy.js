(function () {
    var gb_price = "29.80",
        gx_prefix = "20";
    function getRnd(n) {
        var num_str = "";
        for (var i = 0; i < n; i++) {
            var num = Math.floor(Math.random() * 10);
            num_str = num_str + num;
        }
        return num_str;
    }
    var myDate = new Date();
    var month = myDate.getMonth() + 1;
    var date = myDate.getDate();
    var datestr = myDate.getFullYear() + '-' + (month < 10 ? '0' + month : month) + '-' + (date < 10 ? '0' + date : date);
    var html = "";
    for (var i = 0; i < 20; i++) {
        var order_no = getRnd(5);
        var myDateStr = myDate.getFullYear().toString();
        html = html + '<li>八字起名 ' + gx_prefix + '***' + order_no + '<i>' + gb_price + '元</i><span>' + datestr + '</span></li>';
    }
    if ($('#latersMovelist').length) {
        $('#latersMovelist').html(html);
    }
    $(".latersMove").kxbdMarquee({ direction: "up", isEqual: false });
})()
//当点击支付的同时增加cookie
function addLoopCookie() {
    setCookie("loopCookie", 1, "s300");
}
jQuery(document).ready(function ($) {
    if (getCookie('loopCookie') == 1) {
        window.setInterval(checkOrderStatus, 3000);
    }
    /*    function setLtime() {
            var nl_date = calendar.solar2lunar(2017, 9, 20);
            var _lt = (nl_date.lYear + "年 " + nl_date.IMonthCn + " " + nl_date.IDayCn + " " + Hcovert("0"));
            $('.ltime').text(_lt);
        }
        //设置农历
        setLtime();*/
    $(".software_name").val("周易起名 联系微信 " + getCookie('weixin'));
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
    $('#showme,#unlock').each(function () {
        $(this).click(function () {
            $('#mask,#maskpay').show();
        });
    });
    $('#mask').on('click', function (event) {
        $('#maskpay, #mask').hide();
    });
});
