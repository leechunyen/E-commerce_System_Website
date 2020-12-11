<?php
require '../../php_framework/function.php';
if(!isset($_POST['id'])||!checkAdminLogin(false,false)){
    echo 'Process stopped';
}else{
    $id=$_POST['id'];
    $sql="update `purchase_history` set `Status`='c' where `ID`='$id';";
    if(!mysqli_query($conn,$sql)){
        $mg="Fail to cancel purchase";echo$mg;
        errorLog($mg.' '.mysqli_error($conn));
    }else{$cache->delete('db_recent_purchase_history');}
    mysqli_close($conn);
}
?>