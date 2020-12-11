<?php
if(!isset($_POST['id'])||!isset($_POST['pth'])){
    echo 'Process stopped';
}else{
    require '../../php_framework/function.php';
    $id=$_POST['id'];
    $pth=$_POST['pth'];
    $sql="delete from `product_photo` where `ProductID`=$id and `Photo`='$pth';";
    if(!mysqli_query($conn,$sql)){
        $mg="Fail to delete more product photo";
        errorLog($mg.' '.mysqli_error($conn));
        echo $mg;
    }else{deleteFile('../..'.$pth);}
    mysqli_close($conn);
}
?>