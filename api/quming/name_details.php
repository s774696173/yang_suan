<?php
	include 'cls_bihua.class.php';
	include 'xingming.class.php';
	include $_SERVER['DOCUMENT_ROOT'].'/api/model.class.php';
	$ModelController = new ModelController();
	$model = new mod_xingming();
	$order_num = $_REQUEST['order_num'];

//判断是够支付过
	$order_info = $ModelController->getOrderStatusByOrderNum($order_num);
	if($order_info['order_status']!=3){
		//echo "<script> alert('该订单还未支付！') </script>";
		echo "paynull";
		return false;
	}

	$name = $_REQUEST['name'];
	$xing = substr($name,0,3);
	$ming = substr($name,3,9);

	$xing1 = substr($xing,0,3);	
	$ming1 = substr($ming,0,3);
	//五行
	$wh_bh_arr = $ModelController->getBihua($xing1);

	$bihua1 = $wh_bh_arr['bihua'];
	$hzwh1 = $wh_bh_arr['hzwh'];
	$tiange = $bihua1 + 1;
	$tiangee = $bihua1 + 1;
	$renge1 = $bihua1;

	$xing2 = substr($xing,3,3);
	if($xing2!=''){
		$wh_bh_arr2 = $ModelController->getBihua($xing2);
		$bihua2 = $wh_bh_arr2['bihua'];
		$hzwh2 = $wh_bh_arr2['hzwh'];
		$xing22 = $xing2;
		$tiange = $bihua1+$bihua2;
		$tiangee = $bihua1+$bihua2;
		$renge1 = $bihua2; 
		
		$xing2py = $model->Pinyin_sm($xing2,1);
		$xing2gb = $model->gb_big5($xing2);
	}


	$ming_wh_bh_arr = $ModelController->getBihua($ming1);
	$bihua3 = $ming_wh_bh_arr['bihua'];
	$hzwh3 = $ming_wh_bh_arr['hzwh'];
	$dige = $bihua3 + 1;
	$digee = $bihua3 + 1;
	$renge2 = $bihua3;

	$ming2 = substr($ming,3,3);

	if($ming2!=''){
		$ming_wh_bh_arr2 = $ModelController->getBihua($ming2);
		$bihua4 = $ming_wh_bh_arr2['bihua'];
		$hzwh4 = $ming_wh_bh_arr2['hzwh'];
		
		$dige = $bihua3 + $bihua4;
		$digee = $bihua3 + $bihua4;
		
		$ming2py = $model->Pinyin_sm($ming2,1);
		$ming2gb = $model->gb_big5($ming2);
	}

	//gb_big5
	$xm_arr = array('xing1'=>$xing1,'xing1py'=>$model->Pinyin_sm($xing1,1),'xing1gb'=>$model->gb_big5($xing1),'xing2'=>$xing2,'xing2py'=>$xing2py,'xing2gb'=>$xing2gb,'ming1'=>$ming1,'ming1py'=>$model->Pinyin_sm($ming1,1),'ming1gb'=>$model->gb_big5($ming1),'ming2'=>$ming2,'ming2py'=>$ming2py,'ming2gb'=>$ming2gb);

	$bh_wh_arr = array('bihua1'=>$bihua1,'bihua2'=>$bihua2,'bihua3'=>$bihua3,'bihua4'=>$bihua4,'hzwh1'=>$hzwh1,'hzwh2'=>$hzwh2,'hzwh3'=>$hzwh3,'hzwh4'=>$hzwh4);

	$zhongge = $bihua1 + $bihua2 + $bihua3 + $bihua4;
	$zhonggee = $bihua1 + $bihua2 + $bihua3 + $bihua4;

	//计算三才
	$renge = $renge1 + $renge2;
	$rengee = $renge1 + $renge2;
	$waige = $zhongge - $renge;
	$waigee = $zhonggee - $rengee;
	if($xing2==''){
		$waige = $waige + 1;
		$waigee = $waigee + 1;
	}
	if($ming2==''){
		$waige = $waige + 1;
		$waigee = $waigee + 1;
	}

			
	//天格
	$tiangearr = $ModelController->getGe($tiangee);
	$tiangearr['tiangee'] = $tiangee;

	//人格
	$rengearr = $ModelController->getGe($rengee);
	$rengearr['rengee'] = $rengee;
	
	//地格
	$digearr = $ModelController->getGe($digee);
	$digearr['digee'] = $digee;
	
	//外格
	$waigearr = $ModelController->getGe($waigee);
	$waigearr['waigee'] = $waigee;
	
	//总格
	$zonggearr = $ModelController->getGe($zhongge);
	$zonggearr['waigee'] = $zhongge;

	//天地人三才
	$tian_sancai = $model->getsancai($tiange);
	$ren_sancai = $model->getsancai($renge);
	$di_sancai = $model->getsancai($dige);

	//三才吉凶
	$sancai = $tian_sancai.$ren_sancai.$di_sancai;
	$rssancai = $ModelController->getSancai($sancai);
	$rssancai['sancai'] = $sancai;
		
	$tdr_ge = array('renge'=>$renge,'tiange'=>$tiange,'dige'=>$dige,'tian_sancai'=>$tian_sancai,'ren_sancai'=>$ren_sancai,'di_sancai'=>$di_sancai,'waige'=>$waige,'waige_sancai'=>$model->getsancai($waige),'zhongge'=>$zhongge,'zongge_sancai'=>$model->getsancai($zhongge));
	//姓名得分
	$xmdf = $model->getpf($tiangearr['jx'])/10+$model->getpf($rengearr['jx'])+$model->getpf($digearr['jx'])+$model->getpf($zonggearr['jx'])+$model->getpf($waigearr['jx'])/10+$model->getpf($rssancai['jx'])/4+$model->getpf($rssancai['jx1'])/4+$model->getpf($rssancai['jx2'])/4+$model->getpf($rssancai['jx3'])/4;
	
	if($zhonggee>60){
		  $xmdf = $xmdf - 4;
	}
	$xmdf = 58 + $xmdf;
	//最终得分大于100 统一为100
	if($xmdf > 100){
		$xmdf = 100;
	}

	$data = array();

	$data['xm_arr'] = $xm_arr;
	$data['bh_wh_arr'] = $bh_wh_arr;
	$data['tiangearr'] = $tiangearr;
	$data['rengearr'] = $rengearr;
	$data['digearr'] = $digearr;
	$data['waigearr'] = $waigearr;
	$data['zonggearr'] = $zonggearr;
	$data['rssancai'] = $rssancai;
	$data['tdr_ge'] = $tdr_ge;
	$data['xmdf'] = $xmdf;
	$data['name'] = $name;

	if($xmdf<60){
		$pinyu = '<p>你的名字可能不是很好。强烈建议你换个名字试试，也许人生会因此而改变的。</p>
	<p>如果有条件，改个名字也未尝不可。</p>';
	}elseif($xmdf>=60 && $xmdf<70){
		$pinyu = '<p>你的名字可能不太好，如果可能的话，不妨尝试改变一下，也许会有事半功倍之效。</p>
	<p>如果有条件，改个名字也未尝不可。</p>';
	}elseif($xmdf>=70 && $xmdf<80){
		$pinyu = '<p>你的名字可能不太理想，要想赢得成功，必须比别人付出更多的艰辛和汗水。如果有条件，改个名字也未尝不可。</p>
	<p>如果有条件，改个名字也未尝不可。</p>';
	}elseif($xmdf>=80 && $xmdf<90){
		$pinyu = '<p>你的名字取得不错，如果与命理搭配得当，相信它会助你一生顺利的，祝你好运！</p>';
	}elseif($xmdf>=90){
		$pinyu = '<p>你的名字取得非常棒，如果与命理搭配得当，成功与惊喜将会伴随你的一生。但千万注意不要失去上进心。</p>';
	}

	$data['pinyu'] = $pinyu;

	echo json_encode($data);