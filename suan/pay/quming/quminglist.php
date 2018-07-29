<?php
header('content-type:text/html;charset=utf-8');
	include $_SERVER['DOCUMENT_ROOT'].'/api/function.php';
    include $_SERVER['DOCUMENT_ROOT'].'/api/model.class.php';
    include $_SERVER['DOCUMENT_ROOT'].'/api/function_html.php';
    $ModelController = new ModelController();
    
    //$fullname = $_GET['fullname'];
    $order_num = $_GET['order_num'];

    // 判断是够支付过
    $order_info = $ModelController->getOrderStatusByOrderNum($order_num);
	if($order_info['order_status']!=3){
		echo "<script>alert('该订单还未支付！');history.go(-1);</script>";
		return false;
    }

    // 用户信息
    $data_user_info = json_decode($order_info['user_info'], true);
    $fullname = urldecode($data_user_info['xing']);
    $data_birthtimeStr = urldecode($data_user_info['birthtimeStr']);
    $data_gender = urldecode($data_user_info['gender']);
    $data_birthtimeNongliStr = urldecode($data_user_info['birthtimeNongliStr']);
    $data_bornStatus = urldecode($data_user_info['bornStatus']);

    //八字
    $date_req = preg_replace('/[ ]/', '', $data_birthtimeStr);
    $year_req = (int)mb_substr($date_req,0,4,'UTF-8');
    $month_req = (int)mb_substr($date_req,5,2,'UTF-8');
    $day_req = (int)mb_substr($date_req,8,2,'UTF-8');
    $hour_req = (int)mb_substr($date_req,11,2,'UTF-8');
    $minute_req = (int)mb_substr($date_req,14,2,'UTF-8');
    $data_bazi  = get_bazi_paid($year_req,$month_req,$day_req,$hour_req,$minute_req);
 
    //生肖
    $shengxiao = $data_bazi['shengXiao'];

    //节气
    $jieqi = $data_bazi['jieqi'];

    //五行占比
    $wuxing_percentage = $data_bazi['wxPercentage'];

    // 向添加數據來源接口发起curl请求
    curl_add_source($order_num,'namelist','wap',get_client_ip());

    // 上一页URL
    $previous_page = getenv('HTTP_REFERER');
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
    <link rel="stylesheet" href="/Public/css/style.css">
    <link rel="stylesheet" href="/Public/css/suan-index.css">
    <link rel="stylesheet" href="/Public/css/suan-result.css">
</head>

<body class="page-names-details mobile">
    <main class="site-main">
        <header class="site-header">
            <a href="<?php echo $previous_page;?>" class="btn-back">返回</a>
            <a href="../../history/index.php" class="my-order">我的订单</a>
            <span>周易算命</span>
        </header>
        <article class="site-content">
            <?php
                main_content_name_details_suan(array(
                    'gender'=> $data_gender,
                    'shengxiao'=> $shengxiao,
                    'birthtimeStr'=> $data_birthtimeStr,
                    'birthtimeNongliStr'=> $data_birthtimeNongliStr,
                    'lastname'=> $lastname,
                    'firstname'=> $firstname,
                    'jieqi' => $jieqi,
                    'wuxing_percentage' => $wuxing_percentage,
                    'bazi' => $data_bazi,
                    'fullname' => $fullname,
                ));
            ?>
        </article>
        <footer class="site-footer"></footer>
    </main>
    <script src="/Public/js/jquery.js"></script>
    <script src="/Public/js/cookie.js"></script>
    <script src="/Public/js/suan/main.js"></script>
    <script src="/Public/js/suan/pageNameDetails.js"></script>
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