<?php

//检查本地数据支付状态
include $_SERVER['DOCUMENT_ROOT'].'/api/model.class.php';
include $_SERVER['DOCUMENT_ROOT'].'/api/function.php';
$ModelController = new ModelController();


if($_POST['order_num'] && strlen($_POST['order_num'])>1){
	$order_info = $ModelController->getOrderStatusByOrderNum($_POST['order_num']);
	$refere_str = $order_info['referer_kwd'];
	$refere_arr = explode('-', $refere_str);
	$referer = $refere_arr[0];
	$source = $refere_arr[1];
	$client_ip = $_POST['client_ip'];
}else{
	$referer = empty($_POST['referer'])?$_COOKIR['referer']:$_POST['referer'];
	$source = empty($_POST['source'])?$_COOKIR['source']:$_POST['source'];
	$client_ip = get_client_ip();
}
$page = $_POST['page'];
$deviceType['device'] = $_POST['deviceType'];
$deviceType['host'] = $_SERVER['HTTP_HOST'];
$deviceType = json_encode($deviceType);


$kwd = urldecode($referer);
$ModelController->addUserSource($kwd, $source, $page, $deviceType, $client_ip);