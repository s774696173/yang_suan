<?php

	include 'cls_bihua.class.php';
	include 'xingming.class.php';
	include $_SERVER['DOCUMENT_ROOT'].'/api/model.class.php';

	try {   
		$ModelController = new ModelController();  
	} catch (Exception $e) {   
		print $e->getMessage();
		exit();   
	}

	$order_num = $_REQUEST['order_num'];

//判断是够支付过
	$order_info = $ModelController->getOrderStatusByOrderNum($order_num);
	if($order_info['order_status']!=3){
		echo 'paynull';//该订单还未支付！
		return false;
	}

	$user_info_arr = json_decode($order_info['user_info'], true);



	$model = new mod_xingming();

	if($user_info_arr['xing2']){
		$xing = urldecode($user_info_arr['xing2']);
	}else{
		$xing = urldecode($user_info_arr['xing']);
	}

	$sex = urldecode($user_info_arr['gender'])=='男'?0:1;

	$geshu = empty($_REQUEST['geshu'])?'':$_REQUEST['geshu'];
	
	$re = $ModelController->getBaijiaXing($xing);
	//拿到baijia_xing表对应的id
	if($re['id']!=''){
		
		$xid = $re['id'];
	}

	//没有对应的id，则返回错误
	if($xid == ''){
		//echo "<script>alert('姓氏不在列表中');history.go(-1);</script>";
		echo "fail";
		return false;
	} 

	$where = '`xid`="'.$xid.'"';

	if($geshu){
		$where .= ' and geshu='.$geshu;
	}

	//if($sex){
	$where .= ' and sex='.$sex;
	//}

	//拿到baijia_ming表对应的姓名
	$data = $ModelController->getNameList($where);

	echo json_encode($data);