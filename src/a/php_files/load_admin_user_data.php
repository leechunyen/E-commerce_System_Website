<?php
require '../../php_framework/function.php';
if(!isset($_POST['id'])||!isset($_POST['type'])){
    echo 'Process stopped';
}else{
    $type=$_POST['type'];
    $id=$_POST['id'];
    $tb;
    if($type=='a'){$tb='admin';}
    elseif($type=='u'){$tb='user';}
    $data=getData($conn,$maxCacheItem,$tb,'ID',$id);
    if($_SESSION["aid"]==$val){$data['Self']=true;}
    else{$data['Self']=false;}
    $json=json_encode($data);
    if($json){echo $json;}
    else{errorLog('Fail to encode json '.json_last_error_msg());}
}
?>