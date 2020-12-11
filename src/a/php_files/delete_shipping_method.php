<?php
if(!isset($_POST['id'])){
    echo 'Process stopped';
}else{
    require '../../php_framework/function.php';
    $id=$_POST['id'];
    $sql="delete from `shipping_method` where `ID`=$id;";
    if(!mysqli_query($conn,$sql)){
        $mg="Fail to delete shipping method id=$id";
        errorLog($mg.' '.mysqli_error($conn));
    }else{$cache->delete('db_recent_shipping_method');}
    mysqli_close($conn);
}
?>