<?php
require '../../php_framework/function.php';
if(!isset($_POST['pid'])||!isset($_SESSION['uid'])){echo 'Process stopped '.$_SESSION['uid'];}
else{
    $uid=$_SESSION['uid'];
    $pid=$_POST['pid'];
    $sql="delete from `user_cart_product` where `UserID`=$uid and `ProductID`=$pid;";
    if(!mysqli_query($conn,$sql)){
        $mg='Fail to remove from cart';errorLog($mg.':'.mysqli_error($conn));echo$mg;
    }
    mysqli_close($conn);
}
?>