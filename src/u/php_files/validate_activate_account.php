<?php
require '../../php_framework/function.php';
if(!isset($_POST['vc'])||!isset($_POST['rc'])){echo 'Process stopped';}
else{
    $vc=$_POST['vc'];
    $rc=$_POST['rc'];
    $vd=validationCodeValify($rc,$vc,'data');
    if(!$vd['check']){
        echo 1;
    }else{
        $sql="update `user` set `Activated`=true where `ID`=".$vd['data'].';';
        if(!mysqli_query($conn,$sql)){
            $mg='Fail to activate account';errorLog($mg.' '.mysqli_error($conn));echo$mg;
        }else{echo 0;
        $cache->delete('db_recent_user');
        $cache->delete('vc_'.$rc);}
        mysqli_close($conn);
    }
    
    
    
    
    
}
?>