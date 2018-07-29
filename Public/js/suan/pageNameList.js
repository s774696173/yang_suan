/** 姓名列表页面 */
jQuery(document).ready(function ($) {
    // $('.page-name-list .top-title').on({
    //     click: function (e) {
    //         e.stopPropagation();
    //         $(this).find('.options').fadeIn();
    //     }
    // })
    // $(document).on({
    //     click: function () {
    //         var topTitle = $('#divTop.page-name-list .top-title');
    //         if (!topTitle.is(event.target) && topTitle.has(event.target).length === 0) {
    //             $('.page-name-list .options').fadeOut();
    //         }
    //     }
    // })
    function addWxServicePadding() {
        if ($('.item-addWeixin').length > 0) {
            var height = $('.item-addWeixin').outerHeight();
            $('body').css({
                'padding-bottom': height + 'px'
            })
        }
    }
    addWxServicePadding();
    $(window).resize(function (event) {
        addWxServicePadding()
    });
    function addWxServicePadding() {
        if ($('.item-addWeixin').length > 0) {
            var height = $('.item-addWeixin').outerHeight();
            $('body').css({
                'padding-bottom': height + 'px'
            })
        }
    }
    addWxServicePadding();
    $(window).resize(function (event) {
        addWxServicePadding()
    });
});
function changeURLArg(url, arg, arg_val) {
    var pattern = arg + '=([^&]*)';
    var replaceText = arg + '=' + arg_val;
    if (url.match(pattern)) {
        var tmp = '/(' + arg + '=)([^&]*)/gi';
        tmp = url.replace(eval(tmp), replaceText);
        return tmp;
    } else {
        if (url.match('[\?]')) {
            return url + '&' + replaceText;
        } else {
            return url + '?' + replaceText;
        }
    }
}
$(function () {
    var _content = []; //临时存储li循环内容
    var getMoreList = {
        _default: 18, //默认显示图片个数
        _loading: 18, //每次点击按钮后加载的个数
        _total: $(".loadmore ul.list li").length,
        init: function () {
            var lis = $(".loadmore .hidden li");
            $(".loadmore ul.list").html("");
            for (var n = 0; n < getMoreList._default; n++) {
                lis.eq(n).appendTo(".loadmore ul.list");
            }
            $(".loadmore ul.list img").each(function () {
                $(this).attr('src', $(this).attr('realSrc'));
            })
            for (var i = getMoreList._default; i < lis.length; i++) {
                _content.push(lis.eq(i));
            }
            $(".loadmore .hidden").html("");
        },
        loadMore: function () {
            var mLis = $(".loadmore ul.list li").length;
            for (var i = 0; i < getMoreList._loading; i++) {
                var target = _content.shift();
                if (!target) {
                    $('.loadmore .more').html("<p>全部加载完毕...</p>");
                    break;
                }
                $(".loadmore ul.list").append(target);
            }
        }
    }
    getMoreList.init();
    $('.add_more').on({
        click: function () {
            getMoreList.loadMore();
            console.log(_content);
            if (_content.length == 0) {
                $('.add_more').html('没有更多了').css({
                    'opacity': '.5'
                });
                return false;
            }
        }
    })

    $('.surname-length>span').on({
        click: function () {
            $('.surname-length .surname-options').show();
        }
    })
    $('.surname-length .surname-options a').on({
        click: function () {
            $url = '';
            switch ($(this).index()) {
                case 0:
                    $url = changeURLArg($('.namesReget').attr('href'), 'single', 1);
                    $('.surname-length-value').text('单字名');
                    break;
                case 1:
                    $url = changeURLArg($('.namesReget').attr('href'), 'single', 0);
                    $('.surname-length-value').text('双字名');
                    break;
            }
            $('.namesReget').attr({
                href: $url
            });
            $('.surname-length .surname-options').hide();
        }
    })
    $(document).on({
        click: function () {
            var topTitle = $('.surname-length');
            if (!topTitle.is(event.target) && topTitle.has(event.target).length === 0) {
                $('.surname-length .surname-options').hide();
            }
        },
        touchend: function () {
            var topTitle = $('.surname-length');
            if (!topTitle.is(event.target) && topTitle.has(event.target).length === 0) {
                $('.surname-length .surname-options').hide();
            }
        }
    })
    $('.g-title-primary span').append('<i class="icon-pattern pattern-top-left">&#x1009;</i><i class="icon-pattern pattern-top-right">&#x1009;</i><i class="icon-pattern pattern-bottom-left">&#x1009;</i><i class="icon-pattern pattern-bottom-right">&#x1009;</i>');
})
