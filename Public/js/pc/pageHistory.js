jQuery(document).ready(function ($) {
    function getSearchText() {
        var searchText = getQueryStrings();
        if (searchText.search) {
            $('.header-search .search-text').val(searchText.search);
            $('.header-search .searchOrderLabel').hide();
            $('.header-search .searchSubmit').show();
        }else{
            $('.header-search .search-text').val('');
        }
    }
    getSearchText();
    $('.header-search .searchOrderLabel').on({
        click: function () {
            $(this).hide();
            $('.header-search .search-text').attr({
                'placeholder': '请输入订单号查找'
            }).focus();
            $('.header-search .searchSubmit').show();
        }
    })
    $('.header-search .search-text').on({
        blur: function () {
            if ($(this).val().length < 1) {
                $(this).attr({
                    'placeholder': ''
                });
                $('.header-search .searchSubmit').hide();
                $('.header-search .searchOrderLabel').show();
            }
        }
    })
    if ($('.page-history').length > 0 && $('.page-history').outerHeight() < $(window).height()) {
        $('.page-history .footer').addClass('fix-bottom');
        $('.page-history').css({
            'padding-bottom': $('.page-history .footer').outerHeight() + 'px'
        })
    }
});