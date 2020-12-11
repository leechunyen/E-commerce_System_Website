<?php
if(!isset($_POST['pid'])||!isset($_POST['qty'])||!isset($_POST['pri'])||!isset($_POST['sup'])){echo 'Process stopped';}
else{
    require '../../php_framework/function.php';
    $pid=$_POST['pid'];
    $qty=$_POST['qty'];
    $pri=$_POST['pri'];
    $sui=$_POST['sup'];
    $pro=getData($conn,$maxCacheItem,'product','ID',$pid);
    $sup=getData($conn,$maxCacheItem,'manage_supplier','ID',$sui);
    $sql="insert into `purchase_history` (`Quantity`,`Price`,`Status`,`ProductPhoto`,`ProductName`,`ProductModelID`,`SupplierID`,`SupplierName`,`SupplierAddress`,`SupplierEmail`,`SupplierPhone`,`ProductID`) values ($qty,$pri,'w','".$pro['DefaultPhoto']."','".$pro['Name']."','".$pro['ModelID']."','".$sup['ID']."','".$sup['Name']."','".$sup['Address']."','".$sup['Email']."','".$sup['Phone']."',$pid)";
    if(!mysqli_query($conn,$sql)){
        $mg='Fail to make purchase';
        echo$mg;
        errorLog($mg.' '.mysqli_error($conn));
    }
    mysqli_close($conn);
}
?>