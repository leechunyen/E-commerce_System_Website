<?php
if(!isset($_POST['rc'])||!isset($_POST['em'])||!isset($_POST['usn'])){
    echo'Process stopped.';
}else{
    require '../../php_framework/function.php';
    $em=$_POST['em'];
    $rc=$_POST['rc'];
    $usn=$_POST['usn'];
    $pass=true;
    $er=0;
    if(ifExist($conn,$maxCacheItem,'user','Username',$usn)){
        $pass=false;
        $er=$er+1;
    }
    if(ifExist($conn,$maxCacheItem,'user','Email',$em)){
        $pass=false;
        $er=$er+2;
    }
    if($pass){sendValidationCode($em,$rc,'user',null);}
    else{echo$er;}
}
?>