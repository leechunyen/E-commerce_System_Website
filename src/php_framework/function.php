<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require getFile('/php_framework/string_enc_dec.php');
$cache;$conn;$key;$xmldata;$logo;$title;$ppapi;$maxCacheItem=1000;$imgCompressLevel=50;
$imgArray=array('png','jpg','jpeg','PNG','JPG','JPEG');
$txtDocArray=array('txt');
if(checkSetup()){//init
    $xmldata=loadSystemSettingFile();
    if(!isset($_SERVER["HTTPS"])&&$xmldata->ForceHTTPS=='true'){
        header("Location: https://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
    }
    $logo=getFile('/'.$xmldata->LogoPath);
    $title=$xmldata->Title;
    $cache=cacheSetup();
    $key=$xmldata->SysAuth;
    $host;$port;$usn;$pass;$db;
    $ppapi=$xmldata->PayPalAPI;
    $db_aarr=$cache->get('db_auth');
    if($db_aarr){
        $host=$db_aarr["hts"][0];
        $port=$db_aarr["prt"][0];
        $usn=$db_aarr["usn"][0];
        $pass=$db_aarr["pas"][0];
        $db=$db_aarr["dbn"][0];
    }else{
        $host=decryptString($xmldata->DatabaseServer->Host,$key);
        $port=decryptString($xmldata->DatabaseServer->Port,$key);
        $usn=decryptString($xmldata->DatabaseServer->Username,$key);
        $pass=decryptString($xmldata->DatabaseServer->Password,$key);
        $db=decryptString($xmldata->DatabaseServer->DatabaseName,$key);
        $db_aarr=array();
        $db_aarr["hts"][0]=$host;
        $db_aarr["prt"][0]=$port;
        $db_aarr["usn"][0]=$usn;
        $db_aarr["pas"][0]=$pass;
        $db_aarr["dbn"][0]=$db;
        $cache->set('db_auth',$db_aarr, strtotime('+ 1 day'));
    }
    $conn=mysqli_connect($host.':'.$port,$usn,$pass,$db);
    if(!$conn){
        $er='Fail to connect Database '.mysqli_connect_error();
        errorLog($er);echo$er;
    }
    checkProductAvailability($conn,$cache);
}
function sendEmail($recEm,$recName,$subject,$ctn){
    require_once getFile('/php_framework/PHPMailer-6.1.7/PHPMailer.php');
    require_once getFile('/php_framework/PHPMailer-6.1.7/Exception.php');
    require_once getFile('/php_framework/PHPMailer-6.1.7/SMTP.php');
    $xmldata=loadSystemSettingFile();$title=$xmldata->Title;$key=$xmldata->SysAuth;
    $host=$xmldata->MailServer->Host;$port=$xmldata->MailServer->Port;
    $secure=$xmldata->MailServer->SMTPSecure;$auth=false;if($xmldata->MailServer->SMTPAuth=='true'){$auth=true;}
    $emacc='';$empass='';$cache=cacheSetup();$emauth=$cache->get('mail_auth');
    if($emauth){$emacc=$emauth["acc"][0];$empass=$emauth["pas"][0];}else{
        $emacc=decryptString($xmldata->MailServer->Username,$key);
        $empass=decryptString($xmldata->MailServer->Password,$key);
        $emauth=array();$emauth['acc'][0]=$emacc;$emauth['pas'][0]=$empass;
        $cache->set('mail_auth',$emauth,strtotime('+ 1 day'));}
    if($recEm!=""||$subject!=""||$ctn!=""){
        $mail=new PHPMailer(true);
        try{$mail->isSMTP();$mail->Host=$host;$mail->SMTPAuth=$auth;$mail->Username=$emacc;$mail->Password=$empass;
            $mail->SMTPSecure=$secure;$mail->Port=$port;$mail->isHTML(true);$mail->setFrom($emacc,$title); $mail->addAddress($recEm,$recName);
            $mail->Subject=$subject;$mail->Body=$ctn;$mail->send();
         }catch(Exception$e){errorLog($e);echo"Email fail to send.";}}
}
function cacheSetup(){
    require_once getFile('/php_framework/RWFileCache.php');
    $cdir=getFile('/others/cached/');
    if(!is_writable($cdir)){errorLog('Fail to write cache');}
    else{
        $cache=new\rapidweb\RWFileCache\RWFileCache();
        $cache->changeConfig(["cacheDirectory"=>$cdir]);
        return $cache;
    }
}
function getFile($f){
    if(file_exists('.'.$f)){return'.'.$f;}
    elseif(file_exists('..'.$f)){return'..'.$f;}
    elseif(file_exists('../..'.$f)){return'../..'.$f;}
    else{echo"Csn't found ".$f;}
}
function loadSystemSettingFile(){
    $xmlfile=simplexml_load_file(getFile('/others/system_setting.xml'));
    if($xmlfile){return $xmlfile;}
    else{errorLog('Fail to load /others/system_setting.xml');}
}
function checkSetup(){
    if(basename($_SERVER['PHP_SELF'])<>'first_setup_start.php'){
        $xmldata=loadSystemSettingFile();
        $fs=getFile('/a/pages/first_setup.php');
        if($xmldata->Setup<>'true'&&basename($_SERVER['PHP_SELF'])<>'first_setup.php'){
            header('Location: '.$fs);
        }elseif($xmldata->Setup=='true'&&basename($_SERVER['PHP_SELF'])=='first_setup.php'){
            header('Location: ../index.php');
        }
        if($xmldata->Setup<>'true'){return false;}
        else{return true;}
    }else{return false;}
}
function checkAdminLogin($mode=true,$jumpback=''){
    $bk='';if($jumpback!==''){$bk='?ret='.$jumpback;}
    if(isset($_SESSION["aid"])&&isset($_SESSION["type"])){
        if($mode&&basename($_SERVER['PHP_SELF'])=='index.php'){
            echo"<script>location.href='./pages/master.php';</script>";
        }else if($mode&&basename($_SERVER['PHP_SELF'])=='reset_password.php'){
            echo"<script>location.href='./master.php';</script>";
        }
        return true;
    }else{
        if($mode&&basename($_SERVER['PHP_SELF'])=='master.php'){
            echo"<script>location.href='../index.php$bk';</script>";
        }
        return false;
    }
}
function checkUserLogin($mode=false,$jumpback=false){
    $bk='';if($jumpback){$bk='?ret=1';}
    if(isset($_SESSION["uid"])){
        if($mode&&basename($_SERVER['PHP_SELF'])=='login_register.php'){
            echo"<script>location.href='../index.php';</script>";
        }
        return true;
    }else{
        if($mode&&basename($_SERVER['PHP_SELF'])!='login_register.php'){
            echo"<script>location.href='".getFile('/u/pages/login_register.php')."$bk';</script>";
        }
        return false;
    }
}
function getDateTime($f='Y-m-d H:i:s'){
    date_default_timezone_set("UTC");
    return date($f);
}
function wrFail($file=''){
    errorLog('File or directory fail to write \''.$file.'\'');
    echo"can't write to comfiguration file: $file. ";
}
function errorLog($error_mg){
    $error_log_file="/others/errors.log";
    error_log('['.getDateTime().' UTC] "'.$_SERVER['PHP_SELF'].'" '.$error_mg.'
',3,getFile($error_log_file));
}
function validateEmail($email){
    if(filter_var($email,FILTER_VALIDATE_EMAIL)){
        return true;
    }else{return false;}
}
function sendValidationCode($email,$rc,$type,$data=''){
    $cache=cacheSetup();
    $code=rand(100000,999999);
    validationCodeSend($email,$code);
    $arr= array();
    $arr['type'][0]=$type;
    $arr['data'][0]=$data;
    $arr['email'][0]=$email;
    $arr['code'][0]=$code;
    $cache->set('vc_'.$rc,$arr,strtotime('+ 5 minutes'));
}
function resendValidationCode($rc,$em,$type,$data=''){
    $cache=cacheSetup();$email='';$arr= array();
    $code=rand(100000,999999);
    $carr=$cache->get('vc_'.$rc);
    if($carr){
        $arr=$carr;
        $email=$arr['email'][0];
    }else{
        $arr['email'][0]=$em;
        $arr['type'][0]=$type;
        $arr['data'][0]=$data;
        $email=$em;
    }
    $arr['code'][0]=$code;
    validationCodeSend($email,$code);
    $cache->set('vc_'.$rc,$arr,strtotime('+ 5 minutes'));
}
function validationCodeValify($rc,$ipcode,$get=null){
    $cache=cacheSetup();
    $arr=$cache->get('vc_'.$rc);
    if(!$arr){return false;}else{
        $code=$arr['code'][0];
        if($get==null){
            if($code==$ipcode){return true;}else{return false;}
        }else{
            $arr1=array();
            if($code==$ipcode){$arr1['check']=true;}else{$arr1['check']=false;}
            $arr1[$get]=$arr[$get][0];
            return $arr1;
        }
    }
}
function validationCodeSend($email,$code){
    $xmldata=loadSystemSettingFile();
    $st=$xmldata->Title;
    $sj="$st Validation Code";
    $mg="Your validation code is $code this code will expire after 5 minutes.";
    sendEmail($email,'',$sj,$mg);
}
function logOut($m){
    if($m==1){//user
        unset($_SESSION['uid']);
    }elseif($m==2){//admin
        unset($_SESSION['aid']);
        unset($_SESSION['type']);
    }
}
function ifExist($conn,$maxCacheItem,$tb,$col,$val,$selfID=null){
    $condition="`$col`='$val'";$cache=cacheSetup();$ldb=true;$arr= array();$oarr=$cache->get('db_recent_'.$tb);
    if($selfID!=null){$condition.=" and `ID`!=$selfID";}
    if($oarr){$arr=$oarr;foreach($arr as $row){
        if($row[$col]==$val){
            if($selfID!=null){if($row['ID']!=$selfID){return true;}  
            }else{return true;}$ldb=false;
        }
    }}
    if($ldb){$sql="select * from `$tb` where $condition;";
        $result=mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){
            while($row=mysqli_fetch_assoc($result)){
                if($row[$col]==$val){if(count($arr[0])>=$maxCacheItem){$cache->delete('db_recent_'.$tb);unset($arr);$arr=array();}
                    $arr[]=$row;$cache->set('db_recent_'.$tb,$arr,strtotime('+ 1 day'));
                    return true;
                }
            }
        }
    }
    return false;
}
function updateLastLoginInfo($conn,$tb,$id){
    $qr="update `$tb` set `LastLoginIp`='".get_ip_address()."',`LastLoginDateTime`='".getDateTime()."' where `ID`='$id';";
    if(!mysqli_query($conn,$qr)){
        errorLog('Fail to update last login info : '.mysqli_error($conn));
    }
}
function compressImage($source,$destination,$quality=50) {
    $info = getimagesize($source);
    if ($info['mime']=='image/jpeg'){
        $image=imagecreatefromjpeg($source);
    }elseif ($info['mime']=='image/gif'){
        $image=imagecreatefromgif($source);
    }elseif ($info['mime']=='image/png'){
        $image=imagecreatefrompng($source);
    }
    if($destination==null){
        ob_start(); 
        imagejpeg($image,$destination,$quality);
        $ct=ob_get_contents(); 
        ob_end_clean(); 
        return $ct;
    }else{return imagejpeg($image,$destination,$quality);}
    
}
function deleteFile($target){
    if(is_dir($target)){
        $files=glob($target.'*', GLOB_MARK ); 
        foreach($files as $file){
            deleteFile( $file );      
        }
        rmdir( $target );
    } elseif(is_file($target)) {
        unlink( $target );  
    }
}
function human_filesize($bytes,$decimals=2) {
    $sz='BKMGTP';
    $factor=floor((strlen($bytes)-1)/3);
    return sprintf("%.{$decimals}f",$bytes/pow(1024,$factor)).@$sz[$factor];
}
function string_generator($length=5) {
    $characters='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength=strlen($characters);
    $randomString='';
    for($i=0;$i<$length;$i++) {
        $randomString.=$characters[rand(0,$charactersLength-1)];
    }
    return$randomString;
}
function getIdByEmUsn($conn,$maxCacheItem,$tb,$col,$val){
    $condition="`$col`='$val'";$cache=cacheSetup();$ldb=true;$arr= array();$oarr=$cache->get('db_recent_'.$tb);
    if($oarr){$arr=$oarr;
        foreach($arr as $row){if($row[$col]==$val){$ldb=false;return $row['ID'];}
    }}
    if($ldb){$sql="select * from `$tb` where $condition;";
        $result=mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){
            while($row=mysqli_fetch_assoc($result)){
                if($row[$col]==$val){
                    if(count($arr[0])>=$maxCacheItem){
                        $cache->delete('db_recent_'.$tb);
                        unset($arr);$arr=array();
                    }
                    $arr[]=$row;$cache->set('db_recent_'.$tb,$arr,strtotime('+ 1 day'));
                    return $row['ID'];
                }
            }
        }
    }
    return false;
}
function getValByEmUsn($conn,$maxCacheItem,$tb,$col,$val,$vtg){
    $condition="`$col`='$val'";$cache=cacheSetup();$ldb=true;$arr= array();$oarr=$cache->get('db_recent_'.$tb);
    if($oarr){$arr=$oarr;
        foreach($arr as $row){if($row[$col]==$val){$ldb=false;return $row[$vtg];}
    }}
    if($ldb){$sql="select * from `$tb` where $condition;";
        $result=mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){
            while($row=mysqli_fetch_assoc($result)){
                if($row[$col]==$val){
                    if(count($arr[0])>=$maxCacheItem){
                        $cache->delete('db_recent_'.$tb);
                        unset($arr);$arr=array();
                    }
                    $arr[]=$row;$cache->set('db_recent_'.$tb,$arr,strtotime('+ 1 day'));
                    return $row[$vtg];
                }
            }
        }
    }
    return false;
}
function stringToDate($dt,$f='m/d/Y H:i'){
    $date=date_create_from_format($f,$dt);
    $date->getTimestamp();
    return$date;
}
function dataFormat($dt,$f='m/d/Y H:i'){
    $date=new DateTime($dt);
    return $date->format($f);
}
function getData($conn,$maxCacheItem,$tb,$col,$val){
    $data=false;$arr=array();$ldb=true;$condition="`$col`='$val'";
    $cache=cacheSetup();$oarr=$cache->get('db_recent_'.$tb);
    if($oarr){ $arr=$oarr;
        foreach($arr as $row){if($row[$col]==$val){$data=$row;$ldb=false;break;}}
    }
    if($ldb){$sql="select * from `$tb` where $condition;";
        $result=mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){
            while($row=mysqli_fetch_assoc($result)){
                if($row[$col]==$val){
                    if(count($arr[0])>=$maxCacheItem){$cache->delete('db_recent_'.$tb);unset($arr);$arr=array();}
                    $arr[]=$row;$data=$row;
                    $cache->set('db_recent_'.$tb,$arr,strtotime('+ 1 day'));
                }
            }
        }
    }
    return $data;
}
function checkProductAvailability($conn,$cache){
    $fl= array('master.php','index.php');
    if(!in_array(basename($_SERVER['PHP_SELF']),$fl)){
        $sql="select * from `product` where `AutoAvailableDateTime` is not null or `AutoUnavailableDateTime` is not null;";
        $result=mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){$up=false;
            while($row=mysqli_fetch_assoc($result)){
                if($row['AutoAvailableDateTime']<>null&&new DateTime($row['AutoAvailableDateTime'])<=new DateTime(getDateTime())){
                    $sql1="update `product` set `AutoAvailableDateTime`=null,`Available`=true where `ID`=".$row['ID'].";";
                    mysqli_query($conn,$sql1);$up=true;
                }
                if($row['AutoUnavailableDateTime']<>null&&new DateTime($row['AutoUnavailableDateTime'])<=new DateTime(getDateTime())){
                    $sql1="update `product` set `AutoUnavailableDateTime`=null,`Available`=false where `ID`=".$row['ID'].";";
                    mysqli_query($conn,$sql1);$up=true;
                }
                if($up){$cache->delete('db_recent_product');}
            }
        }
    }
}
?>