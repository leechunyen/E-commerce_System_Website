<?php
require '../../php_framework/function.php';
if(!isset($_POST['p'])&&$_POST['p']=="send"){
    echo 'Process stopped';
}else{
    $col='ID';
    $tb='admin';
    $acc=$_SESSION["aid"];
    $arr=array();
    $ldb=true;
    $condition="`$col`=$acc";
    $oarr=$cache->get('db_recent_'.$tb);
    if($oarr){
        $arr=$oarr;
        foreach($arr as $row){
            if($row[$col]==$acc){
                sendEmail($row['Email'],$row['FirstName'],"TestEmail","This is a test email from $title");
                $ldb=false;
                break;
            }
        }
    }
    if($ldb){
        $sql="select * from `$tb` where $condition;";
        $result=mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){
            while($row=mysqli_fetch_assoc($result)){
                if($row[$col]==$acc){
                    if(count($arr>=$maxCacheItem)){
                        $cache->delete('db_recent_'.$tb);
                        unset($arr);
                        $arr=array();
                    }
                    $arr[]=$row;
                    sendEmail($row['Email'],$row['FirstName'],"TestEmail","This is a test email from $title");
                }
            }
        }
        mysqli_close($conn);
    }
    sendEmail($recEm,$recName,$subject,$ctn);
}
?>