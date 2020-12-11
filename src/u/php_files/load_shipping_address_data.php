<?php
require '../../php_framework/function.php';
if(!isset($_POST['id'])||!isset($_SESSION['uid'])){echo'Prosess stopped.';}
else{
    $id=$_POST['id'];
    $uid=$_SESSION['uid'];
    $tb='shipping_info';
    $data=false;$arr=array();$ldb=true;$condition="`ID`=$id and `UserID`=$uid";
    $oarr=$cache->get('db_recent_'.$tb);
    if($oarr){ $arr=$oarr;
        foreach($arr as $row){
            if($row['ID']==$id && $row['UserID']==$uid){$data=$row;$ldb=false;break;}
        }
    }
    if($ldb){$sql="select * from `$tb` where $condition;";
        $result=mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){
            while($row=mysqli_fetch_assoc($result)){
                if($row[$col]==$val){
                    if(count($arr[0])>=$maxCacheItem){$cache->delete('db_recent_'.$tb);unset($arr);$arr=array();}
                    $arr[]=$row;$data=$row;
                    $cache->set('db_recent_'.$tb,$arr,strtotime('+ 1 day'));
                }
            }
        }
        mysqli_close($conn);
    }
    $json=json_encode($data);
    if($json){echo $json;}
    else{errorLog('Fail to encode json '.json_last_error_msg());}
}
?>