<?php
$ready=true;
for($i=0;$i<14;$i++){
    if(!isset($_POST['data'][$i])){
        $ready=false;
        break;
    }
}
if(!$ready){echo 'Process stopped';}
else{
    require '../../php_framework/function.php';
    $id=$_POST['data'][0];
    $title=$_POST['data'][1];
    $model=$_POST['data'][2];
    $stock=$_POST['data'][3];
    $reopt=$_POST['data'][4];
    $price=$_POST['data'][5];
    $atava=$_POST['data'][6];
    $atunava=$_POST['data'][7];
    $detil=$_POST['data'][8];
    $ava=$_POST['data'][9];
    $isatava=$_POST['data'][10];
    $isatunava=$_POST['data'][11];
    $isdfpth=$_POST['data'][12];
    $ismrpth=$_POST['data'][13];
    $pass=true;$er='';$dbatava='';$dbatunava='';$dbdfphoto='';$dfphotopth='';$profl='';
    if($isdfpth=='true'||$ismrpth=='true'){
        if(!is_writable('../../data')){
            wrFail('/data');
            $pass=false;
        }else{
            if(!file_exists('../../data/product')){
                mkdir('../../data/product',0755,true);
            }
            if(!is_writable('../../data/product')){
                wrFail('/data/product');
                $pass=false;
            }
            else{
                $dfopth=getData($conn,$maxCacheItem,'product','ID',$id)['DefaultPhoto'];
                $profl=substr($dfopth,0,strpos($dfopth,'df.'));
                if($isdfpth=='true'){//default photo
                    $pthtype=pathinfo($_FILES["data"]["name"][0],PATHINFO_EXTENSION);
                    if(!in_array($pthtype,$imgArray)){
                        $mg="Default Photo only allow";
                        foreach ($imgArray as $item){$mg=$mg.' '.$item;}
                        $er.=$mg.' ';$pass=false;
                    }else if($_FILES["data"]['size'][0]>5242880){//5MB
                        $er.='Default Photo only less than 5MB allowed. ';
                        $pass=false;
                    }else{
                        $dfphotopth=$profl."df".".".$pthtype;
                        deleteFile('../..'.$dfopth);
                        compressImage($_FILES['data']['tmp_name'][0],'../..'.$dfphotopth,$imgCompressLevel);
                    }
                }
            }
        }
    }
    if($pass){
        if($isatava=='true'){//auto available
            if($atava!=''&&$atava!=null){
                $dbatava=",`AutoAvailableDateTime`='".dataFormat($atava,'Y-m-d H:i:s')."'";
            }
        }else{$dbatava=",`AutoAvailableDateTime`=null";}
        if($isatunava=='true'){//auto unavailable
            if($atunava!=''&&$atunava!=null){
                $dbatunava=",`AutoUnavailableDateTime`='".dataFormat($atunava,'Y-m-d H:i:s')."'";
            }
        }else{$dbatunava=",`AutoUnavailableDateTime`=null";}
        $sql="update `product` set `Name`='$title',`Price`=$price,`Detail`='".base64_encode($detil)."',`ModelID`='$model',`Stock`=$stock,`Available`=$ava,`ReorderPoint`=$reopt$dbatava$dbatunava where `ID`=$id;";
        if(!mysqli_query($conn,$sql)){
            $mg='Fail to save change';
            $er.=$mg.' ';
            errorLog($mg.' '.mysqli_error($conn));
        }else{
            $cache->delete('db_recent_product');
            if($ismrpth=='true'){//more photo
                $stfr=0;
                $tf=count($_FILES["data"]['name']);
                if($isdfpth=='true'){$stfr=1;}
                $erimg=0;$dt=getDateTime('YmdHis');
                for($i=$stfr;$i<$tf;$i++){
                    $exp=pathinfo($_FILES["data"]["name"][0],PATHINFO_EXTENSION);
                    $ran=string_generator();
                    $phpth=$profl.$dt.$ran.'.'.$exp;
                    while(true){
                        if(file_exists('../..'.$phpth)){
                            $ran=string_generator();
                            continue;
                        }else{break;}
                    }
                    if(compressImage($_FILES['data']['tmp_name'][$i],'../..'.$phpth,$imgCompressLevel)){
                        $sql="insert into `product_photo` (`ProductID`,`Photo`) values ($id,'$phpth');";
                        if(!mysqli_query($conn,$sql)){
                            $mg='Fail to more photo ';
                            $erimg++;
                            deleteFile('../..'.$phpth);
                            errorLog($mg.' '.mysqli_error($conn));
                        }
                    }
                }
                if($erimg>0){$er.=$erimg.'img fail to upload ';}
            }
        }
    }
    echo$er;
}
?>