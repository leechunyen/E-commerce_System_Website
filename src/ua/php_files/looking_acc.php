<?php
require '../../php_framework/function.php';
if(!isset($_POST['acc'])||!isset($_POST['rc'])){echo 'Process stopped';}
else{
    $acc=$_POST['acc'];
    $rc=$_POST['rc'];
    $tb='user';$col='Username';$mode;
    if(isset($_POST['md'])){$mode=$_POST['md'];}
    if($mode=='sysadm'){$tb='admin';}
    if(validateEmail($acc)){$col='Email';}
    $arr=array();
    $ldb=true;
    $condition="`$col`='$acc'";
    $oarr=$cache->get('db_recent_'.$tb);
    if($oarr){
        $arr=$oarr;
        foreach($arr as $row){
            if($row[$col]==$acc){
                echo$row['Email'];
                sendValidationCode($row['Email'],$rc,$tb);
                $ldb=false;
                break;
            }
        }
    }
    if($ldb){
        $sql="select * from `$tb` where $condition;";
        $result=mysqli_query($conn,$sql);
        if (mysqli_num_rows($result)>0){
            while($row=mysqli_fetch_assoc($result)){
                if($row[$col]==$acc){
                    if(count($arr[0])>=$maxCacheItem){
                        $cache->delete('db_recent_'.$tb);
                        unset($arr);
                        $arr=array();
                    }
                    $arr[]=$row;
                    $cache->set('db_recent_'.$tb,$arr,strtotime('+ 1 day'));
                    echo$row['Email'];
                    sendValidationCode($row['Email'],$rc,$tb);
                }
            }
        }else{echo 'Account not found.';}
        mysqli_close($conn);
    }
}
?>