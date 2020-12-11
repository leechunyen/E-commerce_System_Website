<?php
if(!isset($_POST['m'])||!isset($_POST['f'])||!isset($_POST['v1'])||!isset($_POST['v2'])||!isset($_POST['v3'])){echo'Process stopped.';}
else{
    require '../../php_framework/function.php';
    $m=$_POST['m'];
    $f=$_POST['f'];
    $v1=$_POST['v1'];
    $v2=$_POST['v2'];
    $v3=$_POST['v3'];
    $tb;$col;$id;$pass=true;
    if($f=='a'){$tb='admin';$id=$_SESSION['aid'];}elseif($f=='u'){$tb='user';$id=$_SESSION['uid'];}
    if($m=='usn'){$col='Username';}
    elseif($m=='em'){$col='Email';}
    elseif($m=='name'){$col='name';}
    elseif($m=='gd'){$col='Gender';}
    elseif($m=='cty'){$col='CountryRegional';}
    elseif($m=='dob'){$col='dob';}
    if($m=='usn'&&ifExist($conn,$maxCacheItem,$tb,$col,$v1,$id)){
        $pass=false;
        echo "Username: '.$v1.' is already exist.";
    }
    elseif($m=='em'){
        $pass=false;
        if(ifExist($conn,$maxCacheItem,$tb,$col,$v1,$id)){
            echo "Email: '.$v1.' is already exist.";
        }else{sendValidationCode($v1,$v2,$tb);echo 1;}
    }
    if($pass){
        $set="`$col`='$v1'";
        if($m=='name'){$set="`FirstName`='$v1',`LastName`='$v2'";}
        elseif($m=='dob'){$set="`DobDay`=$v1,`DobMonth`=$v2,`DobYear`=$v3";}
        $sql="update `$tb` set $set where `ID`=$id;";
        if(!mysqli_query($conn,$sql)){
            $mg='Fail to save profile setting';
            echo$mg;
            errorLog($mg." $tb ".mysqli_error($conn));
        }else{$cache->delete('db_recent_'.$tb);}
        mysqli_close($conn);
    }
}
?>