$(function () {
    for (var i = 0, max = $('.Js_date').length; i < max; i++) {
        var calendar1 = new lCalendar().init('#' + $('.Js_date').eq(i).attr('id'));
    }
})

$(function () {
    // 性别选择 && 出生状态选择
    var sexCheckbox = $('.sm_form_sex');
    if (sexCheckbox.length) {
        sexCheckbox.children('span').on('click', function () {
            $(this).addClass('cur');
            $(this).siblings('span').removeClass('cur');
            var value = $(this).data('value');
            $(this).parent().find('input').val(value);
            if ($('#bornStatus').val() == '0') {
                $('.basic-info-more').hide()
            } else {
                $('.basic-info-more').show()
            }
        });
    }

});

$(function () {
    var $Hour = $('#hour');
    var $Minutes = $('#minutes');
    var def_day = '--';
    var def_value = 0;
    var str = '<option value="' + def_value + '" selected>' + def_day + '</option>';
    $Hour.append(str);
    $Minutes.append(str);
    // 时
    for (var i = 0; i < 24; i++) {
        var hStr = '<option value="' + i + '">' + i + '</option>';
        $Hour.append(hStr);
    }
    //分
    for (var i = 0; i < 60; i++) {
        var minStr = '<option value="' + i + '">' + i + '</option>';
        $Minutes.append(minStr);
    }
})

$(function () {
    $('#bornStatus').val(1);
    $("#btnGetNameNow").click(function () {
        if ($('#agree').prop('checked') === false) {
            $("#agreebox").addClass('shake');
            next = false;
            clearshake();
            return;
        }
        $("#smname").val($("#smname").val().replace(/[^\u4E00-\u9FA5]/g, ''));
        if ($("#smname").val() == '' || $("#smname").val().length > 2) {
            $("#smname").addClass('shake');
            next = false;
            clearshake();
            return;
        }
        var bornStatus = $("#bornStatus").val();
        if (bornStatus == 1) {
            if ($("#b_input").val() == '') {
                $("#birthday").addClass('shake');
                next = false;
                clearshake();
                return;
            }
        }
        var xm = $("#smname").val();
        var o = {};
        o.name = xm;
        o.gender = $("#gender").val();
        o.bornStatus = bornStatus;
        o.birthday = $("#b_input").val();
        o.xing = xm;
        o.ming = '';
        o.birthtime = $("#hour").val();
        o.birthmin = $("#minutes").val();
        o.phone = ""; //$("#phone").val();
        o.ver = $("#ver").val();
        o.from = getQueryString("from");
        //o.order_num = Math.round(new Date().getTime() / 1000).toString() + randomNum(1000000, 9999999).toString();
        var next = true;
        var order_num = '';
        var weixin_code = '';
        if (getCookie('weixin') != null || getCookie('weixin') != undefined || getCookie('weixin') != '') {
            weixin_code = getCookie('weixin');
        } else {
            weixin_code = weixinArr[randNum];
        }
        $.ajax({
            type: "post",
            url: "/api/wap_check/getOrderNum.php",
            async: false,
            data: { o: o, pay_from: 'wap2', weixin_code: weixin_code, product_kwd: '周易起名', product_id: 103 },
            success: function (re) {
                order_num = re;
            }
        });
        //o.order_num = order_num;
        if (!next) {
            clearshake();
            return;
        }
        location.href = "pay/?order_num="+order_num;
    })
})

jQuery(document).ready(function ($) {
    var ddte = new Date();
    var curr_d = ddte.getFullYear() + "-" + (ddte.getMonth() + 1) + "-" + ddte.getDate();
    $("#birthday").attr("data-date", curr_d);
});

$(function () {
    $(".commList h5 span").each(function () {
        var v = $(this).text();
        $(this).text(v.replace("CS17", "SHJ"));
    });
})

// 获取上一页或前一页
function getReferer() {
    if (document.referrer) {
        return document.referrer;
    } else {
        return false;
    }
}
//获取请求数据的关键字
function GetRequest(strHref, strName) {
    var arrTmp = [];
    if (strHref) {
        if (strHref.indexOf("?") != -1) {
            var str = strHref.substr(1);
            strs = str.split("&");
            for (var i = 0; i < strs.length; i++) {
                var arrTemp = strs[i].split("=");
                if (arrTemp[0].toUpperCase() == strName.toUpperCase()) return arrTemp[1];
            }
        }
    }
    return "";
}
//获取域名
function getSource(strHref) {
    var source = '';
    if (strHref) {
        intPos = strHref.indexOf("?"); // 参数开始位置
        //域名
        source = strHref.substr(0, intPos);
        return source;
    }
    return "";
}
$(function () {
    //获取搜索关键字
    function getkwd() {
        //var strHref = getReferer();
        //var baidu_kwd = GetRequest(strHref, 'word');
        //var shenma_kwd = GetRequest(strHref, 'wd');
        //var source = getSource(strHref);
        var kwd = getCookie('referer');
        var source = getCookie('source');

        setCookie("referer", kwd, "h24");
        setCookie("source", source, "h24");
        $.post('/api/wap_check/addSource.php', {
            referer: kwd,
            source: source,
            page: 'index',
            deviceType: 'wap'
        }, function (re) {
        })
    }
    getkwd();
    // console.log('referer result is ' + getCookie('referer'));
    // console.log('source result is ' + getCookie('source'));
})
