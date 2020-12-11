<?php
$ready=true;
for($i=0;$i<6;$i++){
    if(!isset($_POST['data'][$i])){
        $ready=false;
        break;
    }
}
if(!$ready){echo 'Process stopped.';}
else{
    require '../../php_framework/function.php';
    $ava=$_POST['data'][0];
    $dsc=$_POST['data'][1];
    $minpay=$_POST['data'][2];
    $dis=$_POST['data'][3];
    $mode=$_POST['data'][4];
    $dtexp=$_POST['data'][5];
    $sql="insert into `coupon_type` (`MinPay`,`Discount`,`DaysToExpired`,`Mode`,`Available`,`Description`) values ($minpay,$dis,$dtexp,'$mode',$ava,'$dsc');";
    if(!mysqli_query($conn,$sql)){
        $mg='Fail to add coupon type';
        errorLog($mg.' '.mysqli_error($conn));
        echo$mg;
    }
    mysqli_close($conn);
}
?>