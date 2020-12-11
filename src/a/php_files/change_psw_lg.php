<?php
require '../../php_framework/function.php';
if(!isset($_POST['nwpswlg'])){
    echo 'Process stopped';
}else{
    $nwpasslg=$_POST['nwpswlg'];
    $xmldata->MinPassLength=$nwpasslg;
    if(!file_put_contents('../../others/system_setting.xml',$xmldata->saveXML())){
        echo 'Fail to save system setting';
    }
}
?>