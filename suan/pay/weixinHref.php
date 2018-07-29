<?php

include $_SERVER['DOCUMENT_ROOT'].'/api/function.php';

$redirect_url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

$previous_page = $_GET['redirect_url'];

$arr = parse_url($previous_page);

$arr_query = convertUrlQuery($arr['query']);

$order_num = $arr_query['order_num'];

$url = $_GET['tenpayurl'].'&redirect_url='.urlencode($redirect_url);

//向添加數據來源接口发起curl请求
curl_add_source($order_num,'weixinHref','wap',get_client_ip());

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta name="viewport" content="width=750,width=device-width, initial-scale=1,  initial-scale=1.0,maximum-scale=1.0, user-scalable=no">
    <title>微信支付确认页</title>
    <style type='text/css'>
    .layer {
        position: fixed;
        z-index: 3;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.4);
    }

    .m_model {
        position: fixed;
        top: 120px;
        right: 0;
        left: 0;
        margin: 0 auto;
        box-sizing: border-box;
        z-index: 4;
        width: 80%;
        height: 180px;
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
    }

    .m_cont {
        padding-top: 45px;
        font-size: 16px;
        color: #000;
        margin-bottom: 38px;
        text-align: center;
    }

    .m_fot {
        height: 38px;
        position: absolute;
        width: 100%;
        left: 0;
        bottom: 0;
    }

    .m_fot a {
        display: block;
        width: 50%;
        height: 100%;
        float: left;
        text-align: center;
        line-height: 36px;
        font-size: 16px;
        color: #c1c1c1;
        text-decoration: none;
        border-top: 1px solid #efefef;
        background: #f1f1f1;
    }

    .m_fot .active {
        color: #fff;
        background: #fd6467;
        border-top: 1px solid #fd6467;
    }
</style>
</head>

<body>
    <div class='layer' id='layer_s'></div>
    <div class='m_model' id='model_s'>
        <div class='m_cont'>
            <span>点击微信付款按钮
                <br/>
                <div style='margin-top: 10px'></div>打开微信完成付款</span>
        </div>
        <div class='m_fot'>
            <a href='<?php echo $previous_page;?>'>取消</a>
            <a href='javascript:;' class='active' onclick="checkPay()">微信付款</a>
        </div>
    </div>
    <script src="/Public/js/jquery.js"></script>
    <script src="/Public/js/cookie.js"></script>

    <script type="text/javascript">
        function checkPay() {
            //当点击支付的同时增加cookie
            //function addLoopCookie(){
            setCookie("loopCookie", 1, "s300");
            //}


            var order_num = '<?php echo $order_num;?>';
            $.post('/api/wap_check/checkOrderStatus.php', {
                order_num: order_num
            }, function (re) {
                if (re == 3) {
                    //if(getCookie('paid_href')==order_num){

                    //}else{
                    //把订单存到cookie
                    setCookie("order_num", getCookie('order_num') + '-' + order_num, "d365");
                    //跳转到姓名列表
                    setCookie("paid_href", order_num, "s300");
                    window.location.href = 'quming/quminglist.php?order_num=' + order_num;
                    //}
                } else {
                    window.location.href = '<?php echo $url;?>';
                }
            })
        }

        function GetQueryString(name) {
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
            var r = window.location.search.substr(1).match(reg);
            if (r != null) return unescape(r[2]);
            return null;
        }

        if (getCookie('loopCookie') == 1) {
            window.setInterval(checkOrderStatus, 3000);
        }


        //进行轮训查询支付状态
        function checkOrderStatus() {
            var order_num = '<?php echo $order_num;?>';
            $.post('/api/wap_check/checkOrderStatus.php', {
                order_num: order_num
            }, function (re) {
                console.log(re)
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
    </script>
</body>

</html>