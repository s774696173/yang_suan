<?php

//向服务器发起curl请求
function curl_post($url, $postArr){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST' );
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postArr );
    curl_setopt($ch, CURLOPT_URL, $url);
    $result = curl_exec($ch);
    curl_close ($ch);
    return $result;
}

//向PC支付接口发起curl请求
function curl_get_pay_pc_url($order_num='', $software_price='', $url='', $software_name='',$product_id=102){
    $time = time();
    $postArr = array(
        'software_name' => $software_name,//软件名称
        'software_price' => $software_price,//软件价格
        'software_version' => '官方版',//软件版本
        'mobile' => '12345678910',//联系方式
        'out_trade_no' => $order_num,//订单号
        'product_id' => $product_id,//应用ID 自定义
        'client_ip' => get_client_ip(),//客户真实ip
        'expire_time' => 1,//会员到期时间
        'time' => $time,//当前UNIX时间戳
        'token' => strtolower(substr(md5('pc'.$time),0,10)),//token值
        'notify_url' => 'http://qumingweb.huduntech.com/api/wap_check/notify.php?',//支付完成异步url
        'return_url' => '',//支付包收银台支付时候需填
        'reserve' => '',//预留字段          
    );

    return curl_post($url, $postArr);
}

//向WAP支付宝接口发起curl请求
function curl_get_pay_wap_url($price='', $previous_page='', $software_name, $out_trade_no='' ,$client_ip='' ,$token='', $time='', $pay_type=0,$product_id=103){
    
    //$url = 'http://iosdatarecovery.api.huduntech.com/ver2/wap/paywithAlipay';//
    if($pay_type==1){
        $url = 'http://iosdatarecovery.api.huduntech.com/ver2/wap/paywithAlipay';
    }elseif($pay_type==2){
        $url = 'http://iosdatarecovery.api.huduntech.com/ver2/wap/paywithWeixin';
    }
    
    $notify_url = 'http://qumingweb.huduntech.com/api/wap_check/notify.php?';
    $postArr = array(
        'software_name' => $software_name,//软件名称
        'software_price' => $price,//软件价格
        'software_version' => '官方版',//软件版本
        'mobile' => '12345678910',//联系方式
        'out_trade_no' => $out_trade_no,
        'product_id' => $product_id,//应用ID 自定义
        'client_ip' => $client_ip,//客户真实ip
        'expire_time' => 1,//会员到期时间
        'time' => $time,//当前UNIX时间戳
        'token' => $token,//token值
        'notify_url' => $notify_url,//支付完成异步url
        'return_url' => $previous_page,//支付完成之后的跳转页面
        'reserve' => '',//预留字段      
    );

    return curl_post($url, $postArr);
}

/**
 * 获取客户端IP地址
 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
 * @return mixed
 */
function get_client_ip($type = 0) {
      $type =  $type ? 1 : 0;
      $ip  =   NULL;
      if ($ip !== NULL) return $ip[$type];
      if (isset($_SERVER['HTTP_CLIENTIP'])) {
            $ip     =   $_SERVER['HTTP_CLIENTIP'];
      }elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos    =   array_search('unknown',$arr);
            if(false !== $pos) unset($arr[$pos]);
            $ip     =   trim($arr[0]);
      }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
          $ip     =   $_SERVER['HTTP_CLIENT_IP'];
      }elseif (isset($_SERVER['REMOTE_ADDR'])) {
          $ip     =   $_SERVER['REMOTE_ADDR'];
      }
    // IP地址合法验证
    $long = sprintf("%u",ip2long($ip));
    $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];
}

//判断是否有微信号，没有则php生成一个
function get_weixin_code($code=''){
    $weixin_code_str = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/api/weixin_code.json');
    $weixin_code_arr = json_decode($weixin_code_str);
    if(in_array($code,$weixin_code_arr)){
      $weixin_code = $code;
    }else{
      $weixin_code = $weixin_code_arr[rand(0,count($weixin_code_arr)-1)];
    }
    return $weixin_code;
}

//向添加數據來源接口发起curl请求
function curl_add_source($order_num='',$page='index',$deviceType='wap',$client_ip=''){
    $url = 'http://'.$_SERVER['HTTP_HOST'].'/api/wap_check/addSource.php';
    $postArr = array(
        'order_num' => $order_num,//
        'page' => $page,//
        'deviceType' => $deviceType,//
        'client_ip' => $client_ip,
    );
    return curl_post($url, $postArr);
}
/**
 * 将字符串参数变为数组
 */
function convertUrlQuery($query){
    $queryParts = explode('&', $query);
    $params = array();
    foreach ($queryParts as $param) {
        $item = explode('=', $param);
        $params[$item[0]] = $item[1];
    }
    return $params;
}

//参数1：访问的URL，参数2：post数据(不填则为GET)，参数3：提交的$cookies,参数4：是否返回$cookies
 function curl_request($url,$post='',$cookie='', $returnCookie=0){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)');
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        curl_setopt($curl, CURLOPT_REFERER, "http://XXX");
        if($post) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));
        }
        if($cookie) {
            curl_setopt($curl, CURLOPT_COOKIE, $cookie);
        }
        curl_setopt($curl, CURLOPT_HEADER, $returnCookie);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        if (curl_errno($curl)) {
            return curl_error($curl);
        }
        curl_close($curl);
        if($returnCookie){
            list($header, $body) = explode("\r\n\r\n", $data, 2);
            preg_match_all("/Set\-Cookie:([^;]*);/", $header, $matches);
            $info['cookie']  = substr($matches[1][0], 1);
            $info['content'] = $body;
            return $info;
        }else{
            return $data;
        }
}

