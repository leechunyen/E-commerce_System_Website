<?php
$ready=true;
for($x=0;$x<=11;$x++){
    if(!isset($_POST['data'][$x])){$ready=false;break;}
}
if(!$ready){
    echo 'Process stopped';
}else{
    require '../../php_framework/function.php';
    $lock=$_POST['data'][0];
    $act=$_POST['data'][1];
    $fn=$_POST['data'][2];
    $ln=$_POST['data'][3];
    $usn=$_POST['data'][4];
    $em=$_POST['data'][5];
    $psw=$_POST['data'][6];
    $dobd=$_POST['data'][7];
    $dobm=$_POST['data'][8];
    $doby=$_POST['data'][9];
    $ctry=$_POST['data'][10];
    $gd=$_POST['data'][11];
    if((strlen($psw)<(int)$xmldata->MinPassLength||strlen($psw)>80)||($gd!='f'&&$gd!='m')){
        echo 'Invalid data';
    }else{
        $encpsw=encryptString ($psw,$key);
        $phcol='';$phval='';$pth;$pass=true;
        if(ifExist($conn,$maxCacheItem,'user','Username',$usn)){
            $pass=false;
            echo 1;
        }
        if(ifExist($conn,$maxCacheItem,'user','Email',$em)){
            $pass=false;
            echo 2;
        }
        if($pass){
            if(isset($_FILES['data']['name'][0])){
                $pthtype=pathinfo($_FILES["data"]["name"][0],PATHINFO_EXTENSION);
                if(!in_array($pthtype,$imgArray)){
                    $pass=false;
                    $mg="Photo only allow";
                    foreach ($imgArray as $item){
                        $mg=$mg.' '.$item;
                    }
                    echo $mg;
                }else if($_FILES["data"]['size'][0]>5242880){//5MB
                    $pass=false;
                    echo 'Logo only less than 5MB allowed. ';
                }else{
                    if(!is_writable('../../data')){
                        wrFail('../../data');
                    }elseif(!file_exists('../../data/user')){
                        mkdir('../../data/user',0755,true);
                    }
                    if(!is_writable('../../data/user')){
                        wrFail('../../data/user');
                    }else{
                        $rs=string_generator();
                        $pth='/data/user/'.getDateTime('YmdHis').$rs.'.'.$pthtype;
                        while(true){
                            if(file_exists('../..'.$pth)){$rs=string_generator();}
                            else{break;}
                        }
                        $phcol=",`Photo`";
                        $phval=",'$pth'";
                        compressImage($_FILES['data']['tmp_name'][0],'../..'.$pth,$imgCompressLevel);
                    }
                }
            }
        }
        if($pass){
            $sql="insert into `user` (`Username`,`Password`,`Email`,`FirstName`,`LastName`,`Gender`,`DobYear`,`DobMonth`,`DobDay`,`CountryRegional`,`Activated`,`Deleted`,`Locked`,`CreateDateTime`$phcol) values ('$usn','$encpsw','$em','$fn','$ln','$gd',$doby,$dobm,$dobd,'$ctry',$act,false,$lock,'".getDateTime()."'$phval);";
            if(!mysqli_query($conn,$sql)){
                $mg='Fail to add user';
                echo$mg;
                deleteFile($pth);
                errorLog($mg.' '.mysqli_error($conn));
            }
            mysqli_close($conn);
        }
    }
}
?>