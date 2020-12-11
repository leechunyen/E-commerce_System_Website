<?php
require '../../php_framework/function.php';
if(!isset($_POST['oid'])||!isset($_POST['tc'])){
    echo 'Process stopped';
}else{
    $tc=$_POST['tc'];
    $oid=$_POST['oid'];
    $od=getData($conn,$maxCacheItem,'order','ID',$oid);
    $sql="insert into `delivery` (`DateTime`,`TrackingNumber`,`UserID`) values ('".getDateTime()."','$tc','".$od['UserID']."');";
    if(!mysqli_query($conn, $sql)){
        $mg='Fail to save tracking code';
        echo$mg;errorLog($mg.' '.mysqli_error($conn));
    }else{
        $dvid=mysqli_insert_id($conn);
        $sql="update `order` set `DeliveryID`=$dvid where `ID`='$oid';";
        if(!mysqli_query($conn, $sql)){
            $mg='Fail to update order';
            echo$mg;errorLog($mg.' '.mysqli_error($conn));
        }else{$cache->delete('db_recent_order');}
    }
    mysqli_close($conn);
}
?>