function curl_get_https($url){
    $curl = curl_init(); // 启动一个CURL会话
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);  // 从证书中检查SSL加密算法是否存在
    $tmpInfo = curl_exec($curl);     //返回api的json对象
    //关闭URL请求
    curl_close($curl);
    return $tmpInfo;    //返回json对象
}

/* PHP CURL HTTPS POST */
function curl_post_https($url,$data){ // 模拟提交数据函数
    $curl = curl_init(); // 启动一个CURL会话
    curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在
    curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
    curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
    curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
    curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
    $tmpInfo = curl_exec($curl); // 执行操作
    if (curl_errno($curl)) {
        echo 'Errno'.curl_error($curl);//捕抓异常
    }
    curl_close($curl); // 关闭CURL会话
    return $tmpInfo; // 返回数据，json格式
}


function get_name_list_paid($lastname='',$single=false,$gender=1,$num=99){
    $name_list_req = curl_get_https('https://api.99quming.com/v1/names.php?lastname='.$lastname.'&is_single='.$single.'&gender='.$gender.'&num='.$num);
    $name_list= json_decode($name_list_req,true);
    return $name_list['data'];
}

function get_bazi_paid($year='',$month='',$day='',$hour='',$minute=''){
    $url = 'https://api.99quming.com/v1/suanbz.php?year='.$year.'&month='.$month.'&day='.$day.'&hour='.$hour.'&minute='.$minute;
    $data_bazi_req = curl_get_https('https://api.99quming.com/v1/suanbz.php?year='.$year.'&month='.$month.'&day='.$day.'&hour='.$hour.'&minute='.$minute);
    $data_bazi= json_decode($data_bazi_req,true);
    return $data_bazi['data'];
}

function get_sancai_paid($firstname='',$lastname=''){
    $data_sancai_req = curl_get_https('https://api.99quming.com/v1/sancai.php?firstname='.$firstname.'&lastname='.$lastname);
    $data_sancai= json_decode($data_sancai_req,true);
    return $data_sancai['data'];
}

function get_shengxiao_num($shengxiao =''){
    $id = 1;
    switch($shengxiao){
        case '鼠':
            $id = 1;
            break;
        case '牛':
            $id = 2;
            break;
        case '虎':
            $id = 3;
            break;
        case '兔':
            $id = 4;
            break;
        case '龙':
            $id = 5;
            break;
        case '蛇':
            $id = 6;
            break;
        case '马':
            $id = 7;
            break;
        case '羊':
            $id = 8;
            break;
        case '猴':
            $id = 9;
            break;
        case '鸡':
            $id = 10;
            break;
        case '狗':
            $id = 11;
            break;
        case '猪':
            $id = 12;
            break;
    }
    return $id ;
}

function get_jieqi_num($jieqi =''){
    $id = 1;
    switch($jieqi){
        case '立春':
            $id = 1;
            break;
        case '雨水':
            $id = 2;
            break;
        case '惊蛰':
            $id = 3;
            break;
        case '春分':
            $id = 4;
            break;
        case '清明':
            $id = 5;
            break;
        case '谷雨':
            $id = 6;
            break;
        case '立夏':
            $id = 7;
            break;
        case '小满':
            $id = 8;
            break;
        case '芒种':
            $id = 9;
            break;
        case '夏至':
            $id = 10;
            break;
        case '小暑':
            $id = 11;
            break;
        case '大暑':
            $id = 12;
            break;
        case '立秋':
            $id = 13;
            break;
        case '处暑':
            $id = 14;
            break;
        case '白露':
            $id = 15;
            break;
        case '秋分':
            $id = 16;
            break;
        case '寒露':
            $id = 17;
            break;
        case '霜降':
            $id = 18;
            break;
        case '立冬':
            $id = 19;
            break;
        case '小雪':
            $id = 20;
            break;
        case '大雪':
            $id = 21;
            break;
        case '冬至':
            $id = 22;
            break;
        case '小寒':
            $id = 23;
            break;
        case '大寒':
            $id = 24;
            break;
    }
    return $id ;
}
function mb_str_split($str){  
    return preg_split('/(?<!^)(?!$)/u', $str );  
}  


//向获取姓名列表接口发起curl请求
function get_sancai_peizhi_paid($order_num='', $name=''){
    $url = 'http://'.$_SERVER['HTTP_HOST'].'/api/quming/name_details.php';
    $postArr = array(
        'order_num' => $order_num,//软件名称
        'name' => $name,//软件名称
    );

    return curl_post($url, $postArr);
}

function str_format_time($timestamp = ''){  
    if (preg_match("/[0-9]{4}-[0-9]{1,2}-[0-9]{1,2} (0[0-9]|1[0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])/i", $timestamp)){
        list($date,$time)=explode(" ",$timestamp);
        list($year,$month,$day)=explode("-",$date);
        list($hour,$minute,$seconds )=explode(":",$time);
        $timestamp=gmmktime($hour,$minute,$seconds,$month,$day,$year);
    }
    else{
        $timestamp=time();
    }
    return $timestamp;
}

function get_wuxing_sum($data_wuxing){
    $data_wuxing_sum= 0;
    foreach($data_wuxing as $wx_key =>$wx_val ){
        $data_wuxing_sum+=$wx_val;
    }
    return $data_wuxing_sum;
}