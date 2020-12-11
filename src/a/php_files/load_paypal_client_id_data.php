<?php
require '../../php_framework/function.php';
if(!isset($_POST['p'])||!checkAdminLogin(false,false)){
    echo 'Process stopped';
}else{echo $ppapi;}
?>