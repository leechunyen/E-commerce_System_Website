<?php
require '../../php_framework/function.php';
if(!isset($_POST['id'])){
    echo 'Process stopped';
}else{
    $id=$_POST['id'];
    $sql="delete from `manage_supplier` where `ID`=$id;";
    if(!mysqli_query($conn,$sql)){
        $mg="Fail to delete manage supplier id=$id";
        errorLog($mg.' '.mysqli_error($conn));
    }else{$cache->delete('db_recent_manage_supplier');}
    mysqli_close($conn);
}
?>