<?php

include 'dbconfig.php';

define("HOSTNAME",$config['host']);//改
define("USERNAME",$config['username']);//改
define("PASSWORD",$config['password']);//改
define("DATANAME",$config['dbname']);//改

class Model{

  private $link;
//初始化数据库连接
  public function __construct(){
    $this->link = mysqli_connect(HOSTNAME,USERNAME,PASSWORD,DATANAME) or die("数据库连接失败");
    mysqli_set_charset($this->link,"utf8");
  }
  //添加数据方法
  public function insert($sql){
    mysqli_query($this->link,$sql);
    return mysqli_insert_id($this->link);
  }
  //查找数据方法
  public function find($sql){
    $res = mysqli_query($this->link,$sql);
    $arr = mysqli_fetch_all($res,MYSQLI_ASSOC);
    mysqli_free_result($res);
    return $arr;
  }
  //查找数据方法
  public function findOne($sql){
    $res = mysqli_query($this->link,$sql);
    $arr = mysqli_fetch_all($res,MYSQLI_ASSOC);
    mysqli_free_result($res);
    return $arr[0];
  }
  //修改数据
  public function update($sql){
    $res = mysqli_query($this->link,$sql);
    return mysqli_affected_rows($this->link);
  }
  //删除数据
  public function delete($sql){
    $res = mysqli_query($this->link,$sql);
    return mysqli_affected_rows($this->link);
  }  
  public function __call($function_name, $args){
       echo "<br><font color=#ff0000>你所调用的方法 $function_name 不存在</font><br>\n";
  }
  public function __destruct(){
    mysqli_close($this->link);
  }
}

/*$dbo = new Model();
$sql = "select software_name,software_version,software_price from t_software";

$re = $dbo->find($sql);
$fields = 'create_time,license_num,func_name,software_website,image_name,software_name,software_version,software_price';
foreach($re as $v){
  $software_name = $v['software_name'];
  $software_version = $v['software_version'];
  $software_price = $v['software_price'];
  $sql = "select * from as_software_type where software_name='$software_name'";
  $re2 = $dbo->find($sql);
  if($re2){
    $software_website =$re2[0]['software_website'];
    $func_name =$re2[0]['func_name'];
    $image_name =$re2[0]['image_name'];
    $sql = "insert into as_software_type($fields) values(NOW(),3,'$func_name','$software_website','$image_name','$software_name','$software_version','$software_price')";
    $dbo->insert($sql);
  }else{
        $sql = "insert into as_software_type(create_time,license_num,software_name,software_version,software_price) values(NOW(),3,'$software_name','$software_version','$software_price')";
    $dbo->insert($sql);
  }
}*/   


