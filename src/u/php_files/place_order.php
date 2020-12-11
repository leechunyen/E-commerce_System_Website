<?php
require '../../php_framework/function.php';
if(!isset($_POST['spmdid'])||!isset($_POST['addrid'])||!isset($_POST['cpid'])||!isset($_SESSION['uid'])){echo 'Process stopped '.$_SESSION['uid'];}
else{
    $uid=$_SESSION['uid'];
    $spmd=$_POST['spmdid'];
    $addr=$_POST['addrid'];
    $uscp=$_POST['cpid'];
    $tp=$_POST['tp'];
    $pass=true;$spmame;$spfe;
    $spmddt=getData($conn,$maxCacheItem,'shipping_method','ID',$spmd);
    if(!$spmddt){$pass=false;}
    else{
        $spmame=$spmddt['Title'];
        $spfe=$spmddt['Price'];
    }
    $spaddt=getData($conn,$maxCacheItem,'shipping_info','ID',$addr);
    if(!$spaddt||$spaddt['UserID']!=$uid){$pass=false;}
    if($uscp!=0){
        $spcpdt=getData($conn,$maxCacheItem,'user_coupon','ID',$uscp);
        if(!$spaddt||$spaddt['UserID']!=$uid){$pass=false;}
    }else{$uscp='null';}
    if(!$pass){echo 'System error';}
    else{
        $total=0;
        $sql="insert into `order` (`DateTime`,`TotalAmount`,`ShippingEmail`,`ShippingPhone`,`ShippingName`,`ShippingAddress`,`Finished`,`UserID`) values ('".getDateTime()."',0,'".$spaddt['Email']."','".$spaddt['Phone']."','".$spaddt['Name']."','".$spaddt['Address'].' '.$spaddt['City'].' '.$spaddt['State'].' '.$spaddt['Country'].' '.$spaddt['Postcode']."',false,'$uid');";
        if(!mysqli_query($conn,$sql)){
            $mg='Fail to place order';errorLog($mg.':'.mysqli_error($conn));echo$mg;
        }else{
            $oid=mysqli_insert_id($conn);
            $sql1="select * from `user_cart_product` join `product` on `user_cart_product`.`ProductID`=`product`.`ID` where `user_cart_product`.`UserID`=$uid;";
            $result1=mysqli_query($conn,$sql1);
            if(mysqli_num_rows($result1)>0){
                while($row=mysqli_fetch_assoc($result1)){
                    $sql="insert into `order_product` (`OrderID`,`ProductID`,`ProductPrice`,`Quantity`,`ProductName`,`ProductPhoto`) values ($oid,".$row['ProductID'].",".$row['Price'].",".$row['Quantity'].",'".$row['Name']."','".$row['DefaultPhoto']."');";
                    mysqli_query($conn,$sql);
                    $total+=(double)$row['Price']*(int)$row['Quantity'];
                }
            }
            $sql2="insert into `payment` (`PaidAmount`,`ShippingFee`,`DateTime`,`ShippingMethodSelected`,`UserID`,`UserCouponID`) values ('$tp',$spfe,'".getDateTime()."','$spmame',$uid,$uscp);";
            if(!mysqli_query($conn,$sql2)){
                $mg='Fail to insert payment';errorLog($mg.':'.mysqli_error($conn));echo$mg;
            }
            $pid=mysqli_insert_id($conn);
            $sql3="update `order` set `TotalAmount`=$total,`PaymentID`=$pid where `ID`=$oid";
            if(!mysqli_query($conn,$sql3)){
                $mg='Fail to update order total amount ';errorLog($mg.':'.mysqli_error($conn));echo$mg;
            }
            if($uscp!='null'){
                $sql4="update `user_coupon` set `Used`=true where `ID`=$uscp";
                if(!mysqli_query($conn,$sql4)){
                    $mg='Fail to update coupon use ';errorLog($mg.':'.mysqli_error($conn));echo$mg;
                }
            }
            $sql5="select * from `user_cart_product` where `UserID`=$uid;";
            $result5=mysqli_query($conn,$sql5);
            if (mysqli_num_rows($result5)>0) {
                while($row=mysqli_fetch_assoc($result5)) {
                    $sql6="update `product` set `Stock`=`Stock`-".$row['Quantity']." where `ID`=".$row['ProductID'].";";
                    if(!mysqli_query($conn,$sql6)){
                        $mg='Fail to update product quantity ';errorLog($mg.':'.mysqli_error($conn));echo$mg;
                    }
                }
                $cache->delete('db_recent_product');
            }
            $sql7="delete from `user_cart_product` where `UserID`=$uid;";
            if(!mysqli_query($conn,$sql7)){
                $mg='Fail to clear cart ';errorLog($mg.':'.mysqli_error($conn));echo$mg;
            }
            $usr=getData($conn,$maxCacheItem,'user','ID',$uid);
            $subject=$xmldata->Title.'Order';
            $ctn='you are place an order om our website.<br/>Order ID: '.$oid;
            sendEmail($usr['Email'],$usr['LastName'],$subject,$ctn);
        }
        mysqli_close($conn);
    }
}
?>