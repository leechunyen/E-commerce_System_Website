<?php
if(!isset($_POST['psw'])||!isset($_POST['type'])||!isset($_POST['id'])){
    echo 'Process stopped.';
}else{
    require '../../php_framework/function.php';
    $psw=$_POST['psw'];
    $type=$_POST['type'];
    $id=$_POST['id'];
    if($id=='-'&&!isset($_POST['crpsw'])){echo 'Process stopped.';}
    else{
        $fpfst=false;$pass=true;$tb;
        $crpsw=$_POST['crpsw'];
        if($type=='a'){$tb='admin';}
        elseif($type=='u'){$tb='user';}
        if($id=='-'&&$type=='a'){$id=$_SESSION['aid'];$fpfst=true;}
        elseif($id=='-'&&$type=='u'){$id=$_SESSION['uid'];$fpfst=true;}
        if($fpfst){
            $opsw=getValByEmUsn($conn,$maxCacheItem,$tb,'ID',$id,'Password');
            if($crpsw!=decryptString($opsw,$key)){
                $pass=false;
                echo 1;
            }
        }
        if($pass){
            $encpsw=encryptString ($psw,$key);
            $sql="update `$tb` set `Password`='$encpsw' where `ID`=$id;";
            if(!mysqli_query($conn, $sql)){
                echo 'Fail to update.';
                errorLog("Fail to update $tb Password ".mysqli_error($conn));
            }else{$cache->delete('db_recent_'.$tb);}
            mysqli_close($conn);
        }
    }
}
?>