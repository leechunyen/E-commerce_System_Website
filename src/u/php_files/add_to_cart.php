<?php
if(!isset($_POST['id'])||!isset($_POST['qty'])){echo 'Process stopped';}
else{
    require '../../php_framework/function.php';
    if(!isset($_SESSION['uid'])){echo 1;}
    else{
        $pid=$_POST['id'];
        $uid=$_SESSION['uid'];
        $qty=$_POST['qty'];
        if((int)$qty<1){echo "Quantity can't less then 1.";}
        else{
            $sql="select * from user_cart_product where `UserID`=$uid and `ProductID`=$pid";
            $result=mysqli_query($conn,$sql);
            if(mysqli_num_rows($result)>0){
                $sql="update `user_cart_product` set `Quantity`=`Quantity`+$qty where `UserID`=$uid and `ProductID`=$pid;";
                if(!mysqli_query($conn,$sql)){
                    $mg='Fail to add to cart.';errorLog($mg.':'.mysqli_error($conn));echo$mg;
                }
            }else{
                $sql="insert into `user_cart_product` (`UserID`,`ProductID`,`DateTime`,`Quantity`) values ($uid,$pid,'".getDateTime()."',$qty);";
                if(!mysqli_query($conn,$sql)){
                    $mg='Fail to add to cart';errorLog($mg.':'.mysqli_error($conn));echo$mg;
                }
            }
            mysqli_close($conn);
        }
    }
}
?>