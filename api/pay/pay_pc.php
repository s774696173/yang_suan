<?php
	header("Content-type:text/html;charset=utf-8");

	include $_SERVER['DOCUMENT_ROOT'].'/api/function.php';

	include $_SERVER['DOCUMENT_ROOT'].'/api/pay/pay_config.php';

	include $_SERVER['DOCUMENT_ROOT'].'/api/model.class.php';

    $domain = $config['domain'];
    //价格
    $software_price = 29.8;
    //软件名称
    $software_name = $_POST['software_name'];
    //支付方式
    $payType = $_POST['payType'];
    //订单号
    $order_num = $_POST['order_num'];
    //支付渠道
    $pay_from = 'pc';
    //判断支付url
    if($payType=='ali'){
        $url = $domain.'ver2/pc/aliqrpay';
        $pay_type = 1;
    }elseif($payType=='wx'){
        $url = $domain.'ver2/pc/weixinqrpay';
        $pay_type = 2;
    }else{
        echo 'error';return false;
    }
    //插入数据库
    $ModelController = new ModelController();

    //查找订单状态
    $order_info = $ModelController->getOrderStatusByOrderNum($order_num);
    $product_id = $order_info['product_id'];
    if($order_info['order_status']==3){
        echo 'paid';
        return false;
    }
    //切换了支付方式
    if($pay_type!=$order_info['pay_type']){
        $ModelController->select_order_by_order_num($order_num, $pay_type);
    }
    //发起支付请求
    $re =  curl_get_pay_pc_url($order_num, $software_price, $url, $software_name,$product_id);

    $url = json_decode($re, true)['responseData'];

    echo $url;