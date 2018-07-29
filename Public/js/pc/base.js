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



// babyMain
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
            //curSiteDomain = 'quming.jiakaodashi.com';
            $.ajaxSettings.async = false;
            $.getJSON('/pc/siteInfo.json', function (data) {
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
             var asideContactShow = '';
            var info = this.siteInfo();
            var buyQrcode='';
            var wxCode = getCookie('weixin');
            var footerHtml ='';
            switch (info.wxShow) {
                case 0:
                    wxCodeText = '';
                    classNameWxShow = 'hidden';
                    asideContactShow = 'hidden';
                    break;
                case 1:
                    wxCodeText = '加老师微信咨询<span class="weixinAccount">' + wxCode + '</span>人工起名';
                    classNameWxShow = 'default';
                    asideContactShow = 'default';
                    buyQrcode='<img src="/Public/images/pc/qrcode-wxMaster.jpg" height="134" width="134">';
                    break;
                case 2:
                    wxCodeText = '';
                    classNameWxShow = 'textOnly';
                    break;
            }
            footerHtml = '<div class="footer">' +'<p class="copyright">' + info.title + '</p>' +'</div>';
            $('.add_dashi_weixin').addClass(classNameWxShow).html(wxCodeText);
            $('.asideContactWx').addClass(asideContactShow);
            $('body').addClass(info.name).append(footerHtml);
            $('.wxAccountQrcode').html(buyQrcode);
            $('.wxCode').html(wxCode);

        }
    }
})(window)


jQuery(document).ready(function ($) {
    var viewWidth = document.body.clientWidth || document.documentElement.clientWidth;
    window.onscroll = function () {
        var scrollTop = document.documentElement.scrollTop || window.pageYOffset || document.body.scrollTop;
        if (scrollTop < 890) {
            $('.aside-fixed').css('display', 'none');
        } else {
            $('.aside-fixed').css('display', 'block');
        };
    };
    $('.nav li').on({
        click: function () {
            var curPosition = $(this).children('a').attr('href');
            var li = $('.aside-nav li a[href="' + curPosition + '"]').parent('li');
            $(this).addClass('active').siblings().removeClass('active');
            li.addClass('active').siblings().removeClass('active');
        }
    })
    $('.aside-nav li').on({
        click: function () {
            var curPosition = $(this).children('a').attr('href');
            var li = $('.nav li a[href="' + curPosition + '"]').parent('li');
            $(this).addClass('active').siblings().removeClass('active');
            li.addClass('active').siblings().removeClass('active');
        }
    })
    $('.aside-nav li').each(function (index, item) {
        if ($(this).children('a').attr('href') == window.location.hash) {
            $(this).addClass('active').siblings().removeClass('active');
        }
    })
    $(window).resize(function () {
        asidePositionAjust()
    })
    function asidePositionAjust() {
        var asideNav = $('.aside-nav');
        var asideContact = $('.aside-contact');
        if ($(window).width() < 1200) {
            asideNav.addClass('slide');
            asideContact.addClass('slide');
        } else {
            asideNav.removeClass('slide');
            asideContact.removeClass('slide');
        }
    }
    asidePositionAjust();
    $('.aside-contact, .aside-nav').on({
        mouseenter: function () {
            $(this).removeClass('slide')
        },
        mouseleave: function () {
            if ($(window).width() < 1200 && !$(this).hasClass('slide')) {
                $(this).addClass('slide')
            }
        }
    })
});

$(function () {
    if ($(".lazy").length > 0) {
        $(".lazy").lazyload({
            effect: "fadeIn"
        });
    }
});

jQuery(document).ready(function ($) {
    $(window).on('scroll', function () {
        if ($(this).scrollTop() > 100) {
            $(".backToTop").fadeIn();
        } else {
            $(".backToTop").fadeOut();
        }
    });
    $(".backToTop").on('click', function (e) {
        $("html, body").animate({ scrollTop: 0 }, 500);
    });
    $(".backToTop").hide();
});


$(function () {
    // // cookie设置微信号
    babyMain.setWxCode();
    // // 获取站点信息
    babyMain.getSiteInfo();
})