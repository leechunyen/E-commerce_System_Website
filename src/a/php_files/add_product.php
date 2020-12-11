<?php
require '../../php_framework/function.php';
$ready=true;
for($x=0;$x<9;$x++){
    if(!isset($_POST['data'][$x])){
        $ready=false;
        break;
    }
}
if(!$ready&& !isset($_FILES['data'][0])){
    echo 'Process stopped';
}else{
    $dfphoto=$_FILES['data'][0];
    $name=$_POST['data'][0];
    $model=$_POST['data'][1];
    $price=$_POST['data'][2];
    $stock=$_POST['data'][3];
    $orpoi=$_POST['data'][4];
    $avail=$_POST['data'][5];
    $dtautoava=$_POST['data'][6];
    $dtautounava=$_POST['data'][7];
    $detail=$_POST['data'][8];
    $tf=count($_FILES["data"]['name']);
    $pass=true;
    for($x=0;$x<$tf;$x++){
        if($_FILES["data"]['size'][$x]>5242880){//5MB
            $pass=false;
            echo 'Logo only less than 5MB allowed. ';
            break;
        }
    }
    if($pass){
        if(!is_writable('../../data')){
            wrFail('/data');
        }else{
            if(!file_exists('../../data/product')){
                mkdir('../../data/product',0755,true);
            }
            if(!is_writable('../../data/product')){
                wrFail('/data/product');
            }else{
                $dt=getDateTime('YmdHis');
                $rand=string_generator();
                $propth="/data/product/".$dt.$rand;
                while(true){
                    if(file_exists('../..'.$propth)){
                        $rand=string_generator();
                        continue;
                    }else{break;}
                }
                mkdir('../..'.$propth,0755,true);
                if(!is_writable('../..'.$propth)){
                    wrFail($propth);
                }else{
                    $pthtype=pathinfo($_FILES["data"]["name"][0],PATHINFO_EXTENSION);
                    $dfphotopth=$propth."/df".".".$pthtype;
                    compressImage($_FILES['data']['tmp_name'][0],'../..'.$dfphotopth,$imgCompressLevel);
                    $atavdt='null';$atunavdt='null';
                    if($dtautoava!=''||$dtautoava!=null){$atavdt="'".date_format(stringToDate($dtautoava),'Y-m-d H:i:s')."'";}
                    if($dtautounava!=''||$dtautounava!=null){$atunavdt="'".date_format(stringToDate($dtautounava),'Y-m-d H:i:s')."'";}
                    $endet=base64_encode($detail);
                    $sql="insert into `product` (`Name`,`DefaultPhoto`,`Price`,`Detail`,`ModelID`,`Stock`,`Available`,`AutoAvailableDateTime`,`AutoUnavailableDateTime`,`ReorderPoint`) values ('$name','$dfphotopth',$price,'$endet','$model',$stock,$avail,$atavdt,$atunavdt,$orpoi);";
                    if(!mysqli_query($conn,$sql)){
                        $mg='Fail to add product';
                        echo$mg;
                        deleteFile('../..'.$propth);
                        errorLog($mg.' '.mysqli_error($conn));
                    }else{
                        $lastID=mysqli_insert_id($conn);
                        if($tf>=2){$er=0;$dt=getDateTime('YmdHis');
                            for($i=1;$i<$tf;$i++){
                                $exp=pathinfo($_FILES["data"]["name"][0],PATHINFO_EXTENSION);
                                $ran=string_generator();
                                $phpth=$propth.'/'.$dt.$ran.'.'.$exp;
                                while(true){
                                    if(file_exists('../..'.$phpth)){
                                        $ran=string_generator();
                                        continue;
                                    }else{break;}
                                }
                                compressImage($_FILES['data']['tmp_name'][$i],'../..'.$phpth,$imgCompressLevel);
                                $sql="insert into `product_photo` (`ProductID`,`Photo`) values ($lastID,'$phpth');";
                                if(!mysqli_query($conn,$sql)){
                                    $mg='Fail to more photo ';
                                    echo$mg;$er++;
                                    deleteFile('../..'.$phpth);
                                    errorLog($mg.' '.mysqli_error($conn));
                                }
                                mysqli_close($conn);
                            }
                        }
                    }
                }
            }
        }
    }
    if($er>0){echo "$er photo fail to upload.";}
}
?>