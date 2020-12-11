<?php
$ready=true;
for($i=0;$i<7;$i++){
    if(!isset($_POST['data'][$i])){
        $ready=false;
        break;
    }
}
if(!$ready){echo 'Process stopped.';}
else{
    require '../../php_framework/function.php';
    $id=$_POST['data'][0];
    $ava=$_POST['data'][1];
    $dsc=$_POST['data'][2];
    $minpay=$_POST['data'][3];
    $dis=$_POST['data'][4];
    $mode=$_POST['data'][5];
    $dtexp=$_POST['data'][6];
    $sql="update `coupon_type` set `MinPay`=$minpay,`Discount`=$dis,`DaysToExpired`=$dtexp,`Mode`='$mode',`Available`=$ava,`Description`='$dsc' where `ID`=$id;";
    if(!mysqli_query($conn,$sql)){
        $mg='Fail to add coupon type';
        errorLog($mg.' '.mysqli_error($conn));
        echo$mg;
    }else{$cache->delete('db_recent_coupon_type');}
    mysqli_close($conn);
}
?>