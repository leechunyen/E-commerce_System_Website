<?php
if(!isset($_POST['id'])){
    echo 'Process stopped';
}else{
    require '../../php_framework/function.php';
    $id=$_POST['id'];
    $data=getData($conn,$maxCacheItem,'coupon_type','ID',$id);
    $json=json_encode(mb_convert_encoding($data,'UTF-8','UTF-8'));
    if($json){echo $json;}
    else{errorLog('Fail to encode json '.json_last_error_msg());}
}
?>