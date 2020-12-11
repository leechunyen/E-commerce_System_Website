<?php
require '../../php_framework/function.php';
if(!isset($_POST['spmdid'])||!isset($_POST['addrid'])||!isset($_POST['cpid'])||!isset($_SESSION['uid'])){echo 'Process stopped '.$_SESSION['uid'];}
else{
    $uid=$_SESSION['uid'];
    $spmd=$_POST['spmdid'];
    $addr=$_POST['addrid'];
    $uscp=$_POST['cpid'];
    $pass=true;$spcpdt;
    $spmddt=getData($conn,$maxCacheItem,'shipping_method','ID',$spmd);
    if(!$spmddt){$pass=false;}
    $spaddt=getData($conn,$maxCacheItem,'shipping_info','ID',$addr);
    if(!$spaddt||$spaddt['UserID']!=$uid){$pass=false;}
    if($uscp!=0){
        $spcpdt=getData($conn,$maxCacheItem,'user_coupon','ID',$uscp);
        if(!$spaddt||$spaddt['UserID']!=$uid){$pass=false;}
    }
    if(!$pass){echo 'System error';}
    else{
        $total=0;$cop=0;$top=0;
        $sql1="select * from `user_cart_product` join `product` on `user_cart_product`.`ProductID`=`product`.`ID` where `user_cart_product`.`UserID`=$uid;";
        $result1=mysqli_query($conn,$sql1);
        if(mysqli_num_rows($result1)>0){
            while($row=mysqli_fetch_assoc($result1)){
                $top+=(int)$row['Quantity'];
                $total+=(double)$row['Price']*(int)$row['Quantity'];
            }
        }
        if($uscp!=0){
            if($spcpdt['Mode']=='c'){$cop=$spcpdt['Discount'];}
            elseif($spcpdt['Mode']=='p'){$cop=(double)$total*(double)$spcpdt['Discount']/100;}
        }
        $payam=(double)$total+(double)$spmddt['Price']-(double)$cop;
        $arr= array($payam,$top);
        $json=json_encode($arr);
        if($json){echo $json;}
        else{errorLog('Fail to encode json '.json_last_error_msg());}
    }
}
?>