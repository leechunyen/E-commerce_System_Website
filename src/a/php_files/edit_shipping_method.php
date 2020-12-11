<?php
require '../../php_framework/function.php';
if(!isset($_POST['id'])||!isset($_POST['title'])||!isset($_POST['price'])||!isset($_POST['dd'])){
    echo 'Process stopped';
}else{
    $id=$_POST['id'];
    $title=$_POST['title'];
    $price=$_POST['price'];
    $dd=$_POST['dd'];
    $arr= array();
    if(ifExist($conn,$maxCacheItem,'shipping_method','Title',$title,$id)){
        $arr['ti']=true;
    }else{
        $sql="update `shipping_method` set `Title`='$title',`Price`='$price',`DeliveryDays`='$dd' where `ID`=$id;";
        if(!mysqli_query($conn,$sql)){
            $mg='Fail to update shipping method title='.$title;
            errorLog($mg.' '.mysqli_error($conn));
            $arr['er']=$mg;
        }else{$cache->delete('db_recent_shipping_method');}
        mysqli_close($conn);
    }
    $json=json_encode($arr);
    if($json){echo $json;}
    else{errorLog('Fail to encode json '.json_last_error_msg());}
}
?>