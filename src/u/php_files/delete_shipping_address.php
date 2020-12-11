<?php
require '../../php_framework/function.php';
if(!isset($_POST['id'])||!isset($_SESSION['uid'])){echo'Prosess stopped.';}
else{
    $id=$_POST['id'];
    $uid=$_SESSION['uid'];
    $sql="delete from `shipping_info` where ID=$id and `UserID`=$uid";
    if(!mysqli_query($conn,$sql)){$mg='Fail to delete shipping address.';errorLog($mg.':'.mysqli_error($conn));echo$mg;}
}
?>