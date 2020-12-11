<?php
if(!isset($_POST['id'])||!isset($_POST['m'])){echo 'Process stopped';}
else{
    require '../../php_framework/function.php';
    if(!isset($_SESSION['uid'])){echo 1;}
    else{
        $pid=$_POST['id'];
        $uid=$_SESSION['uid'];
        $m=$_POST['m'];
        if($m=='a'){
            $sql="insert into `user_wishlist_product` (`UserID`,`ProductID`,`DateTime`) values ('$uid','$pid','".getDateTime()."');";
            if(!mysqli_query($conn,$sql)){$mg='Fail to add to wishlist.';errorLog($mg.':'.mysqli_error($conn));echo$mg;}
        }elseif($m=='r'){
            $sql="delete from `user_wishlist_product` where `UserID`=$uid and `ProductID`=$pid;";
            if(!mysqli_query($conn,$sql)){
                $mg='Fail to remove from wishlist.';errorLog($mg.':'.mysqli_error($conn));echo$mg;}
        }
        mysqli_close($conn);
    }
}
?>