<?php
$ready=true;
for($i=0;$i<4;$i++){
    if(!isset($_POST['data'][$i])){
        $ready=false;
        break;
    }
}
if(!$ready){echo 'Process stopped.';}
else{
    require '../../php_framework/function.php';
    $name=$_POST['data'][0];
    $email=$_POST['data'][1];
    $phone=$_POST['data'][2];
    $address=$_POST['data'][3];
    $sql="insert into `manage_supplier` (`Name`,`Address`,`Phone`,`Email`) values ('$name','".base64_encode($address)."','$phone','$email');";
    if(!mysqli_query($conn,$sql)){
        $mg='Fail to add suppiler ';
        errorLog($mg.' '.mysqli_error($conn));
        echo$mg;
    }
    mysqli_close($conn);
}
?>