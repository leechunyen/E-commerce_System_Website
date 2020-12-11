<?php
require '../../php_framework/function.php';
$ready=true;
for($i=0;$i<10;$i++){
    if(!isset($_POST['data'][$i])){
        $ready=false;
        break;
    }
}
if(!$ready||!isset($_SESSION['uid'])){echo 'Process stopped.';}
else{
    $uid=$_SESSION['uid'];
    $id=$_POST['data'][0];
    $name=$_POST['data'][1];
    $ph=$_POST['data'][2];
    $em=$_POST['data'][3];
    $addr=$_POST['data'][4];
    $st=$_POST['data'][5];
    $city=$_POST['data'][6];
    $zc=$_POST['data'][7];
    $cty=$_POST['data'][8];
    $tag=$_POST['data'][9];
    $sql="update `shipping_info` set `Name`='$name',`Phone`='$ph',`Email`='$em',`Address`='$addr',`City`='$city',`State`='$st',`Country`='$cty',`Postcode`='$zc',`Tag`='$tag' where `UserID`=$uid and `ID`=$id;";
    if(!mysqli_query($conn,$sql)){$mg='Fail to edit shipping address.';errorLog($mg.':'.mysqli_error($conn));echo$mg;}
}
?>