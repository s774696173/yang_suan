 jQuery(document).ready(function ($) {
    var sexCheckbox = $('.J_sex');
    if (sexCheckbox.length) {
        sexCheckbox.children('span').on('click', function () {
            $(this).addClass('cur');
            $(this).siblings('span').removeClass('cur');
            var value = $(this).data('value');
            $(this).parent().find('input').val(value);
        });
    }
    $('#bornStatus').val(1);
    var bornStatusCheckbox = $('.bornStatus');
    if (bornStatusCheckbox.length > 0) {
        bornStatusCheckbox.children('span').on('click', function () {
            $(this).addClass('cur');
            $(this).siblings('span').removeClass('cur');
            var value = $(this).data('value');
            $(this).parent().find('input').val(value);

            //console.log($('#bornStatus').val())
            if ($('#bornStatus').val() == '0') {
                $('.form-group-date').hide();
            } else {
                $('.form-group-date').show();
            }
        });
    }


    $('#bjx a').live('click', function () {
        var val = $(this).html();
        $('#xs_input').val(val);
        $('.display_win').hide();
    });
    $('.close').click(function () {
        $('.display_win').hide();
    });
    $('#xs_input').click(function () {
        $('.display_win').show();
    });
    $('.qk').click(function () {
        $('#xs_input').val('');
    });

    //年
    var year = '<option value="{year}">{year}</option>';
    var _y_lsp = [];
    for (var i = 1940; i < 2050; i++) {
        _y_lsp.push(i);

    }
    for (var j = 0; j < _y_lsp.length; j++) {
        var _temp = year;
        _temp = _temp.replace(/{year}/g, _y_lsp[j]);
        if (_temp.indexOf('2018') != -1) {
            _temp = _temp.replace('option', 'option selected="selected" ');
        }
        $('.year').append(_temp);
    }
    //日
    var day = '<option value="{day}">{day}</option>';
    var _m_lsp = [];
    for (var k = 1; k < 32; k++) {
        _m_lsp.push(k);
    }
    for (var d = 0; d < _m_lsp.length; d++) {
        var m_temp = day;

        m_temp = m_temp.replace(/{day}/g, _m_lsp[d]);

        if (_m_lsp[d] == (new Date()).getDate()) {
            m_temp = m_temp.replace('option', 'option selected="selected" ');
        }

        $('.day').append(m_temp);
    }
    //分
    var min = '<option value="{min}">{min}</option>';
    var _min_lsp = [];
    for (var m = 0; m < 60; m++) {
        _min_lsp.push(m);
    }
    for (var m1 = 0; m1 < _min_lsp.length; m1++) {
        var min_temp = min;
        min_temp = min_temp.replace(/{min}/g, _min_lsp[m1]);
        $('.minute').append(min_temp);
    }
    $('#diswin').mouseleave(function () {
        $(this).hide();
    })
});
jQuery(document).ready(function ($) {
    var master = "dong";
    $(function () {
        $("#cs").click(function () {
            cs();
        })
        var id = 0;
        $("#img,#explain,#cjwn").css('cursor', 'pointer').click(function () {
            location.href = '#top';
        })
    })

    function getRandomInt(min, max) {
        min = Math.ceil(min);
        max = Math.floor(max);
        return Math.floor(Math.random() * (max - min)) + min;
    }

    function cs() {
        //if($('#agree').prop('checked')===false){
        //  $("#agreebox").addClass('shake');next=false;clearshake();return;
        //}

        $("#xs_input").val($("#xs_input").val().replace(/[^\u4E00-\u9FA5]/g, ''));

        if ($("#xs_input").val() == '' || $("#xs_input").val().length > 2) {
            $("#xs_input").addClass('shake');
            next = false;
            clearshake();
            return;
        }
        if ($("#b_input").val() == '') {
            $("#xs_input").addClass('shake');
            next = false;
            clearshake();
            return;
        }
        var xm = $("#xs_input").val();



        var _newdata = $("#year").val() + "-" + $("#month").val() + '-' + $("#day").val();
        if ($("#dtype").val() == '农历') {
            _newdata = _newdata.split('-');
            var _s = calendar.lunar2solar(parseInt(_newdata[0]), parseInt(_newdata[1]), parseInt(_newdata[2]));
            _newdata = (_s.cYear + "-" + _s.cMonth + '-' + _s.cDay);
        }


        var o = {};
        o.name = xm;
        o.gender = $("#gender").val();
        o.bornStatus = $("#bornStatus").val();
        o.birthday = _newdata;
        o.xing = xm;
        o.ming = '';
        o.birthtime = $("#time").val();
        o.birthmin = $("#minute").val();
        o.phone = (+new Date()) + "" + getRandomInt(1000, 9999);
        o.ver = $("#ver").val();
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
            data: { o: o, pay_from: 'pc', weixin_code: weixin_code, product_kwd: '周易起名', product_id: 102 },
            success: function (re) {
                order_num = re;
            }
        });
        o.order_num = order_num;
        var next = true;

        if (!next) {
            clearshake();
            return;
        }

        location.href = "order?order_num=" + order_num;

    }

    //获取随机数
    function randomNum(minNum, maxNum) {
        switch (arguments.length) {
            case 1:
                return parseInt(Math.random() * minNum + 1, 10);
                break;
            case 2:
                return parseInt(Math.random() * (maxNum - minNum + 1) + minNum, 10);
                break;
            default:
                return 0;
                break;
        }
    }

    function clearshake() {
        setTimeout(function () { $(".shake").removeClass('shake'); }, 2000)
    }

    /**********************设置微信cookie*******************************/
    $.ajaxSettings.async = false;
    var weixinArr = [];
    $.getJSON("/api/weixin_code.json", function (data) {
        $.each(data, function (infoIndex, info) {
            weixinArr.push(info);
        })
    });

    var weixinArrLength = weixinArr.length;

    var randNum = Math.floor(Math.random() * weixinArrLength);

    //如果没有获取到cookie  则生成cookie
    if (getCookie('weixin')) {
    } else {
        setCookie("weixin", weixinArr[randNum], "d365");
    }

    $('.weixin_code').html(getCookie('weixin'));
    //console.log(getCookie('weixin'));

    /******************获取用户来源数据**********************/
