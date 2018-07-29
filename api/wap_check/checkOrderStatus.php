<?php
//检查本地数据支付状态
include $_SERVER['DOCUMENT_ROOT'].'/api/model.class.php';

$ModelController = new ModelController();

$order_num = $_POST['order_num'];

$order_status = $ModelController->getOrderStatusByOrderNum($order_num);

/*if($order_status['order_status']==3){
	//检查有没有绑定过手机号
	//$mobile = $ModelController->checkBindMobile($order_num);

	//if($mobile!='12345678910'){
		//echo 1;return false;
	//}
	//检查该姓是不是存在的
	$order_info = $ModelController->getOrderStatusByOrderNum($order_num);
	$user_info_arr = json_decode($order_info['user_info'], true);
	$xing = urldecode($user_info_arr['xing']);
	$re = $ModelController->getBaijiaXing($xing);
	if($re['id'] == ''){
		echo "fail";
		return false;
	}

}*/


echo $order_status['order_status'];