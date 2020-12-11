<?php
require '../../php_framework/function.php';
if(!isset($_POST['p'])){
    echo 'Process stopped';
}else{$cache->flush();}
?>