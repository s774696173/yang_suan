<?php
//支付接口支付完成进行回调地址

include $_SERVER['DOCUMENT_ROOT'].'/api/model.class.php';

$ModelController = new ModelController();
//http://baby.com/pcqm/pay/notify.php?&response={"notify_type":"pay","out_trade_no":"63643503026214944847","transaction_id":"4200000012201710137799703808","software_price":"88","time":1507877440,"server_token":"53851fdc50"}
$json_data = $_GET['response'];

$arr_data = json_decode($json_data, true);

//获取传过来的order_num，进行查询，匹配价格
$order_info = $ModelController->getOrderStatusByOrderNum($arr_data['out_trade_no']);

//如果为pay则更新数据
if($arr_data['notify_type']=='pay'){
	//检查价格是否一致
	if($arr_data['software_price']!=$order_info['product_price']){

		echo 'price not match';return false;

	}
	
	//更新状态为已支付
	if($ModelController->update_order_paid($arr_data['out_trade_no'], $arr_data['transaction_id'])){
		echo 'success';
	}else{
		echo 'fail';
	}

	

}elseif($arr_data['notify_type']=='refund'){

//如果为refund 则退款 更改状态为5
	if($ModelController->update_order_refund($arr_data['out_trade_no'])){
		echo 'success';
	}else{
		echo 'fail';
	}
}