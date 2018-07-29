// 字符串去重
String.prototype.unique = function () {
    var newStr = '';
    for (var i = 0; i < this.length; i++) {
        if (newStr.indexOf(this[i]) == -1) {
            newStr += this[i];
        }
    }
    return newStr
}

// 字符串批量替换
String.prototype.replaceBy = function (A, B) {
    var C = this;
    for (var i = 0; i < A.length; i++) {
        C = C.replace(A[i], B[i]);
    };
    return C;
};

// 字符串从哪开始多长字符去掉
String.prototype.removeFrom = function (A, B) {
    var s = '';
    if (A > 0) s = this.substring(0, A);
    if (A + B < this.length) s += this.substring(A + B, this.length);
    return s;
};


// 去掉所有空白字符串
String.prototype.trimAll = function () {
    return this.replace(/\s+/g, '')
};


// 判断字符串是否以指定的字符串结束
String.prototype.endBy = function (A, B) {
    var C = this.length;
    var D = A.length;
    if (D > C) return false;
    if (B) {
        var E = new RegExp(A + '$', 'i');
        return E.test(this);
    } else return (D == 0 || this.substr(C - D, D) == A);
};

// 判断字符串是否以指定的字符串开始
String.prototype.startFrom = function (str) {
    return this.substr(0, str.length) == str;
};

// 是否包含指定字符串
String.prototype.isContain = function (subStr) {
    var currentIndex = this.indexOf(subStr);
    if (currentIndex != -1) {
        return true;
    } else {
        return false;
    }
}

//清除摇晃
function clearshake() {
    setTimeout(function () {
        $(".shake").removeClass('shake');
    }, 2000)
}

function getRandomInt(min, max) {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min)) + min;
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


function getQueryStrings() {
    var url = location.search;
    var theRequest = new Object();
    if (url.indexOf("?") != -1) {
        var str = url.substr(1);
        str = str.split("&");
        for (var i = 0; i < str.length; i++) {
            theRequest[str[i].split("=")[0]] = unescape(str[i].split("=")[1]);
        }
    }
    return theRequest;
}

function getQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);
    if (r != null) return unescape(r[2]); return null;
}

babyMain = (function () {
    return {
        ispc: (function () {
            var userAgent = window.navigator.userAgent.toLowerCase();
            return /windows nt/i.test(userAgent);
        })(),
        isOnline: (function () {
            return navigator.onLine;
        })(),
        isPhoneNum: function (str) {
            return RegExp(/^1[34578]\d{9}$/).test(str);
        },
        setWxCode: function () {
            var weixinArr = [], weixinArrLength = 0, randNum = 0;
            $.ajaxSettings.async = false;
            $.getJSON("/api/weixin_code.json", function (data) {
                weixinArr = data
            });
            weixinArrLength = weixinArr.length;
            randNum = Math.floor(Math.random() * weixinArrLength);
            if (getCookie('weixin')) {
            } else {
                setCookie("weixin", weixinArr[randNum], "d365");
            }
        },
        siteInfo: function () {
            var curSiteDomain = '';
            var info = {
                "name": "",
                "title": "",
                "autoPc": 1,
                "wxShow": 1
            };
            curSiteDomain = window.location.href;
            $.ajaxSettings.async = false;
            $.getJSON('/wap/siteInfo_wap.json', function (data) {
                $.each(data, function (i, item) {
                    if (curSiteDomain.isContain(item.name))
                        info = item;
                });
            });
            return info;
        },
        getSiteInfo: function () {
            var classNameWxShow = '';
            var wxCodeText = '';
            var info = this.siteInfo();
            switch (info.wxShow) {
                case 0:
                    wxCodeText = '';
                    classNameWxShow = 'hidden';
                    break;
                case 1:
                    wxCodeText = '加老师微信咨询<span class="weixinAccount">' + getCookie('weixin') + '</span>测算';
                    classNameWxShow = 'default';
                    break;
                case 2:
                    wxCodeText = '加老师微信咨询测算';
                    classNameWxShow = 'textOnly';
                    break;
            }
            $('body').addClass(info.name).append('<div class="site-copyright"><span>' + info.title + '</span></div>');
            $('.add_dashi_weixin').addClass(classNameWxShow).html(wxCodeText);
        }
    }
})(window)

jQuery(document).ready(function ($) {

    // cookie设置微信号
    babyMain.setWxCode();
    // 获取站点信息
    babyMain.getSiteInfo();

    // 我们的联系方式
    $('.usPhoneNum').html('<a href="tel:15068888729">15068888729</a>');

    // 根据底部公司信息调整body高度
    $('body').css({
        'padding-bottom': $('.btnUnlockFix').outerHeight() + 'px'
    });
    // 点击微信号打开微信客户端
    if ($('.item-addWeixin').length > 0) {
        $('body').css({
            'padding-bottom': $('.item-addWeixin').outerHeight() + 'px'
        })
    }
});