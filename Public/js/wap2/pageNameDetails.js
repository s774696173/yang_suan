function modalUserContactSet() {
    var userContact = $('.userPhoneNum').val();
    var result = userContact.match(/^1[0-9]{10}$|^106[0-9]{9,12}$/)
    if (result == null) {
        $('.modal-msg').show();
        return false;
    }
    var wap_order_num = $('#wap_order_num').html();

    /*    var re = '';
        $.ajax({ 
            type: "post", 
            url: "/api/wap_check/bindMobile.php",
            async:false,
            data:{mobile:userContact,order_num:wap_order_num},
            success: function(re){
                re = re;
            }
        });*/
    $.post("/api/wap_check/bindMobile.php", { mobile: userContact, order_num: wap_order_num }, function (re) {
        setCookie("userPhoneNum", re, "d365");
        $('.modal').hide();
    })

}
function userPhoneNumGet() {
    if (!getCookie('userPhoneNum')) {
        $('.modal-user-contact').show();
    }
}
$(function () {
    userPhoneNumGet();
    $('.modal .btn-close').on({
        click: function () {
            $('.modal').hide();
        }
    })
    $('.modal-user-contact input').on({
        focus: function () {
            $('.modal-msg').hide();
        }
    })
    $('.modal-user-contact .btn-submit').on({
        click: function () {
            modalUserContactSet();
        }
    })
})

$(function () {
    $('.g-title-primary span').append('<i class="icon-pattern pattern-top-left">&#xe612;</i><i class="icon-pattern pattern-top-right">&#xe612;</i><i class="icon-pattern pattern-bottom-left">&#xe612;</i><i class="icon-pattern pattern-bottom-right">&#xe612;</i>');
})