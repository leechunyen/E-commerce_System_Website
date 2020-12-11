<?php
require '../../php_framework/function.php';
if(!isset($_FILES['data'])){
    echo 'Process stopped.';
}elseif($_FILES['data']['error']>0){
    echo 'Error';
    errorLog('File upload error: '.$_FILES['data']['error']);
}elseif(!is_writable('../../data')){
    wrFail('../../data');
}else{
    $typeLogo=pathinfo($_FILES["data"]["name"],PATHINFO_EXTENSION);
    if(!in_array($typeLogo,$imgArray)){
        $mg="Logo only allow";
        foreach ($imgArray as $item){
            $mg=$mg.' '.$item;
        }
        echo $mg;
    }else if($_FILES["data"]['size']>5242880){//5MB
        echo 'Logo only less than 5MB allowed. ';
    }else{
        deleteFile('../..'.$xmldata->LogoPath);
        $logoPath='/data/logo.'.$typeLogo;
        if(!compressImage($_FILES["data"]["tmp_name"],'../..'.$logoPath,$imgCompressLevel)){
            errorLog('Fail to upload or compress logo.');
            echo 'Logo fail to upload.';
        }else{
            $xmldata->LogoPath=$logoPath;
            if(!file_put_contents('../../others/system_setting.xml',$xmldata->saveXML())){
                echo 'Fail to save system setting';
            }else{
                $logo=getFile($logoPath);
            }
        }
    }
}
?>