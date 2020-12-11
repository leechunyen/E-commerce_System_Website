<?php
if(!isset($_POST['rc'])||!isset($_POST['vc'])){echo 'Process stopped';}
else{
    require '../../php_framework/function.php';
    $rc=$_POST['rc'];
    $vc=$_POST['vc'];
    if(!validationCodeValify($rc,$vc)){echo 'Invalid validation code.';}
}
?>