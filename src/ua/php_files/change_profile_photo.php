<?php

if(!isset($_POST['data'][0])||!isset($_FILES['data']['name'][0])){
    echo 'Process stopped';
}else{
    require '../../php_framework/function.php';
    $f=$_POST['data'][0];
    if($f!='a'&&$f!='u'){
        echo 'Invalid data';
    }else{
        $pth;$tb;$id;
        if($f=='a'){
            $tb='admin';
            $id=$_SESSION['aid'];
        }elseif($f=='u'){
            $tb='user';
            $id=$_SESSION['uid'];
        }
        $pthtype=pathinfo($_FILES["data"]["name"][0],PATHINFO_EXTENSION);
        if(!in_array($pthtype,$imgArray)){
            $mg="Photo only allow";
            foreach ($imgArray as $item){
                $mg=$mg.' '.$item;
            }
            echo $mg;
        }else if($_FILES["data"]['size'][0]>5242880){//5MB
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
                if(compressImage($_FILES['data']['tmp_name'][0],'../..'.$pth,$imgCompressLevel)){
                    $oph=getValByEmUsn($conn,$maxCacheItem,$tb,'ID',$id,'Photo');
                    $sql="update `$tb` set `Photo`='$pth' where `ID`=$id;";
                    if(!mysqli_query($conn,$sql)){
                        deleteFile('../..'.$pth);
                        $mg='Fail to change photo';
                        echo$mg;
                        errorLog($mg.' '.mysqli_error($conn));
                    }else{
                        $cache->delete('db_recent_'.$tb);
                        if($phadd!=''&&$oph!==''&&$oph!=null){deleteFile('../..'.$oph);}
                    }
                    mysqli_close($conn);
                }
            }
        }
            
        
    }
}
?>