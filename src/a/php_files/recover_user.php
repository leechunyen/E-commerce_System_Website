<?php
require '../../php_framework/function.php';
if(!isset($_POST['id'])){
    echo 'Process stopped';
}else{
    $id=$_POST['id'];
    $arr= array();$er=0;$m='';
    $tusn='tmp-username';
    $tem='tmp-email';
    $oem=getValByEmUsn($conn,$maxCacheItem,'user','ID',$id,'Email');
    $oun=getValByEmUsn($conn,$maxCacheItem,'user','ID',$id,'Username');
    $em=substr($oem,4);$em=substr($em,0,strpos($em,'-'));
    $un=substr($oun,4);$un=substr($un,0,strpos($un,'-'));
    if(!ifExist($conn,$maxCacheItem,'user','Username',$un)){$tusn=$un;}
    else{$er=$er+1;}
    if(!ifExist($conn,$maxCacheItem,'user','Email',$em)){$tem=$em;}
    else{$er=$er+2;}
    $arr['usn']=$un;
    $arr['em']=$em;
    $arr['er']=$er;
    if($er==0){
        $m="`Username`='$tusn',`Email`='$tem',";
    }elseif($er==1){
        $m="`Email`='$tem',";
    }elseif($er==2){
        $m="`Username`='$tusn',";
    }
    $sql="update `user` set $m`Deleted`=false where `ID`=$id;";
    if(!mysqli_query($conn,$sql)){
        $mg='Fail to recover user '.$id;
        $arr['ermg']=$mg;
        errorLog($mg.' '.mysqli_error($conn));
    }else{$cache->delete('db_recent_user');}
    mysqli_close($conn);
    echo json_encode($arr);
}
?>