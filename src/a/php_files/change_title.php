<?php
require '../../php_framework/function.php';
if(!isset($_POST['nwtitle'])){
    echo 'Process stopped';
}else{
    $nwtitle=$_POST['nwtitle'];
    $xmldata->Title=$nwtitle;
    if(!file_put_contents('../../others/system_setting.xml',$xmldata->saveXML())){
        echo 'Fail to save system setting';
    }else{$title=$nwtitle;}
}
?>