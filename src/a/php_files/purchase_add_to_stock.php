<?php
require '../../php_framework/function.php';
if(!isset($_POST['id'])||!checkAdminLogin(false,false)){
    echo 'Process stopped';
}else{
    $id=$_POST['id'];
    $po=getData($conn,$maxCacheItem,'purchase_history','ID',$id);
    $sql="update `purchase_history` set `Status`='f' where `ID`=".$id.";";
    if(!mysqli_query($conn,$sql)){
        $mg="Fail to change status";echo$mg;
        errorLog($mg.' '.mysqli_error($conn));
    }else{
        $cache->delete('db_recent_purchase_history');
        $sql="update `product` set `Stock`=`Stock`+".$po['Quantity']." where `ID`=".$po['ProductID'].";";
        if(!mysqli_query($conn,$sql)){
            $mg="Fail to add stock";echo$mg;
            errorLog($mg.' '.mysqli_error($conn));
        }else{$cache->delete('db_recent_product');}
    }
    mysqli_close($conn);
}
?>