<?php
if(!isset($_POST['acc'])||!isset($_POST['psw'])){
    echo 'Process stopped.';
}else{
    require '../../php_framework/function.php';
    require_once '../../php_framework/get_ip_address.php';
    $next=0;$uid=0;
    $acc=$_POST['acc'];
    $psw=$_POST['psw'];
    $lgflmg='Login fail please try again.';
    $col='Username';
    $tb='user';
    if(validateEmail($acc)){$col='Email';}
    $arr=array();
    $ldb=true;
    $condition="`$col`='$acc'";
    $oarr=$cache->get('db_recent_'.$tb);
    if($oarr){
        $arr=$oarr;
        foreach($arr as $row){
            if($row[$col]==$acc){$uid=$row['ID'];
                if(!$row['Deleted']&&decryptString($row['Password'],$key)==$psw){
                    if($row['Locked']){$next=2;}
                    elseif(!$row['Activated']){
                        $next=3;
                    }else{
                        $_SESSION['uid']=$row['ID'];
                        $next=1;
                        updateLastLoginInfo($conn,$tb,$row['ID']);
                    }
                }
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
                if($row[$col]==$acc){$uid=$row['ID'];
                    if(count($arr[0])>=$maxCacheItem){
                        $cache->delete('db_recent_'.$tb);
                        unset($arr);
                        $arr=array();
                    }
                    $arr[]=$row;
                    $cache->set('db_recent_'.$tb,$arr,strtotime('+ 1 day'));
                    if(!$row['Deleted']&&decryptString($row['Password'],$key)==$psw){
                        if($row['Locked']){$next=2;}
                        elseif(!$row['Activated']){
                            $next=3;
                        }else{
                            $_SESSION['uid']=$row['ID'];
                            $next=1;
                            updateLastLoginInfo($conn,$tb,$row['ID']);
                        }
                    }
                }
            }
        }
        mysqli_close($conn);
    }
    $js=array($next,$uid);
    $json=json_encode($js);
    if($json){echo $json;}
    else{errorLog('Fail to encode json '.json_last_error_msg());}
}
?>