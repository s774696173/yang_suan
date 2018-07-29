<?php 
date_default_timezone_set('PRC');
    header('content-type:text/html;charset=utf-8');
    include $_SERVER['DOCUMENT_ROOT'].'/api/function.php';
    include $_SERVER['DOCUMENT_ROOT'].'/api/model.class.php';
    $ModelController = new ModelController();

    if(empty($_GET['amp;order_num'])){
        if(empty($_GET['order_num'])){
            $order_num = '';
        }else{
            $order_num = $_GET['order_num'];
        }
    }else{
        $order_num = $_GET['amp;order_num'];
    }
    
    $order_info_decode = $ModelController->getOrderStatusByOrderNum($order_num);
    $order_info_str = urldecode($order_info_decode['user_info']);
    $order_info_arr = json_decode($order_info_str,true);
    $xing = $order_info_arr['xing'];
    $gender = $order_info_arr['gender'];
    $birthtimeStr = $order_info_arr['birthtimeStr'];
    $birthtimeNongliStr = $order_info_arr['birthtimeNongliStr'];
    $bornStatus = $order_info_arr['bornStatus'];

    //向添加數據來源接口发起curl请求
    curl_add_source($order_num,'pay','suan',get_client_ip());

    //返回到首页
    $previous_page = 'http://'.$_SERVER['HTTP_HOST'].'/suan';

?>

<!DOCTYPE html>
<html lang="ch-ZN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=750,width=device-width, initial-scale=1,  initial-scale=1.0,maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>周易算命 - 美名宝</title>
    <script>
        (function (doc, win) {
            var docEl = doc.documentElement,
                resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
                recalc = function () {
                    var clientWidth = docEl.clientWidth;
                    if (!clientWidth) return;
                    var fts = clientWidth / 10;
                    if (fts < 32) {
                        fts = 32;
                    } else if (fts > 72) {
                        fts = 72;
                    }
                    docEl.style.fontSize = fts + 'px';
                };
            if (!doc.addEventListener) return;
            win.addEventListener(resizeEvt, recalc, false);
            doc.addEventListener('DOMContentLoaded', recalc, false);
        })(document, window);
    </script>
    <link rel="stylesheet" href="/Public/css/global.css">
    <link rel="stylesheet" href="/Public/css/fonts.css">
    <link rel="stylesheet" href="/Public/css/calendar.css">
    <link rel="stylesheet" href="/Public/css/animate.css">
    <link rel="stylesheet" href="/Public/css/suan-index.css">
</head>