//对url进行解码
function urldecode(encodedString)
{
    var output = encodedString;
    var binVal, thisString;
    var myregexp = /(%[^%]{2})/;
    function utf8to16(str)
    {
        var out, i, len, c;
        var char2, char3;
 
        out = "";
        len = str.length;
        i = 0;
        while(i < len) 
        {
            c = str.charCodeAt(i++);
            switch(c >> 4)
            { 
                case 0: case 1: case 2: case 3: case 4: case 5: case 6: case 7:
                out += str.charAt(i-1);
                break;
                case 12: case 13:
                char2 = str.charCodeAt(i++);
                out += String.fromCharCode(((c & 0x1F) << 6) | (char2 & 0x3F));
                break;
                case 14:
                char2 = str.charCodeAt(i++);
                char3 = str.charCodeAt(i++);
                out += String.fromCharCode(((c & 0x0F) << 12) |
                        ((char2 & 0x3F) << 6) |
                        ((char3 & 0x3F) << 0));
                break;
            }
        }
        return out;
    }
    while((match = myregexp.exec(output)) != null
                && match.length > 1
                && match[1] != '')
    {
        binVal = parseInt(match[1].substr(1),16);
        thisString = String.fromCharCode(binVal);
        output = output.replace(match[1], thisString);
    }
     
    //output = utf8to16(output);
    output = output.replace(/\\+/g, " ");
    output = utf8to16(output);
    return output;
}





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
    //获取搜索关键字
    function getkwd() {
        var strHref = getReferer();
        //如果没有获取到前一页信息
        if(!strHref){
            return false;
        }
        strHref = urldecode(strHref);
        var baidu_kwd = GetRequest(strHref, 'word');
        var shenma_kwd = GetRequest(strHref, 'wd');
        var source = getSource(strHref);
        setCookie("referer", baidu_kwd + shenma_kwd, "h24");
        setCookie("source", source, "h24");
        $.post('/api/wap_check/addSource.php', {
            referer: baidu_kwd + shenma_kwd,
            source: source,
            page: 'index',
            deviceType: 'pc'
        }, function (re) {

        })
    }
    getkwd();
});

$(function () {
    $('#owl-banner-homepage-1').owlCarousel({
        items: 1,
        lazyLoad: true,
        autoPlay: true,
        responsive: true,
        singleItem: true
    });
    $(window).resize(function () {
        $('#owl-banner-homepage-1').css({
            'width': '100%'
        })
    })
});