<?php
if(!isset($_POST['id'])){echo 'Process stopped';}
else{
    require '../../php_framework/function.php';
    if(!isset($_SESSION['uid'])){echo 1;}
    else{
        $uid=$_SESSION['uid'];
        $cid=$_POST['id'];
        if(ifExist($conn,$maxCacheItem,'user_coupon','CouponTypeID',$cid)){
            echo 'you already get this coupon.';
        }else{
            $data=getData($conn,$maxCacheItem,'coupon_type','ID',$cid);
            if(!$data||!$data['Available']){echo'Coupon not available.';}
            else{
                $expdt=Date('Y-m-d H:i:s',strtotime('+'.$data['DaysToExpired'].' days'));
                $sql="insert into `user_coupon` (`MinPay`,`Discount`,`ExpireDateTime`,`Mode`,`Used`,`CouponTypeID`,`UserID`) values (".$data['MinPay'].",".$data['Discount'].",'$expdt','".$data['Mode']."',false,$cid,$uid);";
                if(!mysqli_query($conn,$sql)){
                    $mg='Fail to get coupon ';errorLog($mg.':'.mysqli_error($conn));echo$mg;
                }
            }
        }
        mysqli_close($conn);
    }
}
?>