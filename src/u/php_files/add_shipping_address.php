<?php
require '../../php_framework/function.php';
$ready=true;
for($i=0;$i<9;$i++){
    if(!isset($_POST['data'][$i])){
        $ready=false;
        break;
    }
}
if(!$ready||!isset($_SESSION['uid'])){echo 'Process stopped.';}
else{
    $id=$_SESSION['uid'];
    $name=$_POST['data'][0];
    $ph=$_POST['data'][1];
    $em=$_POST['data'][2];
    $addr=$_POST['data'][3];
    $st=$_POST['data'][4];
    $city=$_POST['data'][5];
    $zc=$_POST['data'][6];
    $cty=$_POST['data'][7];
    $tag=$_POST['data'][8];
    $sql="insert into `shipping_info` (`Name`,`Phone`,`Email`,`Address`,`City`,`State`,`Country`,`Postcode`,`Tag`,`UserID`) values ('$name','$ph','$em','$addr','$city','$st','$cty','$zc','$tag',$id);";
    if(!mysqli_query($conn,$sql)){$mg='Fail to add shipping address.';errorLog($mg.':'.mysqli_error($conn));echo$mg;}
}
?>