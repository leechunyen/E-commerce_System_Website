<?php
$ready=true;
for($x=0;$x<=22;$x++){if(!isset($_POST['data'][$x])){$ready=false;break;}}
if(!$ready){echo 'Process stopped';}
else{
    require '../../php_framework/function.php';
    require_once '../../php_framework/get_ip_address.php';
    $key=base64_encode(openssl_random_pseudo_bytes(32));
    $ip=get_ip_address();
    $sitename=$_POST['data'][0];
    $min_pass_lg=$_POST['data'][1];
    $pass_cap=$_POST['data'][2];
    $foece_https=$_POST['data'][3];
    $db_host=$_POST['data'][4];
    $db_port=$_POST['data'][5];
    $db_usn=$_POST['data'][6];
    $db_pass=$_POST['data'][7];
    $db_name=$_POST['data'][8];
    $em_host=$_POST['data'][9];
    $em_port=$_POST['data'][10];
    $em_secure=$_POST['data'][11];
    $em_auth=$_POST['data'][12];
    $em_usn=$_POST['data'][13];
    $em_pass=$_POST['data'][14];
    $rg_fn=$_POST['data'][15];
    $rg_ln=$_POST['data'][16];
    $rg_usn=$_POST['data'][17];
    $rg_em=$_POST['data'][18];
    $rg_pass=$_POST['data'][19];
    $rg_gender=$_POST['data'][20];
    $currency=$_POST['data'][21];
    $pp_api=$_POST['data'][22];
    $next=true;
    if(!is_writable('../../')){
        wrFail('/');
    }else{
        if(!file_exists('../../data')){
            mkdir('../../data',0755,true);
        }
        if(!file_exists('../../others/cached')){
            mkdir('../../others/cached',0755,true);
        }
        if(!is_writable('../../others/cached')||!is_writable('../../data')||!is_writable('../../others/system_setting.xml')||!is_writable('../../others/errors.log')){
            if(!is_writable('../../data')){
                wrFail('data');
            }
            if(!is_writable('../../others/cached')){
                wrFail('others/cached');
            }
            if(!is_writable('../../system_setting.xml')){
                wrFail('others/system_setting.xml');
            }
            if(!is_writable('../../others/errors.log')){
                wrFail('others/errors.log');
            }
        }else{
            $update=simplexml_load_file("../../others/system_setting.xml") or die("Failed to load others/system_setting.xml");
            $update->SysAuth=$key;
            $update->Title=$sitename;
            $update->MinPassLength=$min_pass_lg;
            $update->PassCap=$pass_cap;
            $update->ForceHTTPS=$foece_https;
            $update->DatabaseServer->Host=encryptString($db_host,$key);
            $update->DatabaseServer->Port=encryptString($db_port,$key);
            $update->DatabaseServer->Username=encryptString($db_usn,$key);
            $update->DatabaseServer->Password=encryptString($db_pass,$key);
            $update->DatabaseServer->DatabaseName=encryptString($db_name,$key);
            $update->MailServer->Host=$em_host;
            $update->MailServer->SMTPSecure=$em_secure;
            $update->MailServer->Port=$em_port;
            $update->MailServer->SMTPAuth=$em_auth;
            $update->MailServer->Username=encryptString($em_usn,$key);
            $update->MailServer->Password=encryptString($em_pass,$key);
            $update->Currency=$currency;
            $update->PayPalAPI=$pp_api;
            $cdb=mysqli_connect($db_host.':'.$db_port,$db_usn,$db_pass);
            if(!$cdb){
                $error_mg="Database connection failed: ".mysqli_connect_error();
                $next=false;
                errorLog($error_mg);
                echo $error_mg." ";
            }else{
                $sql="create database if not exists `$db_name`;";
                if(!mysqli_query($cdb,$sql)){
                    $error_mg=mysqli_error($cdb);
                    errorLog($error_mg);
                    echo $error_mg." ";
                }
            }
            mysqli_close($cdb);
            if($next){
                $er_count=0;
                $conn=mysqli_connect($db_host.':'.$db_port,$db_usn,$db_pass,$db_name);
                $query='';
                $sqlScript=file('../../others/setup.sql');
                foreach($sqlScript as $line){
                    $startWith=substr(trim($line),0,2);
                    $endWith=substr(trim($line),-1,1);
                    if(empty($line)||$startWith=='--'||$startWith=='/*'||$startWith=='//'){continue;}
                    $query=$query.$line;
                    if ($endWith==';'){
                        if(!mysqli_query($conn,$query)){
                            $error_mg='Fail to run SQL query: '.$query;
                            errorLog($error_mg);
                            $er_count++;
                        }$query='';
                    }
                }
                if($er_count>0){
                    $next=false;
                    echo 'Fail to create databade table. ';
                }
            }
            if($next){
                if(isset($_FILES['data'])&&!empty($_FILES['data'])){
                    if(($_FILES["data"]["error"][1]>0)||($_FILES["data"]["error"][0]>0)){
                        if($_FILES["data"]["error"][1]>0){
                            $next=false;
                            $error_mg="File error: ".$_FILES["data"]["error"][0];
                            errorLog($error_mg);
                            echo$error_mg;
                        }
                        if($_FILES["data"]["error"][0]>0){
                            $next=false;
                            $error_mg="File error: ".$_FILES["data"]["error"][1];
                            errorLog($error_mg);
                            echo$error_mg;
                        }
                    }else{
                        $typeLogo=pathinfo($_FILES["data"]["name"][0],PATHINFO_EXTENSION);
                        $typeToc=pathinfo($_FILES["data"]["name"][1],PATHINFO_EXTENSION);
                        if(!in_array($typeLogo,$imgArray)){
                            $next=false;
                            $mg="Logo only allow ";
                            foreach ($imgArray as $item){
                                $mg=$mg.' '.$item;
                            }
                            echo $mg;
                        }else if($_FILES["data"]['size'][0]>5242880){//5MB
                            $next=false;
                            echo 'Logo only less than 5MB allowed. ';
                        }else{
                            $logoPath='/data/logo.'.$typeLogo;
                            $update->LogoPath=$logoPath;
                            if(!compressImage($_FILES["data"]["tmp_name"][0],'../..'.$logoPath,$imgCompressLevel)){
                                $next=false;errorLog('Fail to upload logo.');
                            }
                        }
                        if(!in_array($typeToc,$txtDocArray)){
                            $next=false;
                            $mg="TnC only allow ";
                            foreach ($txtDocArray as $item){
                                $mg=$mg.' '.$item;
                            }
                            echo $mg;
                        }else if($_FILES["data"]['size'][1]>5242880){//5MB
                            $next=false;
                            echo 'TnC only less than 10MB allowed. ';
                        }else{
                            $tncPath='/data/tnc.'.$typeToc;
                            $update->TncPath=$tncPath;
                            if(!move_uploaded_file($_FILES["data"]["tmp_name"][1],'../..'.$tncPath)){
                                $next=false;errorLog('Fail to upload toc.');
                            }
                        }
                    }
                }else{
                    $next=false;
                    echo'Please upload Logo and TnC.';
                }
            }
            if($next){
                $sql="DELETE FROM `admin` WHERE Username='$rg_usn';";
                mysqli_query($conn,$sql);
                $sql="insert into `admin` (Username,Password,Email,FirstName,LastName,Gender,Type,Permission,LastLoginIp,LastLoginDateTime,CreateDateTime,Locked)Values('$rg_usn','".encryptString($rg_pass,$key)."','$rg_em','$rg_fn','$rg_ln','$rg_gender','s','*','".get_ip_address()."','".getDateTime()."','".getDateTime()."',false)";
                if(!mysqli_query($conn,$sql)){
                    $error_mg='Fail to create Super User: '.mysqli_error($conn);
                    errorLog($error_mg);
                    echo$error_mg." ";
                }else{
                    $lastID=mysqli_insert_id($conn);
                    $update->Setup='true';
                    if(!file_put_contents('../../others/system_setting.xml',$update->saveXML())){
                        $sql='rollback;';
                        mysqli_query($conn,$sql);
                        errorLog("others/system_setting.xml can't be write");
                        echo "System configuration can't be save.";
                    }
                    $_SESSION["aid"]=$lastID;
                    $_SESSION["type"]='s';
                }
            }
            mysqli_close($conn);
        }
    }
}
?>