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
                $('.basic-info-more').hide();
                $('.form-groups.form-name-get .form-group').eq(1).addClass('no-border');
            } else {
                $('.basic-info-more').show();
                $('.form-groups.form-name-get .form-group').eq(1).removeClass('no-border');
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
});

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
        if ($("#smname").val() == '' || $("#smname").val().length > 4) {
            $("#smname").addClass('shake');
            next = false;
            clearshake();
            return;
        }
        var bornStatus = $("#bornStatus").val();
   
            if ($("#b_input").val() == '') {
                $("#birthday").addClass('shake');
                next = false;
                clearshake();
                return;
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
        o.fullname = $("#ver").val();
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
            data: {
                o: o,
                pay_from: 'wap',
                weixin_code: weixin_code,
                product_kwd: '周易算命',
                product_id: 106
            },
            success: function (re) {
                order_num = re;
            }
        });
        //o.order_num = order_num;
        if (!next) {
            clearshake();
            return;
        }
        location.href = "pay/?order_num=" + order_num;
    })
})

jQuery(document).ready(function ($) {
    var ddte = new Date();
    var curr_d = ddte.getFullYear() + "-" + (ddte.getMonth() + 1) + "-" + ddte.getDate();
    $("#birthday").attr("data-date", curr_d);
    $('.btnSolution').on({
        click: function () {
            $('html, body').animate({
                scrollTop: 0
            }, 500)
        }
    })
});
