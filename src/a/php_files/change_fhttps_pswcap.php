<?php
require '../../php_framework/function.php';
if(!isset($_POST['mode'])||!isset($_POST['val'])){
    echo 'Process stopped';
}else{
    $mode=$_POST['mode'];
    $val=$_POST['val'];
    if($mode==1){
        $xmldata->ForceHTTPS=$val;
    }elseif($mode==2){
        $xmldata->PassCap=$val;
    }
    if(!file_put_contents('../../others/system_setting.xml',$xmldata->saveXML())){
        echo 'Fail to save system setting';
    }
}
?>