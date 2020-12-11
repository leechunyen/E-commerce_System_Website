<?php
require '../../php_framework/function.php';
if(!isset($_POST['ppcid'])||!checkAdminLogin(false,false)){
    echo 'Process stopped';
}else{
    $cid=$_POST['ppcid'];
    $xmldata->PayPalAPI=$cid;
    if(!file_put_contents('../../others/system_setting.xml',$xmldata->saveXML())){
        $mg='Fail to save';
        errorLog($mg.' PayPal Client ID');echo$mg;
    }else{$ppapi=$cid;}
}
?>