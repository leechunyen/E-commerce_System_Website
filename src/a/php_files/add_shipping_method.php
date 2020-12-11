<?php
require '../../php_framework/function.php';
if(!isset($_POST['title'])||!isset($_POST['price'])||!isset($_POST['dd'])){
    echo 'Process stopped';
}else{
    $title=$_POST['title'];
    $price=$_POST['price'];
    $dd=$_POST['dd'];
    $arr= array();
    if(!ifExist($conn,$maxCacheItem,'shipping_method','Title',$title)){
        $sql="insert into `shipping_method` (`Title`,`Price`,`DeliveryDays`) values ('$title',$price,'$dd');";
        if(!mysqli_query($conn,$sql)){
            $mg='Fail to add shipping method';
            errorLog($mg.' '.mysqli_error($conn));
            $arr['er']=$mg;
        }
        mysqli_close($conn);
    }else{
        $arr['ti']=true;
    }
    $json=json_encode($arr);
    if($json){echo $json;}
    else{errorLog('Fail to encode json '.json_last_error_msg());}
}
?>