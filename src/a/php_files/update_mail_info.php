<?php
require '../../php_framework/function.php';
$ready=true;
for($x=0;$x<=5;$x++){
    if(!isset($_POST['data'][$x])){
        $ready=false;
        break;
    }
}
if(!$ready){
    echo 'Process stopped';
}else{
    $em_host=$_POST['data'][0];
    $em_port=$_POST['data'][1];
    $em_secure=$_POST['data'][2];
    $em_auth=$_POST['data'][3];
    $em_usn=$_POST['data'][4];
    $em_pass=$_POST['data'][5];
    $xmldata->MailServer->Username=encryptString($em_usn,$key);
    $xmldata->MailServer->Password=encryptString($em_pass,$key);
    $xmldata->MailServer->Host=$em_host;
    $xmldata->MailServer->Port=$em_port;
    $xmldata->MailServer->SMTPSecure=$em_secure;
    $xmldata->MailServer->SMTPAuth=$em_auth;
    if(!file_put_contents('../../others/system_setting.xml',$xmldata->saveXML())){
        $mg='Fail to save system setting';
        errorLog($mg.' mail server configuration.');echo$mg;
    }else{$cache->delete('mail_auth');}
}
?>