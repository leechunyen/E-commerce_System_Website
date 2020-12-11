<?php
if(!isset($_POST['rc'])||!isset($_POST['pass'])){echo 'Process stopped';}
else{
    require '../../php_framework/function.php';
    $rc=$_POST['rc'];
    $pass=$_POST['pass'];
    $arr=$cache->get('vc_'.$rc);
    if($arr){
        $em=$arr["email"][0];
        $type=$arr["type"][0];
        $pml=(int)$xmldata->MinPassLength;
        if(strlen($pass)<$pml){
            echo 'Minimum password length is '.$pml.'.';
        }else{
            $nwpass=encryptString($pass,$key);
            $sql="update `$type` set `Password`='$nwpass' where `Email`='$em';";
            if(mysqli_query($conn,$sql)){
                $cache->delete('db_recent_'.$type);
                $cache->delete('vc_'.$rc);
            }
            else{
                errorLog(mysqli_error($conn));
                echo 'Fail to reset password please try again.';
            }
        }
    }else{echo 1;}
}
?>