<?php
if(!isset($_POST['acc'])||!isset($_POST['pass'])){
    echo 'Process stoped';
}else{
    require '../../php_framework/function.php';
    require_once '../../php_framework/get_ip_address.php';
    $next=0;
    $acc=$_POST['acc'];
    $psw=$_POST['pass'];
    $col='Username';
    $tb='admin';
    if(validateEmail($acc)){$col='Email';}
    $arr=array();
    $ldb=true;
    $condition="`$col`='$acc'";
    $oarr=$cache->get('db_recent_'.$tb);
    if($oarr){
        $arr=$oarr;
        foreach($arr as $row){
            if($row[$col]==$acc){
                if(decryptString($row['Password'],$key)==$psw){
                    if(!$row['Locked']){
                        $_SESSION["aid"]=$row["ID"];
                        $_SESSION["type"]=$row["Type"];
                        $next=1;
                        updateLastLoginInfo($conn,$tb,$row['ID']);
                    }else{$next=2;}
                }
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
                    if(count($arr[0])>=$maxCacheItem){
                        $cache->delete('db_recent_'.$tb);
                        unset($arr);
                        $arr=array();
                    }
                    $arr[]=$row;
                    if(decryptString($row['Password'],$key)==$psw){
                        if(!$row['Locked']){
                            $_SESSION["aid"]=$row["ID"];
                            $_SESSION["type"]=$row["Type"];
                            $next=1;
                            updateLastLoginInfo($conn,$tb,$row['ID']);
                            $cache->set('db_recent_'.$tb,$arr,strtotime('+ 1 day'));
                        }else{$next=2;}
                    }
                }
            }
        }
        mysqli_close($conn);
    }
    if($next==0){echo'Login fail please try again.';}
    else if($next==2){echo"Account locked";}
}
?>