<?php
if(!isset($_POST['rc'])||!isset($_POST['vc'])||!isset($_POST['em'])){echo 'Process stopped';}
else{
    require '../../php_framework/function.php';
    $rc=$_POST['rc'];
    $vc=$_POST['vc'];
    $em=$_POST['em'];
    $arr=validationCodeValify($rc,$vc,'type');
    $id;$tb=$arr['type'];
    if($tb=='admin'){$id=$_SESSION['aid'];}
    elseif($tb=='user'){$id=$_SESSION['uid'];}
    if(!$arr['check']){echo 'Invalid validation code.';}
    else{
        $sql="update `$tb` set `Email`='$em' where `ID`=$id;";
        if(!mysqli_query($conn,$sql)){
            $mg='Fail to save profile setting';
            echo$mg;
            errorLog($mg.' Email '.mysqli_error($conn));
        }else{$cache->delete('db_recent_'.$tb);}
        mysqli_close($conn);
    }
}
?>