<?php
require '../../php_framework/function.php';
if(!isset($_POST['id'])){
    echo 'Process stopped';
}else{
    $id=$_POST['id'];
    $sql="delete from `coupon_type` where `ID`=$id;";
    if(!mysqli_query($conn,$sql)){
        $mg="Fail to delete coupon type id=$id";
        errorLog($mg.' '.mysqli_error($conn));
    }else{$cache->delete('db_recent_coupon_type');}
    mysqli_close($conn);
}
?>