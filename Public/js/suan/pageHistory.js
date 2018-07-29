// 订单搜索
jQuery(document).ready(function ($) {
    function getSearchText() {
        var searchText = getQueryStrings();
        if (searchText && searchText.length > 0) {
            $('.header-search .search-text').val(searchText);
            $('.header-search .searchOrderLabel').hide();
            $('.header-search .searchSubmit').show();
        }
        if ($('.header-search .search-text').val().length > 0) {
            $('.header-search .searchOrderLabel').hide();
            $('.header-search .searchSubmit').show();
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
});
