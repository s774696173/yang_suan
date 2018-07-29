<?php
    include $_SERVER['DOCUMENT_ROOT'].'/api/model.class.php';

    $ModelController = new ModelController();

    $order_nums = empty($_COOKIE['order_num'])?'':$_COOKIE['order_num'];
    $search = empty($_GET['search'])?'':$_GET['search'];//查询关键字
    $order_num_arr1 = explode('-', $order_nums);
    unset($order_num_arr1[0]);

    $order_num_arr = array_unique($order_num_arr1);
    $order_info = array();
    if($search){
        $user = $ModelController->getOrderStatusByOrderNum($search,'算命');
        if($user['order_status']==3){
            $order_info[$v]['order_num'] = $search;
            $order_info_arr = json_decode($user['user_info'], true);
            $order_info[$v]['xing'] = urldecode($order_info_arr['xing']);
            $order_info[$v]['create_time'] = $user['create_time'];
            $order_info[$v]['gender'] = urldecode($order_info_arr['gender']);
            $order_info[$v]['birthtimeStr'] = urldecode($order_info_arr['birthtimeStr']);
        }
    }else{
        if(empty($order_num_arr1)){
            $order_null = '<span style="margin-left:40%">暂无订单记录</span>';
        }else{
            foreach($order_num_arr as $k=>$v){
                $user = $ModelController->getOrderStatusByOrderNum($v,'算命');
                
                if($user['order_status']==3){
                    $order_info[$v]['order_num'] = $v;
                    $order_info_arr = json_decode($user['user_info'], true);
                    $order_info[$v]['xing'] = urldecode($order_info_arr['xing']);
                    $order_info[$v]['create_time'] = $user['create_time'];
                    $order_info[$v]['gender'] = urldecode($order_info_arr['gender']);
                    $order_info[$v]['birthtimeStr'] = urldecode($order_info_arr['birthtimeStr']);
                }
            }
        }

    }
    if($order_info==array()){
        $order_null = '<span style="margin-left:40%">暂无订单记录</span>';
    }

    //上一页URL
    $previous_page = getenv('HTTP_REFERER');

?>
<!DOCTYPE html>
<html lang="ch-ZN">

<head>
    <meta charset="UTF-8">
    <meta name="applicable-device" content="mobile">
    <meta name="viewport" content="width=750,width=device-width, initial-scale=1,  initial-scale=1.0,maximum-scale=1.0, user-scalable=no">
    <title>历史订单 - 美名宝</title>
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
    <link rel="stylesheet" type="text/css" href="/Public/css/global.css">
    <link rel="stylesheet" type="text/css" href="/Public/css/fonts.css">
    <link rel="stylesheet" type="text/css" href="/Public/css/animate.css">
    <link rel="stylesheet" type="text/css" href="/Public/css/calendar.css">
    <link rel="stylesheet" type="text/css" href="/Public/css/history.css">
</head>

<body class="page-history">
    <main class="site-main">
        <header class="site-header">
            <span class="">我的订单</span>
        </header>
        <article class="site-content">
            <div class="header-search">
                <form action="index.php" method="get">
                    <input type="text" name="search" value="" class="search-text" id="searchOrder">
                    <p class="searchOrderLabel" ><span class="icon icon-search"></span>请输入订单号查找</p>
                    <button type="submit" class="searchSubmit"></button>
                </form>
            </div>
            <p class="myContact add_dashi_weixin"></p>
            <p class="myContact">以下是您支付过的的测算订单，点击查看详情</p>
            <div class="order" id="orderlist">
                <ul class="myOrder">
                    <?php 
                        $orderListItem = '';
                        if(is_array($order_info)){
                            foreach($order_info as $v){
                                $orderListItem .= '<li class="myOrderItem">
                                    <div class="myOrderItemDetail orderTitle">
                                        <span class="orderNum">订单号：'.$v['order_num'].'</span>
                                        <span class="orderStatus">已支付</span>
                                    </div>
                                    <div class="myOrderItemDetail orderProduct">
                                        <span>姓名：<i>'.$v['xing'].'</span>
                                    </div>
                                    <div class="myOrderItemDetail orderTime">
                                        <span>订单时间：<i>'.$v['create_time'].'</i></span><span class="orderPreview"><a href="../pay/quming/quminglist.php?order_num='.$v['order_num'].'">查看</a></span>
                                    </div>
                                </li>';
                            }
                        }
                        echo $orderListItem;
                    ?>
                </ul>
                <a href="<?php echo $previous_page;?>" class="btn-back-history">返回</a>
            </div>
            <?php echo $order_null;?>
        </article>
        <footer class="site-footer"></footer>
    </main>
    <script src="/Public/js/jquery.js"></script>
    <script src="/Public/js/cookie.js"></script>
    <script src="/Public/js/suan/main.js"></script>
    <script src="/Public/js/suan/pageHistory.js"></script>
</body>
<script>
    // var _hmt = _hmt || [];
    // (function() {
    //     var hm = document.createElement("script");
    //     hm.src = "https://hm.baidu.com/hm.js?d6171fc44735066530ba341c3c20049e";
    //     var s = document.getElementsByTagName("script")[0];
    //     s.parentNode.insertBefore(hm, s);
    // })();
</script>

</html>