<body class="page-suan mobile bg-primary-body">
    <main class="site-main">
        <header class="site-header">
            <a href="<?php echo $previous_page;?>" class="btn-back">
                <span>返回</span>
            </a>
            <a href="/suan/history" class="my-order">
                <span>我的订单</span>
            </a>
            <span class="">周易算命</span>
        </header>
        <article class="site-content">
            <section class="banner-homepage-1">
                <img src="/Public/images/suan/banner-homepage-1-1.png" alt="">
            </section>
            <section class="form-order">
                <ul class="form-groups form-info-user">
                    <li class="form-group">
                        <div>姓名：</div>
                        <div id='fullname'><?php echo $xing; ?></div>
                    </li>
                    <li class="form-group">
                        <div>性别：</div>
                        <div><?php echo $gender; ?></div>
                    </li>
                    <li class="form-group ">
                        <div>阳历：</div>
                        <div><?php echo $birthtimeStr; ?></div>
                    </li>
                    <li class="form-group ">
                        <div>农历：</div>
                        <div><?php echo $birthtimeNongliStr; ?><div>
                    </li>
                </ul>
                <div class="form-info-order">
                    <p class="order-price">
                        <span class="hotPrice"><del class="priceDiscount">原价:98</del>限时优惠价:<i class="price">29.80 </i>元</span>
                    </p>
                    <p class="order-num">
                        <span>订单号：<i id="wap_order_num"><?php echo $order_num;?></i></span>
                    </p>
                </div>
                <div class="paytype-choose">
                    <form action="http://qumingweb.huduntech.com/api/pay/pay_wap.php" method="get" id="weixinpay2" onsubmit="return addLoopCookie();">
                        <input type="hidden" name="xing" value="<?php echo $xing; ?>">
                        <input type="hidden" name="gender" value="<?php echo $gender; ?>">
                        <input type="hidden" name="birthtimeStr" value="<?php echo $birthtimeStr; ?>">
                        <input type="hidden" name="birthtimeNongliStr" value="<?php echo $birthtimeNongliStr; ?>">
                        <input type="hidden" name="software_name" value="算命-wap" class="software_name">
                        <input type="hidden" name="software_price" value="29.8">
                        <input type="hidden" name="pay_type" value="2">
                        <input type="hidden" name="order_num" value="<?php echo $order_num?>">
                        <input type="hidden" name="bornStatus" value="<?php echo $bornStatus;?>">
                        <a href="javascript:;" data-text="1301" onclick="$('#weixinpay2').submit()" class="pay-weixinpay"><i class="icon icon-weixinpay"></i>微信支付</a>
                    </form>
                    <form action="http://qumingweb.huduntech.com/api/pay/pay_wap.php" method="get" id="alipay2" onsubmit="return addLoopCookie();">
                        <input type="hidden" name="xing" value="<?php echo $xing; ?>">
                        <input type="hidden" name="gender" value="<?php echo $gender; ?>">
                        <input type="hidden" name="birthtimeStr" value="<?php echo $birthtimeStr; ?>">
                        <input type="hidden" name="birthtimeNongliStr" value="<?php echo $birthtimeNongliStr; ?>">
                        <input type="hidden" name="software_name" value="算命-wap" class="software_name">
                        <input type="hidden" name="software_price" value="29.8">
                        <input type="hidden" name="pay_type" value="1">
                        <input type="hidden" name="order_num" value="<?php echo $order_num?>">
                        <input type="hidden" name="bornStatus" value="<?php echo $bornStatus;?>">
                        <a href="javascript:;" data-text="12" onclick="$('#alipay2').submit()" class="pay-alipay"><i class="icon icon-alipay"></i>支付宝支付</a>
                    </form>
                </div>
            </section>
            <section class="infos-unlock">
                <h4 class="primary-title-3"><span>解锁基本信</span>息</h4>
                <img src="/Public/images/wyqmInfoToShow/wyqmInfoToShow-000.png">
                <h4 class="primary-title-3"><span>解锁五行分</span>析</h4>
                <img src="/Public/images/wyqmInfoToShow/wyqmInfoToShow-001.png">
                <h4 class="primary-title-3"><span>解锁强度分</span>析</h4>
                <img src="/Public/images/wyqmInfoToShow/wyqmInfoToShow-002.png">
                <h4 class="primary-title-3"><span>解锁八字分</span>析</h4>
                <img src="/Public/images/wyqmInfoToShow/wyqmInfoToShow-003.png">
                <h4 class="primary-title-3"><span>解锁吉祥分</span>析</h4>
                <img src="/Public/images/wyqmInfoToShow/wyqmInfoToShow-004.png">
                <h4 class="primary-title-3"><span>解锁生肖喜</span>忌</h4>
                <img src="/Public/images/wyqmInfoToShow/wyqmInfoToShow-005.png">
            </section>
        </article>
        <footer></footer>
    </main>
    <div class="btn-pay_bottomFixed">
        <div class="btn-primary-double">
            <span>
                <i>立即查看测算结果</i>
            </span>
        </div>
    </div>
    <script src="/Public/js/jquery.js"></script>
    <script src="/Public/js/daySelect.js"></script>
    <script src="/Public/js/calendar.min.js"></script>
    <script src="/Public/js/ntog.js"></script>
    <script src="/Public/js/cookie.js"></script>
    <script src="/Public/js/jquery.kxbdmarquee.js"></script>
    <script src="/Public/js/suan/main.js"></script>
    <script src="/Public/js/suan/pageBuy.js"></script>
</body>
<script>
    var _hmt = _hmt || [];
    (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?d6171fc44735066530ba341c3c20049e";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();
</script>

</html>