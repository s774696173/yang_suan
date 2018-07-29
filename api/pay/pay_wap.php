<?php

    header("Content-type:text/html;charset=utf-8");

    include $_SERVER['DOCUMENT_ROOT'].'/api/function.php';

    include $_SERVER['DOCUMENT_ROOT'].'/api/pay/pay_config.php';

    include $_SERVER['DOCUMENT_ROOT'].'/api/model.class.php';
    //价格
    $price = $_GET['software_price'];

    $price = $_GET['from']=='test'?0.01:29.8;
    //$price = 0.01;
    //支付方式
    $pay_type = $_GET['pay_type'];
    //$price = 0.01;
    $domain = $config['domain'];
    //软件名称
    $software_name = $_GET['software_name'];
    
    $out_trade_no = $_GET['order_num'];
    //客户端ip
    $client_ip = get_client_ip();
    $time = time();
    //token值
    $token = strtolower(substr(md5('pc'.$time),0,10));

    $ModelController = new ModelController();
    //前一页
    $previous_page = getenv('HTTP_REFERER');
    $previous_page_url = explode('?', $previous_page);
    $previous_page_domain = $previous_page_url[0];

    if($out_trade_no){
        $order_info = $ModelController->getOrderStatusByOrderNum($out_trade_no);
        $software_name = $order_info['product'];
        $product_id = $order_info['product_id'];
        //如果已经支付过了，则直接到取名列表
        if($order_info['order_status']==3){
            header('location:'.$previous_page_domain.'quming/quminglist.php?order_num='.$out_trade_no);  return false;
        }
        //切换了支付方式
        if($pay_type!=$order_info['pay_type']){
            $ModelController->select_order_by_order_num($order_num, $pay_type);
        }
    }else{ 
        echo "<script> alert('请回到首页填写信息！'); </script>";
        echo "<meta http-equiv='Refresh' content='0;URL=$previous_page_domain'>";return false;
    }
    //发起支付请求，获取支付url
    $re_json = curl_get_pay_wap_url($price, $previous_page, $software_name,$out_trade_no,$client_ip,$token,$time,$pay_type,$product_id);

    $url = json_decode($re_json, true)['responseData'];

    if($pay_type==1){
        header('location:'.$url);
    }elseif($pay_type==2){
        header('location:http://'.$_SERVER['HTTP_HOST'].'/wap/pay/weixinHref.php?tenpayurl='.urlencode($url).'&redirect_url='.urlencode($previous_page));
    }