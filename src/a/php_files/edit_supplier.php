<?php
$ready=true;
for($x=0;$x<5;$x++){
    if(!isset($_POST['data'][$x])){$ready=false;break;}
}
if(!$ready){
    echo 'Process stopped';
}else{
    require '../../php_framework/function.php';
    $id=$_POST['data'][0];
    $name=$_POST['data'][1];
    $email=$_POST['data'][2];
    $phone=$_POST['data'][3];
    $address=$_POST['data'][4];
    $sql="update `manage_supplier` set `Name`='$name',`Address`='".base64_encode($address)."',`Phone`='$phone',`Email`='$email' where `ID`=$id;";
    if(!mysqli_query($conn,$sql)){
        $mg='Fail to edit supplier';
        echo$mg;
        errorLog($mg.' '.mysqli_error($conn));
    }else{$cache->delete('db_recent_manage_supplier');}
    mysqli_close($conn);
}
?>