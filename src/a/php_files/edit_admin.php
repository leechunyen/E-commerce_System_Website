<?php
$ready=true;
for($x=0;$x<=7;$x++){
    if(!isset($_POST['data'][$x])){$ready=false;break;}
}
if(!$ready){
    echo 'Process stopped';
}else{
    require '../../php_framework/function.php';
    $type=$_POST['data'][0];
    $lock=$_POST['data'][1];
    $fn=$_POST['data'][2];
    $ln=$_POST['data'][3];
    $usn=$_POST['data'][4];
    $em=$_POST['data'][5];
    $gd=$_POST['data'][6];
    $id=$_POST['data'][7];
    if(($type!='a'&&$type!='s')||($gd!='f'&&$gd!='m')){
        echo 'Invalid data';
    }else{
        $phadd='';$pth;$pass=true;
        if(ifExist($conn,$maxCacheItem,'admin','Username',$usn,$id)){
            $pass=false;
            echo 1;
        }
        if(ifExist($conn,$maxCacheItem,'admin','Email',$em,$id)){
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
                    }elseif(!file_exists('../../data/admin')){
                        mkdir('../../data/admin',0755,true);
                    }
                    if(!is_writable('../../data/admin')){
                        wrFail('../../data/admin');
                    }else{
                        $rs=string_generator();
                        $pth='/data/admin/'.getDateTime('YmdHis').$rs.'.'.$pthtype;
                        while(true){
                            if(file_exists('../..'.$pth)){$rs=string_generator();}
                            else{break;}
                        }
                        $phadd=",`Photo`='$pth'";
                        compressImage($_FILES['data']['tmp_name'][0],'../..'.$pth,$imgCompressLevel);
                    }
                }
            }
        }
        if($pass){
            $oph=getValByEmUsn($conn,$maxCacheItem,'admin','ID',$id,'Photo');
            $sql="update `admin` set `Username`='$usn',`Email`='$em',`FirstName`='$fn',`LastName`='$ln',`Gender`='$gd',`Type`='$type',`Locked`=$lock$phadd where `ID`=$id;";
            if(!mysqli_query($conn, $sql)){
                $mg='Fail to add admin';
                echo$mg;
                deleteFile('../..'.$pth);
                errorLog($mg.' '.mysqli_error($conn));
            }else{
                $cache->delete('db_recent_admin');
                if($phadd!=''&&$oph!==''&&$oph!=null){deleteFile('../..'.$oph);}
            }
            mysqli_close($conn);
        }
    }
}
?>