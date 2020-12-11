<?php
if(!isset($_POST['m'])){
    echo 'Process stopped.';
}else{
    require '../../php_framework/function.php';
    $m=$_POST['m'];
    logOut($m);
}
?>