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
    $typeToc=pathinfo($_FILES["data"]["name"],PATHINFO_EXTENSION);
    if(!in_array($typeToc,$txtDocArray)){
        $mg="Tnc only allow";
        foreach ($txtDocArray as $item){
            $mg=$mg.' '.$item;
        }
        echo $mg;
    }else if($_FILES["data"]['size']>5242880){//5MB
        echo 'Tnc only less than 5MB allowed. ';
    }else{
        deleteFile('../..'.$xmldata->TncPath);
        $Path='/data/tnc.'.$typeToc;
        if(!move_uploaded_file($_FILES["data"]["tmp_name"],'../..'.$Path)){
            errorLog('Fail to upload toc.');
            echo 'Tnc fail to upload.';
        }else{
            $xmldata->TncPath=$Path;
            if(!file_put_contents('../../others/system_setting.xml',$xmldata->saveXML())){
                echo 'Fail to save system setting';
            }
        }
    }
}
?>