<?php
require '../../php_framework/function.php';
if(!isset($_POST['uid'])||!isset($_POST['rc'])){echo 'Process stopped '.$_SESSION['uid'];}
else{
    $uid=$_POST['uid'];
    $rc=$_POST['rc'];
    $data=getData($conn,$maxCacheItem,'user','ID',$uid);
    $arr= array($data['Email']);
    sendValidationCode($data['Email'],$rc,'user',$uid);
    $json=json_encode($arr);
    if($json){echo $json;}
    else{errorLog('Fail to encode json '.json_last_error_msg());}
}
?>