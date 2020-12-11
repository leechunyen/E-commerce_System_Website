<?php
require '../../php_framework/function.php';
if(!isset($_POST['id'])||!isset($_POST['type'])){echo 'Process stopped';}
else{
    $id=$_POST['id'];
    $type=$_POST['type'];
    $frompage=false;
    if($id=='-'&&$type=='a'){$id=$_SESSION['aid'];$frompage=true;}
    elseif($id=='-'&&$type=='u'){$id=$_SESSION['uid'];$frompage=true;}
    if($type=='a'){
        $phpth=getValByEmUsn($conn,$maxCacheItem,'admin','ID',$id,'Photo');
        $sql="delete from `admin` where `ID`=$id;";
        if(!mysqli_query($conn,$sql)){
            $mg='Fail to delete admin '.$id;
            echo$mg;
            errorLog($mg.' '.mysqli_error($conn));
        }else{
            $cache->delete('db_recent_admin');
            if($phpth!=null){deleteFile('../..'.$phpth);}
        }
    }elseif($type=='u'){
        $phpth=getValByEmUsn($conn,$maxCacheItem,'user','ID',$id,'Photo');
        $ranstr=string_generator(5);
        $cdt=getDateTime();
        $sql="update `user` set `Username`=concat('del-',`Username`, '-$cdt-$ranstr'),`Email`=concat('del-',`Email`, '-$cdt-$ranstr'),`Photo`=null,`Deleted`=true,`Activated`=false where `ID`=$id;";
        if(!mysqli_query($conn,$sql)){
            $mg='Fail to delete user '.$id;
            echo$mg;
            errorLog($mg.' '.mysqli_error($conn));
        }else{
            $cache->delete('db_recent_user');
            if($phpth!=null){deleteFile('../..'.$phpth);}
            if($frompage&&$type=='a'){logOut(2);}
            elseif($frompage&&$type=='u'){logOut(1);}
        }
    }
}
?>