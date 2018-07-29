<?php

	header('content-type:text/html;charset=utf-8');

	include $_SERVER['DOCUMENT_ROOT'].'/api/db/dbo.php';

	$dbo = new Model();


	$sql = 'select * from t_order where mobile != "12345678910" order by pay_time desc limit 200';

	$re = $dbo->find($sql);

?>




<!DOCTYPE html>
<html>
<head>
	<title>后台首页</title>
	<meta charset="utf-8">
</head>
<body>
	<!-- CSS goes in the document HEAD or added to your external stylesheet -->
<style type="text/css">
table.gridtable {
	font-family: verdana,arial,sans-serif;
	font-size:11px;
	color:#333333;
	border-width: 1px;
	border-color: #666666;
	border-collapse: collapse;
}
table.gridtable th {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #666666;
	background-color: #dedede;
}
table.gridtable td {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #666666;
	background-color: #ffffff;
}
</style>

<!-- Table goes in the document BODY -->
<table class="gridtable">
	<tr>
		<th>序号</th><th>手机号</th><th>订单号</th><th>价格</th><th>支付方式</th><th>支付渠道</th><th>支付时间</th>
	</tr>
	<?php foreach($re as $k=>$v){?>
	<tr>
		<td><?php echo $k+1;?></td>
		<td><?php echo $v['mobile'];?></td>
		<td><?php echo $v['order_num'];?></td>
		<td><?php echo $v['product_price'];?></td>
		<td><?php if($v['pay_type']==1){echo '支付宝';}else{echo '微信';};?></td>
		<td><?php echo $v['pay_from'];?></td>
		<td><?php echo $v['pay_time'];?></td>
	</tr>
	<?php }?>
</table>
</body>
</html>