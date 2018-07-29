<?php
//获取新的订单号
include $_SERVER['DOCUMENT_ROOT'].'/api/model.class.php';
include $_SERVER['DOCUMENT_ROOT'].'/api/function.php';
include $_SERVER['DOCUMENT_ROOT'].'/api/quming/nongli.php';

$ModelController = new ModelController();

$order_date = date('YmdHis',time());

$order_rand = sprintf("%02d", rand(0,99));

$order_num = $order_date.$order_rand;
//得到订单号
for($i=0;$i<99;$i++){
	$order_info = $ModelController->getOrderStatusByOrderNum($order_num);
	if($order_info){
		$order_rand = sprintf("%02d", $order_rand+1+$i);
		$order_rand = $order_rand>99?$order_rand-90:$order_rand;
		$order_num = $order_date.$order_rand;
	}else{
		break;
	}
}

//把参数写入数据库
//客户端ip
$client_ip = get_client_ip();
$pay_type = 2;
$price = 29.8;

$pay_from = $_POST['pay_from'];
$product_id = $_POST['product_id'];
$product_kwd = $_POST['product_kwd'];
//来源关键字
$referer_kwd = urldecode($_COOKIE['referer']).'-'.$_COOKIE['source'];
//获取微信号
$weixin_code = get_weixin_code($_POST['weixin_code']);
$software_name = $product_kwd." 联系微信 ".$weixin_code;

$birthday = $_POST['o']["birthday"];
$birthtime = $_POST['o']["birthtime"];
$birthmin = $_POST['o']["birthmin"];

$birthtime_ = strtotime($birthday . " " . $birthtime . ":" . $birthmin);
$birthtimeStr = date("Y年m月d日H时i分", $birthtime_);
$shichenArray = ["子时","丑时","寅时","卯时","辰时","己时","午时","未时","申时","酉时","戊时","亥时"];
$hour = (int)$birthtime;
$hour = (int) ((($hour + 1) % 24 ) / 2);
$shichen =  $shichenArray[$hour];
$nongli = nongli($birthday);
$birthtimeNongliStr = $nongli . " " . $shichen;
$user_info = array();

$user_info['xing'] = urlencode($_POST['o']['xing']);
$user_info['gender'] = (int)$_POST['o']["gender"] == 0 ? urlencode("女") : urlencode("男");

$user_info['birthtimeStr'] = urlencode($birthtimeStr);
$user_info['birthtimeNongliStr'] = urlencode($birthtimeNongliStr);
$user_info['bornStatus'] = $_POST['o']['bornStatus'];
$user_info = json_encode($user_info);
//插入数据库
if(!$ModelController->insert_order($software_name,$product_id,'12345678910',$order_num,$price,'官方版',$pay_type,$pay_from,$client_ip,$referer_kwd,$user_info)){
  	echo 'fail';  return false;
}else{
	echo $order_num;
}