<?php
require '../../php_framework/function.php';
if(!isset($_POST['id'])){
    echo 'Process stopped';
}else{
    $id=$_POST['id'];
    $tb='purchase_history';
    $data=getData($conn,$maxCacheItem,$tb,'ID',$id);
    $json=json_encode($data);
    if($json){echo $json;}
    else{errorLog('Fail to encode json '.json_last_error_msg());}
}
?>