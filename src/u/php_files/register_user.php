<?php
$ready=true;
for($x=0;$x<10;$x++){
    if(!isset($_POST['data'][$x])){$ready=false;break;}
}
if(!$ready){echo 'Process stopped.';}
else{
    require '../../php_framework/function.php';
    require_once '../../php_framework/get_ip_address.php';
    $rg_vc=$_POST['data'][0];
    $rc=$_POST['data'][1];
    $rg_fn=$_POST['data'][2];
    $rg_ln=$_POST['data'][3];
    $rg_usn=$_POST['data'][4];
    $rg_em=$_POST['data'][5];
    $rg_psw=$_POST['data'][6];
    $rg_dobd=$_POST['data'][7];
    $rg_dobm=$_POST['data'][8];
    $rg_doby=$_POST['data'][9];
    $rg_gd=$_POST['data'][10];
    $rg_ctry=$_POST['data'][11];
    if(!validationCodeValify($rc,$rg_vc)){
        echo 'Invalid validation code.';
    }elseif(ifExist($conn,$maxCacheItem,'user','Username',$rg_usn)||ifExist($conn,$maxCacheItem,'user','Email',$rg_em)){
        echo 'Username or Email already exist';
    }else{
        $sql="insert into `user` (`Username`,`Password`,`Email`,`FirstName`,`LastName`,`Gender`,`DobYear`,`DobMonth`,`DobDay`,`CountryRegional`,`Activated`,`Deleted`,`Locked`,`LastLoginIp`,`LastLoginDateTime`,`CreateDateTime`) values ('$rg_usn','".encryptString($rg_psw,$key)."','$rg_em','$rg_fn','$rg_ln','$rg_gd','$rg_doby','$rg_dobm','$rg_dobd','$rg_ctry',true,false,false,'".get_ip_address()."','".getDateTime()."','".getDateTime()."');";
        if(mysqli_query($conn,$sql)){
            $_SESSION["uid"]=mysqli_insert_id($conn);
        }else{
            $mg='Fail to create account.';
            errorLog($mg.':'.mysqli_error($conn));
            echo$mg;
        }
        mysqli_close($conn);
    }
}
?>