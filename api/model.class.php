<?php

//数据库model操作
class ModelController{

	private $dbo;

	function __construct(){

        include $_SERVER['DOCUMENT_ROOT'].'/api/db/dbo.php';

		$this->dbo = new Model();

	}
	//根据订单号查询订单相关信息
	public function  getOrderStatusByOrderNum($order_num='',$product_id=''){
        //如果传递产品参数值，则判断属于哪个id下的产品，避免算命的订单和起名的订单 cookie混在一起
        if($product_id){
            if($product_id=='起名'){
                $where = " where order_num='$order_num' and (product_id=102 or product_id=103) ";
            }elseif($product_id=='算命'){
                $where = " where order_num='$order_num' and (product_id=106 or product_id=107) ";
            }
        }else{
            $where = " where order_num='$order_num' ";
        }

		$sql = "select * from t_order $where limit 1";

		$re = $this->dbo->findOne($sql);

		return $re;

	}

//将支付数据插入数据库
    public function insert_order($product='',$product_id='',$mobile='',$order_num='',$product_price='',$product_version='',$pay_type='',$pay_from='',$create_ip='',$referer_kwd='kwd', $user_info=''){

        $fields = "id,product,product_id,mobile,order_num,product_price,product_version,pay_type,pay_from,order_status,create_ip,create_time,referer_kwd,user_info";

        $sql = "insert into t_order($fields) values(NULL,'$product',$product_id,'$mobile','$order_num',$product_price,'$product_version',$pay_type,'$pay_from',1,'$create_ip',NOW(),'$referer_kwd','$user_info')";

        if($this->dbo->insert($sql)){
            return true;
        }else{
            return false;
        }

    }

//更新订单状态--支付
    public function update_order_paid($order_num='',$transaction_id=''){

        $sql = "update t_order set order_status=3,pay_time=NOW(),transaction_id='$transaction_id' where order_num='$order_num'";

        if($this->dbo->update($sql)){
            return true;
        }else{
            return false;
        }

    }
//更新订单状态--退款
    public function update_order_refund($order_num=''){

        $sql = "update t_order set order_status=5 where order_num='$order_num'";

        if($this->dbo->update($sql)){
            return true;
        }else{
            return false;
        }

    }

//是否存在订单号 
    public function select_order_by_order_num($order_num='',$type=0){

    	$re = $this->getOrderStatusByOrderNum($order_num);

    	if($re){

    		$sql = "update t_order set pay_type=$type where order_num='$order_num'";

    		$this->dbo->update($sql);

            return true;
    	}else{

    		return false;
    	}

    }

//修改预留的手机号
    public function update_order_mobile($mobile='', $order_num=''){

        //检查是否绑定手机号
        $re = $this->getOrderStatusByOrderNum($order_num);

        if($re['mobile']=='12345678910'){

            $sql = "update t_order set mobile='$mobile' where order_num='$order_num'";

            if($this->dbo->update($sql)){

                return true;

            }else{

                return false;
                
            }

        }else{

            return true;

        }

    }

//检查有没有绑定过手机号
    public function checkBindMobile($order_num=''){

        $sql = "select mobile from t_order where order_num='$order_num' limit 1";

        $re = $this->dbo->findOne($sql);
        
        return $re['mobile'];
        
    }

//根据姓查找t_baijia_xing相关记录
    public function getBaijiaXing($xing){

        $sql = 'select * from `t_baijia_xing` where `xing`="'.$xing.'"';

        $re = $this->dbo->findOne($sql);

        return $re;
    }    

//获取姓名列表
    public function getNameList($where){

        $sql = "select * from `t_baijia_ming` where $where and geshu=2 limit 50";

        $list_2 = $this->dbo->find($sql);
        $sql = "select * from `t_baijia_ming` where $where and geshu=3 limit 50";
        $list_3 = $this->dbo->find($sql);

        $list = array_merge($list_3,$list_2);
        return $list;
    } 

//获取天地人外总格
    public function getGe($ge){
        $sql = "select * from `t_sm_81` where num='".$ge."' limit 1";
        $tiangearr = $this->dbo->findOne($sql);
        return $tiangearr;
    }  

//获取三才
    public function getSancai($sancai){
        $sqlsancai = "select * from `t_sm_sancai` where `title`='".$sancai."'";
        $rssancai = $this->dbo->findOne($sqlsancai);
        return $rssancai;
    }

//获取笔画、五行
    function getBihua($str){

        $sql = "select num from `t_sm_bihua` where hanzi like '%$str%'";

        $bihua1 = $this->dbo->findOne($sql);
        
        if($bihua1['num']!=''){

                $bihua1 = $bihua1['num'];

            }else{

                $bihuatext = new cls_bihua();

                $bihua1 = $bihuatext->find($str);

        }   
        
        $sql = 'select `wh` from `t_sm_hzwh` where hz like "%'.$str.'%"';

        $hzwh1 = $this->dbo->findOne($sql);

        if($hzwh1['wh']!=''){

            $hzwh1 = $hzwh1['wh'];

        }else{

            $hzwh1 = '金';

        }

        $arr['bihua'] = $bihua1;

        $arr['hzwh'] = $hzwh1;

        return $arr;
        
    }

//用戶來源記錄
        function addUserSource($referer='', $source='', $page='index', $deviceType='wap', $client_ip=''){
            $time = date('Y-m-d H:i:s', time());
            $sql = "insert into t_source(kwd,source,page,device,client_ip,create_time) values('$referer','$source','$page','$deviceType','$client_ip','$time')";
            $this->dbo->insert($sql);
        }


}