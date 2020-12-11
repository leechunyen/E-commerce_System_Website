<?php
if(!isset($_POST['rc'])||!isset($_POST['em'])){echo 'Process stopped';}
else{
    require '../../php_framework/function.php';
    $rc=$_POST['rc'];
    $em=$_POST['em'];
    $mode;$dt='';$tb='user';
    if(isset($_POST['md'])){$mode=$_POST['md'];}
    if(isset($_POST['dt'])){$dt=$_POST['dt'];}
    if($mode=='sysadm'){$tb='admin';}
    resendValidationCode($rc,$em,$tb,$dt);
}
?>