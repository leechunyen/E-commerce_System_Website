<?php
require '../../php_framework/function.php';
if(!isset($_POST['p'])||!checkAdminLogin(false,false)){
    echo 'Process stopped';
}else{
    $emauth=$cache->get('mail_auth');
    if(!$emauth){
        sendEmail("","","","");
        $emauth=$cache->get('mail_auth');
    }
    $arr= array();
    $arr['host']=(string)$xmldata->MailServer->Host;
    $arr['port']=(string)$xmldata->MailServer->Port;
    $arr['secure']=(string)$xmldata->MailServer->SMTPSecure;
    $arr['auth']=$xmldata->MailServer->SMTPAuth;
    $arr['acc']=$emauth["acc"][0];
    $arr['psw']=$emauth["pas"][0];
    $json=json_encode($arr);
    if($json){echo $json;}
    else{errorLog('Fail to encode json '.json_last_error_msg());}
}
?>