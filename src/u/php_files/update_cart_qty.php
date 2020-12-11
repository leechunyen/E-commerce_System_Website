<?php
if(!isset($_POST['pid'])||!isset($_POST['qty'])){echo 'Process stopped';}
else{
    require '../../php_framework/function.php';
    $uid=$_SESSION['uid'];
    $pid=$_POST['pid'];
    $qty=$_POST['qty'];
    $sql="update `user_cart_product` set `Quantity`=$qty where `UserID`=$uid and `ProductID`=$pid;";
    if(!mysqli_query($conn,$sql)){
        $mg='Fail to save quantity';
        echo$mg;
        errorLog($mg.' to cart '.mysqli_error($conn));
    }
    mysqli_close($conn);
}
?>